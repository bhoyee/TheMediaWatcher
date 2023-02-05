<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>
<?php 
	use Phppot\DataSource;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();
	require_once ('./vendor/autoload.php');
	$_SESSION['station']= '';
	if (isset($_POST["import"])) {

		$allowedFileType = [
			'application/vnd.ms-excel',
			'text/xls',
			'text/xlsx',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];
	
		if (in_array($_FILES["file"]["type"], $allowedFileType)) {
	
			$targetPath = 'uploads/' . $_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
	
			$Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	
			$spreadSheet = $Reader->load($targetPath);
			$excelSheet = $spreadSheet->getActiveSheet();
			$spreadSheetAry = $excelSheet->toArray();
			$sheetCount = count($spreadSheetAry);
			$p_date = date("Y-m-d"); //post date
	
			for ($i = 0; $i <= $sheetCount; $i ++) {
				$date = "";
				if (isset($spreadSheetAry[$i][0])) {
					$date = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
				}
				$time = "";
				if (isset($spreadSheetAry[$i][1])) {
					$time = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
				}
				$brand = "";
				if (isset($spreadSheetAry[$i][2])) {
					$brand = mysqli_real_escape_string($conn, $spreadSheetAry[$i][2]);
				}
				$campaign = "";
				if (isset($spreadSheetAry[$i][3])) {
					$campaign = mysqli_real_escape_string($conn, $spreadSheetAry[$i][3]);
				}
				// $station = "";
				// if (isset($spreadSheetAry[$i][4])) {
				// 	$station = mysqli_real_escape_string($conn, $spreadSheetAry[$i][4]);
				// }
				$medium = "";
				if (isset($spreadSheetAry[$i][5])) {
					$medium = mysqli_real_escape_string($conn, $spreadSheetAry[$i][5]);
				}
				$duaration = "";
				if (isset($spreadSheetAry[$i][6])) {
					$duration = mysqli_real_escape_string($conn, $spreadSheetAry[$i][6]);
				}
				$company = "";
				if (isset($spreadSheetAry[$i][7])) {
					$company = mysqli_real_escape_string($conn, $spreadSheetAry[$i][7]);
				}
	
				$industry = "";
				if (isset($spreadSheetAry[$i][8])) {
					$industry = mysqli_real_escape_string($conn, $spreadSheetAry[$i][8]);
				}
				$language = "";
				if (isset($spreadSheetAry[$i][9])) {
					$language = mysqli_real_escape_string($conn, $spreadSheetAry[$i][9]);
				}
				$program = "";
				if (isset($spreadSheetAry[$i][10])) {
					$program = mysqli_real_escape_string($conn, $spreadSheetAry[$i][10]);
				}
				$region = "";
				if (isset($spreadSheetAry[$i][11])) {
					$region = mysqli_real_escape_string($conn, $spreadSheetAry[$i][11]);
				}

				$rdate = date('Y-m-d', strtotime($date));

                $sname = trim($_POST['sname']);

			  
				if (! empty($rdate) || ! empty($brand)) {
					$query = "insert into data_bank(date,time,brand,campaign,station,medium,duration,company,industry,language,program,region,post_date) values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$paramType = "sssssssssssss";
					$paramArray = array(
						$rdate,
						$time,
						$brand,
						$campaign,
						$sname,
						$medium,
						$duration,
						$company,
						$industry,
						$language,
						$program,
						$region,
						$p_date
	
					);
					$insertId = $db->insert($query, $paramType, $paramArray);
					// $query = "insert into tbl_info(name,description) values('" . $name . "','" . $description . "')";
					// $result = mysqli_query($conn, $query);
	
					if (! empty($insertId)) {
						$_SESSION['station'] = $sname; 

						$type = "success";
						$message = ".$sheetCount . Data Imported into the Database Successfully";
					} else {
						$type = "error";
						$message = "Problem in Importing Excel Data";
					}
				}
			}
		} else {
			$type = "error";
			$message = "Invalid File Type. Upload Excel File.";
		}
	}

	// require_once './config/db-config.php'; 

	require_once './controller/product-controller.php';

	// $db = new DBController();

	// $conn = $db->connect();

	$dCtrl  =	new ProductsController($conn);

	$products = $dCtrl->index();


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
            <h3 class="text-5 font-weight-400">Upload Specific Station Data</h3>
            <p class="text-muted">Use below to upload, edit and delete Data Bank </p>
			<form class="row g-3" action="" method="post" name="frmExcelImport"
               id="frmExcelImport" enctype="multipart/form-data" onsubmit="myFunction()">
				<div class="col-md-6 mb-3">
					<!-- <label for="inputEmail4" class="form-label">Email</label> -->
					<select class="custom-select" id="sname" name="sname" >
                              <option value="">-- Select Station --</option>
                                
                                <?php
                                $sqli = "SELECT id, name FROM station";
                                $result = mysqli_query($con, $sqli);
                                while ($row = mysqli_fetch_array($result)) {
                                  $id = $row['id'];
                                  $name = $row['name']; 
                                  echo '<option value="'.$name.'">'.$name.'</option>';
                                }
                                
                                echo '</select>';
                                
                                ?>
				</div>
				<div class="col-md-6">
				<div class="input-group ">
                  <input class="form-control shadow-none border-0 bg-success text-light" type="file" name="file" id="file" accept=".xls,.xlsx" placeholder="choose excel file..." value="">
                    <div class="input-group-append ml-3"> 
                        <span class="input-group-text bg-white border-0 p-0">
                            <button type="submit" id="submit" name="import"
                            class="btn btn-success mr-3">Import</button>
                        </span> 
                    </div>
                </div>
				</div>
			</form>
          
            <div id="response"
            class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?>
            </div>
        </div>
                  
             <div id="loader"></div>
            </div>
          </div>
          <!-- End Create Company Model -->
		  <section class="section bg-white">
      <div class="container">
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
		<p class="text-6 text-center text-danger mb-3">Only Data Uploaded Today Will Display</p> 

		<?php
                // $connection = mysqli_connect("localhost","root","");
                // $db = mysqli_select_db($conn, 'phpcrud');
				$cDate = date("Y-m-d");
                $stat = $_SESSION['station'];
                $query = "SELECT id,date,time,brand,campaign,station,medium,duration,company,industry,language,program,region FROM data_bank WHERE station = '$stat' AND post_date = '$cDate'";
                $query_run = mysqli_query($con, $query);
				confirm($query_run);
            ?>

		<table class="table table-bordered table-hovered table-striped" id="productTable">
					<thead>
					     <th></th>
						<th> Date </th>
						<th> Time </th>
						<!-- <th> SKU </th> -->
						<th> Brand </th>
						<th> Campaign </th>
						<th> Station</th>
						<th>Medium</th>
						<th>Duration</th>
						<th>Company</th>
						<th>Industry</th>
						<th>Language</th>
						<th> Program</th>
						<th>Region</th>

					</thead>
					<?php  $i = 1;
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                

					<tbody>

				

							<tr>
								<td width="5">
								<?php
									echo $i;
									$i++;
								?> </td>
								<td> <?php echo $row['date']; ?> </td>
								<td> <?php echo $row['time']; ?> </td>
								<td> <?php echo $row['brand']; ?> </td>
								<td> <?php echo $row['campaign']; ?> </td>
								<td> <?php echo $row['station']; ?> </td>
								<td> <?php echo $row['medium']; ?> </td>
								<td> <?php echo $row['duration']; ?> </td>
								<td> <?php echo $row['company']; ?> </td>
								<td> <?php echo $row['industry']; ?> </td>
								<td> <?php echo $row['language']; ?> </td>
								<td> <?php echo $row['program']; ?> </td>
								<td> <?php echo $row['region']; ?> </td>

							</tr>


					</tbody>	
					<?php           
                    }
                }
                else 
                {
                    echo "No Record Found";
                }
            ?>
				</table>
		
		</div>
        </div>
						</div>
						</section>
         
        <!-- Middle Panel End --> 
      </div>
    </div>
  </div>
  <!-- Content end -->
   
  <!-- Content end --> 
  <?php include("includes/dashfooter.php") ?>
  <script>

$(document).ready(function() {
    $('#productTable').DataTable();
});

</script>
  
