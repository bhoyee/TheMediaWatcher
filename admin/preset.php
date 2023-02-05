<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


<?php 
  use Phppot\DataSource;
	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();

  require_once './controller/product-controller.php';

	$dCtrl  =	new ProductsController($conn);

	$ucompanies = $dCtrl->ucomp();


?>



  <!-- Content
  ============================================= -->
  <div id="content" class="py-4">
    <div class="container">
      <div class="row"> 
        <!-- Left Panel
        ============================================= -->

        
        <!-- Middle Panel
        ============================================= -->
        <div class="col-lg-12">
          
          <!-- Notifications
          ============================================= -->
          <div class="bg-light shadow-sm rounded p-4 mb-4">
            <h3 class="text-5 font-weight-400">Reset User Password</h3>
            <p class="text-danger">Password Must Be At Least 8 Digits Long .</p>

            <?php
                           
              if(isset($_POST['resetPwd']))
                {
                    $user = trim($_POST['user']);
                    $pass = trim($_POST['pwd']);
                    $pwd  = md5($pass);

                    $queryReset ="UPDATE users SET pwd ='$pwd' WHERE userID = '$user'";
                   

                    // $querydel = "DELETE FROM users WHERE id='$id'";
                    $query_Reset = query($queryReset);
                    confirm($query_Reset);

                    if($query_Reset)
                    {
                        echo '<script> alert("User Data Deleted"); </script>';
                        // echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                         header("Location:dashboard.php");
                    }
                    else
                    {
                        echo '<script> alert("User Password Updat Successfully"); </script>';
                    }
                }

             ?>
            <hr class="mx-n4">
            <div class="mb-5 clearfix">
            <div class="row justify-content-start">
            <div class="col-12">
          
            <form id="" method="post" action="" onsubmit="myFunction()">

            <div class="mb-5 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Select User Name</label>
                        <div class="col-sm-10">
                             <select class="custom-select" id="user" name="user" >
                                
                                <?php
                                
                                $sqlii = "SELECT userID, username FROM users";
                                $resulti = mysqli_query($con, $sqlii);
                                while ($rowi = mysqli_fetch_array($resulti)) {
                                  $userid = $rowi['userID'];
                                  $uname = $rowi['username']; 
                                  echo '<option value="'.$userid.'">'.$uname.'</option>';

                                }
                                
                                echo '</select>';
                                
                                ?>  
                        
                        </div>
                    </div>
                    <div class="mb-5 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Default Password</label>
                        <div class="col-sm-10">
                        <input type="password" class="form-control" name="pwd" id="inputPassword" minlength="8">
                        </div>
                    </div>
                  
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="resetPwd">Reset Password</button>
                  </form>
                  <div id="loader"></div>

            </div>
            <!-- <div class="col-6">
              
            <a class="btn btn-success" href="user-company.php" role="button"><i class="fa fa-plus"></i> Add User to company</a>

            </div> -->
        </div>
            
              <!-- <a href="#create-company" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Company</a> -->
            </div>


       
        </div>
        <!-- Middle Panel End --> 
      </div>
    </div>
  </div>
  <!-- Content end -->
  <?php include("includes/dashfooter.php") ?>