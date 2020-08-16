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
	<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>
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
			<p></p>
			<div class="alert alert-success">
				Your last successfull login was on <strong>
					<?php echo date_format(date_create($result1['LastLogin']),"l, F d, Y h:i:s a");?>
				</strong>
			</div>
		</div>
	</div>
	<?php
		require_once("footer.php");
	?>
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