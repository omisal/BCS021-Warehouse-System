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
						<th>Remain</th>
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
				        	$remain=intval($result1["Quantity"])-intval($result1["CompletedQuantity"]);
				        ?>
				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $result1["ProdDetail"];?></td>
				        	<td><?php echo $result1["Quantity"];?></td>
				        	<td><?php echo date_format(date_create($result1["DateOrdered"]),"l, F d, Y h:i:s a");?></td>
				        	<td><?php echo $result1["Shop"];?></td>
				        	<td><?php echo $result1["CompletedQuantity"];?></td>
				        	<td><?php echo $remain;?></td>
				        	<td><?php echo ($result1["Quantity"]>$result1["CompletedQuantity"]) ? "Not Done":"Done";?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item fa fa-edit pl-4" onclick="completeOrder('<?php echo $result1["OrderID"];?>','<?php echo $result1["ProductID"];?>','<?php echo $result1["ProdDetail"];?>','<?php echo $remain;?>')" href="javascript:void(0)">Complete Order</a>
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
						<th>Remain</th>
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

<div class="modal" id="compOrderModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-placed-order-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Complete Order">
					<input type="hidden" name="orderID" id="orderID" readonly="">
					<fieldset>
						<legend>Order Information</legend>
						<div class="form-group">
							<label for="editProd">Product Ordered:</label>
							<input type="text" class="form-control form-control-sm" id="editProd" name="prod" readonly="">
						</div>
						<div class="form-group">
							<label for="editQuant">Quantity Remained:</label>
							<input type="number" class="form-control form-control-sm" id="editQuant" name="quant" placeholder="Quantity Ordering" min="0" readonly="" required>
							<span class="warn">Quantity is required!</span>
						</div>
						<div class="form-group">
							<label for="editImport">Select Import</label>
							<select class="form-control form-control-sm" id="editImport" name="import" required>
								<option value="">--Select Shop--</option>
								
					    	</select>
							<span class="warn">Shop is required!</span>
						</div>
						<div class="form-group">
							<label for="compQuant">Quantity To Deliver:</label>
							<input type="number" class="form-control form-control-sm" id="compQuant" name="compQuant" placeholder="Quantity to Deliver" min="0" required>
							<span class="warn">Quantity is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Complete Order</button>
					</div>
				</form>
			</div>
			<div class="modal-footer text-right" style="background-color: #4caf50;color: #f1f1f1;font-size: small;font-weight: bold;">
				Copyright Brainners &copy; 2020 All rights reserved.
			</div>
		</div>
	</div>
</div>
<div class="modal" id="warningModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<fieldset>
					<legend></legend>
					<div class="form-group mt-2 text-center">
						Currently, no product in stoke is available for this order.
					</div>
				</fieldset>
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
	function completeOrder(ordID,prodID,prodName,rem){
		$("#orderID").val(ordID);
		$("#editProd").val(prodName);
		$("#editQuant").val(rem);
		$.ajax({
		    type: 'POST',
		    url: 'import-services.php',
		    data: {prod: JSON.stringify(prodID)},
		    dataType: 'json'
		})
		.done( function(data) {
			result=data;
			//alert(result.import.date);
			for (var i = 0; i< result.count; i++) {
				$("#editImport").append("<option value='"+result.import.ID+"'>Import of "+result.import.date+"</option>");
				if (rem>result.import.Stoke) {
					$("#compQuant").attr("max",result.import.Stoke);
				}else{
					$("#compQuant").attr("max",rem);
				}
			}
		    $("#compOrderModal").modal("show");
		})
		.fail( function(data) {
		    $("#warningModal").modal("show");
		});
	}
	function deleteOrder(id){
		$("#delOrderID").val(id);
		$("#deleteProductModal").modal("show");
	}
	var result;
</script>
</body>
</html>