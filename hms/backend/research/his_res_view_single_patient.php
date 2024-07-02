<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();

  $res_id=$_SESSION['res_id'];
  //$res_number = $_SERVER['res_number'];
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('assets/inc/head.php');?>
	<style>
	
	#day_monitor option:disabled {
	  color: #999999; /* Cambia el color de la opción deshabilitada */
	}
	
	
	
	</style>

    <body>
	
	
		<!-- modal --->
		
																														


	<!-- modal Glasgow --->
		
		<!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
        
			<?php include("assets/inc/sidebar.php");?>
			
			<?php
				$pat_id=$_GET['pat_id'];
				$pat_index=$_GET['pat_index'];
				$ret="SELECT * 
				FROM `patients` 
				LEFT JOIN `control` ON `patients`.pat_id= `control`.`control_pat_id` 
				LEFT JOIN `caso` ON `patients`.pat_id= `caso`.`case_pat_id` 
				LEFT JOIN `clinical_finding` ON `caso`.`cl_find_id` = `clinical_finding`.`cl_find_id` 
				LEFT JOIN `codigo_sexo` ON `patients`.pat_sex= `codigo_sexo`.`sex_codes` 

				
				WHERE `pat_id`= ?";
				
				$stmt= $mysqli->prepare($ret) ;
				$stmt->bind_param('s',$pat_id);
				$stmt->execute() ;//ok
				$res=$stmt->get_result();
				
				$date_ingreso_uci = "";
				$date_ingreso = "";
				while($row=$res->fetch_object())
				{
					$select_rol_pat = $row->pat_role;
					$mysqlDateTime = $row->pàt_data_joined;
					
					$fecha_nacimiento = ($row->pat_dateBirth == null || empty($row->pat_dateBirth)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_dateBirth));
					
					$fecha_ingreso_hosp = ($row->pat_date_ingreso == null || empty($row->pat_date_ingreso)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_date_ingreso));
					$fecha_ingreso_uci = ($row->pat_date_ingreso_uci == null || empty($row->pat_date_ingreso_uci)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_date_ingreso_uci));
					

					$date_ingreso_uci=$row->pat_date_ingreso_uci;
					$date_ingreso=$row->pat_date_ingreso;
					
					
					
					$checked = ($row->pat_record_status == 1) ? 'checked' : '';
				?>
			
			<div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
						<!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tablero</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
                                            <li class="breadcrumb-item active">Ver pacientes</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"> Perfil <?php echo $pat_id;?></h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
						<div class="row">
                            <div class="col-lg-4 col-xl-4">
								<!--<div class="row">
									<div class="col">
										<div class="card-box text-center">
											<fieldset class="col float-lef" style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
											box-shadow: 0 0 10px #666; background:#e8f5e9">
												<legend class="float-none w-auto"></legend>
													<div class="holder">
														<div class="checkdiv grey400" >
															<input type="checkbox" class="le-checkbox" id="ficha_paciente"  <?php echo $checked;?> name="ficha_paciente"/>
															<span>Ficha completa</span>
														</div>
													</div>
											</fieldset>
										</div>
									</div>
									<div class="col">
										<div class="card-box">
											<div class="text-center">
											
												<button type="button" class="btn btn-danger btn-lg" style="width:200px;" id="guardar_dia" onclick="save_estado_ficha()">Actualizar estado ficha</button>
											</div>
										</div>
									</div>
								</div>-->
                                <div class="card-box text-center">
									
									<button class="btn btn-primary" type="button" id= "btn_details">
									Datos paciente</button>
									
									<img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

									<div id="datos_paciente" style ="display:none">
										<div class="card card-body">
											<div class="text-left mt-3">
												<p class="text-muted mb-2 font-13"><strong>Identificador interno:</strong> <span class="ml-2"><?php echo $row->pat_id;?></span></p>
												<hr>
												<p class="text-muted mb-2 font-13"><strong>Rol de estudio:</strong><span class="ml-2"><?php echo $row->pat_role;?></span></p>
												<p id="control_type" name="control_type" style="display:none" class="text-muted mb-2 font-13"><strong>Tipo de control:</strong> <span class="ml-2"><?php echo $row->control_type;?></span></p>
												<p id="clinical_finding" name="clinical_finding" style="display:none" class="text-muted mb-2 font-13"><strong>Hallazgo clínico:</strong> <span class="ml-2"><?php echo $row->cl_find_name;?></span></p>
												<p id="diagnostico" name="diagnostico" style="display:none" class="text-muted mb-2 font-13"><strong>Diagnóstico de ingreso:</strong> <span class="ml-2"><?php echo $row->pat_diag_ingreso;?></span></p>
												<hr>
												<p class="text-muted mb-2 font-13"><strong>Fecha de nacimiento:</strong> <span class="ml-2"><?php echo $fecha_nacimiento;?></span></p>
												<p class="text-muted mb-2 font-13"><strong>Edad:</strong> <span class="ml-2"><?php echo $row->pat_age;?> años</span></p>
												<p class="text-muted mb-2 font-13"><strong>Sexo:</strong> <span class="ml-2"><?php echo $row->pat_sex_name;?></span></p>
												<hr>
												<p class="text-muted mb-2 font-13"><strong>Fecha de registro:</strong> <span class="ml-2"><?php echo date("d/m/Y - H:i", strtotime($mysqlDateTime));?></span></p>
												<p class="text-muted mb-2 font-13"><strong>Ingreso hospitalario:</strong> <span class="ml-2"><?php echo $fecha_ingreso_hosp;?></span></p>
												<p class="text-muted mb-2 font-13"><strong>Ingreso en UCI:</strong> <span class="ml-2"><?php echo $fecha_ingreso_uci;?></span></p>
												<hr>
											</div>
										</div>
									</div>
									<?php } $select_rol_pat = json_encode($select_rol_pat); ?>
								</div> <!-- end card-box -->
								<div class="card-box">
									<fieldset class="border p-2">
											<legend class="float-none w-auto" style ="font-size:20px;"> Días preUCI</legend>
											   <b><span class="title">Selecciona el dia de toma de datos</span> </b>
												<div class="d-grid gap-2">
														
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-secondary btn-lg col-12" style="margin:10px;" name="btndiaIngreso_hosp" id="btndiaIngreso_hosp" 
															
															onclick="ajustar_campos('Día ingreso hospitalario','dia_ingreso_hosp_estado','#aaacc9','btndiaIngreso_hosp','HOSP')">Ingreso hospitalario</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia_ingreso_hosp_estado" name="dia_ingreso_hosp_estado" 
																	/>
																</div>
															</div>
														
														</div>
													</div>
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-secondary btn-lg col-12" style="margin:10px;" name="btndiaAnterior_uci" id="btndiaAnterior_uci" 
															
															onclick="ajustar_campos('Día anterior al ingreso en UCI','dia_anterior_uci_estado','#b2dfdb','btndiaAnterior_uci','preUCI')">Día anterior a UCI</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia_anterior_uci_estado" name="dia_anterior_uci_estado" 
																	/>
																</div>
															</div>
														
														</div>
													</div>
												</div>
												
												<br></br>
												<fieldset class="border p-2">
												
												
														<legend class="float-none w-auto" style ="font-size:20px;"> Otros días preUCI recuperados </legend>
														   <b><span class="title">Selecciona el dia de toma de datos</span> </b>
															<p></p>
															
																	
																<div class="form-inline well">
																	
																	
																	<div class="form-group" style="width:80%;">
																	
																		<?php
																		$pat_id = $_GET['pat_id'];
																		$id_tipo_toma = 'preUCI';
																		$ret = "SELECT `id_dia`
																				FROM `vars`
																				WHERE `pat_id` = ? AND `id_tipo_toma` = ?";
																		$stmt = $mysqli->prepare($ret);
																		$stmt->bind_param('ss', $pat_id, $id_tipo_toma);
																		$stmt->execute();
																		$res = $stmt->get_result();

																		// Generar los botones en HTML
																		$foundValidDays = false; // Variable para registrar si se encontraron días válidos
																		$buttonsAndCheckboxesHTML = ""; // Variable para almacenar los botones generados
																		$array_btns_otros_preuci=array();
																		
																		while ($row = $res->fetch_object()) {
																			$nombre = $row->id_dia;
																			$excluir_valores = array(1);
																			$count = 0;
																			if (!in_array($nombre, $excluir_valores)) {
																				$foundValidDays = true; // Se encontró al menos un día válido

																				if ($count % 3 == 0) {
																					$buttonsAndCheckboxesHTML .= '<div class="form-row">';
																				}

																				$color_boton ='#1b5e20';    
																				$buttonText = 'Dia ' . $nombre . ' anterior al ingreso en UCI';
																				$buttonCheck = 'dia_'. $nombre .'_preuci_estado';
																				$buttonsAndCheckboxesHTML .= '
																					<div class="form-inline well">
																						<button class="boton_dia btn btn-dark btn-lg" style="margin:5px; width: 55px;" name="btndiapre' . $nombre . '" id="btndiapre' . $nombre . '"
																						onclick="ajustar_otros(\'' . $buttonText . '\', \'' . $color_boton . '\', \'' . $buttonCheck . '\', \'' . $nombre . '\', \'' . $id_tipo_toma . '\' )">' . $nombre . '</button>
																						<div class="checkdiv grey400">
																							<input type="checkbox" class="le-checkbox" id='. $buttonCheck .' name='. $buttonCheck .' />
																						</div>
																					</div>';
																				
																				$array_btns_otros_preuci[]=$nombre;
																				
																				$count++;
																				if ($count % 3 == 0) {
																					$buttonsAndCheckboxesHTML .= '</div>';
																				}
																			}
																		}

																		if ($foundValidDays) {
																			echo '<div id="botonesGenerados">' . $buttonsAndCheckboxesHTML . '</div>';
																		} else {
																			echo 'No se han registrado otros días.';
																		}
																		
																		$array_btns_otros_preuci=json_encode($array_btns_otros_preuci);
																		?>
																	
																		<div class="button-container" id="botonesGenerados"></div>
																		
																	</div>
																	
																</div>
															
															<br></br>
														
												</fieldset>
									</fieldset>
								</div>
								
								<div class="card-box">
								 <fieldset class="border p-2">
											<legend class="float-none w-auto" style ="font-size:20px;"> Días de estudio</legend>
											   <b><span class="title">Selecciona el dia de toma de datos</span> </b>
												<div class="d-grid gap-2">
														
													<!--<div class="form-inline well" style="display:none">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-primary btn-lg col-12" style="margin:10px;" name="btndiaIngreso" id="btndiaIngreso" 
															
															onclick="ajustar_campos('Día ingreso de estudio','dia_ingreso_estado','#aaacc9','btndiaIngreso')">Ingreso</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia_ingreso_estado" name="dia_ingreso_estado" 
																	/>
																</div>
															</div>
														
														</div>
													</div>-->
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-primary btn-lg col-12" style="margin:10px;" name="btndia1" id="btndia1" 
															
															onclick="ajustar_campos('Ingreso (1er día) de estudio','dia1_estado','#3f51b5','btndia1','estudio')">Ingreso (1er día)</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia1_estado" name="dia1_estado"
																	/>
																</div>
															</div>
														
														</div>
													</div>
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
													
															<button type="button" class="boton_dia btn-action btn-primary btn-lg col-12" style="margin:10px;"  name="btndia3" id="btndia3" 
															
															onclick="ajustar_campos('Día 3 de estudio', 'dia3_estado','#00897b','btndia3','estudio')">3er día</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia3_estado" name="dia3_estado"
																	/>
																</div>
															</div>
														
														</div>
													</div>
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-primary btn-lg col-12" style="margin:10px;" name="btndia5"  id="btndia5" 
															
															onclick="ajustar_campos('Día 5 de estudio','dia5_estado','#0097a7','btndia5','estudio')">5to día</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input  style="display:none" type="checkbox" class="le-checkbox" id="dia5_estado" name="dia5_estado"
																	/>
																</div>
															</div>
														
														</div>
													</div>
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-primary btn-lg col-12" style="margin:10px;" name="btndia7" id="btndia7" 
															
															onclick="ajustar_campos('Día 7 de estudio','dia7_estado','#7b1fa2','btndia7','estudio')">7to día</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia7_estado" name="dia7_estado"
																	/>
																</div>
															</div>
														
														</div>
													</div>
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="boton_dia btn-action btn-primary btn-lg col-12" style="margin:10px;"  name= "btndia14" id="btndia14" 
															
															onclick="ajustar_campos('Día 14 de estudio','dia14_estado','#f8bbd0','btndia14','estudio')">14to día</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia14_estado" name="dia14_estado"
																	/>
																</div>
															</div>
														
														</div>
													</div>
													
														
												</div>
												<br></br>
												<fieldset class="border p-2">
												
												
														<legend class="float-none w-auto" style ="font-size:20px;"> Otros días de estudio recuperados </legend>
														   <b><span class="title">Selecciona el dia de toma de datos</span> </b>
															<p></p>
															
																	
																<div class="form-inline well">
																	
																	
																	<div class="form-group" style="width:80%;">
																	
																		<?php
																		$pat_id = $_GET['pat_id'];
																		$id_tipo_toma = 'estudio';
																		$ret = "SELECT `id_dia`
																				FROM `vars`
																				WHERE `pat_id` = ? AND `id_tipo_toma` = ?";
																		$stmt = $mysqli->prepare($ret);
																		$stmt->bind_param('ss', $pat_id, $id_tipo_toma);
																		$stmt->execute();
																		$res = $stmt->get_result();
																		
																		$array_btns_otros=array();
																		// Generar los botones en HTML
																		if ($res->num_rows > 0) {
																			$buttonsAndCheckboxesHTML = "";
																			$count = 0;
																			
																			while ($row = $res->fetch_object()) {
																				$nombre = $row->id_dia; 
																				$excluir_valores = array(1, 3, 5, 7, 14);
																				if (!in_array($nombre, $excluir_valores)) {
																					if ($count % 3 == 0) {
																						$buttonsAndCheckboxesHTML .= '<div class="form-row">';
																					}
																					
																					$color_boton ='#1b5e20';	
																					$buttonText = 'Dia ' . $nombre . ' de estudio';
																					$buttonCheck = 'dia'. $nombre .'_estado';
																					$buttonsAndCheckboxesHTML .= '
																						<div class="form-inline well">
																							<button class="boton_dia btn btn-info btn-lg" style="margin:5px; width: 55px;" name="btndia' . $nombre . '" id="btndia' . $nombre . '"
																							onclick="ajustar_otros(\'' . $buttonText . '\', \'' . $color_boton . '\', \'' . $buttonCheck . '\', \'' . $nombre . '\', \'' . $id_tipo_toma . '\' )">' . $nombre . '</button>
																							<div class="checkdiv grey400">
																								<input type="checkbox" class="le-checkbox" id='. $buttonCheck .' name='. $buttonCheck .' />
																							</div>
																						</div>';
																																																												
																					$array_btns_otros[]=$nombre;
																						
																					$count++;
																					if ($count % 3 == 0) {
																						$buttonsAndCheckboxesHTML .= '</div>';
																					}
																				}
																			}
																			
																			if ($count % 3 != 0) {
																				$buttonsAndCheckboxesHTML .= '</div>';
																			}
																			echo '<div id="botonesGenerados">' . $buttonsAndCheckboxesHTML . '</div>';
																		} else {
																			echo 'No se han registrado otros días.';
																		}
																		
																		
																		$array_btns_otros=json_encode($array_btns_otros);?>
																	
																		<div class="button-container" id="botonesGenerados"></div>
																		
																	</div>
																	
																</div>
															
															<br></br>
														
												</fieldset>
									 </fieldset>
									
								</div>
								<!--<div class="card-box" style="display:none">
									<fieldset class="border p-2">
											<legend class="float-none w-auto" style ="font-size:20px;"> Días postUCI</legend>
											   <b><span class="title">Selecciona el dia de toma de datos</span> </b>
												<div class="d-grid gap-2">
														
													<div class="form-inline well">
														
														
														<div class="form-group" style="width:80%;">
															<button type="button" class="btn-action btn-primary btn-lg col-12" style="margin:10px;" name="btndiaIngreso" id="btndiaIngreso" 
															
															onclick="ajustar_campos('Día ingreso','dia_ingreso_estado','#aaacc9','btndiaIngreso')">Otro</button>
														</div>
														<div class="form-group">
															<div class="holder">
																<div class="checkdiv grey400">
																	<input style="display:none" type="checkbox" class="le-checkbox" id="dia_ingreso_estado" name="dia_ingreso_estado" 
																	/>
																</div>
															</div>
														
														</div>
													</div>
												</div>
									</fieldset>
								</div>-->
								
								

                            </div> <!-- end col-->
							<div class="col-lg-8 col-xl-8">
								<div class="card-box">
									<div class="jumbotron" style="height: 50%;" id= "jumbotron_color">
										<div class="row">
											<h1 style="color:white" id="jumbotron_dia" > Ningún día seleccionado </h1> 
											<div class="holder">
												<div class="checkdiv grey400">
													<input type="checkbox" class="le-checkbox" id="status_dia" name="status_dia"
													/>
												</div>
											</div>
										</div>	
									</div>
								
								</div>
								<?php
									$pat_id = $_GET['pat_id'];

									// Obtener fechas de ingreso hosp y uci del paciente
									$query = "SELECT * FROM patients WHERE pat_id = ?";
									$stmt = $mysqli->prepare($query);
									$stmt->bind_param('s', $pat_id);
									$stmt->execute();
									$resultado = $stmt->get_result();

									// Verificar si se obtuvieron resultados
									if ($resultado->num_rows > 0) {
										while ($row = $resultado->fetch_object()) {
											$ingreso_hosp = new DateTime($row->pat_date_ingreso);
											$ingreso_uci = new DateTime($row->pat_date_ingreso_uci);
										}
										$stmt->free_result();

										$intervalo = $ingreso_uci->diff($ingreso_hosp);
										$diferenciaDias = ($intervalo->days);

										$diferenciaDias_num = ($intervalo->days);

										$opciones_dates = array();
										
										for ($i = 0; $i <= $diferenciaDias; $i++) {
											if ($i==0){
												$opciones_dates[$i] = 'Ingreso en UCI';
												
											}else if ($i==1) {
												$opciones_dates[$i]='Día anterior a UCI';
												$primer_diaPreuci = $i;
												
											}else if ($i==$diferenciaDias) {
												
												$opciones_dates[$i]='Ingreso hospitalario';
												
											}else{
												$opciones_dates[$i]=$i;
											}
											
										}
										
										
									} else {
										echo 'No se encontraron opciones.';
									}

									$stmt->close();
								?>
								
								<div class="card-box" id="campos_variables">
									<div class="form-row justify-content-between" id="custom_day_divs" style= "display: none;">
										<div class="form-row justify-content-between">
											
											<fieldset id= "datos_preUCI"  class="col-2 float-right campo_toma_datos" style="display:none">
												<legend class=" legendCustom float-none w-auto">Toma de datos</legend>
													<div class="form-row">
														
														<div class="col-8" style="margin-left: 20px;">
															<label for="date_monitor_preuci" class="col-form-label"> Fecha preUCI</label>
															<input type="date" name="date_monitor_preuci" class="form-control" id="date_monitor_preuci" readonly>
														</div>
														
													</div>
											<p></p>
											</fieldset>
											
									
											<fieldset class="col-7 float-lef" style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
											box-shadow: 0 0 10px #666; background:#e8f5e9">
												<legend class=" legendCustom float-none w-auto">Dia personalizado de estudio</legend>
													<div class="form-row">
														<div class="col-4">
															<label for="day_monitor" class="col-form-label">Dia de la toma de datos</label>
															<!-- <input type="text" required="required" name="day_monitor"  maxlength="2" class="form-control" 
															id="day_monitor" onkeypress ="only_int_nums(event)" oninput= "getDateMonitor()" >-->
															
															<select name="day_monitor" id="day_monitor"  class="form-control" onclick= "ajuste_id_dia()">
																  <option value="">--Elige--</option>
																  <option value="0">Ingreso</option>
																  <option value="1">1</option>
																  <option value="2">2</option>
																  <option value="3">3</option>
																  <option value="4">4</option>
																  <option value="5">5</option>
																  <option value="6">6</option>
																  <option value="7">7</option>
																  <option value="8">8</option>
																  <option value="9">9</option>
																  <option value="10">10</option>
																  <option value="11">11</option>
																  <option value="12">12</option>
																  <option value="13">13</option>
																  <option value="14">14</option>
																  <option value="15">15</option>
																  <option value="16">16</option>
																  <option value="17">17</option>
																  <option value="18">18</option>
																  <option value="19">19</option>
																  <option value="20">20</option>
																  <option value="21">21</option>
																  <option value="22">22</option>
																  <option value="23">23</option>
																  <option value="24">24</option>
																  <option value="24">25</option>
																  <option value="24">26</option>
																  <option value="24">27</option>
																  <option value="24">28</option>
																  <option value="24">29</option>
																  <option value="24">30</option>
																  
																  
															  
																
															</select> 
														</div>
														
														
														<div class="col">
															<label for="date_monitor" class="col-form-label">Fecha de la toma de datos</label>
															<input type="date" name="date_monitor" class="form-control" id="date_monitor" readonly>
														</div>
														<div id="info_preuci_1" class="col-2 float-right" style="display:none">
														<button type="button" class="btn btn-sm btn-info" data-toggle="popover" title="Información" 
														data-content="Solo se pueden ingresar dias posteriores al ingreso hospitalario y anteriores al ingreso en UCI."
														style="position: absolute; top: -10px; right: 50px; font-size: smaller;">i</button>
													</div>
												</div>
												<p></p>
												<p id="info_preuci_2" style="display:none" style="margin-left: 20px;">   La diferencia en días entre el ingreso en UCI y hospitalario es de: <?php echo $diferenciaDias_num; ?></p>
												
											</fieldset>
											<fieldset class="col-3 float-right" style="padding:14px; border:3px solid #0288d1; border-radius: 8px;
												box-shadow: 0 0 10px #666; background:#e1f5fe">
												<legend class=" legendPat float-none w-auto">Datos paciente</legend>
												<div class="form-row">
													
													
													<div class="col-md">
														<label for="date_ingreso_uci" class="col-form-label">Fecha ingreso UCI </label>
														<input required="required" type="date" name="date_ingreso_uci" class="form-control"  
														id="date_ingreso_uci" readonly>
														
													</div>
													<div class="col-md" id="campo_fecha_ingreso" style="display:none">
														<label for="date_ingreso" class="col-form-label">Fecha ingreso hospitalario</label>
														<input required="required" type="date" name="date_ingreso" class="form-control"  
														id="date_ingreso"  readonly>
														
													</div>
													
												
												</div>
												
											</fieldset>
										</div>	
										
									</div>
									
									
										<div class="form-row justify-content-between">
											<div id="paciente_estancia_uci" style="display:none">
												<fieldset class="col float-lef" style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
													box-shadow: 0 0 10px #666; background:#e8f5e9">
														<legend class="float-none w-auto"></legend>
															<div class="container" >
															<div class="myTest custom-control custom-checkbox">
																  <input type="checkbox" class="custom-control-input" id="UCI_pat" name="UCI_pat" />
																  <label class="custom-control-label"  style="color:green; font-size:15px" for="UCI_pat">¿El paciente se encuentra en UCI?</label>
																</div>
																
															</div>
															
															
												</fieldset>
											</div>
											<fieldset id= "datos_ecc"  class="col-3 float-right campo_toma_datos" style="display:none">
													<legend class=" legendCustom float-none w-auto">Diagnóstico ECC</legend>
													<form action="" method="post" name= "diagnostico_ecc" id="diagnostico_ecc">
														<div class="form-row" style="margin-left: 20px;margin-right: 5px;">
															
															<div class="col">
																
																<div class="myDiagnosis custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" id="VM_96h_pat_check" name="VM_96h_pat_check" />
																	<label class="custom-control-label"  style="color:black; font-size:15px" for="VM_96h_pat_check">VM > 96h </label>
																	<input type="hidden" name="VM_96h_pat" value="0" />  
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" id="traqueo_pat_check" name="traqueo_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="traqueo_pat_check">Traqueo </label>
																	<input type="hidden" name="traqueo_pat" value="0" />   
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" id="infecccion_nosoco_pat_check" name="infecccion_nosoco_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="infecccion_nosoco_pat_check">Infección nosocomial </label>
																	<input type="hidden" name="infecccion_nosoco_pat" value="0" />    
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" id="upp_pat_check" name="upp_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="upp_pat_check">Úlcera por presión</label>
																	 <input type="hidden" name="upp_pat" value="0" />   
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" id="fmo_pat_check" name="fmo_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="fmo_pat_check">FMO</label>
																	 <input type="hidden" name="fmo_pat" value="0" />   
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	 <input type="checkbox" class="custom-control-input" id="perdida_masa_musc_pat_check" name="perdida_masa_musc_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="perdida_masa_musc_pat_check">Pérdida de masa muscular</label>
																	 <input type="hidden" name="perdida_masa_musc_pat" value="0" />  
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	 <input type="checkbox" class="custom-control-input" id="malnutricion_pat_check" name="malnutricion_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="malnutricion_pat_check">Malnutrición</label>
																	 <input type="hidden" name="malnutricion_pat" value="0" />  
																</div>
																<div class="myDiagnosis custom-control custom-checkbox">
																	<input type="checkbox" class="custom-control-input" id="det_cognitivo_pat_check" name="det_cognitivo_pat_check" />
																	  <label class="custom-control-label"  style="color:black; font-size:15px" for="det_cognitivo_pat_check">Deterioro cognitivo</label>
																	  <input type="hidden" name="det_cognitivo_pat" value="0" />  
																</div>
																<br></br>
																<div class="col-md" style="display:none">
																		<label for="contador_ecc" class="col-form-label text-right">Contador ECC</label>
																		<input type="number" name="contador_ecc" class="form-control" id="contador_ecc" style="width:80px" value=0 readonly>
																	  </div>
																<fieldset  class="campo_toma_datos">
																	<div class="holder">
																		<div class="myDiagnosis checkdiv grey400">
																			<input type="checkbox" class="le-checkbox" id="status_ecc_pat_check" name="status_ecc_pat_check" style="width: 25px; height: 25px;" disabled />
																			<span><b>Paciente ECC</b></span>
																			<input type="hidden" name="status_ecc_pat" value="0" />  
																		</div>
																	</div>
																
																</fieldset>
															
																
															</div>
														</div>
													</form>	
												<p></p>
													
												</fieldset>
											
											
												<fieldset id= "datos_pics"  class="col-7 float-right campo_toma_datos" style="display:none">
													<legend class=" legendCustom float-none w-auto">Diagnóstico PICS</legend>
														<div class="form-row" style="margin-left: 20px; margin-right: 5px;">
															<div class="row">
																<div class="col">
																	<fieldset class="col" style="padding:14px; border:3px solid #0288d1; border-radius: 8px;
																	box-shadow: 0 0 10px #666; background:#e1f5fe">
																		  <div class="col-md ">
																			<label for="PCR_pat_copied" class="col-form-label text-right">PCR</label>
																			<input type="number" name="PCR_pat_copied" class="form-control" id="PCR_pat_copied" style="width:80px" step="0.1" readonly>
																		  </div>
																		  <div class="col-md">
																			<label for="albumina_pat_copied" class="col-form-label text-right">Albúmina</label>
																			<input type="number" name="albumina_pat_copied" class="form-control" id="albumina_pat_copied" style="width:80px" readonly>
																		  </div>
																		  <div class="col-md">
																			<label for="linfocitos_abs_pat_copied" class="col-form-label text-right">Linfocitos</label>
																			<input type="number" name="linfocitos_abs_pat_copied" class="form-control" id="linfocitos_abs_pat_copied" style="width:80px" readonly>
																		  </div>
																		  <div class="col-md">
																			<label for="rbp_pat_copied" class="col-form-label text-right">RBP</label>
																			<input type="number" name="rbp_pat_copied" class="form-control" id="rbp_pat_copied" readonly style="width:80px">
																		  </div>
																		  <div class="col-md">
																			<label for="prealbumina_pat_copied" class="col-form-label text-right">Prealbúmina</label>
																			<input type="number" name="prealbumina_pat_copied" class="form-control" id="prealbumina_pat_copied" style="width:80px" readonly>
																		  </div>
																	</fieldset> 
																<br></br>												
																</div>
																<form action="" method="post" name= "diagnostico_pics" id="diagnostico_pics">
																<div class="col">

																	  <div class="myDiagnosis custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="pcr_pics_pat_check" name="pcr_pics_pat_check" disabled />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="pcr_pics_pat_check">PCR &gt;1.5</label>
																		<input type="hidden" name="pcr_pics_pat" value="0" />
																	  </div>
																	  
																	  <div class="myDiagnosis custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="linfo_pics_pat_check" name="linfo_pics_pat_check" disabled />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="linfo_pics_pat_check">Linfocitos abs &lt;800</label>
																		<input type="hidden" name="linfo_pics_pat" value="0" />
																	  </div>
																	  
																	  <div class="myDiagnosis custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="albumnina_pics_pat_check" name="albumnina_pics_pat_check" disabled />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="albumnina_pics_pat_check">Albúmina &lt;3 g/dL</label>
																		<input type="hidden" name="albumnina_pics_pat" value="0" />
																	  </div>
																	  <div class="myDiagnosis custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="rbp_pics_pat_check" name="rbp_pics_pat_check" disabled />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="rbp_pics_pat_check">RBP &lt;1 mg/dl</label>
																		<input type="hidden" name="rbp_pics_pat" value="0" />
																	  </div>
																	  <div class="myDiagnosis custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="prealbumina_pics_pat_check" name="prealbumina_pics_pat_check" disabled />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="prealbumina_pics_pat_check">Prealbúmina &lt;10 mg/dl</label>
																		<input type="hidden" name="prealbumina_pics_pat" value="0" />
																	  </div>
																	
																		<br></br>
																	<fieldset  class="campo_toma_datos">
																	<div class="col-md" style="display:none">
																		<label for="contador_pics" class="col-form-label text-right">Contador PICS</label>
																		<input type="number" name="contador_pics" class="form-control" id="contador_pics" style="width:80px" value=0 readonly>
																	  </div>
																	<div class="holder">
																		<div class="checkdiv grey400">
																			<input type="checkbox" class="le-checkbox" id="status_ecc_pat_copied" name="status_ecc_pat_copied" style="width: 25px; height: 25px;" disabled />
																			<span><b>Paciente ECC</b></span>
																		</div>
																		<div class="myDiagnosis checkdiv grey400">
																			<input type="checkbox" class="le-checkbox" id="status_pics_pat_check" name="status_pics_pat_check" style="width: 25px; height: 25px;" disabled />
																			<span><b>Paciente PICS</b></span>
																			<input type="hidden" name="status_pics_pat" value="0" />
																		</div>
																	</div>
																
																</fieldset>
																</div>
																</form>
																
															</div>
														
																
															 
														</div>
															
																
												<p></p>
													
												</fieldset>
											</div>
										<br></br>
									<div id="campos_blurred_variables">
									<form action="" method="post" name= "ingreso_datos" id="ingreso_datos" >
											<br></br>
											<div id="identificadores"style= "display:none">
												<div class="col-md" >
															
													<label for="id_dia" class="col-form-label" >Identificador dia</label>
													<input type="number" name="id_dia"  class="form-control" id="id_dia"   readonly>
												</div>
												<div class="col-md" >
													<label for="pat_id"  class="col-form-label">Identificador interno</label>
													<input type="text"   name="pat_id"  class="form-control" id="pat_id" readonly>
												</div>
												
												<div class="col-md" >
													<label for="id_tipo_toma"   class="col-form-label">Identificador momento de toma</label>
													<input type="text"   name="id_tipo_toma"  class="form-control" id="id_tipo_toma"  readonly>
												</div>
											</div>
										<fieldset class=".custom-fieldset	 border p-2">
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Biomarcadores</legend>
											<div class="fields">
											
												<div class="form-row">
													
														<div class="col">
																	
															<label for="SOFA_pat" class="col-form-label">SOFA</label>
															<div class="input-group"> 
																<input class="font-weight-bold" type="number" class="form-control" name="SOFA_pat" id="SOFA_pat" style="width:80px;" >
																
															</div>
															
														<!-- los modales están al principio del body, se han recolocado ahí para evitar errores al abrir las ventanas emergentes-->
														
														</div>
														<div class="col">
															<label for="PCR_pat" class="col-form-label">PCR</label>
															<div class="input-group">
																<input  type="number"  class="form-control"  name= "PCR_pat" id="PCR_pat"  oninput= "duplicate(this.id)" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/L</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="lactato_pat" class="col-form-label">Lactato</label>
															<div class="input-group">
																<input  type="number" name="lactato_pat" class="form-control"  id="lactato_pat"  step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mmol/L</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="pH_pat" class="col-form-label">pH</label>
															<input required="required" type="number" name="pH_pat" class="form-control"  id="pH_pat" placeholder="" step = "0.1">
														</div>
														<div class="col">
															<label for="procalcitonina_pat" class="col-form-label">Procalcitonina</label>
															<div class="input-group">	
																<input  type="number" name="procalcitonina_pat" class="form-control"  id="procalcitonina_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">ng/mL</span>
																</div>
															</div>
														</div>
												</div>
												<div class="form-row">
														<div class="col">
															<label for="H2B_pat" class="col-form-label">H2B</label>
															<div class="input-group">
																<input  type="number" name="H2B_pat" class="form-control"  id="H2B_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">ng/mL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="H3_pat" class="col-form-label">H3</label>
															<div class="input-group">
																<input  type="number" name="H3_pat" class="form-control"  id="H3_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">ng/mL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="H4_pat" class="col-form-label">H4</label>
															<div class="input-group">
																<input  type="number" name="H4_pat" class="form-control"  id="H4_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">ng/mL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="PCA_pat" class="col-form-label">PCA</label>
															<div class="input-group">
																<input  type="number" name="PCA_pat" class="form-control"  id="PCA_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">ng/mL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="prot_C_pat" class="col-form-label">Proteina C funcional</label>
															<div class="input-group">
																<input  type="number" name="prot_C_pat" class="form-control"  id="prot_C_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">%</span>
																</div>
															</div>
														</div>
											
												</div>
											</div>
											
										</fieldset>
										<br></br>
										<fieldset class="border p-2">
													   
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Constantes vitales</legend>
											<div class="fields">
											
												<div class="form-row">
													<div class="col-2">
														<label for="FR_pat" class="col-form-label">FR</label>
														<div class="input-group">
															<input  type="number" name="FR_pat" class="form-control"  id="FR_pat" placeholder="" onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">resp/min</span>
															</div>
														</div>
													</div>
													<div class="col-2">
														<label for="TAS_pat" class="col-form-label">TAS</label>
														<div class="input-group">
															<input type="number" name="TAS_pat" class="form-control"  id="TAS_pat" placeholder="" onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmHg</span>
															</div>
														</div>
													</div>
													<div class="col-2">
														<label for="TAM_pat" class="col-form-label">TAM</label>
														<div class="input-group">
															<input type="number" name="TAM_pat" class="form-control"  id="TAM_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmHg</span>
															</div>
														</div>
													</div>
													
												</div>
											</div>
										</fieldset>
												
										<br></br>
										<fieldset class="border p-2">
													   
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Bioquímica</legend>
											<div class="fields">
											
												<div class="form-row">
													<div class="col">
														<label for="glucosa_pat" class="col-form-label">Glucosa</label>
														<div class="input-group">	
															<input type="number" name="glucosa_pat" class="form-control"  id="glucosa_pat" placeholder="" onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="urea_pat" class="col-form-label">Urea</label>
														<div class="input-group">	
															<input  type="number" name="urea_pat" class="form-control"  id="urea_pat" placeholder="" onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="creatinina_pat" class="col-form-label">Creatinina</label>
														<div class="input-group">	
															<input type="number" name="creatinina_pat" class="form-control"  id="creatinina_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="Ca_pat" class="col-form-label">Calcio (Ca)</label>
														<div class="input-group">
															<input type="number" name="Ca_pat" class="form-control"  id="Ca_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="fosforo_pat" class="col-form-label">Fosforo (P)</label>
														<div class="input-group">	
															<input type="number" name="fosforo_pat" class="form-control"  id="fosforo_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
												</div>
												<div class="form-row">
													
													<div class="col">
														<label for="Fe_pat" class="col-form-label">Hierro (Fe)</label>
														<div class="input-group">	
															<input type="number" name="Fe_pat" class="form-control"  id="Fe_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">µG/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="transferrina_pat" class="col-form-label">Transferrina</label>
														<div class="input-group">	
															<input type="number" name="transferrina_pat" class="form-control"  id="transferrina_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="IST_pat" class="col-form-label">IST</label>
														<div class="input-group">
															<input type="number" name="IST_pat" class="form-control"  id="IST_pat" placeholder="Ind.sat.transferrina" step = "0.1">
															<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="ferritina_pat" class="col-form-label">Ferritina</label>
														<div class="input-group">	
															<input type="number" name="ferritina_pat" class="form-control"  id="ferritina_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">ng/mL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="colesterol_total_pat" class="col-form-label">Colesterol total</label>
														<div class="input-group">
															<input type="number" name="colesterol_total_pat" class="form-control"  id="colesterol_total_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
												</div>
												<div class="form-row">
													
														<div class="col">
															<label for="trigliceridos_pat" class="col-form-label">Trigliceridos</label>
															<div class="input-group">
																<input type="number" name="trigliceridos_pat" class="form-control"  id="trigliceridos_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="hdl_pat" class="col-form-label">HDL</label>
															<div class="input-group">
																<input  type="number" name="hdl_pat" class="form-control"  id="hdl_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="ldl_pat" class="col-form-label">LDL</label>
															<div class="input-group">
																<input type="number" name="ldl_pat" class="form-control"  id="ldl_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="magnesio_pat" class="col-form-label">Magnesio (Mg)</label>
															<div class="input-group">	
																<input type="number" name="magnesio_pat" class="form-control"  id="magnesio_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
													
														<div class="col">
															<label for="proteina_total_pat" class="col-form-label">Proteina total</label>
															<div class="input-group">
																<input type="number" name="proteina_total_pat" class="form-control"  id="proteina_total_pat"  step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">g/dL</span>
																</div>
															</div>
														</div>
													</div>
													
													<div class="form-row">
														<div class="col">
															<label for="albumina_pat" class="col-form-label">Albúmina</label>
															<div class="input-group">
																<input  type="number" name="albumina_pat" class="form-control"  id="albumina_pat" placeholder="" step = "0.1" oninput= "duplicate(this.id)">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">g/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="bilirrubina_total_pat" class="col-form-label">Bilirrubina total</label>
															<div class="input-group">	
																<input type="number" name="bilirrubina_total_pat" class="form-control"  id="bilirrubina_total_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="bilirrubina_direct_pat" class="col-form-label">Bilirrubina directa</label>
															<div class="input-group">	
																<input type="number" name="bilirrubina_direct_pat" class="form-control"  id="bilirrubina_direct_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="cpk_pat" class="col-form-label">CPK</label>
															<div class="input-group">	
																<input type="number" name="cpk_pat" class="form-control"  id="cpk_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">U/L</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="trasaminasa_got_pat" class="col-form-label">Transaminasa GOT</label>
															<div class="input-group">	
																<input type="number" name="trasaminasa_got_pat" class="form-control"  id="trasaminasa_got_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">U/L</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="trasaminasa_gpt_pat" class="col-form-label">Transaminasa GPT</label>
															<div class="input-group">	
																<input type="number" name="trasaminasa_gpt_pat" class="form-control"  id="trasaminasa_gpt_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">U/L</span>
																</div>
															</div>
														</div>
													</div>
													<div class="form-row">
														
														<div class="col">
															<label for="transaminasa_ggt_pat" class="col-form-label">Transaminasa GGT</label>
															<div class="input-group">	
																<input type="number" name="transaminasa_ggt_pat" class="form-control"  id="transaminasa_ggt_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">U/L</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="Zn_pat" class="col-form-label">Zinc (Zn)</label>
															<div class="input-group">	
																<input type="number" name="Zn_pat" class="form-control"  id="Zn_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">µg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="fosfatasa_alcalina_pat" class="col-form-label">Fosfatasa alcalina</label>
															<div class="input-group">	
																<input type="number" name="fosfatasa_alcalina_pat" class="form-control"  id="fosfatasa_alcalina_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">U/L</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="acido_urico_pat" class="col-form-label">Ácido úrico</label>
															<div class="input-group">	
																<input type="number" name="acido_urico_pat" class="form-control"  id="acido_urico_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mg/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="LDH_pat" class="col-form-label">LDH</label>
															<div class="input-group">	
																<input required="required" type="number" name="LDH_pat" class="form-control"  id="LDH_pat" placeholder="Lactato deshidrogenasa" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">U/L</span>
																</div>
															</div>
														</div>
													</div>
												<div class="form-row">
													
														
														
														
												</div>
												
											</div>
										</fieldset>
										<br></br>
										<fieldset class="border p-2">
													   
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Hemograma</legend>
											<div class="fields">
												<div class="form-row">
														<div class="col">
															<label for="leucocitos_pat" class="col-form-label">Leucocitos</label>
															<div class="input-group">
																<input type="number" name="leucocitos_pat" class="form-control"  id="leucocitos_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">10<sup>3</sup>/mm3</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="neutrofilos_pat" class="col-form-label">Neutrofilos</label>
															<div class="input-group">
																<input  type="number" name="neutrofilos_pat" class="form-control"  id="neutrofilos_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">%</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="hemoglobina_pat" class="col-form-label">Hemoglobina</label>
															<div class="input-group">
																<input type="number" name="hemoglobina_pat" class="form-control"  id="hemoglobina_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">g/dL</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="hematocrito_pat" class="col-form-label">Hematocritos</label>
															<div class="input-group">
																<input  type="number" name="hematocrito_pat" class="form-control"  id="hematocrito_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">%</span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="plaquetas_pat" class="col-form-label">Plaquetas</label>
															<div class="input-group">
																<input  type="number" name="plaquetas_pat" class="form-control"  id="plaquetas_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">10<sup>3</sup>/mm3 </span>
																</div>
															</div>
														</div>
														<div class="col">
															<label for="linfocitos_abs_pat" class="col-form-label">Linfocitos absolutos</label>
															<div class="input-group">
																<input  type="number" name="linfocitos_abs_pat" class="form-control"  id="linfocitos_abs_pat" placeholder="" step = "0.1">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">10<sup>3</sup>/mm3 </span>
																</div>
															</div>
														</div>
														
														
														
														
														
												</div>
											</div>
										</fieldset>
										<br></br>
										<br></br>
										<fieldset class="border p-2">
													   
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Coagulación</legend>
											<div class="fields">
												<div class="form-row">
													<div class="col">
														<label for="t_pro_trombina_pat" class="col-form-label">Tiempo de protrombina</label>
														<div class="input-group">	
															<input type="number" name="t_pro_trombina_pat" class="form-control"  id="t_pro_trombina_pat" placeholder="segundos" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">s</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="ind_quick_pat" class="col-form-label">Índice quick</label>
														<div class="input-group">
															<input type="text" name="ind_quick_pat" class="form-control"  id="ind_quick_pat"  onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="inr_pat" class="col-form-label">INR</label>
														
															<input type="number" name="inr_pat" class="form-control"  id="inr_pat" step = "0.1">
															
														
													</div>
													<div class="col">
														<label for="t_tromboplastina_parcial_act_pat" class="col-form-label">Tiempo tromboplastina parcial activado</label>
														<div class="input-group">	
															<input type="number" name="t_tromboplastina_parcial_act_pat" class="form-control"  id="t_tromboplastina_parcial_act_pat" placeholder="segundos" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">s</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="dimero_d_pat" class="col-form-label">Dimero D</label>
														<div class="input-group">	
															<input type="number" name="dimero_d_pat" class="form-control"  id="dimero_d_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">ng/mL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="antitrombina_3_pat" class="col-form-label">Niveles de antitrombina 3</label>
														<div class="input-group">
															<input required="required" type="number" name="antitrombina_3_pat" class="form-control"  id="antitrombina_3_pat"  >
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col-2">
														<label for="fibrinogeno_pat" class="col-form-label">Fibrinógeno</label>
														<div class="input-group">	
															<input type="number" name="fibrinogeno_pat" class="form-control"  id="fibrinogeno_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">g/L</span>
															</div>
														</div>
													</div>
														
														
														
												</div>
												
												
												
											</div>
										</fieldset>
										<br></br>
										<fieldset class="border p-2">
													   
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Proteinas,indicadores y vitaminas</legend>
											<div class="fields">
												
												<div class="form-row">
													<div class="col">
														<label for="prealbumina_pat" class="col-form-label">Prealbúmina</label>
														<div class="input-group">
															<input  type="number" name="prealbumina_pat" class="form-control"  id="prealbumina_pat" placeholder="" step = "0.1" oninput= "duplicate(this.id)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="rbp_pat" class="col-form-label">Proteina fijadora del retinol</label>
														<div class="input-group">	
															<input type="number" name="rbp_pat" class="form-control"  id="rbp_pat" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mg/dL</span>
															</div>
														</div>
													
													</div>
													<div class="col">
														<label for="nt_proBNP_pat" class="col-form-label">NT-proBNP</label>
														<div class="input-group">	
															<input type="number" name="nt_proBNP_pat" class="form-control"  id="nt_proBNP_pat" placeholder="" >
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">pg/mL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="troponina_cardiac_ultrasensib_pat" class="col-form-label">Troponina cardica ultrasensible</label>
														<div class="input-group">	
															<input type="number" name="troponina_cardiac_ultrasensib_pat" class="form-control"  id="troponina_cardiac_ultrasensib_pat" placeholder="" >
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">pg/mL</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="Pa02_Fi02_pat" class="col-form-label">PaO<sub>2</sub>/FiO<sub>2</sub></label> <!-- se calcula -->
															
															<input type="text" name="Pa02_Fi02_pat" class="form-control"  id="Pa02_Fi02_pat" placeholder="" onkeypress = "only_int_nums(event)">
													</div>
													
												</div>
												<div class="form-row">
													<div class="col">
														<label for="PaC02_pat" class="col-form-label">PaCO<sub>2</sub></label>
														<div class="input-group">	
															<input  type="number" name="PaC02_pat" class="form-control"  id="PaC02_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmHg</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="Pa02_pat" class="col-form-label">PaO<sub>2</sub></label> <!-- se calcula -->
														<div class="input-group">	
															<input  type="number" name="Pa02_pat" class="form-control"  id="Pa02_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmHg</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="Fi02_pat" class="col-form-label">FiO<sub>2</sub></label> <!-- se calcula -->
														<div class="input-group">
															<input type="text" name="Fi02_pat" class="form-control"  id="Fi02_pat"  onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="Na_pat" class="col-form-label">Sodio (Na+)</label>
														<div class="input-group">	
															<input  type="number" name="Na_pat" class="form-control"  id="Na_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmol/L</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="K_pat" class="col-form-label">Potasio (K)</label>
														<div class="input-group">	
															<input  type="number" name="K_pat" class="form-control"  id="K_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmol/L</span>
															</div>
														</div>
													</div>
													
													
													
														
														
												</div>
												<div class="form-row">
													<div class="col-2">
														<label for="Cl_pat" class="col-form-label">Cloro (Cl)</label>
														<div class="input-group">	
															<input type="text" name="Cl_pat" class="form-control"  id="Cl_pat" placeholder="" onkeypress = "only_int_nums(event)">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmol/L</span>
															</div>
														</div>
													</div>
													
													<div class="col-2">
														<label for="bicarbonato_pat" class="col-form-label">Bicarbonato</label>
														<div class="input-group">	
															<input type="number" name="bicarbonato_pat" class="form-control"  id="bicarbonato_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">mmol/L</span>
															</div>
														</div>
													</div>
													
														
												</div>
											
											
												
											</div>
										</fieldset>
										<br></br>
										<fieldset class="border p-2">
													   
											<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Citometría de flujo</legend>
											<div class="fields">
												<div class="form-row">
													<div class="col">
														<label for="linfocitos_cd3_abs_pat" class="col-form-label">Niveles Linfocitos CD3 absolutos</label>
															
															<input  type="number" name="linfocitos_cd3_abs_pat" class="form-control"  id="linfocitos_cd3_abs_pat" placeholder="" step = "0.1">
													</div>
													<div class="col">
														<label for="linfocitos_cd4_abs_pat" class="col-form-label">Niveles Linfocitos CD4 absolutos</label>
														
															<input type="number" name="linfocitos_cd4_abs_pat" class="form-control"  id="linfocitos_cd4_abs_pat" placeholder="" step = "0.1">
													</div>
													<div class="col">
														<label for="linfocitos_cd8_abs_pat" class="col-form-label">Niveles Linfocitos CD8 absolutos</label>
														
															<input type="number" name="linfocitos_cd8_abs_pat" class="form-control"  id="linfocitos_cd8_abs_pat" placeholder="" step = "0.1">
													</div>
													<div class="col">
														<label for="cd4_cd8_abs_pat" class="col-form-label">Linfocitos CD4+CD8+ absoluto </label>
														
															<input type="number" name="cd4_cd8_abs_pat" class="form-control"  id="cd4_cd8_abs_pat" placeholder="" step = "0.1">
													</div>
													
													
													
												</div>
												<div class="form-row">
													<div class="col">
														<label for="linfocitos_cd3_pat" class="col-form-label">Niveles Linfocitos CD3 </label>
														<div class="input-group">	
															<input  type="number" name="linfocitos_cd3_pat" class="form-control"  id="linfocitos_cd3_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="linfocitos_cd4_pat" class="col-form-label">Niveles Linfocitos CD4 </label>
														<div class="input-group">
															<input type="number" name="linfocitos_cd4_pat" class="form-control"  id="linfocitos_cd4_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="linfocitos_cd8_pat" class="col-form-label">Niveles Linfocitos CD8 </label>
														<div class="input-group">
															<input type="number" name="linfocitos_cd8_pat" class="form-control"  id="linfocitos_cd8_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="cd4_cd8_pat" class="col-form-label">Linfocitos CD4+CD8+  </label>
														<div class="input-group">
															<input type="number" name="cd4_cd8_pat" class="form-control"  id="cd4_cd8_pat" placeholder="" step = "0.1">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">%</span>
															</div>
														</div>
													</div>
													<div class="col">
														<label for="ratio_cd4_cd8_pat" class="col-form-label">Ratio CD4/CD8 </label>
														
															<input type="number" name="ratio_cd4_cd8_pat" class="form-control"  id="ratio_cd4_cd8_pat" placeholder="" step = "0.1">
													</div>
													
													
													
												</div>
												
												
											</div>
										</fieldset>
									<br></br>
												
												
									
									</form>
									</div>
								
								</div>
							</div>
							
							
						</div> <!-- end row-->
					
					</div> <!-- end container-->
				
				</div> <!-- end content-->
				<!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->
			
			</div> <!-- end content page-->
		
		</div> <!-- end wrapper-->
		
		<!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
		
		
		
		
		<script>
		$(document).ready(function() {
			  ajustar_botones();
			  
			  $('#day_monitor').on('change', function() {
				$(":input:not(#id_dia, #id_tipo_toma,#pat_id,#day_monitor,#date_monitor,#date_monitor_preuci,#date_ingreso,#date_ingreso_uci )").val("");
				$('#UCI_pat').prop('checked',false);
			  });
			 
			 
				
			 $("#ingreso_datos input").on("input change", function() {
				  var $campo = $(this);
				  
				  if ($campo.val() !== "") {
					$campo.removeClass("campo-naranja");
				  } 
			 }); 
			

			$('#status_dia').on("change",function(){
				
				if ($("#status_dia").prop('checked')){
					
					const myForm = $('#ingreso_datos');
					const campos = myForm.find('input[type="text"], input[type="number"]');
					let todasDistintasDeCero = true;
					var camposVacios = [];
					var etiquetasCampos=[];

					campos.each(function() {
					  if ($(this).val() === '') {
						todasDistintasDeCero = false;
						camposVacios.push($(this).attr('id'));
						$(this).addClass("campo-naranja");
						
						var label = $('label[for="' + $(this).attr('id') + '"]');
						etiquetasCampos.push(label.text());
						
					  }
					  
					  
					});
					
					if (todasDistintasDeCero != true){
						
					  alert('Establaceras el día como completo pero los siguientes campos están vacíos: ' + etiquetasCampos.join(', '));
					  
					}
					
					
				}
				
				
			});
			$('#btn_details').click(function(){
				
				$('#datos_paciente').toggle();
				
				
				
			});
			$('#PCR_pat').on("input",function(){
			
			if (parseFloat($('#PCR_pat').val())> 1.5){
				
				$('#pcr_pics_pat_check').prop('checked', true).trigger("change");
			} else {
				$('#pcr_pics_pat_check').prop('checked', false).trigger("change"); // Desmarcar el checkbox y desencadenar el evento "change"
			  }
		
			});
			$('#albumina_pat').on("input",function(){
				if (parseInt($('#albumina_pat').val())< 800){
				
					$('#albumnina_pics_pat_check').prop('checked', true).trigger("change");
				} else {
					$('#albumnina_pics_pat_check').prop('checked', false).trigger("change"); // Desmarcar el checkbox y desencadenar el evento "change"
				  }
			
			});
			$('#linfocitos_abs_pat').on("change",function(){
				if (parseInt($('#linfocitos_abs_pat').val())< 800){
					
					
					$('#linfo_pics_pat_check').prop('checked', true).trigger("change");
				
				}else {
					$('#linfo_pics_pat_check').prop('checked', false).trigger("change"); // Desmarcar el checkbox y desencadenar el evento "change"
				  }
			
			}); 
			 $('#rbp_pat').on("change",function(){
				if (parseInt($('#rbp_pat').val())<1){
					
					
					$('#rbp_pics_pat_check').prop('checked', true).trigger("change");
				
				}else {
					$('#rbp_pics_pat_check').prop('checked', false).trigger("change"); // Desmarcar el checkbox y desencadenar el evento "change"
				  }
			
			}); 
			$('#prealbumina_pat').on("input",function(){
				if (parseInt($('#prealbumina_pat').val())< 10){
					
					$('#prealbumina_pics_pat_check').prop('checked', true).trigger("change");
				} else {
					$('#prealbumina_pics_pat_check').prop('checked', false).trigger("change"); // Desmarcar el checkbox y desencadenar el evento "change"
				  }
			
			});
		
		// eec 
		
		var contador_ecc = $('#contador_ecc');
		var checkboxes_ecc = $('#VM_96h_pat_check, #traqueo_pat_check, #infecccion_nosoco_pat_check, #upp_pat_check, #fmo_pat_check, #perdida_masa_musc_pat_check, #malnutricion_pat_check, #det_cognitivo_pat_check');
		  
		  checkboxes_ecc.on("change", function() {
			var i = 0;
			checkboxes_ecc.each(function() {
			  if ($(this).prop('checked')) {
				i++;
			  } else{
				  
			  }
			  
			});
			contador_ecc.val(i);

			if (parseInt(contador_ecc.val()) >= 2) {
			  $('#status_ecc_pat_check').prop('checked', true).trigger("change");
			} else {
			  $('#status_ecc_pat_check').prop('checked', false).trigger("change");
			}
		  });
		  
		  var contador_pics = $('#contador_pics');
		  var checkboxes_pics = $('#pcr_pics_pat_check, #albumnina_pics_pat_check, #linfo_pics_pat_check, #rbp_pics_pat_check, #prealbumina_pics_pat_check,#status_ecc_pat_copied');
		  var status_pics = $('#status_pics_pat_check');
		  
		  checkboxes_pics.on("change", function() {
			var i = 0;
			checkboxes_pics.each(function() {
			  if ($(this).prop('checked')) {
				  
				  if ($(this).attr('id')== 'status_ecc_pat_copied'){
					  
					  i= i+99;
					  
				  }else{
					i++;
				  }
			  }
			});
			contador_pics.val(i);

			if (parseInt(contador_pics.val()) > 99) {
			  status_pics.prop('checked', true).trigger("change");
			} else {
			  status_pics.prop('checked', false).trigger("change");
			}
		  });
		  
		  $('.myDiagnosis input[type="checkbox"]').on('change', function() {
			$('.myDiagnosis input[type="checkbox"]').each(function() {
			  var checkbox = $(this);
			  var hiddenInput = checkbox.parent().find('input[type="hidden"]');
			  
			  if (checkbox.prop('checked')) {
				hiddenInput.val('1');
			  } else {
				hiddenInput.val('0');
			  }
			});
		  })

	});		
		
		</script>
		
		<script>
			function ajustar_botones() {
				
			  
			  var rol_paciente = <?php echo $select_rol_pat;?>;
			  var select_rol = (rol_paciente == 'Caso') ? 1 : 0;
			  
			  
			  if (select_rol === 0) { //control
				  
				// monitorización botones
				$('#btndia3, #btndia5, #btndia7, #btndia14').prop('disabled', true).css('background-color','#a59deb');
				
				$('#control_type').css('display', 'block');
				
				
			  } else if (select_rol === 1) { // caso
				// monitorización botones
				$('#btndia1, #btndia3, #btndia5, #btndia7, #btndia14').prop('disabled', false);
				
				$('#clinical_finding').css('display', 'block');
				$('#diagnostico').css('display', 'block');
			  }
			  
			  
			}
			
			
			
			
		</script>
		<script>
	
	
	</script>
		<script>
		function ajustar_otros(texto, color_boton,check_dia, btn_value,btn_tipo) {
			
			
			// Cambiar el título y color de la página según el botón seleccionado
			var jumbotron = document.getElementById("jumbotron_color");
			jumbotron.style.backgroundColor = color_boton;
			document.getElementById('jumbotron_dia').textContent = texto;
			
			$('#datos_ecc').css('display', 'none');
			$('#datos_pics').css('display', 'none');
			
			
			//var identificadoras
			document.getElementById("pat_id").value =  '<?php echo $pat_id; ?>';
			var id_dia = parseInt(btn_value);
			$("#id_dia").val(id_dia);
			var id_tipo_toma = btn_tipo;
			$("#id_tipo_toma").val(id_tipo_toma);
			
			// Mostrar u ocultar divs según el botón clicado
			const divElement = document.getElementById('custom_day_divs');
			const divElement_uci = document.getElementById('paciente_estancia_uci');
			
			divElement.style.display = 'none';
			
			if (btn_tipo=='estudio'){
				
				divElement_uci.style.display = 'block';
				
			}else if (btn_tipo=='preUCI'){
				
				divElement_uci.style.display = 'none';
			}
			
			// Agregar la clase de desenfoque al div objetivo
			var divObjetivo = document.getElementById('campos_variables');
			divObjetivo.classList.add('desenfoque');

			// Mostrar el loading
			var loading = document.createElement('div');
			loading.classList.add('loading');
			divObjetivo.appendChild(loading);

			// Simular un retraso antes de mostrar los valores
			setTimeout(function() {
				// Quitar la clase de desenfoque y ocultar el loading
				divObjetivo.classList.remove('desenfoque');
				divObjetivo.removeChild(loading);
				
				$("#ingreso_datos input").each(function() {
					var $campo = $(this);
					
					if ($campo.val() === "") {
					  $campo.removeClass("campo-naranja");
					} 
				 });
			
				var pat_id = '<?php echo $pat_id; ?>';
							
				var formData={id_dia, pat_id, id_tipo_toma};
				
				console.log(formData)
				
				
				 $.ajax({
						  url: 'assets/inc/enviarv2_id_dia_al_server.php', // 
						  type: 'POST',
						  data: formData, // 
						  success: function(responseData) {
							var res = JSON.parse(responseData);
							console.log(res)
							
							if (res.datos === null){
								
								
								
								$(":input:not(#id_dia, #pat_id, #id_tipo_toma,#date_monitor,#date_ingreso_uci,#day_monitor,#date_ingreso)").val("");
								
								
								
								
							}else{
								for (var columna in res.datos) {
								  if (res.datos.hasOwnProperty(columna)) {
									var valor = res.datos[columna];
									var campo = document.getElementById(columna + "_pat");
									if (columna === "UCI") {
										campo.checked = valor;
									} else {
										campo.value = valor;
									}
								  }
								}
								
								
								
							}
							
							if (res.ficha_dia === null){
								
								var isChecked = false;
								console.log(isChecked)
								console.log(res.ficha_dia)
								
								$("#status_dia").prop('checked', isChecked);
								console.log(check_dia)
								
								document.getElementById(check_dia).checked = isChecked;
								
							
							}else {
								
								var isChecked = res.ficha_dia.status_dia ? true : false;
								console.log(isChecked)
								console.log(res.ficha_dia.status_dia)
								
								$("#status_dia").prop('checked', isChecked);
								console.log(check_dia)
								
								document.getElementById(check_dia).checked = isChecked;
								
							}
							
							
							$("#ingreso_datos input").each(function() {
								var $campo = $(this);
								
								if ($campo.val() === "") {
								  $campo.addClass("campo-naranja");
								} 
							 });
							
						 },
						  error: function(xhr, status, error) {
							
							console.log(status)
							console.log(error)
						  }
						  
						  
					 }); 
			}, 1000);
			
			
		}
		
		
		
		</script>
		
		
		 <script>
		/* function ajustar_campos_preUCI(texto, check_dia, color_boton, btn_id) {
			//var placeholder
			document.getElementById("pat_id").value =  '<?php echo $pat_id; ?>';
			var id_dia = "";
						
			
			
			// Cambiar el título y color de la página según el botón seleccionado
			var jumbotron = document.getElementById("jumbotron_color");
			jumbotron.style.backgroundColor = color_boton;
			document.getElementById('jumbotron_dia').textContent = texto;

			// Mostrar u ocultar divs según el botón clicado
			const divElement = document.getElementById('custom_day_divs');
			const divElement_uci = document.getElementById('paciente_estancia_uci');
			
			divElement_uci.style.display = 'none';

			if (btn_id == 'btndiaOtro_preuci') {
				// Agregar la clase de desenfoque al div objetivo
				var divObjetivo = document.getElementById('campos_variables');
				divObjetivo.classList.add('desenfoque');

				// Mostrar el loading
				var loading = document.createElement('div');
				loading.classList.add('loading');
				divObjetivo.appendChild(loading);

				// Simular un retraso antes de mostrar los valores
				setTimeout(function() {
					divElement.style.display = 'block';
					$("#id_dia").val("");
					$("#day_monitor").val("");
					$(":input:not(#id_dia, #pat_id, #id_tipo_toma)").val("");
					$('#UCI_pat').prop('checked',false);
					
				}, 1000);	
			} else {
				divElement.style.display = 'none';
				switch (btn_id) {
					case "btndiaIngreso_hosp":
						$("#id_dia").val("1");
							
						id_dia = $("#id_dia").val();
						$('#dia_ingreso_hosp_estado').css('display', 'block');
						var id_tipo_toma = 'HOSP';
						$("#id_tipo_toma").val(id_tipo_toma);
							
						break;

					case "btndiaAnterior_uci":
						$("#id_dia").val("1");
						
						id_dia = $("#id_dia").val();
						$('#dia_anterior_uci_estado').css('display', 'block');
						var id_tipo_toma = 'preUCI';
						$("#id_tipo_toma").val(id_tipo_toma);
						
						break;

					
				}
				
				// Agregar la clase de desenfoque al div objetivo
			var divObjetivo = document.getElementById('campos_variables');
			divObjetivo.classList.add('desenfoque');

			// Mostrar el loading
			var loading = document.createElement('div');
			loading.classList.add('loading');
			divObjetivo.appendChild(loading);

			// Simular un retraso antes de mostrar los valores
			setTimeout(function() {
				// Quitar la clase de desenfoque y ocultar el loading
				divObjetivo.classList.remove('desenfoque');
				divObjetivo.removeChild(loading);
				
				$("#ingreso_datos input").each(function() {
					var $campo = $(this);
					
					if ($campo.val() === "") {
					  $campo.removeClass("campo-naranja");
					} 
				 });
				 
				var pat_id = '<?php echo $pat_id; ?>';
							
				var formData={id_dia, pat_id, id_tipo_toma};
				
				console.log(formData)
				
				
				 $.ajax({
						  url: 'assets/inc/enviarv2_id_dia_al_server.php', // 
						  type: 'POST',
						  data: formData, // 
						  success: function(responseData) {
							var res = JSON.parse(responseData);
							console.log(res)
							
							if (res.datos === null){
								
							$(":input:not(#id_dia, #pat_id, #id_tipo_toma,#date_monitor,#date_ingreso,#day_monitor)").val("");
							$('#UCI_pat').prop('checked',false);
								
							}else{
								for (var columna in res.datos) {
								  if (res.datos.hasOwnProperty(columna)) {
									var valor = res.datos[columna];
									var campo = document.getElementById(columna + "_pat");
									if (campo) {
									  campo.value = valor;
									}
								  }
								}
								
								
								
							}
							
							
							if (res.ficha_dia === null){
								
								var isChecked = false;
								console.log(isChecked)
								console.log(res.ficha_dia)
								
								$("#status_dia").prop('checked', isChecked);
								
								document.getElementById(check_dia).checked = isChecked;
							
							}else {
								
								var isChecked = res.ficha_dia.status_dia ? true : false;
								console.log(isChecked)
								console.log(res.ficha_dia.status_dia)
								
								$("#status_dia").prop('checked', isChecked);
								
								document.getElementById(check_dia).checked = isChecked;
							}
							
							$("#ingreso_datos input").each(function() {
								var $campo = $(this);
								
								if ($campo.val() === "") {
								  $campo.addClass("campo-naranja");
								} 
							 });
							
							
							
							
							
						 },
						  error: function(xhr, status, error) {
							
							console.log(status)
							console.log(error)
						  }
						  
						  
					 }); 
					 
				}, 1000); 
				
				
					
			}
			
			
		} */
		
		
		</script> 
		
		
		<script>
		function ajustar_campos(texto, check_dia, color_boton, btn_id, btn_tipo) {
			//var placeholder
			document.getElementById("pat_id").value =  '<?php echo $pat_id; ?>';
						
			// Cambiar el título y color de la página según el botón seleccionado
			var jumbotron = document.getElementById("jumbotron_color");
			jumbotron.style.backgroundColor = color_boton;
			document.getElementById('jumbotron_dia').textContent = texto;
			
			
			// Mostrar u ocultar divs según el botón clicado
			const divElement = document.getElementById('custom_day_divs');
			const divElement_uci = document.getElementById('paciente_estancia_uci');
			const divElement_fecha_hosp = document.getElementById('campo_fecha_ingreso');
			
			$('#datos_ecc').css('display', 'none');
			$('#datos_pics').css('display', 'none');
			
			
			var id_dia = "";
			
			if (btn_id == 'btndiaOtro' || btn_id == 'btndiaOtro_preuci') {
				
				// Agregar la clase de desenfoque al div objetivo
				var divObjetivo = document.getElementById('campos_variables');
				divObjetivo.classList.add('desenfoque');

				// Mostrar el loading
				var loading = document.createElement('div');
				loading.classList.add('loading');
				divObjetivo.appendChild(loading);

				// Simular un retraso antes de mostrar los valores
				setTimeout(function() {
					$("#ingreso_datos input").each(function() {
						var $campo = $(this);
						
						if ($campo.val() === "") {
						  $campo.removeClass("campo-naranja");
						} 
					 });
					
					// Quitar la clase de desenfoque y ocultar el loading
					divObjetivo.classList.remove('desenfoque');
					divObjetivo.removeChild(loading);
					
					$("#id_dia").val("");
					$("#day_monitor").val("");
					$('#UCI_pat').prop('checked',false);					
					$(":input:not(#id_dia, #pat_id, #id_tipo_toma,#date_ingreso_uci,#date_ingreso,#day_monitor)").val("");
					$('#status_dia').prop('checked',false);
					var fecha_uci_ingreso ="<?php echo $date_ingreso_uci?>";
					$('#date_ingreso_uci').val(fecha_uci_ingreso);
					
					var fecha_ingreso ="<?php echo $date_ingreso?>";
					$('#date_ingreso').val(fecha_ingreso);
					
					var selectElement = document.getElementById('day_monitor');
					
					if (btn_tipo == 'estudio'){
						
						var id_tipo_toma = btn_tipo;
						$("#id_tipo_toma").val(id_tipo_toma);
						
						divElement.style.display = 'block';
						divElement_fecha_hosp.style.display = 'none';
						divElement_uci.style.display = 'block';
						$('#info_preuci_1').css('display', 'none');
						$('#info_preuci_2').css('display', 'none');
						
							
						
						
						  selectElement.innerHTML = '';

						  // Agregar las opciones correspondientes al select
						  
							for (var i = 1; i <= 30; i++) {
							  var option = document.createElement('option');
							  if (i==1){
								  option.value = i;
								  option.text = 'Ingreso UCI';
								  selectElement.appendChild(option);
								  
							  }else{
								  option.value = i;
								  option.text = i;
								  selectElement.appendChild(option);
								  
							  }
							  
							}
						  
							var valoresDeshabilitados_default = [1, 3, 5, 7, 14];
							var valoresDeshabilitados_otros = <?php echo $array_btns_otros?>;
							var deshabilitar = valoresDeshabilitados_default.concat(valoresDeshabilitados_otros);
							
							$("#day_monitor option").each(function() {
							  var valor = parseInt($(this).val());
							  if (deshabilitar.includes(valor)) {
								$(this).prop('disabled', true);
							  } else {
								$(this).prop('disabled', false);
							  }
							});
						
					}else if (btn_tipo == 'preUCI'){
						
						var id_tipo_toma = btn_tipo;
						$("#id_tipo_toma").val(id_tipo_toma);
					
						divElement.style.display = 'block';
						divElement_fecha_hosp.style.display = 'block';
						divElement_uci.style.display = 'none';
						$('#info_preuci_1').css('display', 'block');
						$('#info_preuci_2').css('display', 'block');
						
						 selectElement.innerHTML = '';
						<?php foreach ($opciones_dates as $clave => $texto) : ?>
							  var option = document.createElement('option');
							  option.value = '<?php echo $clave; ?>';
							  option.text = '<?php echo $texto; ?>';
							  selectElement.appendChild(option);
							<?php endforeach; ?>
						
						var valoresDeshabilitados_default = [0,1,<?php echo $diferenciaDias;?>];
						
						var valoresDeshabilitados_otros_preuci = <?php echo $array_btns_otros_preuci;?>;
						var deshabilitar = valoresDeshabilitados_default.concat(valoresDeshabilitados_otros_preuci);
						
						$("#day_monitor option").each(function() {
						  var valor = parseInt($(this).val());
						  if (deshabilitar.includes(valor)) {
							$(this).prop('disabled', true);
						  } else {
							$(this).prop('disabled', false);
						  }
						});
						
					}
					
					
				}, 1000);
				
			
			} else {
				
				divElement.style.display = 'none';
				if (btn_tipo == 'estudio'){
					var id_tipo_toma = btn_tipo;
					$("#id_tipo_toma").val(id_tipo_toma);
					
					divElement_uci.style.display = 'block';
					
					
					switch (btn_id) {
						case "btndiaIngreso":
							$("#id_dia").val("0");
								
								var id_dia = $("#id_dia").val();
							$('#dia_ingreso_estado').css('display', 'block');
							
								
							break; 

						case "btndia1":
							$("#id_dia").val("1");
							
								var id_dia = $("#id_dia").val();
							$('#dia1_estado').css('display', 'block');
							
							break;

						case "btndia3":
							$("#id_dia").val("3");
							
								var id_dia = $("#id_dia").val();
							$('#dia3_estado').css('display', 'block');	
								
							break;

						case "btndia5":
							$("#id_dia").val("5");
							
								var id_dia = $("#id_dia").val();
							$('#dia5_estado').css('display', 'block');	
								
							break;

						case "btndia7":
							$("#id_dia").val("7");
							
								var id_dia = $("#id_dia").val();
							$('#dia7_estado').css('display', 'block');
							$('#datos_ecc').css('display', 'block');
								
							break;

						case "btndia14":
							$("#id_dia").val("14");
							
								var id_dia = $("#id_dia").val();
								
							$('#dia14_estado').css('display', 'block');
							$('#datos_pics').css('display', 'block');
							break;
						
					}
				
				}else if (btn_tipo == 'preUCI'){
					var id_tipo_toma = btn_tipo;
					$("#id_tipo_toma").val(id_tipo_toma);
					$('#paciente_estancia_uci').css('display', 'none');
					
					
					switch (btn_id) {
						
						case "btndiaAnterior_uci":
							$("#id_dia").val("1");
							
							id_dia = $("#id_dia").val();
							$('#dia_anterior_uci_estado').css('display', 'block');
							var id_tipo_toma = 'preUCI';
							$("#id_tipo_toma").val(id_tipo_toma);
							$('#UCI_pat').prop('checked',false);
							
							break;

						
					}
					
				}else if (btn_tipo == 'HOSP'){
					var id_tipo_toma = btn_tipo;
					$("#id_tipo_toma").val(id_tipo_toma);
					$('#paciente_estancia_uci').css('display', 'none');
					
					switch (btn_id) {
						case "btndiaIngreso_hosp":
							$("#id_dia").val("1");
								
							id_dia = $("#id_dia").val();
							$('#dia_ingreso_hosp_estado').css('display', 'block');
							var id_tipo_toma = 'HOSP';
							$("#id_tipo_toma").val(id_tipo_toma);
							$('#UCI_pat').prop('checked',false);
								
							break;
					}
					
				}
				
				
				// Agregar la clase de desenfoque al div objetivo
			var divObjetivo = document.getElementById('campos_variables');
			divObjetivo.classList.add('desenfoque');

			// Mostrar el loading
			var loading = document.createElement('div');
			loading.classList.add('loading');
			divObjetivo.appendChild(loading);

			// Simular un retraso antes de mostrar los valores
			setTimeout(function() {
				// Quitar la clase de desenfoque y ocultar el loading
				divObjetivo.classList.remove('desenfoque');
				divObjetivo.removeChild(loading);
				
				
				$("#ingreso_datos input").each(function() {
					var $campo = $(this);
					
					if ($campo.val() === "") {
					  $campo.removeClass("campo-naranja");
					} 
				 });
				
				var pat_id = '<?php echo $pat_id; ?>';
							
				var formData={id_dia, pat_id, id_tipo_toma };
				
				console.log(formData)
				
				
				 $.ajax({
						  url: 'assets/inc/enviarv2_id_dia_al_server.php', // 
						  type: 'POST',
						  data: formData, // 
						  success: function(responseData) {
							var res = JSON.parse(responseData);
							console.log(res)
							
							if (res.datos === null){
								
								
								
								$(":input:not(#id_dia, #pat_id, #id_tipo_toma,#date_monitor,#date_ingreso,#date_ingreso_uci,#day_monitor)").val("");
								$('#UCI_pat').prop('checked',false);
								
								setTimeout(function () {
									Swal.fire("Atención", "No se han encontrado datos previos de este día", "warning");
								}, 100);
								
							}else{
								
								for (var columna in res.datos) {
								  if (res.datos.hasOwnProperty(columna)) {
									var valor = res.datos[columna];
									var campo = document.getElementById(columna + "_pat");
									var campo_copied = document.getElementById(columna + "_pat_copied");
									
									if (columna === "UCI") {
										
										campo.checked = valor;
										
									} else if (columna === 'PCR' || columna === 'albumina' || columna === 'linfocitos_abs' || columna === 'rbp' || columna === 'prealbumina'){
										
										campo_copied.value = valor;
										campo.value = valor;
										
									} else {
										
										campo.value = valor;
									}
								  }
								}
								
								for (var columna in res.datos_caso) {
								  if (res.datos_caso.hasOwnProperty(columna)) {
									var valor = res.datos_caso[columna];
									
									var campo = document.getElementById(columna + "_pat_check");
									var campo_copied = document.getElementById(columna + "_pat_copied");
									
									if (columna === "status_ecc") {
										
										campo.checked = valor;
										campo_copied.checked = valor;
										
									} else {
										
										campo.checked = valor;
									}
								  }
								}
								
								
								
							}
							
							if (res.ficha_dia === null){
								
								var isChecked = false;
								console.log(isChecked)
								console.log(res.ficha_dia)
								
								$("#status_dia").prop('checked', isChecked);
								
								document.getElementById(check_dia).checked = isChecked;
							
							}else {
								
								var isChecked = res.ficha_dia.status_dia ? true : false;
								console.log(isChecked)
								console.log(res.ficha_dia.status_dia)
								
								$("#status_dia").prop('checked', isChecked);
								
								document.getElementById(check_dia).checked = isChecked;
							}
							
							
							$("#ingreso_datos input").each(function() {
								var $campo = $(this);
								
								if ($campo.val() === "") {
								  $campo.addClass("campo-naranja");
								} 
							 });
							
						 },
						  error: function(xhr, status, error) {
							
							console.log(status)
							console.log(error)
						  }
						  
						  
					 }); 
					 
				}, 1000); 
				
				
					
			}
			
			
		}
		
		
		</script>
		
		
		
		
		<script type="text/javascript">
  
	  function addDays(date, days) {
		var result = new Date(date);
		result.setDate(result.getDate() + days);
		return result;
		}
	  
	  
	  function substractDays(date, days) {
	  var result = new Date(date);
	  result.setDate(result.getDate() - days);
	  return result;
	  }
	  
	  
	  
	  
	  
	  
	  function getDateMonitor(dias, tipo_toma) {
		
		var fecha_inicio = document.getElementById('date_ingreso_uci').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = dias;
		dia_monitor = new Number(dia_monitor);
		
		if (tipo_toma== 'estudio'){
			
			var fecha_monitor =    addDays(fecha_inicio,dia_monitor);	
			
		}else if(tipo_toma== 'preUCI'){
			
			var fecha_monitor =    substractDays(fecha_inicio,dia_monitor);	
		}
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
		document.getElementById('date_monitor').value = fecha_monitor;
		
		
		} 

  
	</script>
	<script>
		function ajuste_id_dia (){
			var valor_dia = $("#day_monitor").val();
			var tipo_toma = $("#id_tipo_toma").val();
			
			var id_dia = $("#id_dia").val(valor_dia);
			
				
			$('#diaOtro_estado').css('display', 'block');
			
			getDateMonitor(valor_dia,tipo_toma);
		
		}
		</script>
		
		<script>
	
	function save(){
		
		var id_dia= $("#id_dia").val();
							  
		if (id_dia === "" ){

			setTimeout(function () {
							Swal.fire("Atención", "Para poder guardar los datos, es necesario establecer un día de toma de datos", "warning");
						}, 100);
			
			return false;
		}
		
		const ECC_form = $('#diagnostico_ecc');
		const PICS_form = $('#diagnostico_pics');
		const myForm = $('#ingreso_datos');
		const checkbox = $('#status_dia');
		const campos = myForm.find('input[type="text"], input[type="number"]');
			let todasDistintasDeCero = true;
			var camposVacios = [];
			var etiquetasCampos=[];

			campos.each(function() {
			  if ($(this).val() === '') {
				todasDistintasDeCero = false;
				camposVacios.push($(this).attr('id'));
				$(this).addClass("campo-naranja");
				
				var label = $('label[for="' + $(this).attr('id') + '"]');
				etiquetasCampos.push(label.text());
				
			  }
			  
			  
			});
			
			
			
			if (todasDistintasDeCero == true){
				checkbox.prop('checked', todasDistintasDeCero);
				alert('Todas las variables se han completado, se establecerá el día como completado');
			} else {
				
			  alert('Los siguientes campos están vacíos: ' + etiquetasCampos.join(', '));
			  
			}

			
			console.log(todasDistintasDeCero)
		
		
		setTimeout(function () 
		{ 
			Swal.fire({
						  title: '¿Quieres guardar los cambios?',
						  icon: "warning",
						  showDenyButton: true,
						  showCancelButton: false,
						  confirmButtonText: 'Guardar',
						  denyButtonText: 'No guardar',
						}).then((result) => {
							
							
						  
						  if (result.isConfirmed) {
							 var id_dia= $("#id_dia").val();
							 
							  
							  if (id_dia === "" ){
				
									setTimeout(function () {
													Swal.fire("Atención", "Para poder guardar los datos, es necesario establecer un día de toma de datos", "warning");
												}, 100);
									
									return false;
								}
								
							
							
							 var formData = myForm.serialize();
							 
							 isChecked_dia = $('#status_dia').prop('checked');
							 var status_dia = isChecked_dia ? 1 : 0;
							 
							 formData += '&status_dia=' + status_dia;
							 
							 isChecked = $('#UCI_pat').prop('checked');
							 var UCI_pat = isChecked ? 1 : 0;
							 
							 formData += '&UCI_pat=' + UCI_pat;
							 
								
							 var formData_ecc = ECC_form.serialize(); 
							 var formData_pics = PICS_form.serialize();
							  
							 console.log(formData)
							 console.log(formData_ecc)
							 console.log(formData_pics)
							 
							
							 
							 $.ajax({
									  url: 'assets/inc/guardarv2_datos_dias.php', // URL de tu script PHP que guarda los datos
									  type: 'POST',
									  data: {formData:formData,formData_ecc:formData_ecc, formData_pics:formData_pics}, // 
									  success: function(response) {
										  var res = JSON.parse(response);
										  console.log(res)
										  
											//let btnDia = document.querySelector("#guardar_dia");
											if ('<?php echo $id_tipo_toma ?>'== 'estudio'){
												
												var check_ficha = document.querySelector("#status_dia");
												localStorage.setItem('check_dia'+ id_dia, check_ficha.checked);
												
											}
											
											
											
											if (res.success == true){
												setTimeout(function () 
														{ 
															Swal.fire('¡Día '+ id_dia +' guardado!', 'Puedes continuar realizando cambios si los deseas', 'success');
															},
														100);
											} else if (res.success == false){
							
												setTimeout(function () 
													{ 
														Swal.fire("ERROR","Error al guardar, vuelva a intentarlo de nuevo","error");
													},
														100);
											}
										
										
									 },
									  error: function(xhr, status, error) {
										// Aquí puedes manejar el error en caso de que ocurra un problema al guardar los datos
										Swal.fire('Error', 'Ocurrió un error al guardar los datos.', 'error');
										console.log(status)
										console.log(error)
									  }
									  
									  
								 });
						  
						  } else if (result.isDenied) {
							Swal.fire('Cambios no guardados', 'No olvides guardar antes de cerrar', 'info')
						  }
						});
		
		
		
		},
			100);
	}
	

