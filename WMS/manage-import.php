<!DOCTYPE html>
<?php
	session_start();
	if (!isset($_SESSION["wh_user"]) || $_SESSION["wh_role"] == "Shop Keeper") {
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
	<div class="row m-3">
		<div class="col-lg-12">
			<button class="btn btn-success fa fa-user-plus" data-toggle="modal" data-target="#newImportModal"> Add New Import</button>
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
						<th>Quantity</th>
						<th>Date Recieved</th>
						<th>In Stoke</th>
						<th>Supplier</th>
						<th>Stored In</th>
						<th>Recieved By</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try {
				        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				        $query1=$conn->prepare("SELECT imports.ImportID,imports.ProductID,CONCAT(products.ProductName,' - ',products.Brand) AS ProdDetail,imports.Quantity,imports.StokeRemain,storeroom.Label AS StoreRoom,staff.FirstName,staff.MiddleName,staff.LastName,supplier.SupplierName,imports.DateRecieved,imports.SupplierID,storeroom.RoomID FROM imports,products,staff,supplier,storeroom WHERE (imports.ProductID=products.ProductID AND imports.UserName=staff.UserName AND imports.StoreRoom=storeroom.RoomID AND imports.SupplierID=supplier.SupplierID)");
				        $query1->execute();
				        $n=0;
				        while($result1=$query1->fetch()){
				        ?>
				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $result1["ProdDetail"];?></td>
				        	<td><?php echo $result1["Quantity"];?></td>
				        	<td><?php echo date_format(date_create($result1["DateRecieved"]),"l, F d, Y h:i:s a");?></td>
				        	<td><?php echo $result1["StokeRemain"];?></td>
				        	<td><?php echo $result1["SupplierName"];?></td>
				        	<td><?php echo $result1["StoreRoom"];?></td>
				        	<td><?php echo $result1["FirstName"].", ".$result1["MiddleName"][0].". ".$result1["LastName"];?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item fa fa-edit pl-4" onclick="editImport('<?php echo $result1["ImportID"];?>','<?php echo $result1["ProductID"];?>','<?php echo $result1["SupplierID"];?>','<?php echo $result1["RoomID"];?>')" href="javascript:void(0)"> Edit</a>
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
						<th>Quantity</th>
						<th>Date Recieved</th>
						<th>In Stoke</th>
						<th>Supplier</th>
						<th>Stored In</th>
						<th>Recieved By</th>
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


<div class="modal" id="newImportModal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-import-handler.php" onsubmit="return validateImport()">
					<input type="hidden" name="action" value="New Import">
					<fieldset>
						<legend>Product Information</legend>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group">
									<label for="prodID">Product Recieved:</label>
									<select class="form-control form-control-sm" id="prodID" name="prodID" placeholder="Product Recieved" required>
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
									<span class="warn">Import Label is required!</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="manufDate">Manufacture Date:</label>
									<input type="date" class="form-control form-control-sm" id="manufDate" name="manufDate" placeholder="Manufacture Date" max="<?php echo date("Y-m-d");?>" required>
									<span class="warn">Manufacture Date is required!</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="expDate">Expire Date:</label>
									<input type="date" class="form-control form-control-sm" id="expDate" name="expDate" placeholder="Expire Date" min="<?php echo date("Y-m-d");?>" required>
									<span class="warn">Expire Date is required!</span>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Delivery Information</legend>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="quant">Recieved Quantity:</label>
									<input type="number" class="form-control form-control-sm" id="quant" name="quant" placeholder="Recieved Quantity" min="0" required>
									<span class="warn">Recieved Quantity is required!</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form-group">
									<label for="storage">Stored at:</label>
									<select class="form-control form-control-sm" id="storage" name="storage" required>
										<option value="">--Select Storage--</option>
										<?php
									try {
								        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								        $query2=$conn->prepare("SELECT * FROM storeroom WHERE Status=1");
								        $query2->execute();
								        while($result2=$query2->fetch()){
								        ?>
								        <option value="<?php echo $result2['RoomID'];?>"><?php echo $result2['Label'];?></option>
								        <?php
								        }
								    }catch(PDOException $e){
								    	echo "Error: " . $e->getMessage();
								    }
							        ?>
							    	</select>
									<span class="warn">Storeroom is required!</span>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group">
									<label for="supplier">Supplied By:</label>
									<select class="form-control form-control-sm" id="supplier" name="supplier" required>
										<option value="">--Select Supplier--</option>
										<?php
									try {
								        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								        $query2=$conn->prepare("SELECT * FROM supplier");
								        $query2->execute();
								        while($result2=$query2->fetch()){
								        ?>
								        <option value="<?php echo $result2['SupplierID'];?>"><?php echo $result2['SupplierName'];?></option>
								        <?php
								        }
								    }catch(PDOException $e){
								    	echo "Error: " . $e->getMessage();
								    }
							        ?>
							    	</select>
									<span class="warn">Import Label is required!</span>
								</div>
							</div>
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
<div class="modal" id="editImportModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-import-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Edit Import">
					<input type="hidden" name="importID" id="importID">
					<fieldset>
						<legend>Delivery Information</legend>
						<div class="form-group">
							<label for="editProdID">Product Recieved:</label>
							<select class="form-control form-control-sm" id="editProdID" name="prodID" placeholder="Product Recieved" required>
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
							<span class="warn">Import Label is required!</span>
						</div>
						<div class="form-group">
							<label for="editStorage">Stored at:</label>
							<select class="form-control form-control-sm" id="editStorage" name="storage" required>
								<option value="">--Select Storage--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM storeroom WHERE RoomID=1");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['RoomID'];?>"><?php echo $result2['Label'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Storeroom is required!</span>
						</div>
						<div class="form-group">
							<label for="editSupplier">Supplied By:</label>
							<select class="form-control form-control-sm" id="editSupplier" name="supplier" required>
								<option value="">--Select Supplier--</option>
								<?php
							try {
						        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						        $query2=$conn->prepare("SELECT * FROM supplier");
						        $query2->execute();
						        while($result2=$query2->fetch()){
						        ?>
						        <option value="<?php echo $result2['SupplierID'];?>"><?php echo $result2['SupplierName'];?></option>
						        <?php
						        }
						    }catch(PDOException $e){
						    	echo "Error: " . $e->getMessage();
						    }
					        ?>
					    	</select>
							<span class="warn">Import Label is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Import Record</button>
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
	function editImport(impID,prodID,supID,roomID){
		$("#importID").val(impID);
		$("#editProdID").val(prodID);
		$("#editSupplier").val(supID);
		$("#editStorage").val(roomID);
		$("#editImportModal").modal("show");
	}
</script>
</body>
</html>