<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_profile']))
		{
			$admin_name=$_POST['admin_name'];
			$admin_surname=$_POST['admin_surname'];
			$ad_id=$_SESSION['ad_id'];
            $admin_mail=$_POST['admin_mail'];
           // $doc_pwd=sha1(md5($_POST['doc_pwd']));
            $admin_pic=$_FILES["admin_pic"]["name"];
		    move_uploaded_file($_FILES["admin_pic"]["tmp_name"],"assets/images/users/".$_FILES["admin_pic"]["name"]);

            //sql to insert captured values
			$query="UPDATE user_admin SET admin_name=?, admin_surname=?,  admin_mail=?, admin_pic=? WHERE admin_id = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssss', $admin_name, $admin_surname, $admin_mail, $admin_pic, $ad_id);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Perfil actualizado";
			}
			else {
				$err = "Ha ocurrido un error, vuelva a intentarlo más tarde";
			}
			
			
        }
        //Change Password
        if(isset($_POST['update_pwd']))
		{
            $ad_id=$_SESSION['ad_id'];
            $admin_pwd=sha1(md5($_POST['admin_pwd']));//double encrypt 
			
            
            //sql to insert captured values
			$query="UPDATE user_admin SET admin_pwd =? WHERE admin_id = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ss', $admin_pwd, $ad_id);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Contraseña actualizada";
			}
			else {
				$err = "Ha ocurrido un error, vuelva a intentarlo más tarde";
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
                <?php include('assets/inc/sidebar.php');?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                $aid=$_SESSION['ad_id'];
                $ret="select * from user_admin where admin_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$aid);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
					
					$old_contraeña=$row->admin_pwd;
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
                                                <li class="breadcrumb-item active">Perfil</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Perfil <?php echo $row->admin_id;?> <?php echo $row->admin_name;?></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->

                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <div class="card-box text-center">
                                        <img src="assets/images/users/<?php echo $row->admin_pic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                            alt="profile-image">

                                        <h4 class="mb-0"><?php echo $row->admin_id;?> <?php echo $row->admin_name;?></h4>
                                        <p class="text-muted">@Administrador_del_sistema_HMSS</p>
                                        <div class="text-left mt-3">
                                            <p class="text-muted mb-2 font-13"><strong>Nombre completo:</strong> <span class="ml-2"><?php echo $row->admin_name;?> <?php echo $row->admin_surname;?></span></p>
                                            <p class="text-muted mb-2 font-13"><strong>Correo :</strong> <span class="ml-2 "><?php echo $row->admin_mail;?></span></p>
                                        </div>

                                    </div> <!-- end card-box -->
                                   
                                </div> <!-- end col-->

                                <div class="col-lg-8 col-xl-8">
                                    <div class="card-box">
                                        <ul class="nav nav-pills navtab-bg nav-justified">
                                            <li class="nav-item">
                                                <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                    Actualizar perfil
                                                </a>
                                            </li>
                                            
                                            <li class="nav-item">
                                                <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                    Cambiar contraseña
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="aboutme">

                                            <form method="post" enctype="multipart/form-data">
                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Información </h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="admin_name">Nombre</label>
                                                                <input type="text" name="admin_name"  class="form-control" id="admin_name" value="<?php echo $row->admin_name;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="admin_surname">Apellidos</label>
                                                                <input type="text" name="admin_surname" class="form-control" id="admin_surname" value="<?php echo $row->admin_surname;?>">
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="admin_mail">Correo</label>
                                                                <input type="email" name="admin_mail" class="form-control" id="admin_mail" value="<?php echo $row->admin_mail;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="admin_pic">Avatar</label>
                                                                <input type="file" name="admin_pic" class="form-control btn btn-success" id="admin_pic" value="<?php echo $row->admin_pic;?>">
                                                            </div>
                                                        </div>
                                                        
                                                    </div> <!-- end row -->

                                                    
                                                    <div class="text-right">
                                                        <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Guardar</button>
                                                    </div>
                                                </form>


                                            </div> <!-- end tab-pane -->
                                            <!-- end about me section content -->

                                           

                                            <div class="tab-pane" id="settings">
                                                <form id="passwords" method="post">
                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Información personal</h5>
                                                    <div class="row">
                                                        <!--<div class="col-md-6" >
                                                            <div class="form-group">
                                                                <label for="old_pwd">Antigua contraseña</label>
                                                                <input type="password" class="form-control" id="old_pwd" name="old_pwd" placeholder="Introduzca última contraseña">
                                                            </div>
                                                        </div>-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="admin_pwd">Nueva contraseña</label>
                                                                <input type="password" class="form-control" name="admin_pwd" id="admin_pwd" placeholder="Introduzca nueva contraseña">
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="confirm_pwd">Confirma la contraseña</label>
																<input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd"  placeholder="Confirma la nueva contraseña">
															</div>
														</div>	
													</div>

                                                    <div class="text-right">
                                                        <button type="submit" name="update_pwd" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Actualizar contraseña</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end settings content-->

                                        </div> <!-- end tab-content -->
                                    </div> <!-- end card-box-->

                                </div> <!-- end col -->
                            </div>
                            <!-- end row-->

                        </div> <!-- container -->

                    </div> <!-- content -->

                    <!-- Footer Start -->
                    <?php include("assets/inc/footer.php");?>
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

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
		<script>
		// Esperar a que el documento esté completamente cargado
			document.addEventListener('DOMContentLoaded', function() {
			  // Obtener el formulario
			  var form = document.getElementById('passwords');

			  // Agregar un evento de escucha para el envío del formulario
			  form.addEventListener('submit', function(event) {
				// Obtener los valores de los campos de contraseña
				
				
				var newPwd = document.getElementById('admin_pwd').value;
				var confirmPwd = document.getElementById('confirm_pwd').value;

				// Validar que la nueva contraseña y la confirmación coincidan
				if (newPwd !== confirmPwd) {
				  // Detener el envío del formulario
				  event.preventDefault();
				  
				  // Mostrar mensaje de error al usuario
				  alert('La nueva contraseña y la confirmación no coinciden.');
				}
				
				/* if (oldPwd !== old_password_server) {
				  // Detener el envío del formulario
				  event.preventDefault();
				  
				  // Mostrar mensaje de error al usuario
				  alert('La contraseña antigua introducida no coincide con la actual, por favor,introduce la contraseña más reciente para poder hacer efectivo el cambio de contraseña');
				}  */
			  });
			});


		</script>
    </body>


</html>