<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


  <!-- Secondary Menu
  ============================================= -->
  <div class="bg-primary">
    <div class="container d-flex justify-content-center">
      <ul class="nav secondary-nav">
        <li class="nav-item"> <a class="nav-link active" href="#">Account</a></li>
        <li class="nav-item"> <a class="nav-link" href="profile-name">Profile </a></li>
        <!-- <li class="nav-item"> <a class="nav-link" href="profile-notifications.html">Notifications</a></li> -->
      </ul>
    </div>
  </div>
  <!-- Secondary Menu end -->

  <!-- Content
  ============================================= -->
  <div id="content" class="py-4">
    <div class="container">
      <div class="row">

        <!-- Left Panel
        ============================================= -->
        <aside class="col-lg-3">
          <?php
          $userID = $_SESSION['userID'];
          $sql = "SELECT boidata.fname AS F_Name, boidata.lname AS L_Name, boidata.phone AS phone, boidata.company AS cname, users.email AS Email, users.username AS uname, users.reg_date AS regDate
          FROM boidata INNER JOIN users ON users.userID = boidata.userID WHERE boidata.userID = $userID ";
          $result = query($sql);
          confirm($result);
          if(row_count($result) > 0){

            $row = fetch_array($result);
          
            $fName    = $row['F_Name'];
            $lName    = $row['L_Name'];
            $cname   =  $row['cname'];
            $email    = $row['Email'];
            $uname    = $row['uname'];
            $phone    = $row['phone'];
            $regDate   = $row['regDate'];


           
              $image = 'images/profile-thumb.jpg'; // setting default img
              
            
          }

        ?>
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
              redirect("index.php");
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
                  echo $_SESSION['uname'];
                  // header('Location: profile-name.php');
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
            <a href="#" class="btn btn-primary btn-block">Chate with Us</a> </div>
          <!-- Need Help? End -->

        </aside>
        <!-- Left Panel End -->

        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-9">
          <div class="text-center">

                              <?php
                                $userID = $_SESSION['userID'];
                                 if (isset($_POST['update_personal'])) {
                            $sql2 = "UPDATE boidata set fname='" . $_POST['first_name'] . "', lname='" . $_POST['last_name'] . "', phone='" . $_POST['phone'] . "', company='" . $_POST['cname'] . "' WHERE userID= $userID ";
                                // $message = "Record Modified Successfully";
                                $result = query($sql2);
                                confirm($result);
                                if($result){
                                  $message = "Information Updated Successfully";
                                echo "<script type='text/javascript'>alert('$message');</script>";
                                 echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                                }
                                else{
                                  $message = "Something went wrong";
                                echo "<script type='text/javascript'>alert('$message');</script>";

                                }
                              }
                        
                               //update email
                               if (isset($_POST['update_email'])) {

                                 $sql4 = "UPDATE users set email='" . $_POST['email'] . "' WHERE userID= $userID ";
                                     // $message = "Record Modified Successfully";
                                     $result4 = query($sql4);
                                     confirm($result4);
                                     if($result4 > 0){
                                       $message = "Email Updated Successfully";
                                     echo "<script type='text/javascript'>alert('$message');</script>";
                                     echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                                     }
                                     else{
                                       $message = "Something went wrong";
                                     echo "<script type='text/javascript'>alert('$message');</script>";
                                     // $message = "Something went wrong";
                                     }

                               }
                               //update phone

                               if (isset($_POST['update_phone'])) {

                                 $sql5 = "UPDATE boidata set phone='" . $_POST['phone'] . "' WHERE userID= $userID ";
                                     // $message = "Record Modified Successfully";
                                     $result5 = query($sql5);
                                     confirm($result5);
                                     if($result5 > 0){
                                       $message = "Mobile Number Updated Successfully";
                                     echo "<script type='text/javascript'>alert('$message');</script>";
                                     echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                                     }
                                     else{
                                       $message = "Something went wrong";
                                     echo "<script type='text/javascript'>alert('$message');</script>";
                                     // $message = "Something went wrong";
                                     }

                               }

                               // chang password





                                ?>


          </div>
          <!-- Personal Details
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <?php
             if (isset($_POST['change_pwd'])) {
              change_pwd();
             }
   
             ?>
            <?php display_message(); ?>
            <h3 class="text-5 font-weight-400 mb-3">Personal Details <a href="#edit-personal-details" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Email</p>
              <p class="col-sm-9"><?php echo $email;  ?></p>
            </div>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">User Name</p>
              <p class="col-sm-9"><?php echo $uname;  ?></p>
            </div>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
              <p class="col-sm-9"><?php echo $fName .' '. $lName;  ?>,<br>
          </p>
            </div>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="edit-personal-details" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Personal Details</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">

                  <form id="personaldetails" method="post">
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="firstName">First Name</label>
                          <input type="text" value="<?php echo $fName;  ?>" class="form-control" data-bv-field="firstName" id="firstName" name="first_name" required placeholder="First Name">
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="lastName">Last Name</label>
                          <input type="text" value="<?php echo $lName;  ?>" class="form-control" data-bv-field="lastName" id="lastName" name="last_name" required placeholder="Last Name">
                        </div>
                      </div>
                   
                      <div class="col-12">
                        <div class="form-group">
                          <label for="phone">Mobile Number</label>
                          <input id="phone" name="phone" value="<?php echo $phone;  ?>" type="text" class="form-control" required placeholder="Mobile number">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="phone">Company</label>
                          <input id="cname" name="cname" value="<?php echo $cname;  ?>" type="text" class="form-control" required placeholder="Company Name">
                        </div>
                      </div>


                      <!-- <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="zipCode">Zip Code</label>
                          <input id="zipCode" value="22434" type="text" class="form-control" required placeholder="City">
                        </div>
                      </div> -->
                      <!-- <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label for="inputCountry">Country</label>
                          <select class="custom-select" id="inputCountry" name="country_id">
                            <option value=""> --- Please Select --- </option>

                            <option selected="selected" value="223">United States</option>

                          </select>
                        </div>
                      </div> -->
                    </div>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="update_personal" value="update_personal">Save Changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Personal Details End -->

          <!-- Account Settings
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">Account Settings <a href="#" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Language</p>
              <p class="col-sm-9">English (United States)</p>
            </div>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Registered Date</p>
              <p class="col-sm-9"><?php echo $regDate;  ?></p>
            </div>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Account Status</p>
              <p class="col-sm-9"><span class="bg-success text-white rounded-pill d-inline-block px-2 mb-0"><i class="fas fa-check-circle"></i> <?php $status = 'Verified'; echo $status;  ?></span></p>
            </div>
          </div>
        
          <!-- Email Addresses
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">Email Addresses <a href="#edit-email" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Email ID <span class="text-muted font-weight-500">(Primary)</span></p>
              <p class="col-sm-9"><?php echo $email;  ?></p>
            </div>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="edit-email" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Email Addresses</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="emailAddresses" method="post">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="emailID">Email ID <span class="text-muted font-weight-500">(Primary)</span></label>
                          <input type="email" name="email" value="<?php echo $email;  ?>" class="form-control" data-bv-field="emailid" id="emailID" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- <a class="btn-link text-uppercase d-flex align-items-center text-1 float-right mb-3" href="#"><span class="text-3 mr-1"><i class="fas fa-plus-circle"></i></span>Add another email</a> -->
                    <button class="btn btn-primary btn-block" type="submit" name="update_email">Save Changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Email Addresses End -->

          <!-- Phone
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400 mb-3">Phone <a href="#edit-phone" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">Mobile <span class="text-muted font-weight-500">(Primary)</span></p>
              <p class="col-sm-9"><?php echo $phone;  ?></p>
            </div>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="edit-phone" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Phone</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="phone" method="post">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="mobileNumber">Mobile <span class="text-muted font-weight-500">(Primary)</span></label>
                          <input type="number" name="phone" value="<?php echo $phone;  ?>" class="form-control" data-bv-field="mobilenumber" id="mobileNumber" required placeholder="Mobile Number">
                        </div>
                      </div>
                    </div>
                    <!-- <a class="btn-link text-uppercase d-flex align-items-center text-1 float-right mb-3" href="#"><span class="text-3 mr-1"><i class="fas fa-plus-circle"></i></span>Add another Phone</a> -->
                    <button class="btn btn-primary btn-block" type="submit" name="update_phone">Save Changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Phone End -->

          <!-- Security
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4">
            <h3 class="text-5 font-weight-400 mb-3">Security <a href="#change-password" data-toggle="modal" class="float-right text-1 text-uppercase text-muted btn-link"><i class="fas fa-edit mr-1"></i>Edit</a></h3>
            <div class="row">
              <p class="col-sm-3 text-muted text-sm-right mb-0 mb-sm-3">
                <label class="col-form-label">Password</label>
              </p>
              <p class="col-sm-9">
                <input type="password" class="form-control-plaintext" data-bv-field="password" id="password" value="EnterPassword" readonly>
              </p>
            </div>
          </div>
          <!-- Edit Details Modal
          ================================== -->
          <div id="change-password" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Change Password</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">

                  <form id="changePassword" method="post" onsubmit="myFunction()">
                    <div class="form-group">
                      <label for="existingPassword">Confirm Current Password</label>
                      <input type="password" class="form-control" name="cpwd" data-bv-field="existingpassword" id="existingPassword" required placeholder="Enter Current Password">
                    </div>
                    <div class="form-group">
                      <label for="newPassword">New Password</label>
                      <input type="password" class="form-control" name="npwd" data-bv-field="newpassword" id="newPassword" required placeholder="Enter New Password">
                    </div>
                    <div class="form-group">
                      <label for="confirmPassword">Confirm New Password</label>
                      <input type="password" class="form-control" name="cnpwd" data-bv-field="confirmgpassword" id="confirmPassword" required placeholder="Enter Confirm New Password">
                    </div>
                    <button class="btn btn-primary btn-block mt-4" type="submit" name="change_pwd">Update Password</button>
                  </form>
                  <div id="loader"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- Security End -->

        </div>
        <!-- Middle Panel End -->
      </div>
    </div>
  </div>
  <!-- Content end -->


  <?php include("includes/dashfooter.php") ?>
