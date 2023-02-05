<?php
//======
//====== HELPER FUNCTIONS ------------------------------------------------------
//======
function clean($string){
    return htmlentities($string);
}
function redirect($location){

    return header("Location: {$location}");
}
function set_message($message){
    if(!empty($message)){
        $_SESSION['message'] = $message;
    }
    else{
        $message = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
function token_generator(){
    $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    return $token;
}

function validation_errors($error_message){
    $alert_error_message = "
    <div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong>
    {$error_message}
    </div>
    ";
    return $alert_error_message;
}

//chck email duplicate
function email_exists(){
    $sql = "SELECT userID FROM users ";
    $result = query($sql);
    confirm($result);

    if(row_count($result) >= 1){
        $row = fetch_array($result);
        $_SESSION['userID'] = $row['userID'];
        return true;
    }
    return false;
}


function send_email($to, $subject, $msg, $headers){
    return mail($to, $subject, $msg, $headers);
}

//======
//====== VALIDATION FUNCTIONS --------------------------------------------------
//======


function validate_user_registration(){

    $errors = [];

    $min = 8;
    $max = 50;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        sleep(3); // cause delay in execution of code

        $uName          = clean($_POST['uName']);
        $email             = clean($_POST['email']);
        $pwd               = clean($_POST['pwd']);


        if(email_exists()){
            $errors[] = "Sorry only one admin can exit. Please contact Super admin";
        }

       $errors = validate_length($errors, $pwd, "password", $min, $max);

        if(!empty($errors)){
            foreach($errors as $error){
                echo validation_errors($error);
            }
        }
        else{
            if(register_user($uName, $email, $pwd)){

                set_message("<p class='bg-success text-center text-white py-3'> Registration Successful. You can now login</p>");
                // redirect("reg.php");
            }
            else{
                set_message("<p class='bg-danger text-center'> Sorry, we could not register you.</p>");
                // redirect("register.php");
            }
        }
    }
}

function validate_length($errors, $string, $label, $min, $max){

    if(strlen($string) < $min){
        $errors[] = "Your {$label} cannot be less than {$min} characters";
    }
    else if(strlen($string) > $max){
        $errors[] = "Your {$label} cannot be greater than {$max} characters";
    }

    return $errors;
}



//======
//====== REGISTER USER FUNCTIONS -----------------------------------------------
//======


  function register_user($uName, $email, $pwd){

    $uName = escape($uName);
    $email      = escape($email);
    $pwd   = escape($pwd);
    // $refer   = escape($refer);


    if(email_exists()){
        return false;
    }

    $userId = substr(number_format(time() * rand(),0,'',''),0,8);
    $userId = (int)$userId;
    $date = date('Y-m-d H:i:s');
    $pwd = md5($pwd);
    // $validation = md5((int)$userId + (int)microtime());
    // $activity = "Registered";
    // $date_visit = date("Y-m-d H:i:s");
    $role = 'admin';
    // $verify_status = 'Not Verify';





    //insert into users table
    $sql = "INSERT INTO users (userID, username, email, pwd, role, reg_date) ";
    $sql.= "values ('{$userId}','{$uName}','{$email}', '{$pwd}', '{$role}','{$date}')";


    //insert into biodata
    $sql2 = "INSERT INTO boidata (userID)";
    $sql2.= "values ('{$userId}')";

    //insert into logHistory
    // $sql3 = "INSERT INTO logg (date_visit, activity, userId)";
    // $sql3.= "values ('{$date_visit}', '{$activity}', '{$userId}')";

    $result = query($sql);
     $result2 = query($sql2);

    // $result3 = query($sql3);
    confirm($result);
     confirm($result2);

    // confirm($result3);

    return true;

}

//======
//====== VALIDATE USER LOGIN FUNCTIONS -----------------------------------------
//======

function validate_user_login(){
    $errors = [];

    $min = 8;
    $max = 50;

    if(!isset($_POST['email']) && !isset($_POST['pwd'])){
        return;
    }

    $email        = clean($_POST['email']);
    $pwd          = clean($_POST['pwd']);


    if(empty($email)){
        $errors[] = "Email / User Name field cannot be empty.";
    }

    if(empty($pwd)){
        $errors[] = "Password field cannot be empty.";
    }


    if(!empty($errors)){
        foreach($errors as $error){
            echo validation_errors($error);
        }
    }
    else{

      if(login_user($email, $pwd)){

          redirect("dashboard");
        
        }
      else{
          echo validation_errors("Your credentials are not correct");
      }

    }
}

//======
//====== USER LOGIN FUNCTIONS --------------------------------------------------
//======

// 
function login_user($email, $password){
    $sql = "SELECT users.userID AS userID, users.username AS userName, users.email AS email, users.pwd AS password, users.status AS status, boidata.company AS company, boidata.fname AS fName, boidata.lname AS LName, boidata.phone AS phone, boidata.company_logo AS logo, boidata.address AS addres FROM users INNER JOIN boidata ON users.userID = boidata.userID WHERE users.email = '".escape($email)."' OR users.username = '".escape($email)."' AND users.role = 'admin'";

    // $sql = "SELECT pwd, userID, email FROM users WHERE email = '".escape($email)."' OR username = '".escape($uName)."' AND role = 'admin'";
    $result = query($sql);
    if(row_count($result) == 1){
        $row = fetch_array($result);

        $pwd = $row['password'];
        $userID = $row['userID'];
        $uname = $row['userName'];
        $email = $row['email'];
        $fname = $row['fName'];
        $lname = $row['LName'];
        $company = $row['company'];
        $status = $row['status'];
        $tel    = $row['phone'];
        $img   = trim($row['logo']);
        $address  = trim($row['addres']);

        if(md5($password) == $pwd){

            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['userID'] = $userID;
            $_SESSION['uname'] = $uname;
            $_SESSION['email'] = $email;
            $_SESSION['company'] = $company;
            $_SESSION['status']  = $status;
            $_SESSION['phone']  = $tel;
            $_SESSION['img']  = $img;
            $_SESSION['address']  = $address;

            $_SESSION['last_login_timestamp'] = time();

            // if($remember == "on"){
            //     setcookie('email', $email, time() + 1200);
            // }

             // $_SESSION['email'] = $email;

            return true;
        }
        
      

    }

    return false;
}
//======
//====== LOGGED IN FUNCTION ----------------------------------------------------
//======

function logged_in(){
    if(isset($_SESSION['email']) || isset($_SESSION['uname']) ){
    //  echo $_SESSION["uname"];
    //   echo $_SESSION['first_name'];
        return true;
    }
    else{
        return false;
    }
}


//======

//======
 /// ====== CHANGE PASSWORD ==========================================

   //change passowrd
   function change_pwd(){
    $userID    = $_SESSION['userID'];
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      sleep(3); // cause delay in execution of code

      $old_pwd           = clean($_POST['cpwd']);
      $new_pwd           = clean($_POST['npwd']);
      $re_pwd            = clean($_POST['cnpwd']);

      if ($old_pwd == '') {
        $errors[] = "Current Password field is required!";
      } elseif ($new_pwd == '') {
          $errors[] = "New Password field is required!";
      } elseif ($re_pwd == '') {
          $errors[] = "Please confirm your new password!";
      } elseif ($new_pwd != $re_pwd) {
          $errors[] = 'Password confirmation does not match with new password!';
      } elseif ($old_pwd == $new_pwd) {
          $errors[] = 'New Password and current password can not be the same!';
      }
         // hash old and new passwords
        $oldpass=md5($old_pwd);
        $newpassword=md5($new_pwd);
        $sql = "SELECT pwd FROM users WHERE userID = '$userID'";
        $result = query($sql);
        confirm($result);

            if(row_count($result) > 0){
              $row = fetch_array($result);
              $pwd    = $row['pwd'];

              if ($oldpass == $pwd){
                if($new_pwd == $re_pwd) {

                              $sql_new = "UPDATE users SET pwd = '$newpassword' WHERE userID = $userID";
                              $result_update = query($sql_new);
                              confirm($result_update);

                              if($result_update){
                                set_message("<p class='bg-success text-center text-white p-2'><strong>Password Changed Successfully !!</strong></p>");
                                header( "refresh:2; url=.\index.php" ); // this will refresh and redirect 

                                // redirect("..\login.php");
                               }
                              else{
                               set_message("<p class='bg-danger text-center text-white p-2'> Sorry, Something went wrong you can't change your password.</p>");
                              }
                            }
                          }
                          else {
                            set_message("<p class='bg-danger text-center text-white p-2'> Current passowrd wrong.</p>");

                          }
                        }
                      }
                if(!empty($errors)){
                  foreach($errors as $error){
                  echo validation_errors($error);
                  }
                }
              }
