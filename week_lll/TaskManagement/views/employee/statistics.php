<?php
include './controller/static.php';
?>

<div class="container mt-5">
    <?php
    $user_id = $_SESSION['user']['id'];

    // task counts by status for the employee
    $tasks_pending = getTaskCountByEmployeeAndStatus($user_id, 1);
    $tasks_assigned = getTaskCountByEmployeeAndStatus($user_id, 2);
    $tasks_completed = getTaskCountByEmployeeAndStatus($user_id, 5);

    if ($tasks_pending === false || $tasks_assigned === false || $tasks_completed === false) {
        echo '<div class="alert alert-danger" role="alert">Error retrieving data</div>';
    }
    ?>

    <h1 class="mb-4">Statistics</h1>

    <!-- Tasks Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Tasks</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_pending['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Assigned Tasks</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_assigned['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Completed Tasks</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_completed['task_count'] ?></h5>
                </div>
            </div>
        </div>
    </div>