<?php
session_start();
include('config.php');

$response = array('success' => false);


//$SerializedData = $_POST['formData'];

if (isset($_POST['pat_id'])){
				// nuestras variables
				
				
				$pat_id = $_POST['pat_id'];
				$ficha_paciente =intval( $_POST['ficha_paciente']);
				
				
				$query= "UPDATE `patients` SET `pat_record_status`=?
							WHERE `pat_id`=?";
					
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('is', $ficha_paciente, $pat_id);
					
					
					$stmt->execute();
					
					if($stmt)
					{
					
					$response['success'] = true;
					
						
					}
					else {
						echo "No se encontró el registro o no se realizaron cambios.";
					} 
					
					
				
				
					
				
	
	echo json_encode($response);
}
?>