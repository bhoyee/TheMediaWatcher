<?php include("includes/dashheader.php") ?>
<?php include("session_timeout.php") ?>


<?php 
  use Phppot\DataSource;
	require_once 'DataSource.php';
	$db = new DataSource();
	$conn = $db->getConnection();

  require_once './controller/product-controller.php';

	$dCtrl  =	new ProductsController($conn);

	$clients = $dCtrl->client3($_SESSION['userID']);

    $totalAmt = '';
    $vat = '';
    $from ='';
    $to = '';
    $i = 1;
    
    if (isset($_POST['submit'])){

    //   if($_POST['time'] === 'morning') {

    //     $_SESSION['sTime'] = '05:00:00';
    //     $_SESSION['eTime'] = '11:59:59';
    //     $_SESSION['belt']  = 'Morning';
    //     // $selected = $_POST['Fruit'];
    //     echo 'You have chosen: ' . $_SESSION['sTime'] . 'endTime'. $_SESSION['eTime'];
    // } elseif($_POST['time'] === 'afternoon') {

    //   $_SESSION['sTime'] = '12:00:00';
    //   $_SESSION['eTime'] = '17:59:59';
    //   $_SESSION['belt']  = 'Afternoon';
    //   // $selected = $_POST['Fruit'];
    //   echo 'You have chosen: ' . $_SESSION['sTime'] . 'endTime'. $_SESSION['eTime'];

    // } elseif($_POST['time'] === 'night'){

    //   $_SESSION['sTime'] = '18:00:00';
    //   $_SESSION['eTime'] = '24:00:00';
    //   $_SESSION['belt']  = 'Night';
    //   // $selected = $_POST['Fruit'];
    //   echo 'You have chosen: ' . $_SESSION['sTime'] . 'endTime'. $_SESSION['eTime'];

    // } elseif($_POST['time'] === 'all'){
    //   $_SESSION['sTime'] = '01:00:00';
    //   $_SESSION['eTime'] = '24:00:00';
    //   $_SESSION['belt']  = '24 hrs';
    //   // $selected = $_POST['Fruit'];
    //   echo 'You have chosen: ' . $_SESSION['sTime'] . 'endTime'. $_SESSION['eTime'];
    //   echo "something went wrong";

    // } elseif($_POST['time'] === 'early-morning'){
    //   $_SESSION['sTime'] = '1:00:00';
    //   $_SESSION['eTime'] = '04:59:59';
    //   $_SESSION['belt']  = 'Early Morning';
    //   // $selected = $_POST['Fruit'];
    
    // }

    // $sTime = trim($_SESSION['sTime']);
    // $eTime = trim($_SESSION['eTime']);

      
      
   $from           = date('Y-m-d',strtotime($_POST['fdate']));
     $to             = date('Y-m-d',strtotime($_POST['tdate']));
     // $totalSpot      = $_POST['spot'];
     $station        = trim($_POST['sname']);
     $brand          = trim($_POST['brand']);
     $sname        = trim($_POST['sname']);
    //  $amountperSpot  = trim((float)$_POST['spot']);
     $discount       = trim((float)$_POST['discount']);
     $term           = trim($_POST['term']);
     $bill_To        = trim($_POST['bill']);
     $adtype         = trim($_POST['ads']);
     $belt         = trim($_POST['belt']);

          $t15 = trim($_POST['t15']);
     $_SESSION['t15'] = $t15;

     $t30 = trim($_POST['t30']);
     $_SESSION['t30'] = $t30;

     $t45 = trim($_POST['t45']);
     $_SESSION['t45'] = $t45;

     $t60 = trim($_POST['t60']);
     $_SESSION['t60'] = $t60;

    
     
     $invoiceNo      = mt_rand(10000000,99999999);//8 digit unique number

    //  $oquery = $conn->query("select COUNT(id) AS id from data_bank where date between '$from' and '$to' and station='$station' and brand='$brand'");
            
         

          $Amt_Per_15sec_Duration = trim((float)$_POST['txt15sec']);
          $Amt_Per_30sec_Duration = trim((float)$_POST['txt30sec']);
          $Amt_Per_45sec_Duration = trim((float)$_POST['txt45sec']);
          $Amt_Per_60sec_Duration = trim((float)$_POST['txt60sec']);

          // 15sec duration
         
          $Total_Dspot15sec      = trim((int)$_POST['t15sec']);

            // 30sec duration
          $Total_Dspot30sec      = trim((int)$_POST['t30sec']);
        
      
          // 45sec duration
          $Total_Dspot45sec      = trim((int)$_POST['t45sec']);

      
          // 60sec duration
          $Total_Dspot60sec      = trim((int)$_POST['t60sec']);



          // echo $Total_Dspot15sec ." -30- " .$Total_Dspot30sec." -45- ".$Total_Dspot45sec." -60- ".$Total_Dspot60sec ;  

          $total_15Sec_Duration_Rate = (float)$Amt_Per_15sec_Duration * $Total_Dspot15sec;
          $total_30Sec_Duration_Rate = (float)$Amt_Per_30sec_Duration * $Total_Dspot30sec;
          $total_45Sec_Duration_Rate = (float)$Amt_Per_45sec_Duration * $Total_Dspot45sec;
          $total_60Sec_Duration_Rate = (float)$Amt_Per_60sec_Duration * $Total_Dspot60sec;

          $subTotal       = $total_15Sec_Duration_Rate + $total_30Sec_Duration_Rate + $total_45Sec_Duration_Rate + $total_60Sec_Duration_Rate;
          $totalDiscount  = (float)($discount * $subTotal)/100;


                // $totalAmt   = (float)$amountperSpot * $tspot;
                // $vat        = (float)(12.5*$totalAmt)/100;
                // $tamt       =  $totalAmt + $vat;
                $c_date     = date('Y-m-d h:i:s');
                $userID     = $_SESSION['userID'];
            

                //insert data into invoice table
                $nsql = "INSERT INTO invoicedom (invoice_no,dateFrom,dateTo,brand,company,discountPer,discount,term,dur_amt_15,dur_amt_30,dur_amt_45,dur_amt_60,
                total_dur_spot_15,total_dur_spot_30,total_dur_spot_45,total_dur_spot_60,created_date,userID,billTo,belt) 
                VALUES ('$invoiceNo','$from','$to','$brand','$sname','$discount','$totalDiscount','$term',
                '$Amt_Per_15sec_Duration','$Amt_Per_30sec_Duration','$Amt_Per_45sec_Duration','$Amt_Per_60sec_Duration','$Total_Dspot15sec','$Total_Dspot30sec','$Total_Dspot45sec','$Total_Dspot60sec','$c_date','$userID','$bill_To','$belt')";
                
                if ($conn->query($nsql) === TRUE) {
                $message = "Invoice Created Successfully";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
                } else {
                    
                    $message = "Something went wrong";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    echo "Error: " . $nsql . "<br>" . $conn->error;
                }
        
      

  //  }
   
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
            <h3 class="text-5 font-weight-400">Manage Customise Invoice</h3>
            <p class="text-muted">Create and delete Invoice </p>

            <?php   

              //Delete invoice

              if(isset($_POST['deletedata']))
                {
                    $id = $_POST['delete_id'];

                    $querydel ="DELETE FROM invoicedom WHERE invoicedom.id='$id'";

                    // $querydel = "DELETE FROM users WHERE id='$id'";
                    $query_del = query($querydel);
                    confirm($query_del);

                    if($query_del)
                    {
                        echo '<script> alert("User Data Deleted"); </script>';
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
            <div class="row justify-content-start">
            <form id="" method="post" onsubmit="myFunction()">

            <div class="container-fluid">     
                <div class="row">
             
                <div class="col-lg-6 ">
                    <div class="form-group">
                      <label for="cname">Select Invoice Generated Date:</label>
                      <input type="date" value="" class="form-control" id="fdate" name="fdate" >
                    </div>
                </div>
                <div class="col-lg-6 ">
                   <div class="form-group">
                      <label for="cname">Payment Due Date:</label>
                      <input type="date" value="" class="form-control" id="tdate" name="tdate" >
                    </div>    
                </div>

                <div class="col-lg-6 ">
                        <div class="form-group">
                          <label for="cname">Enter Station Name</label>

                          <input type="text" value="" class="form-control" id="sname" name="sname" required placeholder="Enter Station Name">
                         </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="form-group">
                            
                          <label for="cname">Enter Brand Name / Details</label>
                          <input type="text" value="" class="form-control" id="brand" name="brand" required placeholder="Enter Brand Name">
                         
                          <!-- <input type="text" value="" class="form-control" data-bv-field="cname" id="cname" name="cname" required placeholder="Enter Company Name"> -->
                        </div>

                     </div>

                          <!-- <div class="col-lg-6 ">
                              <div class="form-group">
                                  <label for="company">Enter Company Name</label>
                                  <input type="text" value="" class="form-control" id="company" name="company" required placeholder="Enter Company Name">

                               </div>
                          </div> -->
                          <div class="col-lg-6 ">
                            <div class="form-group">
                              <label for="discount">Bill To: </label>
                              <input type="text" class="form-control" name="bill" id="bill" placeholder="Name of the Receiver (Company / Individual)" required>
                            </div>
                     
                        </div>   
                        
                          <div class="col-lg-6 ">
                          <label for="company">Enter Belt Timing</label>
                          <input type="text" value="" class="form-control" id="belt" name="belt" placeholder="Enter Belt (e.g morning, afternoon, eening , night)">
<!-- 
                          <select name="time"  class="custom-select">
                              <option value="" disabled selected>Choose option</option>
                              <option value="morning">Morning Belt (5:00 AM - 11:59 AM)</option>
                              <option value="afternoon">Afternoon Belt (12:00 PM - 5:59 PM)</option>
                              <option value="night">Night Belt (6:00 AM - 11:59 AM)</option>
                              <option value="early-morning">Early Morning Belt (1:00 AM - 4:59 AM)</option>
                              <option value="all">All Belt (24 Hours)</option>
                             
                          </select> -->
                          </div>

                        <!-- <div class="col-lg-6 ">
                            <div class="form-group">
                              <label for="Spot">Enter Amount/Price Per Spot</label>
                              <input type="number" class="form-control" name="spot" id="spot" placeholder="amount (00.00)" step=".01" required>
                            </div>
                     
                        </div> -->
                        <div class="col-lg-6 mt-2">
                       
                         
                           
                   
                        </div>
                        <div class="col-lg-6 mt-2">
                       
                      
               
                    </div>

                    
                         <!-- <div class="col-lg-6 ">
                            <div class="form-group">
                              <label for="discount">Bill To: </label>
                              <input type="text" class="form-control" name="bill" id="bill" placeholder="Name of the Receiver (Company / Individual)" required>
                            </div>
                     
                        </div>    -->
                        
                        <div class="col-lg-6 ">
                            <div class="form-group">
                              <label for="discount">Enter Discount Percentage(%)</label>
                              <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount percentage % (00.00)" step=".01" required>
                            </div>
                     
                        </div>  
                        <div class="col-lg-6 ">
                            <div class="form-group">
                              <label for="discount">Enter Ads Type: </label>
                              <input type="text" class="form-control" name="ads" id="ads" placeholder="Enter Ads Type" required>
                            </div>
                     
                        </div>          
                        
                        <div class="col-lg-6 mb-5 pb-5">
                            <div class="form-group">
                              <label for="term">Enter Terms of Payment</label>
                              <textarea class="form-control" id="term" name="term" rows="3" placeholder="This can be payment mthos description" required></textarea>
                            </div>
                     
                        </div> <br><br><br>         
                 

                        <div class="col-lg-12 product-item float-clear" style="clear:both;">
                    <p>Enter Duration Amount/Rate Per Spot with Total Spot Per Duration</p>
                    <hr>
                  
                      <div class="col-lg-4 pb-3 w-100 float-left">
                          <span>Duration (e.g 45) min</span>
                          <input type="number" name="t15" class="form-control w-100" placeholder="Duration(e.g 15)"/>
                      </div>
                      <div class="col-lg-4 pb-3 w-100 float-left">
                        <span>Amount/Rate Per Spot</span>    
                        <input type="number" name="txt15sec" class="form-control w-100" placeholder="Amount(e.g 00.0)" />
                      </div>
                      <div class="col-lg-4 pb-3 w-100 float-left">
                        <span>Total Spot Per Duration</span>    
                        <input type="number" name="t15sec" class="form-control w-100" placeholder="Total Spot(e.g 20)" />
                      </div>
                    

                    <br><br>

                   
                    <p>Enter Duration Amount/Rate Per Spot with Total Spot Per Duration</p>
                    <hr>
                  
                    <div class="col-lg-4 pb-3 w-100 float-left">
                        <span>Duration (e.g 45) min</span>
                        <input type="number" name="t30" class="form-control w-100" placeholder="Duration(e.g 15)"/>
                    </div>
                    <div class="col-lg-4 pb-3 w-100 float-left">
                    <span>Amount/Rate Per Spot</span>    
                    <input type="number" name="txt30sec" class="form-control w-100" placeholder="Amount(e.g 00.0)" /></div>
                    <div class="col-lg-4 pb-3 w-100 float-left">
                    <span>Total Spot Per Duration</span>    
                    <input type="number" name="t30sec" class="form-control w-100" placeholder="Total Spot(e.g 20)" /></div>
                    

                    <br><br>

                    <br><br>
              
                    <p>Enter Duration Amount/Rate Per Spot with Total Spot Per Duration</p>
                    <hr>
                  
                    <div class="col-lg-4 pb-3 w-100 float-left">
                        <span>Duration (e.g 45) min</span>
                     
                      <input type="number" name="t45" class="form-control w-100" placeholder="Duratiosn(e.g 15)"/> </div>
                    <div class="col-lg-4 pb-3 w-100 float-left">
                    <span>Amount/Rate Per Spot</span>    
                    <input type="number" name="txt45sec" class="form-control w-100" placeholder="Amount(e.g 00.0)" /></div>
                    <div class="col-lg-4 pb-3 w-100 float-left">
                    <span>Total Spot Per Duration</span>    
                    <input type="number" name="t45sec" class="form-control w-100" placeholder="Total Spot(e.g 20)" /></div>
                    <br><br>
                    <p>Enter Duration Amount/Rate Per Spot with Total Spot Per Duration</p>
                    <hr>
    
              <div class="col-lg-4 pb-3 w-100 float-left">
                        <span>Duration (e.g 45) min</span>
                     
                      <input type="number" name="t60" class="form-control w-100" placeholder="Duration(e.g 15)"/> </div>
                    <div class="col-lg-4 pb-3 w-100 float-left">
                    <span>Amount/Rate Per Spot</span>    
                    <input type="number" name="txt60sec" class="form-control w-100" placeholder="Amount(e.g 00.0)" /></div>
                    <div class="col-lg-4 pb-3 w-100 float-left">
                    <span>Total Spot Per Duration</span>    
                    <input type="number" name="t60sec" class="form-control w-100" placeholder="Total Spot(e.g 20)" /></div>
                    
              </div>
                            

                    
                
            </div>

            <div class="col-6 mt-5 pb-5">
           
            <input type="submit" class="btn btn-success pull-right" value="Generate Invoice" name="submit"  >

            </div>
           </form>
           <div id="loader"></div>

      
        </div>
            
              <!-- <a href="#create-company" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Company</a> -->
            </div>


          


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

     

        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto table-responsive">
				<table class="table table-bordered table-hovered table-striped" id="productTable">
					<thead>
        
            
            <th></th>
            <th>#</th>
            <th scope="col">Created Date </th>
            <th scope="col">Brand </th>
            <th scope="col"> Company </th>
            <th scope="col"> Invoice No </th>
           <th></th>
            <th scope="col"> DELETE </th>

				
					</thead>

					<tbody>

					<?php 
					$i = 1;
						foreach($clients as $client) : ?>

				<tr>
              <td style="visibility:hidden;"> <?php echo $client['id']; ?> </td> 

                <td> <?php echo $i;	$i++; ?> </td>
				<td> <?php echo $client['created_date']; ?> </td>
                <td> <?php echo $client['brand']; ?> </td>
				<td> <?php echo $client['company']; ?> </td>
                <td> <?php echo $client['invoice_no']; ?> </td>
                <td class="text-right"><a target="_blank" class="bg-success p-2 text-white"
                        title="Generate Invoice"
                        href="./invoiced.php?invoice_no=<?php echo $client['invoice_no'];?>">Download</a></td>
              
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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

            $('.editclientbtn').on('click', function () {

                $('#edit-client-details').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#client_id').val(data[0]);
                $('#uname').val(data[3]);
                $('#email').val(data[4]);
                $('#status').val(data[5]);
             
            });
        });
    </script>
    <script>

$(document).ready(function() {
    $('#productTable').DataTable(
   
    );
});

</script>

<script>
$(document).ready(function(){
    $('#sname').on('change', function(){
        var stationID = $(this).val();
        console.log(stationID.length);
        console.log(stationID);
        let te = stationID.trim();
        console.log(te.length);
        if(stationID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'sname='+stationID,
                success:function(html){
                    $('#brand').html(html);
               
                }
            }); 
        }else{
            $('#brand').html('<option value="">Select station first</option>');
        }
    });

    $('#brand').on('change', function(){
        var brandID = $(this).val();
        if(brandID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'brand='+brandID,
                success:function(html){
                    $('#company').html(html);
                }
            }); 
        }else{
          $('#company').html('<option value="">Select brand first</option>');
        }
    });                       

});
    
</script>


</body>
</html>