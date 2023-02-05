<?php
extract($_REQUEST);
include("functions/init.php");


$sql=mysqli_query($con,"select * from files where id='$del'");
$row=mysqli_fetch_array($sql);

unlink("uploads/$row[name]");

mysqli_query($con,"delete from files where id='$del'");

header("Location:sindex.php");

?>