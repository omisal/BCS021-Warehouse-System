<!DOCTYPE html>
<?php
	session_start();
	if (!isset($_SESSION["wh_user"])) {
		header("location:../index.php");
	}
?>
<html>
<head>
	<title>Brainner's Warehouse</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style type="text/css">
		footer.footer{
			background-color: #4caf50;
			position:fixed;
			bottom: 0px;
			width: 100%;
			font-size: medium;
			font-weight: bold;
			text-align: center;
			color: white;
			padding: 20px;
		}
	</style>
</head>
<body style="background-color: #e9e9e9;">
	<?php
		require_once("navigation.php");
	?>
<div class="page-content" id="content">
	<?php
		require_once("header.php");
	?>
	<div class="row m-3">
		<div class="col-lg-12">
			<h1>Welcome <?php echo $result1["FirstName"].", ".$result1["MiddleName"][0].". ".$result1["LastName"];?></h1>
			<p>My main content comes here</p>
			<div class="alert alert-success">
				Your last successfull login was on <strong>Thursday August 5,2020 4:00:34</strong>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div id="foo">
			Copyright Brainners &copy; 2020 All rights reserved.
		</div>
	</footer>
</div>
<!-- End demo content -->	
<script type="text/javascript">
	$(document).ready(function() {
	  // Sidebar toggle behavior
	  $('#sidenavToogle').on('click', function() {
	    $('#sidebar, #content').toggleClass('active');
	  });
	});
</script>
</body>
</html>