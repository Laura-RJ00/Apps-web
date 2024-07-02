<?php
session_start();
include('config.php');

$response = array('success' => false);

if (isset($_POST['formData'])) {


	//Ingreso y actualización de las variables de monitorización
    $formData = $_POST['formData'];
	parse_str($formData, $formArray);

	// Obtener variables
	$id_dia = intval($formArray['id_dia']);
	$pat_id = $formArray['pat_id'];
	$id_tipo_toma = $formArray['id_tipo_toma'];
	$status_dia = intval($formArray['status_dia']);
	$uci_form= intval($formArray['UCI_pat']);

	$query_id = "SELECT pat_id, id_dia FROM vars WHERE pat_id = ? AND id_dia = ? AND id_tipo_toma = ?";
	$stmt = $mysqli->prepare($query_id);
	$stmt->bind_param('sis', $pat_id, $id_dia, $id_tipo_toma);
	$stmt->execute();
	$stmt->store_result();
	$check_pat_id = $stmt->num_rows;

	if ($check_pat_id > 0) {
		$setClause = "";
		foreach ($formArray as $key => $value) {
			if ($key == "status_dia"){
				$column = $key;
				$setClause .= "$column = ?, ";
			
			} else if ($key !== "id_dia" && $key !== "id_tipo_toma" && $key !== "pat_id" && $key !== "status_dia") {
				$column = str_replace('_pat', '', $key);
				$setClause .= "$column = ?, ";
			}
		}
		
		$setClause = rtrim($setClause, ', ');
		$whereClause = "WHERE pat_id = ? AND id_dia = ? AND id_tipo_toma = ?";

		$tableName = "vars";
		$sql = "UPDATE $tableName SET $setClause $whereClause";
		$stmt = $mysqli->prepare($sql);

		if ($stmt) {
			$paramTypes = "";
			$paramValues = array();

			foreach ($formArray as $key => $value) {
				if ($key === "status_dia") {
					$paramTypes .= "i";
					$paramValues[] = intval($value);
				}else if ($key === "UCI_pat"){
						$paramTypes .= "i";
						$paramValues[] = intval($value);
						
				}else if ($key !== "id_dia" && $key !== "id_tipo_toma" && $key !== "pat_id" && $key !== "status_dia") {
					$column = str_replace('_pat', '', $key);
					
						
						$paramTypes .= "s";
						$paramValues[] = $value;
					
					
				}
			}

			// Agrega los valores de las variables WHERE al final del array $paramValues
			$paramTypes .= "sis";
			$paramValues[] = $pat_id;
			$paramValues[] = intval($id_dia);
			$paramValues[] = $id_tipo_toma;

			try {
				$stmt->bind_param($paramTypes, ...$paramValues);

				if ($stmt->execute()) {
					$response['success'] = true;
					$response['message'] = "Actualización exitosa";
					/* $response['sets'] = $setClause;
					$response['where'] = $whereClause;
					$response['paramTypes'] = $paramTypes;
					$response['paramValues'] = $paramValues;
					$response['sql'] = $sql;
					$response['uci_og'] = $uci_form; */
				} else {
					$response['message'] = "Error en la actualización: " . $stmt->error;
				}
			} catch (Exception $e) {
				$response['message'] = "Error en bind_param: " . $e->getMessage();
			}

			$stmt->close();
		} else {
			$response['message'] = "Error en la preparación de la consulta: " . $mysqli->error;
		}
	
	
	} else {

        $tableName = "vars";
        $keys = implode(", ", array_map(function ($key) {
            if ($key === "id_dia" || $key === "id_tipo_toma" || $key === "pat_id" || $key === "status_dia") {
                return $key;
            } else {
                return str_replace('_pat', '', $key);
            }
        }, array_keys($formArray)));

        $values = implode(", ", array_fill(0, count($formArray), "?"));
        $sql = "INSERT INTO $tableName ($keys) VALUES ($values)";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $paramTypes = "";
            $paramValues = array();

            foreach ($formArray as $key => $value) {
                if ($key === "id_dia" || $key === "status_dia") {
                    $paramTypes .= "i";
                    $paramValues[] = intval($value);
					
				}else if ($key === "UCI_pat"){
						$paramTypes .= "i";
						$paramValues[] = intval($value);
					
                } else if ($key === "id_tipo_toma" || $key === "pat_id") {
                    $paramTypes .= "s";
                    $paramValues[] = $value;
					
                } else {
                    $column = str_replace('_pat', '', $key);
					
					$paramTypes .= "s";
					$paramValues[] = $value;
					
                }
            }

            $stmt->bind_param($paramTypes, ...$paramValues);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Inserción exitosa";
				/* $response['keys'] = $keys;
				$response['values'] = $values;
				$response['paramTypes'] = $paramTypes;
				$response['paramValues'] = $paramValues;
				$response['sql'] = $sql;
				$response['uci_og'] = $uci_form; */
            } else {
                $response['message'] = "Error en la inserción: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['message'] = "Error en la preparación de la consulta: " . $mysqli->error;
        }
    }
	
	
	
	
	// La actualización de estos paraemtros solo se realiza si el id_dia es igual a 14
	// Recordamos la siguiente variable:
	
	// Obtener variables
	$id_dia = intval($formArray['id_dia']);
	
	if($id_dia === 7){
		// A continuación guardaremos (actualización dado que previamente a la introducción de estos datos 
		// el paciente tiene que ser categorizado como caso obligatoriamente) los datos relacionados con el 
		// diagnostico ECC almacenado en otro formData.
		
		//Ingreso y actualización de las variables de monitorización
		$formData_ecc = $_POST['formData_ecc'];
		parse_str($formData_ecc, $formArray_ecc);

		// Volveremos a usar la variable pat_id del formData previo de las variables
		
		$pat_id = $formArray['pat_id'];
		

		$query_id = "SELECT case_pat_id FROM caso WHERE case_pat_id = ? ";
		$stmt = $mysqli->prepare($query_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;

		if ($check_pat_id > 0) {
			$setClause = "";
			foreach ($formArray_ecc as $key => $value) {
				if (!preg_match('/_pat$/', $key)){
					
					continue;
					
				} 
				
				$column = str_replace('_pat', '', $key);
				$setClause .= "$column = ?, ";
				
			}
			
			$setClause = rtrim($setClause, ', ');
			$whereClause = "WHERE case_pat_id = ?";

			$tableName = "caso";
			$sql = "UPDATE $tableName SET $setClause $whereClause";
			$stmt = $mysqli->prepare($sql);

			if ($stmt) {
				$paramTypes = "";
				$paramValues = array();

				foreach ($formArray_ecc as $key => $value) {
					if (!preg_match('/_pat$/', $key)) {
						
						continue;
						
					}
					
					$column = str_replace('_pat', '', $key);
					$paramTypes .= "i";
					$paramValues[] = intval($value);
						
						
					
				}

				// Agrega los valores de las variables WHERE al final del array $paramValues
				$paramTypes .= "s";
				$paramValues[] = $pat_id;
				

				try {
					$stmt->bind_param($paramTypes, ...$paramValues);

					if ($stmt->execute()) {
						$response['success'] = true;
						$response['message'] = "Actualización exitosa";
						/* $response['sets'] = $setClause;
						$response['where'] = $whereClause;
						$response['paramTypes'] = $paramTypes;
						$response['paramValues'] = $paramValues;
						$response['sql'] = $sql;
						 */
					} else {
						$response['message'] = "Error en la actualización: " . $stmt->error;
					}
				} catch (Exception $e) {
					$response['message'] = "Error en bind_param: " . $e->getMessage();
				}

				$stmt->close();
			} else {
				$response['message'] = "Error en la preparación de la consulta: " . $mysqli->error;
			}
		
		
		} else {

				$response['message'] = "ERROR, no el paciente no ha sido definido previamente como CASO: ";
			}

		
		
	}else if ($id_dia === 14){	
		
		
		
		// A continuación guardaremos (actualización dado que previamente a la introducción de estos datos 
		// el paciente tiene que ser categorizado como caso obligatoriamente) los datos relacionados con el 
		// diagnostico PICS almacenado en otro formData.
		
		
		// La actualización de estos paraemtros solo se realiza si el id_dia es igual a 14
		
		//Ingreso y actualización de las variables de monitorización
		$formData_pics = $_POST['formData_pics'];
		parse_str($formData_pics, $formArray_pics);

		// Volveremos a usar la variable pat_id del formData previo de las variables
		
		$pat_id = $formArray['pat_id'];
		

		$query_id = "SELECT case_pat_id FROM caso WHERE case_pat_id = ? ";
		$stmt = $mysqli->prepare($query_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;

		if ($check_pat_id > 0) {
			$setClause = "";
			foreach ($formArray_pics as $key => $value) {
				if (!preg_match('/_pat$/', $key)){
					
					continue;
					
				} 
				
				$column = str_replace('_pat', '', $key);
				$setClause .= "$column = ?, ";
				
			}
			
			$setClause = rtrim($setClause, ', ');
			$whereClause = "WHERE case_pat_id = ?";

			$tableName = "caso";
			$sql = "UPDATE $tableName SET $setClause $whereClause";
			$stmt = $mysqli->prepare($sql);

			if ($stmt) {
				$paramTypes = "";
				$paramValues = array();

				foreach ($formArray_pics as $key => $value) {
					if (!preg_match('/_pat$/', $key)) {
						
						continue;
						
					}
					
					$column = str_replace('_pat', '', $key);
					$paramTypes .= "i";
					$paramValues[] = intval($value);
						
						
					
				}

				// Agrega los valores de las variables WHERE al final del array $paramValues
				$paramTypes .= "s";
				$paramValues[] = $pat_id;
				

				try {
					$stmt->bind_param($paramTypes, ...$paramValues);

					if ($stmt->execute()) {
						$response['success'] = true;
						$response['message'] = "Actualización exitosa";
						/* $response['sets'] = $setClause;
						$response['where'] = $whereClause;
						$response['paramTypes'] = $paramTypes;
						$response['paramValues'] = $paramValues;
						$response['sql'] = $sql;
						 */
					} else {
						$response['message'] = "Error en la actualización: " . $stmt->error;
					}
				} catch (Exception $e) {
					$response['message'] = "Error en bind_param: " . $e->getMessage();
				}

				$stmt->close();
			} else {
				$response['message'] = "Error en la preparación de la consulta: " . $mysqli->error;
			}
		
		
		} else {

				$response['message'] = "ERROR, no el paciente no ha sido definido previamente como CASO: ";
			}
	
	
	}
}





echo json_encode($response);
?>