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
                                           <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Tableros</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Colaboradores</a></li>
                                            <li class="breadcrumb-item active">Administrar entidades</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Colaboradores</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title">Hospitales</h4>
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
                                                <th data-toggle="true">Nombre</th>
                                                <th data-hide="phone">Localización</th>
                                                <th data-hide="phone">Responsable</th>
                                                <th data-hide="phone">Contacto</th>
                                                <th data-hide="phone">Acción</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                                $ret="SELECT * FROM  hospital_docs
												ORDER BY hosp_name ASC "; 
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->hosp_name;?></td>
                                                    <td><?php echo $row->hosp_location;?></td>
                                                    <td><?php echo $row->hosp_resp_name;?></td>
                                                    <td><?php echo $row->hosp_resp_mail;?></td>
                                                   

                                                    <td style="width: 310px;">
														<a href="his_admin_view_single_pharm.php?ent_id=<?php echo $row->hosp_id;?>&&ent_type=hospital" class="badge badge-success  btn-fixed-width"><i class="far fa-eye "></i> Ver</a>
														<a href="his_admin_update_single_pharm.php?ent_id=<?php echo $row->hosp_id;?>&&ent_type=hospital" class="badge badge-warning  btn-fixed-width"><i class="fas fa-clipboard-check "></i> Editar</a>
														<button class="eliminarDia mdi mdi-trash-can-outline btn-danger btn-fixed-width" data-id="<?php echo $row->hosp_id . '_' . 'hospital'; ?>">Eliminar</button>
													</td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
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
						<hr>
						<div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title">Investigación</h4>
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
                                                <th data-toggle="true">Nombre</th>
                                                <th data-hide="phone">Localización</th>
                                                <th data-hide="phone">Responsable</th>
                                                <th data-hide="phone">Contacto</th>
                                                <th data-hide="phone">Acción</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                                $ret="SELECT * FROM  research_centers
												ORDER BY RAND() "; 
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->center_name;?></td>
                                                    <td><?php echo $row->res_location;?></td>
                                                    <td><?php echo $row->res_responsable;?></td>
                                                    <td><?php echo $row->res_center_mail;?></td>
                                                    

                                                    <td style="width: 310px;">
														<a href="his_admin_view_single_pharm.php?ent_id=<?php echo $row->center_id;?>&&ent_type=research" class="badge badge-success  btn-fixed-width"><i class="far fa-eye "></i> Ver</a>
														<a href="his_admin_update_single_pharm.php?ent_id=<?php echo $row->center_id;?>&&ent_type=research" class="badge badge-warning  btn-fixed-width"><i class="fas fa-clipboard-check "></i> Editar</a>
														<button class="eliminarDia mdi mdi-trash-can-outline btn-danger btn-fixed-width" data-id="<?php echo $row->center_id . '_' . 'research'; ?>">Eliminar</button>
													</td>
												</tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
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
		  // Manejar el clic en el botón de eliminar
		  $(document).on('click', '.eliminarDia', function() {
			// Obtener el ID del día a eliminar
			var ent_id = $(this).data('id').split('_')[0];
			var ent_type = $(this).data('id').split('_')[1];
			
			// Confirmar la eliminación
			if (confirm('¿Estás seguro de que deseas eliminar esta entidad?')) {
			  // Realizar la solicitud AJAX para eliminar el día de la base de datos
			  $.ajax({
				url: 'assets/inc/eliminarEntidad.php', // Ruta al script PHP que elimina el día
				method: 'POST',
				data: { ent_id: ent_id, ent_type: ent_type }, // Enviar el ID del día al script PHP
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
        
    </body>

</html>