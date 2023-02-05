<?php
use Phppot\Order;

require_once __DIR__ . '/Model/Order2.php';
$orderModel = new Order();
$result = $orderModel->getPdfGenerateValues($_GET["invoice_no"]);
$invoiceItemResult = $orderModel->getOrderItems($result[0]["invoice_no"]);
if (! empty($result)) {
    require_once __DIR__ . "/lib/PDFService2.php";
    $pdfService = new PDFService();
    $pdfService->generatePDF($result, $invoiceItemResult);
}