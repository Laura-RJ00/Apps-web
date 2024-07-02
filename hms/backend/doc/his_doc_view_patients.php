<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  
  $doc_id = $_SESSION['doc_id']
?>
<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>

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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tablero</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
                                            <li class="breadcrumb-item active">Ver pacientes</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detalles del paciente</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                <div class="form-group mr-2" style="">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Mostrar todo</option>
                                                       <!-- <option value="Discharged">Discharged</option> -->
                                                        <option value="OutPatients">Ficha completa</option>
                                                        <option value="InPatients">Ficha incompleta</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
												<th data-toggle="true">Ficha</th>
												<th data-toggle="true">ID</th>
                                                <th data-toggle="true">SIP</th>
												<th data-toggle="true">NHC</th>
                                                <th data-toggle="true">Rol estudio</th>
												<th data-toggle='true'>Tipo de control</th>
                                                <th data-toggle="true">Hallazgo clínico</th>
                                                <th data-toggle="true">Diagnóstico ingreso</th>
												<th data-toggle="true">Edad</th>
                                                <th data-toggle="true">Sexo</th>
                                                <th data-toggle="true">Modificar</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients
                                                *
                                            */
                                                $ret="SELECT * 
														FROM patients 
														LEFT JOIN control ON patients.pat_id= control.control_pat_id
														LEFT JOIN caso ON patients.pat_id= caso.case_pat_id
														LEFT JOIN clinical_finding ON caso.cl_find_id = clinical_finding.cl_find_id
														LEFT JOIN codigo_sexo ON patients.pat_sex= codigo_sexo.sex_codes
														WHERE pat_doc_assigned ='$doc_id'
														ORDER BY pat_index DESC "; 
														
                                                //
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=0;
                                                while($row=$res->fetch_object())
                                                {
													$cnt++;
													$checked = ($row->pat_record_status == 1) ? 'checked' : '';
													
													$pat_control_type = !empty($row ->control_type) ? $row->control_type : 'No aplica';
													$pat_diagnos_ingreso = !empty($row ->pat_diag_ingreso) ? $row->pat_diag_ingreso : 'No aplica';
													$pat_cl_find_name = !empty($row->cl_find_name) ? $row->cl_find_name : 'No aplica';
                                            ?>

											<tbody>
											<tr>
												<td><?php echo $cnt;?></td>
												<td style="text-align: center; vertical-align: middle;">
													<div class="checkdiv grey400">
														<input type="checkbox" class="le-checkbox" id="status_record_<?php echo $cnt;?>" name="status_record" <?php echo $checked;?> disabled/>
																
													</div>
												</td>
												<td><?php echo $row->pat_id;?></td>
												<td><?php echo $row->pat_sip;?></td>
												<td><?php echo $row->pat_nhc;?></td>
												<td><?php echo $row->pat_role;?></td>
												<td><?php echo $pat_control_type;?></td>
												<td><?php echo $pat_cl_find_name;?></td>
												<td><?php echo $pat_diagnos_ingreso;?></td>
												<td><?php echo $row->pat_age;?> años</td>
												<td><?php echo $row->pat_sex_name;?></td>
												
												
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
                                            <?php   }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="12">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
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


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>