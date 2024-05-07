<?php
require './auth.php';

if (isset($_POST['logout'])) {
    logout();
}

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}

?>

<?php include '../layout/header.php'; ?>

<style>
    .gradient-custom {
        background: #f6d365;
        background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));
        background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
    }
</style>

<body>
    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">

                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <?php
                                if (isset($_SESSION["img"])) {
                                    $img = $_SESSION["img"];
                                    echo "<img src='$img' alt='Avatar' class='img-fluid my-4' style='width: 100px;'>";
                                } else {
                                    echo "<img src='https://cdn.icon-icons.com/icons2/2643/PNG/512/male_man_people_person_avatar_white_tone_icon_159363.png' alt='Avatar' class='img-fluid my-4' style='width: 100px;'>";
                                }
                                ?>

                                <p>Backend Developer</p>
                                <i class="far fa-edit mb-5"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Name</h6>
                                            <?php
                                            if (isset($_GET['name'])) {
                                                echo '<p class="text-muted">' . $_GET['name'] . '</p>';
                                            } else {
                                                if (isset($_SESSION["email"])) {
                                                    $username = strstr($_SESSION['email'], '@', true);
                                                    echo '<p class="text-muted">' . $username . '</p>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <?php
                                            if (isset($_SESSION["email"])) {
                                                $email = $_SESSION["email"];
                                                echo  '<p class="text-muted">' . $email . '</p>';
                                            }
                                            ?>

                                        </div>
                                        <form method="post">
                                            <!-- Your other form elements -->
                                            <button type="submit" class="btn btn-outline-warning" name="logout">Logout</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include '../layout/footer.php' ?>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>


</html>