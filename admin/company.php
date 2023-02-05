<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


<?php 
  use Phppot\DataSource;
	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();

  require_once './controller/product-controller.php';

	$dCtrl  =	new ProductsController($conn);

	$companies = $dCtrl->company();
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
            <h3 class="text-5 font-weight-400">Manage Company</h3>
            <p class="text-muted">Use below to add, edit and delete company </p>

            <?php
               $cDate = date("Y-m-d");
              //  $userID = $_SESSION['userID'];
               
                  // create company

               if (isset($_POST['create_company'])) {
                 
                  $name = trim($_POST['cname']);

                  $sql2 = "INSERT INTO company (name, created_date) VALUES ('$name','$cDate')";
                  // $message = "Record Modified Successfully";
                  $result = query($sql2);
                  confirm($result);
                  if($result){
                  $message = "Company Added Successfully";
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
                  
                  $cname = $_POST['cname'];
                           
                  $query = "UPDATE company SET name='$cname' WHERE id='$id'  ";
                  $query_run = query($query);
                  confirm($query_run);
                  if($query_run)
                  {
                      echo '<script> alert("Company Data Updated Successfully"); </script>';
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

                    $querydel = "DELETE FROM company WHERE id='$id'";
                    $query_del = query($querydel);
                    confirm($query_del);

                    if($query_del)
                    {
                        echo '<script> alert("Company Data Deleted"); </script>';
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
              <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-company">
              <i class="fa fa-plus"></i> Add New Company
              </button>
              <!-- <a href="#create-company" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Company</a> -->
            </div>


                <!-- Edit company Modal
          ================================== -->
          <div id="edit-company-details" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Edit / Update Company Detail</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="" method="post" ">
                    <div class="row">
                      <div class="col-12">
                      <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                          <label for="cname">Company Name</label>
                          <input type="text" name="cname" id="cname" class="form-control"
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
          <!-- End Company Update/Edit Model -->


               <!-- Delete company Modal
          ================================== -->
          <div id="delete-company" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Dalete Company Detail</h5>
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

              <!-- create company Modal
          ================================== -->
          <div id="create-company" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Company Detail</h5>
                  <button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body p-4">
                  <form id="" method="post" onsubmit="myFunction()">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="cname">Company Name</label>
                          <input type="text" value="" class="form-control" data-bv-field="cname" id="cname" name="cname" required placeholder="Enter Company Name">
                        </div>
                      </div>
                                        
                    </div>
                    <button class="btn btn-primary btn-block mt-2" type="submit" name="create_company" id="create_company">Submit</button>
                  </form>
                </div>
                <div id="loader"></div>
              </div>
            </div>
          </div>
          <!-- End Create Company Model -->

        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
				<table class="table table-bordered table-hovered table-striped" id="productTable">
					<thead>
        
            <th></th>
            <th></th>
            <th scope="col">Company Name </th>
            <th scope="col"> Date Created </th>
            <th scope="col"> EDIT </th>
            <th scope="col"> DELETE </th>
				
					</thead>

					<tbody>

					<?php 
					$i = 1;
						foreach($companies as $company) : ?>

							<tr>
              <td style="visibility:hidden;"> <?php echo $company['id']; ?> </td> 

                <td>
                <?php
									echo $i;
									$i++;
								?> 
                </td>

								<td> <?php echo $company['name']; ?> </td>
								<td> <?php echo $company['created_date']; ?> </td>
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

  
  <?php include("includes/dashfooter.php") ?>
  