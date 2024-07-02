<head>
        <meta charset="utf-8" />
        <title>Hospital Management Information System of Sepsis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="Laura Romero Jaque" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Plugins css -->
        <link href="assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
		
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">-->
         <!-- Loading button css -->
         <link href="assets/libs/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
		 
		 <!-- selct2 -->
	   
	   

        <!-- Footable css -->	
        <link href="assets/libs/footable/footable.core.min.css" rel="stylesheet" type="text/css" />
		

      
	   
	   <!-- Datatables css-->
	   
	    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
		<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />-->
    <!-- searchPanes -->
		<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css">
    <!-- select -->
		<link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
	   
	   <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" rel="stylesheet" type="text/css" />
	   <!--<link href="assets/libs/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
	   <link href="assets/libs/datatables/SearchPanes-2.1.2/css/searchPanes.dataTables.min.css" rel="stylesheet" type="text/css" />
	   <link href="assets/libs/datatables/Select-1.6.2/css/select.dataTables.min.css" rel="stylesheet" type="text/css" />
	   <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet" type="text/css" />  -->
	   
	   
	  <!-- <script src="assets/js/jquery.js"></script>-->
	  <!-- <script src="assets/js/jquery.min.js"></script>-->
	  <!--<script src="assets/js/bootstrap.js"></script>-->
	   <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>-->
	   <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>-->
	   
	   <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
	   <script src="assets/js/bootstrap.min.js"></script>
	   <script src="assets/js/bootstrap.bundle.min.js"></script>
	   
	    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
	   
	   <!-- selct2 -->
	   
	   
	   
		
	   
	   <!--Load Sweet Alert Javascript-->
	   
	   <!-- Incluye DataTables -->
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>

