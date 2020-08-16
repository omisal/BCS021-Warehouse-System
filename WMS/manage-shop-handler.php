<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="New Shop") {
	    $name = $_POST["shopName"];
	    $loc = $_POST["shopLoc"];
	    newShop($name,$loc);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Shop") {
	    $shopID = $_POST["shopID"];
	    $name = $_POST["shopName"];
	    $loc = $_POST["shopLoc"];
	    $status = $_POST["status"];
	    editShop($shopID,$name,$loc,$status);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Delete Shop") {
	    $id = $_POST["shopID"];
	    deleteShop($id);
	}else{
		header("location:manage-shop.php");
	}
	function newShop($lbl,$loc){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("INSERT INTO shops(Label, Location) VALUES (?,?)");
        	$query1->execute([$lbl,$loc]);
			header("location:manage-shop.php");
			$_SESSION['sms']="<span class='text-success'>Shop Record Saved Successfully!</span>";
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editShop($id,$name,$loc,$stt){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT Label FROM shops WHERE ShopID=?");
	        $query1->execute([$id]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("UPDATE shops SET Label=?,Location=?,Status=? WHERE ShopID=?");
	        	$query1->execute([$name,$loc,$stt,$id]);
				header("location:manage-shop.php");
				$_SESSION['sms']="<span class='text-success'>Shop Record updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to update Shop Record!</span>";
	        	header("location:manage-shop.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function deleteShop($id){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT Label FROM shops WHERE ShopID=?");
	        $query1->execute([$id]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("DELETE FROM shops WHERE ShopID=?");
	        	$query1->execute([$id]);
	        	if ($query1) {
	        		$_SESSION['sms']="<span class='text-success'>Shop Record deleted Successfully!</span>";
	        	}else{
	        		$_SESSION['sms']="<span class='text-success'>Sorry! Can't delete this Record as it is being used for other record.Try to change its status to restrict uses.</span>";
	        	}
				header("location:manage-shop.php");
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to delete Shop Record!</span>";
	        	header("location:manage-shop.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>