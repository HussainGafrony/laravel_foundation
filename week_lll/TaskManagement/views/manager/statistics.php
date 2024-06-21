<?php
include './controller/static.php';
?>

<div class="container mt-5">
    <?php
    $user_id = $_SESSION['user']['id'];

    // tasks count by status for the manager
    $tasks_completed = getTaskCountByManagerAndStatus($user_id, 5);
    $tasks_not_assigned = getTaskCountByManagerAndStatus($user_id, 0);
    $tasks_in_progress = getTaskCountByManagerAndStatus($user_id, 3);

    //  employees by status for the manager
    $employees_active = EmployeesByManager(1, $user_id);
    $employees_disabled = EmployeesByManager(2, $user_id);
    $employees_suspended = EmployeesByManager(3, $user_id);


    if ($tasks_completed === false || $tasks_not_assigned === false || $employees_active === false || $employees_suspended === false || $employees_disabled === false) {
        echo '<div class="alert alert-danger" role="alert">Error retrieving data</div>';
    }
    ?>

    <h1 class="mb-4">Statistics</h1>

    <!-- Tasks Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tasks Completed</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_completed['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Tasks Not Assigned</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_not_assigned['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger-light mb-3">
                <div class="card-header">Tasks In Progress </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_in_progress['task_count'] ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Active Employees</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $employees_active['employee_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Suspended Employees</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $employees_suspended['employee_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Disabled Employees</div>
                <div class="card-body">
                    <h5 class="card-title text-white"><?= $employees_disabled['employee_count'] ?></h5>
                </div>
            </div>
        </div>
    </div>