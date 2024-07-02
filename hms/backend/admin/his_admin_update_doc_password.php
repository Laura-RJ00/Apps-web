<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_doc']))
		{
            $email=$_GET['email'];
            $pwd=sha1(md5($_GET['pwd']));
			
                        
			$query_user="SELECT user_rol FROM users WHERE user_mail = ?";
			$stmt_user= $mysqli->prepare($query_user);
			$rc=$stmt_user->bind_param('s', $email);
			$stmt_user->execute();
			$stmt_user->bind_result($user_rol);
			$stmt_user->fetch();
			$stmt_user->close();
			
			if ($user_rol == 2){
			//sql to insert captured values
            $query_doc="UPDATE user_docs SET doc_pwd =? WHERE doc_mail = ?";
			$stmt = $mysqli->prepare($query_doc);
			$rc_doc=$stmt->bind_param('ss', $pwd, $email);
			$stmt->execute();
				
			}elseif($user_rol == 1){
			
			$query_res="UPDATE user_research SET res_pwd =? WHERE res_mail = ?";
			$stmt = $mysqli->prepare($query_res);
			$rc_res=$stmt->bind_param('ss', $pwd, $email);
			$stmt->execute();			
			}
						
            
			$status = $_POST['status'];
			
            $query1 = "UPDATE reset_pwd_usuarios SET status =? WHERE email = ?";
			$stmt1 = $mysqli->prepare($query1);
			$rs=$stmt1->bind_param('ss', $status, $email);
			$stmt1->execute();
			
			if($stmt && $stmt1)
			{
				$success = "Contraseña actualizada";
				header("his_admin_manage_password_resets.php"); 
				exit;
			}
            else
            {
				$err = "Ha ocurrido un error, inténtalo de nuevo";
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reseteo contraseñas</a></li>
                                            <li class="breadcrumb-item active">Administrar</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Actualizar contraseña del usuario</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <?php
                            $email=$_GET['email'];
                            $ret="SELECT  * FROM reset_pwd_usuarios WHERE email=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('s',$email);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
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
                                                    <label for="user_mail" class="col-form-label">Correo</label>
                                                    <input required="required"  type="email" value="<?php echo $row->email;?>" class="form-control" name="user_mail" id="user_mail">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="user_pwd" class="col-form-label">Contraseña</label>
                                                    <input required="required"  type="text" value="<?php echo $row->pwd;?>"  name="user_pwd" class="form-control" id="user_pwd">
                                                </div>
                                                <div class="form-group col-md-6" style="display:none">
                                                    <label for="status" class="col-form-label">Estado solicitud</label>
                                                    <input required="required"  type="text" value="Reset"  name="status" class="form-control" id="status">
                                                </div>  
                                                
                                            </div>                                            

                                            <button type="submit" name="update_doc" class="ladda-button btn btn-success" data-style="expand-right">Actualizar contraseña</button>

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