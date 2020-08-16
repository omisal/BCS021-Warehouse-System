<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="New Supplier") {
	    $name = $_POST["supName"];
	    $email = $_POST["email"];
	    $phone = $_POST["phone"];
	    newSupplier($name,$email,$phone);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Supplier") {
	    $supID = $_POST["supID"];
	    $name = $_POST["supName"];
	    $email = $_POST["email"];
	    $phone = $_POST["phone"];
	    editSupplier($supID,$name,$email,$phone);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Delete Supplier") {
	    $id = $_POST["supID"];
	    deleteSupplier($id);
	}else{
		header("location:manage-supplier.php");
	}
	function newSupplier($name,$email,$phone){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("INSERT INTO supplier(SupplierName, Email, Phone) VALUES (?,?,?)");
        	$query1->execute([$name,$email,$phone]);
			header("location:manage-supplier.php");
			$_SESSION['sms']="<span class='text-success'>Supplier Record Saved Successfully!</span>";
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editSupplier($supID,$name,$email,$phone){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT SupplierName FROM supplier WHERE SupplierID=?");
	        $query1->execute([$supID]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("UPDATE supplier SET SupplierName=?,Email=?,Phone=? WHERE SupplierID=?");
	        	$query1->execute([$name,$email,$phone,$supID]);
				header("location:manage-supplier.php");
				$_SESSION['sms']="<span class='text-success'>Supplier Record updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to update Supplier Record!</span>";
	        	header("location:manage-supplier.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function deleteSupplier($id){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT SupplierName FROM supplier WHERE SupplierID=?");
	        $query1->execute([$id]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("DELETE FROM supplier WHERE SupplierID=?");
	        	$query1->execute([$id]);
	        	if ($query1) {
	        		$_SESSION['sms']="<span class='text-success'>Supplier Record deleted Successfully!</span>";
	        	}else{
	        		$_SESSION['sms']="<span class='text-success'>Sorry! Can't delete this Record as it is being used for other record.Try to change its status to restrict uses.</span>";
	        	}
				header("location:manage-supplier.php");
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to delete Supplier Record!</span>";
	        	header("location:manage-supplier.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>