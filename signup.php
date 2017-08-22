<?php 
	header('Content-Type: application/json; charset=UTF-8');
	require_once("./db.php");

	// confirm content type 
	if(!in_array('application/json', explode(';', $_SERVER['CONTENT_TYPE']))) {
		echo json_encode(array('code' => '400')); 
		exit(); 
	}

	$data_back = json_decode(file_get_contents('php://input'));

	$user_id = $data_back->{"userId"}; 
	$nickname = $data_back->{"nickname"};
	$thumbnail_image_path = $data_back->{"thumbnailImagePath"};

	$query = "SELECT * FROM user WHERE id = '$user_id'"; 

	$result = $conn->query($query);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);

		echo json_encode(array('code' => '200',
							   'result' => "already user",
							   'idx' => $row['idx']));
	} else {
		$query = "INSERT INTO user (id, nickname, thumbnailImagePath) VALUES ('$user_id', '$nickname', 'thumbnail_image_path')"; 
		
		$result = $conn->query($query); 
		
		if ($result) {
			$query = "SELECT * FROM user WHERE id = '$user_id'"; 

			$result = $conn->query($query);

			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);

				echo json_encode(array('code' => '200',
							   'result' => "already user",
							   'idx' => $row['idx']));
			} else {
				echo json_encode(array('code' => '200',
									   'result' => "fail"));	
			}
		} else {
			echo json_encode(array('code' => '200',
								   'result' => "fail"));
		}
	}
?>