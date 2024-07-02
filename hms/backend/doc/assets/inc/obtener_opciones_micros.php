<?php
session_start();
include('config.php');


	$query_2 = "SELECT * FROM lista_micros
				 ORDER BY CASE WHEN microor_name = 'negativo' THEN 0 ELSE 1 END, microor_name"; 
	$resultado = $mysqli->query($query_2);

	// Verificar si se obtuvieron resultados
	if ($resultado->num_rows > 0) {
		// Generar las opciones a partir de los resultados de la consulta
		$opciones_micros = array();
		
		while ($row = $resultado->fetch_object()) {
			$id = $row->microor_id;
			$nombre = $row->microor_name ;
			$opciones_micros[$id] = $nombre;
		}
	$opciones_micros["0"] = "No aplica";
	
	} else {
		echo 'No se encontraron opciones.';
	}
	 
	$resultado->free();
	
	$response['success'] = true;
	$response['opciones'] = $opciones_micros;

	
echo json_encode($response);
?>