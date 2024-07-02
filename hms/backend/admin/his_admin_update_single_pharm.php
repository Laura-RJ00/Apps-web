
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_ent']))
		{
			$ent_id = $_GET['ent_id'];
			$ent_type = $_GET['ent_type'];
			
			$ent_name = $_POST['ent_name'];
			$ent_mail = $_POST['ent_mail'];
            $ent_resp = $_POST['ent_resp'];
            $ent_local = $_POST['ent_location'];
			
			
			if($ent_type == 'hospital'){
				
				$query_name = "SELECT hosp_name FROM hospital_docs WHERE hosp_id = ?";
				$stmt_name = $mysqli->prepare($query_name);
				$stmt_name->bind_param('i', $ent_id);
				$stmt_name->execute();
				$stmt_name->store_result();
				$stmt_name->bind_result($ent_name_SERVER);
				$stmt_name->fetch();

				if ($ent_name_SERVER !== $ent_name) {
					// El nombre ha cambiado, verifiquemos si ya está en uso
					$query_id = "SELECT hosp_id FROM hospital_docs WHERE hosp_name = ?";
					$stmt_id = $mysqli->prepare($query_id);
					$stmt_id->bind_param('s', $ent_name);
					$stmt_id->execute();
					$stmt_id->store_result();
					$check_names = $stmt_id->num_rows;

					if ($check_names > 0) {
						$stmt_id->bind_result($ent_id_SERVER);
						$stmt_id->fetch();

						if ($ent_id_SERVER !== $ent_id) {
							// Ya existe otra entidad con el mismo nombre, mostrar una alerta
							$warn = "Nombre identificativo no actualizado ya que pertenece a otro entidad";
							
						} else {
							// Actualizar el nombre y otros datos
							$query="UPDATE `hospital_docs` SET `hosp_name`= ?,`hosp_location`= ?,`hosp_resp_name`= ?,`hosp_resp_mail`= ? WHERE `hosp_id`= ?";
							$stmt = $mysqli->prepare($query);
							$rc=$stmt->bind_param('ssssi', $ent_name, $ent_local, $ent_resp, $ent_mail,$ent_id);
							$stmt->execute();
							
							
							if($stmt)
							{
								$success = "Actualizado correctamente";
							}
							else {
								$err = "Por favor, inténtelo de nuevo más tarde";
							}
						}
					} else {
						$query="UPDATE `hospital_docs` SET `hosp_name`= ?,`hosp_location`= ?,`hosp_resp_name`= ?,`hosp_resp_mail`= ? WHERE `hosp_id`= ?";
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ssssi', $ent_name, $ent_local, $ent_resp, $ent_mail,$ent_id);
						$stmt->execute();
						
						//declare a varible which will be passed to alert function
						if($stmt)
						{
							$success = "Actualizado correctamente";
						}
						else {
							$err = "Por favor, inténtelo de nuevo más tarde";
						}
					}
				} else {
					// El nombre no ha cambiado, actualizar el resto de datos
					$query="UPDATE `hospital_docs` SET `hosp_location`= ?,`hosp_resp_name`= ?, `hosp_resp_mail`= ?  WHERE `hosp_id`= ?";
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('sssi', $ent_local, $ent_resp, $ent_mail,$ent_id);
					$stmt->execute();
					
					//declare a varible which will be passed to alert function
					if($stmt)
					{
						$success = "Actualizado correctamente";
					}
					else {
						$err = "Por favor, inténtelo de nuevo más tarde";
					}
				}
				
				
				
			}elseif($ent_type == 'research'){
				
				$query_name = "SELECT center_name FROM research_centers WHERE center_id = ?";
				$stmt_name = $mysqli->prepare($query_name);
				$stmt_name->bind_param('i', $ent_id);
				$stmt_name->execute();
				$stmt_name->store_result();
				$stmt_name->bind_result($ent_name_SERVER);
				$stmt_name->fetch();

				if ($ent_name_SERVER !== $ent_name) {
					// El nombre ha cambiado, verifiquemos si ya está en uso
					$query_id = "SELECT center_id FROM research_centers WHERE center_name = ?";
					$stmt_id = $mysqli->prepare($query_id);
					$stmt_id->bind_param('s', $ent_name);
					$stmt_id->execute();
					$stmt_id->store_result();
					$check_names = $stmt_id->num_rows;

					if ($check_names > 0) {
						$stmt_id->bind_result($ent_id_SERVER);
						$stmt_id->fetch();

						if ($ent_id_SERVER !== $ent_id) {
							// Ya existe otra entidad con el mismo nombre, mostrar una alerta
							$warn = "Nombre identificativo no actualizado ya que pertenece a otro entidad";
							
						} else {
							// Actualizar el nombre y otros datos
							$query="UPDATE `research_centers` SET `center_name`= ?,`res_location`= ?,`res_responsable`= ?,`res_center_mail`= ? WHERE `center_id`= ?";
							$stmt = $mysqli->prepare($query);
							$rc=$stmt->bind_param('ssssi', $ent_name, $ent_local, $ent_resp, $ent_mail,$ent_id);
							$stmt->execute();
							
							//declare a varible which will be passed to alert function
							if($stmt)
							{
								$success = "Actualizado correctamente";
							}
							else {
								$err = "Por favor, inténtelo de nuevo más tarde";
							}
						}
					} else {
						$query="UPDATE `research_centers` SET `center_name`= ?,`res_location`= ?,`res_responsable`= ?,`res_center_mail`= ? WHERE `center_id`= ?";
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ssssi', $ent_name, $ent_local, $ent_resp, $ent_mail,$ent_id);
						$stmt->execute();
						
						//declare a varible which will be passed to alert function
						if($stmt)
						{
							$success = "Actualizado correctamente";
						}
						else {
							$err = "Por favor, inténtelo de nuevo más tarde";
						}
					}
				} else {
					$query="UPDATE `research_centers` SET `res_location`= ?,`res_responsable`= ?,`res_center_mail`= ? WHERE `center_id`= ?";
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('sssi', $ent_local, $ent_resp, $ent_mail,$ent_id);
					$stmt->execute();
					
					//declare a varible which will be passed to alert function
					if($stmt)
					{
						$success = "Actualizado correctamente";
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
            <?php
                $ent_id=$_GET['ent_id'];
				$ent_type=$_GET['ent_type'];
				
				$ent_name='';
				$ent_location='';
				$ent_resp='';
				$ent_mail='';
				
				
				if($ent_type=='hospital'){
				
					$ret="SELECT  * FROM hospital_docs WHERE hosp_id = ?";
					$stmt= $mysqli->prepare($ret) ;
					$stmt->bind_param('i',$ent_id);
					$stmt->execute() ;//ok
					$res=$stmt->get_result();
					//$cnt=1;
					if($row=$res->fetch_object())
					{
							$ent_name=$row->hosp_name;
							$ent_location=$row->hosp_location;
							$ent_resp=$row-> hosp_resp_name;
							$ent_mail=$row->hosp_resp_mail;
					}
				}elseif($ent_type== 'research'){
					
					$ret="SELECT  * FROM research_centers WHERE center_id = ?";
					$stmt= $mysqli->prepare($ret) ;
					$stmt->bind_param('i',$ent_id);
					$stmt->execute() ;//ok
					$res=$stmt->get_result();
					//$cnt=1;
					if($row=$res->fetch_object())
					{
						$ent_name=$row->center_name;
						$ent_location=$row->res_location;
						$ent_resp=$row-> res_responsable;
						$ent_mail=$row->res_center_mail;
						
					}
				}
                
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
                                                 <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Tableros</a></li>
												<li class="breadcrumb-item"><a href="javascript: void(0);">Colaboradores</a></li>
												<li class="breadcrumb-item active">Editar entidad</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Editar #<?php echo $ent_id;?> - <?php echo $ent_name;?></h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Rellenar campos</h4>
                                            <!--Add Patient Form-->
                                            <form method="post">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="ent_name" class="col-form-label">Nombre</label>
                                                        <input type="text" required="required" value="<?php echo $ent_name;?>" name="ent_name" class="form-control" id="ent_name" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="ent_location" class="col-form-label">Localización</label>
                                                        <input required="required" type="text" value="<?php echo $ent_location;?>" name="ent_location" class="form-control"  id="ent_location">
                                                    </div>
                                                </div>
												<div class="form-row">
													<div class="form-group col-md-6">
														<label for="ent_resp" class="col-form-label">Responsable</label>
														<input required="required"  type="text" class="form-control" name="ent_resp" id="ent_resp" value='<?php echo $ent_resp;?>'>
													</div>
                                               
													<div class="form-group col-md-6">
															<label for="ent_mail" class="col-form-label">Correo de contacto</label>
															<input required="required" type="text" value="<?php echo $ent_mail;?>" name="ent_mail" class="form-control"  id="ent_mail">
													</div>
                                                
                                                </div>
                                            <button type="submit" name="update_ent" class="ladda-button btn btn-warning" data-style="expand-right">Actualizar</button>

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