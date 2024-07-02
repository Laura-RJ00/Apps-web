<?php
session_start();
include('config.php');

$response = array('success' => false);


if (isset($_POST['tag']))
	{
		
		$newTag = $_POST['tag'];
		$tipo ='Personalizado';
		
		$query_1="INSERT INTO `lista_micros`(`microor_name`,`tipo_microor`) VALUES (?,?)";
		
		
		$stmt = $mysqli->prepare($query_1);
		$rc=$stmt->bind_param('ss', $newTag,$tipo);
		$stmt->execute();
			if($stmt){ 
				
				$response['success'] = true;
				$response['message'] = 'nuevo microorganismo introducido';
				$newTagId = $stmt->insert_id;
				
				$response['newTagId'] = $newTagId;
				
			 }else {
				echo "Error in executing the statement: " . $stmt->error;
			} 
		
	}
echo json_encode($response);
?>