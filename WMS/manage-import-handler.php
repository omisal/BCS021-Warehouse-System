<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="New Import") {
	    $prodID = $_POST["prodID"];
	    $manufDate = $_POST["manufDate"];
	    $expDate = $_POST["expDate"];
	    $quant = $_POST["quant"];
	    $supplier = $_POST["supplier"];
	    $storage = $_POST["storage"];
	    newImport($prodID,$manufDate,$expDate,$quant,$storage,$supplier);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Import") {
	    $impID = $_POST["importID"];
	    $prodID = $_POST["prodID"];
	    $supplier = $_POST["supplier"];
	    $storage = $_POST["storage"];
	    editImport($impID,$prodID,$supplier,$storage);
	}else{
		header("location:manage-import.php");
	}
	function newImport($prodID,$manufDate,$expDate,$quant,$storage,$supplier){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("INSERT INTO imports(ProductID, ManufactDate, ExpireDate, Quantity, StoreRoom, UserName, SupplierID, DateRecieved, StokeRemain) VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP,?)");
        	$query1->execute([$prodID,$manufDate,$expDate,$quant,$storage,$_SESSION["wh_user"],$supplier,$quant]);
			header("location:manage-import.php");
			$_SESSION['sms']="<span class='text-success'>Import Record Saved Successfully!</span>";
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editImport($impID,$prodID,$supplier,$storage){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT ImportID FROM imports WHERE ImportID=?");
	        $query1->execute([$impID]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("UPDATE imports SET ProductID=?,StoreRoom=?,SupplierID=? WHERE ImportID=?");
	        	$query1->execute([$prodID,$storage,$supplier,$impID]);
				header("location:manage-import.php");
				$_SESSION['sms']="<span class='text-success'>Import Record updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to update Import Record!</span>";
	        	header("location:manage-import.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>