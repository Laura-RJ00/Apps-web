<?php
session_start();
include('config.php');

$response = array('success' => false);

if (isset($_POST['id_dia'])){
				
		$pat_id=$_POST['pat_id'];
		$id_dia = intval($_POST['id_dia']);
		$id_tipo_toma=$_POST['id_tipo_toma'];
		
				
		$status_dia = "";
		$SOFA = "";
		$pcr_pat = "";
		$lactato_pat = "";
		$pH_pat = "";
		$procalcitonina_pat = "";
		$h2b_pat = "";
		$h3_pat = "";
		$h4_pat = "";
		$pca_pat = "";
		$prot_c_pat = "";

		$fr_pat = "";
		$tas_pat = "";
		$tam_pat = "";
		$prot_total_pat = "";
		$leuco_pat = "";
		$neutro_pat = "";
		$plaque_pat = "";
		$hemo_pat = "";
		$albu_pat = "";
		$prealbu_pat = "";
		$Ca_pat = "";
		$ac_urico_pat = "";
		$coles_pat = "";
		$triglicr_par = "";
		$hdl_pat = "";
		$ldl_pat = "";
		$trans_gpt_pat = "";
		$trans_got_pat = "";
		$trans_ggt_pat = "";
		$fosfa_alcali_pat = "";
		$Fe_pat = "";
		$bili_total_pat = "";
		$bili_direct_pat = "";
		$bilir_pat = "";
		$ferrit_pat = "";
		$transferr_pat = "";
		$fosfo_pat = "";
		$magnesi_pat = "";
		$zinc_pat = "";
		$cd3_abs_pat = "";
		$cd4_abs_pat = "";
		$cd8_abs_pat = "";
		$glucosa_pat = "";
		$urea_pat = "";
		$creati_pat = "";
		$sodio_pat = "";
		$K_pat = "";
		$Cl_pat = "";
		$pac02_pat = "";
		$pa02_pat = "";
		$fi02_pat = "";
		$ratio_pao2_fio2 = "";
		$bicar_pat = "";
		$quick_pat = "";
		$ldh_pat = "";
		$fibrino_pat = "";
		$dimeroD_pat = "";
		$proBNP_pat = "";
		$trop_card_ultra = "";
		$pro_tromb_pat = "";
		$trombo_act_pat = "";
		$antitromb_3 = "";
		$ist_pat = "";
		
		
		$ret="SELECT * FROM `vars` 
		LEFT JOIN `marcadores` ON `vars`.`patient_id`= `marcadores`.`patient_id` 
		WHERE `vars`.`patient_id`= ? AND `vars`.`dia_toma_datos`= ?  AND `marcadores`.`dia_toma_datos`= ? AND `vars`.`momento_toma`= ?  AND `marcadores`.`momento_toma`= ?";
		
		$stmt= $mysqli->prepare($ret) ;
		$stmt->bind_param('siiss',$pat_id,$id_dia,$id_dia,$id_tipo_toma,$id_tipo_toma);
		$stmt->execute() ;//ok
		
		$res=$stmt->get_result();
		
		if($row=$res->fetch_object())
		{
			$status_dia = $row->status_dia;
			$SOFA = $row->SOFA;
			$pcr_pat = $row->PCR;
			$lactato_pat = $row->lactato;
			$pH_pat = $row->pH;
			$procalcitonina_pat = $row->procalcitonina;
			$h2b_pat = $row->H2B;
			$h3_pat = $row->H3;
			$h4_pat = $row->H4;
			$pca_pat = $row->PCA;
			$prot_c_pat = $row->Prot_C_funcional;

			$fr_pat = $row->FR;
			$tas_pat = $row->TAS;
			$tam_pat = $row->TAM;
			$prot_total_pat = $row->proteina_total;
			$leuco_pat = $row->leucocitos;
			$neutro_pat = $row->neutrofilos;
			$plaque_pat = $row->plaquetas;
			$hemo_pat = $row->hemoglobina;
			$albu_pat = $row->albumina;
			$prealbu_pat = $row->prealbumina;
			$Ca_pat = $row->Ca;
			$ac_urico_pat = $row->acido_urico;
			$coles_pat = $row->colesterol_total;
			$triglicr_par = $row->trigliceridos;
			$hdl_pat = $row->hdl;
			$ldl_pat = $row->ldl;
			$trans_gpt_pat = $row->trasaminasa_gpt;
			$trans_got_pat = $row->trasaminasa_got;
			$trans_ggt_pat = $row->transaminasa_ggt;
			$fosfa_alcali_pat = $row->fosfatasa_alcalina;
			$Fe_pat = $row->Fe;
			$bili_total_pat = $row->bilirrubina_total;
			$bili_direct_pat = $row->bilirrubina_direct;
			$bilir_pat = $row->bilirrubina;
			$ferrit_pat = $row->ferritina;
			$transferr_pat = $row->transferrina;
			$fosfo_pat = $row->fosforo;
			$magnesi_pat = $row->magnesio;
			$zinc_pat = $row->Zn;
			$cd3_abs_pat = $row->linfocitos_cd3abs;
			$cd4_abs_pat = $row->linfocitos_cd4_abs;
			$cd8_abs_pat = $row->linfocitos_cd8_abs;
			$glucosa_pat = $row->glucosa;
			$urea_pat = $row->urea;
			$creati_pat = $row->creatinina;
			$sodio_pat = $row->Na;
			$K_pat = $row->K;
			$Cl_pat = $row->Cl;
			$pac02_pat = $row->PaC02;
			$pa02_pat = $row->Pa02;
			$fi02_pat = $row->Fi02;
			$ratio_pao2_fio2 = $row->Pa02_Fi02;
			$bicar_pat = $row->bicarbonato;
			$quick_pat = $row->ind_quick;
			$ldh_pat = $row->LDH;
			$fibrino_pat = $row->fibrinógeno;
			$dimeroD_pat = $row->dimero_d;
			$proBNP_pat = $row->nt_proBNP;
			$trop_card_ultra = $row->troponina_cardiac_ultrasensib;
			$pro_tromb_pat = $row->tiempo_pro_trombina;
			$trombo_act_pat = $row->tiempo_tromboplastina_parcial_act;
			$antitromb_3 = $row->antitrombina_3;
			$ist_pat = $row->IST;
			} 
		
		
		if($stmt)
			{
			
			$response['success'] = true;
			$response['status_dia'] = $status_dia;
			$response['SOFA'] = $SOFA;
			$response['ist_pat'] = $ist_pat;
			$response['pcr_pat'] = $pcr_pat;
			$response['lactato_pat'] = $lactato_pat;
			$response['pH_pat'] = $pH_pat;
			$response['procalcitonina_pat'] = $procalcitonina_pat;
			$response['h2b_pat'] = $h2b_pat;
			$response['h3_pat'] = $h3_pat;
			$response['h4_pat'] = $h4_pat;
			$response['pca_pat'] = $pca_pat;
			$response['prot_c_pat'] = $prot_c_pat;

			$response['fr_pat'] = $fr_pat;
			$response['tas_pat'] = $tas_pat;
			$response['tam_pat'] = $tam_pat;
			$response['prot_total_pat'] = $prot_total_pat;
			$response['leuco_pat'] = $leuco_pat;
			$response['neutro_pat'] = $neutro_pat;
			$response['plaque_pat'] = $plaque_pat;
			$response['hemo_pat'] = $hemo_pat;
			$response['albu_pat'] = $albu_pat;
			$response['prealbu_pat'] = $prealbu_pat;
			$response['Ca_pat'] = $Ca_pat;
			$response['ac_urico_pat'] = $ac_urico_pat;
			$response['coles_pat'] = $coles_pat;
			$response['triglicr_par'] = $triglicr_par;
			$response['hdl_pat'] = $hdl_pat;
			$response['ldl_pat'] = $ldl_pat;
			$response['trans_gpt_pat'] = $trans_gpt_pat;
			$response['trans_got_pat'] = $trans_got_pat;
			$response['trans_ggt_pat'] = $trans_ggt_pat;
			$response['fosfa_alcali_pat'] = $fosfa_alcali_pat;
			$response['Fe_pat'] = $Fe_pat;
			$response['bili_total_pat'] = $bili_total_pat;
			$response['bili_direct_pat'] = $bili_direct_pat;
			$response['bilir_pat'] = $bilir_pat;
			$response['ferrit_pat'] = $ferrit_pat;
			$response['transferr_pat'] = $transferr_pat;
			$response['fosfo_pat'] = $fosfo_pat;
			$response['magnesi_pat'] = $magnesi_pat;
			$response['zinc_pat'] = $zinc_pat;
			$response['cd3_abs_pat'] = $cd3_abs_pat;
			$response['cd4_abs_pat'] = $cd4_abs_pat;
			$response['cd8_abs_pat'] = $cd8_abs_pat;
			$response['glucosa_pat'] = $glucosa_pat;
			$response['urea_pat'] = $urea_pat;
			$response['creati_pat'] = $creati_pat;
			$response['sodio_pat'] = $sodio_pat;
			$response['K_pat'] = $K_pat;
			$response['Cl_pat'] = $Cl_pat;
			$response['pac02_pat'] = $pac02_pat;
			$response['pa02_pat'] = $pa02_pat;
			$response['fi02_pat'] = $fi02_pat;
			$response['ratio_pao2_fio2'] = $ratio_pao2_fio2;
			$response['bicar_pat'] = $bicar_pat;
			$response['quick_pat'] = $quick_pat;
			$response['ldh_pat'] = $ldh_pat;
			$response['fibrino_pat'] = $fibrino_pat;
			$response['dimeroD_pat'] = $dimeroD_pat;
			$response['proBNP_pat'] = $proBNP_pat;
			$response['trop_card_ultra'] = $trop_card_ultra;
			$response['pro_tromb_pat'] = $pro_tromb_pat;
			$response['trombo_act_pat'] = $trombo_act_pat;
			$response['antitromb_3'] = $antitromb_3;
			
			}
			
			else {
				echo "No se encontró el registro o no se realizaron cambios.";
			}
		
		
				
				
			
	}
	
	echo json_encode($response);
?>