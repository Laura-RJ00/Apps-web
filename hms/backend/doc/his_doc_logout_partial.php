<?php
    session_start();
	include('assets/inc/config.php');
	//registro del logout del usuario
		$doc_id = $_SESSION['doc_id'];
		$logId = $_SESSION['logId'];
		$fechaHoraActual = date('Y-m-d H:i:s');
		
		$query_historial="UPDATE `userlog` SET `logOutTime`= ? WHERE `logId`=?";
		$stmt_hist = $mysqli->prepare($query_historial);
		$rc=$stmt_hist->bind_param('ss',$fechaHoraActual,$logId);
		$stmt_hist->execute();
		$stmt_hist->close();
		
    unset($_SESSION['doc_id']);
    unset($_SESSION['doc_number']);
    session_destroy();

    header("Location: his_doc_logout.php");
    exit;
?>

