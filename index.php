<!DOCTYPE html>
<html>
<head>
	<title>Brainner's Warehouse</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="wms/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="wms/js/popper.min.js"></script>
	<script type="text/javascript" src="wms/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="wms/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body style="background-color: #e9e9e9;">
	<?php
		require_once("header.php");
	?>
	<div class="container-fluid" style="margin-bottom: 100px;">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 text-center p-0">
				<div id="demo" class="carousel slide" data-ride="carousel">
					<ul class="carousel-indicators">
						<li data-target="#demo" data-slide-to="0" class="active"></li>
						<li data-target="#demo" data-slide-to="1"></li>
						<li data-target="#demo" data-slide-to="2"></li>
						<li data-target="#demo" data-slide-to="3"></li>
						<li data-target="#demo" data-slide-to="4"></li>
						<li data-target="#demo" data-slide-to="5"></li>
						<li data-target="#demo" data-slide-to="6"></li>
						<li data-target="#demo" data-slide-to="7"></li>
						<li data-target="#demo" data-slide-to="8"></li>
					</ul>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="image/a0.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/a3.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/a5.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/a6.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/a7.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/a9.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/b0.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/b2.jpg" alt="Brainner's Warehouse">
						</div>
						<div class="carousel-item">
							<img src="image/b5.jpg" alt="Brainner's Warehouse">
						</div>
					</div>
					<a class="carousel-control-prev" href="#demo" data-slide="prev">
						<span class="carousel-control-prev-icon"></span>
					</a>
					<a class="carousel-control-next" href="#demo" data-slide="next">
						<span class="carousel-control-next-icon"></span>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 p-0 text-justify">
				<div class="jumbotron jumbotron-fluid" style="background-color: #f1f1f1;margin: 0px;">
					<div class="container">
						<h2>Welcome to Brainner's Warehousing Cop.</h2>
						<p>W3Schools is optimized for learning, testing, and training. Examples might be simplified to improve reading and basic understanding. Tutorials, references, and examples are constantly reviewed to avoid errors, but we cannot warrant full correctness of all content. While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy. W3Schools is optimized for learning, testing, and training. Examples might be simplified to improve reading and basic understanding. Tutorials, references, and examples are constantly reviewed to avoid errors, but we cannot warrant full correctness of all content. While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 mt-3">
				<h3>NEWS</h3>
				No news
			</div>
		</div>
	</div>
	<?php
		require_once("footer.php");
	?>
</body>
</html>