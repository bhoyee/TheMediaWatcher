<?php include("includes/dashheader.php") ?>
<?php include 'filesLogic.php';?>
<?php include("session_timeout.php") ?>

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
            <h3 class="text-5 font-weight-400">Upload Document to User</h3>
            <p class="text-muted">Use below to upload and delete Documents. <b>File Supported (pdf,txt,zip,doc,docx,xls,xlsx,cvs,ppt,gif,png,jpeg,jpg)</b>  </p>

			<form class="row g-3" action="" method="post" name="frmExcelImport"
               id="frmExcelImport" enctype="multipart/form-data" onsubmit="myFunction()">
				<div class="col-md-6 mb-3">
					<!-- <label for="inputEmail4" class="form-label">Email</label> -->
					<select class="custom-select" id="user" name="user" >
                              <option value="">-- Select User --</option>
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
				<div class="col-md-6">
				<div class="input-group ">
                  <input class="form-control shadow-none border-0 bg-success text-light" type="file" name="myfile" id="myfile" accept=".pdf,.txt,.zip,.doc,.docx,.xls,.xlsx,.ppt,.gif,.png,.jpeg,.jpg" placeholder="choose file..." value="">
                    <div class="input-group-append ml-3"> 
                        <span class="input-group-text bg-white border-0 p-0">
                            <button type="submit" id="save" name="save"
                            class="btn btn-success mr-3">Upload</button>
                        </span> 
                    </div>
                </div>
				</div>
			</form>
          
                </div>
                  
             <div id="loader"></div>
            </div>
          </div>

           




          <!-- End Create Company Model -->
		  <section class="pt-5 bg-white">
      <div class="container">
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 table-responsive">


		<table class="table table-bordered table-hovered table-striped" id="fileTable">
					<thead>


    <th>#</th>
    <th>Filename</th>
    <th>User</th>
    <th>size (in mb)</th>
    <th>Date</th>
    <th>No Of Downloads</th>
    <th></th>
    <th></th>

					</thead>
					<?php  $i = 1;
          
            ?>
                

					<tbody>
							<tr>
              <?php foreach ($files as $file): ?>
                <!-- <td><?php echo $file['id']; ?></td> -->
								<td width="5">
								<?php
									echo $i;
									$i++;
								?> </td>
						
      <td><?php echo $file['name']; ?></td>
      <td><?php echo $file['uname']; ?></td>
      <td><?php echo floor($file['size'] / 1000) . ' KB'; ?></td>
      <td><?php echo $file['date']; ?></td>
      <td><?php echo $file['downloads']; ?></td>
      <td><a class="bg-success p-2 text-white" href="filesLogic.php?file_id=<?php echo $file['id'] ?>">Download</a></td>
    
      <td> 
       <a href="#" class="bg-danger p-2 text-white mr-3 deletebtn" title="Delete Record ">Delete</a>
       </td>

    </tr>

       <!-- Delete company Modal
          ================================== -->
          <div id="delete-client" class="modal fade " role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-400">Dalete Document</h5>
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
                        <a class="btn btn-danger bg-danger p-2 text-white" href="delete.php?del=<?php echo $file['id']?>">Yes !! Delete it.</a>

                    </div>
                  </form>
                </div>
                <div id="loader"></div>
              </div>
            </div>
          </div>
          <!-- End Company Delete Model -->
  <?php endforeach;?>

					</tbody>	
			
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
    $('#fileTable').DataTable();
});

</script>
<script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#delete-client').modal('show');

                             
            });
        });

  </script>
