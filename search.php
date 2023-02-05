<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


<?php 
  use Phppot\DataSource;
	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();

  require_once './controller/product-controller.php';

	$dCtrl  =	new ProductsController($conn);

	// $dbanks = $dCtrl->dbank();


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
            <h3 class="text-5 font-weight-400">Search / Query Data</h3>
            <p class="text-muted">Use below to search and download data </p>

            
            <hr class="mx-n4">
            <div class="mb-5 clearfix">
            <div class="row justify-content-start">
            <form method="POST">
            <div class="container-fluid">     
                <div class="row">
             
                <div class="col-sm">
                    <div class="form-group">
                      <label for="cname">Select Date From:</label>
                      <input type="date" value="" class="form-control" id="fdate" name="fdate" >
                    </div>
                </div>
                <div class="col-sm">
                   <div class="form-group">
                      <label for="cname">Select Date To:</label>
                      <input type="date" value="" class="form-control" id="tdate" name="tdate" >
                    </div>    
                </div>

                     <div class="col-sm ">
                        <div class="form-group">
                          <label for="cname">Select Company</label>
                            
                          <select class="custom-select" id="cname" name="cname" >
                          <option value="">Select Company</option>
                                <?php
                                $userID = $_SESSION['userID'];
                                $sqli = "SELECT ucompany.id AS id, ucompany.userID AS userID, company.name AS cname FROM ucompany INNER JOIN company ON company.id = ucompany.c_id WHERE ucompany.userID = '$userID'";
                                $result = mysqli_query($con, $sqli);
                                while ($row = mysqli_fetch_array($result)) {
                                  $id = $row['id'];
                                  $cname = $row['cname']; 
                                  echo '<option value="'.$cname.'">'.$cname.'</option>';
                                }
                                
                                echo '</select>';
                                
                                ?>
                          <!-- <input type="text" value="" class="form-control" data-bv-field="cname" id="cname" name="cname" required placeholder="Enter Company Name"> -->
                        </div>

                     </div>
                    
                
            </div>

            <div class="col-6 pb-5">
           
            <input type="submit" class="btn btn-success pull-right" value="Get Data" name="submit"  >

            </div>
                            </form>
      
        </div>
            
              <!-- <a href="#create-company" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Company</a> -->
            </div>



        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
        <table class="table table-bordered table-hovered table-striped" id="databank">
					<thead>
        
            
            
            <!--<th></th>-->
            <th scope="col">Date </th>
            <th scope="col">Time</th>
            <th scope="col"> Brand </th>
            <th scope="col"> Campaign </th>
            <th scope="col"> Station </th>
            <th scope="col"> medium </th>
            <th scope="col">Duration </th>
            <th scope="col">Company </th>
            <th scope="col">Industry</th>
            <th scope="col"> Language </th>
            <th scope="col"> Program </th>
            <th scope="col"> Region </th>
       

				
					</thead>

					<tbody>
                        <?php 
                           $_SESSION['company'] = '';
                           $from ='';
                           $to = '';
                           $i = 1;

                       	if (isset($_POST['submit'])){
                            
                            $from    = date('Y-m-d',strtotime($_POST['fdate']));
                            $to      = date('Y-m-d',strtotime($_POST['tdate']));
                            $company = $_POST['cname'];

                            $oquery = $conn->query("select date, time, brand, campaign, station, medium, duration, company, industry, language,program, region from data_bank where date between '$from' and '$to' and company='$company'");

                            while($orow = $oquery->fetch_array()){
                                $_SESSION['company'] =  $orow['company'];
                                ?>  
                        <tr>
                            <!-- <td>-->
                            <!--    <?php echo $i; $i++; ?> -->
                            <!--</td>-->
						    <td><?php echo $orow['date']?></td>
						       <td><?php 
                                 $time = $orow['time'];
                                 // 24-hour time to 12-hour time 
                                 $newTime  = date("g:i:s A", strtotime($time));
                                 echo $newTime ?></td>
						  
						    <td><?php echo $orow['brand']?></td>
                 <td><?php echo $orow['campaign']?></td>
						    <td><?php echo $orow['station']?></td>
						    <td><?php echo $orow['medium']?></td>
               <td><?php echo $orow['duration']?></td>
               <td><?php echo $orow['company']?></td>
						    <td><?php echo $orow['industry']?></td>
                <td><?php echo $orow['language']?></td>
						    <td><?php echo $orow['program']?></td>
						    <td><?php echo $orow['region']?></td>
					    </tr>
					<?php 
				    }
			    }
		    ?>
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
            <li class="nav-item"> <a class="nav-link" href="#">Careers</a></li>
            <li class="nav-item"> <a class="nav-link" href="#">Affiliate</a></li>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>


<?php
        $name = $_SESSION['company'];
        $fdate = $from;
        $tdate = $to;
    ?>


<script>
     var x = "<?php echo"$name"?>";
     let y = "<?php echo"$fdate"?>"; ;
     let z = "<?php echo"$tdate"?>";;

       $(document).ready(function() {
    $('#databank').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        
            {
            extend: 'pdfHtml5',
            title: 'New report for' +' '+ x +' '+ 'from'+' '+ y +' '+'to'+' ' + z,
            text:'Export PDF',
           orientation:'landscape'
        },
        {
            extend: 'excel',
            title: 'New report for' +' '+ x +' '+ 'from'+' '+ y +' '+'to'+' ' + z
        },
        {
            extend: 'csv',
            title: 'New report for' +' '+ x +' '+ 'from'+' '+ y +' '+'to'+' ' + z
        },
        {
            extend: 'copy',
            title: 'New report for' +' '+ x +' '+ 'from'+' '+ y +' '+'to'+' ' + z
        },
        {
            extend: 'print',
            title: 'New report for' +' '+ x +' '+ 'from'+' '+ y +' '+'to'+' ' + z
        }
        ]
    } );
} );
    </script>


</body>
</html>

  