<!-- Incluye SearchPanes -->
<!--<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/2.1.1/js/dataTables.searchPanes.min.js"></script>
	  

	
	  
	   
       <!--<script src="assets/js/swal.js"></script>-->
	   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	      
			   
        <!--Inject SWAL-->
		<!--This code for injecting an alert- si falla es porque he cambiado la libreria de sweet a otra para que vuelva a funcionar
		cambiar Swal.fire a  solo swal y redireccionar la libreria sweet a la viaja que está en comentarios-->
		
        <?php if(isset($success)) {?>
        
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Correcto","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Error","<?php echo $err;?>","error");
                            },
                                100);
                </script>

        <?php } ?>
		
		<?php if(isset($warn)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Aviso","<?php echo $warn;?>","warning");
                            },
                                100);
                </script>

        <?php } ?>
		
		<?php if(isset($info)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                Swal.fire("Aviso","<?php echo $info;?>","info");
                            },
                                100);
                </script>

        <?php } ?>
		
		<!--<style type="text/css">
			.modal:nth-of-type(even) {
				z-index: 1052 !important;
			}
			.modal-backdrop.show:nth-of-type(even) {
				z-index: 1051 !important;
			}
		
		
		</style>-->
		
		<style>
		
		
		
		.select2-results__option--highlighted {
			background-color: #3d5afe !important;
		  }
		  
		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			background-color: #0d6efd;
			border-color: #3d9970;
		}
		  
		.campos-wrapper {
		  display: block;
		  margin-top: 10px;
		}
		  
	    
		
		
		.custom-fieldset{
			border: 2px solid #673ab7; 
		    padding: 10px; 
		}
		.campo-naranja {
			border: 2px solid orange;
		}

		.campo-naranja::after {
			content: "\f06a"; /* Código Unicode del icono de alerta (puedes utilizar un icono de tu elección) */
			font-family: "Font Awesome"; /* Asegúrate de tener cargada la fuente Font Awesome */
			position: absolute;
			top: 50%;
			right: 10px;
			transform: translateY(-50%);
			color: orange;
		}
		
		.additional-error {
		  color: red;
		  font-size: 12px;
		  margin-top: 5px;
		}
		
		.campo_toma_datos{
			
			padding:14px;
			border:3px solid #14A44D; 
			border-radius: 8px;
			box-shadow: 0 0 10px #666; 
			background:#e8f5e9;
			
		}
		
		.legendCustom {
		  background-color: #14A44D;
		  color: white;
		  padding: 5px 10px;
		  font-size:15px;
		}
		
		.legendRemember {
		  background-color: #7e57c2;
		  color: white;
		  padding: 5px 10px;
		  font-size:15px;
		}
		
		.legendPat {
		  background-color: #0288d1;
		  color: white;
		  padding: 5px 10px;
		  font-size:15px;
		}
		.modal.fade {
			background: rgba(0,0,0,0.5);
		}
		
		button:disabled {
		  cursor: not-allowed;
		  pointer-events: all !important;
		}
		
		input.class[type=checkbox][disabled]{
		   cursor:not-allowed;
		   pointer-events: all !important;
		}
		
		.formatForButton {
			background:pink;
		}
		
		.formatForOriginalButton{
			background:#6658dd;
			color : white;
		}
		
		.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
		  background-color: green!important;
		}

		.custom-checkbox .custom-control-input:checked:focus ~ .custom-control-label::before {
		  box-shadow: 0 0 0 1px #fff, 0 0 0 0.2rem rgba(0, 255, 0, 0.25)
		}
		.custom-checkbox .custom-control-input:focus ~ .custom-control-label::before {
		  box-shadow: 0 0 0 1px #fff, 0 0 0 0.2rem rgba(0, 0, 0, 0.25)
		}
		.custom-checkbox .custom-control-input:active ~ .custom-control-label::before {
		  background-color: #C8FFC8; 
		}
		
			
		
		.checkdiv {
		  position: relative;
		  padding: 4px 8px;
		  border-radius:40px;
		  margin-bottom:4px;
		  min-height:30px;
		  padding-left:40px;
		  display: flex;
		  align-items: center;
		}
		.checkdiv:last-child {
		  margin-bottom:0px;
		}
		.checkdiv span {
		  position: relative;
		  vertical-align: middle;
		  line-height: normal;
		}
		.le-checkbox {
		  appearance: none;
		  position: absolute;
		  top:50%;
		  left:5px;
		  transform:translateY(-50%);
		  background-color: #F44336;
		  width:30px;
		  height:30px;
		  border-radius:40px;
		  margin:0px;
		  outline: none; 
		  transition:background-color .5s;
		}
		.le-checkbox:before {
		  content:'';
		  position: absolute;
		  top:50%;
		  left:50%;
		  transform:translate(-50%,-50%) rotate(45deg);
		  background-color:#ffffff;
		  width:20px;
		  height:5px;
		  border-radius:40px;
		  transition:all .5s;
		}

		.le-checkbox:after {
		  content:'';
		  position: absolute;
		  top:50%;
		  left:50%;
		  transform:translate(-50%,-50%) rotate(-45deg);
		  background-color:#ffffff;
		  width:20px;
		  height:5px;
		  border-radius:40px;
		  transition:all .5s;
		}
		.le-checkbox:checked {
		  background-color:#4CAF50;
		}
		.le-checkbox:checked:before {
		  content:'';
		  position: absolute;
		  top:50%;
		  left:50%;
		  transform:translate(-50%,-50%) translate(-4px,3px) rotate(45deg);
		  background-color:#ffffff;
		  width:12px;
		  height:5px;
		  border-radius:40px;
		}

		.le-checkbox:checked:after {
		  content:'';
		  position: absolute;
		  top:50%;
		  left:50%;
		  transform:translate(-50%,-50%) translate(3px,2px) rotate(-45deg);
		  background-color:#ffffff;
		  width:16px;
		  height:5px;
		  border-radius:40px;
		}
		
		.button-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
		}
		
		.button-container > .form-row {
			display: flex;
			align-items: center;
			margin-right: 10px;
			margin-bottom: 10px;
		}
		
		
		.desenfoque {
			filter: blur(5px);
			pointer-events: none;
		}
		
		.loading {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background-color: rgba(0, 0, 0, 0.5);
			z-index: 9999;
		}

		.loading::after {
			content: "";
			display: block;
			width: 20px;
			height: 20px;
			margin: 10px;
			border-radius: 50%;
			border: 2px solid #fff;
			border-color: #fff transparent #fff transparent;
			animation: loading-animation 0.6s linear infinite;
		}

		@keyframes loading-animation {
			0% {
				transform: rotate(0);
			}
			100% {
				transform: rotate(360deg);
			}
}
			<!--.dtsp-searchPanes .dtsp-paneInputButton .dtsp.search {
		  white-space: normal;
		  max-width: 400px; /* Ajuste del ancho máximo según las necesidades */
		  overflow: hidden;
		  text-overflow: ellipsis;
		}
		
		<!--.full_screen {
            width: 100%;
            height: 100%;
           
        }-->
		
		
		<!--.center {
		display: flex;
		flex-wrap: wrap;
		align-content: center;
		justify-content: center;
		}-->
		</style>
		
		

		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
		
		<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
		
		

		
</head>