</script>

<script>
	
function save_estado_ficha(){
		
	setTimeout(function () 
		{ 
			Swal.fire({
						  title: '¿Quieres actualizar el estado de la ficha del paciente?',
						  icon: "warning",
						  showDenyButton: true,
						  showCancelButton: false,
						  confirmButtonText: 'Guardar',
						  denyButtonText: 'No guardar',
						}).then((result) => {
						  
						  if (result.isConfirmed) {
							  
							 isChecked = $('#ficha_paciente').prop('checked');
							 var ficha_paciente = isChecked ? 1 : 0; 
							
							 var pat_id = '<?php echo $pat_id; ?>';
							
							 var formData={ficha_paciente, pat_id };
							
							console.log(ficha_paciente)
							console.log(pat_id)
				
							 
							 							  
							 $.ajax({
									  url: 'assets/inc/guardar_ficha_paciente.php', // URL al script PHP que guarda los datos
									  type: 'POST',
									  data: formData, // 
									  success: function(response) {
										
										//var res = JSON.parse(response);  
										console.log(response)	
											
											
										Swal.fire('¡Estado de ficha modificado!', '', 'success')
										
										
									 },
									  error: function(xhr, status, error) {
										// Aquí puedes manejar el error en caso de que ocurra un problema al guardar los datos
										Swal.fire('Error', 'Ocurrió un error al guardar los datos.', 'error');
										console.log(status)
										console.log(error)
									  }
									  
									  
								 });
							
						  } else if (result.isDenied) {
							Swal.fire('Cambios no guardados', 'No olvides guardar antes de cerrar', 'info')
						  }
						});
		
		
		
		},
			100);
			
	}
	

