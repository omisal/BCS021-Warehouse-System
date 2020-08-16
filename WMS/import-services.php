<?php
	//if (isset(json_decode($_POST["prod"]))) {
		header("content_type:application/json");
		$prod=json_decode($_POST["prod"]);
	    require_once("connection.php");
		try {
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $query1=$conn->prepare("SELECT * FROM imports WHERE ProductID=? AND StokeRemain>0");
        	$query1->execute([$prod]);
			$count=0;
		    $res=null;
		    while($result1=$query1->fetch()){
		    	$count++;
		    	$res["ID"]=$result1["ImportID"];
		    	$res["Stoke"]=$result1["StokeRemain"];
		    	$res["date"]=$result1["DateRecieved"];
		    	break;
		    }
		    $data = array(
		    	"count" => $count,
		    	"import" => $res
		    );
		    echo json_encode($data);
	        $conn = null;
	    }
	    catch(PDOException $e) {
	        echo "Error: " . $e->getMessage();
	    }
	    
	//}
?>