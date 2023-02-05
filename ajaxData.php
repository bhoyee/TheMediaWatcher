<?php include("functions/init.php") ?>
<?php include("session_timeout.php") ?>

<?php  
if(!empty($_POST["sname"])){ 
    $station = $_POST["sname"];
    // Fetch state data based on the specific country 
    $query = "SELECT DISTINCT(brand) AS brand FROM data_bank WHERE station='$station'"; 
    // $result = $db->query($query); 
       $result = mysqli_query($con, $query);
 
    // Generate HTML of state options list 
    if($result->num_rows > 0){ 
        
        echo '<option value="">Select Brand</option>'; 
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="'.$row['brand'].'">'.$row['brand'].'</option>'; 
       
        } 
    }else{ 
        echo '<option value="">Brand not available</option>'; 
    } 
}elseif(!empty($_POST["brand"])){ 
    $brand = $_POST["brand"];
    // Fetch city data based on the specific state 
    $query1 = "SELECT DISTINCT(company) FROM data_bank WHERE brand='$brand'"; 
    $result1 = mysqli_query($con, $query1);
     
    // Generate HTML of city options list 
    if($result1->num_rows > 0){ 
         echo '<option value="">Select company</option>'; 
         while ($row1 = mysqli_fetch_array($result1)) {  
            echo '<option value="'.$row1['company'].'">'.$row1['company'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Company not available</option>'; 
        echo "Error: " . $query1 . "<br>" . $db->error;

    } 
} 
?>

