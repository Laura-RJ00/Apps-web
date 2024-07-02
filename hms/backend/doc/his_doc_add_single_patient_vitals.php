<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_patient_vitals']))
		{

			$day_monitor= intval($_POST['day_monitor']);
			$id_tipo_toma = $_POST['id_tipo_toma'];
			$h2b_pat=$_POST['h2b_pat'];
			$h3_pat=$_POST['h3_pat'];
			$h4_pat=$_POST['h4_pat'];
			$pca_pat=$_POST['pca_pat'];
			$il6_pat=$_POST['il6_pat'];
			$comentarios_histonas= $_POST['comentarios_histonas'] ;
			
			$pat_id=$_POST['pat_id'];
			
			
			$query_pat_id = "SELECT * FROM vars WHERE pat_id = ? AND id_dia = ? AND id_tipo_toma = ?  ";
			$stmt= $mysqli->prepare($query_pat_id);
			$stmt->bind_param('sis', $pat_id, $day_monitor,$id_tipo_toma);
			$stmt->execute();
			$stmt->store_result();
			$check_pat_id = $stmt->num_rows;
			
			if ($check_pat_id > 0) {
				
				$query_up="UPDATE `vars` SET `H2B`= ?, `H3`= ?,`H4`= ?,`PCA`= ?,`il6`= ?, `comentarios_histonas`= ?	
											WHERE pat_id=? AND id_dia=? AND `id_tipo_toma`=?";
				$stmt_up = $mysqli->prepare($query_up);
				$rc=$stmt_up->bind_param('sssssssis', $h2b_pat, $h3_pat,$h4_pat,$pca_pat,$il6_pat, $comentarios_histonas, $pat_id, $day_monitor,$id_tipo_toma);
				$stmt_up->execute();
				
				if($stmt_up)
				{
				
					
					$success = "Datos de histonas actualizados";
				}
				else {
					
					$err = "Por favor intenténtelo de nuevo o pruebe más tarde";
				}
				
				
			}else {
				
				
				echo "No se han guardado los datos ";
				
			}
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
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
            <?php
                $pat_id = $_GET['pat_id'];
                $ret="SELECT  * FROM patients WHERE pat_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$pat_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
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
                                                <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Tablero</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laboratorio</a></li>
                                                <li class="breadcrumb-item active">Registrar variables biomédicas</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Registro <?php echo $row->pat_id;?> de histonas</h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
											<form method="post" id= "histonas_pac" name="histonas_pac">
												<div class="form-row">
													<div class="col">
														<fieldset style="padding:14px; border:3px solid #0288d1; border-radius: 8px;
															box-shadow: 0 0 10px #666; background:#e1f5fe">
															<legend class=" legendPat float-none w-auto">Datos identificativos</legend>
															
															
																<div class="form-row">

																	<div class="form-group col-md-6">
																		<label for="sip_pat" class="col-form-label">SIP del paciente</label>
																		<input type="text" required="required" readonly name="sip_pat" value="<?php echo $row->pat_sip;?> " class="form-control" id="sip_pat" placeholder="" >
																	</div>
																	
																	<div class="form-group col-md-6">
																		<label for="pat_id" class="col-form-label">Identificador interno</label>
																		<input type="text" required="required" readonly name="pat_id" value="<?php echo $row->pat_id;?>" class="form-control" id="pat_id" placeholder="">
																	</div>

																	

																</div>

																<div class="form-row">

																	<div class="form-group col-md-6">
																		<label for="nhc_pat" class="col-form-label">Nº Historia clínica</label>
																		<input type="text" required="required" readonly name="nhc_pat" value="<?php echo $row->pat_nhc;?> " class="form-control" id="nhc_pat" placeholder="">
																	</div>
																	<div class="form-group col-md-6">
																		<label for="rol_pat" class="col-form-label">Rol de estudio</label>
																		<input required="required" type="text" readonly name="rol_pat" value="<?php echo $row->pat_role;?>" class="form-control"  id="rol_pat" placeholder="">
																	</div>


																</div>
																<div class="form-row">
																	
																	
																	<div class="col-md">
																		<label for="date_ingreso_copied" class="col-form-label">Fecha ingreso hospitalario</label>
																		<input required="required" type="date" name="date_ingreso" value="<?php echo $row->pat_date_ingreso;?>" class="form-control"  
																		id="date_ingreso"  readonly>
																		
																	</div>
																	<div class="col-md">
																		<label for="date_ingreso_copied" class="col-form-label">Fecha ingreso en UCI</label>
																		<input required="required" type="date" name="date_ingreso_uci" value="<?php echo $row->pat_date_ingreso_uci;?>" class="form-control"  
																		id="date_ingreso_uci"  readonly>
																		
																	</div>
																
																</div>
															
														</fieldset>
													</div>
												</div>
											<?php }?>
                                                
                                                <hr>
												
												
													<br></br>
													<fieldset class="border p-2">
														<legend class="float-none w-auto" style ="font-size:20px;"> Registros anteriores de histonas recuperados </legend>
														   <b><span class="title">Selecciona el día de toma de datos</span> </b>
															<br></br>
															<div class= "form-row">
																<div class="col">
																	<fieldset class="border p-2">
																		<legend class="float-none w-auto" style ="font-size:20px;">Día: ingreso hospitalario</legend>
																		   
																			<div class="d-grid gap-2">
																					
																				<div class="form-inline well">
																					
																					
																					<div class="form-group" style="width:80%;">
																					
																						<?php
																							$pat_id = $_GET['pat_id'];
																							$id_tipo_toma = 'HOSP';
																							$ret = "SELECT `id_dia`
																									FROM `vars`
																									WHERE `pat_id` = ? AND `id_tipo_toma` = ?";
																							$stmt = $mysqli->prepare($ret);
																							$stmt->bind_param('ss', $pat_id, $id_tipo_toma);
																							$stmt->execute();
																							$res = $stmt->get_result();

																							// Generar los botones en HTML
																							if ($res->num_rows > 0) {
																								
																								$buttonsHTML = "";
																								
																								while ($row = $res->fetch_object()) {
																									
																									$nombre = $row->id_dia; 
																									
																									$buttonsHTML .= '<button class="restore_btn btn btn-info btn-lg" 
																									type="button" style="margin:5px;" value= ' . $nombre . ' name="btn' . $nombre . '" 
																									id="btn' . $nombre . '" 
																									onclick="update_histonas(\'' . $nombre . '\',\'' . $id_tipo_toma . '\')">' . $nombre . '</button>';
																										
																								}
																								
																								echo '<div id="registros_anteriores_hosp">' . $buttonsHTML . '</div>';
																							} else {
																								echo 'No se han registrado otros días.';
																							}
																							?>
																					
																						<div id="registros_anteriores_hosp"></div>
																						
																					</div>
																					
																				</div>
																			</div>
																	</fieldset>
																</div>
																<div class="col">
																	<fieldset class="border p-2">
																		<legend class="float-none w-auto" style ="font-size:20px;">Días preUCI</legend>
																		   
																			<div class="d-grid gap-2">
																					
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
																							if ($res->num_rows > 0) {
																								
																								$buttonsHTML = "";
																								
																								while ($row = $res->fetch_object()) {
																									
																									$nombre = $row->id_dia; 
																									
																									$buttonsHTML .= '<button class="restore_btn btn btn-warning btn-lg" 
																									type="button" style="margin:5px;" value= ' . $nombre . ' name="btn' . $nombre . '" 
																									id="btn' . $nombre . '" 
																									onclick="update_histonas(\'' . $nombre . '\',\'' . $id_tipo_toma . '\')">' . $nombre . '</button>';
																										
																								}
																								
																								echo '<div id="registros_anteriores_preuci">' . $buttonsHTML . '</div>';
																							} else {
																								echo 'No se han registrado otros días.';
																							}
																							?>
																					
																						<div id="registros_anteriores_preuci"></div>
																						
																					</div>
																					
																				</div>
																			</div>
																	</fieldset>
																</div>
																<div class="col">
																	<fieldset class="border p-2">
																		<legend class="float-none w-auto" style ="font-size:20px;">Días estudio</legend>
																		   
																			<div class="d-grid gap-2">
																					
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

																							// Generar los botones en HTML
																							if ($res->num_rows > 0) {
																								
																								$buttonsHTML = "";
																								
																								while ($row = $res->fetch_object()) {
																									
																									$nombre = $row->id_dia; 
																									
																									$buttonsHTML .= '<button class="restore_btn btn btn-success btn-lg" 
																									type="button" style="margin:5px;" value= ' . $nombre . ' name="btn' . $nombre . '" 
																									id="btn' . $nombre . '" 
																									onclick="update_histonas(\'' . $nombre . '\',\'' . $id_tipo_toma . '\')">' . $nombre . '</button>';
																										
																								}
																								
																								echo '<div id="registros_anteriores_uci">' . $buttonsHTML . '</div>';
																							} else {
																								echo 'No se han registrado otros días.';
																							}
																							?>
																					
																						<div id="registros_anteriores_uci"></div>
																						
																					</div>
																					
																				</div>
																			</div>
																	</fieldset>
																</div>
															</div>
													</fieldset>
													<br></br>
													<h2 class="header-title"></h2>
												<p>
												</p>
												<?php
													$pat_id = $_GET['pat_id'];
													$ret="SELECT  * FROM patients WHERE pat_id=?";
													$stmt= $mysqli->prepare($ret) ;
													$stmt->bind_param('s',$pat_id);
													$stmt->execute() ;//ok
													$res=$stmt->get_result();
													//$cnt=1;
													while($row=$res->fetch_object())
													{
												?>
                                                <div id="campos_histonas">
                                                    <div class="form-row justify-content-center" id="custom_day_divs" >
														 <div class="text-center">
															<fieldset style="padding:14px; border:3px solid #14A44D; border-radius: 8px;
															box-shadow: 0 0 10px #666; background:#e8f5e9">
																<legend class=" legendCustom float-none w-auto">Día seleccionado</legend>
																	<div class="form-row">
																		<div class="col-4">
																			<label for="day_monitor" class="col-form-label">Dia</label>
																			<!-- <input type="text" required="required" name="day_monitor"  maxlength="2" class="form-control" 
																			id="day_monitor" onkeypress ="only_int_nums(event)" oninput= "getDateMonitor()" >-->
																			
																			<input name="day_monitor" id="day_monitor"  class="form-control" readonly placeholder="Selecciona">
																				  
																				  
																			
																		</div>
																		
																		
																		<div class="col">
																			<label for="date_monitor" class="col-form-label">Fecha de la toma de datos</label>
																			<input type="date" name="date_monitor" class="form-control" id="date_monitor" readonly>
																		</div>
																		<div class="col">
																			<label for="id_tipo_toma" class="col-form-label">Momento de la toma</label>
																			<select name="id_tipo_toma" id="id_tipo_toma"  class="form-control" >
																				  <option value="">--Selecciona--</option>
																				  <option value="HOSP">Ingreso hospitalario</option>
																				  <option value="preUCI">Días preUCI</option>
																				  <option value="estudio">Días estudio</option>
																				  
																				  																			  
																			</select>
																		</div>
																	</div>
															</fieldset>
														</div>
													</div> 
													<?php }?>											
													<!--<div id= "registros_anteriores">												
														
														<p style="color:red;font-size:15px;">Compruebe si existen datos de registros anteriores, pulsando el botón para visualizarlos: &nbsp;<button type="button" class="btn btn-secondary" style="width:150px;" id="recuperar_datos" onclick="update_histonas()">Recuperar datos</button></p>
													
													</div>-->
													<br></br>
													<h4 class="header-title">Histonas</h4>

													<div class="form-row">

														<div class="form-group col-md-3">
															<label for="h2b_pat" class="col-form-label">H2B</label>
															<input type="text"   name="h2b_pat"class="form-control" id="h2b_pat" placeholder="ng/mL"onkeypress = "only_int_nums(event)">
														</div>

														<div class="form-group col-md-3">
															<label for="h3_pat" class="col-form-label">H3</label>
															<input type="text"  name="h3_pat"  class="form-control"  id="h3_pat" placeholder="ng/mL"onkeypress = "only_int_nums(event)">
														</div>

														<div class="form-group col-md-3">
															<label for="h4_pat" class="col-form-label">H4</label>
															<input  type="text"  name="h4_pat"  class="form-control"  id="h4_pat" placeholder="ng/mL"onkeypress = "only_int_nums(event)">
														</div>
														<div class="form-group col-md-3">
															<label for="pca_pat" class="col-form-label">PCA</label>
															<input  type="text"  name="pca_pat"  class="form-control"  id="pca_pat" placeholder="ng/mL"onkeypress = "only_int_nums(event)">
														</div>
														<div class="form-group col-md-3">
															<label for="il6_pat" class="col-form-label">IL6</label>
															<input  type="text"  name="il6_pat"  class="form-control"  id="il6_pat" placeholder="ng/mL"onkeypress = "only_int_nums(event)">
														</div>
														

														

													</div>
													<div class="form-group">
														<label for="comentarios_histonas">Anotaciones:</label>
														<textarea class="form-control" rows="5" name="comentarios_histonas" id="comentarios_histonas" maxlength="200" spellcheck="true"></textarea>
													</div>

													<button type="submit" name="add_patient_vitals" class="ladda-button btn btn-success" data-style="expand-right">Añadir variables biomédicas</button>
												</div>
                                            </form>
                                            <!--End Patient Form-->
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                        </div> <!-- container -->

                    </div> <!-- content -->

                    <!-- Footer Start -->
                    <?php include('assets/inc/footer.php');?>
                    <!-- end Footer -->

                </div>
				

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        //CKEDITOR.replace('editor')
        </script>

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
		  // Obtener el formulario y el botón de envío
		  var form = document.getElementById("histonas_pac");
		  var submitButton = document.getElementById("add_patient_vitals");

		  // Agregar un evento de escucha al envío del formulario
		  form.addEventListener("submit", function(event) {
			// Obtener los campos de entrada específicos
			var h2b_pat = document.getElementsByName("h2b_pat")[0].value.trim();
			var h3_pat = document.getElementsByName("h3_pat")[0].value.trim();
			var h4_pat = document.getElementsByName("h4_pat")[0].value.trim();
			var pca_pat = document.getElementsByName("pca_pat")[0].value.trim();
			var il6_pat = document.getElementsByName("il6_pat")[0].value.trim();
			var id_tipo_toma = document.getElementsByName("id_tipo_toma")[0].value.trim();
			var day_monitor = document.getElementsByName("day_monitor")[0].value.trim();

			// Verificar si los campos específicos están vacíos
			if (h2b_pat === "" && h3_pat === "" && h4_pat === "" && pca_pat === "" && il6_pat === "") {
			  event.preventDefault(); // Evitar el envío del formulario
			  setTimeout(function () {
								Swal.fire("Atención", "Por favor, complete al menos uno de los campos", "warning");
							}, 100);
			  
			}
			if (id_tipo_toma === "") {
			  event.preventDefault(); // Evitar el envío del formulario
			  setTimeout(function () {
								Swal.fire("Atención", "Por favor, establece un tiempo de toma de datos", "warning");
							}, 100);
			  
			}
			if (day_monitor === "") {
			  event.preventDefault(); // Evitar el envío del formulario
			  setTimeout(function () {
								Swal.fire("Atención", "Por favor, establece un día de toma de datos", "warning");
							}, 100);
			  
			}
		  });
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
		
		var fecha_inicio = document.getElementById('date_ingreso').value;
		fecha_inicio = new Date(fecha_inicio);
		
		var dia_monitor = document.getElementById('day_monitor').value; 
		dia_monitor = new Number(dia_monitor);
		
		var fecha_monitor =    addDays(fecha_inicio,dia_monitor);
		
		
		
		fecha_monitor = fecha_monitor.toISOString().split("T")[0];
				
		document.getElementById('date_monitor').value = fecha_monitor;
		
		
		}
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
			function update_histonas(id_dia,id_tipo_toma) {
				
				var pat_id = '<?php echo $pat_id; ?>';
				var formData = {id_dia: id_dia, pat_id: pat_id, id_tipo_toma: id_tipo_toma};
				
				// Agregar la clase de desenfoque al div objetivo
				var divObjetivo = document.getElementById('campos_histonas');
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
				
					$('#day_monitor').val(id_dia);
					$('#id_tipo_toma').val(id_tipo_toma);
					
					switch(id_tipo_toma){
						
						case 'HOSP':
							var fecha_inicio = document.getElementById('date_ingreso').value;
							fecha_inicio = new Date(fecha_inicio);
							
							var dia_monitor = id_dia;
							dia_monitor = new Number(dia_monitor);
							
							var fecha_monitor =    addDays(fecha_inicio,dia_monitor);
						
						break
						
						case 'preUCI':
							var fecha_inicio = document.getElementById('date_ingreso_uci').value;
							fecha_inicio = new Date(fecha_inicio);
							
							var dia_monitor = id_dia;
							dia_monitor = new Number(dia_monitor);
							
							var fecha_monitor =    substractDays(fecha_inicio,dia_monitor);
						
						break
						
						case 'estudio':
							var fecha_inicio = document.getElementById('date_ingreso_uci').value;
							fecha_inicio = new Date(fecha_inicio);
							
							var dia_monitor = id_dia;
							dia_monitor = new Number(dia_monitor);
							
							var fecha_monitor =    addDays(fecha_inicio,dia_monitor);
						break
					}
					
					
					
					
					
					fecha_monitor = fecha_monitor.toISOString().split("T")[0];
							
					document.getElementById('date_monitor').value = fecha_monitor;

					console.log(id_dia);
					console.log(pat_id);
					$.ajax({
						url: 'assets/inc/recuperar_datos_histonas.php',
						type: 'POST',
						data: formData,
						success: function(response) {
							var res = JSON.parse(response);
							console.log(res);

							if (res.success === true ) {
								$("#h2b_pat").val(res.h2b_pat);
								$("#h3_pat").val(res.h3_pat);
								$("#h4_pat").val(res.h4_pat);
								$("#pca_pat").val(res.pca_pat);
								$("#il6_pat").val(res.il6_pat);
								$("#comentarios_histonas").val(res.comentarios_histonas);
							} else {
								setTimeout(function () {
									Swal.fire("Atención", "No se han encontrado datos previos", "warning");
								}, 100);
							}
						},
						error: function(xhr, status, error) {
							console.log(status);
							console.log(error);
						}
					});
				}, 1000);
			}
	</script>
        
    </body>

</html>