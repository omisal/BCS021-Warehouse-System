<?php
    require_once("connection.php");
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query1=$conn->prepare("SELECT * FROM staff,role WHERE (staff.Role=role.RoleID AND staff.UserName=?)");
        $query1->execute([$_SESSION["wh_user"]]);
        $result1=$query1->fetch(); 
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
<div class="vertical-nav" id="sidebar" style="background-color: #ceffce;">
    <div class="py-2 mb-4" style="background-color: #4caf50;color: #f1f1f1;">
        <div style="text-align: center;">
            <img src="<?php echo "Profiles/".$result1["Photo"];?>" alt="user" style="width: 100px;height: 100px;" class="mr-3 rounded-circle img-thumbnail">
            <h4><?php echo $result1["FirstName"].", ".$result1["MiddleName"][0].". ".$result1["LastName"];?></h4>
            <strong><?php echo $result1["Title"];?></strong>
        </div>
    </div>
    <ul class="nav flex-column mb-0">
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user mr-3"></i><?php echo $result1["FirstName"].", ".$result1["MiddleName"][0].". ".$result1["LastName"];?></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Security</a>
                </div>
            </li>
        <li class="nav-item">
            <a href="index.php" class="nav-link">
                <i class="fa fa-home mr-3"></i>Home
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-address-card mr-3"></i>About
            </a>
        </li>
        <?php
        if ($_SESSION["wh_role"]=="Manager") {
        ?>

        <?php
        }if ($_SESSION["wh_role"]=="Store Keeper") {
        ?>

        <?php
        }if ($_SESSION["wh_role"]=="Shop Keeper") {
        ?>

        <?php
        }
        ?>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-cubes mr-3"></i>Services
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-headset mr-3"></i>Help and Support
            </a>
        </li>
    </ul>
</div>