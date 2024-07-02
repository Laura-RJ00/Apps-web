<?php
    session_start();
    unset($_SESSION['res_index']);
    unset($_SESSION['res_id']);
    session_destroy();

    header("Location: his_res_logout.php");
    exit;
?>