//==== END OF CHANGE PASSWORD ====
            
//====== RECOVER PASSWORD ------------------------------------------------------
//======
//
function recover_password(){
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token'])
        {
            $email = clean($_POST['email']);

            if(email_exists($email)){
                $validation = md5((int)$email + (int)microtime());

                setcookie('temp_access_code', $validation, time() + 900);

                $sql = "UPDATE users SET validation_code = '".escape($validation)."' WHERE email = '".escape($email)."'";
                $result = query($sql);
                confirm($result);

                $to=$email;
                $subject = "Please reset your password.";
                $message = "<strong><h2>Password Reset! </h2></strong>

                <p>  Here is your password reset code:<h4 style='background-color:red; color:white; padding: 10px 10px;'><strong> {$validation} </strong></h4><br/>
                Please   <a href='https://themeadiawatcher.com/admin/code.php?email=$to&code=validation' target='_blank'>
                    click here
                  </a> or button below to reset your password <br/><br/>

                 <br/><br />

            <table width='100%' cellspacing='0' cellpadding='0'>
              <tr>
                  <td>
                      <table cellspacing='0' cellpadding='0'>
                          <tr>
                              <td style='border-radius: 2px;' bgcolor='#7eca9c'>
                                  <a href='https://themeadiawatcher.com/admin/index.php/code.php?email=$to&code=validation' target='_blank' style='padding: 8px 12px; border: 1px solid #7eca9c;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;'>
                                      Reset Password Now
                                  </a>
                              </td>
                          </tr>
                      </table>
                  </td>
              </tr>
            </table>

                ";

                $headers = 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                $headers .= "From: noreply@themeadiawatcher.com";

                if(!send_email($to, $subject, $message, $headers)){
                  echo validation_errors("Email count not be send");

                }
                else {
                  set_message("<p class='alert bg-success text-center text-white p-3'>Please check your email (including spam folder) for a password reset code.</p>");

                }
                // header( "refresh:5; url=index.php" );
                 // redirect("index.php");
            }
            else{
                echo validation_errors("This email does not exist");
            }
        }

    }
    else{//redirect if the token is invalid
        //redirect("index.php");//this seems to cause problems while testing
    }

    if(isset($_POST['cancel_submit'])){
        redirect("index.php");
    }
}
//======
//====== CODE VALIDATION -------------------------------------------------------
//======
function validate_code(){
    if(isset($_COOKIE['temp_access_code'])){
        if(!isset($_GET['email']) && !isset($_GET['code'])){
            redirect("index.php");
        }
        else if(empty($_GET['email']) || empty($_GET['code'])){
            redirect("index.php");
        }
        else{
            if(isset($_POST['code'])){
                $email = clean($_GET['email']);
                $validation_code = clean($_POST['code']);
                $sql = "SELECT userID FROM users WHERE validation_code = '".escape($validation_code)."' AND email = '".escape($email)."'";
                $result = query($sql);

                if(row_count($result) == 1){
                    setcookie('temp_access_code', $validation_code, time() + 300);
                    redirect("reset.php?email=$email&code=$validation_code");
                }
                else{
                    echo validation_errors("Sorry, wrong validation code");
                }
            }
        }

    }
    else{
        set_message("<p class='alert text-white p-3 bg-danger text-center'>Sorry your validation cookie was expired.</p>");
          // redirect(".\forgot-password.php");
    }
}

//======
//====== PASSWORD RESET --------------------------------------------------------
//======

function password_reset(){
    if(isset($_COOKIE['temp_access_code'])){

        if( isset($_GET['email']) && isset($_GET['code']) ){
            if( isset($_SESSION['token']) && isset($_POST['token']) ){
                if($_POST['token'] === $_SESSION['token']){

                    if($_POST['password'] === $_POST['confirm_password']){
                        $updated_password = md5($_POST['password']);


                        $sql = "UPDATE users SET pwd='".escape($updated_password)."', validation_code = 0 WHERE email ='".escape($_GET['email'])."'";
                        query($sql);

                        $userId = $_SESSION['userID'];
                        $activity = "loggedIn Password Changed";
                        // log_hostory($activity, $userId);

                        set_message("<p class='alert text-white p-3 bg-success text-center'>Your password has been updated, please login.</p>");
                        redirect("index");
                    }
                    else {
                      echo validation_errors("Your passwords do not match.");
                    }


                }
            }
        }
    }
    else{
        set_message("<p class='alert text-white p-3 bg-danger text-center'> Sorry your time has expired.  </p>");
        redirect("forgot-password");
    }



}
?>
