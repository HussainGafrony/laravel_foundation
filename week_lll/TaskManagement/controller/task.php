<?php
include 'db.php';
function getTasks()
{
    global $conn;
    $sql = "SELECT tasks.*, 
    user_employees.name AS employee_name,
    user_managers.name AS manager_name
    FROM tasks
    INNER JOIN employees ON employees.id = tasks.employee_id
    INNER JOIN users AS user_employees ON user_employees.id = employees.user_id
    INNER JOIN managers ON managers.id = tasks.manager_id
    INNER JOIN users AS user_managers ON user_managers.id = managers.user_id";


    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        returnResponse("Failed to prepare statement: " . $conn->error);
        return false;
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    $stmt->close();

    return  $tasks ?: false;
}

function getManager($user_id)
{
    global $conn;

    if (!empty($user_id)) {
        $sql = "SELECT id FROM managers WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            returnResponse("Failed to get result: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $manager = $result->fetch_assoc();
        // $stmt->close();
        return $manager;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}

function getTasksByManager($user_id)
{
    global $conn;
    if (!empty($user_id)) {
        $manger_id = getManager($user_id);
        if (!$manger_id) {
            returnResponse("Error: Manager ID not found for user ID: $user_id.");
            return false;
        }
        $sql = "SELECT tasks.*, 
    user_employees.name AS employee_name,
    user_managers.name AS manager_name
    FROM tasks
    INNER JOIN employees ON employees.id = tasks.employee_id
    INNER JOIN users AS user_employees ON user_employees.id = employees.user_id
    INNER JOIN managers ON managers.id = tasks.manager_id
    INNER JOIN users AS user_managers ON user_managers.id = managers.user_id
     WHERE tasks.manager_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $manger_id['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt === false) {
            returnResponse("Failed to prepare statement: " . $conn->error);
            return false;
        }
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        $stmt->close();
        return  $tasks ?: false;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}

function getEmployeesByManagerTask($manger_id)
{
    global $conn;

    if (!empty($manger_id)) {

        $sql = "SELECT employees.*, users.name AS employee_name, users.email AS employee_email
                FROM employees
                INNER JOIN users ON users.id = employees.user_id
                WHERE employees.manager_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $manger_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt === false) {
            returnResponse("Failed to prepare statement: " . $conn->error);
            return false;
        }

        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        $stmt->close();
        return $employees ?: false;
    } else {
        returnResponse("Error: Manager ID not provided.");
        return false;
    }
}


function getTask($task_id)
{
    global $conn;

    if (!empty($task_id)) {
        $sql = "SELECT tasks.*, 
        user_employees.name AS employee_name,
        user_managers.name AS manager_name
        FROM tasks
        LEFT JOIN employees ON employees.id = tasks.employee_id
        LEFT JOIN users AS user_employees ON user_employees.id = employees.user_id
        INNER JOIN managers ON managers.id = tasks.manager_id
        INNER JOIN users AS user_managers ON user_managers.id = managers.user_id
        WHERE tasks.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            returnResponse("Failed to get result: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $manager = $result->fetch_assoc();
        $stmt->close();
        return $manager;
    } else {
        returnResponse("Error: Task ID not provided.");
        return false;
    }
}

function editTask()
{
    global $conn;
    $task_id  = validateInput('task_id');
    $manager_id  = validateInput('manager_id');
    $employee_id = validateInput('employee_id');
    $title = validateInput('title');
    $description = validateInput('description');
    $status = validateInput('status');
    $rejected_reason = validateInput('rejected_reason');


    $sql = "UPDATE tasks SET manager_id = ?, employee_id = ?, title = ?,
     description = ?, status = ?, rejected_reason = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissisi", $manager_id, $employee_id, $title, $description, $status, $rejected_reason, $task_id);

    if ($stmt->execute()) {
        // echo "<script>
        //     window.location.href = window.location.href = '?p=task';
        //     </script>";
        returnResponse('New Task Updated successfully');
    } else {
        returnResponse('Error' . $stmt->error);
    }

    $stmt->close();
}

function createTask()
{
    global $conn;
    $manager_id  = validateInput('manager_id');
    $employee_id = isset($_POST['employee_id']) && $_POST['employee_id'] !== '' ? $_POST['employee_id'] : NULL;
    $title = validateInput('title');
    $description = validateInput('description');
    $status = validateInput('status');
    $rejected_reason = validateInput('rejected_reason');


    if ($employee_id === NULL) {
        // Prepare SQL query without employee_id
        $sql = "INSERT INTO tasks (manager_id, employee_id, title, description, status, rejected_reason) VALUES (?, NULL, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $manager_id, $title, $description, $status, $rejected_reason);
    } else {
        // Prepare SQL query with employee_id
        $sql = "INSERT INTO tasks (manager_id, employee_id, title, description, status, rejected_reason) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissss", $manager_id, $employee_id, $title, $description, $status, $rejected_reason);
    }

    if ($stmt->execute()) {
        returnResponse('New Task Created successfully');
    } else {
        returnResponse('Error' . $stmt->error);
    }

    $stmt->close();
}

function deleteTask()
{
    global $conn;
    $task_id = validateInput('task_id');

    if (!empty($task_id)) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $task_id);

        if ($stmt->execute()) {
            returnResponse('Task deleted successfully!');
        } else {
            returnResponse("Error: Unable to Task. " . $stmt->error);
        }
        $stmt->close();
    } else {
        returnResponse("Error: Task ID not provided.");
        return false;
    }
}



function getEmployee($user_id)
{
    global $conn;
    if (!empty($user_id)) {
        $sql = "SELECT id FROM employees WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            returnResponse("Failed to get result: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $employee = $result->fetch_assoc();
        // $stmt->close();
        return $employee;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}


function getTasksByEmployee($user_id)
{
    global $conn;
    if (!empty($user_id)) {
        $employee = getEmployee($user_id);
        if (!$employee) {
            returnResponse("Error: Manager ID not found for user ID: $user_id.");
            return false;
        }
        $sql = "SELECT * FROM tasks WHERE tasks.employee_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $employee['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt === false) {
            returnResponse("Failed to prepare statement: " . $conn->error);
            return false;
        }
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        $stmt->close();
        return  $tasks ?: false;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}
