<?php
session_start();
include('config.php');

$response = array('success' => false);


if (isset($_POST['pat_number']))
	{
		
	$pat_estado=intval(isset($_POST['status_ficha']) ? $_POST['status_ficha'] : 0);
	$pat_id=$_POST['pat_number'];
			
		//sql to insert captured values
		$query="update patients set pat_record_status=? WHERE pat_id=?";
		$stmt = $mysqli->prepare($query);
		$rc=$stmt->bind_param('is', $pat_estado, $pat_id);
		$stmt->execute();
		
		if ($stmt->affected_rows > 0) {
					$response['success'] = true;
		
		} else {
					
			$response['error'] = "Error al ejecutar la consulta insert: " . mysqli_error($mysqli);
		}
	
	
	
	}
	
	
echo json_encode($response);
	?>