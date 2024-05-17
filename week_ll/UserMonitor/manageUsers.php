<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manage_user";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function deleteUser()
{
    global $conn;

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $userId = $_POST['id'];
        $sql = "DELETE FROM users WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $userId);

            if ($stmt->execute()) {
                header('Location: ./index.php?msg=User deleted successfully');
            } else {
                echo "Error: Unable to delete user.";
            }

            $stmt->close();
        } else {
            echo "Error: Unable to prepare statement.";
        }
    } else {
        echo "Error: User ID not provided.";
    }
}


function getUserData()
{
    global $conn;
    $user_id = isset($_POST['id']) ? $_POST['id'] : 0;
    if ($user_id) {
        // Fetch user data
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Return user data
            return $result->fetch_assoc();
        } else {
            return "User not found.";
        }
    } else {
        return "Invalid user ID.";
    }
}
function updateUser()
{
    global $conn;
    $user_id = isset($_POST['id']) ? $_POST['id'] : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($user_id || $name || $email || $age || $password) {
        // Update user data
        $sql = "UPDATE users SET name='$name', email='$email', age='$age', password='$password' WHERE id=$user_id";

        if ($conn->query($sql) === TRUE) {
            header('Location: ./index.php?msg=Record updated successfully');
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid input.";
    }
}

function createUser()
{
    global $conn;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($name && $email && $age && $password) {

        $sql = "INSERT INTO users (name, email, age, password) VALUES ('$name', '$email', '$age', '$password')";
        if ($conn->query($sql) === TRUE) {
            header('Location: ./index.php?msg=User created successfully');
        } else {
            echo "Error creating user: " . $conn->error;
        }
    } else {
        echo "Invalid input.";
    }
}
