<?php
session_start();
include('config.php');

	$response = array('success' => false);
	
	$pat_id=$_POST['pat_id'];
	
	// Obtener los datos de la base de datos
	$consulta = "SELECT id_dia, DVA, DVA_dias, TRRC, TRRC_dias, VM, VM_dias FROM tto_terapia WHERE pat_id = ?  AND id_dia <> 1";
	$stmt = $mysqli->prepare($consulta);
	$stmt->bind_param('s', $pat_id);
	$stmt->execute();
	$resultado = $stmt->get_result();

	// Recorrer los resultados y guardarlos en un arreglo
	$datos = [];
	while ($row = $resultado->fetch_assoc()) {
		$datos[] = $row;
	}
	
	
	$response['success'] = true;
	$response['datos'] = $datos;
	// Devolver los datos en formato JSON
	echo json_encode($response);

?>