<?php
include './controller/task.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editTask'])) {
    editTask();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createTask'])) {
    createTask();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteTask'])) {
    deleteTask();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getTask'])) {
    $task_id = validateInput('task_id');
    $_SESSION['task_id'] = $task_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editTaskStatus'])) {
    editTaskStatus();
}



?>
<main id="main" class="main">
    <?php
    if (isset($_SESSION['msg'])) {
        echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo '</div>';
    }
    ?>



    <div class="card">
        <div class="card-body my-3">
            <table id="myTable" class="table table-bordered my-3">
                <thead>
                    <tr>
                        <th>title</th>
                        <th>description</th>
                        <th>status</th>
                        <th>rejected_reason</th>
                        <th>created_at</th>
                        <th>comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tasks = getTasksByEmployee($_SESSION['user']['id']);
                    if (!$tasks) {
                        returnResponse('hass error when get tasks');
                    }
                    foreach ($tasks as $task) {

                        echo "<tr>";
                        echo "<td>" . $task['title'] . "</td>";
                        echo "<td>" . $task['description'] . "</td>";
                        echo "<td style='color:" . getTaskStatusColor($task['status']) . "; font-weight: bold;'>" . getTaskStatus($task['status']) . "</td>";
                        echo "<td>" . (!empty($task['rejected_reason']) ? $task['rejected_reason'] : 'Null') . "</td>";
                        echo "<td>" . $task['created_at'] . "</td>";
                        // Comment
                        echo "<td>";
                        if ($task['status'] != 0 && $task['status'] != 1) {
                            echo "<form action='' method='POST' style='display: inline;'>";
                            echo "<a href='?p=comment&task_id=" . $task['id'] . "'>See Comment</a>";
                            echo "</form>";
                        } else {
                            echo "This is not available";
                        }
                        echo "</td>";

                        // Status
                        if (getTaskStatus($task['status']) === 'Pending') {
                            echo "<td>";
                            echo "<select name='status' class='form-select' onchange='showNextOptions(this, " . $task['id'] . ")'>";
                            echo "<option value='2'>Accept</option>";
                            echo "<option value='4'>Reject</option>";
                            echo "</select>";
                            echo "</td>";
                        } elseif (getTaskStatus($task['status']) === 'Assigned') {
                            echo "<td>";
                            echo "<select name='status' class='form-select'  onchange='showNextOptions(this, " . $task['id'] . ")'>";
                            echo "<option value='3'>In Progress</option>";
                            echo "<option value='5'>Completed</option>";
                            echo "</select>";
                            echo "</td>";
                        } elseif (getTaskStatus($task['status']) === 'In Progress') {
                            echo "<td>";
                            echo "<select name='status' class='form-select'  onchange='showNextOptions(this, " . $task['id'] . ")'>";
                            echo "<option value='3'>In Progress</option>";
                            echo "<option value='5'>Completed</option>";
                            echo "</select>";
                            echo "</td>";
                        } else {
                            echo "<td></td>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <form action="" method="POST">
                <div class="text-end">
                    <input type="hidden" class="form-control" name="task_id" id="TaskId">
                    <input type="hidden" class="form-control" name="status" id="TaskStatus">
                    <button type='submit' name='editTaskStatus' class='btn btn-primary'>Update Status</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Rejection Reason Modal -->
    <div class="modal" id="rejectionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reason for Rejection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">

                    <form action="" method="POST">
                        <input type="hidden" class="form-control" name="task_id" id="TaskIdmodal">
                        <input type="hidden" class="form-control" name="status" id="TaskStatusmodal">
                        <div class="form-group">
                            <input type="text" class="form-control" name="rejected_reason" id="rejected_reason" required>
                        </div>
                        <button type="submit" name="editTaskStatus" class="btn btn-primary my-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</main>
<script>
    function showNextOptions(selectElement, taskId) {
        var selectValue = selectElement.value;
        if (selectValue == '4') {
            $('#rejectionModal').modal('show');
            document.getElementById('TaskIdmodal').value = taskId;
            document.getElementById('TaskStatusmodal').value = selectValue;
        } else {
            document.getElementById('TaskId').value = taskId;
            document.getElementById('TaskStatus').value = selectValue;
        }
    }
</script>