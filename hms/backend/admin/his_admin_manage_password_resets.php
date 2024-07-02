<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
  if(isset($_GET['deleteRequest']))
  {
        $id=intval($_GET['deleteRequest']);
        $adn="DELETE FROM reset_pwd_usuarios WHERE  id = ?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	 
  
          if($stmt)
          {
            $success = "Eliminado";
          }
            else
            {
                $err = "Ha ocurrido un error, inténtalo de nuevo";
            }
    }
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reseteo contraseñas</a></li>
                                            <li class="breadcrumb-item active">Administrar</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Solicitudes de reseteo de contraseña</h4>
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
                                                    <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">Correo</th>
                                                <th data-hide="phone">Token reseteo contraseña</th>
                                                <th data-hide="phone">Fecha solicitada</th>
                                                <th data-hide="phone">Acción</th>
                                            </tr>
                                            </thead>
                                            <?php
                                                
                                                $ret="SELECT * FROM  reset_pwd_usuarios
												LEFT JOIN users ON email = user_mail
												
												ORDER BY fecha_solicitud ASC "; 
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
												
                                                while($row=$res->fetch_object())
                                                {
                                                    //trim timestamp to DD-MM-YYYY Formart
                                                    $requestedtime = $row->fecha_solicitud;

                                                    if($row->status == 'Pending')
                                                    {
                                                        $action = "<td><a href='his_admin_update_doc_password.php?email=$row->email&pwd=$row->pwd' class='badge badge-danger'><i class='fas fa-edit'></i>Resetear contraseña</a></td>";
                                                    }
                                                    else
                                                    {
                                                        $action = "<td><a href='mailto:$row->email?subject=Solicitud de reseteo de contraseña&body=Token:$row->token, Hola $row->user_id esta es tu nueva contraseña=$row->pwd' class='badge badge-success'><i class='fas fa-envelope'></i> Enviar correo</a>
														
														<button class='eliminarDia mdi mdi-trash-can-outline btn-danger' data-id=$row->email></button></td>";
													}
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->email;?></td>
                                                    <td><?php echo $row->token;?></td>
                                                    <td><?php echo date('d/m/Y - H:i'), strtotime($requestedtime);?></td>
                                                    <?php echo $action;?>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
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
			var email = $(this).data('id');
			
			
			// Confirmar la eliminación
			if (confirm('¿Estás seguro de que deseas eliminar las peticiones asignadas a este usuario?')) {
			  // Realizar la solicitud AJAX para eliminar el día de la base de datos
			  $.ajax({
				url: 'assets/inc/eliminar_peticionReset.php', // Ruta al script PHP que elimina el día
				method: 'POST',
				data: { email: email }, // Enviar el ID del día al script PHP
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