</script>

<script>
  
  function getSOFAres(){
	  
		
		var pafi02 = new Number(document.querySelector('#PaFi_pat').value);
		
		var v_mecanica = new Number (document.querySelector('input[name="gridVM"]:checked').value);
		
		
		
		if(pafi02 > 400 || pafi02 == 0){
			
			var res_sofa_valor = 0;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
			
		}else if ( pafi02 <= 400 && pafi02 > 300 && v_mecanica == 0 ){
			
			var res_sofa_valor = 1;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
		} else if( pafi02 <= 300 && pafi02 > 200 && v_mecanica == 0){
			
			var res_sofa_valor = 2;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
		} else if( pafi02 <= 200 && pafi02 > 100 && v_mecanica == 1) {
			
			var res_sofa_valor = 3;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
		} else if( pafi02 <= 100 && v_mecanica == 1){
			var res_sofa_valor = 4;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
		} else{
			var res_sofa_valor = 0;
			document.querySelector('#SOFAres').value = res_sofa_valor;
		}
		
	  
	  
  }
  
  function getSOFAcoag(){
		
		var plaq = new Number(document.querySelector('#plaq_pat').value);
		
	  
		if(plaq > 150 || plaq == 0 ){
			
			var coag_sofa_valor = 0;
			document.querySelector('#SOFAcoagu').value = coag_sofa_valor;
			
			
		}else if (plaq <= 150 && plaq > 100){
			
			var coag_sofa_valor = 1;
			document.querySelector('#SOFAcoagu').value = coag_sofa_valor;
			
		} else if (plaq <= 100 && plaq > 50){
			
			var coag_sofa_valor = 2;
			document.querySelector('#SOFAcoagu').value = coag_sofa_valor;
			
		} else if (plaq <= 50 && plaq > 20) {
			
			var coag_sofa_valor = 3;
			document.querySelector('#SOFAcoagu').value = coag_sofa_valor;
			
		} else if (plaq <= 20){
			
			var coag_sofa_valor = 4;
			document.querySelector('#SOFAcoagu').value = coag_sofa_valor;
			
		} 
	  
  }
  
  
  function getSOFArenal(){
		
		var creati = new Number(document.querySelector('#cr_pat').value);
		var diu_pat = new Number(document.querySelector('#diuresis').value);
		
	  
		if(creati < 1.2 || creati == 0 ){
			
			var renal_sofa_valor = 0;
			document.querySelector('#SOFArenal').value = renal_sofa_valor;
			
			
		}else if (creati <= 2 && creati > 1.2){
			
			var renal_sofa_valor = 1;
			document.querySelector('#SOFArenal').value = renal_sofa_valor;
			
		} else if (creati <= 3.4 && creati > 2){
			
			var renal_sofa_valor = 2;
			document.querySelector('#SOFArenal').value = renal_sofa_valor;
			
		} else if (creati <= 4.9 && creati > 3.5 && diu_pat==1) {
			
			var renal_sofa_valor = 3;
			document.querySelector('#SOFArenal').value = renal_sofa_valor;
			
		} else if (creati >= 5 && diu_pat==2){
			
			var renal_sofa_valor = 4;
			document.querySelector('#SOFArenal').value = renal_sofa_valor;
			
		} 
	  
  }
  
   function getSOFAhepa(){
		
		var bilirrub = new Number(document.querySelector('#bilirr_pat').value);
		
	  
		if(bilirrub < 1.2 || bilirrub == 0 ){
			
			var hepa_sofa_valor = 0;
			document.querySelector('#SOFAhepa').value = hepa_sofa_valor;
			
			
		}else if (bilirrub <= 1.9 && bilirrub > 1.2){
			
			var hepa_sofa_valor = 1;
			document.querySelector('#SOFAhepa').value = hepa_sofa_valor;
			
		} else if (bilirrub <= 5.9 && bilirrub > 2){
			
			var hepa_sofa_valor = 2;
			document.querySelector('#SOFAhepa').value = hepa_sofa_valor;
			
		} else if (bilirrub <= 11.9 && bilirrub > 6) {
			
			var hepa_sofa_valor = 3;
			document.querySelector('#SOFAhepa').value = hepa_sofa_valor;
			
		} else if (bilirrub >= 12){
			
			var hepa_sofa_valor = 4;
			document.querySelector('#SOFAhepa').value = hepa_sofa_valor;
			
		} 
	  
  }
   
	function getGlasgow(){
		
		var valor_motora = new Number(document.querySelector('#res_motora').value);
		var valor_visual = new Number(document.querySelector('#res_visual').value);
		var valor_ap_ocular = new Number(document.querySelector('#ap_ocular').value);
		
		
		var valor_glasgow = valor_motora + valor_visual + valor_ap_ocular;
		
		document.querySelector('#res_glasgow').value = valor_glasgow;
		document.querySelector('#glasgow_pat').value = valor_glasgow;
		
		document.querySelector('#SOFAsnc').value = valor_glasgow;
	}
  
	function getSOFAhemo(){
		
		var valor_pam = new Number(document.querySelector('#p_media').value);
		
		var check_drugs = document.querySelector('#check_toggl');
		
		var dopa_value = new Number(document.querySelector('#dopa_pat').value);
		var nora_value = new Number(document.querySelector('#nora_pat').value);
		var adrena_value = new Number(document.querySelector('#adrena_pat').value);
		var dobu_value = new Number(document.querySelector('#dobu_pat').value);
		
		var hemo_sofa_valor = new Number();
		
			if(valor_pam >= 70 && check_drugs.checked == false ){
				
				hemo_sofa_valor = 0;
						
				
			}else if (valor_pam < 70 && valor_pam > 0  && check_drugs.checked == false ){
				
				var hemo_sofa_valor = 1;
				
				
			} else if ((dopa_value <5 && dopa_value >0)|| dobu_value != 0){
				
				var hemo_sofa_valor = 2;
				
				
			} else if ((dopa_value > 5 && dopa_value <= 15 && dopa_value > 0 ) || ((nora_value <= 0.1 && nora_value > 0)|| (adrena_value <= 0.1 && adrena_value > 0))) {
				
				var hemo_sofa_valor = 3;
				
				
			} else if (dopa_value > 15 || (nora_value > 0.1 || adrena_value > 0.1)){
				
				var hemo_sofa_valor = 4;
				
				
			} else if( valor_pam == '' && check_drugs.checked == false){
				hemo_sofa_valor= '';
			}
			
		document.querySelector('#SOFAhemo').value = hemo_sofa_valor;
		
		
	}
	
  
  
  function validateSOFA(){
	  
	  const closeWithJS = document.getElementById('btnCalcularModal');
	  
	  var sofa_res = (document.querySelector('#SOFAres').value);
	  var sofa_hemo = (document.querySelector('#SOFAhemo').value);
	  var sofa_renal = (document.querySelector('#SOFArenal').value);
	  var sofa_coagu = (document.querySelector('#SOFAcoagu').value);
	  var sofa_snc = (document.querySelector('#SOFAsnc').value);
	  var sofa_hepa = (document.querySelector('#SOFAhepa').value);
	  
	  
	  if ((sofa_res != '') && (sofa_hemo != '' )&& (sofa_renal != '') && (sofa_coagu != '')&& (sofa_snc != '')&& (sofa_hepa != '')){
	  
		 sofa_valor_total= Number(sofa_res)+Number(sofa_hemo)+Number(sofa_renal)+Number(sofa_coagu)+Number(sofa_snc)+Number(sofa_hepa);
		 
		 document.querySelector('#SOFAtot').value = sofa_valor_total;
		 
		 //$success = "Patient Details Added";
		
	  
	  } else {
		  alert("Faltan campos por completar");
		  //$err = "Please Try Again Or Try Later";
	  }
	  
  }
  
  
  </script>
  <script>
	  function only_int_nums(evt){
		  
		 <!-- var ch = this.which || this.keycode;
		  <!-- if((ch >=48 && ch <= 57)){       <!-- si se quisieran incluir números negativos enteros -> If ((x >= 48 && x <=57 )  || x==189)) -->
		  <!--  return true;else return false; }
		  
		 
		  var ch = String.fromCharCode(evt.which);
		  if(!(/[0-9]/.test(ch))) {
			  
			  evt.preventDefault();
		  
			}
		  
	  
	  }
  
  </script>
  
    <script type="text/javascript">
	
	function duplicate(x_original){

		var copia = x_original + '_copied';
		var x_original = document.getElementById(x_original);
		document.getElementById(copia).value = x_original.value;
		
		
	}
	
</script>
	
	
	</body>
</html>