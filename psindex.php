<?php include("includes/pdashheader.php") ?>
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
            <h3 class="text-5 font-weight-400">Download Document</h3>
            <p class="text-muted">Use below to search and download document</p>

          
                </div>
                  
            </div>
          </div>

           




          <!-- End Create Company Model -->
		  <section class="pt-5 bg-white">
      <div class="container">
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 table-responsive">
        <?php
        $userID = $_SESSION['userID'];

                $query = "SELECT id,name,size,downloads,date FROM files WHERE userID = '$userID' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>

		<table class="table table-bordered table-hovered table-striped" id="fileTable">
					<thead>


    <th>#</th>
    <th>Filename</th>
    <th>size (in mb)</th>
    <th>Date Uploaded</th>
    <th></th>


					</thead>
				      <?php
              $i = 1;
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                

					<tbody>
							<tr>
            
                <!-- <td><?php echo $row['id']; ?></td> -->
								<td width="5">
								<?php
									echo $i;
									$i++;
								?> </td>
						
      <td><?php echo $row['name']; ?></td>
        <td><?php echo floor($row['size'] / 1000) . ' KB'; ?></td>
      <td><?php echo $row['date']; ?></td>
      <td><a class="bg-success p-2 text-white" href="filesLogic.php?file_id=<?php echo $row['id'] ?>">Download</a></td>
    
    
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
