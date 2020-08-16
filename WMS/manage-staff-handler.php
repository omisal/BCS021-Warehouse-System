<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="New Staff") {
	    $user = $_POST["user"];
	    $role = $_POST["role"];
	    $fName = $_POST["fName"];
	    $mName = $_POST["mName"];
	    $lName = $_POST["lName"];
	    $dob = $_POST["dob"];
	    $gender = $_POST["gender"];
	    $email = $_POST["email"];
	    $phone = $_POST["phone"];
	    $address = $_POST["address"];
	    newStaff($user,$role,$fName,$mName,$lName,$dob,$gender,$email,$phone,$address);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Staff") {
	    $olduser = $_POST["oldUserName"];
	    $newuser = $_POST["user"];
	    $role = $_POST["role"];
	    editStaff($olduser,$newuser,$role);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Delete Staff") {
	    $user = $_POST["userName"];
	    deleteStaff($user);
	}else{
		header("location:manage-staff.php");
	}
	function newStaff($user,$role,$fName,$mName,$lName,$dob,$gnd,$email,$phone,$address){
		require_once("connection.php");
		$pass=sha1("12345");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT UserName FROM staff WHERE UserName=?");
	        $query1->execute([$user]);
	        if ($query1->rowCount()==0){
	        	$query1=$conn->prepare("INSERT INTO staff(UserName, Password, FirstName, MiddleName, LastName, DOB, Gender, Address, Email, Phone, Photo, Role) VALUES (?,?,?,?,?,?,?,?,?,?,'avatar.png',?)");
	        	$query1->execute([$user,$pass,$fName,$mName,$lName,$dob,$gnd,$address,$email,$phone,$role]);
				header("location:manage-staff.php");
				$_SESSION['sms']="<span class='text-success'>Staff Record Saved Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Username already exist!</span>";
	        	header("location:manage-staff.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editStaff($olduser,$newuser,$role){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT UserName FROM staff WHERE UserName=?");
	        $query1->execute([$newuser]);
	        if ($query1->rowCount()==0 || $newuser==$olduser){
	        	$query1=$conn->prepare("UPDATE staff SET UserName=?,Role=? WHERE UserName=?");
	        	$query1->execute([$newuser,$role,$olduser]);
				header("location:manage-staff.php");
				$_SESSION['sms']="<span class='text-success'>Staff Record updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to update Staff Record!</span>";
	        	header("location:manage-staff.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function deleteStaff($user){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT UserName FROM staff WHERE UserName=?");
	        $query1->execute([$user]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("DELETE FROM staff WHERE UserName=?");
	        	$query1->execute([$user]);
				header("location:manage-staff.php");
				$_SESSION['sms']="<span class='text-success'>Staff Record deleted Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to delete Staff Record!</span>";
	        	header("location:manage-staff.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>