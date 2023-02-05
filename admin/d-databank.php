<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>
<?php 
	use Phppot\DataSource;

	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();

	// require_once './config/db-config.php'; 

	require_once './controller/product-controller.php';

	// $db = new DBController();

	// $conn = $db->connect();

	$dCtrl  =	new ProductsController($conn);

	$products = $dCtrl->indexAll();
?>
<?php			
			
      error_reporting(0);
      if (isset($_POST["submit"])) {
      if (count($_POST["ids"]) > 0 ) {
      // Imploding checkbox ids
      $all = implode(",", $_POST["ids"]);
      $sql =mysqli_query($conn,"DELETE FROM data_bank WHERE id in ($all)");
        if ($sql) {
        $errmsg ="Data has been deleted successfully";
        //  echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
        } else {
        $errmsg ="Error while deleting. Please Try again.";
        }
        } else {
        $errmsg = "You need to select atleast one checkbox to delete!";
        }
      }

			 //Delete company

			?>
 
      

    <section class="hero-wrap section">
    <div class="hero-mask opacity-9 bg-success"></div>
    <div class="hero-bg" style="background-image:url('./images/bg/image-2.jpg');"></div>
    <div class="hero-content">
      <div class="container">
        <div class="row align-items-center text-center">
          <div class="col-12">
            <h1 class="text-11 text-white mb-3">Search and Delete Data from Database</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-6 mx-auto">
          <form action="" method="post" name="frmExc"
            id="frmExce" enctype="multipart/form-data" onsubmit="myFunction()">

            <div class="container-fluid">     
                <div class="row">
             
                <div class="col-sm">
                    <div class="form-group">
                      <label class="text-light" for="cname">Select Date From:</label>
                      <input type="date" value="" class="form-control" id="fdate" name="fdate" >
                    </div>
                </div>
                <div class="col-sm">
                   <div class="form-group">
                      <label class="text-light" for="cname">Select Date To:</label>
                      <input type="date" value="" class="form-control" id="tdate" name="tdate" >
                    </div>    
                </div>
                <div class="col-sm pt-3 mt-3">
                <input type="submit" class="btn btn-light pull-right" value="Get Data" name="submit2"  >

                </div>
                    
                
            </div>
          </form>
            <div id="loader"></div>
          
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Header end --> 

  <div id="content">
    
   
    
    <!-- Popular Topics
    ============================================= -->
    <section class="section bg-white">
      <div class="container">

        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
        <form name="multipledeletion" method="post">
        <p style="color:red; font-size:16px;">
	    	<?php if($errmsg){ echo $errmsg; } ?> </p>
        <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-md pull-left mb-3" onClick="return confirm('Are you sure you want to delete?');" ></td>

				<table class="table table-bordered table-hovered table-striped" id="productTable">
					<thead>
						<th></th>
            <th><li><input type="checkbox" id="select_all" />All</li></th>
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
						<th scope="col"> DELETE </th>
					</thead>

					<tbody>
          <?php 
                           $_SESSION['company'] = '';
                           $from ='';
                           $to = '';
                           $i = 1;

                       	if (isset($_POST['submit2'])){
                            
                            $from    = date('Y-m-d',strtotime($_POST['fdate']));
                            $to      = date('Y-m-d',strtotime($_POST['tdate']));
                            // $company = $_POST['cname'];

                            $oquery = $conn->query("select id,date,time,brand,campaign,station,medium,duration,company,industry,language,program,region from data_bank where date between '$from' and '$to'");

                            while($orow = $oquery->fetch_array()){
                                $_SESSION['company'] =  $orow['company'];
                                ?>  


							<tr>
							<td style="visibility:hidden;"> <?php echo $orow['id']; ?> </td> 
              <td ><input type="checkbox" class="checkbox" name="ids[]" value="<?php echo ($orow['id']);?>"/></td>

								<td width="5">
								<?php
									echo $i;
									$i++;
								?> </td>
								<td> <?php echo $orow['date']; ?> </td>
								 <td><?php 
                                 $time = $orow['time'];
                                 // 24-hour time to 12-hour time 
                                 $newTime  = date("g:i:s A", strtotime($time));
                                 echo $newTime ?></td>
								<td> <?php echo $orow['brand']; ?> </td>
								<td> <?php echo $orow['campaign']; ?> </td>
								<td> <?php echo $orow['station']; ?> </td>
								<td> <?php echo $orow['medium']; ?> </td>
								<td> <?php echo $orow['duration']; ?> </td>
								<td> <?php echo $orow['company']; ?> </td>
								<td> <?php echo $orow['industry']; ?> </td>
								<td> <?php echo $orow['language']; ?> </td>
								<td> <?php echo $orow['program']; ?> </td>
								<td> <?php echo $orow['region']; ?> </td>
								<td> 
                  <a href="#" class="mr-3 deletebtn" title="Delete Record "><span class="fa fa-trash-can text-danger"></span></a>
                </td>
							</tr>
              <?php 
				    }
			    }
		    ?>


            </tbody>	
          </table>
         </form>
			
        </div>
      </div>
    </section>
    <!-- Popular Topics end -->

  
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
$(document).ready(function () {

$('#productTable').DataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true,
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Search Your Data",
    }
});

});

</script>
<script type="text/javascript">
		$(document).ready(function(){
      $('#select_all').on('click',function(){
      if(this.checked){
        $('.checkbox').each(function(){
        this.checked = true;
        });
      }else{
        $('.checkbox').each(function(){
        this.checked = false;
        });
      }
      });
      $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
          $('#select_all').prop('checked',true);
          }else{
          $('#select_all').prop('checked',false);
          }
      });
		});
		</script>



</body>
</html>

  