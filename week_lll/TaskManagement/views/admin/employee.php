<?php
include './controller/employee.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createEmployee'])) {
    createEmployee();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteEmployee'])) {
    deleteEmployee();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editEmployee'])) {
    editEmployee();
}

$result = [];
$user_id = validateInput('user_id');
if ($user_id) {
    $result = getEmployee($user_id);
}

?>
<main id="main" class="main">
    <section class="section dashboard">
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
                <a class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#managerModal">Add Employee</a>
            </div>
            <div class="card-body">
                <div class="rounded-3">
                    <table id="myTable" class="table table-bordered hover">
                        <thead>
                            <tr>

                                <th>manager_name</th>
                                <th>name</th>
                                <th>phone_number</th>
                                <th>birthdate</th>
                                <th>email</th>
                                <th>is_active</th>
                                <th>created_at</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $employees = getEmployees();
                            if (!$employees) {
                                returnResponse('hass error when get employees');
                            }
                            foreach ($employees as $employee) {

                                echo "<tr>";
                                echo "<td>" . $employee['manager_name'] . "</td>";
                                echo "<td>" . $employee['name'] . "</td>";
                                echo "<td>" . $employee['phone_number'] . "</td>";
                                echo "<td>" . $employee['birthdate'] . "</td>";
                                echo "<td>" . $employee['email'] . "</td>";
                                echo "<td>" . $employee['is_active'] . "</td>";
                                echo "<td>" . $employee['created_at'] . "</td>";
                                echo "<td>";
                                // " . $_SERVER["PHP_SELF"] . "
                                // action='' has error when delete employee this going in index page
                                echo "<form action='' method='POST' style='display: inline;'>";
                                echo "<input type='hidden' name='user_id' value='" . $employee['user_id'] . "'>";
                                echo "<button type='submit' class=' me-3 btn btn-danger' name='deleteEmployee'>Delete</button>";
                                echo "</form>";

                                echo "<form action='' method='POST' style='display: inline;'>";
                                echo "<input type='hidden' name='user_id' value='" . $employee['user_id'] . "'>";
                                echo "<button type='submit' class='me-3 btn btn-primary'>Edit </button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- Create Employee [Modal]  -->
    <div class="modal fade" id="managerModal" tabindex="-1" aria-labelledby="managerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="managerModal">New Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="name" type="text" class="form-control" id="name" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone_Number</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="phone_number" type="number" class="form-control" id="phone_number" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Birth_Date</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="birthdate" type="date" class="form-control" id="birthdate" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" id="email" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password</label>
                            <div class="col-md-8 col-lg-9 input-container">
                                <input name="password" type="password" class="form-control" id="password" required>
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Employee Status</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="2">Disabled</option>
                                    <option value="3">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Manager </label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="manager_id">
                                    <?php
                                    $managers = getManagers();
                                    if (!$managers) {
                                        returnResponse('hass error when get managers');
                                    }

                                    foreach ($managers as $manager) {

                                        echo "<option value='" . $manager['id'] . "'>" . $manager['name'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="createEmployee">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee [Modal] -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editmanagerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editmanagerModal">Edit Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="row mb-3">
                            <input name="user_id" type="hidden" class="form-control" id="user_id" value="<?= $result['user_id'] ?>" required>

                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="name" type="text" class="form-control" id="name" value="<?= $result['name'] ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone_Number</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="phone_number" type="number" class="form-control" value="<?= $result['phone_number'] ?>" id="phone_number" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Birth_Date</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="birthdate" type="date" class="form-control" value="<?= $result['birthdate'] ?>" id="birthdate" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" value="<?= $result['email'] ?>" id="email" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password</label>
                            <div class="col-md-8 col-lg-9 input-container">
                                <input name="password" type="password" class="form-control" value="<?= $result['password'] ?>" id="password" required>
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Employee Status</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="is_active">
                                    <?php
                                    $is_active = $result['is_active'];
                                    ?>
                                    <option value="1" <?php echo ($is_active == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="2" <?php echo ($is_active == 2) ? 'selected' : ''; ?>>Disabled</option>
                                    <option value="3" <?php echo ($is_active == 3) ? 'selected' : ''; ?>>Suspended</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Manager Employee</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="manager_id">
                                    <?php
                                    $managers = getManagers();
                                    if (!$managers) {
                                        returnResponse('hass error when get managers');
                                    }

                                    foreach ($managers as $manager) {

                                        $selected = $manager['id'] == $result['manager_id'] ? 'selected' : '';
                                        echo "<option value='" . $manager['id'] . "' $selected>" . $manager['name'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="editEmployee">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->

                </div>
            </div>
        </div>
    </div>
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
                    modal.hide();
                });

            <?php endif; ?>
        });
    </script>