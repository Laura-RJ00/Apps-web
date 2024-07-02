<?php
session_start();
include('assets/inc/config.php');//get configuration file
if(isset($_POST['doc_login']))
{
    $doc_id = $_POST['doc_id'];
    //$doc_email = $_POST['doc_ea']
    $doc_pwd = sha1(md5($_POST['doc_pwd']));//double encrypt to increase security
    $stmt=$mysqli->prepare("SELECT doc_id, doc_pwd, doc_index FROM user_docs WHERE  doc_id=? AND doc_pwd=? ");//sql to log in user
    $stmt->bind_param('ss', $doc_id, $doc_pwd);//bind fetched parameters
    $stmt->execute();//execute bind
    $stmt->bind_result($doc_id, $doc_pwd ,$doc_index);//bind result
    $rs = $stmt->fetch();
    
    //$uip=$_SERVER['REMOTE_ADDR'];
    //$ldate=date('d/m/Y h:i:s', time());
    if($rs)
    {//if it's successful
		$stmt->close();
        // Registro del inicio de sesión del usuario, creamos un id del log 
		
		$length = 6;    
		$logId =  substr(str_shuffle('0123456789'),1,$length);
        
		$fechaHoraActual = date('Y-m-d H:i:s');
        
        $query_historial = "INSERT INTO `userlog`(`logId`,`loginTime`, `user_id`) VALUES (?,?,?)";
        $stmt_hist = $mysqli->prepare($query_historial);
        $stmt_hist->bind_param('sss',$logId, $fechaHoraActual, $doc_id);
        $stmt_hist->execute();
        $stmt_hist->close(); // Cierra el statement después de ejecutar la consulta
				

        $_SESSION['doc_index'] = $doc_index;
        $_SESSION['doc_id'] = $doc_id;//Asignar sesión a doc_id
		$_SESSION['logId'] = $logId ;
		
        header("location:his_doc_dashboard.php");
    }
    else
    {
        $err = "Acceso denegado, por favor revisa tus credenciales";
    }
}
?>
<!--End Login-->
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>Hospital Management Information System of Sepsis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="MartDevelopers" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!--Load Sweet Alert Javascript-->
        
        <script src="assets/js/swal.js"></script>
        <!--Inject SWAL-->
        <?php if(isset($success)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Inicio exitoso","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Error","<?php echo $err;?>","error");
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
                                    <a href="index.php">
                                        <span><img src="assets/images/logo_dark-removebg.png" alt="" height="200"></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Introduce tu ID de usuario para acceder al panel de Doctor/a.</p>
                                </div>

                                <form method='post' >

                                    <div class="form-group mb-3">
                                        <label for="doc_id">Identificador Doctor/a </label>
                                        <input class="form-control" name="doc_id" type="text" id="doc_id" required="" placeholder="Introduce tu ID de usuario">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="doc_pwd">Contraseña</label>
                                        <input class="form-control" name="doc_pwd" type="password" required="" id="doc_pwd" placeholder="Introduce tu contraseña">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" name="doc_login" type="submit"> Inicia sesión </button>
                                    </div>

                                </form>

                                

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    <div class="row mt-3">
						<div class="col-12 text-center">
							<p> <a href="his_doc_reset_pwd.php" class="text-white-50 ml-1">¿Has olvidado tu contraseña?</a></p>
						   <!-- <p class="text-white-50">Don't have an account? <a href="his_admin_register.php" class="text-white ml-1"><b>Sign Up</b></a></p>-->
						</div> <!-- end col -->
					</div>
					<div class="row mt-3">
						<div class="col-12 text-center">
							<p class="text-white-50">Volver a <a href="../../index.php" class="text-white ml-1"><b>Pagina de inicio</b></a></p>
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


        <?php include ("assets/inc/footer1.php");?>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>