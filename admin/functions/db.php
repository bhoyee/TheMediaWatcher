<?php

$con = mysqli_connect('localhost', 'themeadi_root', 'import_excel', 'themeadi_import_excel');

 // define('URL', "http://localhost/"); //DO NOT FORGET THE TRAILING /

function row_count($result){


    return mysqli_num_rows($result);
}


function escape($string){
    global $con;
    return mysqli_real_escape_string($con, $string);
}

function query($query){
    global $con;
    return mysqli_query($con, $query);
}

function confirm($result){
    global $con;

    if(!$result){
        die("QUERY FAILED " . mysqli_error($con));
    }
}

function fetch_array($result){
    global $con;

    return mysqli_fetch_array($result);
}

// echo $con ? 'connected' : 'not connected';


?>