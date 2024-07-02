<?php
session_start();
include('config.php');

$response = array('success' => false);
$datos = array();

if (isset($_POST['id_dia'])){
				
		$pat_id=$_POST['pat_id'];
		$id_dia = intval($_POST['id_dia']);
		$id_tipo_toma=$_POST['id_tipo_toma'];
		
		// Obtener los nombres de las columnas de la tabla
		$query = "SHOW COLUMNS FROM vars";
		$resultado = mysqli_query($mysqli, $query);

		$columnas_excluidas = ['pat_id', 'id_dia','id_tipo_toma','status_dia','il6','comentarios_histonas'];

		$columnas = [];
		while ($fila = mysqli_fetch_assoc($resultado)) {
			if (!in_array($fila['Field'], $columnas_excluidas)) {
				$columnas[] = $fila['Field'];
			}
		}
		
		// Construir la consulta SELECT con las columnas
		$columnas_seleccionadas = implode(", ", $columnas);
		
		$query_vars = "SELECT $columnas_seleccionadas FROM vars WHERE pat_id = ?  AND id_dia = ? AND id_tipo_toma= ? ";
		$stmt= $mysqli->prepare($query_vars);
		$stmt->bind_param('sis', $pat_id, $id_dia,$id_tipo_toma);
		$stmt->execute();
		$resultado = $stmt->get_result();
		$datos = $resultado->fetch_assoc();
		
		$query_vars = "SELECT status_dia FROM vars WHERE pat_id = ?  AND id_dia = ? AND id_tipo_toma= ? ";
		$stmt= $mysqli->prepare($query_vars);
		$stmt->bind_param('sis', $pat_id, $id_dia,$id_tipo_toma);
		$stmt->execute();
		$res = $stmt->get_result();
		$ficha_dia = $res->fetch_assoc();
			
		
		 //CONSULTA PARA VISUALIZAR DATOS PREVIAMENTE GUARDADOS de diagnóstico ECC/PICS
		
		$query_id_caso = "SELECT case_pat_id FROM caso WHERE case_pat_id = ? ";
		$stmt= $mysqli->prepare($query_id_caso);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id_caso = $stmt->num_rows;
		
		$datos_caso=array();
		
		
		if ($check_pat_id_caso > 0) {
			
			// Obtener los nombres de las columnas de la tabla
			$query = "SHOW COLUMNS FROM caso";
			$resultado = mysqli_query($mysqli, $query);

			$columnas_excluidas = ['case_pat_id', 'pat_diag_ingreso', 'cl_find_id', 'foco_infecc', 'tipologia_pat', 'agent_etio'];

			$columnas = [];
			while ($fila = mysqli_fetch_assoc($resultado)) {
				if (!in_array($fila['Field'], $columnas_excluidas)) {
					$columnas[] = $fila['Field'];
				}
			}
			
			// Construir la consulta SELECT con las columnas
			$columnas_seleccionadas = implode(", ", $columnas);
			$tableName = "caso";
			
			$query_caso = "SELECT $columnas_seleccionadas FROM $tableName  WHERE case_pat_id = ? ";
			$stmt= $mysqli->prepare($query_caso);
			$stmt->bind_param('s', $pat_id);
			$stmt->execute();
			$resultado = $stmt->get_result();
			$datos_caso = $resultado->fetch_assoc();
		
		}
		
		
		if($stmt){
				
				$response['success'] = true;
				$responseData = array(
					'response' => $response,
					'datos' => $datos,
					'ficha_dia' => $ficha_dia,
					'datos_caso' => $datos_caso,
					
				);
		}else {
			
				echo "No se encontró el registro o no se realizaron cambios.";
		}			
				
			
	}
	
	echo json_encode($responseData);
?>