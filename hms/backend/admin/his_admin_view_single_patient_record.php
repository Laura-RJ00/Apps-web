<?php
	session_start();
	
	include('assets/inc/config.php');
	
		
?>


<!DOCTYPE html>
<html lang="es">

 <!--Head-->
    <?php include('assets/inc/head.php');?>
	
	
		
	
<!--<script>

	$('#toggle_two').change(function () {

        if ($('#toggle_two').prop('checked') == true) {

			$(document).ready(function() {
				
				$("#show").click(function() {
					$("#dopamina_d").show();
				});
				
			 
			});
		  
		})
	  })
	 
	 
	  
	   $(document).ready(function () {
			$('[name"toggle_event"]').click(function (e) {
				e.preventDefault();
				if ($(toggle_event"]:checked').is(":checked")) {
					
					$("#dopamina_d").show();
				} else {
					
					$("#dopamina_d").hide();
				}
			});
		});
	  
	
	
	
	  
	  
	  $(document).ready(function () {
			$('[name="toggle_two"]').click(function (e) {
				e.preventDefault();
				if ($('[name="toggle_two"]:checked').is(":checked")) {
					
					$("#dopamina_d").show();
				} else {
					
					$("#dopamina_d").hide();
				}
			});
		});
	</script> -->

<body>

	
	
	 <!-- Begin page -->
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
				 <!-- Start Content-->
				<div class="container-fluid">
					<!-- start page title -->
					<div class="row">
						<div class="col-12">
							<div class="page-title-box">
								<div class="page-title-right">
									<ol class="breadcrumb m-0">
										<li class="breadcrumb-item"><a href="his_doc_dashboard.php">Tablero</a></li>
										<li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
										<li class="breadcrumb-item active">Añadir paciente</li>
									</ol>
								</div>
								<h4 class="page-title">Ficha de paciente</h4>
								<div class="form-row justify-content-between">
								<?php
									
										$pat_id=$_GET['pat_id'];
										$pat_index=intval($_GET['pat_index']);
																													
										$query = "SELECT * FROM patients WHERE pat_id = ? AND pat_index =?";
										$stmt= $mysqli->prepare($query) ;
										$stmt->bind_param('si', $pat_id, $pat_index);
										$stmt->execute() ;//ok
										$res=$stmt->get_result();
										
										while($row=$res->fetch_object())
										{
											$status_checked = ($row->pat_record_status == 1) ? 'checked' : '';
											
											$sexM_checked = ($row->pat_sex == "1") ? 'checked' : '';
											$sexH_checked = ($row->pat_sex == "0") ? 'checked' : '';
											
											$exitusS_checked = ($row->exitus == "1") ? 'checked' : '';
											$exitusN_checked = ($row->exitus == "0") ? 'checked' : '';
											
											$ASV_s_checked = ($row->asv == "1") ? 'checked' : '';
											$ASV_n_checked = ($row->asv == "0") ? 'checked' : '';
											
											$intrauciS_checked = ($row->intrauci == "1") ? 'checked' : '';
											$intrauciN_checked = ($row->intrauci == "0") ? 'checked' : '';
											
											$exitus28dS_checked = ($row->exitus_28d == "1") ? 'checked' : '';
											$exitus28dN_checked = ($row->exitus_28d == "0") ? 'checked' : ''; 
											
											
																					
											 $edad_pac = $row->pat_age;
										
										
									
									?>
										<fieldset class="col-7 float-lef" style="padding:14px; border:3px solid #0288d1; border-radius: 8px;
											box-shadow: 0 0 10px #666; background:#e1f5fe">
												<legend class=" legendPat float-none w-auto">Datos paciente</legend>
												<div class="form-row">
													
													<div class="col-md-6">
														
														<label for="pat_number" class="col-form-label">Identificador interno</label>
														<input type="text" name="pat_number"  class="form-control" id="pat_number" value="<?php echo $row->pat_id;?>" readonly>
													</div>
													
																
													
													
												</div>
												<br></br>
										</fieldset>
									
										<fieldset class="col-3 float-right" style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
										box-shadow: 0 0 10px #666; background:#e8f5e9">
											<legend class="float-none w-auto"></legend>
												<div class="container" >
												
													<div class="holder justify-content-md-center">
														<div class="checkdiv grey400">
															<input type="checkbox" class="le-checkbox" id="ficha_compl" name="ficha_compl" <?php echo $status_checked ?>/>
															<span style ="font-size:15px;">FICHA COMPLETA</span>
														</div>
													</div>
												</div>
										</fieldset>
								
								</div>
								<p>
								</p>
								<p>
								</p>
								
							</div>
						</div>
					</div>  
					<p>
					</p>
					<p>
					</p>
					<div class="row">
						<div class="col-12"> <!--col-md-8 col-lg-6 -->
							<form action="" method="post" name= "registration" id="registration" >
								<nav>
									<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
										  <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">Ficha identificativa</a>
										  <a class="nav-link" id="step2-tab" data-bs-toggle="tab" href="#step2">Factores de riesgo</a>
										  <!--<a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Manejo inicial</a> -->
										  <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Diagnóstico</a>
										  <a class="nav-link" id="step4-tab" data-bs-toggle="tab" href="#step4" onclick="save()">Monitorización</a>
										  <a class="nav-link" id="step5-tab" data-bs-toggle="tab" href="#step5">Seguimiento</a>
										 
										  
									</div>
								</nav>
								<div class="col-md">
														
									<label for="status_ficha" class="col-form-label" style= "display:none">Estado ficha</label>
									<input style= "display:none" type="number" name="status_ficha"  class="form-control" id="status_ficha" value = 0 readonly>
								</div>
								<div class="tab-content py-4">
									<div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
									  <!--<h4>Rellena todos los campos</h4> -->
									    <div id="pat_detalles">
											 <b><span class="title">Estancia del paciente</span> </b>
											<div class="fields">
												<div class="form-row">
													
													
													<div class="col">
														<label for="date_ingreso" class="col-form-label">Fecha ingreso hospitalario</label>
														<input type="date" name="date_ingreso" class="form-control"  id="date_ingreso" value="<?php echo $row->pat_date_ingreso;?>" onblur= "ajuste_fechas()">
														<span id="error-date_ingreso"></span>
													</div>
													<div class="col">
														<label for="date_ingreso_uci" class="col-form-label">Fecha ingreso UCI</label>
														<input type="date" name="date_ingreso_uci" class="form-control"  id="date_ingreso_uci" value="<?php echo $row->pat_date_ingreso_uci;?>" onblur= "ajuste_fechas()">
													</div>
													<div class="col">
														<label for="date_alta_uci" class="col-form-label">Fecha alta UCI</label>
														<input type="date" name="date_alta_uci" class="form-control"  id="date_alta_uci" value="<?php echo $row->pat_date_alta_uci;?>" onblur= "ajuste_fechas()" oninput= "getEstancia()">
													</div>
													<div class="col">
														<label for="date_alta" class="col-form-label">Fecha alta hospitalaria</label>
														<input type="date" name="date_alta" class="form-control"  id="date_alta" value="<?php echo $row->pat_date_alta;?>">
														
													</div>
													<div class="col">
														<label for="estancia_hosp" class="col-form-label">Estancia en UCI (días)</label>
														<input  type="number" name="estancia_hosp" class="form-control"  id="estancia_hosp"  value="<?php echo $row->estancia_hosp;?>" >
														
													</div>
													
													
													
												</div> 
												
												<br></br>
												 <b><span class="title">Datos evolutivos</span> </b>
												<div class="form-row">
																										
													<div class="col">
														<legend class="col-form-label">Exitus</legend>
														
														<div class="form-check form-check">
															  <input class="form-check-input" type="radio" name="gridExitus" id="gridExitusN" value="0" <?php echo $exitusN_checked; ?>>
															  <label class="form-check-label" for="gridExitusN"> No</label>
														</div>
														<div class="form-check form-check">
														  <input  class="form-check-input" type="radio" name="gridExitus" id="gridExitusS" value="1" <?php echo $exitusS_checked; ?>>
														  <label class="form-check-label" for="gridExitusS">Si</label>
														</div>
														
														<div class="col" id="fecha_exitus" style="display:block">
															<label for="date_exitus" class="col-form-label">Fecha exitus</label>
															<input type="date" name="date_exitus" class="form-control"  id="date_exitus"  value="<?php echo $row->date_exitus;?>">
														</div>
													</div>	
													<div class="col">
														<legend class="col-form-label">ASV</legend>
														
														<div class="form-check form-check">
															  <input class="form-check-input" type="radio" name="gridASV" id="gridASV_N" value="0" <?php echo $ASV_n_checked; ?>>
															  <label class="form-check-label" for="gridASV_N"> No</label>
														</div>
														<div class="form-check form-check">
														  <input  class="form-check-input" type="radio" name="gridASV" id="gridASV_S" value="1" <?php echo $ASV_s_checked; ?>>
														  <label class="form-check-label" for="gridASV_S">Si</label>
														</div>
													</div>
													<div class="col">
														<legend class="col-form-label">INTRAUCI</legend>
														
														<div class="form-check form-check">
															  <input class="form-check-input" type="radio" name="gridINTRAUCI" id="gridINTRAUCI_N" value="0" <?php echo $intrauciN_checked; ?>>
															  <label class="form-check-label" for="gridINTRAUCI_N"> No</label>
														</div>
														<div class="form-check form-check">
														  <input  class="form-check-input" type="radio" name="gridINTRAUCI" id="gridINTRAUCI_S" value="1" <?php echo $intrauciS_checked; ?>>
														  <label class="form-check-label" for="gridINTRAUCI_S">Si</label>
														</div>
													</div>
													
													<div class="col">
														<legend class="col-form-label">Exitus &lt;28 dias </legend>
														
														<div class="form-check form-check">
															  <input class="form-check-input" type="radio" name="gridExitus28d" id="gridExitus28d_N" value="0" <?php echo $exitus28dN_checked; ?>>
															  <label class="form-check-label" for="gridExitus28d_N"> No</label>
														</div>
														<div class="form-check form-check">
														  <input  class="form-check-input" type="radio" name="gridExitus28d" id="gridExitus28d_S" value="1" <?php echo $exitus28dS_checked; ?>>
														  <label class="form-check-label" for="gridExitus28d_S">Si</label>
														</div>
													</div>
													
													
													
												</div>
											</div>
											<br></br>
											
											<b><span class="title">Datos demográficos</span> </b>
											<div class="fields">

												<div class="form-row">
													<div class="col">
														<label for="dateBirth" class="col-form-label">Fecha de nacimiento</label>
														<input type="date"  name="dateBirth" class="form-control" id="dateBirth" value="<?php echo $row->pat_dateBirth;?>" >
														
													</div>
													<div class="col">
														<label for="age" class="col-form-label">Edad</label>
														<input type="number" required="required" name="age" class="form-control"  id="age" 
														min="0" max ="130" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
														placeholder="Edad paciente" oninput= "age_charlson()" value="<?php echo $row->pat_age;?>" >
														
													</div>
													<div class="col">
														<legend class="col-form-label">Sexo</legend>
														
														<div class="form-check form-check">
															  <input class="form-check-input" type="radio" name="gridSexo" id="gridSexoH" value="0" <?php echo $sexH_checked; ?>>
															  <label class="form-check-label" for="gridSexoH"> Hombre</label>
														</div>
														<div class="form-check form-check">
														  <input required class="form-check-input" type="radio" name="gridSexo" id="gridSexoM" value="1" <?php echo $sexM_checked; ?>>
														  <label class="form-check-label" for="gridSexoM">Mujer</label>
														</div>
													</div>	
												</div>
												<div class="form-row">
													<div class="col">
														<label for="pat_height" class="col-form-label">Talla (m)</label>
														<input  type="number" name="pat_height" class="form-control"  id="pat_height" placeholder="Altura en metros" step=".01"
														min = "0.50" max = "2.50" onblur= "getBMI()" value="<?php echo $row->pat_height;?>">
														
													</div>
													<div class="col">
														<label for="peso_pac" class="col-form-label">Peso (kg)</label>
														<input  type="number" class="form-control" name="peso_pac" id="peso_pac" placeholder="Peso en kg" step=".1"
														min = "20.0" max = "300.0" onblur= "getBMI()" value="<?php echo $row->pat_weight;?>">
														<span id="error-peso_pac"></span>
													</div>
													<div class="col">
														<label for="BMI_pac" class="col-form-label">IMC</label>
														<input type="text" name="BMI_pac" class="form-control" id="BMI_pac" placeholder="Índice de masa corporal" value="<?php echo $row->pat_imc;?>" readonly>
														
													</div>
													
												</div>
																						
												
												
											</div>
										</div>
									<?php }?>	
									</div>
									
									<div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
									<?php
									
										$pat_id=$_GET['pat_id'];
										
										$query = "SELECT * FROM pat_risk_factors WHERE pat_id = ? ";
										$stmt= $mysqli->prepare($query) ;
										$stmt->bind_param('s', $pat_id);
										$stmt->execute() ;//ok
										$res=$stmt->get_result();
										
										while($row=$res->fetch_object())
										{
											
											$infartoS_checked= ($row->infarto_miocardio != "0") ? 'checked' : '';
											$infartoN_checked= ($row->infarto_miocardio == "0") ? 'checked' : '';
											
											$cardiacS_checked= ($row->insuficiencia_cardiac_congest != "0") ? 'checked' : '';
											$cardiacN_checked= ($row->insuficiencia_cardiac_congest == "0") ? 'checked' : '';
											
											$vascS_checked= ($row->enf_vasc_periferica != "0") ? 'checked' : '';
											$vascN_checked= ($row->enf_vasc_periferica == "0") ? 'checked' : '';
											
											$cerebroS_checked= ($row->enf_cerebro_vasc != "0") ? 'checked' : '';
											$cerebroN_checked= ($row->enf_cerebro_vasc == "0") ? 'checked' : '';
											
											$demenciaS_checked= ($row->demencial != "0") ? 'checked' : '';
											$demenciaN_checked= ($row->demencial == "0") ? 'checked' : '';
											
											$epocS_checked= ($row->epoc != "0") ? 'checked' : '';
											$epocN_checked= ($row->epoc == "0") ? 'checked' : '';
											
											$conectS_checked= ($row->patologia_conect != "0") ? 'checked' : '';
											$conectN_checked= ($row->patologia_conect == "0") ? 'checked' : '';
											
											$hepaLS_checked= ($row->patologia_hepa_leve != "0") ? 'checked' : '';
											$hepaLN_checked= ($row->patologia_hepa_leve == "0") ? 'checked' : '';
											
											$hepaMS_checked= ($row->patologia_hepa_grav_mod != "0") ? 'checked' : '';
											$hepaMN_checked= ($row->patologia_hepa_grav_mod == "0") ? 'checked' : '';
											
											$peptS_checked= ($row->ulcera != "0") ? 'checked' : '';
											$peptN_checked= ($row->ulcera == "0") ? 'checked' : '';
											
											$dmS_checked= ($row->diabetes != "0") ? 'checked' : '';
											$dmN_checked= ($row->diabetes == "0") ? 'checked' : '';
											
											$dmlesionS_checked= ($row->diabetes_lesion_org != "0") ? 'checked' : '';
											$dmlesionN_checked= ($row->diabetes_lesion_org == "0") ? 'checked' : '';
											
											$hemiS_checked= ($row->hemiplejia != "0") ? 'checked' : '';
											$hemiN_checked= ($row->hemiplejia == "0") ? 'checked' : '';
											
											$renalS_checked= ($row->patologia_renal_grav_mod != "0") ? 'checked' : '';
											$renalN_checked= ($row->patologia_renal_grav_mod == "0") ? 'checked' : '';
											
											$tumorS_checked= ($row->tumor_solido != "0") ? 'checked' : '';
											$tumorN_checked= ($row->tumor_solido == "0") ? 'checked' : '';
											
											$metasS_checked= ($row->metastasis != "0") ? 'checked' : '';
											$metasN_checked= ($row->metastasis == "0") ? 'checked' : '';
											
											$leuS_checked= ($row->leucemia != "0") ? 'checked' : '';
											$leuN_checked= ($row->leucemia == "0") ? 'checked' : '';
											
											$linfoS_checked= ($row->linfomas != "0") ? 'checked' : '';
											$linfoN_checked= ($row->linfomas == "0") ? 'checked' : '';
											
											$sidaS_checked= ($row->sida != "0") ? 'checked' : '';
											$sidaN_checked= ($row->sida == "0") ? 'checked' : '';
											
											
											$tabacoS_checked = ($row->tabaco == "1") ? 'checked' : '';
											$tabacoN_checked = ($row->tabaco == "0") ? 'checked' : '';
											
											$htaS_checked = ($row->hta == "1") ? 'checked' : '';
											$htaN_checked = ($row->hta == "0") ? 'checked' : '';
											
											$alcoholS_checked = ($row->alcohol == "1") ? 'checked' : '';
											$alcoholN_checked = ($row->alcohol == "0") ? 'checked' : '';
											
											$cicS_checked = ($row->cardio_isquemia_cronica == "1") ? 'checked' : '';
											$cicN_checked = ($row->cardio_isquemia_cronica == "0") ? 'checked' : '';
											
											$dlS_checked = ($row->dislipemia == "1") ? 'checked' : '';
											$dlN_checked = ($row->dislipemia == "0") ? 'checked' : '';
											
											$hematoS_checked = ($row->enf_hemato_maligna == "1") ? 'checked' : '';
											$hematoN_checked = ($row->enf_hemato_maligna == "0") ? 'checked' : '';
											
											$cortiS_checked = ($row->corticoides == "1") ? 'checked' : '';
											$cortiN_checked = ($row->corticoides == "0") ? 'checked' : '';
											
											$inmunoS_checked = ($row->inmunosupr == "1") ? 'checked' : '';
											$inmunoN_checked = ($row->inmunosupr == "0") ? 'checked' : '';
											
											$antibiS_checked = ($row->atb_prev_ingreso == "1") ? 'checked' : '';
											$antibiN_checked = ($row->atb_prev_ingreso == "0") ? 'checked' : '';
											
											$ingresoS_checked = ($row->ingreso_prev == "1") ? 'checked' : '';
											$ingresoN_checked = ($row->ingreso_prev == "0") ? 'checked' : '';
											
											
										
											$mes_sem_ingreso = $row->ult_ingreso;
											$opciones_mes_sem = array(
												
												"Meses" => "Meses",
												"Semanas" => "Semanas",
												
											);
										
										
									?>
									    <div class="historia medica">
									       <b><span class="title">Factores de riesgo</span> </b> <p></p> <p></p>
											<div class="fields">
															
												<div class="form-group" >
													<div class="col">
														<label for = "age_pond" class="col-form-label">Edad:</label>
														
														<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
															
															<label class="btn btn-outline-primary"  id= "lbl50" for="btn50">
																<input type="radio" class="btn-check" name= "btn_edad" id= "btn50" value= "0" autocomplete="off" checked disabled> &lt;50 años <p></p></label>
															
															<label class="btn btn-outline-primary" id= "lbl50_59" for ="btn50_59">
															<input type="radio" class="btn-check" name= "btn_edad" id= "btn50_59" value= "1" autocomplete="off" disabled > 50-59 años <p></p></label>
															
															<label class="btn btn-outline-primary" id= "lbl60_69" for ="btn60_69">
															<input type="radio"  class="btn-check" name= "btn_edad" id= "btn60_69" value= "2" autocomplete="off" disabled > 60-69 años<p></p></label>
															
															<label class="btn btn-outline-primary" id= "lbl70_79" for="btn70_79">
															<input type="radio" class="btn-check" name= "btn_edad" id= "btn70_79" value= "3" autocomplete="off" disabled> 70-79 años<p></p></label>
															
															<label class="btn btn-outline-primary" id= "lbl80" for="btn80">
															<input type="radio" class="btn-check" name= "btn_edad" id= "btn80" value= "4" autocomplete="off" disabled> ≥80 años<p></p></label>
															
														</div>
														
													</div>
												</div>
															
												<fieldset class="border p-2">
												  <legend class="float-none w-auto" style ="font-size:20px;"> Cálculo del coeficiente de comorbilidad de Charlson </legend>
													<div class="container">
														
														<div class="form-group row">
															<div class="col-sm">
															  <legend class="col-form-label">Infarto de miocardio</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridInfarto" id="Infarto_mio_si" value="1" <?php echo $infartoS_checked; ?>>
																	  <label class="form-check-label" for="Infarto_mio_si"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridInfarto" id="Infarto_mio_no" value="0"<?php echo $infartoN_checked; ?>>
																	  <label class="form-check-label" for="Infarto_mio_no">No</label>
																	</div>
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Insuficiencia cardiaca congestiva</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridCardiac" id="cardiacS" value="1" <?php echo $cardiacS_checked; ?>>
																	  <label class="form-check-label" for="cardiacS"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridCardiac" id="cardiacN" value="0" <?php echo $cardiacN_checked; ?>>
																	  <label class="form-check-label" for="cardiacN">No</label>
																	</div>
																</div>
															</div>
															<div class="col-sm">
															  <legend class="col-form-label">Enfermedad vascular periférica</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridVasc" id="gridVasc1" value="1" <?php echo $vascS_checked; ?>>
																	  <label class="form-check-label" for="gridVasc1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridVasc" id="gridVasc0" value="0"<?php echo $vascN_checked; ?>>
																	  <label class="form-check-label" for="gridVasc0">No</label>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group row">
															<div class="col-sm">
															  <legend class="col-form-label">Enfermedad cerebrovascular</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridCerebro" id="gridCerebro1" value="1" <?php echo $cerebroS_checked; ?>>
																	  <label class="form-check-label" for="gridCerebro1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridCerebro" id="gridCerebro0" value="0"<?php echo $cerebroN_checked; ?>>
																	  <label class="form-check-label" for="gridCerebro0">No</label>
																	</div>
																</div>
															</div>
															<div class="col-sm">
															  <legend class="col-form-label">Demencia</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridDemencia" id="gridDemencia1" value="1" <?php echo $demenciaS_checked; ?>>
																	  <label class="form-check-label" for="gridDemencia1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridDemencia" id="gridDemencia0" value="0"<?php echo $demenciaN_checked; ?>>
																	  <label class="form-check-label" for="gridDemencia0">No</label>
																	</div>
																</div>
															</div>
															<div class="col-sm">
															  <legend class="col-form-label">Enfermedad pulmonar obstructiva crónica</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridEPOC" id="gridEPOC1" value="1" <?php echo $epocS_checked; ?>>
																	  <label class="form-check-label" for="gridEPOC1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridEPOC" id="gridEPOC0" value="0" <?php echo $epocN_checked; ?>>
																	  <label class="form-check-label" for="gridEPOC0">No</label>
																	</div>
																</div>
															</div>
															
														</div>
														<div class="form-group row">
															<div class="col-sm">
															  <legend class="col-form-label">Patología del tejido conectivo</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridConect" id="gridConect1" value="1" <?php echo $conectS_checked; ?>>
																	  <label class="form-check-label" for="gridConect1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridConect" id="gridConect0" value="0" <?php echo $conectN_checked; ?>>
																	  <label class="form-check-label" for="gridConect0">No</label>
																	</div>
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Patología hepática leve</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHepatL" id="gridHepatL1" value="1" <?php echo $hepaLS_checked; ?>>
																	  <label class="form-check-label" for="gridHepatL1">Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHepatL" id="gridHepatL0" value="0"<?php echo $hepaLN_checked; ?>>
																	  <label class="form-check-label" for="gridHepatL0">No</label>
																	</div>
																	
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Patología hepática moderada o grave</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHepatM" id="gridHepatM1" value="3" <?php echo $hepaMS_checked; ?>>
																	  <label class="form-check-label" for="gridHepatM1">Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHepatM" id="gridHepatM0" value="0" <?php echo $hepaMN_checked; ?>>
																	  <label class="form-check-label" for="gridHepatM0">No</label>
																	</div>
																	
																</div>
															</div>
														</div>
														<div class="form-group row">
															<div class="col-sm">
															  <legend class="col-form-label">Enfermedad ulcerosa</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridPept" id="gridPept1" value="1" <?php echo $peptS_checked; ?>>
																	  <label class="form-check-label" for="gridPept1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridPept" id="gridPept0" value="0" <?php echo $peptN_checked; ?>>
																	  <label class="form-check-label" for="gridPept0">No</label>
																	</div>
																</div>
															</div>
															
																
															<div class="col-sm">
															  <legend class="col-form-label">Diabetes mellitus</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridDiabetes" id="gridDiabetes1" value="1" <?php echo $dmS_checked; ?>>
																	  <label class="form-check-label" for="gridDiabetes1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridDiabetes" id="gridDiabetes0" value="0" <?php echo $dmN_checked; ?>>
																	  <label class="form-check-label" for="gridDiabetes0">No </label>
																	</div>
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Diabetes con lesión orgánica</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridDMlesion" id="gridDMlesion1" value="2" <?php echo $dmlesionS_checked; ?>>
																	  <label class="form-check-label" for="gridDMlesion1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridDMlesion" id="gridDMlesion0" value="0"<?php echo $dmlesionN_checked; ?>>
																	  <label class="form-check-label" for="gridDMlesion0">No</label>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group row">
													
															<div class="col-sm">
															  <legend class="col-form-label">Hemiplejia</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHemi" id="gridHemi1" value="2" <?php echo $hemiS_checked; ?>>
																	  <label class="form-check-label" for="gridHemi1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHemi" id="gridHemi0" value="0" <?php echo $hemiN_checked; ?>>
																	  <label class="form-check-label" for="gridHemi0">No</label>
																	</div>
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Patología renal(moderada o grave)</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridRenal" id="gridRenal1" value="2" <?php echo $renalS_checked; ?>>
																	  <label class="form-check-label" for="gridRenal1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridRenal" id="gridRenal0" value="0"<?php echo $renalN_checked; ?>>
																	  <label class="form-check-label" for="gridRenal0">No</label>
																	</div>
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Diagnóstico de tumor sólido</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridTumor" id="gridTumor1" value="2" <?php echo $tumorS_checked; ?>>
																	  <label class="form-check-label" for="gridTumor1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridTumor" id="gridTumor0" value="0" <?php echo $tumorN_checked; ?>>
																	  <label class="form-check-label" for="gridTumor0">No</label>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group row">
														
															<div class="col-sm">
															  <legend class="col-form-label">Tumor sólido con metástasis</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridMetas" id="gridMetas1" value="6" <?php echo $metasS_checked; ?>>
																	  <label class="form-check-label" for="gridMetas1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridMetas" id="gridMetas0" value="0" <?php echo $metasN_checked; ?>>
																	  <label class="form-check-label" for="gridMetas0">No</label>
																	</div>
																</div>
															</div>
																																											
															<div class="col-sm">
															  <legend class="col-form-label">Leucemia</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridLeu" id="gridLeu1" value="2" <?php echo $leuS_checked; ?>>
																	  <label class="form-check-label" for="gridLeu1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridLeu" id="gridLeu0" value="0" <?php echo $leuN_checked; ?>>
																	  <label class="form-check-label" for="gridLeu0">No</label>
																	</div>
																</div>
															</div>
															
															<div class="col-sm">
															  <legend class="col-form-label">Linfomas</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridLinfo" id="gridLinfo1" value="2" <?php echo $linfoS_checked; ?>>
																	  <label class="form-check-label" for="gridLinfo1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridLinfo" id="gridLinfo0" value="0" <?php echo $linfoN_checked; ?>>
																	  <label class="form-check-label" for="gridLinfo0">No</label>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group row justify-content-center">
													
															<div class="col-sm">
															  <legend class="col-form-label">Diagnóstico de SIDA</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridSIDA" id="gridSIDA1" value="6" <?php echo $sidaS_checked; ?>>
																	  <label class="form-check-label" for="gridSIDA1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridSIDA" id="gridSIDA0" value="0" <?php echo $sidaN_checked; ?>>
																	  <label class="form-check-label" for="gridSIDA0">No</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<p> <p>
												<div class="row justify-content-md-center">
													 <div class="col-md-center">
														<div class="card text-center" style="width: 18rem;">
															<div class="card-header">Charlson </div>
															<div class="card-body">
																<div class="fields"	>
																	<div class="row justify-content-md-center">
																		
																		 <div class="col-md-5">
																			
																			<input type="number" name="cci_pat"  class="form-control"  id="cci_pat"  style="text-align:center;" value="<?php echo $row->charlson;?>">
																		
																		</div>
																		
																	</div>
																</div>
															</div>
															<div class="card-footer">
																<button type="button" class="btn btn-primary btn-sm" id="btnCharlson" onclick="getCharlson()">Calcular</button>
															</div>
														</div>
													</div>
												</div>
												<fieldset class="border p-2">
												  <legend class="float-none w-auto" style ="font-size:15px;"> Otros factores relevantes</legend>
													<div class="container">
														<div class="form-group row">
															<div class="col-sm">		
															
															  <legend class="col-form-label">Hipertensión arterial</legend>
																<div class="col-sm">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHA" id="gridHA1" value="1"  <?php echo $htaS_checked; ?> >
																	  <label class="form-check-label" for="gridHA1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHA" id="gridHA0" value="0" <?php echo $htaN_checked; ?>>
																	  <label class="form-check-label" for="gridHA0">No</label>
																	</div>
																</div>
															</div>
															<div class="col-sm">
															  <legend class="col-form-label">Tabaquismo</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridTabaco" id="gridTabaco1" value="1" <?php echo $tabacoS_checked; ?> >
																	  <label class="form-check-label" for="gridTabaco1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridTabaco" id="gridTabaco0" value="0" <?php echo $tabacoN_checked; ?>>
																	  <label class="form-check-label" for="gridTabaco0">No</label>
																	</div>
																</div>
															</div>
															<div class="col-sm">
															  <legend class="col-form-label">Alcohol</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridAlcohol" id="gridAlcohol1" value="1" <?php echo $alcoholS_checked; ?>>
																	  <label class="form-check-label" for="gridAlcohol1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridAlcohol" id="gridAlcohol0" value="0" <?php echo $alcoholN_checked; ?>>
																	  <label class="form-check-label" for="gridAlcohol0">No</label>
																	</div>
																</div>
															</div>
														</div>
														<div class="form-group row">
															<div class="col-sm">
															  <legend class="col-form-label">Cardiopatia isquemica cronica</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridCIC" id="gridCIC1" value="1" <?php echo $cicS_checked; ?>>
																	  <label class="form-check-label" for="gridCIC1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridCIC" id="gridCIC0" value="0" <?php echo $cicN_checked; ?>>
																	  <label class="form-check-label" for="gridCIC0">No</label>
																	</div>
																</div>
															</div>
															<!-- <div class="col-sm">
															  <legend class="col-form-label">Arteriopatia periférica</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" checked>
																	  <label class="form-check-label" for="gridRadios1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0">
																	  <label class="form-check-label" for="gridRadios2">No</label>
																	</div>
																</div>
															</div> -->
															<div class="col-sm">
															  <legend class="col-form-label">Dislipemia</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridLP" id="gridLP1" value="1" <?php echo $dlS_checked; ?>>
																	  <label class="form-check-label" for="gridLP1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridLP" id="gridLP0" value="0" <?php echo $dlN_checked; ?>>
																	  <label class="form-check-label" for="gridLP0">No</label>
																	</div>
																</div>
															</div>
															
															<!-- <div class="col-sm">
															  <legend class="col-form-label">Enfermedad hepatológica crónica</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" checked>
																	  <label class="form-check-label" for="gridRadios1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0">
																	  <label class="form-check-label" for="gridRadios2">No</label>
																	</div>
																</div>
															</div> -->
															
															<div class="col-sm">
															  <legend class="col-form-label">Diagnóstico de enfermedad hematológica maligna</legend>
																<div class="col-sm-10">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHemato" id="gridHemato1" value="1" <?php echo $hematoS_checked; ?>>
																	  <label class="form-check-label" for="gridHemato1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridHemato" id="gridHemato0" value="0" <?php echo $hematoN_checked; ?>>
																	  <label class="form-check-label" for="gridHemato0">No</label>
																	</div>
																</div>
															</div>
														</div>
													</div>	
												</fieldset>
											</div>
											
											<br> </br>
											<div class="row justify-content-md-center">
												 <div class="col-md-center">
													<div class="card text-center" style="width: 18rem;">
														<div class="card-header">CFS</div>
														<div class="card-body">
															<div class="fields"	>
																<div class="row justify-content-md-center">
																	
																	 <div class="col-md-5">
																		
																		<input type="number" name="cfs_pat"  class="form-control"  id="cfs_pat"  style="text-align:center;" value="<?php echo $row->CFS;?>">
																	
																	</div>
																	
																</div>
															</div>
														</div>
														
													</div>
												</div>
											</div>
											<br> </br>
											<b><span class="title">Tratamientos previos</span> </b>
											<div class="fields"	>
												<fieldset class="form-row">
													<div class="form-group row">
														<div class="col">
													
														  <legend class="col-form-label">Corticoides</legend>
															<div class="col">
																<div class="form-check form-check-inline">
																  <input class="form-check-input" type="radio" name="gridCorticoides" id="gridCorticoides_1" value="1" <?php echo $cortiS_checked; ?>>
																  <label class="form-check-label" for="gridCorticoides_1"> Si</label>
																</div>
																<div class="form-check form-check-inline">
																  <input class="form-check-input" type="radio" name="gridCorticoides" id="gridCorticoides_0" value="0" <?php echo $cortiN_checked; ?>>
																  <label class="form-check-label" for="gridCorticoides_0">No</label>
																</div>
															</div>
														</div>
														
														<div class="col">
														  <legend class="col-form-label">Inmunosupresores</legend>
															<div class="col">
																<div class="form-check form-check-inline">
																  <input class="form-check-input" type="radio" name="gridInmuno" id="gridInmuno1" value="1" <?php echo $inmunoS_checked; ?>>
																  <label class="form-check-label" for="gridInmuno1"> Si</label>
																</div>
																<div class="form-check form-check-inline">
																  <input class="form-check-input" type="radio" name="gridInmuno" id="gridInmuno0" value="0" <?php echo $inmunoN_checked; ?>>
																  <label class="form-check-label" for="gridInmuno0">No</label>
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="col">
															  <legend class="col-form-label">¿Ha tomado antibioticos previamente al ingreso?</legend>
																<div class="col">
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridAntibio" id="gridAntibio1" value="1" <?php echo $antibiS_checked; ?>>
																	  <label class="form-check-label" for="gridAntibio1"> Si</label>
																	</div>
																	<div class="form-check form-check-inline">
																	  <input class="form-check-input" type="radio" name="gridAntibio" id="gridAntibio0" value="0" <?php echo $antibiN_checked; ?>>
																	  <label class="form-check-label" for="gridAntibio0">No</label>
																	</div>
																</div>
															</div>
														</div>
														
													</div>
												
													<div class="form-group row">
														<div class="col-sm">
														  <legend class="col-form-label">¿Ha ingresado previamente?</legend>
															<div class="col-sm">
																<div class="form-check form-check">
																  <input class="form-check-input" type="radio" name="gridPrevio" id="gridPrevio1" value="1" <?php echo $ingresoS_checked; ?>>
																  <label class="form-check-label" for="gridPrevio1"> Si</label>
																</div>
																<div class="form-check form-check">
																  <input class="form-check-input" type="radio" name="gridPrevio" id="gridPrevio0" value="0" <?php echo $ingresoN_checked; ?>>
																  <label class="form-check-label" for="gridPrevio0">No</label>
																</div>
															</div>
														</div>
														<div class="col-sm">
														  <legend class="col-form-label"> Último ingreso más reciente </legend>
															<div class="form-inline well">
																<div class="form-group">
																	 
																	<input type="text" name="cifra_previo" maxlength="2" class="form-control"  id="cifra_previo" value= "<?php echo $row->ult_ingreso_num ?>"onkeypress ="only_int_nums(event)">
																		
																	<div class="form-group">
																		<select name="mes_semana" id="mes_semana" form="carform"class="form-control">
																			<option value="">--Selecciona una opción--</option>
																			  <?php foreach ($opciones_mes_sem as $clave => $texto) : ?>
																					<option value="<?php echo $clave; ?>" <?php echo ($mes_sem_ingreso == $clave) ? "selected" : ""; ?>>
																						<?php echo $texto; ?>
																					</option>
																			   <?php endforeach; ?>
																			
																	  
																		</select>
																	</div>	
																</div>
															</div>
														</div>
													</div>
													
												</fieldset>
											</div>
												
										</div>
										<?php }?>
									</div>
									<?php
									
									// opciones de hallazgo clinico
										$query_1 = "SELECT * FROM clinical_finding";
										$resultado = $mysqli->query($query_1);

										// Verificar si se obtuvieron resultados
										if ($resultado->num_rows > 0) {
											// Generar las opciones a partir de los resultados de la consulta
											$opciones_clinica = array();
											
											while ($row = $resultado->fetch_object()) {
												$id = $row->cl_find_id;
												$nombre = $row->cl_find_name;
												$opciones_clinica[$id] = $nombre;
											}
										$opciones_clinica["0"] = "No aplica";
										} else {
											echo 'No se encontraron opciones.';
										}
										 
										$resultado->free();
									
										//opciones de micros
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
										
										
										// opciones de antibioticos
										$query_3 = "SELECT * FROM list_antibioticos";
										$resultado = $mysqli->query($query_3);

										// Verificar si se obtuvieron resultados
										if ($resultado->num_rows > 0) {
											// Generar las opciones a partir de los resultados de la consulta
											$opciones_antibio = array();
											
											while ($row = $resultado->fetch_object()) {
												$id = $row->ant_id;
												$nombre = $row->nombre_ant;
												$opciones_antibio[$id] = $nombre;
											}
										
										} else {
											echo 'No se encontraron opciones.';
										}
										 
										$resultado->free();
										
										$pat_id=$_GET['pat_id'];
										//$pat_index=intval($_GET['pat_index']);
										
										$query = "SELECT * FROM patients 
												  LEFT JOIN caso ON patients.pat_id= caso.case_pat_id
												  WHERE pat_id = ? ";
										$stmt= $mysqli->prepare($query) ;
										$stmt->bind_param('s', $pat_id);
										$stmt->execute() ;//ok
										$res=$stmt->get_result();
										
										while($row=$res->fetch_object())
										{
											
											$rol_paciente = ($row->pat_role == 'Caso') ? '1' : (($row->pat_role === "Control") ? '0' : "");

											
											
											$opciones_rol = array(
												"" => "--Selecciona un rol--",
												"0" => "Control",
												"1" => "Caso",
											);
											
											
											
											$cl_find_id = $row->cl_find_id;
											
											
											
											
											$tipologia_pat = $row->tipologia_pat;
											$opciones_tipologia = array(
												"0" => "No aplica",
												"Nosocomial" => "Nosocomial",
												"Comunitaria" => "Comunitaria",
												"Asociada a ccss" => "Asociada a cuidados sanitarios",
											);
											
											$pat_diag_ingreso = $row->pat_diag_ingreso;
											$opciones_diag = array(
												
												"0" => "No aplica",
												"Sepsis" => "Sepsis",
												"Shock séptico" => "Shock séptico",
												"Disfunción multiorgánica disociada" => "Disfunción multiorgánica disociada",
											);
											$foco_infecc = $row->foco_infecc;
											
											$opciones_infec = array(
												
												"0" => "No aplica",
												"Urinario" => "Urinario",
												"Abdominal" => "Abdominal",
												"Respiratorio" => "Respiratorio",
												"Osteomuscular" => "Osteomuscular",
												"Cardiaco" => "Cardiaco",
												"SNC" => "Sistema nervioso",
												"Catéter" => "Catéter",
												
											);
											$agent_etio = $row->agent_etio;
											$claves_permitidas = ['9999998', '79', '7'];
										}	
									?>
									
									<div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab"> <!-- DIAGNOSTICO -->
									  
											<fieldset class="border p-2">
											   <legend class="float-none w-auto font-weight-bold" style ="font-size:15px;">Categorización del paciente</legend>
												<div class= "form-row justify-content-around">
													
													<div class = "col-6">
														<label for="rol_pat" >Rol de estudio</label>
														<select name="rol_pat" id="rol_pat"  onclick="pick_patient_rol()" class="form-control" style="margin:10px;" style="width:80px;">
															<?php foreach ($opciones_rol as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>" <?php echo ($rol_paciente == $clave) ? "selected" : ""; ?>>
																	<?php echo $texto; ?>
																</option>
															<?php endforeach; ?>
														  
														  <!--<option value="selecciona">--Selecciona un rol--</option>
														  <option value="0">Control</option>
														  <option value="1">Caso</option> -->
																												  
														</select>
													</div>
													<div class = "col-6">
														<label for="tipologia_pat">Tipología</label>
														<select name="tipologia_pat" id="tipologia_pat"  class="form-control" style="margin:10px;">
														   <option value="">--Selecciona una opción--</option>
														  <?php foreach ($opciones_tipologia as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>" <?php echo ($tipologia_pat == $clave) ? "selected" : ""; ?>>
																	<?php echo $texto; ?>
																</option>
															<?php endforeach; ?>
														  
														</select>
													</div>
													
													
													<div class="w-100"></div>
													
													<div class = "col-6">
														<label for="id_clinica">Hallazgo clínico </label>
														<select name="id_clinica" id="id_clinica" class="form-control" style="margin:10px;">
														  
														   <option value="">--Selecciona una opción--</option>
														  <?php foreach ($opciones_clinica as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>" <?php echo ($cl_find_id == $clave) ? "selected" : ""; ?>>
																	<?php echo $texto; ?>
																</option>
															<?php endforeach; ?>
														  
														 </select>
													</div>
													<div class = "col-6">
														<label for="foco_inf_pat">Foco de infección</label>
														<select name="foco_inf_pat" id="foco_inf_pat" form="carform" class="form-control" style="margin:10px;">
														  
															 <option value="">--Selecciona una opción--</option>
														   <?php foreach ($opciones_infec as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>" <?php echo ($foco_infecc == $clave) ? "selected" : ""; ?>>
																	<?php echo $texto; ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>
													
													<div class="w-100"></div>
													
													<div class = "col-6">
														<label for="diag_ingreso">Diagnóstico de ingreso</label>
														<select name="diag_ingreso" required="" id="diag_ingreso" form="carform" class="form-control" style="margin:10px;">
														  
														   <option value="">--Selecciona una opción--</option>
														  <?php foreach ($opciones_diag as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>" <?php echo ($pat_diag_ingreso == $clave) ? "selected" : ""; ?>>
																	<?php echo $texto; ?>
																</option>
															<?php endforeach; ?>
														  
														</select>
													</div>
													<div class = "col-6">
														<label for="microorganismo">Agente(s) etiológico(s) </label>
														
														<!--<div class = "row-6"> -->
															<!--<input type="text" list="microorganismo" style="text-transform: uppercase;"/>-->
															<select name="microorganismo" id="microorganismo" form="microorganismo" class="form-control" style="margin:10px;">
															  
															   <option value="">--Selecciona una opción--</option>
															  <?php foreach ($opciones_micros as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>" <?php echo ($agent_etio == $clave) ? "selected" : ""; ?>>
																	<?php echo $texto; ?>
																</option>
															  <?php endforeach; ?>
															  
															</select>
															
															<span></span>
															
													</div>
													
													
													
												</div>
											</fieldset>
												<br></br>
												<fieldset class="border p-2">
												<?php
								
												$pat_id=$_GET['pat_id'];
												$id_dia= 1 ;
												$id_tipo_toma= 'estudio' ;
												//$pat_index=intval($_GET['pat_index']);
												
												$query_1= "SELECT SOFA,lactato FROM vars WHERE pat_id = ? AND id_dia = ?  AND id_tipo_toma = ? ";
												$stmt= $mysqli->prepare($query_1);
												$stmt->bind_param('sii', $pat_id, $id_dia,$id_tipo_toma);
												$stmt->execute();
												$stmt->bind_result($sofa_ingreso,$lactato_ingreso);
												$stmt->fetch();
												$stmt->close(); 
												
												
												
												$query = "SELECT * FROM manejo_inicial WHERE pat_id = ? ";
												$stmt= $mysqli->prepare($query) ;
												$stmt->bind_param('s', $pat_id);
												$stmt->execute() ;//ok
												$res=$stmt->get_result();
												
												$comentarios_micros="";
												
												while($row=$res->fetch_object())
												{
													
													$bacterS_checked = ($row->bacteriemia == "1") ? 'checked' : '';
													$bacterN_checked = ($row->bacteriemia == "0") ? 'checked' : '';
													
													$L6HS_checked = ($row->lactato_elimina == "1") ? 'checked' : '';
													$L6HN_checked = ($row->lactato_elimina== "0") ? 'checked' : '';
													
													$desescaladaS_checked = ($row->desescalada_72_antibio == "1") ? 'checked' : '';
													$desescaladaN_checked = ($row->desescalada_72_antibio== "0") ? 'checked' : '';
													
													$comentarios_micros = $row->comentarios_micros;
															
															
												?>
											   
												<legend class="float-none w-auto font-weight-bold" style ="font-size:15px;">Variables de ingreso en UCI</legend>
													<div class="form-row">	
														<div class="col">
															
															<label for="SOFAtot" class="col-form-label">SOFA </label>
															<div class="input-group"> 
																<input class="font-weight-bold" type="number" name="SOFAtot" class="form-control"  id="SOFAtot" placeholder="" value="<?php echo $sofa_ingreso; ?>">
																
															</div>
															
														<!-- los modales están al principio del body, se han recolocado ahí para evitar errores al abrir las ventanas emergentes-->
														
														</div>
														<div class="col">
															
															<label for="apacheii" class="col-form-label">APACHE II</label>
															<div class="input-group"> 
																<input  class="font-weight-bold" type="text" name="apacheii" class="form-control"  id="apacheii" placeholder="" onkeypress = "only_int_nums(event)" value="<?php echo $row->apache_2;?>">
																
															</div>
															<!-- modal --->
															
															 
																																											
														</div>
														<div class="col">
															
															<label for="lactato_ingreso" class="col-form-label">Lactato </label>
															<div class="input-group"> 
																<input class="font-weight-bold" type="number" name="lactato_ingreso" class="form-control"  id="lactato_ingreso" value="<?php echo $lactato_ingreso; ?>" placeholder="" >
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">mmol/L</span>
																</div>
															</div>
															
														<!-- los modales están al principio del body, se han recolocado ahí para evitar errores al abrir las ventanas emergentes-->
														
														</div>
														<div class="col">
														  <legend class="col-form-label"> Bacteriemia</legend>
															<div class="col-sm-10">
																<div class="form-check form-check-inline">
																  <input class="form-check-input" type="radio" name="gridBacter" id="gridBacter1" value="1" <?php echo $bacterS_checked; ?>>
																  <label class="form-check-label" for="gridBacter1"> Si</label>
																</div>
																<div class="form-check form-check-inline">
																  <input class="form-check-input" type="radio" name="gridBacter" id="gridBacter0" value="0" <?php echo $bacterN_checked; ?>>
																  <label class="form-check-label" for="gridBacter0">No</label>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
											
											
											<br></br>
											<div class="form-row">
												<div class="col">
													<fieldset class="border p-2">
													   
														<legend class="float-none w-auto font-weight-bold" style ="font-size:15px;">Manejo inicial</legend>
													
														<div class="fields">
													
															<div class="form-row">
																		
																<div class="col">
																	
																	<label for="ecocardio_fracc" class="col-form-label">Ecocardio Fracción de eyección</label>
																	<div class="input-group">
																		<input  type="text" name="ecocardio_fracc" class="form-control"  id="ecocardio_fracc" placeholder="%" onkeypress = "only_int_nums(event)" value="<?php echo $row->ecocardio_frac;?>">
																		<div class="input-group-append">
																			<span class="input-group-text" id="basic-addon2">%</span>
																		</div>
																	</div>
																</div>
																<div class="col">
																	
																	<label for="sat_venosa" class="col-form-label">Saturación venosa central</label>
																	<div class="input-group">
																		<input type="text" name="sat_venosa" class="form-control"  id="sat_venosa"  onkeypress = "only_int_nums(event)" value="<?php echo $row->sat_ven_central;?>">
																		<div class="input-group-append">
																			<span class="input-group-text" id="basic-addon2">%</span>
																		</div>
																	</div>
																</div>
																<div class="col">
																	
																	<label for="ecocardio_vena_cava" class="col-form-label">Ecocardio Vena Cava inferior</label>
																	<div class="input-group">
																		<input type="text" name="ecocardio_vena_cava" class="form-control"  id="ecocardio_vena_cava"  onkeypress = "only_int_nums(event)" value="<?php echo $row->ecocardio_ven_cava_inf;?>">
																		<div class="input-group-append">
																			<span class="input-group-text" id="basic-addon2">mm</span>
																		</div>
																	</div>
																</div>
																
															</div>
															
															<div class="form-row">
																		
																<div class="col">
																	<label for="cristaloides_pat" class="col-form-label">Cristaloides</label>
																	<div class="input-group">
																		<input type="text" name="cristaloides_pat" class="form-control"  id="cristaloides_pat" placeholder="" onkeypress = "only_int_nums(event)" value="<?php echo $row->cristaloides;?>">
																		<div class="input-group-append">
																			<span class="input-group-text" id="basic-addon2">mL</span>
																		</div>
																	</div>
																</div>
																<div class="col">
																	<label for="coloides_pat" class="col-form-label">Coloides</label>
																	<div class="input-group">
																		<input type="text" name="coloides_pat" class="form-control"  id="coloides_pat" placeholder="" onkeypress = "only_int_nums(event)" value="<?php echo $row->coloides; ?>">
																		<div class="input-group-append">
																			<span class="input-group-text" id="basic-addon2">mL</span>
																		</div>
																	</div>
																</div>
																<div class="col">
																	<label for="lactato_6h" class="col-form-label">Lactato 6h</label>
																	<div class="input-group">
																		<input  type="number" name="lactato_6h" class="form-control"  id="lactato_6h" placeholder="" step = "0.1" value="<?php echo $row->lactato_6h; ?>">
																		<div class="input-group-append">
																			<span class="input-group-text" id="basic-addon2">mmol/L</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-row">	
																<div class="form-group col-md-6">
																	  <legend class="col-form-label">¿Elimina el lactato pasadas 6 horas desde el ingreso?</legend>
																		<div class="col-sm-10">
																			<div class="form-check form-check-inline">
																			  <input class="form-check-input" type="radio" name="gridL6H" id="gridL6H1" value="1" <?php echo $L6HS_checked; ?>>
																			  <label class="form-check-label" for="gridL6H1"> Si</label>
																			</div>
																			<div class="form-check form-check-inline">
																			  <input class="form-check-input" type="radio" name="gridL6H" id="gridL6H0" value="0" <?php echo $L6HN_checked; ?>>
																			  <label class="form-check-label" for="gridL6H0">No</label>
																			</div>
																		</div>
																</div>
																
															</div>
																
																													
														</div>
														
													</fieldset>	
												</div>
												<?php } echo json_encode($comentarios_micros);?>
												
												<div class="col">
													<fieldset class="border p-2">
													<?php
													$query_1 = "SELECT `ant_id` FROM `antibioticos_usados` WHERE pat_id = ?";
													$stmt = $mysqli->prepare($query_1);
													$stmt->bind_param('s', $pat_id);
													$stmt->execute();
													$stmt->bind_result($antibio_id);
													$antibio_array = array(); // Array para almacenar los valores

													while ($stmt->fetch()) {
													  $antibio_array[] = $antibio_id; // Agregar los valores a la matriz
													}

													$stmt->close();
													?>
													   
														<legend class="float-none w-auto font-weight-bold" style ="font-size:15px;">Antibióticos</legend>
															<div class = "form-group">
																<label class="col-form-label" for="antibioticos_tto">Antibióticos usados</label>
																
																<select name="antibioticos_tto" id="antibioticos_tto" class="form-control select2" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
																  
																	    <?php foreach ($opciones_antibio as $clave => $texto) : ?>
																			<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $antibio_array)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																		  <?php endforeach; ?>
																				  
																	  
																  
																</select>
																
																<br></br>
																<br></br>
																
															</div >
															<div class="col">
																<legend class="col-form-label">Desescalada 72 horas</legend>
																
																<div class="form-check form-check">
																	  <input class="form-check-input" type="radio" name="gridDesescalada" id="gridDesescaladaN" value="0" <?php echo $desescaladaN_checked; ?>>
																	  <label class="form-check-label" for="gridDesescaladaN">No</label>
																</div>
																<div class="form-check form-check">
																  <input required class="form-check-input" type="radio" name="gridDesescalada" id="gridDesescaladaS" value="1" <?php echo $desescaladaS_checked; ?>>
																  <label class="form-check-label" for="gridDesescaladaS">Si</label>
																</div>
															</div>
															
														
														
													</fieldset>	
												</div>
											</div>
											<br></br>
											<fieldset class="border p-2">
											<?php
												$query_n_tests = "SELECT count(*) FROM micro_tests ";
												$stmt = $mysqli->prepare($query_n_tests);
												$stmt->execute();
												$stmt->bind_result($num_test);
												$stmt->fetch();
												$stmt->close();

												$pat_id = $_GET['pat_id'];
												
												$micros = [];

												$query = "SELECT * FROM microorganismos 
														  WHERE case_pat_id = ? AND test_id = ?";

												for ($test = 1; $test <= $num_test; $test++) {
													$stmt = $mysqli->prepare($query);
													$stmt->bind_param('si', $pat_id, $test);
													$stmt->execute();
													$res = $stmt->get_result();

													while ($row = $res->fetch_object()) {
														$micro = [];
														$micro['id'] = $test;
														$micro['values'] = $row->microorg_id;
														$micros[] = $micro;
													}
												}
												
												$hemo_pat= array();
												$traquea_pat= array();
												$ag_uri_pat= array();
												$abdomen_pat_micro= array();
												$cateter_pat= array();
												$lcr_pat= array();
												$urino_pat= array();
												$otros_pat= array();
												
												foreach ($micros as $micro) {
													switch ($micro['id']) {
														case 1:
														  $hemo_pat[] = $micro['values'];
														  break;
														  
														case 2:
														  $cateter_pat[] = $micro['values'];
														  break;
														  
														case 3:
														  $lcr_pat[] = $micro['values'];
														  break;
														  
														case 4:
														  $abdomen_pat_micro[] = $micro['values'];
														  break;
														  
														case 5:
														  $traquea_pat[] = $micro['values'];
														  break;
														  
														case 6:
														  $ag_uri_pat[] = $micro['values'];
														  break;
														  
														case 7:
														  $urino_pat[] = $micro['values'];
														  break;
														  
														case 8:
														  $otros_pat[] = $micro['values'];
														  break;
														  
														
														
													}
												}
											?>	
											   
												<legend class="float-none w-auto font-weight-bold" style ="font-size:15px;">Microbiología de ingreso</legend>
												<div class="form-row">
													<div class = "col-6">
														<label for="hemo_pat">Hemocultivos</label> 
														<input style="display: none"type="number" name="hemo_id" class="form-control"  id="hemo_id" value= 1>
														<div class="campos-wrapper">
															<select name="hemo_pat" id="hemo_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															     <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $hemo_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															  
															  
															</select>
														</div>
													</div>
													<br></br>
													<div class = "col-6">
														<label for="traquea_pat">Aspirado traqueal / Esputo</label>
														<input type="number" style="display: none"name="traquea_id" class="form-control"  id="traquea_id" value= 5>
														
														<div class="campos-wrapper">
															<select name="traquea_pat" id="traquea_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															  <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $traquea_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															</select>
														</div>
														
													</div>
													<br></br>
													<div class = "col-6">
														<label for="ag_uri_pat">AG Urinarios</label>
														<input type="number" style="display: none"name="ag_id" class="form-control"  id="ag_id" value= 6>
														<div class="campos-wrapper">
															<select name="ag_uri_pat" id="ag_uri_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															   
															   <?php foreach ($opciones_micros as $clave => $texto) : ?>
																<?php if (in_array($clave, $claves_permitidas)) : ?>
																  <option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $ag_uri_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																<?php endif; ?>
															  <?php endforeach; ?>
															  
															  

															</select>
														</div>
														
													</div>
													<br></br>
													<div class = "col-6">
														<label for="abdomen_pat_micro">Abdomen</label>
														<input type="number" style="display: none"name="abdomen_id" class="form-control"  id="abdomen_id" value= 4>
														<div class="campos-wrapper">
															<select name="abdomen_pat_micro" id="abdomen_pat_micro" class="form-control select2" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															  <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $abdomen_pat_micro)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															</select>
														</div>
														
													</div>
													<br></br>
													<div class = "col-6">
														<label for="cars">Catéter</label>
														<input type="number" style="display: none" name="cateter_id" class="form-control"  id="cateter_id" value= 2>
														<div class="campos-wrapper">
															<select name="cateter_pat" id="cateter_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															  <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $cateter_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															</select>
														</div>
														
													</div>
													<br></br>
													<div class = "col-6">
														<label for="lcr_pat">LCR</label>
														<input type="number" style="display: none" name="lcr_id" class="form-control"  id="lcr_id" value= 3>
														<div class="campos-wrapper">
															<select name="lcr_pat" id="lcr_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															   <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $lcr_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															</select>
														</div>
														
													</div>
													<br></br>
													<div class = "col-6">
														<label for="urino_pat">Urinocultivos</label>
														<input type="number" style="display: none" name="urino_id" class="form-control"  id="urino_id" value= 7>
														<div class="campos-wrapper">
															<select name="urino_pat" id="urino_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															  <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $urino_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
															<?php endforeach; ?>
															</select>
														</div>
														
													</div>
													<br></br>
													<div class = "col-6">
														<label for="otros_id">Otros</label>
														<input type="text" style="display: none" name="otros_id" class="form-control"  id="otros_id" value =8>
														<input type="text" style="text-transform: uppercase; display:none" name="otros_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" id="otros_name">
														<div class="campos-wrapper">
															<select name="otros_pat" id="otros_pat" class="form-control select2 select2-dinamico" style="margin:10px;" multiple="multiple" data-placeholder="Selecciona uno o varios">
															  <?php foreach ($opciones_micros as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>" <?php echo (in_array($clave, $otros_pat)) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															</select>
														</div>
														
													</div>
												</div>
																							
											</fieldset>	
											
											<br> </br>
											
											<div class="form-group">
											  <label for="comentarios_micros">Anotaciones:</label>
											  <textarea id= "comentarios_micros" class="form-control" rows="5" id="comentarios_micros" maxlength="200" spellcheck="true"><?php echo $comentarios_micros;?></textarea>
											</div>
											
											
									</div>
									
									<div class="tab-pane fade" id="step4" role="tabpanel" aria-labelledby="step4-tab"> <!-- TTO -->
									
									    <fieldset class="border p-4" id= "tto_paciente">
										
										<?php
									
											$pat_id=$_GET['pat_id'];
											$id_dia=1;
																														
											$query = "SELECT * FROM tto_terapia WHERE pat_id = ? AND id_dia =?";
											$stmt= $mysqli->prepare($query) ;
											$stmt->bind_param('si', $pat_id, $id_dia);
											$stmt->execute() ;//ok
											$res=$stmt->get_result();
											
											while($row=$res->fetch_object())
											{
												$VM_checked = ($row->VM == 1) ? 'checked' : '';
												$TRRC_checked = ($row->TRRC == 1) ? 'checked' : '';
												$DVA_checked = ($row->DVA == 1) ? 'checked' : '';
												
											
											
										
										?>
											<legend class="float-none w-auto" style ="font-size:20px;">Tratamientos</legend>
												
												<b><span class="title">Introduzca los datos</span> </b>
												<br></br>
												<div class="col-sm-2 float-right">
													<div class="row">
														
													</div>
												</div>
												<br></br>
												<div class="row" id="div_tto_ingreso">
														 <div class="text-center">
															<fieldset style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
															box-shadow: 0 0 10px #666; background:#e8f5e9">
																<legend class=" legendCustom float-none w-auto">Día</legend>
																	<div class="form-row">
																		<div class="col">
																			
																			<select name="dia_tto" id="dia_tto" class="form-control" style="margin-right:10px;">
																				<option value="1">1</option>
																			</select>  
																		</div>
																		
																	</div>
															</fieldset>
														</div>
														<div class = "d-flex flex-row">
														
															<div class = "col" style="margin-left: 30px; margin-top: 30px;">
																<div class = "row">	
																	<div class = "form-group">	
																	 <div class="myTest custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="VM_check_ingreso" name="VM_check_ingreso" <?php echo $VM_checked; ?> />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="VM_check_ingreso">VM</label>
																	  </div>
																	  
																	  <div class="myTest custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="TRRC_check_ingreso" name="TRRC_check_ingreso"  <?php echo $TRRC_checked; ?>/>
																		<label class="custom-control-label" style="color:black; font-size:15px" for="TRRC_check_ingreso">TRRC</label>
																	  </div>
																	  
																	  <div class="myTest custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="DVA_check_ingreso" name="DVA_check_ingreso"  <?php echo $DVA_checked; ?>/>
																		<label class="custom-control-label" style="color:black; font-size:15px" for="DVA_check_ingreso">DVA</label>
																	  </div>
																	</div>	
																</div>	
															</div>
															
																<br></br>
															<fieldset class="border p-2"style="margin-left: 30px; margin-top: -10px;">
																<legend class="float-none w-auto" style ="font-size:15px;">Nº de días en:</legend>
																<div class = "form-group">
																	<div class = "row">	
																		 <div class="col-md" id="VM_val">
																			<label for="VM_pat_val" class="col-form-label text-right">VM</label>
																			<input type="number" name="VM_pat_val_ingreso" class="form-control" id="VM_pat_val_ingreso" style="width:80px" value="<?php echo $row->VM_dias; ?>">
																		  </div>
																		  <div class="col-md" id="TRRC_val">
																			<label for="TRRC_pat_val" class="col-form-label text-right">TRRC</label>
																			<input type="number" name="TRRC_pat_val_ingreso" class="form-control" id="TRRC_pat_val_ingreso" style="width:80px" value="<?php echo $row->TRRC_dias; ?>">
																		  </div>
																		  <div class="col-md"  id="DVA_val">
																			<label for="DVA_pat_val" class="col-form-label text-right">DVA</label>
																			<input type="number" name="DVA_pat_val_ingreso" class="form-control" id="DVA_pat_val_ingreso" style="width:80px" value="<?php echo $row->DVA_dias; ?>">
																		  </div>
																	</div>
																 </div>	
															</fieldset>
																
															
														</div>
													
												<br></br>
													
													
												</div> 
												<br></br>
												<?php }?>
												
												<div class="row" id="tto_previos_guardados" name="tto_previos_guardados">
												
												
												</div>
												<br></br>
												
												
												
													
												
												
												<!-- Contenedor de los divs clonados -->
												<div id="contenedorDivsClonados"></div>
												
												
												
											
										
										</fieldset>
										<fieldset class="border p-4">
											<legend class="float-none w-auto" style ="font-size:20px;"> Toma de datos</legend>
												
													
													<div class="col-sm-2 float-right">
														<button type="button" class="btn btn-success" style="border-radius: 4px;" id="actualizar_botones" onclick="update_btns()">Actualizar</button>
													</div>
												
											   <b><span class="title">Selecciona el dia de la toma de datos</span> </b>
											   <br></br>
											    <fieldset class="border p-2">
												<legend class="float-none w-auto" style ="font-size:15px;"> Días preUCI</legend>
											
													<div class="d-grid gap-2">
															
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder" style="visibility:hidden">
																	<div class="checkdiv grey400">
																		<input  type="checkbox" class="le-checkbox" id="dia_ingreso_hosp_estado" name="dia_ingreso_hosp_estado" 
																		/>
																	</div>
																</div>
															
															</div>
															
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-secondary btn-lg col-12" style="margin:10px;"  id="btndia_ingreso_hosp" 
																>Ingreso hospitalario</button>
															</div>
														</div>
														<div class="form-inline well col">
															<div class="form-group">
																<div class="holder" style="visibility:hidden">
																	<div class="checkdiv grey400">
																		<input  type="checkbox" class="le-checkbox" id="dia_preuci_estado" name="dia_preuci_estado" 
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-secondary btn-lg col-12" style="margin:10px;"  id="btndia_preuci" 
																>Día anterior al ingreso en UCI</button>
															</div>
														</div>
														<div class="form-inline well col">
															<div class="form-group">
																<div class="holder" style="visibility:hidden">
																	<div class="checkdiv grey400">
																		<input  type="checkbox" class="le-checkbox" id="dia_otro_preuci_estado" name="dia_otro_preuci_estado" 
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;" >
																<button type="button" class="btn btn-secondary btn-lg col-12" style="margin:10px;"  id="btndiaotro_preuci" 
																>Otro</button>
															</div>
														</div>
													</div>
											   </fieldset>
											   <br></br>
											   <fieldset class="border p-2">
												<?php
													
													$pat_id = $_GET['pat_id'];
													$id_tipo_toma ='estudio';
													$pacienteData = array();

													
													
													$query_checks = "SELECT  `id_dia`,`status_dia` FROM `vars` WHERE `pat_id`= ? AND `id_tipo_toma`= ? ";
													$stmt = $mysqli->prepare($query_checks);
													$stmt->bind_param('ss', $pat_id, $id_tipo_toma);
													$stmt->execute();
													$res = $stmt->get_result();

														while ($row = $res->fetch_object()) {
															$id_dia = $row->id_dia;
															$status_dia = $row->status_dia;

															// Agrega los valores al array pacienteData
															$pacienteData[$id_dia] = $status_dia;
															
														}	
													
													
													$pacienteDataJson = json_encode($pacienteData);
													
												?>
											   
												<legend class="float-none w-auto" style ="font-size:15px;"> Días de estudio</legend>
												<div class="col-1 float-right">
													<button type="button" class="btn btn-sm btn-info" data-toggle="popover" title="Información" 
													data-content="Los días estudio del paciente se inician cuando este ingresa en UCI, no obstante los días de toma de datos no tienen porque corresponder a que este siga ingresado en UCI."
													>i</button>
												</div>
												
												
													<div class="d-grid gap-2">
															
														
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder">
																	<div class="checkdiv grey400">
																		<input type="checkbox" class="le-checkbox" id="dia1_estado" name="dia1_estado"
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btndia1" 
																>Ingreso (1er día) </button>
															</div>
														</div>
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder">
																	<div class="checkdiv grey400">
																		<input type="checkbox" class="le-checkbox" id="dia3_estado" name="dia3_estado"
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
														
																<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btndia3" 
																>3er día</button>
															</div>
														</div>
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder">
																	<div class="checkdiv grey400">
																		<input type="checkbox" class="le-checkbox" id="dia5_estado" name="dia5_estado"
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btndia5" 
																>5to día</button>
															</div>
														</div>
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder">
																	<div class="checkdiv grey400">
																		<input type="checkbox" class="le-checkbox" id="dia7_estado" name="dia7_estado"
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btndia7" 
																>7to día</button>
															</div>
														</div>
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder">
																	<div class="checkdiv grey400">
																		<input type="checkbox" class="le-checkbox" id="dia14_estado" name="dia14_estado"
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btndia14" 
																>14to día</button>
															</div>
														</div>
														<div class="form-inline well col">
															
															<div class="form-group">
																<div class="holder" style="visibility:hidden">
																	<div class="checkdiv grey400">
																		<input type="checkbox" class="le-checkbox" id="diaOtro_estado" name="diaOtro_estado"
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btndiaOtro" 
																>Otro</button>
															</div>
														</div>
															<!--<button class="btn btn-success" type="button" onclick=" window.open('his_patient_ingreso.php','_blank')"> Google</button>-->
															
															<!--<a class="btn btn-primary" href="his_patient_ingreso.php" role="button" target="_blank" rel="noopener noreferrer" id="btnIngreso" >Link</a> -->
													</div>
												</fieldset>	
												<br></br>
											    <!--<fieldset class="border p-2">
												<legend class="float-none w-auto" style ="font-size:15px;"> Días postUCI</legend>
											
													<div class="d-grid gap-2">
															
														<div class="form-inline well">
															
															<div class="form-group">
																<div class="holder" style="visibility:hidden">
																	<div class="checkdiv grey400" >
																		<input  type="checkbox" class="le-checkbox" id="dia_otro_postuci_estado" name="dia_otro_postuci_estado" 
																		/>
																	</div>
																</div>
															
															</div>
															<div class="form-group" style="width:80%;">
																<button type="button" class="btn btn-info btn-lg col-12" style="margin:10px;"  id="btndiaotro_postuci" 
																>Otro</button>
															</div>
														</div>
													</div>
											   </fieldset>-->
											   <br></br>
												
										 </fieldset>
									
									</div>
									<div class="tab-pane fade" id="step5" role="tabpanel" aria-labelledby="step5-tab"> <!-- TTO -->
									
									    <fieldset class="border p-2">
											<legend class="float-none w-auto" style ="font-size:20px;"> Seguimiento del paciente</legend>
											   <b><span class="title">Selecciona el periodo de seguimoento</span> </b>
											
												<div class="d-grid gap-2">
											
														<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btn3m" 
														>3 meses</button>
														
														<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btn6m" 
														>6 meses</button>
														
														<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btn12m" 
														>1 año</button>
														
														<button type="button" class="btn btn-primary btn-lg col-12" style="margin:10px;"  id="btnSegOtro" 
														>Otro</button>
														
														<!--<a class="btn btn-primary" href="his_patient_ingreso.php" role="button" target="_blank" rel="noopener noreferrer" id="btnIngreso" >Link</a>-->
												</div>
											
											
										 </fieldset>
									
									</div>
									
									
									<!-- Monitorización variables -->
									<div class="tab-pane fade" id="step6" role="tabpanel" aria-labelledby="step6-tab"> 
									
										
									    <div class="col" style="display:none">
											<label for="cont_saves" class="col-form-label">Contador de guardados</label>
											<input type="number"  name="cont_saves" class="form-control" id="cont_saves" value=0 readonly>
											
										</div>								
										
									</div>		
											
											
								</div>
								
								
								<br> </br>
								<br> </br>
								<div class="row justify-content-between">
									<div class="col-auto"><button type="button" class="btn btn-secondary" data-enchanter="previous">Anterior</button></div>
									<div class="col-auto">
									  <input type="hidden" name="hidden_field" id="hidden_field" value="form_check">
									  <button type="button" class="btn btn-primary" data-enchanter="next" onclick="save()" >Siguiente</button>
									  
									  <button type="submit" name= "add_patient" id="add_patient" class=" ladda-button btn btn-success"  data-enchanter="finish">Fin</button>
									</div>
								</div>
								<div class="row" id="div_tto_otros_principal" style="visibility:hidden; margin-bottom: 20px; margin-right: 30px;">
														 <div class="text-center">
															<fieldset style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
															box-shadow: 0 0 10px #666; background:#e8f5e9">
																<legend class=" legendCustom float-none w-auto">Día</legend>
																	
																	<div class="form-row">
																		<div class="col">
																			
																			<select name="dia_tto_otros" id="dia_tto_otros" class="form-control" style="margin-right:10px;">
														  
																			   <option value="">Elija</option>
					
																				<?php
																				
																				// Consulta para obtener los días guardados
																				
																				
																					$pat_id=$_GET['pat_id'];
										
																					$query = "SELECT id_dia FROM tto_terapia WHERE pat_id=?";
																					$stmt= $mysqli->prepare($query) ;
																					$stmt->bind_param('s', $pat_id);
																					$stmt->execute() ;//ok
																					$res = $stmt->get_result();
																					
																					$diasGuardados = array();

																					if ($res->num_rows > 0) {
																						while ($row = $res->fetch_assoc()) {
																							$diasGuardados[] = $row["id_dia"];
																						}
																					}
																				
																				for ($i = 2; $i <= 28; $i++) {
																					if (!in_array($i, $diasGuardados)) {
																						echo '<option value="' . $i . '">' . $i . '</option>';
																					}
																				}
																				?>
																				  
																			</select> 
																		</div>
																		
																	</div>
															</fieldset>
														</div>
														<div class = "d-flex flex-row">
														
															<div class = "col" style="margin-left: 30px; margin-top: 30px;">
																<div class = "row">	
																	<div class = "form-group">	
																	 <div class="myTest custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="VM_check_otros" name="VM_check_otros" />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="VM_check_otros">VM</label>
																	  </div>
																	  
																	  <div class="myTest custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="TRRC_check_otros" name="TRRC_check_otros" />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="TRRC_check_otros">TRRC</label>
																	  </div>
																	  
																	  <div class="myTest custom-control custom-checkbox col">
																		<input type="checkbox" class="custom-control-input" id="DVA_check_otros" name="DVA_check_otros" />
																		<label class="custom-control-label" style="color:black; font-size:15px" for="DVA_check_otros">DVA</label>
																	  </div>
																	</div>	
																</div>	
															</div>
															
																
																<fieldset class="border p-2"style="margin-left: 30px; margin-top: -10px;">
																	<legend class="float-none w-auto" style ="font-size:15px;">Nº de días en:</legend>
																	<div class = "form-group">
																		<div class = "row">	
																			 <div class="col-md"style="display: none" id="VM_val_otros">
																				<label for="VM_val_otros" class="col-form-label text-right">VM</label>
																				<input type="number" name="VM_val_otros" class="form-control" id="VM_val_otros" style="width:80px" >
																			  </div>
																			  <div class="col-md" style="display: none" id="TRRC_val_otros">
																				<label for="TRRC_val_otros" class="col-form-label text-right">TRRC</label>
																				<input type="number" name="TRRC_val_otros" class="form-control" id="TRRC_val_otros" style="width:80px" >
																			  </div>
																			  <div class="col-md" style="display: none" id="DVA_val_otros">
																				<label for="DVA_val_otros" class="col-form-label text-right">DVA</label>
																				<input type="number" name="DVA_val_otros" class="form-control" id="DVA_val_otros" style="width:80px" >
																			  </div>
																		</div>
																	 </div>	
																</fieldset>
																
															
														</div>
														
												<br></br>
														
												<br></br>		
												</div>
								
								
							</form>
						</div> 
					</div> <!-- content -->
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
  <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
 
  
  <!-- JavaScript for validations only -->
  
  <!-- Our script! :) -->
  
  <script src="assets/dist/enchanter.js"></script>
  
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>-->
  
 
 <script>
		
		var	pat_id = document.querySelector("#pat_number").value;
		
		
	  </script>
  
  
 <script>
	 document.addEventListener('DOMContentLoaded', function() {
		 
		var pat_id = '<?php echo $_GET["pat_id"]; ?>';
	
		$.ajax({
			url: 'assets/inc/get_datos_tto.php',
			method: 'POST',
			data: { pat_id: pat_id },
			dataType: 'json',
			success: function(response) {
				
				var res = response;
				console.log(res)
				
				var html = '';

				res.datos.forEach(function(dato) {
					  var id_dia = dato.id_dia;
					  var dva = dato.DVA;
					  var dva_dias = dato.DVA_dias;
					  var trrc = dato.TRRC;
					  var trrc_dias = dato.TRRC_dias;
					  var vm = dato.VM;
					  var vm_dias = dato.VM_dias;

					  var divId = 'div_previos_tto' + id_dia;
					  var vmCheckId = 'VM_check_otros' + id_dia;
					  var trrcCheckId = 'TRRC_check_otros' + id_dia;
					  var dvaCheckId = 'DVA_check_otros' + id_dia;
					  var vmValId = 'VM_val_otros' + id_dia;
					  var trrcValId = 'TRRC_val_otros' + id_dia;
					  var dvaValId = 'DVA_val_otros' + id_dia;
						
					  html += '<br>';
					  html += '<div class="row" id="' + divId + '" style="margin-bottom: 20px; margin-right: 30px;">';
					  html += '<div class="text-center" >';
					  html += '  <fieldset style="padding:14px; border:3px solid #7e57c2; border-radius: 8px; box-shadow: 0 0 10px #666; background:#d1c4e9">';
					  html += '    <legend class="legendRemember float-none w-auto">Día</legend>';
					  html += '    <div class="form-row">';
					  html += '      <div class="col">';
					  html += '        <select name="dia_tto_otros_' + id_dia + '" id="dia_tto_otros_' + id_dia + '" class="form-control" style="margin-right:10px;">';
					  html += '          <option value="' + id_dia + '">' + id_dia + '</option>';
					  html += '        </select>';
					  html += '      </div>';
					  html += '    </div>';
					  html += '  </fieldset>';
					  html += '</div>';

					  html += '<div class="d-flex flex-row">';
					  html += '  <div class="col" style="margin-left: 30px; margin-top: 30px;">';
					  html += '    <div class="row">';
					  html += '      <div class="form-group">';
					  html += '        <div class="myTest custom-control custom-checkbox col">';
					  html += '          <input type="checkbox" class="custom-control-input" id="' + vmCheckId + '" name="' + vmCheckId + '" ' + (vm === 1 ? 'checked' : '') + ' />';
					  html += '          <label class="custom-control-label" style="color:black; font-size:15px" for="' + vmCheckId + '">VM</label>';
					  html += '        </div>';
					  html += '        <div class="myTest custom-control custom-checkbox col">';
					  html += '          <input type="checkbox" class="custom-control-input" id="' + trrcCheckId + '" name="' + trrcCheckId + '" ' + (trrc === 1 ? 'checked' : '') + ' />';
					  html += '          <label class="custom-control-label" style="color:black; font-size:15px" for="' + trrcCheckId + '">TRRC</label>';
					  html += '        </div>';
					  html += '        <div class="myTest custom-control custom-checkbox col">';
					  html += '          <input type="checkbox" class="custom-control-input" id="' + dvaCheckId + '" name="' + dvaCheckId + '" ' + (dva === 1 ? 'checked' : '') + ' />';
					  html += '          <label class="custom-control-label" style="color:black; font-size:15px" for="' + dvaCheckId + '">DVA</label>';
					  html += '        </div>';
					  html += '      </div>';
					  html += '    </div>';
					  html += '  </div>';
					  html += '  <fieldset class="border p-2" style="margin-left: 30px; margin-top: -10px;">';
					  html += '    <legend class="float-none w-auto" style="font-size:15px;">Nº de días en:</legend>';
					  html += '    <div class="form-group">';
					  html += '      <div class="row">';
					  html += '        <div class="col-md"  id="' + vmValId + '">';
					  html += '          <label for="' + vmValId + '" class="col-form-label text-right">VM</label>';
					  html += '          <input type="number" name="' + vmValId + '" class="form-control" id="' + vmValId + '" style="width:80px" value="' + vm_dias + '">';
					  html += '        </div>';
					  html += '        <div class="col-md"  id="' + trrcValId + '">';
					  html += '          <label for="' + trrcValId + '" class="col-form-label text-right">TRRC</label>';
					  html += '          <input type="number" name="' + trrcValId + '" class="form-control" id="' + trrcValId + '" style="width:80px" value="' + trrc_dias + '">';
					  html += '        </div>';
					  html += '        <div class="col-md"  id="' + dvaValId + '">';
					  html += '          <label for="' + dvaValId + '" class="col-form-label text-right">DVA</label>';
					  html += '          <input type="number" name="' + dvaValId + '" class="form-control" id="' + dvaValId + '" style="width:80px" value="' + dva_dias + '">';
					  html += '        </div>';
					  html += '      </div>';
					  html += '    </div>';
					  html += '  </fieldset>';
					  html += '</div>';
					  html += '</div>';
					  html += '<br>';
					   
					});

					$('#tto_previos_guardados').html(html);
					
					console.log('Datos de tto recuperados')
				  },
			error: function() {
				// Manejar errores si ocurre alguno durante la solicitud AJAX
			}
		});
	});
	  
	  
</script>

<script>
	$(document).ready(function() {
	  // Manejar el clic en el botón de eliminar
	  $(document).on('click', '.eliminarDia', function() {
		// Obtener el ID del día a eliminar
		var idDia = $(this).data('id');
		
		var pat_id = '<?php echo $_GET["pat_id"]; ?>';
		
		// Confirmar la eliminación
		if (confirm('¿Estás seguro de que deseas eliminar este día?')) {
		  // Realizar la solicitud AJAX para eliminar el día de la base de datos
		  $.ajax({
			url: 'assets/inc/eliminar_dia.php', // Ruta al script PHP que elimina el día
			method: 'POST',
			data: { idDia: idDia, pat_id: pat_id }, // Enviar el ID del día al script PHP
			success: function(response) {
			  // Eliminar el div del día de la interfaz
			  $('#div_dia_' + idDia).remove();
			  // Mostrar mensaje de éxito o realizar otras acciones necesarias
			  alert('El día se ha eliminado correctamente.');
			},
			error: function(xhr, status, error) {
			  // Manejar errores de la solicitud AJAX
			  console.error(error);
			  alert('Ocurrió un error al eliminar el día.');
			}
		  });
		}
	  });
	});
</script>
<script>
    window.addEventListener('beforeunload', function(e) {
		delete_all_localStore();
      // Cancela el evento de cierre para que la alerta se muestre
      e.preventDefault();
      // La siguiente línea es opcional, pero muestra un mensaje personalizado
      e.returnValue = '¿Estás seguro de que deseas salir de esta página?';
    });
  </script>
  
  <script>
  
		const btndia_ingreso_hosp = document.getElementById("btndia_ingreso_hosp");
		btndia_ingreso_hosp.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso === "" && date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				//window.open('his_patient_dia_ingreso_hosp.php?pat_id=' + encodeURIComponent(pat_id) + '&id_tipo_toma=HOSP' + '&id_dia=0','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=1' + '&id_tipo_toma=HOSP','_blank');return false;
			}
			
		  
		});
		const btndia_preuci = document.getElementById("btndia_preuci");
		btndia_preuci.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso === "" && date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				//window.open('his_patient_dia_preuci.php?pat_id=' + encodeURIComponent(pat_id) + '&id_tipo_toma=preUCI' + '&id_dia=1','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=1' + '&id_tipo_toma=preUCI','_blank');return false;
			}
			
		  
		});
		const btnotro_preuci = document.getElementById("btndiaotro_preuci");
		btnotro_preuci.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso === "" && date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_tipo_toma=preUCI' + '&id_dia=','_blank');return false;
			}
			
		  
		});
	//////////////
	// UCI
	//////////////
		/* const btnIngreso = document.getElementById("btndiaIngreso");
		btnIngreso.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso === "" && date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
			} else{
				
				//window.open('his_patient_ingreso.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=0' + '&id_tipo_toma=estudio','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=0' + '&id_tipo_toma=estudio','_blank');return false;
			}
			
		  
		}); */
		
		const btnd1 = document.getElementById("btndia1");
		btnd1.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				 //window.open('his_patient_dia1.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=1' + '&id_tipo_toma=estudio','_blank');return false;
				 window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=1' + '&id_tipo_toma=estudio','_blank');return false;
			}
			
		  
		});
		
		const btnd3 = document.getElementById("btndia3");
		btnd3.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				//window.open('his_patient_dia3.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=3' + '&id_tipo_toma=estudio','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=3' + '&id_tipo_toma=estudio','_blank');return false;
			}
			
		  
		});
		
		const btnd5 = document.getElementById("btndia5");
		btnd5.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso === "" && date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				//window.open('his_patient_dia5.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=5' + '&id_tipo_toma=estudio','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=5' + '&id_tipo_toma=estudio','_blank');return false;
			}
			
		  
		});
		
		const btnd7 = document.getElementById("btndia7");
		btnd7.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				//window.open('his_patient_dia7.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=7' + '&id_tipo_toma=estudio','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=7' + '&id_tipo_toma=estudio','_blank');return false;
			}
			
		  
		});
		
		const btnd14 = document.getElementById("btndia14");
		btnd14.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
				$("#date_ingreso").addClass("campo-naranja");
				$("#date_ingreso_uci").addClass("campo-naranja");
			} else{
				
				//window.open('his_patient_dia14.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=14' + '&id_tipo_toma=estudio','_blank');return false;
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=14' + '&id_tipo_toma=estudio','_blank');return false;
			}
			
		  
		});
		
		const btnotro = document.getElementById("btndiaOtro");
		btnotro.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_ingreso = $("#date_ingreso").val();
			var date_ingreso_uci = $("#date_ingreso_uci").val();

			if (date_ingreso_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de ingreso antes de continuar", "warning");
			} else{
				
				window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_tipo_toma=estudio' + '&id_dia=','_blank');return false;
			}
			
		  
		});
		
		// seguimiento
		
		const btn3m = document.getElementById("btn3m");
		btn3m.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_alta = $("#date_alta").val();
			var date_alta_uci = $("#date_alta_uci").val();

			if (date_alta_uci === "" && date_alta === "") {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de alta antes de continuar", "warning");
				$("#date_alta").addClass("campo-naranja");
				$("#date_alta_uci").addClass("campo-naranja");
			} else{
			
			
			window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=3' + '&id_tipo_toma=mes seguimiento','_blank');return false;
			
			}
			
		  
		});
		
		const btn6m = document.getElementById("btn6m");
		btn6m.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_alta = $("#date_alta").val();
			var date_alta_uci = $("#date_alta_uci").val();

			if (date_alta_uci === "" && date_alta === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de alta antes de continuar", "warning");
				$("#date_alta").addClass("campo-naranja");
				$("#date_alta_uci").addClass("campo-naranja");
			} else{
			
			
			window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=6' + '&id_tipo_toma=mes seguimiento','_blank');return false;
			
			}
			
		  
		});
		
		const btn12m = document.getElementById("btn12m");
		btn12m.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_alta = $("#date_alta").val();
			var date_alta_uci = $("#date_alta_uci").val();

			if (date_alta_uci === "" && date_alta === "") {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de alta antes de continuar", "warning");
				$("#date_alta").addClass("campo-naranja");
				$("#date_alta_uci").addClass("campo-naranja");
			} else{
			
			
			window.open('his_patient_dia.php?pat_id=' + encodeURIComponent(pat_id) + '&id_dia=12' + '&id_tipo_toma=mes seguimiento','_blank');return false;
			
			}
			
		  
		});
		
		 /* const btnotro_postuci = document.getElementById("btndiaotro_postuci");
		btnotro_postuci.addEventListener("click", function(event) {
			
			var	pat_id = document.querySelector("#pat_number").value;
			var date_alta = $("#date_alta").val();
			var date_alta_uci = $("#date_alta_uci").val();

			if (date_alta_uci === "" ) {
				event.preventDefault(); // Prevent the default redirection behavior
				Swal.fire("Atención", "Por favor, complete los campos de fechas de alta antes de continuar", "warning");
			} else{
				
				window.open('his_patient_diaOtro_postuci.php?pat_id=' + encodeURIComponent(pat_id) + '&id_tipo_toma=postUCI' + '&id_dia=','_blank');return false;
			}
			
		  
		});  */
		
		
