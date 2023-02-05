<?php include("functions/init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
<link href="images/favicon.png" rel="icon" />
<title>
TheMediaWatcher - Smart way to follow your brand ads</title>
<meta name="description" content="Platform to for Money Transfer and online payments .">
<meta name="author" content="bhoyee.com">

<!-- Web Fonts
============================================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">


<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="vendor/font-awesome/css/all.min.css" />
<link rel="stylesheet" type="text/css" href="vendor/bootstrap-select/css/bootstrap-select.css" />
<link rel="stylesheet" type="text/css" href="vendor/currency-flags/css/currency-flags.min.css" />
<link rel="stylesheet" type="text/css" href="vendor/owl.carousel/assets/owl.carousel.min.css" />
<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' type='text/css'>

<style>

#loader {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      background: rgba(0,0,0,0.75) url(img/ajax-loader.gif) no-repeat center center;
      z-index: 10000;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
	border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
	padding: 5px 20px;
	font-size: 0.9em;
}

.tutorial-table {
	margin-top: 40px;
	font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
	background: #f0f0f0;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
	background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
	padding: 10px;
	margin-top: 10px;
	border-radius: 2px;
	display: none;
}

.success {
	background: #c7efd9;
	border: #bbe2cd 1px solid;
}

.error {
	background: #fbcfcf;
	border: #f3c6c7 1px solid;
}

div#response.display-block {
	display: block;
}
</style>

</head>
<body>

<!-- Preloader -->
<div id="preloader">
  <div data-loader="dual-ring"></div>
</div>
<!-- Preloader End -->

<!-- Document Wrapper
============================================= -->
<div id="main-wrapper">
  <!-- Header
  ============================================= -->
  <header id="header">
    <div class="container">
      <div class="header-row">
        <div class="header-column justify-content-start">
          <!-- Logo
          ============================= -->
          <div class="logo"> <a class="d-flex" href="#" title="
TheMediaWatcher - Smart way to follow your brand ads"><img src="images/logo.png" alt="TheMediaWatcher" /></a> </div>
          <!-- Logo end -->
          <!-- Collapse Button
          ============================== -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav"> <span></span> <span></span> <span></span> </button>
          <!-- Collapse Button end -->

          <!-- Primary Navigation
          ============================== -->
          <nav class="primary-menu navbar navbar-expand-lg">
            <div id="header-nav" class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">
                <li class="active"><a href="dashboard">Dashboard</a></li>
                <li><a href="search">Data</a></li>
                <li><a href="sindex">Document</a></li>
                <li><a href="#">Invoice</a></li>
                <!-- <li><a href="upload.php">Upload Data</a></li>
                <li><a href="search.php">Search Data</a></li> -->
                <!-- <li><a href="help.php">Help</a></li> -->


              </ul>
            </div>
          </nav>
          <!-- Primary Navigation end -->
        </div>
        <div class="header-column justify-content-end">
          <!-- Login & Signup Link
          ============================== -->
          <nav class="login-signup navbar navbar-expand">
            <ul class="navbar-nav">
              <li><a href="settings">Settings</a> </li>
              <li class="align-items-center h-auto ml-sm-3"><a class="btn btn-outline-primary shadow-none d-none d-sm-block" href=".\logout.php">Sign out</a></li>
            </ul>
          </nav>
          <!-- Login & Signup Link end -->
        </div>
      </div>
    </div>
  </header>
  <!-- Header End -->
