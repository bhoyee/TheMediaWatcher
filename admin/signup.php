<?php include("includes/header.php") ?>
<?php
if(logged_in()){
  echo "Welcome Back ";
  echo $_SESSION['full_name'];
  redirect("dashboard.php");
}
else{
  echo " ";
}
?>

            <div class="row my-auto">
              <div class="col-10 col-lg-9 mx-auto">
                <h1 class="text-11 text-white mb-4">Get Verified!</h1>
                <p class="text-4 text-white line-height-4 mb-5">Every day, Discover how the media is reporting your brand.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Get Verified! Text End -->
      </div>
      <div class="col-md-6 d-flex align-items-center">
        <!-- SignUp Form
        ============================================= -->
        <div class="container my-4">
          <div class="row">
            <div class="col-11 col-lg-9 col-xl-8 mx-auto">
              <!-- error handling -->
              <?php validate_user_registration() ?>

              <?php display_message(); ?>

              <h3 class="font-weight-400 mb-4">One Time Admin Sign Up</h3>
              <form id="register-form" method="post" onsubmit="myFunction()" >
                <div class="form-group">
                  <label for="fullName">User Name</label>
                  <input type="text" class="form-control" id="uName" name="uName" required placeholder="Enter Your User Name">
                </div>
                <div class="form-group">
                  <label for="emailAddress">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email">
                </div>
                <div class="form-group">
                  <label for="loginPassword">Password</label>
                  <input type="password" class="form-control" id="pwd" name="pwd" required placeholder="Enter Password">
                </div>
                <button class="btn btn-primary btn-block my-4" type="submit" name="submit">Sign Up</button>
              </form>
              <p class="text-3 text-center text-muted">Already have an account? <a class="btn-link" href="index.php">Log In</a></p>
              

            </div>
          </div>
        </div>
        <!-- SignUp Form End -->
      </div>
    </div>
  </div>
</div>
<div id="loader"></div>


<!-- Back to Top
============================================= -->
<?php include("includes/footer.php") ?>
