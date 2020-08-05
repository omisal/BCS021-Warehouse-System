<?php
	//echo bin2hex("omisal");
	session_start();
	if (isset($_POST["user"]) && isset($_POST["pwd"])) {
	    $username = filter_var($_POST["user"]);
	    $password = filter_var($_POST["pwd"]);
	    login($username,$password);
	}
	function login($user,$pass){
		require_once("WMS/connection.php");
		$pass=sha1($pass);
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT staff.UserName,role.Title FROM staff,role WHERE (staff.Role=role.RoleID AND staff.UserName=? AND staff.Password=?)");
	        $query1->execute([$user,$pass]);
	        if ($query1->rowCount()==1) {
	        	$result1=$query1->fetch();
	        	$_SESSION["wh_user"]=$result1["UserName"];
				$_SESSION["wh_role"]=$result1["Title"];
				header("location:WMS/index.php");
	        }else{
	        	header("location:index.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>