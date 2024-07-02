<?php
	session_start();
	include('assets/inc/config.php');
		$habilitarElementoNav = true; // Variable de control para habilitar o deshabilitar el elemento en nav.php
		$habilitarElementoSidebar = true; // Variable de control para habilitar o deshabilitar el elemento en sidebar.php
		
		
		$pat_id=$_GET['pat_id'];
		$id_dia= $_GET['id_dia']!== ""? intval($_GET['id_dia']): null;	
		$id_tipo_toma=$_GET['id_tipo_toma'];
		$response = array('success' => false);
		
		 //CONSULTA PARA VISUALIZAR DATOS PREVIAMENTE GUARDADOS
		
		$query_id_vars = "SELECT *,pat_id,id_dia,id_tipo_toma FROM vars WHERE pat_id = ?  AND id_dia = ? AND id_tipo_toma= ? ";
		$stmt= $mysqli->prepare($query_id_vars);
		$stmt->bind_param('sis', $pat_id, $id_dia,$id_tipo_toma);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id_vars = $stmt->num_rows;
		
		$datos=array();
		$ficha_dia="";
		
		if ($check_pat_id_vars > 0) {
			
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
			
			
		
		}
		
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
		
	$ficha_dia = json_encode($ficha_dia);
		
		
?>

<!DOCTYPE html>

<html lang="es">

 <!--Head-->
    <?php include('assets/inc/head.php');?>
	<style>
	
	#day_monitor option:disabled {
	  color: #999999; /* Cambia el color de la opción deshabilitada */
	}
	
	</style>
	
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	
	
<body onload="load()">

