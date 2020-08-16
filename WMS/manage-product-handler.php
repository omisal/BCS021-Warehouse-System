<?php
	session_start();
	if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="New Product") {
	    $name = $_POST["prodName"];
	    $brand = $_POST["prodBrand"];
	    newProduct($name,$brand);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Product") {
	    $prodID = $_POST["prodID"];
	    $name = $_POST["prodName"];
	    $brand = $_POST["prodBrand"];
	    editProduct($prodID,$name,$brand);
	}elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Delete Product") {
	    $id = $_POST["prodID"];
	    deleteProduct($id);
	}else{
		header("location:manage-product.php");
	}
	function newProduct($name,$brand){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT ProductName FROM products WHERE (ProductName=? AND Brand=?)");
	        $query1->execute([$name,$brand]);
	        if ($query1->rowCount()==0){
	        	$query1=$conn->prepare("INSERT INTO products(ProductName, Brand) VALUES (?,?)");
	        	$query1->execute([$name,$brand]);
				header("location:manage-product.php");
				$_SESSION['sms']="<span class='text-success'>Product Record Saved Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Same product already exist with the same brand!</span>";
	        	header("location:manage-product.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function editProduct($prodID,$name,$brand){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT ProductName FROM products WHERE (ProductName=? AND Brand=?)");
	        $query1->execute([$name,$brand]);
	        if ($query1->rowCount()==0){
	        	$query1=$conn->prepare("UPDATE products SET ProductName=?,Brand=? WHERE ProductID=?");
	        	$query1->execute([$name,$brand,$prodID]);
				header("location:manage-product.php");
				$_SESSION['sms']="<span class='text-success'>Product Record updated Successfully!</span>";
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Same product already exist with the same brand!</span>";
	        	header("location:manage-product.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
	function deleteProduct($id){
		require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT ProductName FROM products WHERE ProductID=?");
	        $query1->execute([$id]);
	        if ($query1->rowCount()==1){
	        	$query1=$conn->prepare("DELETE FROM products WHERE ProductID=?");
	        	$query1->execute([$id]);
	        	if ($query1) {
	        		$_SESSION['sms']="<span class='text-success'>Product Record deleted Successfully!</span>";
	        	}else{
	        		$_SESSION['sms']="<span class='text-success'>Sorry! Can't delete this Record cause it is being used for other record.</span>";
	        	}
				header("location:manage-product.php");
	        }else{
	        	$_SESSION['sms']="<span class='text-danger'>Fail to delete Product Record!</span>";
	        	header("location:manage-product.php");
	        }
	        $conn = null; 
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	}
?>