<!DOCTYPE html>
<?php
	session_start();
	if (!isset($_SESSION["wh_user"]) || $_SESSION["wh_role"] != "Manager") {
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
	<style type="text/css">
		#lblName,#lblUser{
			background-color: #ff8d8d;color:#595959;font-weight: bold;border-radius: 6px;padding: 0px 5px;display: inline-block;
		}
	</style>
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
			<button class="btn btn-success fa fa-user-plus" data-toggle="modal" data-target="#newStaffModal"> Add New Staff</button>
		</div>
		<div class="col-lg-12">
			<div class="text-center my-3" style="font-weight: bold;">
				<?php
					if (isset($_SESSION['sms'])) {
						echo $_SESSION['sms'];
						unset($_SESSION['sms']);
					}
				?>
			</div>
			<table class="table table-sm table-responsive">
				<caption>List of all Staff in the Organization</caption>
				<thead>
					<tr>
						<th>S/N</th>
						<th>Full Name</th>
						<th>Date of Birth</th>
						<th>Gender</th>
						<th>Address</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Role</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try {
				        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				        $query1=$conn->prepare("SELECT * FROM staff,role WHERE (staff.Role=role.RoleID)");
				        $query1->execute();
				        $n=0;
				        while($result1=$query1->fetch()){
				        	$name=$result1["FirstName"].", ".$result1["MiddleName"][0].". ".$result1["LastName"];
				        ?>

				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $name;?></td>
				        	<td><?php echo date_format(date_create($result1['DOB']),"l, F d, Y");?></td>
				        	<td><?php echo (($result1['Gender']=='M') ? "Male" : "Female");?></td>
				        	<td><?php echo $result1["Address"];?></td>
				        	<td><?php echo $result1["Email"];?></td>
				        	<td><?php echo $result1["Phone"];?></td>
				        	<td><?php echo $result1["Title"];?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item fa fa-edit pl-4" onclick="editStaff('<?php echo $result1["UserName"];?>','<?php echo $result1["Role"];?>')" href="javascript:void(0)"> Edit</a>
										<a class="dropdown-item fa fa-trash pl-4 text-danger" onclick="deleteStaff('<?php echo $result1["UserName"];?>','<?php echo $name;?>')" href="javascript:void(0)"> Delete</a>
									</div>
								</div>
							</td>
						</tr>
				        	<?php
				        }
				    }
				    catch(PDOException $e) {
				        echo "Error: " . $e->getMessage();
				    }
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>S/N</th>
						<th>Full Name</th>
						<th>Date of Birth</th>
						<th>Gender</th>
						<th>Address</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Role</th>
						<th>More</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<?php
		require_once("footer.php");
	?>
</div>


<div class="modal" id="newStaffModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-staff-handler.php">
					<input type="hidden" name="action" value="New Staff">
					<fieldset>
						<legend>Personal Information</legend>
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="form-group">
									<label for="fName">First Name:</label>
									<input type="text" class="form-control form-control-sm" id="fName" name="fName" placeholder="First Name" required>
									<span class="warn">First Name is required!</span>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="form-group">
									<label for="mName">Middle Name:</label>
									<input type="text" class="form-control form-control-sm" id="mName" name="mName" placeholder="Middle Name" required>
									<span class="warn">Middle Name is required!</span>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="form-group">
									<label for="lName">Last Name:</label>
									<input type="text" class="form-control form-control-sm" id="lName" name="lName" placeholder="Last Name" required>
									<span class="warn">Last Name is required!</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="dob">Date of Birth:</label>
									<?php 
                                        $date=date_create(date("Y-m-d"));
                                        date_sub($date,date_interval_create_from_date_string("18 years"));
                                    ?>
									<input type="date" class="form-control form-control-sm" id="dob" name="dob" placeholder="Date of Birth" max="<?php echo date_format($date,"Y-m-d");?>" required>
									<span class="warn">Date of Birth is required!</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="gender">Gender:</label>
									<select class="form-control form-control-sm" id="gender" name="gender" required>
										<option value="">--Select Gender--</option>
										<option value="M">Male</option>
										<option value="F">Female</option>
									</select>
									<span class="warn">Gender is required!</span>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Contacts Information</legend>
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="form-group">
									<label for="email">Email:</label>
									<input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="email@hostname.com" required>
									<span class="warn">Email is required!</span>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="form-group">
									<label for="phone">Phone Number:</label>
									<input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="0987654321" pattern="0\d\d\d\d\d\d\d\d\d" title="Should contain 10 digits, the first is 0" required>
									<span class="warn">Phone Number is required!</span>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="form-group">
									<label for="address">Address:</label>
									<input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Address" required>
									<span class="warn">Address is required!</span>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Account Information</legend>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="user">Username:</label>
									<input type="text" class="form-control form-control-sm" id="user" name="user" placeholder="Username" required>
									<span class="warn">Username is required!</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="role">Role:</label>
									<select class="form-control form-control-sm" id="role" name="role" required>
										<option value="">--Select Role--</option>
									<?php
									try {
								        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								        $query2=$conn->prepare("SELECT * FROM role");
								        $query2->execute();
								        while($result2=$query2->fetch()){
								        ?>
								        <option value="<?php echo $result2['RoleID'];?>"><?php echo $result2['Title'];?></option>
								        <?php
								        }
								    }catch(PDOException $e){
								    	echo "Error: " . $e->getMessage();
								    }
							        ?>
									</select>
									<span class="warn">Role is required!</span>
								</div>
							</div>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;" onclick="return validateStaff()">Save Staff Record</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<!--Edit modal-->
