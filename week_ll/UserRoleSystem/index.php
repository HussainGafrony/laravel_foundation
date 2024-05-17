<?php
require './db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    Login();
}

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: ./admin.php');
    } elseif ($_SESSION['role'] == 'user') {
        header('Location: ./user.php');
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Login </title>
</head>

<body>
    <section class="form-02-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="_lk_de">
                        <?php
                        if (isset($_GET['msg'])) {
                            echo '<div id="alert" class="alert alert-danger w-50 mx-auto" role="alert">';
                            echo $_GET['msg'];
                            echo '</div>';
                        }
                        ?>
                        <div class="form-03-main">

                            <div class="logo img-fluid">
                                <img src="./assets/images/user.png">
                            </div>

                            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control _ge_de_ol" placeholder="Enter Email" required="" aria-required="true">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control _ge_de_ol" placeholder="Enter Password" required="" aria-required="true">
                                </div>


                                <div class="checkbox form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="#">Forgot Password</a>
                                </div>

                                <div class="form-group">

                                    <button class="_btn_04" type="submit" name="login">Login</button>
                                </div>
                            </form>
                            <div class="form-group nm_lk">
                                <p>Or Login With</p>
                            </div>

                            <div class="form-group pt-0">
                                <div class="_social_04">
                                    <ol>
                                        <li><i class="fa fa-facebook"></i></li>
                                        <li><i class="fa fa-twitter"></i></li>
                                        <li><i class="fa fa-google-plus"></i></li>
                                        <li><i class="fa fa-instagram"></i></li>
                                        <li><i class="fa fa-linkedin"></i></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="./assets/js/main.js"></script>
</body>

</html>