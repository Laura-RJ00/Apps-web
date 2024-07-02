<?php
session_start();
include('config.php');


	$pat_id = $_POST['pat_id'];
	

    $query = "DELETE FROM patients WHERE pat_index=?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $pat_id);
	$stmt->execute();
	
	

  // Si es necesario, realizar otras operaciones relacionadas con la eliminación
  
  // Enviar una respuesta al cliente (puede ser cualquier cosa)
  echo 'OK';

?>