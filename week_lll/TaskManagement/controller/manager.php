<?php
include 'function.php';
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


function getManager($user_id)
{
    global $conn;

    if (!empty($user_id)) {
        $sql = "SELECT users.*, managers.*
        FROM users
        INNER JOIN managers ON users.id = managers.user_id
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

        $manager = $result->fetch_assoc();
        $stmt->close();
        return $manager;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}
function createManager()
{
    global $conn;
    $name = validateInput('name');
    $phone_number = validateInput('phone_number');
    $birthdate = validateInput('birthdate');
    $email = validateInput('email');
    $password = validateInput('password');
    $is_active = validateInput('is_active');

    $sql = "INSERT INTO users (name, email, password, is_active)
    VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password, $is_active);

    if ($stmt->execute()) {

        $user_id = $stmt->insert_id;
        $sql_manager = "INSERT INTO managers (user_id, phone_number ,birthdate ) VALUES (?, ?, ?)";
        $stmt_manager = $conn->prepare($sql_manager);
        $stmt_manager->bind_param("iss", $user_id, $phone_number, $birthdate);

        if ($stmt_manager->execute()) {
            echo "<script>
            window.location.href = window.location.href = '?p=manager';
            </script>";
            returnResponse('New manager created successfully');
        } else {
            returnResponse('Error' . $stmt_manager->error);
        }
    } else {
        returnResponse('Error' . $stmt->error);
    }

    $stmt->close();
    $stmt_manager->close();
}

function editManager()
{
    global $conn;
    $user_id = validateInput('user_id');
    $name = validateInput('name');
    $phone_number = validateInput('phone_number');
    $birthdate = validateInput('birthdate');
    $email = validateInput('email');
    $password = validateInput('password');
    $is_active = validateInput('is_active');

    $sql = "UPDATE users SET name = ?, email = ?, password = ?, is_active = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $name, $email, $password, $is_active, $user_id);

    if ($stmt->execute()) {

        $sql_manager = "UPDATE managers SET phone_number = ?, birthdate = ? WHERE user_id = ?";
        $stmt_manager = $conn->prepare($sql_manager);
        $stmt_manager->bind_param("ssi", $phone_number, $birthdate, $user_id);

        if ($stmt_manager->execute()) {
            echo "<script>
            window.location.href = window.location.href = '?p=manager';
            </script>";
            returnResponse('New manager created successfully');
        } else {
            returnResponse('Error' . $stmt_manager->error);
        }
    } else {
        returnResponse('Error' . $stmt->error);
    }

    $stmt->close();
    $stmt_manager->close();
}


function deleteManager()
{
    global $conn;

    $user_id = validateInput('user_id');

    if (!empty($user_id)) {
        $sql_user = "DELETE FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("i", $user_id);

        if ($stmt_user->execute()) {
            echo "<script>
            window.location.href = window.location.href = '?p=manager';
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




// function returnResponse($message, $success = true) {
//     echo "<div class='" . ($success ? "alert alert-success" : "alert alert-danger") . "'>$message</div>";
// }
