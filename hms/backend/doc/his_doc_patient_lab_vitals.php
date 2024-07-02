<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Laboratorio</a></li>
                                            <li class="breadcrumb-item active">Añadir histonas</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Ingresar histonas</h4>
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
                                                <div class="form-group mr-2" style="display:none">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Mostrar todo</option>
                                                        <!--<option value="Discharged">Discharged</option> -->
                                                        <option value="OutPatients">OutPatients</option>
                                                        <option value="InPatients">InPatients</option>
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
                                                <th data-hide="phone">ID</th>
												<th data-hide="phone">SIP</th>
                                                <th data-hide="phone">NHC</th>
                                                <th data-hide="phone">Rol</th>
                                                <th data-hide="phone">Ingreso</th>
                                                <th data-hide="phone">Alta</th>
												<th data-hide="phone">Edad</th>
                                                <th data-hide="phone">Sexo</th>
                                                <th data-hide="phone">Acción</th>
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
														ORDER BY pat_index DESC"; 
                                                //sql code to get to ten docs  randomly
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=0;
                                                while($row=$res->fetch_object())
                                                {
													$cnt++;
													$pat_date_ingreso = ($row->pat_date_ingreso== '1970-01-01'|| empty($row->pat_date_ingreso)) ? 'No registrada' : $row->pat_date_ingreso;
													$pat_date_alta = ($row->pat_date_alta== '1970-01-01' || empty($row->pat_date_alta)) ? 'No registrada' : $row->pat_date_alta ;
                                            ?>

                                                <tbody>
                                                <tr>
												
													<td> <!-- 1 -->
                                                        <?php echo $cnt;?>
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
                                                        <?php echo $pat_date_ingreso;?> 
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
                                                    
                                                    <td><a href="his_doc_add_single_patient_vitals.php?pat_id=<?php echo $row->pat_id;?>" class="badge badge-success"><i class="mdi mdi-beaker "></i> Introducir histonas</a></td>
                                                </tr>
                                                </tbody>
                                            <?php }?>
                                            <tfoot>
												<tr class="active">
													<td colspan="10">
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