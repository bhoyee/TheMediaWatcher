<?php include("includes/pdashheader.php") ?>
<?php
    use Phppot\Order;
    require_once __DIR__ . '/../Model/Order2.php';
    function getHTMLPurchaseDataToPDF($result, $invoiceItemResult, $orderedDate, $due_date)
    {
    ob_start();
    $company       = $_SESSION['company'];
    $tel           = $_SESSION['phone'];
    $email         = $_SESSION['email'];
    $img           = $_SESSION['img'];
    $address       = $_SESSION['address'];

    // $belt = $_SESSION['belt'];

?>
<html>
<head>Receipt of Purchase - <?php  echo $result[0]["invoice_no"]; ?>
</head>
<body>

    <div style="text-align:left;">
    
    
    <div style="font-size: 24px;color: #666;"></div>
        
    <table style="line-height: 1;">
        <tr ><td><b>Sender:</b> <?php echo $company; ?></td>
           
        </tr>
        <tr>
            <td><b>Tel:</b> <?php echo $tel; ?></td></tr>
        <tr>
            <td><b>Address:</b> <?php echo $address; ?></td>
        </tr>
        <tr>
            <td><b>Eamil:</b> <?php echo $email; ?></td>
        </tr>
      </table>
    <!-- <p><b>Sender:</b> <?php echo $company; ?></p>
    <p><b>Tel:</b> <?php echo $tel; ?></p>
    <p><b>Address:</b> <?php echo $address; ?></p> -->
    </div>


        <div style="text-align: left;border-top:1px solid #000;">
            <div style="font-size: 24px;color: #666;">INVOICE</div>
        </div>
        
    <table style="line-height: 1.5;">
        <tr><td><b>Invoice:</b> #<?php echo $result[0]["invoice_no"]; ?>
            </td>
            <td style="text-align:right;"><b>Bill To:</b></td>
        </tr>
        <tr>
            <td><b>Date:</b> <?php 
            echo date('d F Y',  strtotime($result[0]["dateFrom"])); 
            ?></td>
            <td style="text-align:right;"><?php echo $result[0]["billTo"]; ?></td>
        </tr>
        <tr>
            <td><b>Payment Due:</b><?php 
            echo date('d F Y',  strtotime($result[0]["dateTo"])); 
            ?>
            </td>
            <!-- <td style="text-align:right;"><?php echo $result[0]["company"]; ?></td> -->
        </tr>
    <tr>
    <td></td>
    <!-- <td style="text-align:right;"><?php echo $result[0]["tAmt"]; ?></td> -->
    </tr>
    </table>

    <div></div>
    <!-- <div style="border-bottom:1px solid #000;"> -->
    
        <table style="line-height: 2;">
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <td style="border:1px solid #cccccc;width:285px;">Brand Description With Duration</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:60px;">Qty</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:70px">Rate(GH¢)</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:60px">Subtotal (GH¢)</td>
            </tr>
    <?php
    $total = 0;
    $productModel = new Order();
    foreach ($invoiceItemResult as $k => $v) {

        $duration15sc = $invoiceItemResult[$k]["total_dur_spot_15"];	
        $duration30sc = $invoiceItemResult[$k]["total_dur_spot_30"];
        $duration45sc = $invoiceItemResult[$k]["total_dur_spot_45"];	
        $duration60sc = $invoiceItemResult[$k]["total_dur_spot_60"];
        
        $tAmt15sc     = $invoiceItemResult[$k]["dur_amt_15"];
        $tAmt30sc     = $invoiceItemResult[$k]["dur_amt_30"];
        $tAmt45sc     = $invoiceItemResult[$k]["dur_amt_45"];
        $tAmt60sc     = $invoiceItemResult[$k]["dur_amt_60"];

        $subT15sec    = $tAmt15sc*$duration15sc;
        $subT30sec    = $tAmt30sc*$duration30sc;
        $subT45sec    = $tAmt45sc*$duration45sc;
        $subT60sec    = $tAmt60sc*$duration60sc;

        $subTotal     = $subT15sec+$subT30sec+$subT45sec+$subT60sec;
    
        $price        = $invoiceItemResult[$k]["amount"] * $invoiceItemResult[$k]["tSpot"];
        $discount     = (float)$invoiceItemResult[$k]["discountPer"];
        $tdiscount    = (float)($discount * $subTotal)/100;

        $totalAfterDic = $subTotal - $tdiscount;
        

        $term         = $invoiceItemResult[$k]["term"];
        
        $nhil         = (float)(2.5*$totalAfterDic)/100;
        $getfund       = (float)(2.5*$totalAfterDic)/100;
        $covidlevies  = (float)(1*$totalAfterDic)/100;

        $totalsublevel = $nhil + $getfund + $covidlevies + $totalAfterDic;
        $vat          = (float)(12.5*$totalsublevel )/100;

        $total        = (float)($vat + $totalsublevel);
        //  $totals  = $total - $discount;
        $productResult = $productModel->getProduct($invoiceItemResult[$k]["id"]);
    ?>
      
       <tr> <td style="border:1px solid #cccccc;font-size:9.2px;"><?php echo $productResult[0]["brand"]; ?> : For <?php echo $_SESSION['t15']; ?> SEC Duration, <?php  echo $result[0]["belt"]; ?> belt</td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo($duration15sc); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($invoiceItemResult[$k]["dur_amt_15"], 2); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($subT15sec, 2); ?></td>
        </tr>
        <tr> <td style="border:1px solid #cccccc; font-size: 9.2px;"><?php echo $productResult[0]["brand"]; ?> : For <?php echo $_SESSION['t30']; ?> SEC Duration, <?php  echo $result[0]["belt"]; ?> belt</td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo($duration30sc); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($invoiceItemResult[$k]["dur_amt_30"], 2); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($subT30sec, 2); ?></td>
        </tr>
        <tr> <td style="border:1px solid #cccccc; font-size: 9.2px;"><?php echo $productResult[0]["brand"]; ?> : For <?php echo $_SESSION['t45']; ?> SEC Duration, <?php  echo $result[0]["belt"]; ?> belt</td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo($duration45sc); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($invoiceItemResult[$k]["dur_amt_45"], 2); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($subT45sec, 2); ?></td>
        </tr>
        <tr> <td style="border:1px solid #cccccc; font-size: 9.2px;"><?php echo $productResult[0]["brand"]; ?> : For <?php echo $_SESSION['t60']; ?> SEC Duration, <?php  echo $result[0]["belt"]; ?> belt</td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo($duration60sc); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($invoiceItemResult[$k]["dur_amt_60"], 2); ?></td>
                        <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($subT60sec, 2); ?></td>
        </tr>
       
        
    <?php
    }
    ?>
       <tr style = "font-size: 9px; font-weight: bold;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">Sub Total</td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($subTotal, 2); ?></td>
        </tr>
        <tr style = "font-size: 9px;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">Discount (<?php echo $discount ?>%)</td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($tdiscount, 2); ?></td>
        </tr>
           <tr style = "font-size: 9px;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;"></td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($totalAfterDic, 2); ?></td>
        </tr>
        <tr style = "font-size: 9px;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">NHIL (2.5%)</td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($nhil, 2); ?></td>
        </tr>
        <tr style = "font-size: 9px;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">GETFund (2.5%)</td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($getfund, 2); ?></td>
        </tr>
        <tr style = "font-size: 9px;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">COVID-19 LEVIES (1%)</td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($covidlevies, 2); ?></td>
        </tr>

        <tr style = "font-size: 9px;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">VAT (12.5%)</td>
            <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($vat, 2); ?></td>
        </tr>
        
        <tr style = "font-weight: bold;">
            <td></td><td></td>
            <td style = "text-align:right; border:1px solid #cccccc;">Total (GH¢)</td>
            <td style = "text-align:right; border:1px solid #cccccc;background-color:#f2f2f2;"><?php echo number_format($total, 2); ?></td>
        </tr>
        </table>
        
        <p ><u><b>TERMS OF PAYMENT</b></u><br/>
        <?php echo $invoiceItemResult[$k]["term"] ; ?>

        </p>
        <p><i>Note: Please send a remittance advice by <b>email to :</b> <?php echo $email; ?></i></p>
        <div></div>
        <div style="font-size: 24px;color: #666;"></div>
        <div> 
      
              <div></div>
    <table style="line-height: 1.0;">
        <tr><td style="width:60%"><b><hr style="float:left; width: 44%;">
        <b style="margin-left:200px"></b>Signature<br></b></td>
            <td style="text-align:center; width:20%"></td>
            <td style="width:20%"></td>
        </tr>
  
    </table>
 


</body>
</html>

<?php
return ob_get_clean();
}
?>