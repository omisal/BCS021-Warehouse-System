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
		#lblName,#lblBrand{
			background-color: #ff8d8d;color:#595959;font-weight: bold;border-radius: 6px;padding: 0px 5px;display: inline-block;
		}
	</style>
</head>
<body>
	<?php
		require_once("navigation.php");
	?>
<div class="page-content" id="content">
	<?php
		require_once("header.php");
	?>
	<div class="row m-3">
		<div class="col-lg-12">
			<button class="btn btn-success fa fa-user-plus" data-toggle="modal" data-target="#newProductModal"> Add New Product</button>
		</div>
		<div class="col-lg-12">
			<div class="text-center my-3" style="font-weight: bold;">
				<?php
					if (isset($_SESSION['sms'])) {
						echo $_SESSION['sms'];
						unset($_SESSION['sms']);
					}
				?>
			</div>
			<table class="table table-sm table-responsive">
				<caption>List of all Products</caption>
				<thead>
					<tr>
						<th>S/N</th>
						<th>Product Name</th>
						<th>Product Brand</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try {
				        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				        $query1=$conn->prepare("SELECT * FROM products");
				        $query1->execute();
				        $n=0;
				        while($result1=$query1->fetch()){
				        ?>
				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $result1["ProductName"];?></td>
				        	<td><?php echo $result1["Brand"];?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item fa fa-edit pl-4" onclick="editProduct('<?php echo $result1["ProductID"];?>','<?php echo $result1["ProductName"];?>','<?php echo $result1["Brand"];?>')" href="javascript:void(0)"> Edit</a>
										<a class="dropdown-item fa fa-trash pl-4 text-danger" onclick="deleteProduct('<?php echo $result1["ProductID"];?>','<?php echo $result1["ProductName"];?>','<?php echo $result1["Brand"];?>')" href="javascript:void(0)"> Delete</a>
									</div>
								</div>
							</td>
						</tr>
				        	<?php
				        }
				    }
				    catch(PDOException $e) {
				        echo "Error: " . $e->getMessage();
				    }
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>S/N</th>
						<th>Product Name</th>
						<th>Product Brand</th>
						<th>More</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<?php
		require_once("footer.php");
	?>
</div>


<div class="modal" id="newProductModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-product-handler.php" onsubmit="return validateProduct()">
					<input type="hidden" name="action" value="New Product">
					<fieldset>
						<legend>Product Information</legend>
						<div class="form-group">
							<label for="prodName">Product Name:</label>
							<input type="text" class="form-control form-control-sm" id="prodName" name="prodName" placeholder="Product Name" required>
							<span class="warn">Product Name is required!</span>
						</div>
						<div class="form-group">
							<label for="prodBrand">Product Brand:</label>
							<input type="text" class="form-control form-control-sm" id="prodBrand" name="prodBrand" placeholder="Product Brand" required>
							<span class="warn">Product Brand is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Save Product Record</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<!--Edit modal-->
<div class="modal" id="editProductModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-product-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Edit Product">
					<input type="hidden" name="prodID" id="prodID">
					<fieldset>
						<legend>Product Information</legend>
						<div class="form-group">
							<label for="prodName">Product Name:</label>
							<input type="text" class="form-control form-control-sm" id="editProdName" name="prodName" placeholder="Product Name" required>
							<span class="warn">Product Name is required!</span>
						</div>
						<div class="form-group">
							<label for="prodBrand">Product Brand:</label>
							<input type="text" class="form-control form-control-sm" id="editProdBrand" name="prodBrand" placeholder="Product Brand" required>
							<span class="warn">Product Brand is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Product Record</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<!--Delete modal-->
<div class="modal" id="deleteProductModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-product-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Delete Product" readonly="">
					<input type="hidden" name="prodID" id="delProdID" readonly="">
					<i class="fa fa-exclamation-triangle text-center" style="color: #ff8d8d;font-size: xx-large;display: block;"></i>
					<fieldset>
						<legend></legend>
						<div class="form-group mt-2 text-center">
							Are you sure you want to delete a product <label id="lblName"></label> withthe brand of <label id="lblBrand"></label>.
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="reset" class="btn form-control" data-dismiss="modal" name="cancel" style="background-color: #4caf50;color: #f1f1f1;max-width: 120px;">No, Cancel</button>
						<button type="submit" class="btn form-control" name="submit" style="background-color: #ff8d8d;color: #000;max-width: 120px;">Yes, Delete</button>
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
	$(document).ready(function() {
		// Sidebar toggle behavior
		$('#sidenavToogle').on('click', function() {
			$('#sidebar, #content').toggleClass('active');
		});		
	});
	function validate(){
		var namePattern=/^[a-zA-Z]+$/;
		var phonePattern=/0\d\d\d\d\d\d\d\d\d/; 
	}
	function editProduct(id,name,brand){
		$("#prodID").val(id);
		$("#editProdName").val(name);
		$("#editProdBrand").val(brand);
		$("#editProductModal").modal("show");
	}
	function deleteProduct(id,name,brand){
		$("#delProdID").val(id);
		$("#lblName").html(name);
		$("#lblBrand").html(brand);
		$("#deleteProductModal").modal("show");
	}
</script>
</body>
</html>