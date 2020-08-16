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
			<button class="btn btn-success fa fa-user-plus" data-toggle="modal" data-target="#newShopModal"> Add New Shop</button>
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
				<caption>List of all Shop in the Organization</caption>
				<thead>
					<tr>
						<th>S/N</th>
						<th>Shop Label</th>
						<th>Shop Location</th>
						<th>Shop Status</th>
						<th>More</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try {
				        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				        $query1=$conn->prepare("SELECT * FROM shops");
				        $query1->execute();
				        $n=0;
				        $status = array('No Longer Usable','Usable');
				        while($result1=$query1->fetch()){
				        ?>
				        <tr>
				        	<td><?php echo ++$n;?></td>
				        	<td><?php echo $result1["Label"];?></td>
				        	<td><?php echo $result1["Location"];?></td>
				        	<td><?php echo $status[$result1["Status"]];?></td>
				        	<td>
					        	<div class="dropdown dropleft">
									<button type="button" class="btn btn-success py-0" data-toggle="dropdown">
									...
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item fa fa-edit pl-4" onclick="editShop('<?php echo $result1["ShopID"];?>','<?php echo $result1["Label"];?>','<?php echo $result1["Location"];?>','<?php echo $result1["Status"];?>')" href="javascript:void(0)"> Edit</a>
										<a class="dropdown-item fa fa-trash pl-4 text-danger" onclick="deleteShop('<?php echo $result1["ShopID"];?>','<?php echo $result1["Label"];?>','<?php echo $result1["Location"];?>')" href="javascript:void(0)"> Delete</a>
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
						<th>Shop Label</th>
						<th>Shop Location</th>
						<th>Shop Status</th>
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


<div class="modal" id="newShopModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-shop-handler.php" onsubmit="return validateShop()">
					<input type="hidden" name="action" value="New Shop">
					<fieldset>
						<legend>Shop Information</legend>
						<div class="form-group">
							<label for="shopName">Shop Label:</label>
							<input type="text" class="form-control form-control-sm" id="shopName" name="shopName" placeholder="Shop Label" required>
							<span class="warn">Shop Label is required!</span>
						</div>
						<div class="form-group">
							<label for="shopLoc">Shop Label:</label>
							<input type="text" class="form-control form-control-sm" id="shopLoc" name="shopLoc" placeholder="Shop Location" required>
							<span class="warn">Shop Location is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Save Shop Record</button>
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
<div class="modal" id="editShopModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-shop-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Edit Shop">
					<input type="hidden" name="shopID" id="shopID">
					<fieldset>
						<legend>Shop Information</legend>
						<div class="form-group">
							<label for="editStoreName">Shop Label:</label>
							<input type="text" class="form-control form-control-sm" id="editShopName" name="shopName" placeholder="Shop Label" required>
							<span class="warn">Shop Label is required!</span>
						</div>
						<div class="form-group">
							<label for="editStoreName">Shop Location:</label>
							<input type="text" class="form-control form-control-sm" id="editShopLoc" name="shopLoc" placeholder="Shop Location" required>
							<span class="warn">Shop Label is required!</span>
						</div>
						<div class="form-group">
							<label for="storeName">Shop Status:</label>
							<select class="form-control form-control-sm" id="shopStatus" name="status" required>
								<option value="">--Select Status--</option>
								<option value="0"><?php echo $status[0];?></option>
								<option value="1"><?php echo $status[1];?></option>
							</select>
							<span class="warn">Shop Status is required!</span>
						</div>
					</fieldset>
					<div class="form-group mt-2 text-center">
						<button type="submit" class="btn form-control" name="submit" style="background-color: #4caf50;color: #f1f1f1;max-width: 400px;">Update Shop Record</button>
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
<div class="modal" id="deleteShopModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4caf50;color: #f1f1f1;">
				<h5 class="modal-title fa fa-user-plus text-center"></h5>
			</div>
			<div class="modal-body">
				<form method="POST" action="manage-shop-handler.php" onsubmit="return validateLogin()">
					<input type="hidden" name="action" value="Delete Shop" readonly="">
					<input type="hidden" name="shopID" id="delshopID" readonly="">
					<i class="fa fa-exclamation-triangle text-center" style="color: #ff8d8d;font-size: xx-large;display: block;"></i>
					<fieldset>
						<legend></legend>
						<div class="form-group mt-2 text-center">
							Are you sure you want to delete a shop with a label <label id="lblName"></label> which is located at <label id="lblLoc"></label>.
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
	function editShop(id,name,loc,stt){
		$("#shopID").val(id);
		$("#editShopName").val(name);
		$("#editShopLoc").val(loc);
		$("#shopStatus").val(stt);
		$("#editShopModal").modal("show");
	}
	function deleteShop(id,name,loc){
		$("#delshopID").val(id);
		$("#lblName").html(name);
		$("#lblLoc").html(loc);
		$("#deleteShopModal").modal("show");
	}
</script>
</body>
</html>