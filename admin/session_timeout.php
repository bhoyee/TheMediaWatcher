<?php
   if(isset($_SESSION["email"]) )
   {
        if((time() - $_SESSION['last_login_timestamp']) > 600) // 900 = 15 * 60
        {
             session_destroy();
             header("location:logout.php");
        }

   }

   ?>
