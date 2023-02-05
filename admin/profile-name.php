<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


  <!-- Secondary Menu
  ============================================= -->
  <div class="bg-primary">
    <div class="container d-flex justify-content-center">
      <ul class="nav secondary-nav">
      <li class="nav-item"> <a class="nav-link active" href="profile-name.php">Profile </a></li>

        <li class="nav-item"> <a class="nav-link " href="settings.php">Account</a></li>
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
          $sql = "SELECT boidata.fname AS F_Name, boidata.lname AS L_Name, boidata.phone AS phone, boidata.company AS cname, boidata.address AS addres, users.email AS Email, users.username AS uname, users.reg_date AS regDate
          FROM boidata INNER JOIN users ON users.userID = boidata.userID WHERE boidata.userID = $userID ";
          $result = query($sql);
          confirm($result);
          if(row_count($result) > 0){

            $row = fetch_array($result);
          
            $fName    = $row['F_Name'];
            $lName    = $row['L_Name'];
            $cname    =  $row['cname'];
            $email    = $row['Email'];
            $uname    = $row['uname'];
            $phone    = $row['phone'];
            $regDate   = $row['regDate'];
            $address   = $row['addres'];


           
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
            <a href="profile-pix.php"> <div class="profile-thumb-edit custom-file bg-primary text-white" data-toggle="tooltip" title="Change Profile Picture"> <i class="fas fa-camera position-absolute"></i>
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
            <a href="#" class="btn btn-primary btn-block">Chat with Us</a> </div>
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
                                  $target_dir = "img/";
                                  // Get file path
                                  $target_file = $target_dir . basename($_FILES["image"]["name"]);
                          
                                  // Get file extension
                                  $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                  // Allowed file types
                                  $allowd_file_ext = array("jpg", "jpeg", "png");

                                  if (!file_exists($_FILES["image"]["tmp_name"])) {
                                    echo '<script> alert("Select image to upload"); </script>';

                                 } else if (!in_array($imageExt, $allowd_file_ext)) {
                                  echo '<script> alert("Allowed file formats .jpg, .jpeg"); </script>';
           
                                 } else if ($_FILES["image"]["size"] > 2097152) {
                                  echo '<script> alert("File is too large. File size should be less than 2 megabytes."); </script>';

                                 } else if (file_exists($target_file)) {
                                  echo '<script> alert("File already exists."); </script>';

                                 }else {

                                  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                      
                                    $path= $target_file;
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    
                                    $sql = "UPDATE boidata set fname='" . $_POST['first_name'] . "', lname='" . $_POST['last_name'] . "', phone='" . $_POST['phone'] . "', company='" . $_POST['cname'] . "', address='" . $_POST['address'] . "',company_logo='$path' WHERE userID= $userID ";

                                    // $sql = "UPDATE boidata set company_logo='$path' WHERE userID= $userID ";
                      
                                      // $sql = "INSERT INTO users (company_logo) VALUES ('$target_file')";
                                      // $stmt = $con->prepare($sql);
                                       if(   $result = query($sql)){
                                        echo '<script> alert("Data Updated Successfully"); </script>';

                                         $script = "<script>
                                          window.location = 'index.php';</script>";
                                          echo $script;
                                        

                                       }
                                  } else {
                                    echo '<script> alert("Something Went wrong"); </script>';

                                  }

                              }

                               
                              }

                        
                              

                                ?>


          </div>
          <!-- Personal Details
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
      
              <!-- Display response messages -->
              <?php if(!empty($resMessage)) {?>
              <div class="alert <?php echo $resMessage['status']?>">
                <?php echo $resMessage['message']?>
              </div>
              <?php }?>
            <h3 class="text-6 font-weight-500 mb-5">Personal Details </h3>
            <p class="text-5 font-weight-400 mb-5">Update your personal Information</p>
           
            <div class="row">
            <form action="" method="post" enctype="multipart/form-data" onsubmit="myFunction()">

                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="firstName">First Name</label>
                          <input type="text" value="<?php echo $fName;  ?>" class="form-control" data-bv-field="firstName" id="firstName" name="first_name" required placeholder="First Name">
                        </div>
                      </div>
                      <div class="col-12">
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
                          <label for="phone">Company Name</label>
                          <input id="cname" name="cname" value="<?php echo $cname;  ?>" type="text" class="form-control" required placeholder="Company Name">
                        </div>
                      </div>
                      <!-- <div class="col-12">
                        <div class="form-group">
                          <label for="phone">Company logo</label>
                          <input type="file" name="image" style="margin-top:-115px;">

                           <input id="clogo" name="clogo" value="<?php echo $clogo;  ?>" type="text" class="form-control" required placeholder="Company Logo">
                        </div>
                      </div> -->

                     

                      <div class="col-12">
                        <div class="form-group">
                        <div class="user-image mb-3 text-center">
                        <div style="width: 100px; height: 100px; overflow: hidden; background: #cccccc; margin: 0 auto">
                          <img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
                        </div>
                      </div>
                          <label for="phone">Company logo</label>
                          <div class="input-group mb-3">
                          <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">Company Logo</button>
                          <input type="file" class="form-control" name="image" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                        </div>
                          <!-- <input id="clogo" name="clogo" value="<?php echo $clogo;  ?>" type="text" class="form-control" required placeholder="Company Logo"> -->
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="phone">Company Address</label>
                          <input id="address" name="address" value="<?php echo $address;  ?>" type="text" class="form-control" required placeholder="Company Address">

                          <!-- <input id="clogo" name="clogo" value="<?php echo $clogo;  ?>" type="text" class="form-control" required placeholder="Company Logo"> -->
                        </div>
                      </div>


                    </div>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="update_personal" value="update_personal">Save Changes</button>
                  </form>
         
            </div>
            
          </div>
          <div id="loader"></div>
        </div>
        <!-- Middle Panel End -->
      </div>
    </div>
  
  <!-- Content end -->

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#imgPlaceholder').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    $("#inputGroupFile03").change(function () {
      readURL(this);
    });
  </script>
  <?php include("includes/dashfooter.php") ?>
