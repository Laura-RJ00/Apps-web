<?php
session_start();
include('config.php');


	$email = $_POST['email'];
	

  // Realizar las operaciones necesarias para eliminar el día de la base de datos
  
  // Ejemplo: consulta SQL para eliminar el día
  $query = "DELETE FROM reset_pwd_usuarios WHERE email = ? ";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('s', $email);
  $stmt->execute();

  // Si es necesario, realizar otras operaciones relacionadas con la eliminación
  
  // Enviar una respuesta al cliente (puede ser cualquier cosa)
  echo 'OK';

?>