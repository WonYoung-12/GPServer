<?php 
	header('Content-Type: application/json; charset=UTF-8');
	require_once("./db.php");

	// confirm content type 
	if(!in_array('application/json', explode(';', $_SERVER['CONTENT_TYPE']))) {
		echo json_encode(array('code' => '400')); 
		exit(); 
	}

	$data_back = json_decode(file_get_contents('php://input'));

	$u_idx = $data_back->{"uIdx"};
	$m_idx = $data_back->{"mIdx"};
	$emotion = $data_back->{"emotion"};

	$query = "SELECT * FROM preference WHERE u_idx = $u_idx AND m_idx = $m_idx"; 

	$result = $conn->query($query); 

	if ($result) {
		if (mysqli_num_rows($result) > 0) { // 이미 들은적이 있음 
			$row = mysqli_fetch_assoc($result);
			$point = $row['point'] + 1; 

			$query = "UPDATE preference SET point = '$point' WHERE  u_idx = $u_idx AND m_idx = $m_idx AND emotion = $emotion";
			$result = $conn->query($query); 

			if ($result) {
				echo json_encode(array('code' => '200',
							   			'result' => "success"));
			} else {
				echo json_encode(array('code' => '200',
							   			'result' => "fail update"));
			}

		} else {
			$query = "INSERT INTO preference (u_idx, m_idx, point, emotion) VALUES ('$u_idx', '$m_idx', 1, '$emotion')"; 
			$result = $conn->query($query); 

			if ($result) {
				echo json_encode(array('code' => '200',
							   			'result' => "success"));
			} else {
				echo json_encode(array('code' => '200',
							   			'result' => "fail insert"));
			}
		}
	} else {
		echo json_encode(array('code' => '200',
							   'result' => "fail select"));
	} 
?>