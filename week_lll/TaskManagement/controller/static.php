<?php
include 'db.php';
// Admin role
function getTasks($status)
{
    global $conn;
    $sql = "SELECT COUNT(*) AS task_count  FROM tasks WHERE status = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $tasks = $result->fetch_assoc();
    $stmt->close();

    return $tasks;
}

function getManagers($status)
{
    global $conn;
    $sql = "SELECT COUNT(*) AS manager_count
    FROM users
    JOIN user_role ON users.id = user_role.user_id
    JOIN roless ON user_role.role_id = roless.id
    WHERE roless.name = 'manager' AND users.is_active = ?";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $managers = $result->fetch_assoc();
    $stmt->close();

    return $managers;
}


function getEmployees($status)
{
    global $conn;

    $sql = "SELECT COUNT(*) AS employee_count
    FROM users
    JOIN user_role ON users.id = user_role.user_id
    JOIN roless ON user_role.role_id = roless.id
    WHERE roless.name = 'empolyee' AND users.is_active = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }
    $employees = $result->fetch_assoc();
    $stmt->close();

    return $employees;
}


// Manager role

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
function getTaskCountByManagerAndStatus($user_id, $status)
{
    global $conn;
    $manger_id = getManager($user_id);
    if (!$manger_id) {
        returnResponse("Error: Manager ID not found for user ID: $user_id.");
        return false;
    }

    $sql = "SELECT COUNT(*) AS task_count FROM tasks WHERE manager_id = ? AND status = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $manger_id['id'], $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $tasks = $result->fetch_assoc();
    $stmt->close();

    return $tasks;
}



function EmployeesByManager($status, $user_id)
{
    global $conn;
    $manager_id = getManager($user_id);
    if (!$manager_id) {
        returnResponse("Error: Manager ID not found for user ID: $user_id.");
        return false;
    }

    $sql = "SELECT COUNT(*) AS employee_count
        FROM users
        JOIN user_role ON users.id = user_role.user_id
        JOIN roless ON user_role.role_id = roless.id
        JOIN employees ON employees.user_id = users.id
        WHERE roless.name = 'empolyee' AND users.is_active = ? AND employees.manager_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $manager_id['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }
    $employees = $result->fetch_assoc();
    $stmt->close();

    return $employees;
}


// Employyee Role
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


function getTaskCountByEmployeeAndStatus($user_id, $status)
{
    global $conn;

    $employee = getEmployee($user_id);
    if (!$employee) {
        returnResponse("Error: Employee not found for user ID: $user_id.");
        return false;
    }

    $sql = "SELECT COUNT(*) AS task_count FROM tasks WHERE employee_id = ? AND status = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $employee['id'], $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $tasks = $result->fetch_assoc();
    $stmt->close();

    return $tasks;
}
