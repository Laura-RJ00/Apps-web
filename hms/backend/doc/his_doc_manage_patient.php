<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  
  $doc_id = $_SESSION['doc_id'];
  
?>

<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
                <?php include('assets/inc/nav.php');?>
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tablero</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
                                            <li class="breadcrumb-item active">Administrar pacientes</li>
                                        </ol>
                                    </div>
                                    <h2 class="page-title">Consulta y exportación de detalles de paciente</h2>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
						<!--<div class="container">-->
							<div class="row">
								<div class="col">
									<div class="card-box">
										<h4 class="header-title"></h4>
										<div class="mb-2">
											<div class="row">
												<div class="col-12 text-sm-center form-inline" >
													<!-- Export link -->
													<div class="col-md-12 head">
														<div class="float-left">
															<button class="btn btn-success" id= "export_button" onclick="download()"> Exportar csv</button>
															<!--<a href="export.php" class="btn btn-info"><i class="dwn"></i> Exportar csv</a>-->
														</div>
													</div>
													
													<!--<div class="form-group">
														<input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
													</div>-->
												</div>
											</div>
											<!--<div class="row" style="display:none">
												<div class="col">
													
												  <h4 class="head-of-editor">Ajustes de filtro:</h4>
												  <div class="checkBoxes"></div>
													  <br />
													  <a class="button button-clear" id="createFilter" href="#">Crear filtro</a><br><br>
													
												
												</div>
											</div>-->
											
										</div>
										<div class="form-group mr-2" >
											<!--<select id="demo-foo-filter-status" class="custom-select custom-select-sm">
												<option value="">Mostrar todos</option>
												
												<option value="OutPatients">Ficha completa</option>
												<option value="InPatients">Ficha incompleta</option>
											</select>-->
										</div>
										
										<!--<div class="row">
											<div class="col">-->
										<div class="table-responsive">
											<table id="table_pats" class="table table-bordered display nowrap " cellspacing="0" width="100%" data-page-size="7">
												<thead>
													<tr>
														<th>#</th>
														<th>Ficha </th> <!-- 1 -->
														<th>ID  </th> <!-- 2 -->
														<th>SIP</th> <!-- 3 -->
														<th>NHC</th> <!-- 4 -->
														<th >Rol estudio</th>
														<!--<th >Tipo de control</th>-->
														<th >Diagnóstico ingreso</th><!-- 5 -->
														<th >Hallazgo clínico</th><!-- 5 -->
														<th>Fecha ingreso</th> <!-- 6 -->
														<th>Fecha alta</th> <!-- 7 -->
														<th>Edad</th> <!-- 8 -->
														<th >Sexo</th> <!-- 9 -->
														
														<th>Acción</th> <!-- 10 -->
														
														
													</tr>
												</thead>
												
												
												<tbody>
												
													<?php
													/*
														*get details of allpatients
														*
													*/
													 //SELECT * FROM  patients WHERE pat_doc_assigned= '$doc_id' ORDER BY pat_index DESC
														$ret="SELECT *
																FROM `patients` 
																LEFT JOIN `control` ON `patients`.pat_id= `control`.`control_pat_id`
																LEFT JOIN `caso` ON `patients`.pat_id= `caso`.`case_pat_id`
																LEFT JOIN `clinical_finding` ON `caso`.`cl_find_id` = `clinical_finding`.`cl_find_id`
																LEFT JOIN `codigo_sexo` ON `patients`.pat_sex= `codigo_sexo`.`sex_codes`
																WHERE pat_doc_assigned ='$doc_id'
																ORDER BY pat_index DESC";
																
														//
														$stmt= $mysqli->prepare($ret) ;
														$stmt->execute() ;//ok
														$res=$stmt->get_result();
														$cnt=0;
														$estado_ficha = [];
														
														
														
														while($row=mysqli_fetch_array($res)){
															
															$cnt++;
															$estado_ficha[] = $row['pat_record_status'];
															$checked = ($row['pat_record_status'] == 1) ? 'checked' : '';
															
															$control_type = !empty($row['control_type']) ? $row['control_type'] : 'No aplica';
															$pat_diag_ingreso = !empty($row['pat_diag_ingreso']) ? $row['pat_diag_ingreso'] : 'No aplica';
															$cl_find_name = !empty($row['cl_find_name']) ? $row['cl_find_name'] : 'No aplica';
															
															$pat_date_ingreso = ($row['pat_date_ingreso']== '1970-01-01' || empty($row['pat_date_ingreso'])) ? 'No registrada' : $row['pat_date_ingreso'] ;
															
															$pat_date_alta = ($row['pat_date_alta']== '1970-01-01'|| empty($row['pat_date_alta'])) ? 'No registrada' : $row['pat_date_alta'] ;
															
															
															
															
													?>
													
																								
													
														<tr>
														<td><?php echo $cnt;?></td>
														<td style="text-align: center; vertical-align: middle;"> 
															<div class="checkdiv grey400">
																<input type="checkbox" class="le-checkbox" id="status_record_<?php echo $cnt;?>" name="status_record" <?php echo $checked;?> disabled/>
																
															</div>
														</td>
														<td><?php echo $row['pat_id'];?></td>
														
														<td><?php echo $row['pat_sip'];?></td>
														<td><?php echo $row['pat_nhc'];?></td>
														<td><?php echo $row['pat_role'];?></td>
															
														<td><?php echo $pat_diag_ingreso;?></td>
														<td><?php echo $cl_find_name;?></td>
														<td><?php echo $pat_date_ingreso;?></td>
														<td><?php echo $pat_date_alta;?></td>
														<td><?php echo $row['pat_age'];?></td>
														<td><?php echo $row['pat_sex_name'];?></td>
														
														<td>
															
															<a href="his_doc_view_single_patient.php?pat_id=<?php echo $row['pat_id'];?>&&pat_index=<?php echo $row['pat_index'];?>" class="badge badge-success"><i class="mdi mdi-eye"></i> Ver</a>
															
														</td>
													</tr>
													
												<?php } ?>
												
													<?php $estado_ficha = json_encode($estado_ficha); ?>
													
												</tbody>  
												
												<tfoot>
													<tr class="active">
														<td colspan="8">
															<div class="text-right">
																<ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
															</div>
														</td>
													</tr>
												</tfoot>
											</table>           
											
										</div>
										
										
									</div> <!-- end card-box -->
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
	
		<!-- Right bar overlay-->
	

	
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
				
    <!--   Datatables-->
		<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  

    <!-- searchPanes   -->
		<script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
    <!-- select -->
		<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>  
		
		<!--<script src="assets/js/jquery.slim.min.js"></script>
		
		<script src="assets/js/popper.min.js"></script>
		
		<script src="assets/js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="assets/libs/datatables/datatables.min.js" ></script>
	   <script src= "assets/libs/datatables/SearchPanes-2.1.2/js/searchPanes.dataTables.min.js" ></script>
	   <script src= "assets/libs/datatables/Select-1.6.2/js/select.dataTables.min.js" ></script>
	   -->
	   
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
	
	<!--<script>
	 
	 //document.querySelector('#status_record').disabled = true;
	 var estado_ficha_1 = <?php echo $estado_ficha; ?>;
	 console.log(estado_ficha_1);
	 
	 <?php for ($i = 1; $i <= $cnt; $i++) { ?>
		
		//var status_checkbox = document.getElementById('status_record_<?php echo $i;?>');
		//status_checked = status_checkbox.checked ;
		
			//status_checkbox.addEventListener('change', function() {
			//  if (this.checked) {
				// Acción si el checkbox está marcado
			  //} else {
				// Acción si el checkbox no está marcado
			  //}
			//});
		
		
	 <?php } ?>
		  
	  
	
	</script>-->
	   
	   
	   
	   
	   <!-- search panes js -->
	   <script>
	    
 
			$(document).ready(function(){
				window.table = $('#table_pats').DataTable({
					"scrollX": true,
					searchPanes: {
						cascadePanes: true,
						dtOpts: {
							dom: 'tp',
							paging: 'true',
							pagingType: 'numbers',
							searching: false,
						},
						layout: 'columns-4',
						language: {
							count: '{total}',
							countFiltered: '{shown} ({total})',
							emptyPanes: 'Sin filtros',
							clearMessage: 'Borrar todo',
							collapse: {
								0: 'Paneles de búsqueda',
								_: 'Paneles de búsqueda (%d)'
							},
							show: 'Mostrar paneles de búsqueda',
							title: 'Filtros activos',
							restore: 'Restaurar'
						}
					},
					dom: 'Plfrtip',
					language: {
						search: 'Buscar:',
						lengthMenu: 'Mostrar _MENU_ registros por página',
						zeroRecords: 'No se encontraron registros',
						info: 'Mostrando _START_ al _END_ de _TOTAL_ registros',
						infoEmpty: 'Mostrando del 0 al 0 de 0 registros',
						infoFiltered: '(filtrados de un total de _MAX_ registros)',
						paginate: {
							first: 'Primero',
							previous: 'Anterior',
							next: 'Siguiente',
							last: 'Último'
						}
					},
					columnDefs: [
						{
							searchPanes: {
								show: true
							},
							targets: [5, 6,7,11]
						},
						{
							searchPanes: {
								show: false
							},
							targets: '_all'
						}
					]
				});
				$('#table_pats').DataTable().searchPanes.rebuildPane();
				
				
				
				
									
				
			});
			
		function download(){
			
				var filteredData = window.table.rows({ search: 'applied' }).data();
				var columnData = filteredData.pluck(2); // 
				var doc_id = '<?php echo $doc_id ?>';

	
				var formData = {
					doc_id: doc_id,
					columnData: columnData.toArray()
				};

				console.log(formData);
				
				
				

				// Enviar los datos a un archivo PHP mediante una solicitud AJAX
				$.ajax({
					url: 'assets/inc/exportData.php',
					type: 'POST',
					data: { formData: formData },
					dataType: 'json', // Esperar una respuesta en formato JSON
					/*processData: false, // Evitar que jQuery procese los datos automáticamente
					contentType: false, // Evitar que jQuery establezca automáticamente el encabezado Content-Type
					  */ 
				
					success: function(response) {
					  console.log(response);
					  //var res = JSON.parse(response);
					  
					  
					  if (response.success) {
						  
						Swal.fire("¡Archivo descargado!", "Por favor revise su carpeta de descargas", "success");
						
						var fileUrl = response.fileUrl;
						var tempFile = response.tempFile;
						var downloadLink = document.createElement('a');
						downloadLink.href = fileUrl;
						downloadLink.download = response.filename;
						downloadLink.style.display = 'none';
						document.body.appendChild(downloadLink);
						downloadLink.click();
						document.body.removeChild(downloadLink);
						
						
						/* var fileUrl = response.fileUrl;
						var downloadLink = document.createElement('a');
						downloadLink.href = fileUrl;
						downloadLink.download = response.filename;
						downloadLink.style.display = 'none';
						document.body.appendChild(downloadLink);
						downloadLink.click();
						document.body.removeChild(downloadLink); */
						
						$.ajax({
							url: 'assets/inc/delete_temp_file.php',
							type: 'POST',
							data: { tempFile: tempFile },
							success: function() {
							  console.log('Archivo temporal eliminado correctamente.');
							},
							error: function() {
							  console.log('Error al eliminar el archivo temporal.');
							}
						  });
						
					
					    } 
					},
					error: function(xhr, status, error) {
					  Swal.fire('Error', 'Ocurrió un error al descargar los datos.', 'error');
					  console.log(status);
					  console.log(error);
					  console.log(xhr);
					  

					
					  
					}
					});
		}	
												
					
					//$('#table_pats').DataTable().searchPanes.rebuildPane();
					

		
		
		</script>
		
		
		
        
    </body>

</html>