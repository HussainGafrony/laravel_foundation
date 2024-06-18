<?php
include './controller/task.php';

?>
<main id="main" class="main">
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
        echo $_SESSION['msg'];
        // unset($_SESSION['msg']);
        echo '</div>';
    }
    ?>
    <div class="card">
        <div class="card-body mt-4">
            <table id="myTable" class="table table-bordered hover">
                <thead>
                    <tr>
                        <th>manager_name</th>
                        <th>employee_name</th>
                        <th>title</th>
                        <th>description</th>
                        <th>status</th>
                        <th>rejected_reason</th>
                        <th>created_at</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tasks = getTasks();
                    if (!$tasks) {
                        returnResponse('hass error when get tasks');
                    }

                    foreach ($tasks as $task) {

                        echo "<tr>";
                        echo "<td>" . $task['manager_name'] . "</td>";
                        echo "<td>" . $task['employee_name'] . "</td>";
                        echo "<td>" . $task['title'] . "</td>";
                        echo "<td>" . $task['description'] . "</td>";
                        echo "<td>" . getTaskStatus($task['status']) . "</td>";
                        echo "<td>" . $task['rejected_reason'] . "</td>";
                        echo "<td>" . $task['created_at'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>



</main>