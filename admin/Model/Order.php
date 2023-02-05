<?php
namespace Phppot;

use Phppot\DataSource;

class Order
{

    private $ds;

    function __construct()
    {
      
          require_once __DIR__ . './../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    function getAllOrders()
    {
        $query = "SELECT * FROM invoice";
        $result = $this->ds->select($query);
        return $result;
    }

    function getPdfGenerateValues11($id)
    {
        $query = "SELECT * FROM tbl_order WHERE id='" . $id . "'";
        $result = $this->ds->select($query);
        return $result;
    }
    
    function getPdfGenerateValues($invoice_no)
    {
        $query = "SELECT * FROM invoice WHERE invoice_no='" . $invoice_no . "'";
        $result = $this->ds->select($query);
        return $result;
    }

    function getInvoice($invoice_no)
    {
        $sql = "SELECT * FROM invoice WHERE invoice='" . $invoice_no . "'";
        $result = $this->ds->select($query);
        return $result;
    }

    function getOrderItems($invoice_no)
    {
        $query = "SELECT * FROM invoice WHERE invoice_no='" . $invoice_no . "'";
        $result = $this->ds->select($query);
        return $result;
    }

    function getProduct($product_id)
    {
        $query = "SELECT * FROM invoice WHERE id='". $product_id ."'";
        $result = $this->ds->select($query);
        return $result;
    }

}
