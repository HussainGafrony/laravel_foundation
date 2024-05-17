<?php
require './manageUsers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateUser'])) {
    updateUser();
}

$user_data = getUserData();

if (is_array($user_data)) {
    $name = $user_data['name'];
    $email = $user_data['email'];
    $age = $user_data['age'];
    $password = $user_data['password'];
} else {
    echo $user_data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>

    <div class="container rounded bg-white mt-5 mb-5 shadow w-50">
        <?php
        if (isset($_GET['msg'])) {
            echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
            echo $_GET['msg'];
            echo '</div>';
        }
        ?>
        <div class="row justify-content-center">

            <div class="col-md-12 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">User Settings</h4>
                    </div>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $user_data['id'] ?>">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="name" value="<?= $name ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="email" value="<?= $email ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Age</label>
                                <input type="number" class="form-control" name="age" placeholder="age" value="<?= $age ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="password" value="<?= $password ?>">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit" name="updateUser">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>