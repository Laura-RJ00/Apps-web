<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
  
	
?>



<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>

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
                                    <h4 class="page-title">Administrar pacientes</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                <div class="form-group mr-2" style="display:none">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Show all</option>
                                                       
                                                        <option value="OutPatients">OutPatients</option>
                                                        <option value="InPatients">InPatients</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="25">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">ID</th>
                                                <th data-hide="phone">Rol</th>
                                                <th data-hide="phone">Doctor asignado</th>
                                                <th data-hide="phone">Hospital</th>
												<th data-hide="phone">Ingreso hospital</th>
												<th data-hide="phone">Ingreso en UCI</th>
												<th data-hide="phone">Alta de UCI</th>
												<th data-hide="phone">Alta hospital</th>
                                                <th data-hide="phone">Registro</th>
												<th data-hide="phone">Acción</th>
												<!--<th data-hide="phone">Última modificación</th-->
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                                $ret="SELECT *
														FROM patients 
														LEFT JOIN control ON patients.pat_id= control.control_pat_id
														LEFT JOIN caso ON patients.pat_id= caso.case_pat_id
														LEFT JOIN clinical_finding ON caso.cl_find_id = clinical_finding.cl_find_id
														LEFT JOIN codigo_sexo ON patients.pat_sex= codigo_sexo.sex_codes
														LEFT JOIN user_docs ON patients.pat_doc_assigned = user_docs.doc_id
														LEFT JOIN hospital_docs ON user_docs.doc_hospital= hospital_docs.hosp_id
														ORDER BY pat_index DESC"; 
                                                //sql code to get to ten docs  randomly
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
													$mysqlDateTime = $row->pàt_data_joined;

													$fecha_ingreso_hosp = ($row->pat_date_ingreso == null || empty($row->pat_date_ingreso)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_date_ingreso));
													$fecha_ingreso_uci = ($row->pat_date_ingreso_uci == null || empty($row->pat_date_ingreso_uci)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_date_ingreso_uci));

													$fecha_alta_hosp = ($row->pat_date_alta == null || empty($row->pat_date_alta)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_date_alta));
													$fecha_alta_uci = ($row->pat_date_alta_uci == null || empty($row->pat_date_alta_uci)) ? 'No registrada' : date("d/m/Y", strtotime($row->pat_date_alta_uci));
													 
												?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
													<td><?php echo $row->pat_id; ?> </td>
													<td><?php echo $row->pat_role; ?></td>
													<td><?php echo $row->pat_doc_assigned; ?></td>
													<td><?php echo $row->hosp_name; ?></td>
													<td><?php echo $fecha_ingreso_hosp; ?></td>
													<td><?php echo $fecha_ingreso_uci; ?></td>
													<td><?php echo $fecha_alta_uci; ?></td>
													<td><?php echo $fecha_alta_hosp; ?></td>
													<td><?php echo date("d/m/Y", strtotime($mysqlDateTime)); ?></td>
													
                                                    
													<td style="width: 310px;">
														
                                                        <a href="his_admin_view_single_patient_record.php?pat_id=<?php echo $row->pat_id;?>&&pat_index=<?php echo $row->pat_index;?>" class="badge badge-success  btn-fixed-width"><i class="mdi mdi-eye"></i> Ver ficha</a>
                                                        <!--<a href="his_admin_update_single_patient.php?pat_id=<?php echo $row->pat_id;?>" class="badge badge-primary"><i class="mdi mdi-check-box-outline "></i> Modificar</a>-->
														<button class="eliminarDia mdi mdi-trash-can-outline btn-danger btn-fixed-width" data-id="<?php echo $row->pat_index;?>"> Eliminar</button>
													</td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="11">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
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


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
		
		<!-- script custom -->
		
				<script>
		$(document).ready(function() {
		  // Manejar el clic en el botón de eliminar
		  $(document).on('click', '.eliminarDia', function() {
			// Obtener el ID del día a eliminar
			var pat_id = $(this).data('id');
			
			console.log(pat_id)
			
			// Confirmar la eliminación
			if (confirm('¿Estás seguro de que deseas eliminar este paciente?')) {
			  // Realizar la solicitud AJAX para eliminar el día de la base de datos
			  $.ajax({
				url: 'assets/inc/eliminarPaciente.php', // Ruta al script PHP que elimina el día
				method: 'POST',
				data: { pat_id: pat_id }, // Enviar el ID del día al script PHP
				success: function(response) {
				 
				  // Mostrar mensaje de éxito o realizar otras acciones necesarias
				  
				  location.reload();
				},
				error: function(xhr, status, error) {
				  // Manejar errores de la solicitud AJAX
				  console.error(error);
				  alert('Ocurrió un error al eliminar el usuario.');
				}
			  });
			}
		  });
		});
</script>
        
    </body>

</html>