<!-- modals -->
<!-- modal SOFA --->
		<!-- modal --->
														
	<div class="modal fade" id="modalSOFA" role="dialog" tabindex="-1" aria-labelledby="tituloModal" data-backdrop="static" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document" >	
			<div class="modal-content">
				
				<div class= "modal-header">
					<h5 class= "modal-title" id="tituloModal"> Cálculo del SOFA</h5>
					<button class="close" data-dismiss="modal" aria-label="Cerrar">
							<span aria-hidden= "true">&times;</span></button>
				
				</div>
				<div class= "modal-body">
					<div class="container-fluid">
					
						<fieldset class="border p-2">
							 <legend class="float-none w-auto" style ="font-size:20px;">Respiratorio</legend>
							 <input type="text" class="text-success font-weight-bold" name="SOFAres" id = "SOFAres" size="3" style="text-align:center;" readonly>
							<p></p>
								<div class= "row justify-content-md-center" > 
									
									<div class="col-4">
										<label for="PaFi_pat" class="col-form-label">Pa0<sub>2</sub>/Fi0<sub>2</sub></label>
										<input type="number" name="PaFi_pat" class="form-control"  id="PaFi_pat" placeholder="mmHg" onblur="getSOFAres()">
										<!--<button type="button" class="btn btn-primary btn-sm" id="btnPaFI" onclick="getPaFi()" >Calcular</button> -->
									
									</div>
									
									<!--<div class="w-100"></div> -->
									<div class="col-4">
										<legend class="col-form-label">Ventilación mecánica</legend>
										<div class="row-4">
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="gridVM" id="gridVM1" value = "1" oninput="getSOFAres()">
											  <label class="form-check-label" for="gridRadios1"> Si</label>
											</div>
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="gridVM" id="gridVM0" value = "0" checked oninput="getSOFAres()">
											  <label class="form-check-label" for="gridRadios2">No</label>
											</div>
										</div>
									</div>
								</div>
						</fieldset>
						<fieldset class="border p-2">
							 <legend class="float-none w-auto" style ="font-size:20px;">Hemodinámico</legend>
							 <input type="text" class="text-success font-weight-bold" name="SOFAhemo" id="SOFAhemo" size="3"  style="text-align:center;" readonly>
							<p></p>
								<div class= "row justify-content-md-center" > 
									<div class="col-4">
								
										<label for="p_sistolica" class="col-form-label">PAS</label>
										<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="mmHg" onkeypress = "only_int_nums(event)">
									</div>
									<div class="col-4">
										<label for="p_diastolica" class="col-form-label">PAD</label>
										<input type="text" name="p_diastolica" class="form-control"  id="p_diastolica" placeholder="mmHg" onkeypress = "only_int_nums(event)">
									</div> 
									<div class="col-4">
										<label for="p_media" class="col-form-label">PAM</label>
										<input type="number" name="p_media" class="form-control"  id="p_media" placeholder="mmHg" oninput= "getSOFAhemo()">
										<button type="button" class="btn btn-primary btn-sm" id="btnPAM" onclick="getPAM()" >Calcular</button>
									</div>
								</div>
								<p></p>
								<p></p>
								<p></p>
								
								<div class="row">
									
									
									<div class="col">
									
									
										<label for="check_toggl" >¿Se han usado drogas vasoactivas? :</label>
										<input type="checkbox" id="check_toggl" onclick="showDrugs()">
												<!--<label for="toggle_two" >¿Se han usado drogas vasoactivas? :</label>
												<span> Si</span>
												<label class="switch">
													<input type="checkbox" name="toggle_two">
													<span class="slider round"></span>
												</label>
												<span class="text-primary"> No</span>-->
											
												
												<!--<input type="checkbox" data-toggle="toggle" name="toggle_event" data-size="sm" data-on="Si" data-off="No" onclick="showDrugs()">
												
												<!--<label for = "toggle_event" class="col-form-label">¿Se han usado drogas vasoactivas? :</label>
																
													<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
														
														<label class="btn btn-outline-primary"  id= "btnSi" for="btnSi">
														<input type="radio" class="btn-check" name= "toggle_event" id= "btnSi" value= "0" autocomplete="off"  >Si</label>
														
														<label class="btn btn-outline-primary" id= "btnNo" for ="btnNo">
														<input type="radio" class="btn-check" name= "toggle_event" id= "btnNo" value= "1" autocomplete="off" checked >No</label>
														
														
													</div>-->
										
									</div>
								
								</div>
								
								<fieldset class="border p-2">
									<div class="row" style="display:none;" id="inputs_drugs_1">
										<div class="col">
											<label for="dopa_pat" class="col-form-label">Dopamina</label>
											<input type="number" name="dopa_pat" class="form-control"  id="dopa_pat" placeholder="µg/kg/min" step="0.1" oninput= "getSOFAhemo()">
											
										</div>
									
										<div class="col">
											<label for="dobu_pat" class="col-form-label">Dobutamina</label>
											<input type="number" name="dobu_pat" class="form-control"  id="dobu_pat" placeholder="µg/kg/min" step="0.1" oninput= "getSOFAhemo()">
											
										</div>
									</div>
									<div class="row" style="display:none;" id="inputs_drugs_2">
										<div class="col">
											<label for="nora_pat" class="col-form-label">Noradrenalina</label>
											<input type="number" name="nora_pat" class="form-control"  id="nora_pat" placeholder="µg/kg/min" step="0.1" oninput= "getSOFAhemo()">
											
										</div>
									
										<div class="col">
											<label for="adrena_pat" class="col-form-label">Adrenalina</label>
											<input type="number" name="adrena_pat" class="form-control"  id="adrena_pat" placeholder="µg/kg/min" step="0.1" oninput= "getSOFAhemo()">
											
										</div>
									</div>
									
								</fieldset>
									
								
						</fieldset>
						<fieldset class="border p-2">
							 <legend class="float-none w-auto" style ="font-size:20px;">Renal</legend>
							 <input type="text" class="text-success font-weight-bold" name="SOFArenal" size="3" id="SOFArenal"  style="text-align:center;" readonly>
							<p></p>
								<div class= "row justify-content-md-center" > 
									<div class="col-6">
								
										<label for="cr_pat" class="col-form-label">Creatinina</label>
										<div class="input-group">	
											<input type="number" name="cr_pat" class="form-control"  id="cr_pat" placeholder="" step= "0.1" oninput="getSOFArenal()">
											<div class="input-group-append">
												<span class="input-group-text" id="basic-addon2">mg/dL</span>
											</div>
										</div>
										
									</div>
									<div class="col-4">
										<label for="diuresis" class="col-form-label">Diuresis</label>
										<select name="diuresis" id="diuresis" form="diuresis" >
											<!--<option value="">Más de 500 mL/día </option> -->
											<option value="1">200 - 500 mL /día</option>
											<option value="2">Menos de 200 mL/día</option>
										</select>
									</div>
									
								</div>
						</fieldset>
						<fieldset class="border p-2">
							 <legend class="float-none w-auto" style ="font-size:20px;">Coagulación</legend>
							 <input type="text" class="text-success font-weight-bold" name="SOFAcoagu" id= "SOFAcoagu" size="3"  style="text-align:center;" readonly>
							<p></p>
								<div class= "row justify-content-md-center" > 
									<div class="col-6">
								
										<label for="plaq_pat" class="col-form-label">Plaquetas</label>
										<div class="input-group">	
											<input type="number" name="plaq_pat" class="form-control" id="plaq_pat" maxlength="3" onkeypress = "only_int_nums(event)" oninput="getSOFAcoag()">
											<div class="input-group-append">
												<span class="input-group-text" id="basic-addon2">10<sup>3</sup>/mm3</span>
											</div>
										</div>
										
									</div>
									
								</div>
						</fieldset>
						<fieldset class="border p-2">
							 <legend class="float-none w-auto" style ="font-size:20px;">SNC</legend>
							 <input type="text" class="text-success font-weight-bold"  name="SOFAsnc" id="SOFAsnc" size="3"  style="text-align:center;" readonly>
							<p></p>
								<div class= "row justify-content-md-center" > 
									<div class="col-6">
									<label for="glasgow_pat" class="col-form-label">Escala de Glasgow</label>
										<div class="input-group"> 
											
											<input type="text" size= "6" class="font-weight-bold" name="glasgow_pat" class="form-control"  id="glasgow_pat" readonly>
											<span class="input-group-btn">
												<button type="button" class="btn btn-primary" id="btnGlagow" data-toggle="modal" data-target="#modalGlasgow">Calcular</button>
											</span>
										</div>
									</div>
									
									
								</div>
						</fieldset>
						<fieldset class="border p-2">
							 <legend class="float-none w-auto" style ="font-size:20px;">Hepático</legend>
							 <input type="text" class="text-success font-weight-bold" name="SOFAhepa" size="3" id="SOFAhepa" style="text-align:center;" readonly>
							<p></p>
								<div class= "row justify-content-md-center" > 
									<div class="col-6">
								
										<label for="bilirr_pat" class="col-form-label">Bilirrubina</label>
										<div class="input-group">	
											<input type="number" name="bilirr_pat" class="form-control"  id="bilirr_pat" placeholder="" step= "0.1" oninput="getSOFAhepa()">
											<div class="input-group-append">
												<span class="input-group-text" id="basic-addon2">mg/dL</span>
											</div>
										</div>
									</div>
									
								</div>
						</fieldset>
					</div>
				</div>
				<div class= "modal-footer">
				
					
					<button type="button" class = "btn btn-secondary" data-dismiss="modal" id="btnCerrarModal">Cerrar</button>
					<button type="button" class = "btn btn-primary"  id="btnCalcularModal" onclick="validateSOFA()">Calcular</button>
				
				</div>
			</div>
		</div>
	</div> 

																													


