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
            <h3 class="text-5 font-weight-400">Search Data</h3>
            <p class="text-muted">Use below to search and download data </p>

            
            <hr class="mx-n4">
            <div class="mb-5 clearfix">
            <div class="row justify-content-start">
            <form method="POST" onsubmit="myFunction()">
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
                          <label for="cname">Select AdType</label>
                            
                          <select class="custom-select" id="adtype" name="adtype" >
                          <option value="">Select Ad-Type</option>
                                <?php
                                // $userID = $_SESSION['userID'];
                                $sqli = "SELECT DISTINCT adtype AS adtype FROM data_bank";
                                $result = mysqli_query($con, $sqli);
                                while ($row = mysqli_fetch_array($result)) {
                                  // $id = $row['id'];
                                  $sname = $row['adtype']; 
                                  echo '<option value="'.$sname.'">'.$sname.'</option>';
                                }
                                
                                echo '</select>';
                                
                                ?>
                          <!-- <input type="text" value="" class="form-control" data-bv-field="cname" id="cname" name="cname" required placeholder="Enter Company Name"> -->
                        </div>

                     </div>

                     <div class="col-sm mt-4 mb-5">
                    
                        <input type="submit" class="btn btn-success pull-right" value="Get Data" name="submit"  >                     

                     </div>               
            </div>
            </form>
      	<div id="loader"></div>
        </div>
            
              <!-- <a href="#create-company" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Company</a> -->
            </div>



        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
        <table class="table table-bordered table-hovered table-striped" id="databank">
					<thead>
        
            
            
            <th></th>
            <th scope="col">Date </th>
            <th scope="col">Time</th>
            <th scope="col"> Brand </th>
            <th scope="col"> Adtype </th>
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
                            $adtype  = trim($_POST['adtype']);
                            // $company = $_POST['cname'];

                            $oquery = $conn->query("select date, time, brand, adtype, campaign, station, medium, duration, company, industry, language,program, region from data_bank where date between '$from' and '$to' and adtype='$adtype'");

                            while($orow = $oquery->fetch_array()){
                                $_SESSION['company'] =  $orow['company'];
                                ?>  
                        <tr>
                             <td>
                                <?php echo $i; $i++; ?> 
                            </td>
						    <td><?php echo $orow['date']?></td>
						    <td><?php echo $orow['time']?></td>
						    <td><?php echo $orow['brand']?></td>
                <td><?php echo $orow['adtype']?></td>
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
	
	

	<!-- php do not refresh page after submit post -->
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>
	
	<script>
	function myFunction() {
	var spinner = $('#loader');
	document.getElementById("loader").style.display = "inline"; // to undisplay
  
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
            title: 'New report from'+' '+ y +' '+'to'+' ' + z,
            text:'Export PDF',
           orientation:'landscape',
           customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/jpg;base64,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' } );
                }
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

  