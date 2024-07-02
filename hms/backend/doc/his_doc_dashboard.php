<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_index=$_SESSION['doc_index'];
  $doc_id = $_SESSION['doc_id'];

?>
<!DOCTYPE html>
<html lang="en">
    
    <!--Head Code-->
    <?php include("assets/inc/head.php");?>

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

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">Mi Tablero</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        
						<div class="row">

                        <!--Start Vendors-->
                       
                            <div class="col-md-6 col-xl-6">
                                <a href="his_doc_account.php">
                                    <div class="widget-rounded-circle card-box">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                    <i class="fas fa-user-tag font-22 avatar-title text-danger"></i>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-right">
                                                    <h3 class="text-dark mt-1"></span></h3>
                                                    <p class="text-muted mb-1 text-truncate">Mi perfil</p>
                                                </div>
                                            </div>
                                        </div> <!-- end row-->
                                    </div>
                                </a> <!-- end widget-rounded-circle-->
                            </div> 
                           <!-- end col--> 
                            <!--End Vendors-->  
						</div>
							<div class="row">
								<!--Start OutPatients-->
									<div class="col-md-6 col-xl-4">
										<div class="widget-rounded-circle card-box">
											<div class="row">
												<div class="col-6">
													<div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
														<i class="fab fa-accessible-icon  font-22 avatar-title text-danger"></i>
													</div>
												</div>
												<div class="col-6">
													<div class="text-right">
														<?php
															//code for summing up number of out patients 
															$result ="SELECT count(*) FROM patients WHERE pat_doc_assigned= '$doc_id'  ";
															$stmt = $mysqli->prepare($result);
															$stmt->execute();
															$stmt->bind_result($patient);
															$stmt->fetch();
															$stmt->close();
														?>
														<h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $patient;?></span></h3>
														<p class="text-muted mb-1 text-truncate">Pacientes totales</p>
													</div>
												</div>
											</div> <!-- end row-->
										</div> <!-- end widget-rounded-circle-->
									</div> <!-- end col-->
								<!--End Out Patients-->


								
								

								<!--Start Pharmaceuticals-->
								<div class="col-md-6 col-xl-4">
									<div class="widget-rounded-circle card-box">
										<div class="row">
											<div class="col-6">
												<div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
													<i class="mdi mdi-pill font-22 avatar-title text-danger"></i>
												</div>
											</div>
											<div class="col-6">
												<div class="text-right">
													<?php
														/* 
														 * code for summing up number of pharmaceuticals,
														 */ 
														$result ="SELECT count(*) FROM patients WHERE pat_doc_assigned= '$doc_id' AND pat_role = 'Caso' ";
														$stmt = $mysqli->prepare($result);
														$stmt->execute();
														$stmt->bind_result($phar);
														$stmt->fetch();
														$stmt->close();
													?>
													<h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $phar;?></span></h3>
													<p class="text-muted mb-1 text-truncate">Pacientes sépticos</p>
												</div>
											</div>
										</div> <!-- end row-->
									</div> <!-- end widget-rounded-circle-->
								</div> <!-- end col-->
								<!--End Pharmaceuticals-->
								
								<!--Start Pharmaceuticals-->
								<div class="col-md-6 col-xl-4">
									<div class="widget-rounded-circle card-box">
										<div class="row">
											<div class="col-6">
												<div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
													<i class="mdi mdi-pill font-22 avatar-title text-danger"></i>
												</div>
											</div>
											<div class="col-6">
												<div class="text-right">
													<?php
														/* 
														 * code for summing up number of pharmaceuticals,
														 */ 
														$result ="SELECT count(*) FROM patients WHERE pat_doc_assigned= '$doc_id'  AND pat_role = 'Control'";
														$stmt = $mysqli->prepare($result);
														$stmt->execute();
														$stmt->bind_result($phar);
														$stmt->fetch();
														$stmt->close();
													?>
													<h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $phar;?></span></h3>
													<p class="text-muted mb-1 text-truncate">Controles</p>
												</div>
											</div>
										</div> <!-- end row-->
									</div> <!-- end widget-rounded-circle-->
								</div> <!-- end col-->
								<!--End Pharmaceuticals-->
							</div>
                        

                        
						<!--Recently pats added-->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Últimos pacientes introducidos</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-centered m-0">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Ficha</th> <!-- 1 -->
                                                    <th>ID  </th> <!-- 2 -->
                                                    <th>SIP</th> <!-- 3 -->
                                                    <th>NHC</th> <!-- 4 -->
													<th>Rol estudio</th> <!-- 5 -->
                                                    <th>Fecha ingreso</th> <!-- 6 -->
                                                    <th>Fecha alta</th> <!-- 7 -->
                                                    <th>Edad</th> <!-- 8 -->
													<th>Sexo</th> <!-- 9 -->
													<th>Acción</th> <!-- 10 -->
                                                </tr>
                                            </thead>
                                            <?php
                                                $ret="SELECT *
														FROM patients 
														LEFT JOIN control ON patients.pat_id= control.control_pat_id
														LEFT JOIN caso ON patients.pat_id= caso.case_pat_id
														LEFT JOIN clinical_finding ON caso.cl_find_id = clinical_finding.cl_find_id
														LEFT JOIN codigo_sexo ON patients.pat_sex= codigo_sexo.sex_codes
														WHERE pat_doc_assigned ='$doc_id'
														ORDER BY pat_index DESC";
												//sql code to get to ten docs  randomly
                                                $stmt= $mysqli->prepare($ret);
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
													$cnt++;
													$checked = ($row->pat_record_status == 1) ? 'checked' : '';
													$pat_date_ingreso = ($row->pat_date_ingreso== '1970-01-01'|| empty($row->pat_date_ingreso)) ? 'No registrada' : $row->pat_date_ingreso;
													
													$pat_date_alta = ($row->pat_date_alta== '1970-01-01' || empty($row->pat_date_alta)) ? 'No registrada' : $row->pat_date_alta ;
															
													
                                            ?>
                                            <tbody>
                                                <tr>
                                                    
                                                    <td style="text-align: center; vertical-align: middle;"> <!-- 1 -->
                                                        <div class="checkdiv grey400">
																<input type="checkbox" class="le-checkbox" id="status_record_<?php echo $cnt;?>" name="status_record" <?php echo $checked;?> disabled/>
																
														</div>
                                                    </td>
                                                    <td> <!-- 2 -->
                                                        <?php echo $row->pat_id;?>
                                                    </td>    
                                                    <td> <!-- 3 -->
                                                        <?php echo $row->pat_sip;?>
                                                    </td> 
                                                    <td> <!-- 4 -->
                                                        <?php echo $row->pat_nhc;?>
                                                    </td>
                                                    <td> <!-- 5 -->
                                                        <?php echo $row->pat_role;?>
                                                    </td>
                                                    <td> <!-- 6 -->
                                                        <?php echo $pat_date_ingreso ;?> 
                                                    </td>
													<td> <!-- 7 -->
                                                        <?php echo $pat_date_alta;?> 
                                                    </td>
													<td> <!-- 8 -->
                                                        <?php echo $row->pat_age;?> años
                                                    </td>
													<td> <!-- 9 -->
                                                        <?php echo $row->pat_sex_name;?> 
                                                    </td>
                                                    <td>
													<div class= "col">
													
														<a href="his_doc_view_single_patient_record.php?pat_id=<?php echo $row->pat_id;?>&&pat_index=<?php echo $row->pat_index;?>" class="badge badge-success"><i class="mdi mdi-pencil " style ="font-size:15px;"></i>Ficha</a>
													</div>
													<div class= "col">
														<a href="his_doc_view_single_patient.php?pat_id=<?php echo $row->pat_id;?>&&pat_index=<?php echo $row->pat_index;?>" class="badge badge-primary"><i class="mdi  mdi-check-box-outline" style ="font-size:15px;" ></i>Días</a>
													
													</div>
													
													</td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                </tr>
                                            </tbody>
                                            <?php }?>
                                        </table>
                                    </div>
                                </div>
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

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0 text-white">Ajustes</h5>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">Laura Romero Jaque</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h5 class="pl-3">Ajustes básicos</h5>
                <hr class="mb-0" />

                <div class="p-3">
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox1" type="checkbox" checked>
                        <label for="Rcheckbox1">
                            Notificaciones
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox2" type="checkbox" checked>
                        <label for="Rcheckbox2">
                            API Access
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox3" type="checkbox">
                        <label for="Rcheckbox3">
                            Auto Actualizaciones
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox4" type="checkbox" checked>
                        <label for="Rcheckbox4">
                            Online Status
                        </label>
                    </div>
                    <!-- <div class="checkbox checkbox-primary mb-0">
                        <input id="Rcheckbox5" type="checkbox" checked>
                        <label for="Rcheckbox5">
                            Auto Payout
                        </label>
                    </div> -->
                </div>

                <!-- Timeline -->
                <hr class="mt-0" />
                <h5 class="px-3">Mensajes <span class="float-right badge badge-pill badge-danger">25</span></h5>
                <hr class="mb-0" />
                <div class="p-3">
                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                        </div>

                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                    </div> <!-- end inbox-widget -->
                </div> <!-- end .p-3-->

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- checks dinamicos-->
		<script>
		pentitle="Checkboxes";

		setTimeout(checkedbox, 1000);
		setTimeout(uncheckedbox, 2000);
		function checkedbox() {
		  $('.thisonetocheck').prop('checked', true);
		}

		function uncheckedbox() {
		  $('.thisonetocheck').prop('checked', false);
		  $('.thisonetocheckalso').prop('checked', true);
		}

		</script>
		<!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Plugins js-->
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script>

        <!-- Dashboar 1 init js-->
        <script src="assets/js/pages/dashboard-1.init.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>