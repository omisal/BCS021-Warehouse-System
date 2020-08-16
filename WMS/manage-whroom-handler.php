<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="New Storage") {
	    $name = $_POST["storeName"];
	    newStorage($name);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Storage") {
	    $storeID = $_POST["storeID"];
	    $storeName = $_POST["storeName"];
	    $oldName = $_POST["oldstoreName"];
	    $status = $_POST["status"];
	    editStorage($storeID,$oldName,$storeName,$status);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Delete Storage") {
	    $id = $_POST["storeID"];
	    deleteStorage($id);
	}else{
		header("location:manage-whroom.php");
	}
	function newStorage($lbl){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT Label FROM storeroom WHERE Label=?");
	        $query1->execute([$lbl]);
	        if ($query1->rowCount()==0){
	        	$query1=$conn->prepare("INSERT INTO storeroom(Label) VALUES (?)");
	        	$query1->execute([$lbl]);
				header("location:manage-whroom.php");
				$_SESSION['sms']="<span class='text-success'>Storage Record Saved Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Storage Label already exist!</span>";
	        	header("location:manage-whroom.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editStorage($id,$oldlbl,$newlbl,$stt){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT Label FROM storeroom WHERE Label=?");
	        $query1->execute([$newlbl]);
	        if ($query1->rowCount()==0 || $newlbl==$oldlbl){
	        	$query1=$conn->prepare("UPDATE storeroom SET Label=?,Status=? WHERE (RoomID=? AND Label=?)");
	        	$query1->execute([$newlbl,$stt,$id,$oldlbl]);
				header("location:manage-whroom.php");
				$_SESSION['sms']="<span class='text-success'>Storage Record updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to update Storage Record!</span>";
	        	header("location:manage-whroom.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function deleteStorage($id){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT Label FROM storeroom WHERE RoomID=?");
	        $query1->execute([$id]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("DELETE FROM storeroom WHERE RoomID=?");
	        	$query1->execute([$id]);
	        	if ($query1) {
	        		$_SESSION['sms']="<span class='text-success'>Storage Record deleted Successfully!</span>";
	        	}else{
	        		$_SESSION['sms']="<span class='text-success'>Sorry! Can't delete this Record as it is being used for other record.Try to change its status to restrict uses.</span>";
	        	}
				header("location:manage-whroom.php");
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to delete Storage Record!</span>";
	        	header("location:manage-whroom.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>