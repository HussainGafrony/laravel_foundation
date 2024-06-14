<?php
include 'db.php';
function editUser()
{
    global $conn;
    $id = validateInput('id');
    $name = validateInput('name');
    $email = validateInput('email');
    $password = validateInput('password');
    $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password, $id);
    if ($stmt->execute()) {
        returnResponse("User information updated successfully.");
    } else {
        returnResponse("Error updating user information: " . $stmt->error);
    }
    $stmt->close();
}

function getUser($user_id)
{
    global $conn;

    if (!empty($user_id)) {
        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            returnResponse("Failed to get result: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    } else {
        returnResponse("Error: User ID not provided.");
        return false;
    }
}
