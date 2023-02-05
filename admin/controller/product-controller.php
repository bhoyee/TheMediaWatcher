<?php

    class ProductsController {

    	// constructor
    	function __construct($conn) {

    		$this->conn = $conn;
    	
    	}


 		// retrieving products data
        public function index() {
            $cDate = date("Y-m-d");

            $data       =    array();

            $sql        =    "SELECT id,date,time,brand,adtype,campaign,station,medium,duration,company,industry,language,program,region FROM data_bank WHERE post_date = '$cDate'";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }
        // retrieving all Data
        public function indexAll() {

            $data       =    array();

            $sql        =    "SELECT id,date,time,brand,campaign,station,medium,duration,company,industry,language,program,region FROM data_bank";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }

        // retrieving company list
        public function company() {
     
            $data       =    array();

            $sql        =    "SELECT id, name, created_date FROM company ";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }

        
        // retrieving station list
        public function station() {
     
            $data       =    array();

            $sql        =    "SELECT id, name, created_date FROM station ";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }

          // retrieving client list
          public function client() {
     
            $data       =    array();

            $sql        =    "SELECT id, userID, username, email, status, reg_date FROM users ";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }
        
         // retrieving client list
         public function client2($userID) {
           
     
            $data       =    array();

            $sql        =    "select id,created_date,brand,company,invoice_no from invoice WHERE userID ='$userID'";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }
        
          // retrieving client list
            public function client3($userID) {
           
     
                $data       =    array();
    
                $sql        =    "select id,created_date,brand,company,invoice_no from invoicedom WHERE userID ='$userID'";
                
                $result     =    $this->conn->query($sql);
                
                if($result->num_rows > 0) {
                
                    $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
                
                }
                          
               return $data;
            }


           // retrieving user-company
           public function ucomp() {
     
            $data       =    array();

            $sql        =    "SELECT ucompany.id AS id , users.username AS uname, users.email AS email, company.name AS cname FROM ucompany
                            LEFT JOIN users ON users.userID = ucompany.userID
                            LEFT JOIN company ON company.id = ucompany.c_id ";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }

        // retrieving user-station
        public function ustat() {
     
            $data       =    array();

            $sql        =    "SELECT ustation.id AS id , users.username AS uname, users.email AS email, station.name AS sname FROM ustation
                            LEFT JOIN users ON users.userID = ustation.userID
                            LEFT JOIN station ON station.id = ustation.s_id ";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }

          // retrieving data_bank
          public function dbank() {
     
            $data       =    array();

            $sql        =    "SELECT id, date, time, brand, campaign, station, medium, duration, industry, language,program, region FROM date_bank ";
            
            $result     =    $this->conn->query($sql);
            
            if($result->num_rows > 0) {
            
                $data        =           mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            }
                      
           return $data;
        }

    }
?>