<?php 
	header('Content-Type: application/json; charset=UTF-8');
	require_once("./db.php");

	// confirm content type 
	if(!in_array('application/json', explode(';', $_SERVER['CONTENT_TYPE']))) {
		echo json_encode(array('code' => '400')); 
		exit(); 
	}

	$data_back = json_decode(file_get_contents('php://input'));

	$u_idx = $data_back->{"idx"};
	$emotion = $data_back->{"emotion"};
	
	/*
	$query = ""; 
	if ($emotion == 123) {
		$query = "SELECT * FROM music AS m INNER JOIN preference As p ON m.id = p.m_idx WHERE p.u_idx = '$u_idx' AND (p.emotion = 1 OR p.emotion = 4 OR p.emotion = 7 OR p.emotion = 10) ORDER BY point DESC"; 	
	} else if ($emotion == 234) {
		$query = "SELECT * FROM music AS m INNER JOIN preference As p ON m.id = p.m_idx WHERE p.u_idx = '$u_idx' AND (p.emotion = 2 OR p.emotion = 5 OR p.emotion = 8 OR p.emotion = 11) ORDER BY point DESC";
	} else {
		$query = "SELECT * FROM music AS m INNER JOIN preference As p ON m.id = p.m_idx WHERE p.u_idx = '$u_idx' AND (p.emotion = 3 OR p.emotion = 6 OR p.emotion = 9 OR p.emotion = 12) ORDER BY point DESC";
	}
	*/

	$query = "SELECT * FROM music AS m INNER JOIN preference As p ON m.id = p.m_idx WHERE p.u_idx = '$u_idx' AND p.emotion = '$emotion' ORDER BY point DESC";
	
	
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

	// happy = 123, 1,4,7,10
	// anger = 234, 2,5,8,11
	// conc  = 345, 3,6,9,12 
?>