<!-- modal apache -->


	<div class="modal fade" id="modalAPACHEII" role="dialog" tabindex="-1" aria-labelledby="tituloModal" data-backdrop="static" aria-hidden="true">
											
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document" >	
			<div class="modal-content">
				
				<div class= "modal-header">
					<h5 class= "modal-title" id="tituloModal">Cálculo del APACHE II</h5>
					<button class="close" data-dismiss="modal" aria-label="Cerrar">
							<span aria-hidden= "true">&times;</span></button>
				
				</div>
				<div class= "modal-body">
					<div class="container-fluid" id="grid-container">
					
						<div class= "row">
						
							<div class= "col">
						
								<fieldset class="border p-2">
									 <legend class="float-none w-auto" style ="font-size:20px;">Edad</legend>
									 <input type="text" name="apache_edad" size="3" readonly>
									<p></p>
										<div class= "row justify-content-md-center" > 
											
												
											<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
												
												<label class="btn btn-outline-primary"  id= "lbl44" for="btn44">
													<input type="radio" class="btn-check" name= "btn_edad_apache" id= "btn44" value= "0" autocomplete="off" checked disabled> &lt;44 años <p></p></label>
												
												<label class="btn btn-outline-primary" id= "lbl45_54" for ="btn45_54">
												<input type="radio" class="btn-check" name= "btn_edad_apache" id= "btn45_54" value= "2" autocomplete="off" disabled > 45-54 años <p></p></label>
												
												<label class="btn btn-outline-primary" id= "lbl55_64" for ="btn55_64">
												<input type="radio"  class="btn-check"name= "btn_edad_apache" id= "btn55_64" value= "3" autocomplete="off" disabled > 55-64 años<p></p></label>
												
												<label class="btn btn-outline-primary" id= "lbl65_74" for="btn65_74">
												<input type="radio" class="btn-check" name= "btn_edad_apache" id= "btn65_74" value= "5" autocomplete="off" disabled> 65-74 años<p></p></label>
												
												<label class="btn btn-outline-primary" id= "lbl75" for="btn75">
												<input type="radio" class="btn-check" name= "btn_edad_apache" id= "btn75" value= "6" autocomplete="off" disabled> ≥75 años<p></p></label>
												
											</div>
												
											
											
										</div>
								</fieldset>
							</div>
						</div>
						<div class= "row">
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">SNC</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row justify-content-md-center">
										
										
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-sm-4">Escala Glasgow :</label>
													<div class="col-12 col-sm-8">
														<div class="input-group"> 
															<input type="text" size="6" class="form-control"  style = "font-weight: bold;" name="glasgow_pat" id="glasgow_pat" readonly>
															<span class="input-group-btn">
																<button type="button" class="btn btn-primary" id="btnGlagow" data-toggle="modal" data-target="#modalGlasgow">Calcular</button>
															</span>
														</div>
													</div>
												</div>
											</div>
										
									</div>
									
								</fieldset>
							</div>
						</div>
						<div class= "row">
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Temperatura</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Presión arterial media</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_pam" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="pam_apache" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="pam_apache" class="form-control"  id="pam_apache" placeholder="mmHg" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
						</div>
						<div class= "row">
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Frecuencia cardiaca</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_fc" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="fc_apache" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="fc_apache" class="form-control"  id="fc_apache" placeholder="lpm" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Frecuencia respiratoria</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_fr" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="fr_apache" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="fr_apache" class="form-control"  id="fr_apache" placeholder="rpm" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
						</div>
						<div class= "row">
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">pH</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="apache_ph" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="ph_apache" class="form-control"  id="ph_apache" placeholder="" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
							<div class= "col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Sodio</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
								<!--<fieldset class="border p-2">
									 <legend class="float-none w-auto" style ="font-size:20px;">Tensión arterial media</legend>
									 <input type="text" name="apache_glasgow" size="3" readonly>
									<p></p>
										<div class= "row justify-content-md-center">
											<div class="col-4">
										
												<label for="p_sistolica" class="col-form-label">Var</label>
												<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="mmHg" onkeypress = "only_int_nums(event)">
											</div>
											
											<div class="col-4">
												<label for="p_media" class="col-form-label">Var</label>
												<input type="text" name="p_media" class="form-control"  id="p_media" placeholder="mmHg" readonly>
												<button type="button" class="btn btn-primary btn-sm" id="btnPAM" onclick="getPAM()" >Calcular</button>
											</div>
											<div class="w-100"></div>
																															
											
											<div class="w-100"></div>
											<div class="col-md-center">
												<legend class="col-form-label">var radio</legend>
												<div class="col-4">
													<div class="form-check form-check-inline">
													  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
													  <label class="form-check-label" for="gridRadios1"> Si</label>
													</div>
													<div class="form-check form-check-inline">
													  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
													  <label class="form-check-label" for="gridRadios2">No</label>
													</div>
												</div>
											</div>
										
										</div>
								</fieldset>-->
							</div>
						</div>
						<div class="row">
							<div class="col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Potasio</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
							<div class="col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Creatinina sérica</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Temperatura</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
							<div class="col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Leucocitos</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Hematocrito</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
								</fieldset>
							</div>
							<div class="col">
								<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Gradiente A-a de O2</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
									
									<fieldset class="border p-2">
									<legend class="float-none w-auto" style ="font-size:20px;">Gradiente A-a de O2</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
									</fieldset>
									
									<fieldset class="border p-2" id="gradiente aa_02 ">
									<legend class="float-none w-auto" style ="font-size:20px;">Gradiente A-a de O2</legend>
									 
									<div class="row">
										
										<div class="col-2">
											<input type="text" name="apache_glasgow" size="3" readonly>
										</div>
									</div>
									<p></p>
									<div class="row">
										
										<div class="col ">
											<div class="form-inline">
												<div class="form-group">
													<label for="glasgow_pat" class="col-form-label col-4"></label>
													<div class="col-8">
														
														<input type="text" name="p_sistolica" class="form-control"  id="p_sistolica" placeholder="ºC" onkeypress = "only_int_nums(event)">
													</div>
												</div>
											</div>
										</div>
									</div>
									<p></p>
									<p></p>
									</fieldset>
								</fieldset>
								
							</div>
						</div>		
					</div>
				</div>		
				<div class= "modal-footer">
				
					
					<button type="button" class = "btn btn-secondary" data-dismiss="modal" id="btnCerrarModal">Cerrar</button>
					<button type="button" class = "btn btn-primary" id="btnCerrarModal">Calcular</button>
				
				</div>
			</div>
		</div>
	</div>

