<?php
include './functions.php';
$user_data = userData();
if (isset($_POST['updateUser']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  updateUser();
}
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Profile</h1>
  </div>
  <?php
  if (isset($_SESSION['msg'])) {
    echo '<div id="alert" class="alert alert-success w-50 mx-auto" role="alert">';
    echo  $_SESSION['msg'];
    // unset($_SESSION['msg']);
    echo '</div>';
  }
  ?>
  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <h2><?= $user_data['name'] ?></h2>
            <h3>Web Designer</h3>
            <div class="social-links mt-2">
              <a target="_blank" href="https://www.facebook.com/hessain.gafrony/" class="facebook"><i class="bi bi-facebook"></i></a>
              <a target="_blank" href="https://www.instagram.com/hussain_gafrony/" class="instagram"><i class="bi bi-instagram"></i></a>
              <a target="_blank" href="https://www.linkedin.com/in/hussain-gafrony-180890217/" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">About</h5>
                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                <h5 class="card-title">Profile Details</h5>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?= $user_data['name'] ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?= $user_data['email'] ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8"><?= $user_data['phone_number'] ?></div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="assets/img/profile-img.jpg" alt="Profile">
                      <div class="pt-2">
                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                        <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                      </div>
                    </div>
                  </div>

                  <input name="id" type="hidden" class="form-control" id="id" value="<?= $user_data['id'] ?>">
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="name" type="text" class="form-control" id="fullName" value="<?= $user_data['name'] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone_number" type="text" class="form-control" id="phone_number" value="<?= $user_data['phone_number'] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="<?= $user_data['email'] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9 input-container">
                      <input name="password" type="password" class="form-control" id="password" value="<?= $user_data['password'] ?>">
                      <i class="bi bi-eye-slash" id="togglePassword"></i>
                    </div>
                  </div>


                  <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="updateUser">Save Changes</button>
                  </div>
                </form>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>