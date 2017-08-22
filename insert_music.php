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
	$name = $data_back->{"name"};
	$url = $data_back->{"url"};

	$query = "INSERT INTO music (emotion, name, url) VALUES ('$emotion', '$name', '$url')"; 
	
	$result = $conn->query($query); 
	
	if ($result) {
		echo json_encode(array('code' => '200',
							   'result' => "success"));
	} else {
		echo json_encode(array('code' => '200',
							   'result' => "fail"));
	}
?>