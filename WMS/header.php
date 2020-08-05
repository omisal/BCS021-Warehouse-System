<header>
	<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
			<button id="sidenavToogle" class="btn fa fa-bars" onclick="openNav()"></button>
			<img src="../image/logo.gif" style="max-height: 60px;">
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
			<div class="" style="color: #f1f1f1;font-weight: bold;cursor: pointer;">
				<div class="dropdown" style="margin: 10px 10px;">
					<img src="<?php echo "Profiles/".$result1["Photo"];?>" data-toggle="dropdown" style="width: 45px;height: 45px;border-radius: 20px;border: 2px solid #f1f1f1;">
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Profile</a>
						<a class="dropdown-item" href="#">Security</a>
						<a class="dropdown-item" href="logout.php">Sign out</a>
					</div>
				</div> 
			</div>
		</div>
	</div>
</header>