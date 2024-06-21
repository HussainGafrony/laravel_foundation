<?php
include './controller/static.php';
?>

<div class="container mt-5">
    <?php

    $tasks_completed = getTasks(5);
    $tasks_not_assigned = getTasks(0);
    $managers_active = getManagers(1);
    $managers_not_active = getManagers(0);
    $employees_active = getEmployees(1);
    $employees_not_active = getEmployees(0);
    $employees_disabled = getEmployees(2);

    if (!$tasks_completed || !$tasks_not_assigned || !$managers_active || !$managers_not_active || !$employees_active || !$employees_not_active || !$employees_disabled) {
        echo '<div class="alert alert-danger" role="alert">Error retrieving data</div>';
    }
    ?>

    <h1 class="mb-4">Statistics</h1>

    <!-- Tasks Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Tasks Completed</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_completed['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Tasks Not Assigned</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $tasks_not_assigned['task_count'] ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Managers Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Active Managers</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $managers_active['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Inactive Managers</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $managers_not_active['task_count'] ?></h5>
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
                    <h5 class="card-title"><?= $employees_active['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Inactive Employees</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $employees_not_active['task_count'] ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Disabled Employees</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $employees_disabled['task_count'] ?></h5>
                </div>
            </div>
        </div>
    </div>