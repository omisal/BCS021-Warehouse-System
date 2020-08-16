<?php
    session_start();
    if (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Edit Profile") {
        $fName = $_POST["fName"];
        $mName = $_POST["mName"];
        $lName = $_POST["lName"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        editProfile($fName,$mName,$lName,$dob,$gender,$email,$phone,$address);
    }elseif (isset($_POST["submit"]) && isset($_POST["action"]) && $_POST["action"]=="Change Password"){
        $opwd = $_POST["opwd"];
        $npwd = $_POST["npwd"];
        $cpwd = $_POST["cpwd"];
        editPass($opwd,$npwd,$cpwd);
    }else{
        header("location:profile.php");
    }
    function editProfile($fName,$mName,$lName,$dob,$gnd,$email,$phone,$address){
        require_once("connection.php");
        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query1=$conn->prepare("SELECT UserName FROM staff WHERE UserName=?");
            $query1->execute([$_SESSION["wh_user"]]);
            if ($query1->rowCount()==1){
                $query1=$conn->prepare("UPDATE staff SET FirstName=?, MiddleName=?, LastName=?, DOB=?, Gender=?, Address=?, Email=?, Phone=? WHERE UserName=?");
                $query1->execute([$fName,$mName,$lName,$dob,$gnd,$address,$email,$phone,$_SESSION["wh_user"]]);
                if(isset($_FILES["photo"])){
                    $picture=$_FILES["photo"];
                    if(($picture["type"]=="image/png" OR $picture["type"]=="image/jpeg" OR $picture["type"]=="image/jpg" OR $picture["type"]=="image/gif") AND $picture["size"]<=1048576 AND $picture["error"]==0){
                        $arr=explode(".",$picture["name"]);
                        $name=$code=hash("crc32b",$_SESSION["wh_user"]);
                        $ext=end($arr);
                        $path="Profiles/".$name.".".$ext;
                        $name=$name.".".$ext;
                        if(move_uploaded_file($picture["tmp_name"],$path)){
                            $query1=$conn->prepare("UPDATE staff SET Photo=? WHERE UserName=?");
                            $query1->execute([$name,$_SESSION["wh_user"]]);
                        }
                    }
                }
                header("location:profile.php");
                $_SESSION['sms']="<span class='text-success'>Profile changed Successfully!</span>";
            }else{
                $_SESSION['sms']="<span class='text-danger'>Fail to change profile!</span>";
                header("location:profile.php");
            }
            $conn = null; 
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function editPass($opwd,$npwd,$cpwd){
        require_once("connection.php");
        try {
            if ($opwd!="" AND $npwd!="" AND $npwd==$cpwd) {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query1=$conn->prepare("SELECT UserName FROM staff WHERE UserName=? AND Password=?");
                $query1->execute([$_SESSION["wh_user"],sha1($opwd)]);
                if ($query1->rowCount()==1 AND $npwd==$cpwd){
                    $query1=$conn->prepare("UPDATE staff SET Password=? WHERE UserName=?");
                    $query1->execute([sha1($npwd),$_SESSION["wh_user"]]);
                    header("location:profile.php");
                    $_SESSION['sms']="<span class='text-success'>Password chaned Successfully!</span>";
                }else{
                    $_SESSION['sms']="<span class='text-danger'>Fail to change password!</span>";
                    header("location:profile.php");
                }
            }
            $conn = null; 
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>