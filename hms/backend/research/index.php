<?php
    session_start();
    include('assets/inc/config.php');//get configuration file
    if(isset($_POST['res_login']))
    {
        $res_id = $_POST['res_id'];
        //$res_email = $_POST['res_ea']
        $res_pwd = sha1(md5($_POST['res_pwd']));//double encrypt to increase security
        $stmt=$mysqli->prepare("SELECT res_id, res_pwd, res_index FROM user_research WHERE  res_id=? AND res_pwd=? ");//sql to log in user
        $stmt->bind_param('ss', $res_id, $res_pwd);//bind fetched parameters
        $stmt->execute();//execute bind
        $stmt -> bind_result($res_id, $res_pwd ,$res_index);//bind result
        $rs=$stmt->fetch();
        $_SESSION['res_index'] = $res_index;
        $_SESSION['res_id'] = $res_id;//Assign session to res_id id
        //$uip=$_SERVER['REMOTE_ADDR'];
        //$ldate=date('d/m/Y h:i:s', time());
        if($rs)
            {//if its sucessfull
                header("location:his_res_dashboard.php");
            }

        else
            {
            #echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
                $err = "Acceso denegado, por favor revisa tus credenciales";
            }
    }
?>
<!--End Login-->
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>Hospital Management System of Sepsis</title>
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
                                swal("Éxito","<?php echo $success;?>","success");
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
                                    <p class="text-muted mb-4 mt-3">Introduce tu ID de usuario para acceder al panel de Investigador/a.</p>
                                </div>

                                <form method='post' >

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Identificador Investigador/a </label>
                                        <input class="form-control" name="res_id" type="text" id="res_id" required="" placeholder="Introduce tu ID de usuario">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Contraseña</label>
                                        <input class="form-control" name="res_pwd" type="password" required="" id="password" placeholder="Introduce tu contraseña">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" name="res_login" type="submit"> Inicia sesión </button>
                                    </div>

                                </form>

                                <!--
                                For Now Lets Disable This 
                                This feature will be implemented on later versions
                                <div class="text-center">
                                    <h5 class="mt-3 text-muted">Sign in with</h5>
                                    <ul class="social-list list-inline mt-3 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                                        </li>
                                    </ul>
                                </div> 
                                -->

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
						<div class="row mt-3">
							<div class="col-12 text-center">
								<p> <a href="his_res_reset_pwd.php" class="text-white-50 ml-1">¿Has olvidado tu contraseña?</a></p>
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