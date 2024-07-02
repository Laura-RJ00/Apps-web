<!--Server side code to handle  Patient Registration-->
<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['add_user'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $user_surnames = $_POST['user_surnames'];
    $user_email = $_POST['user_email'];
    $user_pwd = sha1(md5($_POST['user_pwd']));
	$pwd_og= $_POST['user_pwd'];
    $user_rol = intval($_POST['user_rol']);
    $user_origin = $_POST['user_origin'];

    $query_user_id = "SELECT user_id FROM users WHERE user_mail = ?";
    $stmt_user_id = $mysqli->prepare($query_user_id);
    $stmt_user_id->bind_param('s', $user_email);
    $stmt_user_id->execute();
    $stmt_user_id->store_result();
    $check_mails = $stmt_user_id->num_rows;

    if ($check_mails > 0) {
        $stmt_user_id->bind_result($user_id_SERVER);
        $stmt_user_id->fetch();

        if ($user_id_SERVER !== $user_id) {
            // Ya existe otro usuario con el mismo correo, mostrar una alerta
            $err ="No ha sido posible completar el registro, el correo electrónico introducido pertence a otro usuario";
        }
    } else {
        //sql to insert captured values
        $query = "INSERT INTO users (user_id, user_rol, user_mail) VALUES (?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sis', $user_id, $user_rol, $user_email);
        $stmt->execute();

        if ($stmt) {
            if ($user_rol == 2) {
                $query = "INSERT INTO `user_docs`(`doc_id`, `doc_name`,`doc_surname`,`doc_mail`, `doc_pwd`, `doc_hospital`) VALUES (?,?,?,?,?,?)";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('sssssi', $user_id, $user_name, $user_surnames, $user_email, $user_pwd, $user_origin);
                $stmt->execute();

                if ($stmt) {
                    $nombre_rol= "Doctor";
					
					// Código JavaScript para enviar el correo solo si el insert ha sido exitoso
                        echo ' <script>
                            setTimeout(function () 
                            { 
                                Swal.fire({
                                    title: "Usuario añadido correctamente",
                                    text: "¿Deseas enviar por correo las claves de acceso al usuario?",
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonText: "Sí",
                                    cancelButtonText: "No"
                                }).then(function(result) {
                                    if (result.value) {
                                        var user_email = "' . $user_email . '";
                                        var subject = "Alta usuario";
                                        var body = "Hola ' . $user_name . ' ' . $user_surnames . ', bienvenid@ a Hospital Management of Sepsis (http://epidisease.incliva.es/hms/) . Tus claves de acceso son las siguientes:\\nID de usuario: ' . $user_id . ', contraseña: ' . $pwd_og. ', rol: ' . $nombre_rol . '.\\nPor favor, inicia sesión en el acceso correspondiente. \\nSi tienes problemas al acceder, contacta con el administrador.";

                                        var mailtoUrl = "mailto:" + user_email + "?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                                        window.location.href = mailtoUrl;
                                    }
                                });
                            },
                            100);
                        </script>';
					
                } else {
                    $err = "Por favor, inténtelo de nuevo más tarde";
                }
            } elseif ($user_rol == 1) {
                $query = "INSERT INTO `user_research`(`res_id`, `res_name`, `res_surname`,`res_mail`,`res_pwd`,`res_center`) VALUES (?,?,?,?,?,?)";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('sssssi', $user_id, $user_name, $user_surnames, $user_email, $user_pwd, $user_origin);
                $stmt->execute();

                if ($stmt) {
                   
					$nombre_rol= "Doctor";
					
					
					// Código JavaScript para enviar el correo solo si el insert ha sido exitoso
                        echo ' <script>
                            setTimeout(function () 
                            { 
                                Swal.fire({
                                    title: "Usuario añadido correctamente",
                                    text: "¿Deseas enviar por correo las claves de acceso al usuario?",
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonText: "Sí",
                                    cancelButtonText: "No"
                                }).then(function(result) {
                                    if (result.value) {
                                        var user_email = "' . $user_email . '";
                                        var subject = "Alta usuario";
                                        var body = "Hola ' . $user_name . ' ' . $user_surnames . ', bienvenid@ a Hospital Management of Sepsis (http://epidisease.incliva.es/hms/) . Tus claves de acceso son las siguientes:\\nID de usuario: ' . $user_id . ', contraseña: ' . $user_pwd. ', rol: ' . $nombre_rol . '.\\nPor favor, inicia sesión en el acceso correspondiente\\n. Si tienes problemas al acceder, contacta con el administrador.";

                                        var mailtoUrl = "mailto:" + user_email + "?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                                        window.location.href = mailtoUrl;
                                    }
                                });
                            },
                            100);
                        </script>';
						
                } else {
                    $err = "Por favor, inténtelo de nuevo más tarde";
                }
            }
        } else {
            $err = "Por favor, inténtelo de nuevo más tarde";
        }
    }
}
?>



