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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Informes</a></li>
                                            <li class="breadcrumb-item active">Ver informes de usuarios</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detalles de informes de actividad</h4>
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
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
										<div class="col-lg-6 col-xl-6">
											<div class="card-box">
												<h4 class="header-title"> Historial de sesiones</h4> <br>
													
												<div class="table-responsive">
													<table id="demo-foo-filtering-sesion" class="table table-bordered toggle-circle mb-0" data-page-size="8">
														<thead class="thead-light">
															<tr>
																<th>#</th>
																<th>Usuario ID</th>
																<th>Inicio de sesión</th>
																<th>Cierre de sesión</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$ret = "SELECT * FROM userlog ORDER BY loginTime DESC";
															$stmt = $mysqli->prepare($ret);
															$stmt->execute();
															$res = $stmt->get_result();
															$cnt = 1;

															while ($row = $res->fetch_object()) {
																$tiempo_login = ($row->loginTime == null || empty($row->loginTime)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->loginTime));
																$tiempo_logout = ($row->logOutTime == null || empty($row->logOutTime)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->logOutTime));
															?>
																<tr>
																	<td><?php echo $cnt; ?></td>
																	<td><?php echo $row->user_id; ?></td>
																	<td><?php echo $tiempo_login; ?></td>
																	<td><?php echo $tiempo_logout; ?></td>
																</tr>
															<?php
																$cnt = $cnt + 1;
															}
															?>
														</tbody>
														<tfoot>
															<tr class="active">
																<td colspan="4">
																	<div class="text-right">
																		<ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
																	</div>
																</td>
															</tr>
														</tfoot>
													</table>
												</div>


											</div> <!-- end card-box -->

										</div> <!-- end col-->
										<!--Vitals-->
										<div class="col-lg-6 col-xl-6">
											<div class="card-box">
												<h4 class="header-title"> Historial de descargas</h4> <br>
													
												<div class="table-responsive">
													<table id="demo-foo-filtering-descargas" class="table table-bordered toggle-circle mb-0" data-page-size="8">
														<thead class="thead-light">
															<tr>
																<th>#</th>
																<th>Usuario ID</th>
																<th>Fecha</th>
																
															</tr>
														</thead>
														
															<tbody>
															<?php
															$ret="SELECT * FROM historial_descargas 
															ORDER BY index_descarga DESC";
															$stmt= $mysqli->prepare($ret) ;
															$stmt->execute() ;//ok
															$res=$stmt->get_result();
															$cnt=1;
															
															while($row=$res->fetch_object())
																{
														   
															$tiempo_descarga = ($row->fecha_descarga == null || empty($row->fecha_descarga)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->fecha_descarga));
															
														?>
																<tr>
																	<td><?php echo $cnt;?></td>
																	<td><?php echo $row->usuario;?></td>
																	<td><?php echo $tiempo_descarga;?></td>
																	
																</tr>
															 <?php  $cnt = $cnt +1 ; }?>
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
												
											</div>	<!-- end col-->
										</div>	
										<div class="col-lg-6 col-xl-6">
											<div class="card-box">
												<h4 class="header-title"> Historial de pacientes</h4> <br>
													
												<div class="table-responsive">
													<table id="demo-foo-filtering-pacientes" class="table table-bordered toggle-circle mb-0" data-page-size="8">
														<thead class="thead-light">
															<tr>
																<th>#</th>
																<th>Usuario ID</th>
																<th>Paciente ID</th>
																<th>Registro</th>
																
															</tr>
														</thead>
														
															<tbody>
															<?php
															
															$ret="SELECT `pàt_data_joined`,`pat_id`, `pat_doc_assigned` FROM `patients` 
															ORDER BY `pàt_data_joined` DESC";
															$stmt= $mysqli->prepare($ret) ;
															$stmt->execute() ;//ok
															$res=$stmt->get_result();
															$cnt=1;
															
															while($row=$res->fetch_object())
																{
														   
															$tiempo_pat = ($row->pàt_data_joined == null || empty($row->pàt_data_joined)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->pàt_data_joined));
															$pat_num = (is_null($row->pat_id) || empty($row->pat_id)) ? 'No hay registros' : $row->pat_id;
															
														?>
																<tr>
																	<td><?php echo $cnt;?></td>
																	<td><?php echo $row->pat_doc_assigned;?></td>
																	<td><?php echo $pat_num;?></td>
																	<td><?php echo $tiempo_pat;?></td>
																	
																</tr>
															 <?php  $cnt = $cnt +1 ; }?>
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
												
											</div>	<!-- end col-->
										</div>
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
		<script>
		$(document).ready(function() {
			$('#demo-foo-filtering-sesion').footable();
			$('#demo-foo-filtering-descargas').footable();
			$('#demo-foo-filtering-pacientes').footable();
			
			// Event handler for search input
			$('#demo-foo-search').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-sesion').data('footable-filter').filter(searchText);
				$('#demo-foo-filtering-descargas').data('footable-filter').filter(searchText);
				$('#demo-foo-filtering-pacientes').data('footable-filter').filter(searchText);
			});
		});
		</script>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		<script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>