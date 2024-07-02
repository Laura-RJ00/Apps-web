<?php
session_start();
include('config.php');

$response = array('success' => false);

if (isset($_POST['id_dia'])){
				
		$pat_id=$_POST['pat_id'];
		$id_dia = intval($_POST['id_dia']);
		$id_tipo_toma=$_POST['id_tipo_toma'];
		
		
		$ret="SELECT * FROM `vars` 
		WHERE `pat_id`= ? AND `id_dia`=? AND `id_tipo_toma`=?";
		
		$stmt= $mysqli->prepare($ret) ;
		$stmt->bind_param('sis',$pat_id,$id_dia,$id_tipo_toma);
		$stmt->execute() ;//ok
		$res=$stmt->get_result();
		$check_pat_id = $res->num_rows;
		
		if ($check_pat_id > 0) {
			
			$h2b_pat = "";
			$h3_pat = "";
			$h4_pat = "";
			$pca_pat = "";
			$il6_pat = "";
			$comentarios_histonas= "";

			if($row=$res->fetch_object())
			{
				
				$h2b_pat = $row->H2B;
				$h3_pat = $row->H3;
				$h4_pat = $row->H4;
				$pca_pat = $row->PCA;
				$il6_pat = $row->il6;
				$comentarios_histonas = $row->comentarios_histonas;

				} 
			
			
			if($stmt)
				{
				
				$response['success'] = true;
				
				$response['h2b_pat'] = $h2b_pat;
				$response['h3_pat'] = $h3_pat;
				$response['h4_pat'] = $h4_pat;
				$response['pca_pat'] = $pca_pat;
				$response['il6_pat'] = $il6_pat;
				$response['comentarios_histonas'] = $comentarios_histonas;

				
				}
				
				else {
				
					echo "No se encontró el registro o no se realizaron cambios.";
				}
		}else{
		
		$response['success'] = false;
		
		}		
				
			
	}
	
	echo json_encode($response);
?>