<!--End Server Side-->
<!--End Patient Registration-->
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
                                            <li class="breadcrumb-item active">Añadir usuario</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Añadir usuario</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Rellena todos los campos</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
										
                                            <div class="form-row">
												<div class="form-group col-md-6" >
                                                    <?php 
                                                        $length = 5;    
                                                        $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                    ?>
                                                    <label for="user_id" class="col-form-label">ID usuario</label>
                                                    <input type="text" name="user_id" value="<?php echo $patient_number;?>" class="form-control" id="user_id">
												</div>
												<div class="form-group col-md-6">
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
												
													<div class="row">
														<div class="form-group col-md-6">
															<label for="user_rol" class="col-form-label">Categoría</label>
															<select id="user_rol" required="required" name="user_rol" class="form-control">
																<option>--Elige--</option>
																<?php foreach ($opciones_roles as $clave => $texto) : ?>
																	<option value="<?php echo $clave; ?>"><?php echo $texto; ?></option>
																<?php endforeach; ?>
																
															</select>
														</div>
														<div class="form-group col-md-6">
															<label for="user_origin" class="col-form-label">Perteneciente a</label>
															<select id="user_origin" required="required" name="user_origin" class="form-control">
																
																<option>--Elige--</option>
																
																
																													
															</select>
														</div>
													</div>
												</div> 
											</div>
											<div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="user_name" class="col-form-label">Nombre</label>
                                                    <input type="text" required="required" name="user_name" class="form-control" id="user_name" >
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="user_surnames" class="col-form-label">Apellidos</label>
                                                    <input required="required" type="text" name="user_surnames" class="form-control"  id="user_surnames">
                                                </div>
                                            
											</div>
                                            
											
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="user_email" class="col-form-label">Correo electrónico</label>
													<input required="required" type="email" class="form-control" name="user_email" pattern=".*@.*" id="user_email">
												</div>
												
												

												<div class="form-group col-md-6">
													<div class="col">
														<label for="user_pwd" class="col-form-label">Contraseña</label>
														<div class="input-group">
															
															<input required="required" type="text" name="user_pwd" class="form-control" id="user_pwd">
												
															<span class="input-group-btn">
																<button type="button" class="btn btn-primary" id="btn_passw" onclick="genPassword()" >Generar</button>
															</span>
														</div>
													</div>
												</div>
													
												
											</div>
                                            <button type="submit" name="add_user" id="add_user" class="ladda-button btn btn-success" data-style="expand-right">Añadir usuario</button>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
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
			
		function genPassword() {
			var password_field = $('#user_pwd');
			
			var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			var passwordLength = 12;
			var password = "";

			for (var i = 0; i <= passwordLength; i++) {
				var randomNumber = Math.floor(Math.random() * chars.length);
				password += chars.substring(randomNumber, randomNumber + 1);
			}

			password_field.val(password);
		}
		
		</script>
		
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

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

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