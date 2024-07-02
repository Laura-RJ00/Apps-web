<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_profile']))
		{
			$res_name=$_POST['res_name'];
			$res_surname=$_POST['res_surname'];
			$res_index=$_SESSION['res_index'];
            $res_mail=$_POST['res_mail'];
           // $res_pwd=sha1(md5($_POST['res_pwd']));
            $res_dpic=$_FILES["res_pic"]["name"];
		    move_uploaded_file($_FILES["res_pic"]["tmp_name"],"assets/images/users/".$_FILES["res_pic"]["name"]);

            //sql to insert captured values
			$query="UPDATE user_research SET res_name=?, res_surname=?,  res_mail=?, res_pic=? WHERE res_index = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssi', $res_name, $res_surname, $res_mail, $res_pic, $res_index);
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
				$err = "Por favor vuelva a intentarlo o pruebe más tarde";
			}
			
			
        }
        //Change Password
        if(isset($_POST['update_pwd']))
		{
            $res_id=$_SESSION['res_id'];
            $res_pwd=sha1(md5($_POST['res_pwd']));//double encrypt 
            
            //sql to insert captured values
			$query="UPDATE user_research SET res_pwd =? WHERE res_id = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('si', $res_pwd, $res_id);
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
				$err = "Por favor vuelva a intentarlo o pruebe más tarde";
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
                $res_index=$_SESSION['res_index'];
                $ret="SELECT * FROM  user_research where res_index=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$res_index);
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tablero</a></li>
                                                <li class="breadcrumb-item active">Perfil</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title"><?php echo $row->res_name;?> <?php echo $row->res_surname;?> perfil </h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title -->

                            <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="../res/assets/images/users/<?php echo $row->res_pic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Nombre completo:</strong> <span class="ml-2"><?php echo $row->res_name;?> <?php echo $row->res_surname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Centro de investiación :</strong> <span class="ml-2"><?php echo $row->res_center;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Identificador:</strong> <span class="ml-2"><?php echo $row->res_id;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Correo electrónico :</strong> <span class="ml-2"><?php echo $row->res_mail;?></span></p>


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
                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Información personal</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="firstname">Nombre</label>
                                                                <input type="text" name="res_name"  class="form-control" id="firstname" placeholder="<?php echo $row->res_name;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lastname">Apellidos</label>
                                                                <input type="text" name="res_surname" class="form-control" id="lastname" placeholder="<?php echo $row->res_surname;?>">
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="useremail">Correo electrónico</label>
                                                                <input type="email" name="res_mail" class="form-control" id="useremail" placeholder="<?php echo $row->res_mail;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="useremail">Avatar</label>
                                                                <input type="file" name="res_pic" class="form-control btn btn-success" id="useremail" >
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
                                                <form method="post">
                                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Información personal</h5>
                                                    <div class="row">
                                                        <!--<div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="firstname">Antigua contraseña</label>
                                                                <input type="password" class="form-control" id="firstname" placeholder="Introduzca la contraseña anterior">
                                                            </div>
                                                        </div>-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="res_pwd">Nueva contraseña</label>
                                                                <input type="password" class="form-control" name="res_pwd" id="res_pwd" placeholder="Introduzca la nueva contraseña">
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
				
				var newPwd = document.getElementById('res_pwd').value;
				var confirmPwd = document.getElementById('confirm_pwd').value;

				// Validar que la nueva contraseña y la confirmación coincidan
				if (newPwd !== confirmPwd) {
				  // Detener el envío del formulario
				  event.preventDefault();
				  
				  // Mostrar mensaje de error al usuario
				  alert('La nueva contraseña y la confirmación no coinciden.');
				}/* else{
				
					if (oldPwd !== old_password_server) {
					  // Detener el envío del formulario
					  event.preventDefault();
					  
					  // Mostrar mensaje de error al usuario
					  alert('La contraseña antigua introducida no coincide con la actual, por favor,introduce la contraseña más reciente para poder hacer efectivo el cambio de contraseña');
					} 
					
				} */
				
			  });
			});


		</script>

    </body>


</html>