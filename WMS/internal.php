<!DOCTYPE html>
<html>
<head>
	<title>Brainner's Warehouse</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.navbar .nav-item .nav-link{
			color: #f1f1f1;font-weight: bold;font-size: large;
		}
		.carousel img{
			width: 100%;
			max-height: 400px;
		}
		footer{
			background-color: #ffb12c;
			position:fixed;
			bottom: 0px;
			width: 100%;
			font-size: medium;
			font-weight: bold;
			text-align: center;
			color: white;
			padding: 20px;

		}
		 /* The side navigation menu */
.sidenav {
    height: 100%; /* 100% Full-height */
    width: 0; /* 0 width - change this with JavaScript */
    position: fixed; /* Stay in place */
    z-index: 1; /* Stay on top */
    top: 0; /* Stay at the top */
    left: 0;
    background-color: #111; /* Black*/
    overflow-x: hidden; /* Disable horizontal scroll */
    padding-top: 60px; /* Place content 60px from the top */
    transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}
/* Position and style the close button (top right corner) */
.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#mainContent {
    transition: margin-left .5s;
    padding: 20px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
} 
	</style>
</head>
<body style="background-color: #e9e9e9;">
	<header style="background-color: #ffb12c;">
		<button class="btn fa fa-bars" onclick="openNav()"></button>
		<img src="image/logo.gif" style="max-height: 60px;">
		<div class="" style="color: #f1f1f1;font-weight: bold;cursor: pointer;float: right;">
			<div class="dropdown" style="margin: 10px 10px;">
				<button type="button" class="btn" data-toggle="dropdown" style="background-color: #f1f1f1;">
				Omar S Suleiman
				</button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Profile</a>
					<a class="dropdown-item" href="#">Security</a>
					<a class="dropdown-item" href="#">Sign out</a>
				</div>
			</div> 
		</div>
	</header>
	<nav id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn fa fa-bars" onclick="closeNav()"></a>
		<ul class="nav flex-column nav-pills">
			<li class="nav-item">
				<a class="nav-link active" href="#">Active</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Separated link</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>
	</nav>
	<div id="mainContent" style="margin-bottom: 100px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 text-center p-0">
					My content
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
	</div>
	
	
	<footer class="footer">
		<div id="footer">
			Copyright Brainners &copy; 2020 All rights reserved.
		</div>
	</footer>

<!-- The Modal -->
<div class="modal" id="loginModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #ffb12c;color: #f1f1f1;">
				<h5 class="modal-title">Login</h5>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="user">User Name:</label>
						<input type="user" class="form-control" id="user" placeholder="User Name">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd" placeholder="Password">
					</div>
					<div class="form-group">
						<a href="">Forget Password</a>
					</div>
					<div class="form-group">
						<button type="submit" class="btn form-control" style="background-color: #ffb12c;color: #f1f1f1;">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #ffb12c;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("mainContent").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("mainContent").style.marginLeft = "0";
}
openNav();
</script>
	
</body>
</html>