<div class="modal" id="editStaffModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-staff-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Edit Staff">
					<input type="hidden" name="oldUserName" id="oldUserName">
					<fieldset>
						<legend>Account Information</legend>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group">
									<label for="newuser">New Username:</label>
									<input type="text" class="form-control form-control-sm" id="newuser" name="user" placeholder="Username" required>
									<span class="warn">Username is required!</span>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group">
									<label for="newrole">Role:</label>
									<select class="form-control form-control-sm" id="newrole" name="role" required>
										<option value="">--Select Role--</option>
									<?php
									try {
								        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								        $query2=$conn->prepare("SELECT * FROM role");
								        $query2->execute();
								        while($result2=$query2->fetch()){
								        ?>
								        <option value="<?php echo $result2['RoleID'];?>"><?php echo $result2['Title'];?></option>
								        <?php
								        }
								    }catch(PDOException $e){
								    	echo "Error: " . $e->getMessage();
								    }
							        ?>
									</select>
									<span class="warn">Role is required!</span>
								</div>
							</div>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Staff Record</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<!--Delete modal-->
<div class="modal" id="deleteStaffModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-staff-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Delete Staff" readonly="">
					<input type="hidden" name="userName" id="delUserName" readonly="">
					<i class="fa fa-exclamation-triangle text-center" style="color: #ff8d8d;font-size: xx-large;display: block;"></i>
					<fieldset>
						<legend></legend>
						<div class="form-group mt-2 text-center">
							Are you sure you want to delete <label id="lblName"></label> with user name <label id="lblUser"></label>.
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="reset" class="btn form-control" data-dismiss="modal" name="cancel" style="background-color: #4caf50;color: #f1f1f1;max-width: 120px;">No, Cancel</button>
						<button type="submit" class="btn form-control" name="submit" style="background-color: #ff8d8d;color: #000;max-width: 120px;">Yes, Delete</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		// Sidebar toggle behavior
		$('#sidenavToogle').on('click', function() {
			$('#sidebar, #content').toggleClass('active');
		});
		//$("#newStaffModal").modal("show");
		
	});
	function validateStaff(){
		var valid=true;
		var namePattern=/^[a-zA-Z]+$/;
		var phonePattern=/0\d\d\d\d\d\d\d\d\d/; 
		if ($("#fName").val()=="") {valid=false;$("#fName").next().css("display","block");}
		else{$("#fName").next().css("display","none");}
		if ($("#mName").val()=="") {valid=false;$("#mName").next().css("display","block");}
		else{$("#mName").next().css("display","none");}
		if ($("#lName").val()=="") {valid=false;$("#lName").next().css("display","block");}
		else{$("#lName").next().css("display","none");}
		if ($("#dob").val()=="") {valid=false;$("#dob").next().css("display","block");}
		else{$("#dob").next().css("display","none");}
		if ($("#gender").val()=="") {valid=false;$("#gender").next().css("display","block");}
		else{$("#gender").next().css("display","none");}
		if ($("#email").val()=="") {valid=false;$("#email").next().css("display","block");}
		else if ($("#email").val().search(/@/i)== -1 || $("#email").val().search(/.com/i)== -1 ){
			valid=false;$("#email").next().css("display","block");}
		else{$("#email").next().css("display","none");}
		if ($("#phone").val()=="" || !phonePattern.test($("#phone").val())) {valid=false;$("#phone").next().css("display","block");}
		else{$("#phone").next().css("display","none");}
		if ($("#address").val()=="") {valid=false;$("#address").next().css("display","block");}
		else{$("#address").next().css("display","none");}
		if ($("#user").val()=="") {valid=false;$("#user").next().css("display","block");}
		else{$("#user").next().css("display","none");}
		if ($("#role").val()=="") {valid=false;$("#role").next().css("display","block");}
		else{$("#role").next().css("display","none");}
		return valid;
	}
	function editStaff(user,role){
		$("#oldUserName").val(user);
		$("#newuser").val(user);
		$("#newrole").val(role);
		$("#editStaffModal").modal("show");
	}
	function deleteStaff(user,name){
		$("#delUserName").val(user);
		$("#lblUser").html(user);
		$("#lblName").html(name);
		$("#deleteStaffModal").modal("show");
	}
</script>
</body>
</html>