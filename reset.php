<?php include("includes/header.php") ?>


              <div class="row no-gutters my-auto">
                <div class="col-10 col-lg-9 mx-auto">
                  <h1 class="text-11 text-white mb-4">Password Rest!</h1>
                  <p class="text-4 text-white line-height-4 mb-5">We are still with you in getting your account back to shape. We gat your back in this process</p>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!-- Welcome Text End -->

      <!-- password reset Form
      ============================================= -->
      <div class="col-md-6 d-flex align-items-center">
        <div class="container my-4">
          <div class="row">
            <div class="col-11 col-lg-9 col-xl-8 mx-auto">
              <?php display_message(); ?>
              <?php password_reset(); ?>

              <h5 class="font-weight-400 mb-4">Rest New Password
              </h5>
              <form id="loginForm" method="post">
                <div class="form-group">
                  <label for="emailAddress">Enter New Password</label>
                  <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="enter code">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm-password" class="form-control" autocomplete="off">
                </div>

                <button class="btn btn-primary btn-block my-4" id="reset-password-submit" name="reset-password-submit" type="submit">Reset Password</button>

                <input type="hidden" class="hide" name="token" id="token" value="<?php echo token_generator() ?>">

                <!-- <button class="btn btn-primary btn-block my-4" type="submit">Submit</button> -->
              </form>
              <p class="text-3 text-center text-muted mt-3"><a class="btn-link" href=".\index.php">Back to home page</a></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Login Form End -->
    </div>
  </div>
</div>

<!-- Back to Top
============================================= -->
<?php include("includes/footer.php") ?>
