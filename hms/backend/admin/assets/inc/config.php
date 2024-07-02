<?php
$dbuser="usuario_DOC";
$dbpass="8840prueba3008";
$host="0.0.0.0";
$db="hmi_sepsis";
$mysqli=new mysqli($host,$dbuser, $dbpass, $db);

$habilitarElementoNav = true; // Variable de control para habilitar o deshabili>
$habilitarElementoSidebar = true; // Variable de control para habilitar o desha>


if (!$mysqli) {
    die("Conexión fallida: " . mysqli_connect_error());
}

?>
