<?php
?>

<main id="main" class="main">
    <section class="section dashboard">
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
                        <th>name</th>
                        <th>status</th>
                        <th>role</th>
                        <th style="width: 20%;">responsible</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // $users = getUsers();
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
    </section>

</main>