<?php
include '../function.php';
include '../db.php';

function Login()
{
    global $conn;
    $email = validateInput('email');
    $password = validateInput('password');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        returnResponse("Invalid email format");
        return false;
    }

    if (!$conn) {
        returnResponse("Database connection failed: " . $conn->connect_error);
        return false;
    }


    $sql = "SELECT users.*, roless.name AS role_name
    FROM users
    INNER JOIN user_role ON users.id = user_role.user_id 
    INNER JOIN roless ON user_role.role_id = roless.id 
    WHERE users.email = ? AND users.password = ?";

    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            returnResponse("Failed to get result: " . $stmt->error);
            $stmt->close();
            return false;
        }
        $user_data = $result->fetch_assoc();
        if ($user_data > 0) {
            // print_r($user_data['is_active']);
            if ($user_data['is_active'] !== 1) {
                checkUserStatus($user_data['is_active']);
                return false;
            }
            $_SESSION['user'] = $user_data;
        } else {
            returnResponse('Invalid username or password');
        }
        $stmt->close();
        return $user_data;
    } else {
        returnResponse("Prepare failed: " . $conn->error);
        return false;
    }
}
