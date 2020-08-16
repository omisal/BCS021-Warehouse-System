<!DOCTYPE html>
<?php
	session_start();
	if (!isset($_SESSION["wh_user"]) || $_SESSION["wh_role"] != "Manager") {
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
			<button class="btn btn-success fa fa-user-plus" data-toggle="modal" data-target="#newSupplierModal"> Add New Supplier</button>
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
				<caption>List of all Supplier in the Organization</caption>
				<thead>
					<tr>
						<th>S/N</th>
						<th>Supplier Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try {
				        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				        $query1=$conn->prepare("SELECT * FROM supplier");
				        $query1->execute();
				        $n=0;
				        while($result1=$query1->fetch()){
				        ?>
				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $result1["SupplierName"];?></td>
				        	<td><?php echo $result1["Email"];?></td>
				        	<td><?php echo $result1["Phone"];?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item fa fa-edit pl-4" onclick="editSupplier('<?php echo $result1["SupplierID"];?>','<?php echo $result1["SupplierName"];?>','<?php echo $result1["Email"];?>','<?php echo $result1["Phone"];?>')" href="javascript:void(0)"> Edit</a>
										<a class="dropdown-item fa fa-trash pl-4 text-danger" onclick="deleteSupplier('<?php echo $result1["SupplierID"];?>','<?php echo $result1["SupplierName"];?>')" href="javascript:void(0)"> Delete</a>
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
						<th>Supplier Name</th>
						<th>Email</th>
						<th>Phone</th>
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


<div class="modal" id="newSupplierModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-supplier-handler.php" onsubmit="return validateSupplier()">
					<input type="hidden" name="action" value="New Supplier">
					<fieldset>
						<legend>Supplier Information</legend>
						<div class="form-group">
							<label for="supName">Supplier Name:</label>
							<input type="text" class="form-control form-control-sm" id="supName" name="supName" placeholder="Supplier Name" required>
							<span class="warn">Supplier Name is required!</span>
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="email@hostname.com" required>
							<span class="warn">Email is required!</span>
						</div>
						<div class="form-group">
							<label for="phone">Phone Number:</label>
							<input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="0987654321" pattern="0\d\d\d\d\d\d\d\d\d" title="Should contain 10 digits, the first is 0" required>
							<span class="warn">Phone Number is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Save Supplier Record</button>
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
<div class="modal" id="editSupplierModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-supplier-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Edit Supplier">
					<input type="hidden" name="supID" id="supID">
					<fieldset>
						<legend>Supplier Information</legend>
						<div class="form-group">
							<label for="supName">Supplier Name:</label>
							<input type="text" class="form-control form-control-sm" id="editSupName" name="supName" placeholder="Supplier Name" required>
							<span class="warn">Supplier Name is required!</span>
						</div>
						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control form-control-sm" id="editEmail" name="email" placeholder="email@hostname.com" required>
							<span class="warn">Email is required!</span>
						</div>
						<div class="form-group">
							<label for="phone">Phone Number:</label>
							<input type="text" class="form-control form-control-sm" id="editPhone" name="phone" placeholder="0987654321" pattern="0\d\d\d\d\d\d\d\d\d" title="Should contain 10 digits, the first is 0" required>
							<span class="warn">Phone Number is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Supplier Record</button>
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
<div class="modal" id="deleteSupplierModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-supplier-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Delete Supplier" readonly="">
					<input type="hidden" name="supID" id="delSupID" readonly="">
					<i class="fa fa-exclamation-triangle text-center" style="color: #ff8d8d;font-size: xx-large;display: block;"></i>
					<fieldset>
						<legend></legend>
						<div class="form-group mt-2 text-center">
							Are you sure you want to delete a Supplier with a name <label id="lblName"></label>.
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
	function editSupplier(id,name,email,phone){
		$("#supID").val(id);
		$("#editSupName").val(name);
		$("#editEmail").val(email);
		$("#editPhone").val(phone);
		$("#editSupplierModal").modal("show");
	}
	function deleteSupplier(id,name){
		$("#delSupID").val(id);
		$("#lblName").html(name);
		$("#deleteSupplierModal").modal("show");
	}
</script>
</body>
</html>