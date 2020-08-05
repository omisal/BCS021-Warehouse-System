<?php
	session_start();
	if (isset($_SESSION["wh_user"])) {
	    logout();
	}
	function logout(){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("UPDATE staff SET LastLogin=CURRENT_TIMESTAMP WHERE UserName=?");
	        $query1->execute([$_SESSION["wh_user"]]);
	        session_destroy();
	        $conn = null;
	        header("location:../index.php"); 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>