<?php include("includes/pdashheader.php") ?>
<?php include("session_timeout.php") ?>
<?php 

    // Database connection
    // include("config/database.php");
    
    if(isset($_POST["submit"])) {
        // Set image placement folder
        $target_dir = "img/";
        // Get file path
        $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);

        // Get file extension
        $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allowed file types
        $allowd_file_ext = array("jpg", "jpeg", "png", "pdf");

        $userID = $_SESSION['userID'];

             

        if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
           $resMessage = array(
               "status" => "alert-danger",
               "message" => "Select image to upload."
           );
        } else if (!in_array($imageExt, $allowd_file_ext)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "Allowed file formats .jpg, .jpeg, .pdf and .png."
            );            
        } else if ($_FILES["fileUpload"]["size"] > 2097152) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File is too large. File size should be less than 2 megabytes."
            );
        } else if (file_exists($target_file)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File already exists."
            );
        } else {

            if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {

              $path= $target_file;
              $type = pathinfo($path, PATHINFO_EXTENSION);
              $data = file_get_contents($path);
              $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

              $sql = "UPDATE boidata set company_logo='$path' WHERE userID= $userID ";

                // $sql = "INSERT INTO users (company_logo) VALUES ('$target_file')";
                $stmt = $con->prepare($sql);
                 if($stmt->execute()){
                    $resMessage = array(
                        "status" => "alert-success",
                        "message" => "Image uploaded successfully."
                    ); 
                    header( "refresh:3;url=index.php" ); 
               
                 }
            } else {
                $resMessage = array(
                    "status" => "alert-danger",
                    "message" => "Image coudn't be uploaded."
                );
            }
        }

    }

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
            <h3 class="text-5 font-weight-400">Profile Image</h3>
            <p class="text-muted">Image uploaded will appear on the profile , reports and invoice</p>
            <p class="text-danger">Note: System will logout after successful upload of the image</p>
             <!-- Display response messages -->
    <?php if(!empty($resMessage)) {?>
    <div class="alert <?php echo $resMessage['status']?>">
      <?php echo $resMessage['message']?>
    </div>
    <?php }?>
  </div>
            
    <form action="" method="post" enctype="multipart/form-data" class="mb-3">
      <h3 class="text-center mb-5">Upload File (only jpeg & jpg)</h3>

      <div class="user-image mb-3 text-center">
        <div style="width: 250px; height: 200px; overflow: hidden; background: #cccccc; margin: 0 auto">
          <img src="..." class="figure-img img-fluid rounded" id="imgPlaceholder" alt="">
        </div>
      </div>

      <div class="custom-file">
        <input type="file" name="fileUpload" class="custom-file-input" id="chooseFile">
        <label class="custom-file-label" for="chooseFile">Select file</label>
      </div>

      <button type="submit" name="submit" class="btn btn-primary btn-block mt-4 mb-5">
        Upload File
      </button>
    </form>

   


          
                </div>
                  
            </div>
          </div>

           


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

    $("#chooseFile").change(function () {
      readURL(this);
    });
  </script>

   
  <!-- Content end --> 
<?php include("includes/dashfooter.php") ?>
  
