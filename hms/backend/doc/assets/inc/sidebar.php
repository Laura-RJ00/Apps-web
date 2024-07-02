<div class="left-side-menu">

	<div class="slimscroll-menu">

		<!--- Sidemenu -->
		<div id="sidebar-menu">
		
			<?php if ($habilitarElementoNav): ?>
			  <ul class="metismenu" id="side-menu">

				<li class="menu-title">Navegación</li>

				<li>
					<a href="his_doc_dashboard.php">
						<i class="fe-airplay"></i>
						<span> Tablero </span>
					</a>
					
				</li>

				<li>
					<a href="javascript: void(0);">
						<i class="fab fa-accessible-icon "></i>
						<span> Pacientes </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<li>
							<a href="his_doc_register_patient.php">Registrar paciente</a>
						</li>
						<li>
							<a href="his_doc_manage_patient.php">Búsqueda</a>
						</li>
						<li>
							<a href="his_doc_view_patients.php">Editar paciente</a>                                       
						</li>
						<hr>
						
					</ul>
				</li>

			  
				
				<!--<li>
					<a href="javascript: void(0);">
						<i class="mdi mdi-pill"></i>
						<span> Estadística </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<li>
							<a href="his_doc_add_pharm_cat.php">Análisis descriptivo</a>
						</li>
						<li>
							<a href="his_doc_view_pharm_cat.php">Análisis inferencial </a>
						</li>
						<li>
							<a href="his_doc_manage_pharm_cat.php">Análisis exploratorio </a>
						</li>
						<hr>
						<li>
							<a href="his_doc_add_pharmaceuticals.php">Análisis predictivo </a>
						</li>
						<li>
							<a href="his_doc_view_pharmaceuticals.php">Análisis causal </a>
						</li>
						<li>
							<a href="his_doc_manage_pharmaceuticals.php">Análisis mecanicista </a>
						</li>
						<hr>
						<li>
							<a href="his_doc_add_presc.php">Añadir prescripción</a>
						</li>
						<li>
							<a href="his_doc_view_presc.php">Ver prescripciones</a>
						</li>
						<li>
							<a href="his_doc_manage_presc.php">Administrar prescripciones</a>
						</li>
					</ul>
				</li> -->

				
				 <!-- <li>
					<a href="javascript: void(0);">
						<i class=" fas fa-funnel-dollar "></i>
						<span> Inventario </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
					   
						<li>
							<a href="his_doc_pharm_inventory.php">F</a>
						</li>

						<li>
							<a href="his_doc_equipments_inventory.php">Assets</a>
						</li>
						
					</ul>
				</li> -->
	
				<li>
					<a href="javascript: void(0);">
						<i class="mdi mdi-flask"></i>
						<span> Laboratorio </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<!--<li>
							<a href="his_doc_patient_lab_test.php"> Pruebas laboratorio del paciente</a>
						</li>
						<li>
							<a href="his_doc_patient_lab_result.php">Resultados pruebas laboratorio</a>
						</li> -->
						<li>
							<a href="his_doc_patient_lab_vitals.php">Registrar histonas </a>
						</li>
						
						<!--<li>
							<a href="his_doc_lab_report.php">Informes de laboratorio</a>
						</li>-->
						<hr>
						
					</ul>
				</li>

				<!-- <li>
					<a href="javascript: void(0);">
						<i class="mdi mdi-cash-refund "></i>
						<span> Payrolls </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						
						<li>
							<a href="his_doc_view_payrolls.php">M""</a>
						</li>
					</ul>
				</li> -->

				

			</ul>
			  
			<?php else: ?>
			  <ul class="metismenu" id="side-menu" disabled>

				<li class="menu-title">Navegación</li>

				<li>
					<a href="">
						<i class="fe-airplay"></i>
						<span> Tablero </span>
					</a>
					
				</li>

				<li>
					<a href="javascript: void(0);">
						<i class="fab fa-accessible-icon "></i>
						<span> Pacientes </span>
						<span class="menu-arrow"></span>
					</a>
					
				</li>

			  
				
				
	
				<li>
					<a href="javascript: void(0);">
						<i class="mdi mdi-flask"></i>
						<span> Laboratorio </span>
						<span class="menu-arrow"></span>
					</a>
					
				</li>

				

				

			</ul>
			<?php endif; ?>

			

		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

	
			
</div>