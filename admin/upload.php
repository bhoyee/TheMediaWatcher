<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>
<?php 
	use Phppot\DataSource;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();
	require_once ('./vendor/autoload.php');

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
				$rtime = "";
				if (isset($spreadSheetAry[$i][1])) {
					$rtime = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
				}
				$brand = "";
				if (isset($spreadSheetAry[$i][2])) {
					$brand = mysqli_real_escape_string($conn, $spreadSheetAry[$i][2]);
				}
				$adtype = "";
				if (isset($spreadSheetAry[$i][3])) {
					$adtype = mysqli_real_escape_string($conn, $spreadSheetAry[$i][3]);
				}
				$campaign = "";
				if (isset($spreadSheetAry[$i][4])) {
					$campaign = mysqli_real_escape_string($conn, $spreadSheetAry[$i][4]);
				}
				$station = "";
				if (isset($spreadSheetAry[$i][5])) {
					$station = mysqli_real_escape_string($conn, $spreadSheetAry[$i][5]);
				}
				$medium = "";
				if (isset($spreadSheetAry[$i][6])) {
					$medium = mysqli_real_escape_string($conn, $spreadSheetAry[$i][6]);
				}
				$duaration = "";
				if (isset($spreadSheetAry[$i][7])) {
					$duration = mysqli_real_escape_string($conn, $spreadSheetAry[$i][7]);
				}
				$company = "";
				if (isset($spreadSheetAry[$i][8])) {
					$company = mysqli_real_escape_string($conn, $spreadSheetAry[$i][8]);
				}
	
				$industry = "";
				if (isset($spreadSheetAry[$i][9])) {
					$industry = mysqli_real_escape_string($conn, $spreadSheetAry[$i][9]);
				}
				$language = "";
				if (isset($spreadSheetAry[$i][10])) {
					$language = mysqli_real_escape_string($conn, $spreadSheetAry[$i][10]);
				}
				$program = "";
				if (isset($spreadSheetAry[$i][11])) {
					$program = mysqli_real_escape_string($conn, $spreadSheetAry[$i][11]);
				}
				$region = "";
				if (isset($spreadSheetAry[$i][12])) {
					$region = mysqli_real_escape_string($conn, $spreadSheetAry[$i][12]);
				}

				$rdate = date('Y-m-d', strtotime($date));
				
                 $times = strtotime($rtime);
				// convert 12hrs to 24hrs
				 $time = trim(date("H:i:s", strtotime($rtime)));

				//   $time = date('h:i:s A', $times);

				//$time = trim($rtime);

			  
				if (! empty($rdate) || ! empty($brand)) {
					$query = "insert into data_bank(date,time,brand,adtype,campaign,station,medium,duration,company,industry,language,program,region,post_date) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$paramType = "ssssssssssssss";
					$paramArray = array(
						$rdate,
						$time,
						$brand,
						$adtype,
						$campaign,
						$station,
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
<?php
                            
			  $role ='user';
			
			

			 //Delete company

			 if(isset($_POST['deletedata']))
			   {
				   $id = $_POST['delete_id'];

				   $querydel ="DELETE FROM data_bank
				   WHERE id='$id'";

				   // $querydel = "DELETE FROM users WHERE id='$id'";
				   $query_del = query($querydel);
				   confirm($query_del);

				   if($query_del)
				   {
					   echo '<script> alert("Data Deleted Successfully"); </script>';
					   echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
					   // header("Location:index.php");
				   }
				   else
				   {
					   echo '<script> alert("Data Not Deleted"); </script>';
				   }
			   }

			?>
 
       <!-- Delete company Modal
          ================================== -->
          <div id="delete-client" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Dalete Client/User Detail</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="" method="post" onsubmit="myFunction()">
                    <div class="row">
                      <div class="col-12">
                      <input type="hidden" name="delete_id" id="delete_id">
                      <h4> Do you want to Delete this Data ??</h4>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                        <button type="submit" name="deletedata" id="deletedata" class="btn btn-danger"> Yes !! Delete it. </button>
                    </div>
                  </form>
                </div>
                <div id="loader"></div>
              </div>
            </div>
          </div>
          <!-- End Company Delete Model -->

  <!-- Page Header
  ============================================= -->
  <section class="hero-wrap section">
    <div class="hero-mask opacity-9 bg-success"></div>
    <div class="hero-bg" style="background-image:url('./images/bg/image-2.jpg');"></div>
    <div class="hero-content">
      <div class="container">
        <div class="row align-items-center text-center">
          <div class="col-12">
            <h1 class="text-11 text-white mb-3">Upload Data Into Database (Excel Doc)</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-6 mx-auto">
          <form action="" method="post" name="frmExcelImport"
            id="frmExcelImport" enctype="multipart/form-data" onsubmit="myFunction()">
            <div class="input-group">
     
              <input class="form-control shadow-none border-0" type="file" name="file" id="file" accept=".xls,.xlsx" placeholder="choose excel file..." value="">
              <div class="input-group-append"> <span class="input-group-text bg-white border-0 p-0">
              <button type="submit" id="submit" name="import"
                    class="btn btn-success mr-3">Import</button>
                </span> 
              </div>
            </div>
          </form>
            
            <div id="response"
            class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?>
            </div>
	
          </div>
        </div>
      </div>
    </div>
	<div id="loaders"></div>
  </section>
  <!-- Page Header end --> 
  
  <!-- Content
  ============================================= -->
  <div id="content">
    
   
    
    <!-- Popular Topics
    ============================================= -->
    <section class="section bg-white">
      <div class="container">
        <!-- <h2 class="text-9 text-center">Only Data Uploaded Today Will Display</h2> -->
        <p class="text-6 text-center text-danger mb-5">Only Data Uploaded Today Will Display</p> 
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
				<table class="table table-bordered table-hovered table-striped" id="productTable">
					<thead>
						<th></th>
					     <th></th>
						<th> Date </th>
						<th> Time </th>
						<!-- <th> SKU </th> -->
						<th> Brand </th>
						<th> AdType </th>
						<th> Campaign </th>
						<th> Station</th>
						<th>Medium</th>
						<th>Duration</th>
						<th>Company</th>
						<th>Industry</th>
						<th>Language</th>
						<th> Program</th>
						<th>Region</th>
						<th scope="col"> DELETE </th>
					</thead>

					<tbody>

					<?php 
					$i = 1;
						foreach($products as $product) : ?>

							<tr>
							<td style="visibility:hidden;"> <?php echo $product['id']; ?> </td> 
								<td width="5">
								<?php
									echo $i;
									$i++;
								?> </td>
								<td> <?php echo $product['date']; ?> </td>
								   <td><?php 
                                     $time = $product['time'];
                                     // 24-hour time to 12-hour time 
                                     $newTime  = date("g:i:s A", strtotime($time));
                                     echo $newTime ?></td>
							
								<td> <?php echo $product['brand']; ?> </td>
								<td> <?php echo $product['adtype']; ?> </td>
								<td> <?php echo $product['campaign']; ?> </td>
								<td> <?php echo $product['station']; ?> </td>
								<td> <?php echo $product['medium']; ?> </td>
								<td> <?php echo $product['duration']; ?> </td>
								<td> <?php echo $product['company']; ?> </td>
								<td> <?php echo $product['industry']; ?> </td>
								<td> <?php echo $product['language']; ?> </td>
								<td> <?php echo $product['program']; ?> </td>
								<td> <?php echo $product['region']; ?> </td>
								<td> 
                  <a href="#" class="mr-3 deletebtn" title="Delete Record "><span class="fa fa-trash-can text-danger"></span></a>
                </td>
							</tr>


						<?php endforeach; ?>	
					</tbody>	
				</table>
			</div>
        </div>
      </div>
    </section>
    <!-- Popular Topics end -->
    
       
  </div>
  
 <!-- Footer
  ============================================= -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg d-lg-flex align-items-center">
          <ul class="nav justify-content-center justify-content-lg-start text-3">
            <li class="nav-item"> <a class="nav-link active" href="#">About Us</a></li>
            <li class="nav-item"> <a class="nav-link" href="#">Support</a></li>
            <li class="nav-item"> <a class="nav-link" href="#">Help</a></li>
            <li class="nav-item"> <a class="nav-link" href="#">Careers</a></li>
            <li class="nav-item"> <a class="nav-link" href="#">Affiliate</a></li>
            <li class="nav-item"> <a class="nav-link" href="#">Fees</a></li>
          </ul>
        </div>
        <div class="col-lg d-lg-flex justify-content-lg-end mt-3 mt-lg-0">
          <ul class="social-icons justify-content-center">
            <li class="social-icons-facebook"><a data-toggle="tooltip" href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
            <li class="social-icons-twitter"><a data-toggle="tooltip" href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
            <li class="social-icons-google"><a data-toggle="tooltip" href="http://www.google.com/" target="_blank" title="Google"><i class="fab fa-google"></i></a></li>
            <li class="social-icons-youtube"><a data-toggle="tooltip" href="http://www.youtube.com/" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="footer-copyright pt-3 pt-lg-2 mt-2">
        <div class="row">
          <div class="col-lg">
          <p class="text-center text-lg-left mb-2 mb-lg-0">Copyright &copy; 2022 <a href="#">TheMediaWatcher</a>. All Rights Reserved.</p>
          </div>
          <div class="col-lg d-lg-flex align-items-center justify-content-lg-end">
            <ul class="nav justify-content-center">
              <li class="nav-item"> <a class="nav-link active" href="#">Security</a></li>
              <li class="nav-item"> <a class="nav-link" href="#">Terms</a></li>
              <li class="nav-item"> <a class="nav-link" href="#">Privacy</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer end -->

</div>
<!-- Document Wrapper end -->

<!-- CDN jQuery Datatable -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	
	<script>
	function myFunction() {
	var spinner = $('#loader');
	document.getElementById("loaders").style.display = "inline"; // to undisplay
  
	}
	</script>

	<!-- php do not refresh page after submit post -->
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>

<!-- Back to Top
============================================= -->
<a id="back-to-top" data-toggle="tooltip" title="Back to Top" href="javascript:void(0)"><i class="fa fa-chevron-up"></i></a>

<!-- <script src="..\..\vendor\jquery\jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="js/theme.js"></script>

<script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#delete-client').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[0]);

             
            });
        });
    </script>

    <script>

$(document).ready(function() {
    $('#productTable').DataTable(
   
    );
});

</script>


</body>
</html>

  