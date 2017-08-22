<?php 
	header('Content-Type: application/json; charset=UTF-8');
	require_once("./db.php");

	// confirm content type 
	if(!in_array('application/json', explode(';', $_SERVER['CONTENT_TYPE']))) {
		echo json_encode(array('code' => '400')); 
		exit(); 
	}

	$data_back = json_decode(file_get_contents('php://input'));

	$emotion = $data_back->{"emotion"};

	$query = "SELECT * FROM music";//WHERE emotion = '$emotion'"; 
	
	$result = $conn->query($query); 
	
	if ($result) {
		$data = array();

		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$data[] = $row;
		}
		echo json_encode(array('code' => '200',
							   'result' => "success",
							   'musicList' => $data));
	} else {
		echo json_encode(array('code' => '200',
							   'result' => "fail"));
	}
?>