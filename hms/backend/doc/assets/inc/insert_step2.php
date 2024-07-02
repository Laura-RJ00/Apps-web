<?php
session_start();
include('config.php');

$response = array('success' => false);


if (isset($_POST['pat_number']))
	{
		$pat_id = $_POST['pat_number'];
		
		$infarto_pac = intval($_POST['infarto_pac']);
		$cardiac_pac = intval($_POST['cardiac_pac']);
		$vasc_pac = intval($_POST['vasc_pac']);
		$cerebro_pac = intval($_POST['cerebro_pac']);
		$demencia_pac = intval($_POST['demencia_pac']);
		$epoc_pac = intval($_POST['epoc_pac']);
		$conect_pac = intval($_POST['conect_pac']);
		$hepaL_pac = intval($_POST['hepaL_pac']);
		$hepaM_pac = intval($_POST['hepaM_pac']);
		$pept_pac = intval($_POST['pept_pac']);
		$dm_pac = intval($_POST['dm_pac']);
		$dmlesion_pac = intval($_POST['dmlesion_pac']);
		$hemi_pac = intval($_POST['hemi_pac']);
		$renal_pac = intval($_POST['renal_pac']);
		$tumor_pac = intval($_POST['tumor_pac']);
		$metas_pac = intval($_POST['metas_pac']);
		$leu_pac = intval($_POST['leu_pac']);
		$linfo_pac = intval($_POST['linfo_pac']);
		$sida_pac = intval($_POST['sida_pac']);
		
		
		$cci_pac = intval($_POST['cci_pac']);
		$ha_pac = intval($_POST['ha_pac']);
		$tabaco_pac = intval($_POST['tabaco_pac']);
		$alcohol_pac = intval($_POST['alcohol_pac']);
		$cic_pac = intval($_POST['cic_pac']);
		$lp_pac = intval($_POST['lp_pac']);
		$hemato_pac = intval($_POST['hemato_pac']);
		$corti_pac = intval($_POST['corti_pac']);
		$antibio_pac = intval($_POST['antibio_pac']);
		$inmuno_pac = intval($_POST['inmuno_pac']);
		$prev_pac = intval($_POST['prev_pac']);
		$cifra_prev = intval($_POST['cifra_prev']); 
		$prev_sem = $_POST['prev_sem'];
		$cfs_pat = intval($_POST['cfs_pat']); 
		
		$query_pat_id = "SELECT pat_id FROM pat_risk_factors WHERE pat_id = ? ";
		$stmt= $mysqli->prepare($query_pat_id);
		$stmt->bind_param('s', $pat_id);
		$stmt->execute();
		$stmt->store_result();
		$check_pat_id = $stmt->num_rows;
		
		
			if ($check_pat_id > 0) {
				
				
				
				$query="UPDATE `pat_risk_factors` 
						SET 
						`infarto_miocardio`=?, `insuficiencia_cardiac_congest`=?, `enf_vasc_periferica`=?, 
						`enf_cerebro_vasc`=?, `demencial`=?, `epoc`=?, `patologia_conect`=?, `patologia_hepa_leve`=?, 
						`patologia_hepa_grav_mod`=?, `ulcera`=?, `diabetes`=?, `diabetes_lesion_org`=?, `hemiplejia`=?,
						`patologia_renal_grav_mod`=?, `tumor_solido`=?, `metastasis`=?, `leucemia`=?, `linfomas`=?, `sida`=?,
						`charlson`=?, `hta`=?,`tabaco`=?, `alcohol`=?, `cardio_isquemia_cronica`=?,`dislipemia`=?, 
						`enf_hemato_maligna`=?,`corticoides`=?, `inmunosupr`=?,
						`atb_prev_ingreso`=?, `ingreso_prev`=?,`ult_ingreso_num`=?, `ult_ingreso`=?,`CFS`=?

						WHERE `pat_id` = ?";
				
				$stmt = $mysqli->prepare($query);
				$rc=$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiss',
													$infarto_pac, $cardiac_pac, $vasc_pac, $cerebro_pac, 
													$demencia_pac, $epoc_pac, $conect_pac, $hepaL_pac, 
													$hepaM_pac, $pept_pac, $dm_pac, $dmlesion_pac, $hemi_pac, 
													$renal_pac, $tumor_pac, $metas_pac, $leu_pac, $linfo_pac, $sida_pac,
													$cci_pac, $ha_pac, $tabaco_pac, $alcohol_pac, 
													$cic_pac,$lp_pac, $hemato_pac, $corti_pac, $antibio_pac, 
													$inmuno_pac, $prev_pac, $cifra_prev, $prev_sem, $cfs_pat,
													$pat_id);
				$stmt->execute();
				
				if($stmt)
				{
					
					$response['success'] = true;
					
				}
				else {
					echo "No se encontró el registro o no se realizaron cambios.";
				} 
				
		
		
			}else{
				
				
				//sql to insert captured values
				$query="INSERT INTO `pat_risk_factors`(`pat_id`, 
								`infarto_miocardio`, `insuficiencia_cardiac_congest`, `enf_vasc_periferica`,
								`enf_cerebro_vasc`, `demencial`, `epoc`, `patologia_conect`, `patologia_hepa_leve`,
								`patologia_hepa_grav_mod`, `ulcera`, `diabetes`, `diabetes_lesion_org`, `hemiplejia`,
								`patologia_renal_grav_mod`, `tumor_solido`, `metastasis`, `leucemia`, `linfomas`, `sida`,
								`charlson`, `hta`, `tabaco`, `alcohol`,`cardio_isquemia_cronica`, `dislipemia`, 
								`enf_hemato_maligna`, `corticoides`, `inmunosupr`, `atb_prev_ingreso`, `ingreso_prev`, 
								`ult_ingreso_num`, 
								`ult_ingreso`,`CFS`) 
								VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				
				$stmt = $mysqli->prepare($query);
				$rc=$stmt->bind_param('siiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisi',$pat_id, 
												$infarto_pac, $cardiac_pac, $vasc_pac, $cerebro_pac, 
												$demencia_pac, $epoc_pac, $conect_pac, $hepaL_pac, 
												$hepaM_pac, $pept_pac, $dm_pac, $dmlesion_pac, $hemi_pac, 
												$renal_pac, $tumor_pac, $metas_pac, $leu_pac, $linfo_pac, $sida_pac,
												$cci_pac, $ha_pac, $tabaco_pac, $alcohol_pac, $cic_pac,
												$lp_pac, $hemato_pac, $corti_pac, $antibio_pac, $inmuno_pac,
												$prev_pac, $cifra_prev, $prev_sem,$cfs_pat );
				
				$stmt->execute();
				
				if($stmt)
				{
					
					$response['success'] = true;
				}
				else {
					
					echo "No se encontró el registro o no se realizaron cambios.";
				} 
				
			}	 
				
				
		
		
		
			
		
	}
	
	echo json_encode($response);
?>