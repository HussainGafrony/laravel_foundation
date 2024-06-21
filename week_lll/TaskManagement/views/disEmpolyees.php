<?php

include './controller/manager.php';

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

    <!-- Admin Role -->
    <div class="card">
        <div class="card-body">
            <table id="myTable" class="table table-bordered">
                <thead class="">
                    <tr>
                        <th>Name</th>
                        <th>Phone_Number</th>
                        <th>Birth_Date</th>
                        <th>Email</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $employees = getEmployeesByManager($_GET['manager_id']);
                    if (!$employees) {
                        echo "<tr><td colspan='4' class='text-center'>There are no employees</td></tr>";
                    } else {
                        foreach ($employees as $employee) {
                            echo "<tr>";
                            echo "<td>" . $employee['name'] . "</td>";
                            echo "<td>" . $employee['phone_number'] . "</td>";
                            echo "<td>" . $employee['birthdate'] . "</td>";
                            echo "<td>" . $employee['email'] . "</td>";
                            echo "</tr>";
                        }
                    }

                    ?>
                </tbody>

            </table>
        </div>
    </div>


</main>