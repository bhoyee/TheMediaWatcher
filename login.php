<?php include("includes/header.php") ?>

 

              <div class="row no-gutters my-auto">
                <div class="col-10 col-lg-9 mx-auto">
                  <h1 class="text-11 text-white mb-4">Welcome back!</h1>
                  <p class="text-4 text-white line-height-4 mb-5">We are glad to see you again! Discover how the media is reporting your brand.</p>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!-- Welcome Text End -->

      <!-- Login Form
      ============================================= -->
      <div class="col-md-6 d-flex align-items-center">
        <div class="container my-4">
          <div class="row">
            <div class="col-11 col-lg-9 col-xl-8 mx-auto">
              <?php display_message(); ?>
              <?php validate_user_login();?>

              <h3 class="font-weight-400 mb-4">Log In</h3>
              <form id="loginForm" method="post" onsubmit="myFunction()" >
                <div class="form-group">
                  <label for="emailAddress">Email Address / User Name</label>
                  <input type="text" class="form-control" id="email" name="email" required placeholder="Enter Your Email / User Name">
                </div>
                <div class="form-group">
                  <label for="loginPassword">Password</label>
                  <input type="password" class="form-control" id="pwd" name="pwd" required placeholder="Enter Password">
                </div>
                <div class="row">
                  <div class="col-sm">
                    <div class="form-check custom-control custom-checkbox">
                      <input id="remember-me" name="remember" class="custom-control-input" type="checkbox">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="col-sm text-right"><a class="btn-link" href="forgot-password">Forgot Password ?</a></div>
                </div>
                <button class="btn btn-primary btn-block my-4" type="submit">Login</button>
              </form>
              <p class="text-3 text-center text-muted">Don't have an account? <a class="btn-link" href="#">Contact Us</a></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Login Form End -->
    </div>
  </div>
</div>
<div id="loader"></div>

<!-- Back to Top
============================================= -->
<?php include("includes/footer.php") ?>
