<?php
session_start();
include('config.php');

$response = array('success' => false);


if (isset($_POST['pat_number']))
	{	
		 // nuestras variables
		$pat_id=$_POST['pat_number'];
		$rol_pat=$_POST['rol_pat'];
		$id_clinica=intval($_POST['id_clinica']);
		$diag_ingreso=$_POST['diag_ingreso'];
		$tipologia_pat=$_POST['tipologia_pat'];
		$foco_inf_pat=$_POST['foco_inf_pat'];
		
		$microorganismo = $_POST['microorganismo'];

			if ($microorganismo === null || $microorganismo === "" || $microorganismo === 0) {
				$microorganismo = null;
			} else {
				$microorganismo = intval($microorganismo);
			}
					
		
			
		$query_1="UPDATE `patients` SET `pat_role`= ? WHERE `pat_id`= ?";
		// Se realiza un update ya que el paciente ya se ha guardado con anterioridad aunque con la variable vacia
		$stmt = $mysqli->prepare($query_1);
		$rc=$stmt->bind_param('ss', $rol_pat,$pat_id);
		$stmt->execute();
			if($stmt){
				
				if($rol_pat == 'Caso'){
					
					$query_rol = "SELECT `control_pat_id`  FROM `control` WHERE `control_pat_id` = ? ";
					$stmt= $mysqli->prepare($query_rol);
					$stmt->bind_param('s', $pat_id);
					$stmt->execute();
					$stmt->store_result();
					$check_rol = $stmt->num_rows;
					
					if($check_rol > 0){
						
					  $query = "DELETE FROM control WHERE control_pat_id = ?";
					  $stmt = $mysqli->prepare($query);
					  $stmt->bind_param('s', $pat_id);
					  $stmt->execute();
						
					}
						
					$query_pat_id = "SELECT `case_pat_id`  FROM `caso` WHERE `case_pat_id` = ? ";
					$stmt= $mysqli->prepare($query_pat_id);
					$stmt->bind_param('s', $pat_id);
					$stmt->execute();
					$stmt->store_result();
					$check_pat_id = $stmt->num_rows;
					
					if ($check_pat_id > 0) {
						
						
						$query_2="UPDATE `caso` SET `pat_diag_ingreso`= ?,
									`cl_find_id`= ?,`foco_infecc`= ?,`tipologia_pat`= ?,
									`agent_etio`= ? WHERE `case_pat_id`= ?";
						
						$stmt= $mysqli->prepare($query_2);
						$stmt->bind_param('sissis',$diag_ingreso,$id_clinica,$foco_inf_pat, $tipologia_pat, $microorganismo, $pat_id);
						$stmt->execute();
						
						if($stmt)
						{
							
							$response['success'] = true;
							
							$data_micros = $_POST['data_micros'];
							
							$query1 = "DELETE FROM `microorganismos` WHERE `case_pat_id`= ? AND `test_id`= ?";
							
							$stmt1 = $mysqli->prepare($query1); //
							
							foreach ($data_micros as $row) {
								$test_id = $row['id'];
								$microos = isset($row['values']) && is_array($row['values']) ? array_map('intval', $row['values']) : null;
								
								
								
								$stmt1->bind_param('si', $pat_id, $test_id);
								$stmt1->execute();

								if ($stmt1) {
									$response['success_3'] = true;
									
									if ($microos!=null) {
										$query2 = "INSERT INTO `microorganismos`(`case_pat_id`, `microorg_id`, `test_id`) VALUES (?,?,?)";
										$stmt3 = $mysqli->prepare($query2);

										foreach ($microos as $micro_name) {
											$micro_insert = $micro_name;

											$stmt3->bind_param('sii', $pat_id, $micro_insert, $test_id);
											$stmt3->execute();

											if ($stmt3) {
												$response['success_4'] = true;
											} else {
												echo "Error in executing the statement: " . $stmt3->error;
											}
										}
								
									}else if(!is_array($microos)){
										$query2 = "INSERT INTO `microorganismos`(`case_pat_id`, `microorg_id`, `test_id`) VALUES (?,?,?)";
										$stmt3 = $mysqli->prepare($query2);

										
										$micro_insert = null;

										$stmt3->bind_param('sii', $pat_id, $micro_insert, $test_id);
										$stmt3->execute();

										if ($stmt3) {
											$response['success_4'] = true;
										} else {
											echo "Error in executing the statement: " . $stmt3->error;
										}
										
										
										
									}
								

								}else {
									echo "Error in executing the statement: " . $stmt1->error;
								}
								
							}
							
						
						}
						else {
							echo "No se encontró el registro o no se realizaron cambios.";
						}
					
					
					}else{
						
						
						$query_2="INSERT INTO `caso`(`case_pat_id`, `pat_diag_ingreso`, 
						`cl_find_id`, `foco_infecc`, `tipologia_pat`, `agent_etio`) 
						VALUES (?,?,?,?,?,?)";
				
						$stmt = $mysqli->prepare($query_2);
						$rc=$stmt->bind_param('ssissi', $pat_id, $diag_ingreso, $id_clinica,$foco_inf_pat, $tipologia_pat, $microorganismo);
						$stmt->execute();
						
						
						if ($stmt) {
							$response['success'] = true;
							
							$data_micros = $_POST['data_micros'];

							$query = "INSERT INTO `microorganismos`(`case_pat_id`, `microorg_id`, `test_id`) VALUES (?,?,?)";

							$stmt2 = $mysqli->prepare($query); // 

							foreach ($data_micros as $row) {
							$test_id = $row['id'];
							$microos = isset($row['values']) && is_array($row['values']) ? array_map('intval', $row['values']) : null;

								if ($microos!=null) {
									$query2 = "INSERT INTO `microorganismos`(`case_pat_id`, `microorg_id`, `test_id`) VALUES (?,?,?)";
									$stmt3 = $mysqli->prepare($query2);

									foreach ($microos as $micro_name) {
										$micro_insert = $micro_name;

										$stmt3->bind_param('sii', $pat_id, $micro_insert, $test_id);
										$stmt3->execute();

										if ($stmt3) {
											$response['success_4'] = true;
										} else {
											echo "Error in executing the statement: " . $stmt3->error;
										}
									}
							
								}else if(!is_array($microos)){
									$query2 = "INSERT INTO `microorganismos`(`case_pat_id`, `microorg_id`, `test_id`) VALUES (?,?,?)";
									$stmt3 = $mysqli->prepare($query2);

									
									$micro_insert = null;

									$stmt3->bind_param('sii', $pat_id, $micro_insert, $test_id);
									$stmt3->execute();

									if ($stmt3) {
										$response['success_4'] = true;
									} else {
										echo "Error in executing the statement: " . $stmt3->error;
									}
									
									
									
								}
							}
							
						}else {
							echo "No se encontró el registro o no se realizaron cambios.";
						}
						 
					}
						
					
										
				
				}else if ($rol_pat == 'Control'){
					
					$query_rol = "SELECT `case_pat_id`  FROM `caso` WHERE `case_pat_id` = ? ";
					$stmt= $mysqli->prepare($query_rol);
					$stmt->bind_param('s', $pat_id);
					$stmt->execute();
					$stmt->store_result();
					$check_rol = $stmt->num_rows;
					
					if($check_rol > 0){
						
					  $query = "DELETE FROM caso WHERE case_pat_id = ?";
					  $stmt = $mysqli->prepare($query);
					  $stmt->bind_param('s', $pat_id);
					  $stmt->execute();
						
					}
					
					$query_rol = "SELECT `case_pat_id`  FROM `microorganismos` WHERE `case_pat_id` = ? ";
					$stmt= $mysqli->prepare($query_rol);
					$stmt->bind_param('s', $pat_id);
					$stmt->execute();
					$stmt->store_result();
					$check_rol = $stmt->num_rows;
					
					if($check_rol > 0){
						
					  $query = "DELETE FROM microorganismos WHERE case_pat_id = ?";
					  $stmt = $mysqli->prepare($query);
					  $stmt->bind_param('s', $pat_id);
					  $stmt->execute();
						
					}
					
					$query_rol = "SELECT `pat_id`  FROM `antibioticos_usados` WHERE `pat_id` = ? ";
					$stmt= $mysqli->prepare($query_rol);
					$stmt->bind_param('s', $pat_id);
					$stmt->execute();
					$stmt->store_result();
					$check_rol = $stmt->num_rows;
					
					if($check_rol > 0){
						
					  $query = "DELETE FROM antibioticos_usados WHERE pat_id = ?";
					  $stmt = $mysqli->prepare($query);
					  $stmt->bind_param('s', $pat_id);
					  $stmt->execute();
						
					}
					
					
					
						$query_pat_id = "SELECT control_pat_id   FROM control WHERE control_pat_id  = ? ";
						$stmt= $mysqli->prepare($query_pat_id);
						$stmt->bind_param('s', $pat_id);
						$stmt->execute();
						$stmt->store_result();
						$check_pat_id = $stmt->num_rows;
						
						if ($check_pat_id > 0) {
							/* $query_2="UPDATE `control` SET `control_type`= ? WHERE `control_pat_id `= ?";
							
							$stmt= $mysqli->prepare($query_pat_id);
							$stmt->bind_param('ss', $control_type, $pat_id);
							$stmt->execute();  */
						
						}else{
						
							$query="INSERT INTO `control`(`control_pat_id`) 
							VALUES (?)";
					
							$stmt = $mysqli->prepare($query);
							$rc=$stmt->bind_param('s', $pat_id);
							$stmt->execute();
							
							
							if($stmt){
								
								$response['success'] = true;
								
							}
							else {
								echo "No se encontró el registro o no se realizaron cambios.";
							}
						}
					
				}
					
					
					
				
				
				
				
			}else {
				echo "No se encontró el registro o no se realizaron cambios.";
			} 
	
	   // nuestras variables
		
		
		$apacheii = $_POST['apacheii'] !== "" ? intval($_POST['apacheii']) : null;
		$bacteriemia_pat = $_POST['bacteriemia_pat'] !== "" ? intval($_POST['bacteriemia_pat']) : null;
		$ecocardio_fracc = $_POST['ecocardio_fracc'] !== "" ? floatval($_POST['ecocardio_fracc']) : null;
		
		$sat_venosa = $_POST['sat_venosa'] !== "" ? floatval($_POST['sat_venosa']) : null;
		$ecocardio_vena_cava = $_POST['ecocardio_vena_cava'] !== "" ? floatval($_POST['ecocardio_vena_cava']) : null;
		$cristaloides_pat = $_POST['cristaloides_pat'] !== "" ? floatval($_POST['cristaloides_pat']) : null;
		
		$coloides_pat = $_POST['coloides_pat'] !== "" ? floatval($_POST['coloides_pat']) : null;
		$lactato_6h = $_POST['lactato_6h'] !== "" ? floatval($_POST['lactato_6h']) : null;
		$L6H_pat = $_POST['L6H_pat'] !== "" ? intval($_POST['L6H_pat']) : null;
		
		$gridDesescalada = $_POST['gridDesescalada'] !== "" ? intval($_POST['gridDesescalada']) : null;
		
		
		$comentarios_micros=$_POST['comentarios_micros'];
		
		$pat_id=$_POST['pat_number'];
		
		
		$query_pat_id = "SELECT pat_id FROM manejo_inicial WHERE pat_id = ? ";
		$stmt= $mysqli->prepare($query_pat_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;
		
		
			if ($check_pat_id > 0) {
				$response['success'] = true;
				
				$query="UPDATE `manejo_inicial` SET `apache_2`=?, `bacteriemia`=?, `lactato_6h`=?, `lactato_elimina`=?, 
												    `ecocardio_frac`=?, `sat_ven_central`=?,`ecocardio_ven_cava_inf`=?, 
													`cristaloides`=?,`coloides`=?,`desescalada_72_antibio`=?,`comentarios_micros`=?

												WHERE `pat_id` = ?";
				
				$stmt = $mysqli->prepare($query);
				$rc=$stmt->bind_param('iididddddiss', $apacheii, $bacteriemia_pat, $lactato_6h, $L6H_pat,
													   $ecocardio_fracc, $sat_venosa, $ecocardio_vena_cava, $cristaloides_pat, 
													   $coloides_pat,$gridDesescalada,$comentarios_micros, $pat_id );
				$stmt->execute();
				
				/* if($stmt)
				{
					
					$response['success'] = true;
					
				}
				else {
					echo "No se encontró el registro o no se realizaron cambios.";
				}  */ 
				
				
			}else{
				
				$response['success'] = true;
				
				 //sql to insert captured values
				$query="INSERT INTO `manejo_inicial`(`pat_id`, `apache_2`, `bacteriemia`, `lactato_6h`, `lactato_elimina`,
													 `ecocardio_frac`, `sat_ven_central`, `ecocardio_ven_cava_inf`,
													 `cristaloides`,`coloides`, `desescalada_72_antibio`,`comentarios_micros`) 
							
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
							
				$stmt = $mysqli->prepare($query);
				$rc=$stmt->bind_param('siididddddis',$pat_id, $apacheii, $bacteriemia_pat, $lactato_6h, $L6H_pat,
												   $ecocardio_fracc, $sat_venosa, $ecocardio_vena_cava, $cristaloides_pat, 
												   $coloides_pat,$gridDesescalada, $comentarios_micros);
				
				$stmt->execute();
				
				/* if($stmt->execute())
				{
					
					$response['success'] = true;
				}
				else {
					
					$response['error'] = "Error al ejecutar la consulta update: " . mysqli_error($mysqli);
				}  */ 
				
			}  
		
		 // SOFA y lactato
		
		$sofa_ingreso=$_POST['sofa_ingreso'];
		$lactato_ingreso=$_POST['lactato_ingreso'];
		$pat_id=$_POST['pat_number'];
				
		$id_dia = 1;
		$id_tipo_toma = 'estudio';
		$UCI= 1;
		$status_dia= 0;
		
		$query_pat_id = "SELECT pat_id FROM vars WHERE pat_id = ? AND id_dia = ? AND id_tipo_toma = ? ";
		$stmt= $mysqli->prepare($query_pat_id);
		$stmt->bind_param('sis', $pat_id,$id_dia,$id_tipo_toma);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;
		
		
			
			if ($check_pat_id > 0) {
				
				
			
				$query="UPDATE `vars` SET `SOFA`=?, `lactato`=? WHERE `pat_id` = ? AND id_dia = ? AND id_tipo_toma = ? AND UCI = ?";
				
				$stmt = $mysqli->prepare($query);
				$rc=$stmt->bind_param('sssisi', $sofa_ingreso,$lactato_ingreso, $pat_id ,$id_dia,$id_tipo_toma,$UCI);
				$stmt->execute();
				
				if($stmt->execute())
				{
					
					$response['success'] = true;
					
				}
				else {
					$response['error'] = "Error al ejecutar la consulta update: " . mysqli_error($mysqli);
				}  
				
				
			}else{
				
				
				
				
				 //sql to insert captured values
				
				
				$query="INSERT INTO `vars`(`id_dia`, `id_tipo_toma`, `pat_id`, `UCI`, `SOFA`, `lactato`) VALUES (?,?,?,?,?,?)";
				
				$stmt = $mysqli->prepare($query);
				
					
				$stmt->bind_param('ississ',$id_dia, $id_tipo_toma, $pat_id, $UCI,$sofa_ingreso, $lactato_ingreso);
				
				$response['rc'] = $rc;
				$response['query'] = $query;
				$response['SOFA'] = $sofa_ingreso;
				$response['lactato'] = $lactato_ingreso;
				$response['pat_id'] = $pat_id;
				$response['id_dia'] = $id_dia;
				$response['id_tipo_toma'] = $id_tipo_toma;
				$response['UCI'] = $UCI;
				
				if ($stmt->execute()) {
					
					$response['success'] = true;
					
				} else {
					
					$response['error'] = "Error al ejecutar la consulta de inserción: " . $stmt->error;
				}
						
					
				

				
				
			}
		
		// antibioticos
		
		
		$pat_id=$_POST['pat_number'];
		//$data_antibio = $_POST['data_antibio'];
		$data_antibio = isset($_POST['data_antibio']) && is_array($_POST['data_antibio']) ? $_POST['data_antibio'] : array();

		
		$query_pat_id = "SELECT pat_id FROM antibioticos_usados WHERE pat_id = ? ";
		$stmt= $mysqli->prepare($query_pat_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;
		
		
			
			if ($check_pat_id > 0) {
				
				
				$query1 = "DELETE FROM `antibioticos_usados` WHERE `pat_id`= ?";
				
				$stmt1 = $mysqli->prepare($query1);
				$stmt1->bind_param('s', $pat_id);
				$stmt1->execute();

				if ($stmt1) {
				
					$response['success_3'] = true;
					
					$query2 = "INSERT INTO `antibioticos_usados`(`pat_id`, `ant_id`) VALUES (?,?)";

					$stmt2 = $mysqli->prepare($query2); // 

					foreach ($data_antibio as $antibio) {
						
						 $ant_id = !empty($data_antibio) ? intval($antibio) : NULL;

						
						$stmt2->bind_param('si', $pat_id, $ant_id);
						$stmt2->execute();

						if ($stmt2) {
							$response['success_4'] = true;
						} else {
							echo "Error in executing the statement: " . $stmt2->error;
						}
						
					}
					
				}else {
						echo "Error in executing the statement: " . $stmt1->error;
				}
				
				
				
			}else{
				
				$query = "INSERT INTO `antibioticos_usados`(`pat_id`, `ant_id`) VALUES (?,?)";

				$stmt2 = $mysqli->prepare($query); // 

				foreach ($data_antibio as $antibio) {
					
					 $ant_id = !empty($data_antibio) ? intval($antibio) : NULL;

					
					$stmt2->bind_param('si', $pat_id, $ant_id);
					$stmt2->execute();

					if ($stmt2) {
						$response['success_4'] = true;
					} else {
						echo "Error in executing the statement: " . $stmt2->error;
					}
					
				}
				
			}
		
		
		
		
		
	}
	
	echo json_encode($response);
?>