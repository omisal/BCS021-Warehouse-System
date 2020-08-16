<!DOCTYPE html>
<?php
	session_start();
	if (!isset($_SESSION["wh_user"]) || $_SESSION["wh_role"] == "Store Keeper") {
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
		#lblName,#lblLoc{
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
	<div class="row m-3" id="body">
		<div class="col-lg-12">
			<button class="btn btn-success fa fa-plus mr-3" data-toggle="modal" data-target="#newOrderModal"> Make New Order</button>
			<button class="btn btn-success fa fa-search mx-3" data-toggle="modal" data-target="#checkProdModal"> Check Product</button>
			<?php 
			if ($_SESSION["wh_role"]=="Manager") {
			?>
			<a href="manage-placed-order.php" class="btn btn-success fa fa-book mx-3"> View Completed Order</a>
			<?php	
			}
			?>
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
				<caption>List of all Import in the Organization</caption>
				<thead>
					<tr>
						<th>S/N</th>
						<th>Product Detail</th>
						<th>Qty Ordered</th>
						<th>Date Recieved</th>
						<th>Shop</th>
						<th>Qty Complete</th>
						<th>Ordered By</th>
						<th>Status</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try {
				        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				        $query1=$conn->prepare("SELECT orders.OrderID,orders.ShopID,orders.ProductID,CONCAT(products.ProductName,' - ',products.Brand) AS ProdDetail,CONCAT(shops.Label,' - ',shops.Location) AS Shop,orders.Quantity,orders.CompletedQuantity,orders.DateOrdered,staff.FirstName,staff.MiddleName,staff.LastName FROM orders,shops,products,staff WHERE (orders.ShopID=shops.ShopID AND orders.ProductID=products.ProductID AND orders.UserName=staff.UserName)");
				        $query1->execute();
				        $n=0;
				        while($result1=$query1->fetch()){
				        ?>
				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $result1["ProdDetail"];?></td>
				        	<td><?php echo $result1["Quantity"];?></td>
				        	<td><?php echo date_format(date_create($result1["DateOrdered"]),"l, F d, Y h:i:s a");?></td>
				        	<td><?php echo $result1["Shop"];?></td>
				        	<td><?php echo $result1["CompletedQuantity"];?></td>
				        	<td><?php echo $result1["FirstName"].", ".$result1["MiddleName"][0].". ".$result1["LastName"];?></td>
				        	<td><?php echo ($result1["Quantity"]>$result1["CompletedQuantity"]) ? "Not Done":"Done";?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<?php
										if ($result1["CompletedQuantity"]==0) {
										?>
										<a class="dropdown-item fa fa-edit pl-4" onclick="editOrder('<?php echo $result1["OrderID"];?>','<?php echo $result1["ProductID"];?>','<?php echo $result1["Quantity"];?>','<?php echo $result1["ShopID"];?>')" href="javascript:void(0)"> Edit</a>
										<a class="dropdown-item fa fa-edit pl-4 text-danger" onclick="deleteOrder('<?php echo $result1["OrderID"];?>')" href="javascript:void(0)"> Delete</a>
										<?php
										}else{
										?>
										<a class="dropdown-item fa fa-edit pl-4 disabled" href="javascript:void(0)"> Edit</a>
										<a class="dropdown-item fa fa-edit pl-4 disabled" href="javascript:void(0)"> Delete</a>
										<?php
										}
										?>
										

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
						<th>Product Detail</th>
						<th>Qty Ordered</th>
						<th>Date Recieved</th>
						<th>Shop</th>
						<th>Qty Complete</th>
						<th>Ordered By</th>
						<th>Status</th>
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
<div class="modal" id="newOrderModal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-order-handler.php" onsubmit="return validateImport()">
					<input type="hidden" name="action" value="New Order">
					<fieldset>
						<legend>Order Information</legend>
						<div class="form-group">
							<label for="prodID">Product Ordering:</label>
							<select class="form-control form-control-sm" id="prodID" name="prodID" required>
								<option value="">--Select Product--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM products");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['ProductID'];?>"><?php echo $result2['ProductName']." - ".$result2['Brand'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Product is required!</span>
						</div>
						<div class="form-group">
							<label for="quant">Quantity Ordering:</label>
							<input type="number" class="form-control form-control-sm" id="quant" name="quant" placeholder="Quantity Ordering" min="0" required>
							<span class="warn">Quantity is required!</span>
						</div>
						<div class="form-group">
							<label for="shop">Shop:</label>
							<select class="form-control form-control-sm" id="shop" name="shop" required>
								<option value="">--Select Shop--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM shops WHERE Status=1");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['ShopID'];?>"><?php echo $result2['Label']." - ".$result2['Location'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Shop is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Save Import Record</button>
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
<div class="modal" id="editOrderModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-order-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Edit Order">
					<input type="hidden" name="orderID" id="orderID">
					<fieldset>
						<legend>Order Information</legend>
						<div class="form-group">
							<label for="editProdID">Product Ordering:</label>
							<select class="form-control form-control-sm" id="editProdID" name="prodID" required>
								<option value="">--Select Product--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM products");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['ProductID'];?>"><?php echo $result2['ProductName']." - ".$result2['Brand'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Product is required!</span>
						</div>
						<div class="form-group">
							<label for="editQuant">Quantity Ordering:</label>
							<input type="number" class="form-control form-control-sm" id="editQuant" name="quant" placeholder="Quantity Ordering" min="0" required>
							<span class="warn">Quantity is required!</span>
						</div>
						<div class="form-group">
							<label for="editShop">Shop:</label>
							<select class="form-control form-control-sm" id="editShop" name="shop" required>
								<option value="">--Select Shop--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM shops WHERE Status=1");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['ShopID'];?>"><?php echo $result2['Label']." - ".$result2['Location'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Shop is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Order</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<!--Check modal-->
<div class="modal" id="checkProdModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-order-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Check Product" readonly="">
					<fieldset>
						<legend>Product Information</legend>
						<div class="form-group">
							<label for="checkProdID">Product to check:</label>
							<select class="form-control form-control-sm" id="checkProdID" name="prodID" required>
								<option value="">--Select Product--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM products");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['ProductID'];?>"><?php echo $result2['ProductName']." - ".$result2['Brand'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Product is required!</span>
						</div>
					</fieldset>
						<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Check Product</button>
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
<div class="modal" id="deleteOrderModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-product-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Delete Order" readonly="">
					<input type="hidden" name="orderID" id="delOrderID" readonly="">
					<i class="fa fa-exclamation-triangle text-center" style="color: #ff8d8d;font-size: xx-large;display: block;"></i>
					<fieldset>
						<legend></legend>
						<div class="form-group mt-2 text-center">
							Are you sure you want to delete this order.
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
	function editOrder(ordID,prodID,qty,shopID){
		$("#orderID").val(ordID);
		$("#editProdID").val(prodID);
		$("#editQuant").val(qty);
		$("#editShop").val(shopID);
		$("#editOrderModal").modal("show");
	}
	function deleteOrder(id){
		$("#delOrderID").val(id);
		$("#deleteProductModal").modal("show");
	}
</script>
</body>
</html>