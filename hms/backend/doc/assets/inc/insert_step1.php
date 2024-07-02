<?php
session_start();
include('config.php');

$response = array('success' => false);


if (isset($_POST['pat_number']))
	{
		// nuestras variables
		$pat_id=$_POST['pat_number'];

		$doc_pac = $_POST['doc_pac'];
		
		$sip_pac= $_POST['sip_pac'];
		$nhc_pac = $_POST['nhc_pac'];
		
		$ingreso_hosp_pac = ($_POST['ingreso_hosp_pac'] != '') ? date("Y-m-d", strtotime($_POST['ingreso_hosp_pac'])) : NULL;
		$ingreso_uci_pac = ($_POST['ingreso_uci_pac'] != '') ? date("Y-m-d", strtotime($_POST['ingreso_uci_pac'])) : NULL;
		$alta_uci_pac = ($_POST['alta_uci_pac'] != '') ? date("Y-m-d", strtotime($_POST['alta_uci_pac'])) : NULL;
		$alta_hosp_pac = ($_POST['alta_hosp_pac'] != '') ? date("Y-m-d", strtotime($_POST['alta_hosp_pac'])) : NULL;
		$birth_pac = ($_POST['birth_pac'] != '') ? date("Y-m-d", strtotime($_POST['birth_pac'])) : NULL;
		
		$date_exitus = ($_POST['date_exitus'] != '') ? date("Y-m-d", strtotime($_POST['date_exitus'])) : NULL;
		
		
		$estancia_hosp = $_POST['estancia_hosp'] !== "" ? intval($_POST['estancia_hosp']) : null;
		$gridExitus = intval($_POST['gridExitus']);
		$gridASV = intval($_POST['gridASV']);
		$gridINTRAUCI = intval($_POST['gridINTRAUCI']);
		$gridExitus28d = intval($_POST['gridExitus28d']);
		
		$sexo_pac = intval($_POST['sexo_pac']);
		
				
		$edad_pac = $_POST['edad_pac'] !== "" ? intval($_POST['edad_pac']) : null;
		$alt_pac = $_POST['alt_pac'] !== "" ? floatval($_POST['alt_pac']) : null;
		$peso_pac = $_POST['peso_pac'] !== "" ? floatval($_POST['peso_pac']) : null;
		$imc_pac = $_POST['imc_pac'] !== "" ? floatval($_POST['imc_pac']) : null;
		
		
		
		
		  
		$query_pat_id = "SELECT pat_id FROM patients WHERE pat_id = ? ";
		$stmt= $mysqli->prepare($query_pat_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;
		
		
			if ($check_pat_id > 0) {
				
				// Verificar si ya existe otro paciente con el mismo SIP o NHC
				$query = "SELECT pat_id FROM patients WHERE pat_sip = ? AND pat_nhc = ?";
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param('ss', $sip_pac, $nhc_pac);
				$stmt->execute();
				$stmt->bind_result($pat_recuperado);
				$stmt->fetch();
				$stmt->close();
				
				
				if ($pat_recuperado !== $pat_id) {
				// Ya existe otro paciente con el mismo SIP o NHC, mostrar una alerta
				$response['error'] = 'UPDATE: Ya existe un paciente con el mismo SIP o NHC.';
				$response['warning']= true;
				$response['PAT_ID_SERVER']= $pat_recuperado;
				$response['PAT_ID_client']= $pat_id;
				
				}else{
					
					$query="UPDATE `patients`
							SET `pat_sip` = ?, `pat_nhc` = ?, `pat_age` = ?, `pat_sex`=?,
							`pat_height`=?, `pat_weight` = ?, `pat_imc`= ?,`pat_date_ingreso`= ?,
							`pat_date_alta`= ?, `pat_date_ingreso_uci`= ?, `pat_date_alta_uci`= ?,
							`pat_dateBirth`= ?,
							`estancia_hosp`= ?,`exitus`= ?,`asv`= ?,`intrauci`= ?,`exitus_28d`= ?,`date_exitus`=?

							WHERE `pat_id` = ?";
					
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('ssiidddsssssiiiiiss',
												$sip_pac,$nhc_pac,$edad_pac,
												$sexo_pac,$alt_pac, $peso_pac, $imc_pac,
												$ingreso_hosp_pac , $alta_hosp_pac, $ingreso_uci_pac ,$alta_uci_pac ,$birth_pac,
												$estancia_hosp,$gridExitus,$gridASV,$gridINTRAUCI,$gridExitus28d,$date_exitus,
												$pat_id);
					$stmt->execute();

					if ($stmt->execute()) {
						$response['success'] = true;
						
					} else {
						
						$response['error'] = "Error al ejecutar la consulta update: " . mysqli_error($mysqli);
					} 
					
					
					
					
					
					
				}
				
				
		
		
			}else{
				
				$query = "SELECT pat_id FROM patients WHERE pat_sip = ? OR pat_nhc = ?";
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param('ss', $sip_pac, $nhc_pac);
				$stmt->execute();
				$stmt->store_result();
				$check_pats = $stmt->num_rows;

				if ($check_pats > 0) {
					$stmt->bind_result($pat_recuperado);
					$stmt->fetch();

					if ($pat_recuperado !== $pat_id) {
					// Ya existe otro paciente con el mismo SIP o NHC, mostrar una alerta
					$response['error'] = 'UPDATE: Ya existe un paciente con el mismo SIP o NHC.';
					$response['warning']= true;
					
					
					}else{
						
						//sql to insert captured values
						$query="INSERT INTO `patients`(`pat_id`, `pat_doc_assigned`, `pat_sip`,`pat_nhc`,
						`pat_age`, `pat_sex`, `pat_height`, `pat_weight`, `pat_imc`,
						`pat_date_ingreso`,`pat_date_alta`, `pat_date_ingreso_uci`, `pat_date_alta_uci`,`pat_dateBirth`,
						 `estancia_hosp`, `exitus`, `asv`, `intrauci`, `exitus_28d`,`date_exitus`)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
						
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ssssiidddsssssiiiiis', $pat_id, $doc_pac,$sip_pac,$nhc_pac,$edad_pac,
													 $sexo_pac,$alt_pac, $peso_pac, $imc_pac,
													 $ingreso_hosp_pac , $alta_hosp_pac, $ingreso_uci_pac ,$alta_uci_pac ,$birth_pac,
													 $estancia_hosp,$gridExitus,$gridASV,$gridINTRAUCI,$gridExitus28d,$date_exitus);
						$stmt->execute();
						
						if ($stmt->affected_rows > 0) {
							$response['success'] = true;
							$response['warning'] = false;
							
						} else {
							
							$response['error'] = "Error al ejecutar la consulta insert: " . mysqli_error($mysqli);
						}
					}
					
					
				}else{
					//sql to insert captured values
						$query="INSERT INTO `patients`(`pat_id`, `pat_doc_assigned`, `pat_sip`,`pat_nhc`,
						`pat_age`, `pat_sex`, `pat_height`, `pat_weight`, `pat_imc`,
						`pat_date_ingreso`,`pat_date_alta`, `pat_date_ingreso_uci`, `pat_date_alta_uci`,`pat_dateBirth`,
						`estancia_hosp`, `exitus`, `asv`, `intrauci`, `exitus_28d`)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
						
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ssssiidddsssssiiiii', $pat_id, $doc_pac,$sip_pac,$nhc_pac,$edad_pac,
													 $sexo_pac,$alt_pac, $peso_pac, $imc_pac,
													 $ingreso_hosp_pac , $alta_hosp_pac, $ingreso_uci_pac ,$alta_uci_pac ,$birth_pac,
													 $estancia_hosp,$gridExitus,$gridASV,$gridINTRAUCI,$gridExitus28d);
						$stmt->execute();
						
						if ($stmt->affected_rows > 0) {
							$response['success'] = true;
							$response['warning'] = false;
							
						} else {
							
							$response['error'] = "Error al ejecutar la consulta insert: " . mysqli_error($mysqli);
						}
				}
				
				
				
				
				
			}

		
		
		
		
			
		
	}
	
	echo json_encode($response);
?>