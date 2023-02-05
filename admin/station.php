<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


<?php 
  use Phppot\DataSource;
	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();

  require_once './controller/product-controller.php';

	$dCtrl  =	new ProductsController($conn);

	$stations = $dCtrl->station();


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
            <h3 class="text-5 font-weight-400">Manage Station</h3>
            <p class="text-muted">Use below to add, edit and delete station </p>

            <?php
               $cDate = date("Y-m-d");
              //  $userID = $_SESSION['userID'];
               
                  // create company

               if (isset($_POST['create_station'])) {
                 
                  $name = trim($_POST['sname']);

                  $sql2 = "INSERT INTO station (name, created_date) VALUES ('$name','$cDate')";
                  // $message = "Record Modified Successfully";
                  $result = query($sql2);
                  confirm($result);
                  if($result){
                  $message = "Station Added Successfully";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                  }
                  else{
                  $message = "Something went wrong";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  }
               }

              //  update company
              if(isset($_POST['updatedata']))
              {   
                  $id = $_POST['update_id'];
                  
                  $sname = $_POST['sname'];
                           
                  $query = "UPDATE station SET name='$sname' WHERE id='$id'  ";
                  $query_run = query($query);
                  confirm($query_run);
                  if($query_run)
                  {
                      echo '<script> alert("Station Data Updated Successfully"); </script>';
                      echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                    }
                  else
                  {
                      echo '<script> alert("Something went wrong"); </script>';
                  }
              }

              //Delete company

              if(isset($_POST['deletedata']))
                {
                    $id = $_POST['delete_id'];

                    $querydel = "DELETE FROM station WHERE id='$id'";
                    $query_del = query($querydel);
                    confirm($query_del);

                    if($query_del)
                    {
                        echo '<script> alert("Station Data Deleted"); </script>';
                        echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                        // header("Location:index.php");
                    }
                    else
                    {
                        echo '<script> alert("Data Not Deleted"); </script>';
                    }
                }

             ?>
            <hr class="mx-n4">
            <div class="mb-5 clearfix">
              <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-station">
              <i class="fa fa-plus"></i> Add New Station
              </button>
              <!-- <a href="#create-company" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Company</a> -->
            </div>


                <!-- Edit station Modal
          ================================== -->
          <div id="edit-station-details" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Edit / Update Station Detail</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="" method="post" ">
                    <div class="row">
                      <div class="col-12">
                      <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                          <label for="sname">Company Name</label>
                          <input type="text" name="sname" id="sname" class="form-control"
                                placeholder="Enter Course">
                          <!-- <input type="text" value="" class="form-control" data-bv-field="cname" id="cname" name="cname" required placeholder="Enter Company Name"> -->
                        </div>
                      </div>
                                        
                    </div>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="updatedata">Update Record</button>
                  </form>
                </div>
                <div id="loader"></div>
              </div>
            </div>
          </div>
          <!-- End station Update/Edit Model -->


               <!-- Delete station Modal
          ================================== -->
          <div id="delete-station" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Dalete Station Detail</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="" method="post" ">
                    <div class="row">
                      <div class="col-12">
                      <input type="hidden" name="delete_id" id="delete_id">
                      <h4> Do you want to Delete this Data ??</h4>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                        <button type="submit" name="deletedata" class="btn btn-danger"> Yes !! Delete it. </button>
                    </div>
                  </form>
                </div>
                <div id="loader"></div>
              </div>
            </div>
          </div>
          <!-- End Company Delete Model -->

              <!-- create station Modal
          ================================== -->
          <div id="create-station" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Station Detail</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="" method="post" onsubmit="myFunction()">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="cname">Station Name</label>
                          <input type="text" value="" class="form-control" data-bv-field="sname" id="sname" name="sname" required placeholder="Enter Company Name">
                        </div>
                      </div>
                                        
                    </div>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="create_station" id="create_station">Submit</button>
                  </form>
                </div>
                <div id="loader"></div>
              </div>
            </div>
          </div>
          <!-- End Create Station Model -->

        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
				<table class="table table-bordered table-hovered table-striped" id="stationTable">
					<thead>
        
            <th></th>
            <th></th>
            <th scope="col">Station Name </th>
            <th scope="col"> Date Created </th>
            <th scope="col"> EDIT </th>
            <th scope="col"> DELETE </th>
				
					</thead>

					<tbody>

					<?php 
					$i = 1;
						foreach($stations as $station) : ?>

							<tr>
              <td style="visibility:hidden;"> <?php echo $station['id']; ?> </td> 

                <td>
                <?php
									echo $i;
									$i++;
								?> 
                </td>

								<td> <?php echo $station['name']; ?> </td>
								<td> <?php echo $station['created_date']; ?> </td>
                <td>
                  <a href="#" class="mr-3 editbtn" title="Update Record "><span class="fa fa-pencil"></span></a>
                </td>
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
          <!-- Notifications End --> 
          
        </div>
        <!-- Middle Panel End --> 
      </div>
    </div>
  </div>
  <!-- Content end -->

  
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
            <!-- <li class="nav-item"> <a class="nav-link" href="#">Careers</a></li> -->
            <li class="nav-item"> <a class="nav-link" href="#">Affiliate</a></li>
            <!-- <li class="nav-item"> <a class="nav-link" href="#">Fees</a></li> -->
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
	document.getElementById("loader").style.display = "inline"; // to undisplay
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

                $('#delete-station').modal('show');

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
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#edit-station-details').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#sname').val(data[2]);
             
            });
        });
    </script>
    <script>

$(document).ready(function() {
    $('#stationTable').DataTable(
   
    );
});

</script>


</body>
</html>

  