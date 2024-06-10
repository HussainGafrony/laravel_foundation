<?php
include './controller/employee.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createEmployee'])) {
    createEmployee();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteEmployee'])) {
    deleteEmployee();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getManager'])) {
    $user_id = validateInput('user_id');
    $_SESSION['user_id'] =  $user_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editEmployee'])) {
    editEmployee();
}


?>

<main id="main" class="main">
    <section class="section dashboard">
        <?php
        if (isset($_SESSION['msg'])) {
            echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
            echo $_SESSION['msg'];
            // unset($_SESSION['msg']);
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
                                <th>user_id</th>
                                <th>manager_id</th>
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
                                // echo "<pre>";
                                // print_r($employee);
                                // echo "</pre>";

                                echo "<tr>";
                                echo "<td>" . $employee['user_id'] . "</td>";
                                echo "<td>" . $employee['manager_id'] . "</td>";
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
                                echo "<button type='submit' class='me-3 btn btn-primary' name='getManager'>
                                <a data-bs-toggle='modal' data-bs-target='#editmanagerModal'>Edit</a> </button>";
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
    <div class="modal fade" id="editmanagerModal" tabindex="-1" aria-labelledby="editmanagerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php
                $user_id =  $_SESSION['user_id'];
                if (isset($user_id) && $user_id !== '') {
                    $result = getEmployee($_SESSION['user_id']);
                    $_SESSION['employee'] = $result;
                }

                // echo "<pre>";
                // print_r($_SESSION['manager']);
                // echo "</pre>";

                ?>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editmanagerModal">Edit Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Statred -->
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="row mb-3">
                            <input name="user_id" type="hidden" class="form-control" id="user_id" value="<?= $_SESSION['employee']['user_id'] ?>" required>

                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="name" type="text" class="form-control" id="name" value="<?= $_SESSION['employee']['name'] ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone_Number</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="phone_number" type="number" class="form-control" value="<?= $_SESSION['employee']['phone_number'] ?>" id="phone_number" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Birth_Date</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="birthdate" type="date" class="form-control" value="<?= $_SESSION['employee']['birthdate'] ?>" id="birthdate" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" value="<?= $_SESSION['employee']['email'] ?>" id="email" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password</label>
                            <div class="col-md-8 col-lg-9 input-container">
                                <input name="password" type="password" class="form-control" value="<?= $_SESSION['employee']['password'] ?>" id="password" required>
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Employee Status</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="manager_id">
                                    <?php
                                    $is_active = $_SESSION['employee']['is_active'];
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
                                <select class="form-select" name="is_active">
                                    <?php
                                    $managers = getManagers();
                                    if (!$managers) {
                                        returnResponse('hass error when get managers');
                                    }

                                    foreach ($managers as $manager) {

                                        $selected = $manager['id'] == $_SESSION['employee']['manager_id'] ? 'selected' : '';
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

</main>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        function toggleUserManager() {
            console.log("Toggling User Manager visibility");
            var userRole = $("#user_role").val();
            if (userRole === "admin" || userRole === "manager") {
                $("#user_manager").hide();
            } else {
                $("#user_manager").show();
            }
        }
        $("#user_role").change(toggleUserManager);
        toggleUserManager();


    });
    // $("#togglePassword").click(function() {
    //     var type = $("#password").prop("type") === "password" ? "text" : "password";
    //     $("#password").prop("type", type);
    //     $(this).toggleClass("bi-eye");
    // });
</script>