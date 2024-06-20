<?php
include './controller/manager.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createManager'])) {
    createManager();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteManager'])) {
    deleteManager();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editManager'])) {
    editManager();
}

$result = [];
$user_id = validateInput('user_id');
if ($user_id) {
    $result = getManager($user_id);
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
                <a class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#managerModal">Add Manager</a>
            </div>
            <div class="card-body">
                <div class="rounded-3">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
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
                            $managers = getManagers();
                            if (!$managers) {
                                returnResponse('hass error when get managers');
                            }

                            foreach ($managers as $manager) {
                                echo "<tr>";
                                echo "<td>" . $manager['name'] . " <a href='?p=disEmpolyees&manager_id=" . $manager['user_id'] . "'><i class='bi bi-people-fill'></i></a></td>";
                                echo "<td>" . $manager['phone_number'] . "</td>";
                                echo "<td>" . $manager['birthdate'] . "</td>";
                                echo "<td>" . $manager['email'] . "</td>";
                                echo "<td>" . $manager['is_active'] . "</td>";
                                echo "<td>" . $manager['created_at'] . "</td>";
                                echo "<td>";
                                // " . $_SERVER["PHP_SELF"] . "
                                // action='' has error when delete manager this going in index page
                                echo "<form action='' method='POST' style='display: inline;'>";
                                echo "<input type='hidden' name='user_id' value='" . $manager['user_id'] . "'>";
                                echo "<button type='submit' class=' me-3 btn btn-danger' name='deleteManager'>Delete</button>";
                                echo "</form>";

                                echo "<form action='' method='POST' style='display: inline;'>";
                                echo "<input type='hidden' name='user_id' value='" . $manager['user_id'] . "'>";
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

    <!-- Create Manager Modal  -->
    <div class="modal fade" id="managerModal" tabindex="-1" aria-labelledby="managerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="managerModal">New Manager</h1>
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
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Manager Status</label>
                            <div class="col-md-8 col-lg-5">
                                <select class="form-select" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="2">Disabled</option>
                                    <option value="3">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="createManager">Save</button>
                        </div>
                    </form>
                    <!-- Form End -->

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Manager Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editmanagerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit">Edit Manager</h1>
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
                            <label for="role" class="col-md-4 col-lg-4 col-form-label">Manager Status</label>
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="editManager">Save</button>
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
                modal.hide();
            });

        <?php endif; ?>
    });
</script>