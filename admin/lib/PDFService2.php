<?php
use Phppot\Config;
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once __DIR__ . '/../lib/Config.php';
$config = new Config();


    


class PDFService {
    public $img;

    
 
    function generatePDF($result, $invoiceItemResult) {

        ob_start();

        session_start();
        $userID = $_SESSION['userID'];
// $img = $_SESSION['logo'];
// $sql = "SELECT company_logo from boidata WHERE userID =36006103";

// $resultss = query($sql);

$con = mysqli_connect('localhost', 'themeadi_root', 'import_excel');
mysqli_select_db($con,'themeadi_import_excel');

$query2 = mysqli_query($con,"select company, company_logo from boidata where userID='$userID'");


        require_once __DIR__ . '/../vendor/tcpdf/tcpdf.php';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '', array(
            0,
            0,
            0
        ), array(
            255,
            255,
            255
        ));

        
  
        $pdf->SetTitle('Invoice - ' . $result[0]["invoice_no"]);
        $pdf->SetMargins(20, 10, 20, true);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 11);
        $pdf->AddPage();
        

            $dara = mysqli_fetch_array($query2);
            $dar = $dara['company_logo']; //fetch company logo dir
            $company = trim($dara['company']); // fetch comapny name

              //chk for admin users
            if($company ==='themeadiawatcher'){
                $dar = 'img/logo.png';
            }
            
            if($dar =='' || empty($dar)){
                  $dar = 'img/logo.png';
            }
           

                // $row = fetch_array($resultss);
                // $logo = $row['company_logo'];
                
                if (!$dara) {
                    printf("Error: %s\n", mysqli_error($con));
                    exit();
                }
                
                // $x, $y, $w, $h
        $pdf->Image('./'.$dar,20,8,35,18);
        // $img_file = './img/logo.png';

        // Render the image
        // $pdf->Image($img_file, 100,150,60);

        $orderedDate = date('d F Y', strtotime($result[0]["created_date"]));
        $due_date = date("d F Y", strtotime('+' . Config::TERMS . 'days', strtotime($orderedDate)));
        
        require_once __DIR__ . '/../Template/purchase-invoice-template2.php';
                 
        $html = getHTMLPurchaseDataToPDF($result, $invoiceItemResult, $orderedDate, $due_date);
        $filename = "Invoice-" . $result[0]["invoice_no"];
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output($filename . '.pdf', 'I');
    }
}

?>