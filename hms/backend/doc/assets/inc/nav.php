<?php
    $doc_index = $_SESSION['doc_index'];
    $doc_id = $_SESSION['doc_id'];
    $ret="SELECT * FROM  user_docs WHERE doc_index = ? AND doc_id = ?";
    $stmt= $mysqli->prepare($ret) ;
    $stmt->bind_param('is',$doc_index, $doc_id);
    $stmt->execute() ;//ok
    $res=$stmt->get_result();
    //$cnt=1;
    while($row=$res->fetch_object())
    {
?>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">

           

            
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/users/<?php echo $row->doc_pic;?>" alt="dpic" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <?php echo $row->doc_name;?> <?php echo $row->doc_surname;?> <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0"> ¡Bienvenida!</h6>
                    </div>

                    <!-- item-->
                    <!-- <a href="his_doc_account.php" class="dropdown-item notify-item">
                        <i class="fas fa-user"></i>
                        <span>My Account</span>
                    </a> -->

                    <a href="his_doc_update-account.php" class="dropdown-item notify-item">
                        <i class="fas fa-user-tag"></i>
                        <span>Actualizar cuenta </span>
                    </a>


                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="his_doc_logout_partial.php" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Cerrar sesión</span>
                    </a>

                </div>
            </li>

           

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <div class="logo text-center">
                <span class="logo-lg">
                    <img src="assets/images/logo_light-removebg.png" alt="" height="50">
                    <!-- <span class="logo-lg-text-light">UBold</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-sm-text-dark">U</span> -->
                    <img src="assets/images/logo_light-removebg.png" alt="" height="50">
                </span>
            </div>
        </div>

		
        <ul class="list-unstyled topnav-menu topnav-menu-left m-0" id= "boton_desplegable_opciones">
            <li>
			
			<?php if ($habilitarElementoNav): ?>
			  <button class="button-menu-mobile waves-effect waves-light">
					<i class="fe-menu"></i>
			  </button>
			  
			<?php else: ?>
			  <button class="button-menu-mobile waves-effect waves-light" disabled>
			    <i class="fe-menu"></i>
			  </button>
			<?php endif; ?>
				
                <!--<button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>-->
            </li>

			<?php if ($habilitarElementoNav): ?>
				  
			<?php else: ?>
			  
			<?php endif; ?>
				
           

        </ul>
    </div>
<?php }?>