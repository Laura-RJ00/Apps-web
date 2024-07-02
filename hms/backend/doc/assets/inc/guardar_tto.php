<?php
session_start();
include('config.php');

$response = array('success' => false);


if (isset($_POST['pat_id']))
	{
		
		
		$pat_id=$_POST['pat_id'];
		
		
		$query_pat_id = "SELECT pat_id FROM tto_terapia WHERE pat_id = ? ";
		$stmt= $mysqli->prepare($query_pat_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;
		
		
			if ($check_pat_id > 0) {
				
				$query1 = "DELETE FROM `tto_terapia` WHERE `pat_id`= ?";
				
				$stmt1 = $mysqli->prepare($query1);
				$stmt1->bind_param('s', $pat_id);
				$stmt1->execute();
				
				
				$datos = json_decode($_POST['datos'], true);
			
				 foreach ($datos as $dato) {
					 
					
					 
						$id_dia = intval($dato['id_dia']);
						$dva = $dato['dva'];
						$dva_dias = $dato['dva_dias'];
						$vm = $dato['vm'];
						$vm_dias = $dato['vm_dias'];
						$trrc = $dato['trrc'];
						$trrc_dias = $dato['trrc_dias'];

						
						
						
						$query="INSERT INTO `tto_terapia`(`pat_id`, `id_dia`, `DVA`, `DVA_dias`, `TRRC`, `TRRC_dias`, `VM`, `VM_dias`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
								
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('siiiiiii', $pat_id, $id_dia,$dva,$dva_dias,$vm,$vm_dias,$trrc, $trrc_dias);
						$stmt->execute();
								
								
						if ($stmt) {
								$response['success'] = true;
								
						} else {
							
							$response['error'] = "Error al insertar: " . mysqli_error($mysqli);
						} 
					}
				/* $datos = json_decode($_POST['datos'], true);
			
				 foreach ($datos as $dato) {
					 
					
					 
						$id_dia = intval($dato['id_dia']);
						$dva = $dato['dva'];
						$dva_dias = $dato['dva_dias'];
						$vm = $dato['vm'];
						$vm_dias = $dato['vm_dias'];
						$trrc = $dato['trrc'];
						$trrc_dias = $dato['trrc_dias'];
						
						
						
						
						$query="UPDATE `tto_terapia` SET `id_dia`= ?,`DVA`= ?,`DVA_dias`= ?,`TRRC`=?,`TRRC_dias`=?,`VM`= ?,`VM_dias`= ? WHERE `pat_id`= ?";
								
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('iiiiiiis', $id_dia,$dva,$dva_dias,$vm,$vm_dias,$trrc, $trrc_dias,$pat_id);
						$stmt->execute();
								
								
						if ($stmt) {
								$response['success'] = true;
								
						} else {
							
							$response['error'] = "Error al insertar: " . mysqli_error($mysqli);
						} 
					}else{
						
						
					} */	
								
					
				$stmt->close();
		
				 
		
				
			} else{
				
				$datos = json_decode($_POST['datos'], true);
			
				 foreach ($datos as $dato) {
					 
					
					 
						$id_dia = intval($dato['id_dia']);
						$dva = $dato['dva'];
						$dva_dias = $dato['dva_dias'];
						$vm = $dato['vm'];
						$vm_dias = $dato['vm_dias'];
						$trrc = $dato['trrc'];
						$trrc_dias = $dato['trrc_dias'];

						
						
						
						$query="INSERT INTO `tto_terapia`(`pat_id`, `id_dia`, `DVA`, `DVA_dias`, `TRRC`, `TRRC_dias`, `VM`, `VM_dias`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
								
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('siiiiiii', $pat_id, $id_dia,$dva,$dva_dias,$vm,$vm_dias,$trrc, $trrc_dias);
						$stmt->execute();
								
								
						if ($stmt) {
								$response['success'] = true;
								
						} else {
							
							$response['error'] = "Error al insertar: " . mysqli_error($mysqli);
						} 
					}
				$stmt->close();
				
				
			} 
		
	}
	
	echo json_encode($response);
?>