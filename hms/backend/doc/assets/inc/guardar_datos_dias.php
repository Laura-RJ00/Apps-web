<?php
session_start();
include('config.php');

$response = array('success_1' => false, 'success_2' => false);


//$SerializedData = $_POST['formData'];

if (isset($_POST['pat_number_copy'])){
				// nuestras variables
				
				$id_dia = intval($_POST['id_dia']);
				$pat_number_copy = $_POST['pat_number_copy'];
				$id_tipo_toma = $_POST['id_tipo_toma'];
				$ficha_dia =intval( $_POST['ficha_dia']);
				
				$SOFAtot = $_POST['SOFAtot'];
				$pcr_pat = $_POST['pcr_pat'];
				$lactato_pat = $_POST['lactato_pat'];
				$pH_pat = $_POST['pH_pat'];
				$procalcitonina_pat = $_POST['procalcitonina_pat'];
				$h2b_pat = $_POST['h2b_pat'];
				$h3_pat = $_POST['h3_pat'];
				$h4_pat = $_POST['h4_pat'];
				$pca_pat = $_POST['pca_pat'];
				$prot_c_pat = $_POST['prot_c_pat'];
				
				$fr_pat = $_POST['fr_pat'];
				$tas_pat = $_POST['tas_pat'];
				$tam_pat = $_POST['tam_pat'];
				$prot_total_pat = $_POST['prot_total_pat'];
				$leuco_pat = $_POST['leuco_pat'];
				$neutro_pat = $_POST['neutro_pat'];
				$plaque_pat = $_POST['plaque_pat'];
				$hemo_pat = $_POST['hemo_pat'];
				$albu_pat = $_POST['albu_pat'];
				$prealbu_pat = $_POST['prealbu_pat'];
				$Ca_pat = $_POST['Ca_pat'];
				$ac_urico_pat = $_POST['ac_urico_pat'];
				$coles_pat = $_POST['coles_pat'];
				$triglicr_par = $_POST['triglicr_par'];
				$hdl_pat = $_POST['hdl_pat'];
				$ldl_pat = $_POST['ldl_pat'];
				$trans_gpt_pat = $_POST['trans_gpt_pat'];
				$trans_got_pat = $_POST['trans_got_pat'];
				$trans_ggt_pat = $_POST['trans_ggt_pat'];
				$fosfa_alcali_pat = $_POST['fosfa_alcali_pat'];
				$Fe_pat = $_POST['Fe_pat'];
				$bili_total_pat = $_POST['bili_total_pat'];
				$bili_direct_pat = $_POST['bili_direct_pat'];
				$bilir_pat = $_POST['bilir_pat'];
				$ferrit_pat = $_POST['ferrit_pat'];
				$transferr_pat = $_POST['transferr_pat'];
				$fosfo_pat = $_POST['fosfo_pat'];
				$magnesi_pat = $_POST['magnesi_pat'];
				$zinc_pat = $_POST['zinc_pat'];
				$cd3_abs_pat = $_POST['cd3_abs_pat'];
				$cd4_abs_pat = $_POST['cd4_abs_pat'];
				$cd8_abs_pat = $_POST['cd8_abs_pat'];
				$glucosa_pat = $_POST['glucosa_pat'];
				$urea_pat = $_POST['urea_pat'];
				$creati_pat = $_POST['creati_pat'];
				$sodio_pat = $_POST['sodio_pat'];
				$K_pat = $_POST['K_pat'];
				$Cl_pat = $_POST['Cl_pat'];
				$pac02_pat = $_POST['pac02_pat'];
				$pa02_pat = $_POST['pa02_pat'];
				$fi02_pat = $_POST['fi02_pat'];
				$ratio_pao2_fio2 = $_POST['ratio_pao2_fio2'];
				$bicar_pat = $_POST['bicar_pat'];
				$quick_pat = $_POST['quick_pat'];
				$ldh_pat = $_POST['ldh_pat'];
				$fibrino_pat = $_POST['fibrino_pat'];
				$dimeroD_pat = $_POST['dimeroD_pat'];
				$proBNP_pat = $_POST['proBNP_pat'];
				$trop_card_ultra =  $_POST['trop_card_ultra'];
				$pro_tromb_pat = $_POST['pro_tromb_pat'];
				$trombo_act_pat = $_POST['trombo_act_pat'];
				$antitromb_3 = $_POST['antitromb_3'];
				$ist_pat = $_POST['ist_pat'];
				
				$query_id = "SELECT pat_id, id_dia FROM vars WHERE pat_id = ?  AND id_dia = ? AND id_tipo_toma= ? ";
				$stmt= $mysqli->prepare($query_id);
				$stmt->bind_param('sis', $pat_number_copy, $id_dia, $id_tipo_toma);
				$stmt->execute();
				$stmt->store_result();
				$check_pat_id = $stmt->num_rows;
		
		
				if ($check_pat_id > 0) {
					
					// vars
					$query= "UPDATE `vars` SET `status_dia`=?,
						`FR`=?, `TAS`=?, `TAM`=?, `proteina_total`=?, 
						`leucocitos`=?, `hemoglobina`=?, `plaquetas`=?, `neutrofilos`=?, 
						`albumina`=?, `prealbumina`=?, `Ca`=?, `acido_urico`=?,
						`colesterol_total`=?, `trigliceridos`=?, `hdl`=?, `ldl`=?, 
						`trasaminasa_gpt`=?, `trasaminasa_got`=?, `transaminasa_ggt`=?, 
						`fosfatasa_alcalina`=?, `Fe`=?, `IST`=?, `bilirrubina_total`=?, 
						`bilirrubina_direct`=?, `bilirrubina`=?,`ferritina`=?, `transferrina`=?, `fosforo`=?,
						`magnesio`=?,`Zn`=?, `linfocitos_cd3abs`=?, `linfocitos_cd4_abs`=?, 
						`linfocitos_cd8_abs`=?,  `glucosa`=?, `urea`=?, 
						`creatinina`=?, `Na`=?, `K`=?, `Cl`=?,`PaC02`=?, `Pa02`=?, `Fi02`=?, 
						`Pa02_Fi02`=?, `bicarbonato`=?, `dimero_d`=?, `fibrinogeno`=?, 
						`t_tromboplastina_parcial_act`=?, `troponina_cardiac_ultrasensib`=?,
						`t_pro_trombina`=?, `LDH`=?, `antitrombina_3`=?,  
						`ind_quick`=?, `nt_proBNP`=? 
						WHERE `id_dia`=? AND `pat_id`=? AND `id_tipo_toma` =?";
					
					
					$stmt = $mysqli->prepare($query);
					$rc=$stmt->bind_param('isssssssssssssssssssssssssssssssssssssssssssssssssssssiss',
					$ficha_dia,
					$fr_pat, $tas_pat, $tam_pat, $prot_total_pat, $leuco_pat, 
					$hemo_pat,$plaque_pat, $neutro_pat, $albu_pat, $prealbu_pat, $Ca_pat, 
					$ac_urico_pat, $coles_pat, $triglicr_par, $hdl_pat, $ldl_pat, $trans_gpt_pat, 
					$trans_got_pat, $trans_ggt_pat, $fosfa_alcali_pat, $Fe_pat,$ist_pat, $bili_total_pat, 
					$bili_direct_pat, $bilir_pat, $ferrit_pat, $transferr_pat, $fosfo_pat, 
					$magnesi_pat, $zinc_pat, $cd3_abs_pat, $cd4_abs_pat, $cd8_abs_pat, $glucosa_pat, 
					$urea_pat, $creati_pat, $sodio_pat, $K_pat, $Cl_pat, $pac02_pat, $pa02_pat, 
					$fi02_pat, $ratio_pao2_fio2, $bicar_pat,$dimeroD_pat,$fibrino_pat,
					$trombo_act_pat,$trop_card_ultra, $pro_tromb_pat,  $ldh_pat,  $antitromb_3, 
					$quick_pat,$proBNP_pat,
					$id_dia, $pat_number_copy,$id_tipo_toma);
					
					
					$stmt->execute();
					
					if($stmt)
					{
					
					$response['success_1'] = true;
					
						// vars
						$query= "UPDATE `vars` SET `SOFA`=?, `PCR`=?, `lactato`=?, 
							`pH`=?, `procalcitonina`=?, `H3`=?, `H4`=?, 
							`PCA`=?, `prot_C`=?, `H2B`=?
							WHERE `id_dia`=? AND `pat_id`=? AND `id_tipo_toma` =?";
						
						
						$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ssssssssssiss',
						$SOFAtot,$pcr_pat,$lactato_pat,$pH_pat,$procalcitonina_pat,
						$h2b_pat,$h3_pat,$h4_pat,$pca_pat,$prot_c_pat,
						$id_dia, $pat_number_copy, $id_tipo_toma);
						
						
						$stmt->execute();
						
						if($stmt)
						{
						
						$response['success_2'] = true;
						}
						else {
							echo "No se encontró el registro o no se realizaron cambios.";
						}
					}
					else {
						echo "No se encontró el registro o no se realizaron cambios.";
					} 
					
					
				
				}else{
					
					
					 //vars
					
					$query="INSERT INTO `vars`(`id_dia`, `id_tipo_toma`, `pat_id`, `status_dia`,
						`FR`, `TAS`, `TAM`, `proteina_total`, 
						`leucocitos`, `hemoglobina`, `plaquetas`, `neutrofilos`, 
						`albumina`, `prealbumina`, `Ca`, `acido_urico`,
						`colesterol_total`, `trigliceridos`, `hdl`, `ldl`, 
						`trasaminasa_gpt`, `trasaminasa_got`, `transaminasa_ggt`, 
						`fosfatasa_alcalina`, `Fe`, `IST`, `bilirrubina_total`, 
						`bilirrubina_direct`, `bilirrubina`,`ferritina`, `transferrina`, `fosforo`,
						`magnesio`,`Zn`, `linfocitos_cd3abs`, `linfocitos_cd4_abs`, 
						`linfocitos_cd8_abs`,  `glucosa`, `urea`, 
						`creatinina`, `Na`, `K`, `Cl`,`PaC02`, `Pa02`, `Fi02`, 
						`Pa02_Fi02`, `bicarbonato`, `dimero_d`, `fibrinogeno`, 
						`t_tromboplastina_parcial_act`, `troponina_cardiac_ultrasensib`,
						`t_pro_trombina`, `LDH`, `antitrombina_3`,  
						`ind_quick`, `nt_proBNP`,`SOFA`, `PCR`, `lactato`, 
						`pH`, `procalcitonina`, `H3`, `H4`, `PCA`, `prot_C`, `H2B`)
					
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
					?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
					
					
					$stmt = $mysqli->prepare($query);
						$rc=$stmt->bind_param('ississsssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss',
					$id_dia, $id_tipo_toma,$pat_number_copy, $ficha_dia,
					$fr_pat, $tas_pat, $tam_pat, $prot_total_pat, $leuco_pat, 
					$hemo_pat,$plaque_pat, $neutro_pat, $albu_pat, $prealbu_pat, $Ca_pat, 
					$ac_urico_pat, $coles_pat, $triglicr_par, $hdl_pat, $ldl_pat, $trans_gpt_pat, 
					$trans_got_pat, $trans_ggt_pat, $fosfa_alcali_pat, $Fe_pat,$ist_pat, $bili_total_pat, 
					$bili_direct_pat, $bilir_pat, $ferrit_pat, $transferr_pat, $fosfo_pat, 
					$magnesi_pat, $zinc_pat, $cd3_abs_pat, $cd4_abs_pat, $cd8_abs_pat, $glucosa_pat, 
					$urea_pat, $creati_pat, $sodio_pat, $K_pat, $Cl_pat, $pac02_pat, $pa02_pat, 
					$fi02_pat, $ratio_pao2_fio2, $bicar_pat,$dimeroD_pat,$fibrino_pat,
					$trombo_act_pat,$trop_card_ultra, $pro_tromb_pat,  $ldh_pat,  $antitromb_3, 
					$quick_pat,$proBNP_pat,$SOFAtot,$pcr_pat,$lactato_pat,$pH_pat,$procalcitonina_pat,
						$h2b_pat,$h3_pat,$h4_pat,$pca_pat,$prot_c_pat);
					
					
					$stmt->execute();
					if($stmt)
					{
					
					$response['success_1'] = true;
					
						
					}
					else {
						echo "No se encontró el registro o no se realizaron cambios.";
					} 
					
					
				}
	
	echo json_encode($response);
}
?>