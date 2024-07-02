<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
?>
<!DOCTYPE html>
<html lang="en">
    
<?php include ('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
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
												<li class="breadcrumb-item active">Ver entidad</li>
                                        </ol>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">#<?php echo $ent_id;?> - <?php echo $ent_name;?></h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 

                            <div class="row">
                                 <div class="col-lg-6 col-xl-6">
                                    <div class="card-box">
                                        <div class="row">
                                            <img src="assets/images/medical_record.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                            <div class="text-centre mt-3">
                                                <div class="pl-xl-3 mt-3 mt-xl-0">
													<p class="text-muted mb-2 font-13"><strong>Nombre :</strong> <span class="ml-2"><?php echo $ent_name;?></span></p> 
													<p class="text-muted mb-2 font-13"><strong>Localización :</strong> <span class="ml-2"><?php echo $ent_location;?></span></p> 
													<p class="text-muted mb-2 font-13"><strong>Responsable :</strong> <span class="ml-2"><?php echo $ent_resp;?></span></p> 
													<p class="text-muted mb-2 font-13"><strong>Correo de contacto :</strong> <span class="ml-2"><?php echo $ent_mail;?></span></p> 
                                                    
													
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                    </div>   
                                 </div> 
							</div>
							<div class="row">
								<div class="col">
									
									<div class="card-box">
										<h4 class="header-title">Usuarios asociados</h4> <br>
										<div class="mb-2">
											<div class="row">
												<div class="col-12 text-sm-center form-inline" >
													
													<div class="form-group">
														<input id="demo-foo-search-users" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
													</div>
												</div>
											</div>
											
										</div>	
										<div class="table-responsive">
											<table id="demo-foo-filtering-users" class="table table-bordered toggle-circle mb-0" data-page-size="7">
												<thead class="thead-light">
													<tr>
														<th>#</th>
														<th>ID usuario</th>
														<th>Nombre</th>
														<th>Apellidos</th>
														<th>Correo</th>
														
														
													</tr>
												</thead>
												
													<tbody>
														<?php
														$ent_id = intval($_GET['ent_id']);
														$ent_type = $_GET['ent_type'];

														if ($ent_type == 'hospital') {
															$ret = "SELECT * FROM user_docs WHERE doc_hospital = ?";
															$stmt = $mysqli->prepare($ret);
															$stmt->bind_param('i', $ent_id);
															$stmt->execute();
															$res = $stmt->get_result();
															$cnt = 1;

															while ($row = $res->fetch_object()) {
																$users = $row->doc_id;
																$users_name = $row->doc_name;
																$users_surname = $row->doc_surname;
																$users_mail = $row->doc_mail;
																
																?>
																<tr>
																	<td><?php echo $cnt; ?></td>
																	<td><?php echo $users; ?></td>
																	<td><?php echo $users_name; ?></td>
																	<td><?php echo $users_surname; ?></td>
																	<td><?php echo $users_mail; ?></td>
																</tr>
																<?php
																$cnt++;
															}
														} elseif ($ent_type == 'research') {
															$ret = "SELECT * FROM user_research WHERE res_center = ?";
															$stmt = $mysqli->prepare($ret);
															$stmt->bind_param('i', $ent_id);
															$stmt->execute();
															$res = $stmt->get_result();
															$cnt = 1;

															while ($row = $res->fetch_object()) {
																
																$users = $row->res_id;
																$users_name = $row->res_name;
																$users_surname = $row->res_surname;
																$users_mail = $row->res_mail;
																
																?>
																<tr>
																	<td><?php echo $cnt; ?></td>
																	<td><?php echo $users; ?></td>
																	<td><?php echo $users_name; ?></td>
																	<td><?php echo $users_surname; ?></td>
																	<td><?php echo $users_mail; ?></td>
																</tr>
																<?php
																$cnt++;
															}
														}
														?>
													</tbody>
													<tfoot>
													<tr class="active">
														<td colspan="5">
															<div class="text-right">
																<ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
															</div>
														</td>
													</tr>
													</tfoot>
												 
											</table>
											
										</div>

									</div> <!-- end card-box -->

									

                                    
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->
                            
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

         <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
		<script>
		$(document).ready(function() {
			$('#demo-foo-filtering-users').footable();
			
			
			// Event handler for search input
			$('#demo-foo-search-users').on('input', function() {
				var searchText = $(this).val().toLowerCase();

				// Filter table rows based on search text
				$('#demo-foo-filtering-users').data('footable-filter').filter(searchText);
				
			});
			
			
		});
		</script>
        
    </body>

</html>