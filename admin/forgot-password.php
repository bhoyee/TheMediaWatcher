<?php include("includes/header.php") ?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'functions/vendor/autoload.php';

$mail = new PHPMailer(TRUE);

// $con = mysqli_connect("localhost","root","","import_excel");
// if (mysqli_connect_errno()){
// echo "Failed to connect to MySQL: " . mysqli_connect_error();
// die();
// }

?>

        <div class="row no-gutters my-auto">
            <div class="col-10 col-lg-9 mx-auto">
                <h1 class="text-11 text-white mb-4">Forgot Password!</h1>
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
date_default_timezone_set('Asia/Karachi');
$error="";
if(isset($_POST["email"]) && (!empty($_POST["email"]))){

$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);

if (!$email) {
   $error .="<h4 class='text-danger'>Invalid email address please type a valid email address!</h4>";
   }else{
   $sel_query = "SELECT * FROM users WHERE email = '$email'";
   $results = mysqli_query($con,$sel_query);
   $row = mysqli_num_rows($results);
   if ($row==""){
   $error .= "<h4 class='text-danger'>No user is registered with this email address!</h4>";
   }
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a class='btn btn-success text-light' href='javascript:history.go(-1)'>Go Back</a>";
   }else{
   $expFormat = mktime(
   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
   );
   $expDate = date("Y-m-d H:i:s",$expFormat);
   $key = md5(2418*2+(int)$email);
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $key = $key . $addKey;
// Insert Temp Table
// $sql = "UPDATE users SET validation_code = '".escape($validation)."' WHERE email = '".escape($email)."'";

mysqli_query($con, "UPDATE users SET validation_code = '".trim($key)."',expDate ='".trim($expDate)."'WHERE email = '".trim($email)."'");

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="https://themeadiawatcher.com/code.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
https://themeadiawatcher.com/code.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   	
$output.='<p>Thanks,</p>';
$output.='<p>TheMeadiaWatcher Team</p>';
$body = $output; 
$subject = "Password Recovery - TheMeadiaWatcher";

$email_to = $email;
$fromserver = "support@themeadiawatcher.com"; 

$mail->IsSMTP();
$mail->Host = "support@themeadiawatcher.com;rbx105.truehost.cloud"; // Enter your host here
$mail->SMTPAuth = true;
$mail->Username = "support@themeadiawatcher.com"; // Enter your email here
$mail->Password = "p@ssw0rd1234"; //Enter your password here
$mail->Port = 587;
$mail->IsHTML(true);
$mail->From = "support@themeadiawatcher.com";
$mail->FromName = "TheMeadiaWatcher";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
echo "<div class='error'>
<h4 class='text-success'>An email has been sent to your email with instructions on how to reset your password.</h4>
</div><br />
<a class='btn btn-success text-light' href='javascript:history.go(-1)'>Back To Home Page</a>

<br /><br />";
	}
   }
}else{
?>


              <h5 class="font-weight-400 mb-4">Enter your email to reset your password
              </h5>
              <form method="post" action="" name="reset">
                <div class="form-group">
                  <label for="emailAddress">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" required placeholder="Enter Your Email">
                </div>
                <div class="button-group " style="text-align: center;">
                 <button id="submit" name="submit" value="Reset Password" class="btn btn-primary">Submit</button>
                <button id="cancel_submit" name="cancel_submit" value="cancel" class="btn btn-danger ml-3">Cancel</button>
                </div>
                <!-- <input type="hidden" class="hide" name="token" id="token" value="<?php echo token_generator() ?>"> -->

                <!-- <button class="btn btn-primary btn-block my-4" type="submit">Submit</button> -->
              </form>
              <p class="text-3 text-center text-muted mt-3"><a class="btn-link" href="index">Back to home page</a></p>
            </div>
          </div>
        </div>
      </div>
      <!-- Login Form End -->
    </div>
  </div>
</div>

<?php } ?>

<?php include("includes/footer.php") ?>