<!-- modal Glasgow --->
	
	<div class="modal fade" id="modalGlasgow" role="dialog" tabindex="-1" data-backdrop="static" aria-labelledby="tituloModal" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document" >	
			<div class="modal-content">
				
				<div class= "modal-header">
					<h5 class= "modal-title" id="tituloModal"> Escala de Glasgow</h5>
					<button class="close" data-dismiss="modal" aria-label="Cerrar">
							<span aria-hidden= "true">&times;</span></button>
				
				</div>
				<div class= "modal-body">
					<div class="container-fluid">
						<div class="row justify-content-center">
							<input type="text" class="text-info font-weight-bold" style= "font-size: 24px "name="res_glasgow" id = "res_glasgow" size="3" style="text-align:center;" readonly>
							<p></p>
							<p></p>
						</div>
						<div class="row justify-content-center">
						
							
							<fieldset class="border p-2">
								 <legend class="float-none w-auto" style ="font-size:20px;">Respuesta motora</legend>
								 <p></p>
									<div class= "col justify-content-md-center"> 
										<div class="row">
											<select name="res_motora" id="res_motora" form="res_motora" >
												<option value="6">Obedece a órdenes</option>
												<option value="5">Localiza el dolor</option>
												<option value="4">Retira el dolor</option>
												<option value="3">Respuesta en flexión</option>
												<option value="2">Respuesta en extensión</option>
												<option value="1">Sin respuesta</option>
											</select>
										</div>
									</div>	
							</fieldset>
							<fieldset class="border p-2">
								 <legend class="float-none w-auto" style ="font-size:20px;">Respuesta verbal</legend>
								 
								<p></p>
									<div class= "col justify-content-md-center"> 
										<div class="row">
											<select name="res_visual" id="res_visual" form="res_visual" >
												<option value="5">Orientada</option>
												<option value="4">Conversación confusa</option>
												<option value="3">Palabras inapropiadas</option>
												<option value="2">Sonidos incomprensibles</option>
												<option value="1">Sin respuesta</option>
											</select>
										</div>
									</div>	
							</fieldset>	
								<fieldset class="border p-2">
								 <legend class="float-none w-auto" style ="font-size:20px;">Apertura ocular</legend>
								 
								<p></p>
									<div class= "col justify-content-md-center"> 
										<div class="row">
											<select name="ap_ocular" id="ap_ocular" form="ap_ocular" >
												<option value="4">Expontánea</option>
												<option value="3">A órdenes verbales</option>
												<option value="2">A estímulo doloroso</option>
												<option value="1">Sin respuesta</option>
												
											</select>
										</div>
									</div>	
							</fieldset>	
						</div>
					</div>
				</div>
				<div class= "modal-footer">
				
					<button type="button" class = "btn btn-secondary" data-dismiss="modal" id="btnCerrarModal">Cerrar</button>
					<button type="button" class = "btn btn-primary" data-dismiss="modal" id="btnGlasgow" onclick="getGlasgow()">Calcular</button>
				
				</div>
				
			</div>
			
		</div>
		
	</div>




	<div id="wrapper">

		<!-- Topbar Start -->
		<?php include("assets/inc/nav.php");?>
		<!-- end Topbar -->

		<!-- ========== Left Sidebar Start ========== -->
		<?php include("assets/inc/sidebar.php");?>
		<!-- Left Sidebar End -->

		<!-- ============================================================== -->
		<!-- Start Page Content here -->
		<!-- ============================================================== -->
		<div class="content-page">
			<div class="content">
				<div class="jumbotron" id="myJumbotron">
					<h1 style="color:white">
						<?php echo ($id_dia == 1 && $id_tipo_toma != 'preUCI') ? 'Ingreso' : ($id_dia == "" ? 'Día personalizado' : ($id_dia != 0 && $id_tipo_toma == 'mes seguimiento' ? $id_dia . 'º mes de ' : 'Día ' . $id_dia)); ?>
						<?php echo ($id_tipo_toma == 'HOSP') ? 'hospitalario' : (($id_tipo_toma == 'preUCI') ? 'previo al ingreso en UCI' : (($id_tipo_toma == 'mes seguimiento') ? 'seguimiento' : 'de ' . $id_tipo_toma)); ?>
					</h1>
				</div>
				 <!-- Start Content-->
				<div class="container-fluid">
					<!-- start page title -->
					<div class="row">
						<div class="col-12">
						
							<div class="page-title-box">
								<div class="page-title-right">
									<ol class="breadcrumb m-0">
										<li class="breadcrumb-item"><a >Tablero</a></li>
										<li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
										<li class="breadcrumb-item active">Añadir paciente</li>
										<li class="breadcrumb-item active">Añadir dia de toma de datos</li>
									</ol>
								</div>
								
								
								
							</div>
														
						</div>
					</div>
					<div class="form-row justify-content-between">
						<div class="col-6" style="margin-rigth: 20px;">
							<fieldset class="col-4 float-lef" style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
							box-shadow: 0 0 10px #666; background:#e8f5e9">
								<legend class="float-none w-auto"></legend>
									
									
									
									<div class="holder">
										<div class="checkdiv grey400">
											<input type="checkbox" class="le-checkbox" id="status_dia" name="status_dia" />
											<span style="font-size:20px">Día completo</span>
										</div>
									</div>
									
									
							</fieldset>
							<p></p>
							<div id="paciente_estancia_uci" style="display:none">
							<fieldset class="col-5 float-lef" style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
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
							<!--<fieldset id="datos_otros_preuci" style="display:none" class=" campo_toma_datos col-3 float-right" >
							<legend class=" legendCustom float-none w-auto">Toma de datos</legend>
								<div class="form-row">
									
										<select name="day_monitor" id="day_monitor_otro" form="day_monitor_otro" style="width: 150px;" class="form-control" onclick= "getDateMonitor()">
											  <option value="">--Elige--</option>
											  <?php foreach ($opciones_dates as $clave => $texto) : ?>
													<option value="<?php echo $clave; ?>"><?php echo $texto; ?></option>
											  <?php endforeach; ?>
											  
										</select> 
									</div>
									
									
									<div class="col" style="margin-left: 20px;">
										<label for="date_monitor_otro" class="col-form-label">Fecha</label>
										<input type="date" name="date_monitor_otro" class="form-control" id="date_monitor_otro" style="width: 145px;"readonly>
									</div>
									<div class="col-2 float-right">
										<button type="button" class="btn btn-sm btn-info" data-toggle="popover" title="Información" 
										data-content="Solo se pueden ingresar dias posteriores al ingreso hospitalario y anteriores al ingreso en UCI."
										style="position: absolute; top: -10px; right: 50px; font-size: smaller;">i</button>
									</div>
								</div>
						<p></p>
						<p style="margin-left: 20px;">La diferencia en días entre el ingreso en UCI y hospitalario es de: <?php echo $diferenciaDias_num; ?></p>
						</fieldset>-->
						
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
						
						
							<fieldset id= "datos_pics"  class="col-4 float-right campo_toma_datos" style="display:none">
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
													<input type="checkbox" class="custom-control-input" id="pcr_pics_pat_check" name="pcr_pics_pat_check"  disabled />
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
						
							<fieldset id= "datos_preUCI"  class="col-2 float-right campo_toma_datos" style="display:none">
								<legend class=" legendCustom float-none w-auto">Toma de datos</legend>
									<div class="form-row" style="margin-left: 20px;">
										
										<div class="col-8" style="margin-left: 20px;">
											<label for="date_monitor_preuci" class="col-form-label"> Fecha preUCI</label>
											<input type="date" name="date_monitor_preuci" class="form-control" id="date_monitor_preuci" readonly>
										</div>
										
									</div>
							<p></p>
								
							</fieldset>
							<fieldset id="datos_otros" style="display:none" class="campo_toma_datos col-3 float-right">
							<legend class="legendCustom float-none w-auto">Toma de datos</legend>
								<div class="form-row" style="margin-left: 20px;">
									<div class="col-4">
										<label for="day_monitor" class="col-form-label">Dia</label>
										<!-- <input type="text" required="required" name="day_monitor"  maxlength="2" class="form-control" 
										id="day_monitor" onkeypress ="only_int_nums(event)" oninput= "getDateMonitor()" >-->
										
										<select name="day_monitor" id="day_monitor" form="day_monitor" class="form-control" onclick= "getDateMonitor()" >
											  <option value="">--Elige--</option>
											  
											<?php if ($id_tipo_toma== 'estudio') : ?>
											
											  <option value="1">Ingreso</option>
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
											  
											 <?php else : ?>
												  <?php foreach ($opciones_dates as $clave => $texto) : ?>
														<option value="<?php echo $clave; ?>"><?php echo $texto; ?></option>
												  <?php endforeach; ?>
											
											<?php endif; ?>
										</select> 
										
									</div>
									
									
									<div class="col-5">
										<label for="date_monitor" class="col-form-label">Fecha</label>
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
					</div>
					<p>
					</p>
					<p>
					</p>
					<div class="row">
						<div class="col-12"> <!--col-md-8 col-lg-6 -->
							
							
								<fieldset class="col" style="padding:14px; border:3px solid #0288d1; border-radius: 8px;
								box-shadow: 0 0 10px #666; background:#e1f5fe">
								<legend class=" legendPat float-none w-auto">Datos paciente</legend>
								<div class="form-row">
									
									<div id="campos_fechas_ingresos">
										<div class="col-md"id="campo_fecha_UCI" style="display:none">
											<label for="date_ingreso_copied" class="col-form-label">Fecha ingreso UCI </label>
											<input required="required" type="date" name="date_ingreso_uci" class="form-control"  
											id="date_ingreso_uci"  readonly>
											
										</div>
										
										<div class="col-md" id="campo_fecha_ingreso" style="display:none">
											<label for="date_ingreso_copied" class="col-form-label">Fecha ingreso hospitalario</label>
											<input required="required" type="date" name="date_ingreso" class="form-control"  
											id="date_ingreso"  readonly>
											
										</div>
									</div>
									<div id="campo_fechas_alta" style="display:none">
										<div class="col-md">
											<label for="date_alta_uci" class="col-form-label">Fecha alta UCI</label>
											<input required="required" type="date" name="date_alta_uci" class="form-control"  
											id="date_alta_uci"  readonly>
											
										</div>
											
										<div class="col-md">
											<label for="date_alta" class="col-form-label">Fecha alta hospitalaria</label>
											<input required="required" type="date" name="date_alta" class="form-control"  
											id="date_alta"  readonly>
											
										</div>
									</div>
									
									<div class="col-md">
										
										<label for="pat_number" class="col-form-label">Identificador interno</label>
										<input type="text" name="pat_number"  class="form-control" id="pat_number" readonly>
									</div>
									<div class="col-md">
										<label for="pat_SIP" class="col-form-label">SIP</label>
										<input type="text" name="pat_SIP" class="form-control" id="pat_SIP" readonly>
										
									</div>
									<div class="col-md">
										<label for="pat_NHC" class="col-form-label">NHC </label>
										<input type="text" name="pat_NHC" class="form-control"  id="pat_NHC" readonly>
										
									</div>
												
									
									
								</div>
								<br></br>
								</fieldset>
							<form action="" method="post" name= "ingreso_datos" id="ingreso_datos" >
								<br></br>
								<div id="datos_ids" style= "display:none">
									<div class="col-md" >
												
										<label for="id_dia" class="col-form-label" >Identificador dia</label>
										<input type="number" name="id_dia"  class="form-control" id="id_dia" value="<?php echo $id_dia ?>"   readonly>
									</div>
									<div class="col-md">
										<label for="pat_id"  class="col-form-label">Identificador interno</label>
										<input type="text"   name="pat_id"  class="form-control" id="pat_id" readonly>
									</div>
									
									<div class="col-md">
										<label for="id_tipo_toma"   class="col-form-label">Identificador momento de toma</label>
										<input type="text"   name="id_tipo_toma"  class="form-control" id="id_tipo_toma" value="<?php echo $id_tipo_toma ?>" readonly>
									</div>
								</div>
								
								 <fieldset class=".custom-fieldset	 border p-2">
									<legend class="float-none w-auto font-weight-bold" style ="font-size:18px;">Biomarcadores</legend>
									<div class="fields">
									
										<div class="form-row">
											
												<div class="col">
															
													<label for="SOFA_pat" class="col-form-label">SOFA</label>
													<div class="input-group"> 
														<input class="font-weight-bold" required="required" type="number" class="form-control" name="SOFA_pat" id="SOFA_pat" style="width:80px;" >
														<span class="input-group-btn">
															<button type="button" class="btn btn-primary" id="btnCalculoSOFA" data-toggle="modal" data-target="#modalSOFA">Calcular</button>
														</span>
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
														<input  type="number" name="linfocitos_abs_pat" class="form-control"  id="linfocitos_abs_pat" placeholder="" oninput= "duplicate(this.id)" step = "0.1">
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
													<input type="number" name="rbp_pat" class="form-control"  id="rbp_pat" oninput= "duplicate(this.id)" step = "0.1">
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
							
							<p> 
						
							</p>
							<div class="row justify-content-between" style="margin:60px;">
								<div class="col-auto">
									<input type="button" class="btn btn-secondary" onclick="cerrar_pestaña()" value="Volver" style="width:200px;">
								</div>
								
								<div class="col-auto">
									<button type="submit" class="btn btn-primary" style="width:200px;" id="guardar_dia" onclick="save()" >Guardar día</button>
								</div>
							</div>
						</div>
						
					</div>
				</div> 
			</div> 
		</div> 
		<!-- Footer Start -->
		<?php include('assets/inc/footer.php');?>
		<!-- end Footer -->	
		
	</div>
	
	<!-- Right bar overlay-->
	<div class="rightbar-overlay"></div>



	<!-- JavaScript and dependencies -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<!-- JavaScript for validations only -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
	<!-- Our script! :) -->
  
	<script src="assets/dist/enchanter.js"></script>
	
	<!-- Vendor js -->
	<script src="assets/js/vendor.min.js"></script>

	<!-- App js-->
	<script src="assets/js/app.min.js"></script>

	<!-- Loading buttons js -->
	<script src="assets/libs/ladda/spin.js"></script>
	<script src="assets/libs/ladda/ladda.js"></script>

	<!-- Buttons init js-->
	<script src="assets/js/pages/loading-btn.init.js"></script>
	
	
	<script>
	
	
		
	</script>
	
	<!-- Custom script -->
	<script>
	
	$(document).ready(function() {
		
		//cambiar color titulo pagina
		var jumbo_id_dia= parseInt('<?php echo $id_dia ?>');
		
		var tipo_toma = '<?php echo $id_tipo_toma ?>';
		
		switch(tipo_toma){
			
			case 'estudio':
				switch(jumbo_id_dia){
					case 1:
						
					$("#myJumbotron").css("background-color", "#3f51b5");
					$('#UCI_pat').prop('checked',true);
					break;
					case 3:
					$("#myJumbotron").css("background-color", "#00897b");
					$('#UCI_pat').prop('checked',true);
					break;
					case 5:
					$("#myJumbotron").css("background-color", "#0097a7");
					$('#UCI_pat').prop('checked',true);
					break;
					case 7:
					$("#myJumbotron").css("background-color", "#7b1fa2");
					$('#datos_ecc').css('display', 'block');
					break;
					case 14:
					$("#myJumbotron").css("background-color", "#f8bbd0");
					$('#datos_pics').css('display', 'block');
					break;
					
					default:
						$("#myJumbotron").css("background-color", "#558b2f");
						$('#datos_otros').css('display', 'block');
						
						var valoresDeshabilitados = [0, 1, 3, 5, 7, 14];

							$("#day_monitor option").each(function() {
							  var valor = parseInt($(this).val());
							  if (valoresDeshabilitados.includes(valor)) {
								$(this).prop('disabled', true);
							  } else {
								$(this).prop('disabled', false);
							  }
							});
					
					
				}
				$('#paciente_estancia_uci').show();
				$('#datos_preUCI').css('display', 'none');
				$('#campo_fecha_ingreso').css('display', 'none');
				$('#campo_fecha_UCI').css('display', 'block');
				$('#campo_fechas_alta').css('display', 'none');
				
			break;
			
			case 'preUCI':
				switch(jumbo_id_dia){
					
					case 1:
					$("#myJumbotron").css("background-color", "#b2dfdb");
					$('#datos_preUCI').css('display', 'block');
					break;
					
					default:
					$("#myJumbotron").css("background-color", "#1b5e20");
					$('#datos_otros').css('display', 'block');
					$('#info_preuci_1').css('display', 'block');
					$('#info_preuci_2').css('display', 'block');
					
					var valoresDeshabilitados_default = [0, 1];
					var valoresDeshabilitados_otros = <?php echo $diferenciaDias;?>;
					var deshabilitar = valoresDeshabilitados_default.concat(valoresDeshabilitados_otros);
					
					$("#day_monitor option").each(function() {
					  var valor = parseInt($(this).val());
					  if (deshabilitar.includes(valor)) {
						$(this).prop('disabled', true);
					  } else {
						$(this).prop('disabled', false);
					  }
					});
	
	
					
				}
				$('#paciente_estancia_uci').hide();
				$('#campo_fecha_ingreso').css('display', 'block');
				$('#campo_fecha_UCI').css('display', 'block');
				$('#campo_fechas_alta').css('display', 'none');
				
			break;
			case 'HOSP':
				switch(jumbo_id_dia){
					
					case 1:
					$("#myJumbotron").css("background-color", "#aaacc9 ");
					
					break;
					
				}
				$('#paciente_estancia_uci').hide();
				$('#datos_preUCI').css('display', 'none');
				$('#campo_fecha_ingreso').css('display', 'block');
				$('#campo_fecha_UCI').css('display', 'none');
				$('#campo_fechas_alta').css('display', 'none');
				
			break;
			case 'mes seguimiento':
				switch(jumbo_id_dia){
					
					case 3:
					$("#myJumbotron").css("background-color", "#ec407a ");
					
					break;
					case 6:
					$("#myJumbotron").css("background-color", "#7e57c2 ");
					
					break;
					case 12:
					$("#myJumbotron").css("background-color", "#6a1b9a ");
					
					break;
					
				}
				$('#paciente_estancia_uci').hide();
				$('#datos_preUCI').css('display', 'none');
				$('#campo_fecha_ingreso').css('display', 'block');
				$('#campo_fecha_UCI').css('display', 'block');
				$('#campo_fechas_alta').css('display', 'block');
				
			break;
		}
		
		$('#day_monitor').on('change', function() {
        
			$(":input:not(#id_dia, #id_tipo_toma,#pat_SIP, #pat_NHC, #date_ingreso,#date_ingreso_uci,#pat_id,#pat_number,#day_monitor)").val("");
			$('#UCI_pat').prop('checked',false);	
			$('#id_dia').val($(this).val());
		  });
		  
		  //var check_status = $('#VM_96h_pat_check, #traqueo_pat_check, #infecccion_nosoco_pat_check, #upp_pat_check, #fmo_pat_check, #perdida_masa_musc_pat_check, #malnutricion_pat_check, #det_cognitivo_pat_check, #status_ecc_pat_check');
  
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
		  });

		/* var hiddenInputs = $('input[type="hidden"]');
  
		  hiddenInputs.on('change', function() {
			hiddenInputs.each(function() {
			  var hiddenInput = $(this);
			  var checkbox = hiddenInput.parent().find('.myDiagnosis input[type="checkbox"]');
			  
			  if (hiddenInput.val() === '1') {
				checkbox.prop('checked', true);
			  } else {
				checkbox.prop('checked', false);
			  }
			});
		  }); */
		  
		  				

		
		
		
		// valores previos vars
		
		<?php foreach ($datos as $columna => $valor): ?>
			<?php if ($columna === 'UCI'): ?>
				<?php $checked = ($valor == 1) ? 'checked' : ''; ?>
				
					var campo = document.getElementById("<?php echo $columna; ?>_pat");
					campo.checked = "<?php echo $checked; ?>";
			
			<?php elseif($columna === 'PCR' || $columna === 'albumina' || $columna === 'linfocitos_abs' || $columna === 'rbp' || $columna === 'prealbumina' ): ?>
				
					var campo_copied = document.getElementById("<?php echo $columna; ?>_pat_copied");
					campo_copied.value = "<?php echo $valor; ?>";
					
					var campo = document.getElementById("<?php echo $columna; ?>_pat");
					campo.value = "<?php echo $valor; ?>";
						
				
			<?php else: ?>
				
					var campo = document.getElementById("<?php echo $columna; ?>_pat");
					campo.value = "<?php echo $valor; ?>";
				
			<?php endif; ?>
		<?php endforeach; ?>
		
		
		
		// valores previos caso diagnostico ecc y pics
		
		<?php foreach ($datos_caso as $columna => $valor): ?>
			
			<?php if ($columna === 'status_ecc'): ?>
				<?php $checked = ($valor == 1) ? 'checked' : ''; ?>
				
					var campo = document.getElementById("<?php echo $columna; ?>_pat_check");
					var campo_copied = document.getElementById("<?php echo $columna; ?>_pat_copied");
					
					campo.checked = "<?php echo $checked; ?>";
					campo_copied.checked = "<?php echo $checked; ?>";
					
				
			<?php else: ?>
			
				<?php $checked = ($valor == 1) ? 'checked' : ''; ?>
				
					var campo = document.getElementById("<?php echo $columna; ?>_pat_check");
					campo.checked = "<?php echo $checked; ?>";
					
			<?php endif; ?>	
			
				
			
		<?php endforeach; ?>
		
		// Cambiar el check del día según el valor del check volcado de la base de datos
			var ficha_dia = <?php echo $ficha_dia; ?>;
			console.log(ficha_dia)
			
			var ficha_dia = ficha_dia.status_dia ? true : false;
			
			$("#status_dia").prop('checked',ficha_dia);
		
		
		
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
		$('#PCR_pat').on("input",function(){
			
			if (parseFloat($('#PCR_pat').val())> 1.5){
				
				$('#pcr_pics_pat_check').prop('checked', true).trigger("change");
			} else {
				$('#pcr_pics_pat_check').prop('checked', false).trigger("change"); // Desmarcar el checkbox y desencadenar el evento "change"
			  }
		
		});
		$('#albumina_pat').on("input",function(){
			if (parseInt($('#albumina_pat').val())< 3){
			
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
		
		
	
		
	});
	
	
	
	
	</script>
	<script>
	
	 
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
		
	  
	 function getDateMonitor() {
		
		var fecha_inicio = document.getElementById('date_ingreso_uci').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = document.getElementById('day_monitor').value; 
		dia_monitor = new Number(dia_monitor);
		
		if ('<?php echo $id_tipo_toma ?>' == 'estudio'){
			
			var fecha_monitor =    addDays(fecha_inicio,dia_monitor);	
			
		}else if('<?php echo $id_tipo_toma ?>' == 'preUCI'){
			
			var fecha_monitor =    substractDays(fecha_inicio,dia_monitor);	
		}
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
		document.getElementById('date_monitor').value = fecha_monitor;
		
		
		} 
 
	  
	 /*  function getDateMonitor() {
		  
		
		var fecha_inicio = document.getElementById('date_ingreso_uci').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = document.getElementById('day_monitor').value; 
		dia_monitor = new Number(dia_monitor);
		
		var fecha_monitor =    substractDays(fecha_inicio,dia_monitor);
		
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
				
		document.getElementById('date_monitor').value = fecha_monitor;
		
		
		} 

	  
	  
	  function getDateMonitor_estudio() {
		
		var fecha_inicio = document.getElementById('date_ingreso_uci').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = document.getElementById('day_monitor').value; 
		dia_monitor = new Number(dia_monitor);
		
		var fecha_monitor =    addDays(fecha_inicio,dia_monitor);
		
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
				
		document.getElementById('date_monitor_estudio').value = fecha_monitor;
		
		
		} */

  
  
	  
	  
	  function getDateMonitor_preUCI() {
		
		var fecha_inicio = document.getElementById('date_ingreso_uci').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = '<?php echo $primer_diaPreuci ?>'; 
		dia_monitor = new Number(dia_monitor);
		
		var fecha_monitor =    substractDays(fecha_inicio,dia_monitor);
		
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
				
		document.getElementById('date_monitor_preuci').value = fecha_monitor;
		
		
		}

  
  </script>
	
	<script>
	function load(){
		var fecha_pat = localStorage.getItem('pat_ingreso');
		document.getElementById("date_ingreso").value = fecha_pat;
		
		var fecha_pat_uci = localStorage.getItem('pat_ingreso_uci');
		document.getElementById("date_ingreso_uci").value = fecha_pat_uci;
		
		var fecha_pat = localStorage.getItem('pat_alta');
		document.getElementById("date_alta").value = fecha_pat;
		
		var fecha_pat_uci = localStorage.getItem('pat_alta_uci');
		document.getElementById("date_alta_uci").value = fecha_pat_uci;
		
		var numero_pat = localStorage.getItem('pat_numero');
		document.getElementById("pat_number").value = numero_pat;
		document.getElementById("pat_id").value = numero_pat;
		
		var sip_pat = localStorage.getItem('pat_n_sip');
		document.getElementById("pat_SIP").value = sip_pat;
		
		var nhc_pat = localStorage.getItem('pat_n_nhc');
		document.getElementById("pat_NHC").value = nhc_pat;
		
		
		
		//updateFormValues();
		getDateMonitor_preUCI();
	}
	
	</script>
	

<script>
	function cerrar_pestaña(){
		let timerInterval;
		
		setTimeout(function () 
				{ 
					Swal.fire({
						  title: "Estas a punto de salir",
						  text: "Un vez hayas cerrado los cambios no guardados no serán recuperables",
						  icon: "warning",
						  
						  confirmButtonText: 'Cerrar',
						  showCancelButton: true,
						  cancelButtonText: 'Continuar editando',
						  
						  
						})
						.then((result) => {
						  if (result.isConfirmed) {
							Swal.fire({
								  title: '¡Alerta cierre!',
								  html:
									'Cerrando en <strong></strong> segundos.<br/><br/>' , 
								  
								  timer: 4000,
								  buttonsStyling: false,
								  showCancelButton: true,
								  cancelButtonText: 'Cancelar',
								  customClass: {
										cancelButton: "btn btn-danger"
									},
								  didOpen: () => {
										const content = Swal.getHtmlContainer()
										const $ = content.querySelector.bind(content)
										
										Swal.showLoading()
										
										timerInterval = setInterval(() => {
										  Swal.getHtmlContainer().querySelector('strong')
											.textContent = (Swal.getTimerLeft() / 1000)
											  .toFixed(0)
										}, 100)
									  },
								  
								}).then(function (result) {
								  if (result.dismiss === swal.DismissReason.timer) {
									clearInterval(timerInterval)  
									window.open('', '_self', ''); window.close();
								  }
								});
							
						  } 
						});
				
				
				
				},
					100);
			
		
		
		
                
	}
	</script>

	
<script>
	
	function save(){
		
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
									  data: {formData:formData, formData_ecc:formData_ecc, formData_pics:formData_pics}, // 
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
	pentitle="Checkboxes";

	setTimeout(checkedbox, 1000);
	setTimeout(uncheckedbox, 2000);
	function checkedbox() {
	  $('.thisonetocheck').prop('checked', true);
	}

	function uncheckedbox() {
	  $('.thisonetocheck').prop('checked', false);
	  $('.thisonetocheckalso').prop('checked', true);
	}


	</script>
	
	<script>
		
		/* var fechaIngresopat = localStorage.getItem('fecha_ingreso_dia');
		//var sofa_ingreso = localStorage.getItem('sofa_ingreso_pat');
		
		document.getElementById('date_ingreso_copied').value = fechaIngresopat; 
		//document.getElementById('SOFA_pat').value = sofa_ingreso;
	
		localStorage.clear(); */
	
	</script>
	<script>
	function validateForm() {
	  // This function deals with validation of the form fields
	  var x, y, i, valid = true;
	  x = document.getElementsByClassName("tab");
	  y = x[currentTab].getElementsByTagName("input");
	  // A loop that checks every input field in the current tab:
	  for (i = 0; i < y.length; i++) {
		// If a field is empty...
		if (y[i].value == "") {
		  // add an "invalid" class to the field:
		  y[i].className += " invalid";
		  // and set the current valid status to false:
		  valid = false;
		}
	  }
	  // If the valid status is true, mark the step as finished and valid:
	  if (valid) {
		document.getElementsByClassName("step")[currentTab].className += " finish";
	  }
	  return valid; // return the valid status
	}

</script>
	<script>
	function showDrugs() {
	  var checkBox = document.getElementById("check_toggl");
	  
	  var fst_section = document.getElementById("inputs_drugs_1");
	  var sec_section = document.getElementById("inputs_drugs_2");
	  
	  if (checkBox.checked == true){
		
		fst_section.style.display = "block";
		sec_section.style.display = "block";
	  } else {
		 
		 fst_section.style.display = "none";
		 sec_section.style.display = "none";
	  }
	}
	</script>
	<script>
	
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
  
  <script>
  
  function getSOFAres(){
	  
		
		var pafi02 = new Number(document.querySelector('#PaFi_pat').value);
		
		var v_mecanica = new Number (document.querySelector('input[name="gridVM"]:checked').value);
		
		
		
		if(pafi02 > 400 || pafi02 == 0){
			
			var res_sofa_valor = 0;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
		}else if(pafi02 >= 400){
			var res_sofa_valor = 0;
			document.querySelector('#SOFAres').value = res_sofa_valor;
		
		
		}else if ( pafi02 < 400 && pafi02 >= 300){
			
			var res_sofa_valor = 1;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
		} else if( pafi02 < 300){
			
			var res_sofa_valor = 2;
			document.querySelector('#SOFAres').value = res_sofa_valor;
			
			if( pafi02 <= 200 && pafi02 > 100 && v_mecanica == 1){
				
				var res_sofa_valor = 3;
				document.querySelector('#SOFAres').value = res_sofa_valor;
				
			}else if( pafi02 <= 100 && v_mecanica == 1){
				var res_sofa_valor = 4;
				document.querySelector('#SOFAres').value = res_sofa_valor;
			}
			
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
		
		if (valor_glasgow == 15){
			document.querySelector('#SOFAsnc').value = 0;
			
		}else if (valor_glasgow <15 && valor_glasgow >12 ){
			document.querySelector('#SOFAsnc').value = 1;
			
		}else if (valor_glasgow <13 && valor_glasgow >9){
			document.querySelector('#SOFAsnc').value = 2;
			
		}else if (valor_glasgow <10 && valor_glasgow >5){
			document.querySelector('#SOFAsnc').value = 3;
			
		}else if (valor_glasgow <6 ){
			
		}
		
	}
  
	function getSOFAhemo() {
	  var valor_pam = parseFloat(document.querySelector('#p_media').value);

	  var check_drugs = document.querySelector('#check_toggl');

	  var dopa_value = parseFloat(document.querySelector('#dopa_pat').value);
	  var nora_value = parseFloat(document.querySelector('#nora_pat').value);
	  var adrena_value = parseFloat(document.querySelector('#adrena_pat').value);
	  var dobu_value = parseFloat(document.querySelector('#dobu_pat').value);

	  var hemo_sofa_valor;

	  if (check_drugs.checked) {
		  
		hemo_sofa_valor = 2;

		if ((dopa_value < 5 && dopa_value > 0) || dobu_value !== 0) {
		  hemo_sofa_valor = 2;
		  
		} else if (
		  (dopa_value > 5 && dopa_value <= 15) || (nora_value <= 0.1 && nora_value > 0) ||(adrena_value <= 0.1 && adrena_value > 0)) {
			  
			hemo_sofa_valor = 3;
			
		} else if (dopa_value > 15 || nora_value > 0.1 || adrena_value > 0.1) {
		  hemo_sofa_valor = 4;
		}else {
			
			  document.querySelector('#SOFAhemo').value = hemo_sofa_valor;
		}
		
	  } else {
		if (valor_pam >= 70) {
		  hemo_sofa_valor = 0;
		} else if (valor_pam < 70 && valor_pam > 0) {
		  hemo_sofa_valor = 1;
		}
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
		 
		 alert("Calclulo realizado");
		 
		 //$success = "Patient Details Added";
		
	  
	  } else {
		  alert("Faltan campos por completar");
		  //$err = "Please Try Again Or Try Later";
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