</script>

 

 
  
  <script>
  
  function save(){
	  
	  var ficha_pat_income = document.querySelector("#date_ingreso").value;
	  localStorage.setItem('pat_ingreso', ficha_pat_income);
		
	  var ficha_pat_income_uci = document.querySelector("#date_ingreso_uci").value;
	  localStorage.setItem('pat_ingreso_uci', ficha_pat_income_uci);
	  
	  var ficha_pat_outcome = document.querySelector("#date_alta").value;
	  localStorage.setItem('pat_alta', ficha_pat_outcome);
		
	  var ficha_pat_outcome_uci = document.querySelector("#date_alta_uci").value;
	  localStorage.setItem('pat_alta_uci', ficha_pat_outcome_uci);
	  
	  var ficha_pat_number = document.querySelector("#pat_number").value;
	  localStorage.setItem('pat_numero', ficha_pat_number);
	  
	  var ficha_pat_SIP = document.querySelector("#pat_SIP").value;
	  localStorage.setItem('pat_n_sip', ficha_pat_SIP);
	  
	  var ficha_pat_NHC = document.querySelector("#pat_NHC").value;
	  localStorage.setItem('pat_n_nhc', ficha_pat_NHC);
	  
	  /* var ficha_pat_sofa = document.querySelector("#SOFAtot").value;
	  localStorage.setItem('pat_SOFA', ficha_pat_sofa); */
	  
  
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
	function estado_ficha() {
	  var checkBox = document.getElementById("ficha_compl");
	  	  	  
	  if (checkBox.checked == true){
		
		
	  } else {
		 
		 
	  }
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
// los check del estado de los dias de monitorización se desahabilitan para todos los roles ya que ssu valor es dependiente del check de la ficha de cada dia

// monitorización checks
		 //document.querySelector('#dia_ingreso_estado').disabled = true;
		 document.querySelector('#dia1_estado').disabled = true;
		 document.querySelector('#dia3_estado').disabled = true;
		 document.querySelector('#dia5_estado').disabled = true;
		 document.querySelector('#dia7_estado').disabled = true;
		 document.querySelector('#dia14_estado').disabled = true;
		 document.querySelector('#diaOtro_estado').disabled = true;
 //seguimiento
		 
		 
</script>

	
		
<script>
	 
	 function pick_patient_rol(){
	 
	 var select_rol = document.querySelector("#rol_pat");
	 
	
	 
		if (select_rol.value == 0){
			
			// monitorización botones
		 
		  $('#btndia3, #btndia5, #btndia7, #btndia14, #btndiaOtro,#btndiaotro_postuci,#btn3m,#btn6m,#btn1y,#btnSegOtro').prop('disabled', true);
		 	 
			
			
		 
		}else if(select_rol.value == 1){
			
			// monitorización botones
		 $('#btndia3, #btndia5, #btndia7, #btndia14, #btndiaOtro,#btndiaotro_postuci,#btn3m,#btn6m,#btn1y,#btnSegOtro').prop('disabled', false);
		 
		  
		 
			
		}
	
	
	 }
	</script>	
	
	
	
	<script>
	$(document).ready(function () {
		
		$('.select2').select2({
		  language: "es"
		});
		
		/* $('.select2').select2({
		  language: "es",
		  tags: true,
		  createTag: function (params) {
			var term = $.trim(params.term);
			if (term === '') {
			  return null;
			}
			return {
			  id: term.toUpperCase(),
			  text: term.toUpperCase(),
			  newTag: true
			};
		  },
		  insertTag: function (data, tag) {
			data.unshift(tag);
		  }
		}).on('select2:select', function (e) {
		  if (e.params.data.newTag) {
			var newTag = e.params.data.text;
			
			console.log(newTag)
			
			$.ajax({
			  url: 'assets/inc/guardar_tag.php',
			  method: 'POST',
			  data: { tag: newTag },
			  success: function (response) {
				
				// Obtener las opciones existentes desde el servidor y agregar el nuevo tag
				$.ajax({
				  url: 'assets/inc/obtener_opciones_micros.php',
				  method: 'GET',
				  success: function(response) {
					  
					var obj = JSON.parse(response);
					var opcionesExistentes = Object.values(obj);
					
					console.log(opcionesExistentes)

					
					// Guardar las opciones existentes como un atributo data en los selectores
					$('.select2-dinamico').data('options', opcionesExistentes);

					// Llamar a la función para cargar las opciones de los selectores dinámicamente
					cargarOpcionesDinamicas(opcionesExistentes);
				  },
				  error: function(xhr, status, error) {
					console.error(error);
				  }
				});
					 

				
			  },
			  error: function (xhr, status, error) {
				console.error(error);
			  }
			});
		  }
		}); */
		
		
		var contador_divs = 1;

		// Función para clonar los divs
		function clonarDiv() {
			var divOriginal = $("#div_tto_otros_principal");
			var divClonado = divOriginal.clone();

			var nuevoID = "div_tto_otros_clonado_" + contador_divs;
			divClonado.attr("id", nuevoID);
			
			divClonado.css("visibility", "visible");

			var elementosDentroDelDiv = divClonado.find(".text-center, .d-flex");

			elementosDentroDelDiv.find("[id]").each(function() {
				var idOriginal = $(this).attr("id");
				var nuevoID = idOriginal + "_" + contador_divs;
				$(this).attr("id", nuevoID);
			});

			elementosDentroDelDiv.find("[name]").each(function() {
				var nameOriginal = $(this).attr("name");
				var nuevoName = nameOriginal + "_" + contador_divs;
				$(this).attr("name", nuevoName);
			});

			elementosDentroDelDiv.find("label").each(function() {
				var forOriginal = $(this).attr("for");
				var nuevoFor = forOriginal + "_" + contador_divs;
				$(this).attr("for", nuevoFor);
			});

			var currentContador = contador_divs;

			$(document).on("change", "#VM_check_otros_" + currentContador, function() {
				var checkbox = $(this);
				var divVal = checkbox.closest(".d-flex").find("#VM_val_otros_" + currentContador);

				if (checkbox.prop("checked")) {
					divVal.css("display", "block");
				} else {
					divVal.css("display", "none");
				}
			});

			$(document).on("change", "#TRRC_check_otros_" + currentContador, function() {
				var checkbox = $(this);
				var divVal = checkbox.closest(".d-flex").find("#TRRC_val_otros_" + currentContador);

				if (checkbox.prop("checked")) {
					divVal.css("display", "block");
				} else {
					divVal.css("display", "none");
				}
			});

			$(document).on("change", "#DVA_check_otros_" + currentContador, function() {
				var checkbox = $(this);
				var divVal = checkbox.closest(".d-flex").find("#DVA_val_otros_" + currentContador);

				if (checkbox.prop("checked")) {
					divVal.css("display", "block");
				} else {
					divVal.css("display", "none");
				}
			});

			$("#contenedorDivsClonados").append(divClonado);

			contador_divs++;
		}
		
		
		
		
		$("#btnAgregarNuevoDia").on("click", function () {
			
				clonarDiv();
				
		});
		
		
			
		$("#VM_check_ingreso").change(function () {
		
		if( $('#VM_check_ingreso').prop('checked')){
			
			
			$('#VM_val').css('display', 'block');
			
			
		}else {
			$('#VM_val').css('display', 'none');
			
		}
			
		});
		
		$("#TRRC_check_ingreso").change(function () {
			
			if( $('#TRRC_check_ingreso').prop('checked')){
				
				$('#TRRC_val').css('display', 'block');
				
				
				
			}else {
				$('#TRRC_val').css('display', 'none');
			}
			
		});
		
		$("#DVA_check_ingreso").change(function () {
			
			if( $('#DVA_check_ingreso').prop('checked')){
				
				$('#DVA_val').css('display', 'block');
				
				
			}else {
				$('#DVA_val').css('display', 'none');
				
			}
			
		});
		
		
		// Acción cuando cambia el estado del check VM
		
		$(document).on("change", "#VM_check_otros", function() {
			var checkbox = $(this);
			var divVal = checkbox.closest(".d-flex").find("#VM_val_otros");

			if (checkbox.prop("checked")) {
				divVal.css("display", "block");
			} else {
				divVal.css("display", "none");
			}
		});

		// Acción cuando cambia el estado del check TRRC
		
		$(document).on("change", "#TRRC_check_otros", function() {
			var checkbox = $(this);
			var divVal = checkbox.closest(".d-flex").find("#TRRC_val_otros");

			if (checkbox.prop("checked")) {
				divVal.css("display", "block");
			} else {
				divVal.css("display", "none");
			}
		});

		// Acción cuando cambia el estado del check DVA
		
		$(document).on("change", "#DVA_check_otros", function() {
			var checkbox = $(this);
			var divVal = checkbox.closest(".d-flex").find("#DVA_val_otros");

			if (checkbox.prop("checked")) {
				divVal.css("display", "block");
			} else {
				divVal.css("display", "none");
			}
		});
		
		
		
		
		
		
	// JavaScript
		  var checksList = [1, 3, 5, 7, 14]; 

		  var pacienteData = <?php echo $pacienteDataJson; ?>;
		  
		  console.log(pacienteData)

		  // Itera sobre la lista de checks y marca/desmarca según el valor de status_dia
		  checksList.forEach(function(check) {
			  var checkbox = document.getElementById('dia' + check + '_estado');
			  
			  if (pacienteData.hasOwnProperty(check) && pacienteData[check] !== null){
			  
				  checkbox.checked = pacienteData[check] === 1;
				  $('#btndia'+ check).css({"background":"green",color : "white"}); 
			  
			  }
			});
		
		
		
		 $("input[name='gridExitus']").on("change", function () {
			var exitus_pat = parseInt($("input[name='gridExitus']:checked").val());
			
			if (exitus_pat > 0) {
				$('#fecha_exitus').css('display', 'block');
			} else {
				$('#fecha_exitus').css('display', 'none');
			}
		});
		
		
		$("#ficha_compl").change(function () {
			
			isChecked = $('#ficha_compl').prop('checked');
			var ficha_dia = isChecked ? 1 : 0;
			
			$('#status_ficha').val(ficha_dia);
		});
		
		
		$("#pat_SIP, #pat_NHC, #id_clinica,#rol_pat").on("input change", function () {
				if ($(this).val() !== "") {
					$(this).removeClass("campo-naranja");
				}
			});
		$("#registration input, #registration select").each(function() {
			var $campo = $(this);
			
			if ($campo.val() === "") {
			  $campo.addClass("campo-naranja");
			} 
		 });
		 $("#registration input, #registration select").on("input change", function() {
			  var $campo = $(this);
			  
			  if ($campo.val() !== "") {
				$campo.removeClass("campo-naranja");
			  } 
		});
		
		$("#VM_pat_ingreso").change(function () {
			
			if( $('#VM_pat_ingreso').prop('checked')){
				
				
				$('#VM_val').css('display', 'block');
				
				
			}else {
				$('#VM_val').css('display', 'none');
				
			}
			
		});
		
		$("#TRRC_pat_ingreso").change(function () {
			
			if( $('#TRRC_pat_ingreso').prop('checked')){
				
				$('#TRRC_val').css('display', 'block');
				
				
				
			}else {
				$('#TRRC_val').css('display', 'none');
			}
			
		});
		
		$("#DVA_pat_ingreso").change(function () {
			
			if( $('#DVA_pat_ingreso').prop('checked')){
				
				$('#DVA_val').css('display', 'block');
				
				
			}else {
				$('#DVA_val').css('display', 'none');
				
			}
			
		});
		
		
		$("#VM_pat").change(function () {
			
			if( $('#VM_pat').prop('checked')){
				
				
				$('#VM_val_otros').css('display', 'block');
				
				
			}else {
				$('#VM_val_otros').css('display', 'none');
				
			}
			
		});
		
		$("#TRRC_pat").change(function () {
			
			if( $('#TRRC_pat').prop('checked')){
				
				$('#TRRC_val_otros').css('display', 'block');
				
				
				
			}else {
				$('#TRRC_val_otros').css('display', 'none');
			}
			
		});
		
		$("#DVA_pat").change(function () {
			
			if( $('#DVA_pat').prop('checked')){
				
				$('#DVA_val_otros').css('display', 'block');
				
				
			}else {
				$('#DVA_val_otros').css('display', 'none');
				
			}
			
		});
		
		
		
		
	});
	
	</script>
	
	<script>
		// Función para cargar las opciones de los selectores dinámicamente
		/* function cargarOpcionesDinamicas(array_select2) {
		   
			  var select2Elements = $('.select2-dinamico');

			  // Limpiar las opciones existentes en cada elemento select2
			  select2Elements.empty();

			  // Iterar sobre el array de datos y crear las opciones para cada elemento select2
			  for (var i = 0; i < array_select2.length; i++) {
				var opcion = $('<option></option>').text(array_select2[i]);
				select2Elements.append(opcion);
			  }


			// Inicializar Select2 nuevamente
			select.select2({
			  language: "es",
			  tags: true
			});
  
		} */

	
	
	</script>
	
	<script> 
	 
	 $(document).ready(function () {
		$("#rol_pat").change(function () {
			var val = $(this).val();
			if (val == 0) {
				
				// seleccionar automaticamento no aplica
				
				//$('#id_clinica option[value=0]').prop("selected",true);
				$('#id_clinica').val(0);
				$('#microorganismo').val(0);
				$('#tipologia_pat').val(0);
				$('#foco_inf_pat').val(0);
				$('#diag_ingreso').val(0);
				
				$('#hemo_pat').val(0);
				$('#traquea_pat').val(0);
				$('#ag_uri_pat').val(0);
				$('#abdomen_pat_micro').val(0);
				$('#cateter_pat').val(0);
				$('#lcr_pat').val(0);
				$('#urino_pat').val(0);
				$('#otros_pat').val(0);
				
				// impedir seleccionar otras opciones
				
				$("#id_clinica option[value != 0]").prop('disabled',true);
				$("#microorganismo option[value != 0]").prop('disabled',true);
				$("#tipologia_pat option[value != 0]").prop('disabled',true);
				$("#foco_inf_pat option[value != 0]").prop('disabled',true);
				$("#diag_ingreso option[value != 0]").prop('disabled',true);
				
				$("#hemo_pat option[value != 0]").prop('disabled',true);
				$("#traquea_pat option[value != 0]").prop('disabled',true);
				$("#ag_uri_pat option[value != 0]").prop('disabled',true);
				$("#abdomen_pat_micro option[value != 0]").prop('disabled',true);
				$("#cateter_pat option[value != 0]").prop('disabled',true);
				$("#lcr_pat option[value != 0]").prop('disabled',true);
				$("#otros_pat option[value != 0]").prop('disabled',true);
				$("#urino_pat option[value != 0]").prop('disabled',true);
				
			} else{
				
				// volver al estado original
				
				/* $('#id_clinica').val('');
				$('#microorganismo').val('');
				$('#tipologia_pat').val('');
				$('#foco_inf_pat').val('');
				$('#diag_ingreso').val('');
				
				$('#hemo_pat').val('');
				$('#traquea_pat').val('');
				$('#ag_uri_pat').val('');
				$('#abdomen_pat_micro').val('');
				$('#cateter_pat').val('');
				$('#lcr_pat').val('');
				$('#otros_pat').val(''); */
				
				
				
				$("#id_clinica option").prop('disabled',false);
				$("#microorganismo option").prop('disabled',false);
				$("#tipologia_pat option").prop('disabled',false);
				$("#foco_inf_pat option").prop('disabled',false);
				$("#diag_ingreso option").prop('disabled',false);
				
				$("#hemo_pat option[value != 0]").prop('disabled',false);
				$("#traquea_pat option[value != 0]").prop('disabled',false);
				$("#ag_uri_pat option[value != 0]").prop('disabled',false);
				$("#abdomen_pat_micro option[value != 0]").prop('disabled',false);
				$("#cateter_pat option[value != 0]").prop('disabled',false);
				$("#lcr_pat option[value != 0]").prop('disabled',false);
				$("#otros_pat option[value != 0]").prop('disabled',false);
				$("#urino_pat option[value != 0]").prop('disabled',false);
				
			}
		})
	 })
	
	</script>
	
	<script>
	jQuery.extend(jQuery.validator.messages, {
		required: "<span style='color: red;'>Este campo es obligatorio.</span>",
		remote: "<span style='color: red;'>Corrige este campo.</span>",
		email: "<span style='color: red;'>Introduce una dirección de correo válida.</span>",
		url: "<span style='color: red;'>Introduce un URL válido.</span>",
		date: "<span style='color: red;'>Introduce una fecha válida.</span>",
		dateISO: "<span style='color: red;'>Introduce una fecha (ISO) válida.</span>",
		number: "<span style='color: red;'>Introduce un número válido.</span>",
		digits: "<span style='color: red;'>Introduce sólo dígitos.</span>",
		creditcard: "<span style='color: red;'>Introduce un número de tarjeta válido.</span>",
		equalTo: "<span style='color: red;'>Introduce el mismo valor de nuevo.</span>",
		accept: "<span style='color: red;'>Introduce un valor con una extensión válida.</span>",
		maxlength: jQuery.validator.format("<span style='color: red;'>No introduzcas más de {0} caracteres.</span>"),
		minlength: jQuery.validator.format("<span style='color: red;'>Introduce al menos {0} caracteres.</span>"),
		rangelength: jQuery.validator.format("<span style='color: red;'>Introduce un valor con una longitud entre {0} y {1} caracteres.</span>"),
		range: jQuery.validator.format("<span style='color: red;'>Introduce un valor entre {0} y {1}.</span>"),
		max: jQuery.validator.format("<span style='color: red;'>Introduce un valor menor o igual a {0}.</span>"),
		min: jQuery.validator.format("<span style='color: red;'>Introduce un valor mayor o igual a {0}.</span>")
	});
</script>
	
<script>
  var registrationForm = $('#registration');
  var formValidate = registrationForm.validate({
	lang : 'es',
    errorClass: 'is-invalid',
    errorPlacement: function(error, element) {
      // Agregar el mensaje de error después del campo inválido
      error.insertAfter(element);

      // Agregar un mensaje adicional junto a la marca de error
      var errorMessage = "";
      var errorLabel = $("<label>").addClass("additional-error").text(errorMessage);
      errorLabel.insertAfter(element);
    },
    
  });

  const wizard = new Enchanter('registration', {}, {
    onNext: () => {
      if (!registrationForm.valid()) {
        return false;
      } else {
        
      }
    }
  });
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
  
	  function getAge() {
		
		
		var dob = document.getElementById('dateBirth').value;
		dob = new Date(dob);
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
		document.getElementById('age').value=age;
		
		
		
		}
		
		 function getEstancia() {
		
		
		var inicio = document.getElementById('date_ingreso_uci').value;
		inicio = new Date(inicio);
		var fin = document.getElementById('date_alta_uci').value;
		fin = new Date(fin);
		var diferenciaMilisegundos = fin.getTime() - inicio.getTime();
		
		var estancia = Math.round(diferenciaMilisegundos / 86400000);

		
		document.getElementById('estancia_hosp').value=estancia;
		
		
		
		}


	function obtener_edad(birth) {
		
		var birth_pat = new Date(birth);
		var today = new Date();
		var age = Math.floor((today-birth_pat) / (365.25 * 24 * 60 * 60 * 1000));
		
		return age;
		
		}

  
  </script>
  
  <script type="text/javascript">
  
	  function getBMI() {
		
		
		var height = document.getElementById('pat_height').value;
		var weight = document.getElementById('peso_pac').value;
		
		BMI = weight/(height**2); 
		BMI = Math.round(BMI * 100) / 100;
		
		document.getElementById('BMI_pac').value=BMI;
		
		}

  
  </script>
  
   <script type="text/javascript">
  
	  function getPAM() {
		
		
			var PAS = new Number(document.querySelector('#p_sistolica').value);
			var PAD = new Number(document.querySelector('#p_diastolica').value);
			
			
			if (PAS == "" || PAD== ""){
				alert("Por favor rellene los campos de PAS y PAD para poder realizar el cálculo")
			}else{
				if(PAS >= PAD){
				
				PAM = ((2*PAD)+ PAS)/3; 
				PAM = Math.round(PAM);
				
				document.querySelector('#p_media').value=PAM;
				
				} else if(PAS < PAD){
					
					alert(" Error de cálculo el valor PAS no puede ser menor al de PAD")
					
				} 
				
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
		
			if (check_drugs.checked == true){
			
				hemo_sofa_valor = 2;
			
				if ((dopa_value <5 && dopa_value >0)|| dobu_value != 0){
					
					var hemo_sofa_valor = 2;
					
					
				} else if ((dopa_value > 5 && dopa_value <= 15 ) || ((nora_value <= 0.1 && nora_value > 0)|| (adrena_value <= 0.1 && adrena_value > 0))) {
					
					var hemo_sofa_valor = 3;
					
					
				} else if (dopa_value > 15 || (nora_value > 0.1 || adrena_value > 0.1)){
					
					var hemo_sofa_valor = 4;
					
					
				}
			document.querySelector('#SOFAhemo').value = hemo_sofa_valor;
				
			}else if (check_drugs.checked == false){
				
				if(valor_pam >= 70 && check_drugs.checked == false ){
					
					hemo_sofa_valor = 0;
							
					
				}else if (valor_pam < 70 && valor_pam > 0  && check_drugs.checked == false ){
					
					var hemo_sofa_valor = 1;
					
					
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
  

  
  <script>
   function getCharlson(){
		   
		   //edad
		   
		   var cci_edad = new Number (document.querySelector('input[name="btn_edad"]:checked').value);
		   
		   var cci_inf = new Number (document.querySelector('input[name="gridInfarto"]:checked').value);
		   
		   var cci_card = new Number (document.querySelector('input[name="gridCardiac"]:checked').value);
		   
		   var cci_vasc = new Number (document.querySelector('input[name="gridVasc"]:checked').value);
		   
		   var cci_cerebr = new Number (document.querySelector('input[name="gridCerebro"]:checked').value);
		   
		   var cci_dem = new Number (document.querySelector('input[name="gridDemencia"]:checked').value);
		   
		   var cci_epoc = new Number (document.querySelector('input[name="gridEPOC"]:checked').value);
		   
		   var cci_conect = new Number (document.querySelector('input[name="gridConect"]:checked').value);
		   
		   var cci_pept = new Number (document.querySelector('input[name="gridPept"]:checked').value);
		   
		   var cci_dm = new Number (document.querySelector('input[name="gridDiabetes"]:checked').value);
		   
		   var cci_dmles = new Number (document.querySelector('input[name="gridDMlesion"]:checked').value);
		   
		   var cci_hemi = new Number (document.querySelector('input[name="gridHemi"]:checked').value);
		   
		   var cci_renal = new Number (document.querySelector('input[name="gridRenal"]:checked').value);
		   
		   var cci_tumor = new Number (document.querySelector('input[name="gridTumor"]:checked').value);
		   
		   var cci_metas = new Number (document.querySelector('input[name="gridMetas"]:checked').value);
		   
		   var cci_leu = new Number (document.querySelector('input[name="gridLeu"]:checked').value);
		   
		   var cci_linfo = new Number (document.querySelector('input[name="gridLinfo"]:checked').value);
		   
		   var cci_sida = new Number (document.querySelector('input[name="gridSIDA"]:checked').value);
		   
		   
		   var valor_cci_paciente = (cci_edad + cci_inf + cci_card + cci_vasc + cci_cerebr + cci_dem + cci_epoc + cci_conect +cci_pept + cci_dm + cci_dmles + cci_hemi + cci_renal + cci_tumor + cci_metas + cci_leu + cci_linfo + cci_sida);
		   
		   document.getElementById("cci_pat").value = valor_cci_paciente ;
		   
		}
  
  </script>
  
  <script type="text/javascript">
	  
	  
	    var edad_database = '<?php echo $edad_pac ?>';

		const button50 = document.getElementById("btn50");
		const button50_59 = document.getElementById("btn50_59");
		const button60_69 = document.getElementById("btn60_69");
		const button70_79 = document.getElementById("btn70_79");
		const button80 = document.getElementById("btn80");
		<!-- reinicio de los colores de las etiquetas -->
		
		$("#lbl50").css({"background":"transparent",color : "#6658dd"});
		$("#lbl50_59").css({"background":"transparent",color : "#6658dd"});
		$("#lbl60_69").css({"background":"transparent",color : "#6658dd"});
		$("#lbl70_79").css({"background":"transparent",color : "#6658dd"});
		$("#lbl80").css({"background":"transparent",color : "#6658dd"});
		
			if(edad_database < 51){
				
				button50.checked = true;
				$("#lbl50").css({"background":"#6658dd",color : "white"});
				
				
			}
			else if (edad_database>49 && edad_database<60 ){
				button50_59.checked = true;
				$("#lbl50_59").css({"background":"#6658dd",color : "white"});
				
			}
			else if(edad_database>59 && edad_database<70){
				button60_69.checked = true;
				$("#lbl60_69").css({"background":"#6658dd",color : "white"});
				
			}
			else if(edad_database>69 && edad_database<80){
				button70_79.checked = true;
				$("#lbl70_79").css({"background":"#6658dd",color : "white"});
				
			}
			else if (edad_database>79){
				button80.checked = true;
				$("#lbl80").css({"background":"#6658dd",color : "white"});
			}
		
	  
	   </script>
  
  <script type="text/javascript">
	
	function age_charlson(){
		
	//var nacimiento_pat = document.getElementById('dateBirth').value;
		
	//var edad_pac = obtener_edad(nacimiento_pat);
	
	var edad_pac = $('#age').val();
	
	const button50 = document.getElementById("btn50");
	const button50_59 = document.getElementById("btn50_59");
	const button60_69 = document.getElementById("btn60_69");
	const button70_79 = document.getElementById("btn70_79");
	const button80 = document.getElementById("btn80");
	
	const button44 = document.getElementById("btn44");
	const button45_54 = document.getElementById("btn44_54");
	const button55_64 = document.getElementById("btn55_64");
	const button65_74 = document.getElementById("btn65_74");
	const button75 = document.getElementById("btn75");
	<!-- reinicio de los colores de las etiquetas -->
	
	$("#lbl50").css({"background":"transparent",color : "#6658dd"});
	$("#lbl50_59").css({"background":"transparent",color : "#6658dd"});
	$("#lbl60_69").css({"background":"transparent",color : "#6658dd"});
	$("#lbl70_79").css({"background":"transparent",color : "#6658dd"});
	$("#lbl80").css({"background":"transparent",color : "#6658dd"});
	
		if(edad_pac < 50){
			
			button50.checked = true;
			$("#lbl50").css({"background":"#6658dd",color : "white"});
			
			
		}
		else if (edad_pac>=50 && edad_pac<=59 ){
			button50_59.checked = true;
			$("#lbl50_59").css({"background":"#6658dd",color : "white"});
			
		}
		else if(edad_pac>=60 && edad_pac<=69){
			button60_69.checked = true;
			$("#lbl60_69").css({"background":"#6658dd",color : "white"});
			
		}
		else if(edad_pac>=70 && edad_pac<=79){
			button70_79.checked = true;
			$("#lbl70_79").css({"background":"#6658dd",color : "white"});
			
		}
		else if (edad_pac>=80){
			button80.checked = true;
			$("#lbl80").css({"background":"#6658dd",color : "white"});
		}
		
  
  
	}
	
	function age_apacheII(){
		
	//var nacimiento_pat = document.getElementById('dateBirth').value;
		
	//var edad_pac = obtener_edad(nacimiento_pat);
	var edad_pac = $('#age').val();
		
	const button44 = document.getElementById("btn44");
	const button45_54 = document.getElementById("btn44_54");
	const button55_64 = document.getElementById("btn55_64");
	const button65_74 = document.getElementById("btn65_74");
	const button75 = document.getElementById("btn75");
	<!-- reinicio de los colores de las etiquetas -->
	
	$("#lbl44").css({"background":"transparent",color : "#6658dd"});
	$("#lbl45_54").css({"background":"transparent",color : "#6658dd"});
	$("#lbl55_64").css({"background":"transparent",color : "#6658dd"});
	$("#lbl65_74").css({"background":"transparent",color : "#6658dd"});
	$("#lbl75").css({"background":"transparent",color : "#6658dd"});
	
		if(edad_pac <= 44){
			
			button44.checked = true;
			$("#lbl44").css({"background":"#6658dd",color : "white"});
			
			
		}
		else if (edad_pac>=45 && edad_pac<=54 ){
			button45_54.checked = true;
			$("#lbl45_54").css({"background":"#6658dd",color : "white"});
			
		}
		else if(edad_pac>=55 && edad_pac<=64){
			button55_64.checked = true;
			$("#lbl55_64").css({"background":"#6658dd",color : "white"});
			
		}
		else if(edad_pac>=65 && edad_pac<=74){
			button65_74.checked = true;
			$("#lbl65_74").css({"background":"#6658dd",color : "white"});
			
		}
		else if (edad_pac>=75){
			button75.checked = true;
			$("#lbl75").css({"background":"#6658dd",color : "white"});
		}
		
  
  
	}
	
	
	
  
  
  
    </script>
  
  <script type="text/javascript">
  
	  function getPaFi() {
		
		
			var Pa_o2 = new Number(document.querySelector('#Pao2_pat').value);
			var Fi_o2 = new Number(document.querySelector('#Fio2_pat').value);
			
			
			if (Pa_o2 == "" || Fi_o2== ""){
				alert("Por favor rellene los campos de Pa02 y Fi02 para poder realizar el cálculo")
			}else{
				
				Pa_fi = (Pa_o2/Fi_o2); 
				
				Pa_fi = Math.round(Pa_fi);
				
				document.querySelector('#PaFi_pat').value=Pa_fi;
				
			}
		}

  
  </script>
  
  <script type="text/javascript">
  
	  function addDays(date, days) {
		var result = new Date(date);
		result.setDate(result.getDate() + days);
		return result;
		}
	  
	  
	  
	  
	  
	  
	  function getDateMonitor() {
		
		var fecha_inicio = document.getElementById('date_ingreso').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = document.getElementById('day_monitor').value; 
		dia_monitor = new Number(dia_monitor);
		
		var fecha_monitor =    addDays(fecha_inicio,dia_monitor);
		
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
				
		document.getElementById('date_monitor').value = fecha_monitor;
		
		
		}

  
  </script>
  
  <script type="text/javascript">
	
	function duplicate(x_original){

		var copia = x_original + '_copied';
		var x_original = document.getElementById(x_original);
		document.getElementById(copia).value = x_original.value;
		
		
	}
	
</script>

<script>
	function subtractYears(date, years) {
	  var date = new Date(date)	;
	  var y = date.getFullYear();
	  const dateCopy = new Date(date);
	  date.setFullYear(y - years);
	  return date;
	}
	
	
	
	<!-- Set maximum date to current day-->
	now = new Date;
		
	date_ingreso.max = now.toISOString().split("T")[0];
	date_ingreso.min = (subtractYears(now, 25)).toISOString().split("T")[0];
	
	date_ingreso_uci.max = now.toISOString().split("T")[0];
	
	
	date_alta.max = now.toISOString().split("T")[0];
	
	date_alta_uci.max = now.toISOString().split("T")[0];
	
	dateBirth.max = now.toISOString().split("T")[0];
	dateBirth.min = (subtractYears(now, 130)).toISOString().split("T")[0];
	
	
</script>

<script>

 function ajuste_fechas(){
	 
	ingreso_hospital= document.getElementById('date_ingreso').value;
	alta_uci= document.getElementById('date_alta_uci').value;
	
	date_alta.min = (alta_uci > ingreso_hospital) ? alta_uci : ingreso_hospital;
	date_alta_uci.min = document.getElementById('date_ingreso_uci').value;
	date_ingreso_uci.min = document.getElementById('date_ingreso').value ;
	 
 }
 
 
</script>

<script>


	function change_color_days(nameCheck,nameButton) {
	  
	  var checkBox = document.getElementById(nameCheck);
	  
	  if (checkBox.checked == true){
		$(nameButton).css({"background":"green",color : "white"}); 
		
	   } else if (checkBox.checked != true){
		 
		$(nameButton).css({"background":"#6658dd",color : "white"});
		
	   }
	}
	
	</script>
	<script>
	
	function change_all_colours(){
		//change_color_days('dia_ingreso_estado', document.querySelector('#btndiaIngreso'));
		change_color_days('dia1_estado', document.querySelector('#btndia1'));
		change_color_days('dia3_estado', document.querySelector('#btndia3'));
		change_color_days('dia5_estado', document.querySelector('#btndia5'));
		change_color_days('dia7_estado', document.querySelector('#btndia7'));
		change_color_days('dia14_estado', document.querySelector('#btndia14'));
		//change_color_days('diaOtro_estado', document.querySelector('#btndiaOtro'));
	}
</script>


<script>

	function load(){
		
		/* var checked_ingreso = JSON.parse(localStorage.getItem('check_dia0'));
		document.getElementById("dia_ingreso_estado").checked = checked_ingreso; */
		
		var checked_d1 = JSON.parse(localStorage.getItem('check_dia1'));
		document.getElementById("dia1_estado").checked = checked_d1;
		
		var checked_d3 = JSON.parse(localStorage.getItem('check_dia3'));
		document.getElementById("dia3_estado").checked = checked_d3;
		
		var checked_d5 = JSON.parse(localStorage.getItem('check_dia5'));
		document.getElementById("dia5_estado").checked = checked_d5;
		
		var checked_d7 = JSON.parse(localStorage.getItem('check_dia7'));
		document.getElementById("dia7_estado").checked = checked_d7;
		
		var checked_d14 = JSON.parse(localStorage.getItem('check_dia14'));
		document.getElementById("dia14_estado").checked = checked_d14;
		
		/* var checked_otro = JSON.parse(localStorage.getItem('check_dia_otro'));
		document.getElementById("diaOtro_estado").checked = checked_otro; */
		
		
		
	}
		


</script>

<script>
function update_btns(){
	
	load();
	change_all_colours();
}

</script>

<script>
	function delete_all_localStore(){
		location.reload();
		localStorage.clear()

	}
</script>




<!-- por corregir -->


<!--<script>
var current_slide, next_slide, previous_slide;
var left, opacity, scale;
var animation;

var error = false;

// first step validation
$(".btn btn-primary").click(function() {
    // SIP
    if ($("#pat_SIP").val() == "") {
        $("#error-pat_SIP").text('Por favor introduzca los 10 dígitos del número SIP');
        $("#").addClass("box_error");
        error = true;
    } 
    
    // animation
    if (!error) {
        if (animation) return false;
        animation = true;

        current_slide = $(this).parent().parent();
        next_slide = $(this).parent().parent().next();

        $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

        next_slide.show();
        current_slide.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50) + "%";
                opacity = 1 - now;
                current_slide.css({
                    'transform': 'scale(' + scale + ')'
                });
                next_slide.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_slide.hide();
                animation = false;
            },
            easing: 'easeInOutBack'
        });
    }
});

</script>-->

<!--<script>
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

<script type="text/Javascript">
	
	

</script>-->
  
  <!-- Vendor js -->
  <script src="assets/js/vendor.min.js"></script>

	<!-- App js-->
  <script src="assets/js/app.min.js"></script>

	<!-- Loading buttons js -->
  <script src="assets/libs/ladda/spin.js"></script>
  <script src="assets/libs/ladda/ladda.js"></script>

	<!-- Buttons init js-->
  <script src="assets/js/pages/loading-btn.init.js"></script>
  
  

  
  
</body>
</html>