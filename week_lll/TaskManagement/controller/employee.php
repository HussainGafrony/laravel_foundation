<?php
// include 'function.php';
include 'db.php';
function getManagers()
{
    global $conn;
    $sql = "SELECT users.*,managers.*
    FROM users
    INNER JOIN managers ON users.id = managers.user_id";

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
    $managers = [];
    while ($row = $result->fetch_assoc()) {
        $managers[] = $row;
    }

    $stmt->close();

    return  $managers ?: false;
}
function getEmployees()
{
    global $conn;

    $sql = "SELECT users.*, employees.*, manager_users.id AS manager_user_id,
    manager_users.name AS manager_name
    FROM users
    INNER JOIN employees ON users.id = employees.user_id
    INNER JOIN managers ON managers.id = employees.manager_id
    INNER JOIN users AS manager_users ON managers.user_id = manager_users.id";

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
    $employees = [];
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    $stmt->close();

    return  $employees ?: false;
}


function getEmployee($user_id)
{
    global $conn;

    if (!empty($user_id)) {
        $sql = "SELECT users.*, employees.*
        FROM users
        INNER JOIN employees ON users.id = employees.user_id
        WHERE users.id = ?";

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
        $stmt->close();
        return $employee;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}
function createEmployee()
{
    global $conn;
    $name = validateInput('name');
    $phone_number = validateInput('phone_number');
    $birthdate = validateInput('birthdate');
    $email = validateInput('email');
    $password = validateInput('password');
    $is_active = validateInput('is_active');
    $manager_id = validateInput('manager_id');

    $sql = "INSERT INTO users (name, email, password, is_active)
    VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password, $is_active);

    if ($stmt->execute()) {

        $user_id = $stmt->insert_id;
        $sql = "INSERT INTO employees (user_id, manager_id, phone_number, birthdate) VALUES (?, ?, ?, ?)";
        // $sql = "INSERT INTO employees (user_id, phone_number, birthdate) VALUES (?, ?, ?)";
        $stmt_employee = $conn->prepare($sql);
        $stmt_employee->bind_param("iiss", $user_id, $manager_id, $phone_number, $birthdate);

        if ($stmt_employee->execute()) {
            echo "<script>
            window.location.href = '?p=employee';
            </script>";
            returnResponse('New Employee created successfully');
        } else {
            returnResponse('Error: ' . $stmt_employee->error);
        }
        $stmt_employee->close();
    } else {
        returnResponse('Error: ' . $stmt->error);
    }

    $stmt->close();
}


function editEmployee()
{
    global $conn;
    $user_id = validateInput('user_id');
    $name = validateInput('name');
    $phone_number = validateInput('phone_number');
    $birthdate = validateInput('birthdate');
    $email = validateInput('email');
    $password = validateInput('password');
    $is_active = validateInput('is_active');
    $manager_id = validateInput('manager_id');

    $sql = "UPDATE users SET name = ?, email = ?, password = ?, is_active = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $name, $email, $password, $is_active, $user_id);

    if ($stmt->execute()) {

        $sql_employee = "UPDATE employees SET phone_number = ?, birthdate = ?, manager_id = ? WHERE user_id = ?";
        $stmt_employee = $conn->prepare($sql_employee);
        $stmt_employee->bind_param("ssii", $phone_number, $birthdate, $manager_id, $user_id);

        if ($stmt_employee->execute()) {
            echo "<script>
                window.location.href = window.location.href = '?p=employee';
                </script>";
            returnResponse('Edites Employee  successfully');
        } else {
            returnResponse('Error' . $stmt_employee->error);
        }
    } else {
        returnResponse('Error' . $stmt->error);
    }

    $stmt->close();
    $stmt_employee->close();
}




function deleteEmployee()
{
    global $conn;

    $user_id = validateInput('user_id');

    if (!empty($user_id)) {
        $sql_user = "DELETE FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("i", $user_id);

        if ($stmt_user->execute()) {
            echo "<script>
            window.location.href = window.location.href = '?p=employee';
            </script>";
            returnResponse('User deleted successfully!');
        } else {
            returnResponse("Error: Unable to delete user. " . $stmt_user->error);
        }
        $stmt_user->close();
    } else {
        returnResponse("Error: User ID not provided.");
    }
}
