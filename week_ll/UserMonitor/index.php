<?php
require './db_connection.php';
require './manageUsers.php';
if (isset($_POST['deleteUser'])) {
    deleteUser();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <?php
        if (isset($_GET['msg'])) {
            echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
            echo $_GET['msg'];
            echo '</div>';
        }
        ?>
        <table id="myTable" class="table table-bordered hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>age</th>
                    <th style="width: 20%;">actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = getUsers();
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['name'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . $user['age'] . "</td>";
                    echo "<td>";
                    echo "<form action='" . $_SERVER["PHP_SELF"] . "' method='POST' style='display: inline;'>";
                    echo "<input type='hidden' name='id' value='" . $user['id'] . "'>";
                    echo "<button type='submit' class=' me-3 btn btn-danger' name='deleteUser'>Delete</button>";
                    echo "</form>";
                    echo "<form action='edit.php' method='POST' style='display: inline;'>";
                    echo "<input type='hidden' name='id' value='" . $user['id'] . "'>";
                    echo "<button type='submit' class='me-3 btn btn-primary' style=' cursor: pointer;'>Edit</button>";
                    echo "</form>";
                    echo  "<a href='add.php' class=' btn btn-success'>Add</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="./assets/js/main.js"></script>

</body>

</html>