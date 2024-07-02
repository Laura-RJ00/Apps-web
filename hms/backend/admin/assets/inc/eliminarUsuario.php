<?php
session_start();
include('config.php');


	$user_id = $_POST['user_id'];
	

  // Realizar las operaciones necesarias para eliminar el día de la base de datos
  
  // Ejemplo: consulta SQL para eliminar el día
  $query = "DELETE FROM users WHERE user_id = ? ";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('s', $user_id);
  $stmt->execute();

  // Si es necesario, realizar otras operaciones relacionadas con la eliminación
  
  // Enviar una respuesta al cliente (puede ser cualquier cosa)
  echo 'OK';

?>