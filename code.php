<?php include("includes/header.php") ?>
<?php
$error='';
?>
     <div class="row no-gutters my-auto">
            <div class="col-10 col-lg-9 mx-auto">
                <h1 class="text-11 text-white mb-4">Password Reset!</h1>
                <p class="text-4 text-white line-height-4 mb-5">You can't access your account right ? Don't worry, We gat your back to get full access to your account back at no time</p>
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
<?php

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) 
&& ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:s");
  $query = mysqli_query($con,
  "SELECT * FROM users WHERE validation_code ='$key' AND email='$email';"
  );
  $row = mysqli_num_rows($query);
  if ($row==""){
  $error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link
from the email, or you have already used the key in which case it is 
deactivated.</p>
<p><a href="https://themeadiawatcher.com">
Click here</a> to reset password.</p>';
	}else{
  $row = mysqli_fetch_assoc($query);
  $expDate = $row['expDate'];
  if ($expDate >= $curDate){
  ?>
  <br />
  <h5 class="font-weight-400 mb-4">Enter New Password </h5>
  <form method="post" action="" name="update">
  <input type="hidden" name="action" value="update" />
  <br /><br />
  <label><strong>Enter New Password:</strong></label><br />
  <input type="password" class="form-control" name="pass1" maxlength="15" required />
  <br /><br />
  <label><strong>Re-Enter New Password:</strong></label><br />
  <input type="password" class="form-control" name="pass2" maxlength="15" required/>
  <br /><br />
  <input type="hidden" name="email" value="<?php echo $email;?>"/>
  <input type="submit" class="btn btn-primary" value="Reset Password" />
  </form>
<?php
}else{
$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which 
as valid only 24 hours (1 days after request).<br /><br /></p>";
            }
      }
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  }			
} // isset email key validate end


if(isset($_POST["email"]) && isset($_POST["action"]) &&
 ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:s");
if ($pass1!=$pass2){
$error.= "<h4 class='text-danger'>Password do not match, both password should be same.<br /><br /></h4>";
}
  if($error!=""){

echo "<div class='error'>".$error."</div>
   <br /><a class='btn btn-success text-light' href='javascript:history.go(-1)'>Go Back</a>";


}else{
$pass1 = md5($pass1);
mysqli_query($con,
"UPDATE users SET pwd='$pass1' WHERE email='$email';"
);


echo '<div class="error"><h6>Congratulations! Your password has been updated successfully.</h6>
<p><a href="https://themeadiawatcher.com/login">
Click here</a> to Login.</p></div><br />';
	  }		
}
?>
<?php include("includes/footer.php") ?>