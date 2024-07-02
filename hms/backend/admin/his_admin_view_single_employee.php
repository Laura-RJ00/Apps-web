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
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!--Get Details Of A Single User And Display Them Here-->
            <?php
                $user_id=$_GET['user_id'];
				$rol_id=$_GET['rol_id'];
				
                $ret="SELECT  * FROM users
				LEFT JOIN `user_docs` ON `user_id` = `doc_id`
				LEFT JOIN `user_research` ON `user_id` = `res_id`
				LEFT JOIN `users_roles` ON `user_rol` = `rol_id`
				LEFT JOIN `research_centers` ON `res_center`= `center_id`
				LEFT JOIN `hospital_docs` ON `doc_hospital`= `hosp_id`

				WHERE user_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$user_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$doc_number=$_GET['doc_number'];
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tablero</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                                            <li class="breadcrumb-item active">Ver usuarios</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"> Perfil <?php echo $row->user_id;?></h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
							
							
                                <div class="card-box text-center">
                                    <img src="../doc/assets/images/users/<?php echo ($rol_id=='Doctor')? $row->doc_pic : $row->res_pic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>ID :</strong> <span class="ml-2"><?php echo ($rol_id=='Doctor')? $row->doc_id : $row->res_id;?></span></p> 
										<p class="text-muted mb-2 font-13"><strong>Nombre completo:</strong> <span class="ml-2"><?php echo ($rol_id=='Doctor')? $row->doc_name : $row->res_name;?> <?php echo ($rol_id=='Doctor')? $row->doc_surname : $row->res_surname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Rol :</strong> <span class="ml-2"><?php echo $rol_id;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo ($rol_id=='Doctor')? $row->doc_mail : $row->res_mail;?></span></p>
										<p class="text-muted mb-2 font-13"><strong>Origen :</strong> <span class="ml-2"><?php echo ($rol_id=='Doctor')? $row->hosp_name : $row->center_name;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            <!--Vitals-->
                            <div class="col-lg-6 col-xl-6">
								<div class="card-box">
										<h4 class="header-title"> Acciones recientes</h4> 
										<?php
										$user_id =$_GET['user_id'];
										$ret="SELECT `loginTime`,`pat_id`, `pàt_data_joined`, `fecha_descarga`  FROM `users`
										
										LEFT JOIN `userlog` ON  `users`.`user_id`= `userlog`.`user_id`
										LEFT JOIN `historial_descargas` ON  `users`.`user_id`= `historial_descargas`.`usuario`
										LEFT JOIN `patients` ON  `users`.`user_id`= `patients`.`pat_doc_assigned`
										
										WHERE `users`.`user_id` = ?
										
										ORDER BY `loginTime` DESC, `pàt_data_joined` DESC, `fecha_descarga` DESC
										LIMIT 1";
										
										
										$stmt= $mysqli->prepare($ret) ;
										$stmt->bind_param('s',$user_id);
										$stmt->execute() ;//ok
										$res=$stmt->get_result();
										
										
										if($row=$res->fetch_object())
											{
									   
											$last_login = ($row->loginTime == null || empty($row->loginTime)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->loginTime));
											$last_pat = (is_null($row->pat_id) || empty($row->pat_id)) ? 'No hay registros' : $row->pat_id;
											$last_pat_date = ($row->pàt_data_joined == null || empty($row->pàt_data_joined)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->pàt_data_joined));
											$last_descarga = ($row->fecha_descarga == null || empty($row->fecha_descarga)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->fecha_descarga));
																		
										
										} else {
											// No se encontraron registros
											$last_login = 'No hay registros';
											$last_pat = 'No hay registros';
											$last_pat_date = 'No hay registros';
											$last_descarga = 'No hay registros';
}
									?>
									
									<div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Último inicio de sesión :</strong> <span class="ml-2"><?php echo $last_login;?></span></p>
										<p class="text-muted mb-2 font-13"><strong>Paciente introducido reciente:</strong> <span class="ml-2"><?php echo $last_pat;?> <?php echo $last_pat_date;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Descarga reciente:</strong> <span class="ml-2"><?php echo $last_descarga;?></span></p>
                                        


                                    </div>
									
									
								</div>	<!-- end col-->
							</div>	
                        </div>
                        <!-- end row-->
						<div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box">
									<h4 class="header-title"> Historial de sesiones</h4> <br>
										<div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                
                                                <div class="form-group">
                                                    <input id="demo-foo-search-sesion" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="table-responsive">
										<table id="demo-foo-filtering-sesion" class="table table-bordered toggle-circle mb-0" data-page-size="7">
											<thead class="thead-light">
												<tr>
													<th>#</th>
													<th>Inicio de sesión</th>
													<th>Cierre de sesión</th>
													
												</tr>
											</thead>
											
												<tbody>
												<?php
												$user_id =$_GET['user_id'];
												$ret="SELECT * FROM userlog 
												WHERE user_id = ?
												ORDER BY loginTime DESC";
												$stmt= $mysqli->prepare($ret) ;
												$stmt->bind_param('s',$user_id);
												$stmt->execute() ;//ok
												$res=$stmt->get_result();

												$cnt=1;
												
												while($row=$res->fetch_object())
													{
											   
												$tiempo_login = ($row->loginTime == null || empty($row->loginTime)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->loginTime));
												$tiempo_logout = ($row->logOutTime == null || empty($row->logOutTime)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->logOutTime));

											?>
													<tr>
														<td><?php echo $cnt;?></td>
														<td><?php echo $tiempo_login;?></td>
														<td><?php echo $tiempo_logout;?></td>
														
													</tr>
												<?php  $cnt = $cnt +1 ; }?>
												</tbody>
												 <tfoot>
												<tr class="active">
													<td colspan="3">
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
									<div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                
                                                <div class="form-group">
                                                    <input id="demo-foo-search-dw" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
									<div class="table-responsive">
										<table id="demo-foo-filtering-dw" class="table table-bordered toggle-circle mb-0" data-page-size="7">
											<thead class="thead-light">
												<tr>
													<th>#</th>
													<th>Fecha</th>
													
												</tr>
											</thead>
											<tbody>
											<?php
												$user_id =$_GET['user_id'];
												$ret="SELECT * FROM historial_descargas 
												WHERE usuario = ?
												ORDER BY index_descarga DESC";
												$stmt= $mysqli->prepare($ret) ;
												$stmt->bind_param('s',$user_id);
												$stmt->execute() ;//ok
												$res=$stmt->get_result();
												$cnt=1;
												
												while($row=$res->fetch_object())
													{
											   
												$tiempo_descarga = ($row->fecha_descarga == null || empty($row->fecha_descarga)) ? 'No registrada' : date("d/m/Y - H:i", strtotime($row->fecha_descarga));
												
											?>
												
													<tr>
														<td><?php echo $cnt;?></td>
														<td><?php echo $tiempo_descarga;?></td>
														
													</tr>
												
											 <?php  $cnt = $cnt +1 ; }?>
											 </tbody>
											  <tfoot>
                                            <tr class="active">
                                                <td colspan="2">
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
										<div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                
                                                <div class="form-group">
                                                    <input id="demo-foo-search-pats" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="table-responsive">
										<table id="demo-foo-filtering-pats" class="table table-bordered toggle-circle mb-0" data-page-size="7">
											<thead class="thead-light">
												<tr>
													<th>#</th>
													<th>Paciente ID</th>
													<th>Registro</th>
													
												</tr>
											</thead>
											<tbody>
											<?php
												$user_id =$_GET['user_id'];
												$ret="SELECT `pàt_data_joined`,`pat_id` FROM `patients` 
												WHERE `pat_doc_assigned` = ?
												ORDER BY `pàt_data_joined` DESC";
												$stmt= $mysqli->prepare($ret) ;
												$stmt->bind_param('s',$user_id);
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
														<td><?php echo $pat_num;?></td>
														<td><?php echo $tiempo_pat;?></td>
														
													</tr>
												
											 <?php  $cnt = $cnt +1 ; }?>
												</tbody>
												 <tfoot>
                                            <tr class="active">
                                                <td colspan="3">
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
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>
            <?php }?>

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
		
		
		<script>
		$(document).ready(function() {
			$('#demo-foo-filtering-sesion').footable();
			$('#demo-foo-filtering-dw').footable();
			$('#demo-foo-filtering-pats').footable();
			
			
			// Event handler for search input
			$('#demo-foo-search-sesion').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-sesion').data('footable-filter').filter(searchText);
				
			});
			
			$('#demo-foo-search-dw').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-dw').data('footable-filter').filter(searchText);
				
			});
			
			$('#demo-foo-search-pats').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-pats').data('footable-filter').filter(searchText);
				
			});
		});
		</script>

    </body>


</html>