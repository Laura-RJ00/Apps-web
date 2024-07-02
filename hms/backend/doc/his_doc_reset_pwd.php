<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['reset_pwd']))
		{
            //generate random password and a token 
            

            $email=$_POST['email'];
            $token = sha1(md5($_POST['token']));
            $status = $_POST['status'];
            $pwd = $_POST['pwd'];
			
			
			$query_user_id = "SELECT user_mail FROM users WHERE user_mail = ?";
			$stmt_user_id = $mysqli->prepare($query_user_id);
			$stmt_user_id->bind_param('s', $email);
			$stmt_user_id->execute();
			$stmt_user_id->store_result();
			$check_mails = $stmt_user_id->num_rows;

			if ($check_mails > 0) {
				
				$query_status= "SELECT status FROM reset_pwd_usuarios WHERE email = ?";
				$stmt_status = $mysqli->prepare($query_status);
				$stmt_status->bind_param('s', $email);
				$stmt_status->execute();
				$stmt_status->store_result();
				$check_status = $stmt_status->num_rows;

				if ($check_status > 0) {
					
					$stmt_status->bind_result($status_SERVER);
					$stmt_status->fetch();
					
					if ($status == 'Pending'){
						
						$info = "Su solicitud de cambio de contraseña está en proceso.";
						
						$query="UPDATE `reset_pwd_usuarios` SET `pwd`= ? WHERE email = ? ";
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ss',$pwd, $email);
						$stmt->execute();
					
					}
					
					
					
				}else{
					
					$query="INSERT INTO reset_pwd_usuarios (email, token, status, pwd) VALUES(?,?,?,?)";
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('ssss', $email, $token, $status, $pwd);
					$stmt->execute();
					 
					//declare a varible which will be passed to alert function
					if($stmt)
					{
						$success = "Tu petición ha sido enviada al administrador y será respondida a la mayor brevedad posible.Se te proporcionarán nuevas claves de acceso a través de tu correo ";
					}
					else {
						$err = "Ha ocurrido un error, vuelve a intentarlo más tarde";
					}
					
					
				}
				
			}else{
				
				$err = "No existe ninguna cuenta asociada a ese correo, pruebe otro correo";
			
			}
        }
        $length_pwd = 10;
        $length_token = 30;
        $temp_pwd = substr(str_shuffle('0123456789QWERTYUIOPPLKJHGFDSAZCVBNMqwertyuioplkjhgfdsazxcvbnm'),1,$length_pwd);
        $_token = substr(str_shuffle('0123456789QWERTYUIOPPLKJHGFDSAZCVBNMqwertyuioplkjhgfdsazxcvbnm'),1,$length_token);       
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>Hospital Management Information System of Sepsis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!--Load Sweet Alert Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!--Inject SWAL-->
        <?php if(isset($success)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Correcto","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Error","<?php echo $err;?>","error");
                            },
                                100);
                </script>

        <?php } ?>
		
		<?php if(isset($warn)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Aviso","<?php echo $warn;?>","warning");
                            },
                                100);
                </script>

        <?php } ?>
		
		<?php if(isset($info)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Aviso","<?php echo $info;?>","info");
                            },
                                100);
                </script>

        <?php } ?>



    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <a href="his_doc_reset_pwd.php">
                                        <span><img src="assets/images/logo_dark-removebg.png" alt="" height="200"></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Introduce tu correo electrónico y te enviaremos un correo con instrucciones sobre cómo resetear tu contraseña.</p>
                                </div>

                                <form method="post" >

                                    <div class="form-group mb-3">
                                        <label for="email">Correo electrónico</label>
                                        <input class="form-control" name="email" type="email" id="email" required="" placeholder="Introduce tu correo">
                                    </div>
                                    <div class="form-group mb-3" style="display:none">
                                        <label for="token">Reset Token</label>
                                        <input class="form-control" name="token" type="text" value="<?php echo $_token;?>">
                                    </div>
                                    <div class="form-group mb-3" style="display:none">
                                        <label for="pwd">Reset Temp Pwd</label>
                                        <input class="form-control" name="pwd" type="text" value ="<?php echo $temp_pwd;?>">
                                    </div>
                                    <div class="form-group mb-3" style="display:none">
                                        <label for="status">Status</label>
                                        <input class="form-control" name="status" type="text" id="status" required="" value="Pending">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button name="reset_pwd" class="btn btn-primary btn-block" type="submit"> Resetear contraseña </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Volver a  <a href="index.php" class="text-white ml-1"><b>Inicia sesión</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


       <?php include("assets/inc/footer1.php");?>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>