

<?php
try {
	include ('connect.php');

	$type = strtoupper($_GET['type']);
	$params = explode('/', $_GET['param']); // array('users', 'show', 'abc')

	// echo $_SERVER['REQUEST_METHOD'] . ": ";
	// ($params);

	function getTypes()
	{
		global $db;
		$out = array();
		$query = mysqli_query($db, "SELECT * FROM typ");
		while ($row = mysqli_fetch_assoc($query)) {
			array_push($out, $row);
		}

		return $out;
	}

	function getTyp($id)
	{
		global $db;
		$out = array();
		$query = mysqli_query($db, "SELECT * FROM typ WHERE id = '$id' LIMIT 1");
		while ($row = mysqli_fetch_assoc($query)) {
			array_push($out, $row);
		}

		return $out;
	}

	function getKfzs()
	{
		global $db;
		$out = array();
		$query = mysqli_query($db, "SELECT kfz.*, typ.brand, typ.model, typ.motor, typ.code, typ.doors FROM kfz INNER JOIN typ ON typ.id = kfz.typ");
		while ($row = mysqli_fetch_assoc($query)) {
			array_push($out, $row);
		}

		return $out;
	}

	function getKfz($plate)
	{
		global $db;
		$out = array();
		$query = mysqli_query($db, "SELECT kfz.*, typ.brand, typ.model, typ.motor, typ.code, typ.doors FROM kfz INNER JOIN typ ON typ.id = kfz.typ WHERE plate = '$plate' LIMIT 1");
		while ($row = mysqli_fetch_assoc($query)) {
			array_push($out, $row);
		}

		return $out;
	}

	function setKFZ($insData)
	{
		global $db;
		$query = "INSERT INTO `kfz`(`plate`, `typ`, `number`, `hu`, `color`) VALUES ('" . $insData[0]['plate'] . "','" . $insData[0]['typ'] . "','" . $insData[0]['number'] . "','" . $insData[0]['hu'] . "','" . $insData[0]['color'] . "')";
		$sql = mysqli_query($db, $query);
		if (mysqli_errno($db)) {
			throw new Exception(mysqli_errno($db) . ": " . mysqli_error($db));
		}

		return getKfzs();
	}

	function setKFZUpdate($insData, $plate)
	{
		global $db;
		$query = "UPDATE `kfz` SET `plate`= '" . $insData[0]['plate'] . "', `typ` = '" . $insData[0]['typ'] . "', `number` = '" . $insData[0]['number'] . "', `hu` = '" . $insData[0]['hu'] . "', `color` = '" . $insData[0]['color'] . "' WHERE `plate` = '$plate'";
		$sql = mysqli_query($db, $query);
		if (mysqli_errno($db)) {
			throw new Exception(mysqli_errno($db) . ": " . mysqli_error($db));
		}

		return getKfzs();
	}

	function del($table, $key, $id)
	{
		global $db;
		$query = "DELETE FROM `$table` WHERE `$key` = '$id'";
		$sql = mysqli_query($db, $query);
		if (mysqli_errno($db)) {
			throw new Exception(mysqli_errno($db) . ": " . mysqli_error($db));
		}
	}

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		switch (strtoupper($params[0])) {
		case 'TYP':
			if (!($params[1])) {
				$output = getTypes();
			}
			else
			if (isset($params[1])) {
				$output = getTyp($params[1]);
			}

			break;

		case 'KFZ':
			if (!($params[1])) {
				$output = getKfzs();
			}
			else
			if (isset($params[1])) {
				$output = getKfz($params[1]);
			}

			break;
		}
	}
	else
	if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
		$input = json_decode(file_get_contents("php://input") , true);
		switch (strtoupper($params[0])) {
		case 'TYP':
			if (!($params[1])) {

				// $output = setKFZ($input);

			}
			else
			if (isset($params[1])) {
				$output = getTyp($params[1]);
			}

			break;

		case 'KFZ':
			if (!($params[1])) {
				$output = setKFZ($input);
			}
			else
			if (isset($params[1])) {
				$output = setKfzUpdate($input, $params[1]);
			}

			break;
		}
	}
	else
	if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		switch (strtoupper($params[0])) {
		case 'TYP':
			if (!($params[1])) {
				throw new Exception("No identifier for DELETE");
			}
			else
			if (isset($params[1])) {
				$output = del('typ', 'id', $params[1]);
			}

			break;

		case 'KFZ':
			if (!($params[1])) {
				throw new Exception("No identifier for DELETE");
			}
			else
			if (isset($params[1])) {
				del('kfz', 'plate', $params[1]);
				$output = getKFZs();
			}

			break;
		}
	}

	// echo "<pre>";
	// print_r($output);

	$jsonOutput = json_encode($output);
	if (json_last_error() == 0) {
		echo $jsonOutput;
	}
	else {
		throw new Exception(json_last_error_msg());
	}
}

catch(Exception $e) {
	header("HTTP/1.0 500");
	echo 'Fehler: ' . $e->getMessage();
}

?>
