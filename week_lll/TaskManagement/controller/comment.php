<?php
include 'db.php';
function getComment($task_id)
{
    global $conn;

    if (!empty($task_id)) {

        // $sql = "SELECT * FROM comments WHERE task_id = ?";
        $sql = "SELECT comments.*,users.*,comments.id
        FROM comments
        INNER JOIN users ON users.id = comments.user_id
        WHERE comments.task_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            returnResponse("Failed to get result: " . $stmt->error);
            $stmt->close();
            return false;
        }
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        $stmt->close();
        return $comments;
    } else {
        returnResponse("Error: Task ID not provided.");
        return false;
    }
}

function createComment()
{
    global $conn;
    $user_id = validateInput('user_id');
    $task_id = validateInput('task_id');
    $comment = validateInput('comment');

    if (!empty($task_id) && !empty($user_id)) {
        $sql = "INSERT INTO comments (task_id, user_id, comment)
            VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $task_id, $user_id, $comment);
        if ($stmt->execute()) {
            returnResponse('New Comment created successfully');
        } else {
            returnResponse('Error' . $stmt->error);
            return false;
        }
        $stmt->close();
    } else {
        returnResponse('Task ID and User ID are required.');
    }
}

function deleteComment()
{
    global $conn;
    $comment_id = validateInput('comment_id');

    if (!empty($comment_id)) {
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);

        if ($stmt->execute()) {
            returnResponse('Comment deleted successfully!');
        } else {
            returnResponse("Error: Unable to Comment. " . $stmt->error);
        }
        $stmt->close();
    } else {
        returnResponse("Error: Comment ID not provided.");
        return false;
    }
}
