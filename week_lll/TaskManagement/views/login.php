<?php include '../layout/auth/header.php';
session_start(); ?>

<body>

  <main>
    <div class="container">
      <?php
      if (isset($_SESSION['msg'])) {
        echo '<div id="alert" class="alert alert-danger w-50 mx-auto" role="alert">';
        echo  $_SESSION['msg'];
        echo '</div>';
      }
      ?>
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="../assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Welcome</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  </div>

                  <form class="row g-3" action="../manage.php" method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback ">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>
              <?php
              if (isset($_SESSION['msg'])) {
                echo "<p>" . htmlspecialchars($_SESSION['msg']) . "</p>";
                unset($_SESSION['msg']);
              }
              ?>
              <?php include '../layout/auth/footer.php' ?>