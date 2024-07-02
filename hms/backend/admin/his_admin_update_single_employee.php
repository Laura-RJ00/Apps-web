<?php
session_start();
include('assets/inc/config.php');

	if (isset($_POST['update_doc'])) {
		$user_id = $_GET['user_id'];
		$rol_id = $_GET['rol_id'];

		$user_name = $_POST['user_name'];
		$user_surnames = $_POST['user_surname'];
		$user_pwd = $_POST['user_pwd'];
		$user_mail = $_POST['user_mail'];
		$user_rol = $_POST['user_rol'];
		$user_origin = $_POST['user_origin'];

		$query_mail = "SELECT user_mail FROM users WHERE user_id = ?";
		$stmt_mail = $mysqli->prepare($query_mail);
		$stmt_mail->bind_param('s', $user_id);
		$stmt_mail->execute();
		$stmt_mail->store_result();
		$stmt_mail->bind_result($mail_id_SERVER);
		$stmt_mail->fetch();

		if ($mail_id_SERVER !== $user_mail) {
			// El correo electrónico ha cambiado, verifiquemos si ya está en uso
			$query_user_id = "SELECT user_id FROM users WHERE user_mail = ?";
			$stmt_user_id = $mysqli->prepare($query_user_id);
			$stmt_user_id->bind_param('s', $user_mail);
			$stmt_user_id->execute();
			$stmt_user_id->store_result();
			$check_mails = $stmt_user_id->num_rows;

			if ($check_mails > 0) {
				$stmt_user_id->bind_result($user_id_SERVER);
				$stmt_user_id->fetch();

				if ($user_id_SERVER !== $user_id) {
					// Ya existe otro usuario con el mismo correo, mostrar una alerta
					$warn = "Correo electrónico no actualizado ya que pertenece a otro usuario";
				} else {
					// Actualizar el rol y el correo electrónico
					$query = "UPDATE `users` SET `user_rol`=?, `user_mail`=? WHERE `user_id`=?";
					$stmt = $mysqli->prepare($query);
					$stmt->bind_param('iss', $user_rol, $user_mail, $user_id);
					$stmt->execute();
				}
			} else {
				// Actualizar el rol y el correo electrónico
				$query = "UPDATE `users` SET `user_rol`=?, `user_mail`=? WHERE `user_id`=?";
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param('iss', $user_rol, $user_mail, $user_id);
				$stmt->execute();
			}
		} else {
			// El correo electrónico no ha cambiado, solo actualizar el rol
			$query = "UPDATE `users` SET `user_rol`=? WHERE `user_id`=?";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param('is', $user_rol, $user_id);
			$stmt->execute();
		}

    
        if ($user_rol == 2) {
            $query_id = "SELECT * FROM user_docs WHERE doc_id = ?";
            $stmt = $mysqli->prepare($query_id);
            $stmt->bind_param('s', $user_id);
            $stmt->execute();
            $stmt->store_result();
            $check_id = $stmt->num_rows;

            if ($check_id > 0) {
                $query = "UPDATE `user_docs` SET  `doc_name`=?,`doc_surname`= ?,`doc_hospital`= ? WHERE `doc_id`=?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('ssis', $user_name, $user_surnames, $user_origin, $user_id);
                $stmt->execute();

                if ($stmt) {
                    $success = "Usuario actualizado correctamente";
                } else {
                    $err = "Por favor, inténtelo de nuevo más tarde";
                }
            } else {
                $query = "DELETE FROM `user_research` WHERE `res_id` =?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('s', $user_id);
                $stmt->execute();

                if ($stmt) {
                    $query = "INSERT INTO `user_docs`(`doc_id`, `doc_name`,`doc_surname`, `doc_pwd`, `doc_hospital`) VALUES (?,?,?,?,?,?)";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('ssssi', $user_id, $user_name, $user_surnames, $user_pwd, $user_origin);
                    $stmt->execute();

                    if ($stmt) {
                        $success = "Usuario actualizado correctamente";
                       
                    } else {
                        $err = "Por favor, inténtelo de nuevo más tarde";
                    }
                } else {
                    $err = "Por favor, inténtelo de nuevo más tarde";
                }
            }
        } elseif ($user_rol == 1) {
            $query_id = "SELECT * FROM user_research WHERE res_id = ? ";
            $stmt = $mysqli->prepare($query_id);
            $stmt->bind_param('s', $user_id);
            $stmt->execute();
            $stmt->store_result();
            $check_id = $stmt->num_rows;

            if ($check_id > 0) {
                $query = "UPDATE `user_research` SET  `res_name`=?,`res_surname`= ?,`res_center`= ? WHERE `res_id`=?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('ssis', $user_name, $user_surnames, $user_origin, $user_id);
                $stmt->execute();

                if ($stmt) {
                    $success = "Usuario actualizado correctamente";
                } else {
                    $err = "Por favor, inténtelo de nuevo más tarde";
                }
            } else {
                $query = "DELETE FROM `user_docs` WHERE `doc_id` =?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('s', $user_id);
                $stmt->execute();

                if ($stmt) {
                    $query = "INSERT INTO `user_research`(`res_id`, `res_name`, `res_surname``res_pwd`,`res_center`) VALUES (?,?,?,?,?,?)";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('ssssi', $user_id, $user_name, $user_surnames, $user_pwd, $user_origin);
                    $stmt->execute();

                    if ($stmt) {
                        $success = "Usuario actualizado correctamente";
                        
                    } else {
                        $err = "Por favor, inténtelo de nuevo más tarde";
                    }
                } else {
                    $err = "Por favor, inténtelo de nuevo más tarde";
                }
            }
        }
    
}
?>

