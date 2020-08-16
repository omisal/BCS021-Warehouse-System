<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Complete Order") {
	    $orderID = $_POST["orderID"];
	    $import = $_POST["import"];
	    $quant = $_POST["compQuant"];
	    completeOrder($orderID,$import,$quant);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Order") {
	    $ordID = $_POST["orderID"];
	    $prodID = $_POST["prodID"];
	    $quant = $_POST["quant"];
	    $shop = $_POST["shop"];
	    editOrder($ordID,$prodID,$quant,$shop);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Delete Order") {
	    $id = $_POST["orderID"];
	    deleteOrder($id);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Check Product") {
	    $id = $_POST["prodID"];
	    checkOrder($id);
	}else{
		header("location:manage-placed-order.php");
	}
	function completeOrder($order,$import,$quant){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("INSERT INTO ordercompleted(OrderID, ImportID, Quantity, DateIssued, UserName) VALUES (?,?,?,CURRENT_TIMESTAMP,?)");
        	$query1->execute([$order,$import,$quant,$_SESSION["wh_user"]]);
        	$query2=$conn->prepare("SELECT StokeRemain FROM imports WHERE ImportID=?");
        	$query2->execute([$import]);
        	$result2=$query2->fetch();
        	$query2=$conn->prepare("UPDATE imports SET StokeRemain=StokeRemain-? WHERE ImportID=?");
        	$query2->execute([$quant,$import]);
			$query2=$conn->prepare("UPDATE orders SET CompletedQuantity=CompletedQuantity+? WHERE OrderID=?");
        	$query2->execute([$quant,$import]);
			header("location:manage-placed-order.php");
			$_SESSION['sms']="<span class='text-success'>Order has been completed Successfully!</span>";
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editOrder($ordID,$prodID,$quant,$shop){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT OrderID FROM orders WHERE OrderID=?");
	        $query1->execute([$ordID]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("UPDATE orders SET ShopID=?,ProductID=?,Quantity=?,DateOrdered=CURRENT_TIMESTAMP,UserName=? WHERE OrderID=?");
	        	$query1->execute([$shop,$prodID,$quant,$_SESSION["wh_user"],$ordID]);
				header("location:manage-placed-order.php");
				$_SESSION['sms']="<span class='text-success'>Order has been updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to update Order!</span>";
	        	header("location:manage-placed-order.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function deleteOrder($id){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT OrderID FROM orders WHERE OrderID=?");
	        $query1->execute([$id]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("DELETE FROM orders WHERE OrderID=?");
	        	$query1->execute([$id]);
				header("location:manage-placed-order.php");
				$_SESSION['sms']="<span class='text-success'>Order has been Deleted Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to delete Order!</span>";
	        	header("location:manage-placed-order.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }	
	}
	function checkOrder($id){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT products.ProductName,products.Brand,COUNT(imports.StoreRoom) AS Cnt,SUM(imports.StokeRemain) AS Total FROM imports,products WHERE (imports.ProductID=products.ProductID AND imports.StoreRoom>0 AND products.ProductID=?) GROUP BY products.ProductName,products.Brand");
	        $query1->execute([$id]);
	        if ($query1->rowCount()>0){
	        	$result1=$query1->fetch();
				$_SESSION['sms']="<span class='text-success'>There are ".$result1["Total"]." ".$result1["ProductName"]." - ".$result1["Brand"]." in stock from ".$result1["Cnt"]." import(s)</span>";
	        	header("location:manage-placed-order.php");
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Currently the product you checked is not available!</span>";
	        	header("location:manage-placed-order.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }	
	}
?>