<?php
function validateInput($key, $default = '')
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}
function checkUserStatus($user_data)
{
    // 1_ Active
    // 2_ Disabled
    // 3_Suspended
    // 4_deleted
    switch ($user_data) {
        case '2':
            returnResponse('Account is  disabled');
            break;
        case '3':
            returnResponse('Account is  suspended');
            break;
        case '4':
            returnResponse('Account is  deleted');
            break;

        default:
            returnResponse('Account is has problem in status');

            break;
    }
}

function getTaskStatus($status)
{
    switch ($status) {
        case 0:
            return "Not Assigned";
        case 1:
            return "Pending";
        case 2:
            return "Assigned";
        case 3:
            return "In Progress";
        case 4:
            return "Rejected";
        case 5:
            return "Completed";
        default:
            return "Unknown Status";
    }
}

function getTaskStatusColor($status)
{
    switch ($status) {
        case 0:
            return 'gray'; // Not Assigned
        case 1:
            return 'red'; // Pending
        case 2:
            return 'blue'; // Assigned
        case 3:
            return 'orange'; // In Progress
        case 4:
            return 'purple'; // Rejected
        case 5:
            return 'green'; // Completed
        default:
            return 'black'; // Unknown Status
    }
}
function returnResponse($msg, $nextTo = false)
{
    $_SESSION['msg'] = $msg;
    if ($nextTo) {
        header('Location: views/login.php');
        exit();
    }
}

// function returnResponse($message, $success = true) {
//     echo "<div class='" . ($success ? "alert alert-success" : "alert alert-danger") . "'>$message</div>";
// }