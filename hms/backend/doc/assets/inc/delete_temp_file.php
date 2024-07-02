<?php
if (isset($_GET['tempFile'])) {
    $tempFile = $_GET['tempFile'];
    $tempFilePath = $tempFile; // Ruta completa al archivo temporal

    if (file_exists($tempFilePath)) {
        // Eliminar el archivo temporal
        unlink($tempFilePath);
        echo 'Archivo temporal eliminado con éxito.';
    } else {
        echo 'El archivo temporal no existe.';
    }
} else {
    echo 'Parámetro tempFile no proporcionado.';
}
?>