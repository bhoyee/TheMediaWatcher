<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


  <!-- Content
  ============================================= -->
  <div id="content" class="py-4">
    <div class="container">
      <div class="row">
        <!-- Left Panel
        ============================================= -->
        <aside class="col-lg-3">

          <!-- Profile Details
          =============================== -->
            <div class="bg-light shadow-sm rounded text-center p-3 mb-4">
            <div class="profile-thumb mt-3 mb-4"> <img class="rounded-circle" src="<?php 
             if(logged_in())
            {
             
                if(!empty($_SESSION['img'])){
                   echo $_SESSION['img'];
                  
                }
                else{
                  $_SESSION['img'] = 'images/profile-thumb.jpg'; // setting default img
                  echo $_SESSION['img'];
                }
            }
            else{
              redirect("index");
            }
            ?>" alt="" width="150" height="150">
            <a href="aprofile-pix.php"> <div class="profile-thumb-edit custom-file bg-primary text-white" data-toggle="tooltip" title="Change Profile Picture"> <i class="fas fa-camera position-absolute"></i>
            </div></a>
            </div>
            <p class="text-3 font-weight-500 mb-2">Hello,
              <?php

        			if(logged_in()){
                if(!empty($_SESSION['fname'])){
                  echo $_SESSION['fname'];
              
                }
                else {
                  // redirect("profile-name.php");

                  echo $_SESSION['uname'];
                  
                }
        			}
        			else{
        				redirect("index.php");
        			}

        			?>
            </p>
            <p class="mb-2"><a href="profile-pix.php" class="text-5 text-light" data-toggle="tooltip" title="Edit Profile"><i class="fas fa-edit"></i></a></p>

          </div>
          <!-- Profile Details End -->

      

          <!-- Need Help?
          =============================== -->
          <div class="bg-light shadow-sm rounded text-center p-3 mb-4">
            <div class="text-17 text-light my-3"><i class="fas fa-comments"></i></div>
            <h3 class="text-3 font-weight-400 my-4">Need Help?</h3>
            <p class="text-muted opacity-8 mb-4">Have questions or concerns regrading your account?<br>
              Our experts are here to help!.</p>
            <a href="#" class="btn btn-primary btn-block">Chate with Us</a>
          </div>
          <!-- Need Help? End -->

        </aside>
        <!-- Left Panel End -->

        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-9">

          
          <!-- Profile Completeness
          =============================== -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 d-flex align-items-center mb-3">Quick Menu</h3>
            <div class="row profile-completeness">
              <div class="col-sm-6 col-md-4 mb-4 mb-md-0">
              <div class="border rounded p-3 text-center bg-success" title="search and download data"> <span class="d-block text-10 text-light mt-2 mb-3"><i class="fas fa-download"></i></span> 
                  <p class="mb-0"><a class="btn-link stretched-link text-light text-decoration-none" href="search">Search / Download Data</a></p>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 mb-4 mb-md-0">
              <div class="border rounded p-3 text-center bg-success " title="update profile"> <span class="d-block text-10 text-light mt-2 mb-3"><i class="fa-solid fa-user"></i></span>
                  <p class="mb-0"><a class="btn-link stretched-link text-light text-decoration-none" href="profile-name">Update Profile</a></p></div>
              </div>
              <div class="col-sm-6 col-md-4 mb-4 mb-sm-0">
                <div class="border rounded p-3 text-center bg-success"  title="update profile and change password"> <span class="d-block text-10 text-light mt-2 mb-3"><i class="fa-solid fa-gears"></i></span> 
                  <p class="mb-0"><a class="btn-link stretched-link text-light text-decoration-none" href="settings">Setting</a></p>
                </div>
              </div>
             
            </div>
          </div>
          <!-- Profile Completeness End -->

          <div class="bg-light shadow-sm rounded p-4 mb-4">

          <div class="row profile-completeness">

          <div class="col-sm-6 col-md-4 mb-4 mb-md-0">
            <div class="border rounded p-3 text-center bg-success"> <span class="d-block text-10 text-light mt-2 mb-3"><i class="fa-solid fa-file"></i></span> 
                <p class="mb-0"><a class="btn-link stretched-link text-light text-decoration-none" href="sindex">Download Documents</a></p>
              </div>
            </div>


          </div>

          </div>
        </div>
        <!-- Middle Panel End -->
      </div>
    </div>
  </div>
  <!-- Content end -->
<?php include("includes/dashfooter.php") ?>
