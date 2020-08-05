<header>
	<nav class="navbar navbar-expand-md navbar-dark" style="padding: 0px 5px;background-color: #4caf50;">
		<a class="navbar-brand" href="#" style="padding: 0px;">
			<img src="image/logo.gif" style="max-height: 60px;">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about.php">About</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Our Services</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Internal Warehouses</a>
						<a class="dropdown-item" href="#">Warehouse for Hire</a>
						<a class="dropdown-item" href="#">Brainner's Shops</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
				<li class="nav-item log-sm">
					<a class="nav-link" data-toggle="modal" data-target="#loginModal">Login</a>
				</li>
			</ul>
		</div>
		<div class="log-lg" style="color: #f1f1f1;font-weight: bold;cursor: pointer;">
			<a class="nav-link" data-toggle="modal" data-target="#loginModal">Login</a>
		</div>
	</nav>	
</header>


<!--Login form modal-->
<div class="modal" id="loginModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title">Login</h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="login.php" onsubmit="return validateLogin()">
					<div class="form-group">
						<label for="user">User Name:</label>
						<input type="user" class="form-control" id="user" name="user" placeholder="User Name">
						<span id="userWarn" class="warn">User name is required!</span>
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
						<span id="pwdWarn" class="warn">Password is required!</span>
					</div>
					<div class="form-group">
						<a href="">Forget Password</a>
					</div>
					<div class="form-group">
						<button type="submit" class="btn form-control" style="background-color: #4caf50;color: #f1f1f1;">Login</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>