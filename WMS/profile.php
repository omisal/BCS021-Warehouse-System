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
    <style type="text/css">
        
    </style>
</head>
<body>
	<?php
		require_once("navigation.php");
	?>
<div class="page-content" id="content">
	<?php
		require_once("header.php");
        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query2=$conn->prepare("SELECT * FROM staff WHERE UserName=?");
            $query2->execute([$_SESSION["wh_user"]]);    
            $result2=$query2->fetch(); 
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
	?>
	<div class="row m-3">
		<div class="col-lg-12">
            <div class="text-center my-3" style="font-weight: bold;">
                <?php
                    if (isset($_SESSION['sms'])) {
                        echo $_SESSION['sms'];
                        unset($_SESSION['sms']);
                    }
                ?>
            </div>
			<ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#view">View Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#edit">Edit Profile</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane container active" id="view">
                    <div class="row">
                        <div class="col-md-4 py-4">
                            <div class="profile-pic">
                                <p><img src="<?php echo 'Profiles/'.$result2['Photo']; ?>" class="img-circle img-thumbnail" style="width: 200px;height: 200px;"></p>
                            </div>
                        </div>
                        <div class="col-md-8 profile-text py-4">
                            <h4>Profile Info.</h4>
                            <h3><?php echo $result2['FirstName']." ".$result2['MiddleName']." ".$result2['LastName']; ?></h3>
                            <h5><?php echo $_SESSION["wh_role"]; ?></h5>
                            <p>
                                <span><?php 
                                if ($result2["Gender"]=="M"){
                                    echo "<i class='fa fa-male'></i> Male";
                                }else{
                                    echo "<i class='fa fa-female'></i> Female";
                                } ?></span>, born <span><?php echo date_format(date_create($result2["DOB"]),"D, d-M-Y");?></span>.
                                
                            </p>
                            <p>
                                <span><i class="fa fa-phone"></i> <?php echo $result2['Phone']; ?></span><br>
                                <span><i class="fa fa-envelope"></i> <?php echo $result2['Email']; ?></span>
                                <br>
                                <span><i class="fa fa-home"></i> <?php echo $result2['Address']; ?></span>
                            </p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#passwordModal">Change Passwordd</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane container fade" id="edit">
                    <form method="POST" action="profile-handler.php" enctype="multipart/form-data" onsubmit="return validateLogin()">
                        <input type="hidden" name="action" value="Edit Profile">
                        <fieldset>
                            <legend>Personal Information</legend>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fName">First Name:</label>
                                        <input type="text" class="form-control form-control-sm" id="fName" name="fName" placeholder="First Name" value="<?php echo $result2['FirstName']; ?>" required>
                                        <span class="warn">First Name is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="mName">Middle Name:</label>
                                        <input type="text" class="form-control form-control-sm" id="mName" name="mName" placeholder="Middle Name" value="<?php echo $result2['MiddleName']; ?>" required>
                                        <span class="warn">Middle Name is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="lName">Last Name:</label>
                                        <input type="text" class="form-control form-control-sm" id="lName" name="lName" placeholder="Last Name" value="<?php echo $result2['LastName']; ?>" required>
                                        <span class="warn">Last Name is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth:</label>
                                        <?php 
                                        $date=date_create(date("Y-m-d"));
                                        date_sub($date,date_interval_create_from_date_string("18 years"));?>
                                        <input type="date" class="form-control form-control-sm" id="dob" name="dob" placeholder="Date of Birth" max="<?php echo date_format($date,"Y-m-d");?>" value="<?php echo $result2['DOB']; ?>" required>
                                        <span class="warn">Date of Birth is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="gender">Gender:</label>
                                        <select class="form-control form-control-sm" id="gender" name="gender" required>
                                            <option value="">--Select Gender--</option>
                                            <option <?php if($result2['Gender']=='M'){echo 'selected';} ?> value="M">Male</option>
                                            <option <?php if($result2['Gender']=='F'){echo 'selected';} ?> value="F">Female</option>
                                        </select>
                                        <span class="warn">Gender is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label for="photo">Photo</label>
                                    <div class="custom-file">
                                        <input type="file" name="photo" id="photo" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif" style="max-height: 30px;">
                                        <label class="custom-file-label" for="photo" style="color: #515151;text-align: left;max-height: 30px;">Change Photo</label>
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
                                        <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="email@hostname.com" value="<?php echo $result2['Email']; ?>" required>
                                        <span class="warn">Email is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="phone">Phone Number:</label>
                                        <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="0987654321" pattern="0\d\d\d\d\d\d\d\d\d" title="Should contain 10 digits, the first is 0" value="<?php echo $result2['Phone']; ?>" required>
                                        <span class="warn">Phone Number is required!</span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Address" value="<?php echo $result2['Address']; ?>" required>
                                        <span class="warn">Address is required!</span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group mt-2 text-center">
                            <button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Profile</button>
                        </div>
                    </form>
                </div>
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
<div class="modal" id="passwordModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
                <h5 class="modal-title">Change Password</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="profile-handler.php" onsubmit="">
                    <input type="hidden" name="action" value="Change Password">
                    <div class="form-group">
                        <label for="opwd">Current Password:</label>
                        <input type="password" class="form-control" id="opwd" name="opwd" placeholder="Current Password" required="">
                        <span id="opwdWarn" class="warn">Current Password is required!</span>
                    </div>
                    <div class="form-group">
                        <label for="npwd">New Password:</label>
                        <input type="password" class="form-control" id="npwd" name="npwd" placeholder="New Password" required="">
                        <span id="npwdWarn" class="warn">New Password is required!</span>
                    </div>
                    <div class="form-group">
                        <label for="cpwd">Confirm Password:</label>
                        <input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="Confirm Password" required="">
                        <span id="cpwdWarn" class="warn">Password does not match!</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn form-control" onclick="return validatePassword()" style="background-color:#4caf50;color: #f1f1f1;">Change Password</button>
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
    function validatePassword(){
        var valid=true;
        if ($("#opwd").val()=="") {valid=false;$("#opwdWarn").css("display","block");}
        else{$("#opwdWarn").css("display","none");}
        if ($("#npwd").val()=="") {valid=false;$("#npwdWarn").css("display","block");}
        else{$("#npwdWarn").css("display","none");}
        if ($("#npwd").val()!= $("#cpwd").val()) {valid=false;$("#cpwdWarn").css("display","block");}
        else{$("#cpwdWarn").css("display","none");}
        return valid;
    }
</script>
</body>
</html>