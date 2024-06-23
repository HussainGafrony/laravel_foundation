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
    $_SESSION['task_id'] = $task_id;
}

$result = [];
$task_id = validateInput('task_id');

if ($task_id) {
    $result = getTask($task_id);
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

        <div class="card-body text-end pb-2 me-2">
            <a class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#createModal">Add Task</a>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-bordered hover">
                <thead>
                    <tr>
                        <th>employee_name</th>
                        <th>title</th>
                        <th>description</th>
                        <th>status</th>
                        <th>rejected_reason</th>
                        <th>created_at</th>
                        <th>comment</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tasks = getTasksByManager($_SESSION['user']['id']);
                    if (!$tasks) {
                        returnResponse('hass error when get tasks');
                    } else {
                        foreach ($tasks as $task) {
                            echo "<tr>";
                            // echo "<td>" . $task['employee_name'] == null ? 'null' : $task['employee_name']  . "</td>";
                            echo "<td>" . ($task['employee_name'] == null ? 'Not Selecet' : $task['employee_name']) . "</td>";

                            echo "<td>" . $task['title'] . "</td>";
                            echo "<td>" . $task['description'] . "</td>";
                            echo "<td>" . getTaskStatus($task['status']) . "</td>";
                            echo "<td>" . $task['rejected_reason'] . "</td>";
                            echo "<td>" . $task['created_at'] . "</td>";
                            echo "<td>";
                            // Comment
                            echo "<form action='' method='POST' style='display: inline;'>";
                            echo "<button type='submit' class='me-3 btn'><a href='?p=comment&task_id=" . $task['id'] . "' >See Comment</a> </button>";
                            echo "</form>";
                            echo "</td>";

                            echo "<td>";

                            // " . $_SERVER["PHP_SELF"] . "
                            // action='' has error when delete task this going in index page
                            echo "<form action='' method='POST' style='display: inline;'>";
                            echo "<input type='hidden' name='task_id' value='" . $task['id'] . "'>";
                            echo "<button type='submit' class=' me-3 btn btn-danger' name='deleteTask'>Delete</button>";
                            echo "</form>";

                            echo "<form action='' method='POST' style='display: inline;'>";
                            echo "<input type='hidden' name='task_id' value='" . $task['id'] . "'>";
                            echo "<button type='submit' class='me-3 btn btn-primary'>Edit</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>


    <!-- Edit Task [Modal] -->
    <div class="modal modal-lg" id="edit" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModal">Edit Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" name="task_id" value="<?= $result['id'] ?>">
                        <input type="hidden" name="manager_id" value="<?= $result['manager_id'] ?>">
                        <input type="hidden" name="employee_id" value="<?= $result['employee_id'] ?>">
                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Title</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="title" type="text" class="form-control" value="<?= $result['title'] ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Description</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="description" type="text" class="form-control" value="<?= $result['description'] ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">rejected_reason</label>
                            <div class="col-md-8 col-lg-9 input-container">
                                <input name="rejected_reason" type="text" class="form-control" value="<?= $result['rejected_reason'] ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-3 col-form-label">Task Status
                            </label>
                            <div class="col-md-8 col-lg-5">
                                <?php
                                $status = $result['status'];
                                $disabled = ($status > 1) ? 'disabled' : '';
                                ?>

                                <select class="form-select" name="status" <?php echo $disabled; ?>>
                                    <?php
                                    $statuses = [0, 1, 2, 3, 4, 5];
                                    foreach ($statuses as $value) {
                                        $selected = ($status == $value) ? 'selected' : '';
                                        echo '<option value="' . $value . '" ' . $selected . ' >' . getTaskStatus($value) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Employee Name</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="employee_id">
                                    <?php
                                    $manager = getManager($_SESSION['user']['id']);
                                    if (!$manager) {
                                        returnResponse('Error when getting manager');
                                    }

                                    $employees = getEmployeesByManagerTask($manager['id']);
                                    if (!$employees) {
                                        returnResponse('Error when getting employees');
                                    }

                                    foreach ($employees as $employee) {
                                        $selected = $employee['id'] == $result['employee_id'] ? 'selected' : '';
                                        echo "<option value='" . $employee['id'] . "' $selected>" . $employee['employee_name'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="editTask">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task [Modal]  -->
    <div class="modal modal-lg" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModal">Create Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <?php

                        $manager = getManager($_SESSION['user']['id']);
                        if (!$manager) {
                            returnResponse('Error when getting manager');
                        }
                        ?>
                        <input type="hidden" name="manager_id" value="<?php echo $manager['id']; ?>">
                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Title</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="title" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Description</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="description" type="text" class="form-control" required>
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">rejected_reason</label>
                            <div class="col-md-8 col-lg-9 input-container">
                                <input name="rejected_reason" type="text" class="form-control">
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-3 col-form-label">Task Status
                            </label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="status">
                                    <?php
                                    $statuses = [0, 1, 2, 3, 4, 5];
                                    foreach ($statuses as $value) {
                                        echo '<option value="' . $value . '" >' . getTaskStatus($value) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Employee Name</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="employee_id">
                                    <option value=''>Not Selected</option>

                                    <?php
                                    $manager = getManager($_SESSION['user']['id']);
                                    if (!$manager) {
                                        returnResponse('Error when getting manager');
                                    }

                                    $employees = getEmployeesByManagerTask($manager['id']);
                                    if (!$employees) {
                                        returnResponse('Error when getting employees');
                                    }

                                    foreach ($employees as $employee) {
                                        echo "<option value='" . $employee['id'] . "'>" . $employee['employee_name'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="createTask" data-bs-dismiss="modal">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($result)) : ?>
            var modalElement = document.getElementById('edit');
            var modal = new bootstrap.Modal(modalElement);
            modal.show();

            modalElement.addEventListener('click', function(event) {
                if (event.target.classList.contains('btn-close') || event.target.classList.contains('btn-secondary') || event.target.classList.contains('modal')) {
                    modal.hide();
                }
            });

            document.querySelector('.btn-primary').addEventListener('click', function() {
                if (modal) {
                    modal.hide();
                }
            });
        <?php endif; ?>


    });
</script>