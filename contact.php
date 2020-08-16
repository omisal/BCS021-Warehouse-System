<!DOCTYPE html>
<html>
<head>
	<title>Brainner's Warehouse</title>
	<style type="text/css">
		#contact{
			width: 70%;
			margin: auto;
		}
		table{
			width: 100%;
			font-size: larger;
			text-align: center;
		}
		#contact table img{
			margin: auto;
			width: 70px;
			height: 70px;
			display: block;
			font-size: larger;
		}
		#comment{
			width: 70%;
			margin: auto;
			border-radius: 10px;
			font-size: large;
			margin-bottom: 100px;
		}
		input{
			height: 40px;
			width: 100%;
			border-radius: 10px;
		}
		textarea{
			padding: 10px;
			font-size: large;
			width: 90%;
			border-radius: 10px;
		}

	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="wms/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="wms/js/popper.min.js"></script>
	<script type="text/javascript" src="wms/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="wms/style/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style/main.css">
	<link rel="stylesheet" type="text/css" href="wms/fontawesome-free/css/all.min.css">
</head>
<body>
	<?php
		require_once("header.php");
	?>
	<div class="container-fluid" style="margin-bottom: 100px;">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 text-center p-0 mb-5">
				<h1 style="text-align: center;">Contact</h1>
			</div>
			<div class="col-lg-4 text-center">
                <span class="fa fa-map-marker mr-3 cont-icon"></span><span class="cont-det">Kijangwani, Mjini Zanzibar</span>
            </div>
            <div class="col-lg-4 text-center">
                <span class="fa fa-phone text-center cont-icon"></span><span class="cont-det">
            		+255 776 538 771<br>
					+255 778 768 664</span>
            </div>
            <div class="col-lg-4 text-center">
                <a href="javascript:void(0);"><span class="fa fa-envelope mr-3 cont-icon"></span><span class="cont-det">omisal95@gmail.com</span></a>
            </div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 p-0 mb-5">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 p-0 mb-5">
				<fieldset id="comment" style="margin-top: 50px;">
					<legend>Comment</legend>
					<form>
						<div class="form-group">
							<label for="name">Name:</label>
							<input type="email" class="form-control" id="name">
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control" id="email">
						</div>
						<div class="form-group">
							<label for="comment">Email address:</label>
							<textarea class="form-control" id="comment" placeholder="Your comment..." rows="8" style="width: 100%;"></textarea>
						</div>
						<div class="form-group">
							<input type="submit" class="form-control btn-secondary" value="Send Comment" style="font-size: medium;font-weight: bolder;">
						</div>
					</form>
				</fieldset>
			</div>
		</div>
	</div>
	<?php
		require_once("footer.php");
	?>
</body>
</html>