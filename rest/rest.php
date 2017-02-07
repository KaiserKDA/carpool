<?php
try {
	include('connect.php');
	
	$type = strtoupper($_GET['type']);
	$params = explode('/', $_GET['param']); // array('users', 'show', 'abc')
	
	print_r($params);
	
	function getTypes() {
		global $db;
		$out = array();
		$query = mysqli_query($db, "SELECT * FROM typ");
		while($row = mysqli_fetch_assoc($query))
		{
		  array_push($out,$row);
		}
		return $out;
	}
	
	function getTyp($id) {
		global $db;
		$out = array();	
		$query = mysqli_query($db, "SELECT * FROM typ WHERE id = '$id' LIMIT 1");
		while($row = mysqli_fetch_assoc($query))
		{
		  array_push($out,$row);
		}
		return $out;
	}
	
	function getKfzs($plate) {
		global $db;
		$out = array();	
		$query = mysqli_query($db, "SELECT kfz.*, typ.brand, typ.model, typ.motor, typ.code, typ.doors FROM kfz INNER JOIN typ ON typ.id = kfz.typ");
		while($row = mysqli_fetch_assoc($query))
		{
		  array_push($out,$row);
		}
		return $out;
	}
	function getKfz($plate) {
		global $db;
		$s = explode('-', $plate);
		$out = array();	
		$query = mysqli_query($db, "SELECT kfz.*, typ.brand, typ.model, typ.motor, typ.code, typ.doors FROM kfz INNER JOIN typ ON typ.id = kfz.typ WHERE city = '".$s['0']."' AND plate = '".$s['1']."' LIMIT 1");
		while($row = mysqli_fetch_assoc($query))
		{
		  array_push($out,$row);
		}
		return $out;
	}
	
	if($type == "GET") {
		switch (strtoupper($params[0])) {
		    case 'TYP':
		    	if(!($params[1])) {
		    		$output = getTypes();
		    	} else if(isset($params[1])) {
		    		$output = getTyp($params[1]);
		    	}
		        break;
		    case 'KFZ':
		    	if(!($params[1])) {
		    		$output = getKfzs();
		    	} else if(isset($params[1])) {
		    		$output = getKfz($params[1]);
		    	}
		    	break;
		    case 2:
		        echo "i ist gleich 2";
		        break;
		}
	}
	

	echo "<pre>";
	print_r($output);
	echo json_encode($output);
} catch (Exception $e) {
    echo 'Exception: ',  $e->getMessage(), "\n";
    header("HTTP/1.0 404 Not Found");
}
?>
