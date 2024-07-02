<?php
session_start();
include('config.php');


	$idDia = $_POST['idDia'];
	$pat_id = $_POST['pat_id'];
	

  // Realizar las operaciones necesarias para eliminar el día de la base de datos
  
  // Ejemplo: consulta SQL para eliminar el día
  $query = "DELETE FROM tto_terapia WHERE id_dia = ? AND pat_id=?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('is', $idDia,$pat_id);
  $stmt->execute();

  // Si es necesario, realizar otras operaciones relacionadas con la eliminación
  
  // Enviar una respuesta al cliente (puede ser cualquier cosa)
  echo 'OK';

?>