<!--End Server Side-->
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
                                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Tablero</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                                            <li class="breadcrumb-item active">Administrar usuarios</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Actualizar detalles del usuario</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
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
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
								
								$id_usuario_rol = $row->user_rol;
								$doc_origin= $row->doc_hospital;
								$res_origin= $row->res_center;
								$doc_contraseña= $row->doc_pwd; 
								$res_contraseña= $row->res_pwd;
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Rellena los campos</h4>
                                        <!--Add Patient Form-->
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="user_name" class="col-form-label">Nombre</label>
                                                    <input type="text" required="required" value="<?php echo ($rol_id=='Doctor')? $row->doc_name : $row->res_name;?>" name="user_name" class="form-control" id="user_name" >
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="user_surname" class="col-form-label">Apellidos</label>
                                                    <input required="required" type="text" value="<?php echo ($rol_id=='Doctor')? $row->doc_surname : $row->res_surname;?>" name="user_surname" class="form-control"  id="user_surname">
                                                </div>
                                            </div>

                                            
                                            <div class="form-row">
												<div class="form-group col-md-6 ">
													<label for="user_mail" class="col-form-label">Correo</label>
													<input required="required" type="email" value="<?php echo ($rol_id=='Doctor')? $row->doc_mail : $row->res_mail;?>" class="form-control" name="user_mail" id="user_mail">
												</div>
												<?php 
												
												$query_1 = "SELECT * FROM users_roles WHERE `rol_id` != '3'";
												$resultado = $mysqli->query($query_1);

												// Verificar si se obtuvieron resultados
												if ($resultado->num_rows > 0) {
													// Generar las opciones a partir de los resultados de la consulta
													$opciones_roles = array();
													
													while ($row = $resultado->fetch_object()) {
														$id = $row->rol_id;
														$nombre = $row->rol_description;
														$opciones_roles[$id] = $nombre;
													}
												
												} else {
													echo 'No se encontraron opciones.';
												}
												 
												$resultado->free();
												
												$query_doc = "SELECT * FROM hospital_docs";
												$resultado = $mysqli->query($query_doc);

												// Verificar si se obtuvieron resultados
												if ($resultado->num_rows > 0) {
													// Generar las opciones a partir de los resultados de la consulta
													$opciones_hosp = array();
													
													while ($row = $resultado->fetch_object()) {
														$id = $row->hosp_id;
														$nombre = $row->hosp_name;
														$opciones_hosp[$id] = $nombre;
													}
												
												} else {
													echo 'No se encontraron opciones.';
												}
												 
												$resultado->free();
												
												$query_res = "SELECT * FROM research_centers";
												$resultado = $mysqli->query($query_res);

												// Verificar si se obtuvieron resultados
												if ($resultado->num_rows > 0) {
													// Generar las opciones a partir de los resultados de la consulta
													$opciones_res = array();
													
													while ($row = $resultado->fetch_object()) {
														$id = $row->center_id;
														$nombre = $row->center_name;
														$opciones_res[$id] = $nombre;
													}
												
												} else {
													echo 'No se encontraron opciones.';
												}
												 
												$resultado->free();
												?>
												
												
													<div class="form-group col-md">
														<label for="user_rol" class="col-form-label">Categoría</label>
														<select id="user_rol" required="required" name="user_rol" class="form-control">
															<option>--Elige--</option>
															<?php foreach ($opciones_roles as $clave => $texto) : ?>
																<option value="<?php echo $clave; ?>"<?php echo ($id_usuario_rol == $clave) ? "selected" : ""; ?>><?php echo $texto; ?></option>
															<?php endforeach; ?>
															 
														</select>
													</div>
													<div class="form-group col-md">
														<label for="user_origin" class="col-form-label">Perteneciente a</label>
														<select id="user_origin" required="required" name="user_origin" class="form-control">
															<option>--Elige--</option>
															<?php if ($rol_id== 'Doctor') : ?>
																<?php foreach ($opciones_hosp as $clave => $texto) : ?>
																		<option value="<?php echo $clave; ?>"<?php echo ($doc_origin == $clave) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															 
															  
															 <?php elseif(($rol_id== 'Investigador') ) : ?>
																  <?php foreach ($opciones_res as $clave => $texto) : ?>
																		<option value="<?php echo $clave; ?>"<?php echo ($res_origin == $clave) ? "selected" : ""; ?>><?php echo $texto; ?></option>
																  <?php endforeach; ?>
															
															<?php endif; ?>
															
															
																												
														</select>
													</div>
												
											</div>
                                            <div class="form-row" style="display:none">
                                                <div class="form-group col-md-6">
                                                    <label for="user_pwd" class="col-form-label">Contraseña</label>
                                                    <input type="password" name="user_pwd" class="form-control" id="user_pwd" value="<?php echo ($rol_id=='Doctor')? $doc_contraseña : $res_contraseña;?>">
                                                </div>
                                                
                                               <!-- <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Foto de perfil</label>
                                                    <input required="required"  type="file" name="doc_dpic" class="btn btn-success form-control"  id="inputCity">
                                                </div>-->
                                            </div>                                            
											<br>
                                            <button type="submit" name="update_doc" class="ladda-button btn btn-success" data-style="expand-right">Actualizar datos</button>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <?php }?>

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
			var opcionesPorCategoria = {
				<?php foreach ($opciones_roles as $clave => $texto) : ?>
					'<?php echo $clave; ?>': {
						<?php if ($texto == 'Doctor') : ?>
							<?php foreach ($opciones_hosp as $clave_hosp => $texto_hosp) : ?>
							   '<?php echo addslashes($clave_hosp); ?>': '<?php echo addslashes($texto_hosp); ?>',
							<?php endforeach; ?>
						<?php elseif ($texto == 'Investigador') : ?>
							<?php foreach ($opciones_res as $clave_res => $texto_res) : ?>
								'<?php echo addslashes($clave_res); ?>': '<?php echo addslashes($texto_res); ?>',
							<?php endforeach; ?>
						<?php endif; ?>
					},
				<?php endforeach; ?>
			};

			var categoriaSelect = document.getElementById('user_rol');
			var pertenecienteSelect = document.getElementById('user_origin');

			categoriaSelect.addEventListener('change', function() {
				var categoriaSeleccionada = categoriaSelect.value;
				var opciones = opcionesPorCategoria[categoriaSeleccionada];

				pertenecienteSelect.innerHTML = '<option value="">--Elige--</option>';

				if (opciones) {
					for (var clave in opciones) {
						var texto = opciones[clave];
						var optionElement = document.createElement('option');
						optionElement.value = clave;
						optionElement.textContent = texto;
						pertenecienteSelect.appendChild(optionElement);
					}
				}
			});
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
        
    </body>

</html>