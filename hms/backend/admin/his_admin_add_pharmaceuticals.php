
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_entity']))
		{
			$ent_name = $_POST['ent_name'];
			$ent_type = $_POST['ent_type'];
            $ent_mail = $_POST['ent_mail'];
            $ent_resp = $_POST['ent_resp'];
            $ent_local = $_POST['ent_local'];
            
                
            //sql to insert captured values
			if($ent_type == 'Hosp'){
				
				$query_hosp = "SELECT * FROM hospital_docs WHERE hosp_name = ?";
				$stmt_hosp = $mysqli->prepare($query_hosp);
				$stmt_hosp->bind_param('s', $ent_name);
				$stmt_hosp->execute();
				$stmt_hosp->store_result();
				$check_hosp = $stmt_hosp->num_rows;

				if ($check_hosp > 0) {
					
						$err ="No ha sido posible completar el registro, puesto que ya exite otra entidad registrada con ese nombre.";
					
				}else {
					
					$query="INSERT INTO `hospital_docs` (`hosp_name`, `hosp_location`, `hosp_resp_name`, `hosp_resp_mail`) VALUES (?,?,?,?)";
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('ssss', $ent_name, $ent_local, $ent_resp, $ent_mail);
					$stmt->execute();
					/*
					*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
					*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
					*/ 
					//declare a varible which will be passed to alert function
					if($stmt)
					{
						$success = "Añadido correctamente";
					}
					else {
						$err = "Por favor, inténtelo de nuevo más tarde";
					}
				}
				
			}elseif($ent_type == 'Research'){
				
				$query_rsc = "SELECT * FROM research_centers WHERE center_name = ?";
				$stmt_rsc = $mysqli->prepare($query_rsc);
				$stmt_rsc->bind_param('s', $ent_name);
				$stmt_rsc->execute();
				$stmt_rsc->store_result();
				$check_rsc = $stmt_rsc->num_rows;

				if ($check_rsc > 0) {
					
						$err ="No ha sido posible completar el registro, puesto que ya exite otra entidad registrada con ese nombre.";
					
				}else {
				
					$query="INSERT INTO `research_centers` (`center_name`, `res_location`, `res_responsable`, `res_center_mail`) VALUES (?,?,?,?)";
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('ssss', $ent_name, $ent_local, $ent_resp, $ent_mail);
					$stmt->execute();
					/*
					*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
					*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
					*/ 
					//declare a varible which will be passed to alert function
					if($stmt)
					{
						$success = "Añadido correctamente";
					}
					else {
						$err = "Por favor, inténtelo de nuevo más tarde";
					}
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
                                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Tableros</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Colaboradores</a></li>
                                            <li class="breadcrumb-item active">Añadir entidad</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Ingresar colaboradores</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Rellena los campos</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="ent_name" class="col-form-label">Nombre</label>
                                                    <input type="text" required="required" name="ent_name" class="form-control" id="ent_name" >
                                                </div>
												<div class="form-group col-md-6">
                                                    <label for="ent_type" class="col-form-label">Tipo de entidad</label>
                                                    <select id="ent_type" required="required" name="ent_type" class="form-control">
                                                    <!--Fetch All Pharmaceutical Categories-->
                                                    <?php
                                                   
                                                       $opciones_entidad = array(
											
															"Hosp" => "Hospital",
															"Research" => "Investigación",
															
														);
                                                    ?>		
															<option value="">--Selecciona una opción--</option>
                                                            <?php foreach ($opciones_entidad as $clave => $texto) : ?>
																
																<option value="<?php echo $clave; ?>"><?php echo $texto; ?></option>
															<?php endforeach; ?>
                                                      
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="form-row">
												<div class="form-group col-md-6">
                                                    <label for="ent_name" class="col-form-label">Nombre responsable</label>
                                                    <input required="required" type="text" name="ent_resp" class="form-control"  id="ent_name">
                                                </div>
												<div class="form-group col-md-6">
                                                    <label for="ent_mail" class="col-form-label">Correo responsable</label>
                                                    <input required="required" type="text" name="ent_mail" class="form-control"  id="ent_mail">
                                                </div>
											</div>
                                            <div class="form-row">
												<div class="form-group col-md-6">
                                                    <label for="ent_local" class="col-form-label">Localización</label>
                                                    <input required="required" type="text" name="ent_local" class="form-control"  id="ent_local">
                                                </div>
                                            </div>  

                                           <button type="submit" name="add_entity" class="ladda-button btn btn-success" data-style="expand-right">Añadir</button>

                                        </form>
                                     
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
        <!--Load CK EDITOR Javascript-->
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
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