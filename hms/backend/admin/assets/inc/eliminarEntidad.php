<?php
session_start();
include('config.php');


	$ent_id = intval($_POST['ent_id']);
	$ent_type = $_POST['ent_type'];
	
	if($ent_type=='hospital'){
		 // Ejemplo: consulta SQL para eliminar el día
		  $query = "DELETE FROM hospital_docs WHERE hosp_id = ? ";
		  $stmt = $mysqli->prepare($query);
		  $stmt->bind_param('i', $ent_id);
		  $stmt->execute();		
					
	}elseif($ent_type== 'research'){
		 // Ejemplo: consulta SQL para eliminar el día
		  $query = "DELETE FROM research_centers WHERE center_id = ? ";
		  $stmt = $mysqli->prepare($query);
		  $stmt->bind_param('i', $ent_id);
		  $stmt->execute();
		
		
	}

  // Realizar las operaciones necesarias para eliminar el día de la base de datos
  
 

  // Si es necesario, realizar otras operaciones relacionadas con la eliminación
  
  // Enviar una respuesta al cliente (puede ser cualquier cosa)
  echo 'OK';

?>