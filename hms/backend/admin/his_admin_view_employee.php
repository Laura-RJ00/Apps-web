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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                                            <li class="breadcrumb-item active">Ver usuarios</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detalles de usuario</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"> Doctores/as</h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                
                                                <div class="form-group">
                                                    <input id="demo-foo-search-docs" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering-docs" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">ID</th>
                                                <th data-hide="phone">Nombre</th>
                                                <th data-hide="phone">Email</th>
                                                <th data-hide="phone">Origen</th>
												<th data-hide="phone">Acción</th>
                                            </tr>
                                            </thead>
                                            

                                                <tbody>
												<?php
													$mysqli->query("SET sql_mode=''");
													 $ret="SELECT * FROM `user_docs`
															LEFT JOIN `hospital_docs` ON `doc_hospital`= `hosp_id`
															ORDER BY doc_surname "; 
														//sql code to get to ten docs  randomly
														$stmt= $mysqli->prepare($ret) ;
														$stmt->execute() ;//ok
														$res=$stmt->get_result();
														$cnt=1;
														while($row=$res->fetch_object())
														{
													?>
												<tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td>
														<?php echo $row->doc_id;?>
                                                    </td>
                                                    
													<td>
													  <?php echo $row->doc_name;?> <?php echo $row->doc_surname;?>
													  
													</td>
												
												    
                                                    <td>
                                                        <?php echo $row->doc_mail;?>
														
                                                    </td>
                                                    
													<td>
                                                        <?php echo $row->hosp_name;?>
														
                                                    </td>
                                                    <td style="width: 310px;">
                                                        <a href="his_admin_view_single_employee.php?user_id=<?php echo $row->doc_id;?>&&rol_id=Doctor" class="badge badge-success btn-fixed-width"><i class="mdi mdi-eye"></i> Ver</a>
														<a href="his_admin_update_single_employee.php?user_id=<?php echo $row->doc_id;?>&&rol_id=Doctor" class="badge badge-primary btn-fixed-width"><i class="mdi mdi-check-box-outline "></i> Editar</a>
														<button class="eliminarDia mdi mdi-trash-can-outline btn-danger btn-fixed-width" data-id="<?php echo $row->doc_id;?>">Eliminar</button>
												   </td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                </tr>
                                                <?php  $cnt = $cnt +1 ; }?>
                                                </tbody>
                                            
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="6">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
								<div class="card-box">
                                    <h4 class="header-title"> Invetigadores/as</h4>
                                    <div class="mb-2">
										<div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                
                                                <div class="form-group">
                                                    <input id="demo-foo-search-res" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering-res" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">ID</th>
                                                <th data-hide="phone">Nombre</th>
                                                <th data-hide="phone">Email</th>
                                                <th data-hide="phone">Origen</th>
												<th data-hide="phone">Acción</th>
                                            </tr>
                                            </thead>
                                            

                                                <tbody>
												<?php
											 $mysqli->query("SET sql_mode=''");
                                             $ret="SELECT * FROM `user_research`
													LEFT JOIN `research_centers` ON `res_center`= `center_id`
													LEFT JOIN `users` ON `res_id`= `user_id`
													ORDER BY res_surname "; 
                                                //sql code to get to ten docs  randomly
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>
												<tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td>
														<?php echo $row->res_id;?>
                                                    </td>
                                                    
													<td>
													  <?php echo $row->res_name;?> <?php echo $row->res_surname;?>
													  
													</td>
												
												    
                                                    <td>
                                                        <?php echo $row->res_mail;?>
														
                                                    </td>
                                                    
													<td>
                                                        <?php echo $row->center_name;?>
														
                                                    </td>
                                                    <td style="width: 310px;">
                                                        <a href="his_admin_view_single_employee.php?user_id=<?php echo $row->res_id;?>&&rol_id=Investigador" class="badge badge-success btn-fixed-width"><i class="mdi mdi-eye"></i> Ver</a>
														<a href="his_admin_update_single_employee.php?user_id=<?php echo $row->res_id;?>&&rol_id=Investigador" class="badge badge-primary btn-fixed-width"><i class="mdi mdi-check-box-outline"></i> Editar</a>
														<button class="eliminarDia mdi mdi-trash-can-outline btn-danger btn-fixed-width" data-id="<?php echo $row->res_id;?>">Eliminar</button>

												   </td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                </tr>
                                                 <?php  $cnt = $cnt +1 ; }?>
                                                </tbody>
                                           
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="6">
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
		
		<script>
		$(document).ready(function() {
		  // Manejar el clic en el botón de eliminar
		  $(document).on('click', '.eliminarDia', function() {
			// Obtener el ID del día a eliminar
			var user_id = $(this).data('id');
			
			
			// Confirmar la eliminación
			if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
			  // Realizar la solicitud AJAX para eliminar el día de la base de datos
			  $.ajax({
				url: 'assets/inc/eliminarUsuario.php', // Ruta al script PHP que elimina el día
				method: 'POST',
				data: { user_id: user_id }, // Enviar el ID del día al script PHP
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
<script>
		$(document).ready(function() {
			$('#demo-foo-filtering-docs').footable();
			$('#demo-foo-filtering-res').footable();
			
			
			// Event handler for search input
			$('#demo-foo-search-docs').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-docs').data('footable-filter').filter(searchText);
				
			});
			
			$('#demo-foo-search-res').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-res').data('footable-filter').filter(searchText);
				
			});
		});
		</script>

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