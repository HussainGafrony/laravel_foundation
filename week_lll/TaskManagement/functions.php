<?php
include './DB/db.php';
function checkLogin($email, $password)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        returnResponse("Invalid email format");
        return false;
    }
    global $conn;

    $sql = "SELECT users.id,users.email,users.password,users.status,profiles.name,
        profiles.phone_number,roles.role_desc
        FROM users
        INNER JOIN profiles ON users.id = profiles.user_id 
        INNER JOIN user_role ON users.id = user_role.user_id  
        INNER JOIN roles ON user_role.role_id = roles.id 
        WHERE users.email = ? AND users.password = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        returnResponse("Failed to prepare statement: " . $conn->error);
        return false;
    }
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result === false) {
        returnResponse("Failed to get result: " . $stmt->error);
        $stmt->close();
        return false;
    }
    $user_data = $result->fetch_assoc();

    $stmt->close();

    return  $user_data ?: false;
}


function checkUserStatus($user_data)
{
    switch ($user_data['status']) {
        case 'disabled':
            returnResponse('Account is  disabled');
            break;
        case 'suspended':
            returnResponse('Account is  suspended');
            break;
        case 'deleted':
            returnResponse('Account is  deleted');
            break;

        default:
            returnResponse('Account is has problem in status');

            break;
    }
}

// function getUserPermissions($role_id)
// {
//     global $conn;

//     $sql = "SELECT role_desc FROM roles WHERE id = ?";
//     $stmt = $conn->prepare($sql);
//     if ($stmt === false) {
//         returnResponse("Failed to prepare statement: " . $conn->error);
//         return false;
//     }
//     $stmt->bind_param("i", $role_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $role_data = $result->fetch_assoc();
//     $stmt->close();

//     return $role_data ?: false;
// }

function getUserData($user_id, $conn)
{
    if (!empty($user_id)) {
        $sql = "SELECT users.id,users.email,users.password,users.status,profiles.name,
         profiles.phone_number,roles.role_desc
         FROM users
         INNER JOIN profiles ON users.id = profiles.user_id 
         INNER JOIN user_role ON users.id = user_role.user_id  
         INNER JOIN roles ON user_role.role_id = roles.id 
         WHERE users.id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            returnResponse('SQL prepare error: ' . $conn->error, false);
            return false;
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $stmt->close();
            return $user_data;
        } else {
            $stmt->close();
            returnResponse('User not found', false);
            return false;
        }
    } else {
        returnResponse('Invalid user ID.', false);
        return false;
    }
}


function updateUser()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task_management";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        returnResponse("Connection failed: " . $conn->connect_error, false);
    } else {
        returnResponse("Database connection established successfully", false);
    }
    if ($conn === null) {
        returnResponse("Database connection is not established", false);
        return;
    }
    $user_id = validateInput('id');
    $name = validateInput('name');
    $email = validateInput('email');
    $phone_number = validateInput('phone_number');
    $password = validateInput('password');

    $sql_user = "UPDATE users SET email = '$email', password = '$password' WHERE id = $user_id";
    $sql_profile = "UPDATE profiles SET name = '$name', phone_number = '$phone_number' WHERE user_id = $user_id";

    if (updateDatabaseRecord($sql_user, $conn)) {
        updateDatabaseRecord($sql_profile, $conn);
        $user_data = getUserData($_SESSION['user']['id'], $conn);
        if ($user_data) {
            $_SESSION['user'] = $user_data;
            echo "<script>
            window.location.href = window.location.href = '?p=profile';
            </script>";
            returnResponse('User updated successfully!', false);
        } else {
            returnResponse('Error  Get User', false);
        }
    } else {
        returnResponse("Error updating : " . $conn->error, false);
    }
    $conn->close();
    return true;
}

function getUsers($conn)
{

    $users = array();
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "email" => $row["email"],
                "age" => $row["age"]
            );
        }
    }
    $conn->close();
    return $users ?: false;
}


function validateInput($key, $default = '')
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

function updateDatabaseRecord($sql, $conn)
{
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function userData()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function logout()
{
    session_unset();
    session_destroy();
    // header("Location: views/login.php");
}


function returnResponse($msg, $nextTo = true)
{
    $_SESSION['msg'] = $msg;
    if ($nextTo) {
        header('Location: views/login.php');
        exit();
    }
    // logout();
}
