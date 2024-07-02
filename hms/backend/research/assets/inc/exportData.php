<?php
session_start();

// Load the database configuration file 
include('config.php');

$response = array('success' => false);

if (isset($_POST['formData'])) {
    $formData = $_POST['formData'];
    $response['success'] = true;

    if (isset($formData['res_id'], $formData['columnData'])) {
        $res_id = $formData['res_id'];
        $columnData = $formData['columnData'];

        if (is_array($columnData)) {
            // Crear un archivo temporal único
            $filename = "hmisepsis-data_" . date('Y-m-d') . ".csv";
            $tempFile = "csv/" . $filename;

            // Crear el archivo CSV y escribir los datos
            $file = fopen($tempFile, "w");
            if (!$file) {
                die("Error al crear el archivo CSV temporal.");
            }

            // Preparar y ejecutar la consulta SQL con el valor de pat_id y res_id
            $query_headers = "SELECT 
                        `patients`.*, 
                        `vars`.*, 
                        `caso`.*, 
                        `manejo_inicial`.*, 
                        `pat_risk_factors`.*
                    FROM 
                        `patients` 
                        JOIN `vars` ON `patients`.pat_id = `vars`.pat_id 
                        JOIN `caso` ON `patients`.pat_id = `caso`.case_pat_id 
                        JOIN `manejo_inicial` ON `patients`.pat_id = `manejo_inicial`.pat_id 
                        JOIN `pat_risk_factors` ON `patients`.pat_id = `pat_risk_factors`.pat_id
                        JOIN `clinical_finding` ON `caso`.cl_find_id = `clinical_finding`.cl_find_id ";
			
			$query = "SELECT 
                        `patients`.*, 
                        `vars`.*, 
                        `caso`.*, 
                        `manejo_inicial`.*, 
                        `pat_risk_factors`.*
                    FROM 
                        `patients` 
                        JOIN `vars` ON `patients`.pat_id = `vars`.pat_id 
                        JOIN `caso` ON `patients`.pat_id = `caso`.case_pat_id 
                        JOIN `manejo_inicial` ON `patients`.pat_id = `manejo_inicial`.pat_id 
                        JOIN `pat_risk_factors` ON `patients`.pat_id = `pat_risk_factors`.pat_id
                        JOIN `clinical_finding` ON `caso`.cl_find_id = `clinical_finding`.cl_find_id 

                        WHERE
                        `patients`.pat_id IN (".implode(",", array_fill(0, count($columnData), "?")).")";


            // Exclude the columns from headers
            $excludedColumns = [
                'vars.pat_id',
				'manejo_inicial.pat_id',
				'pat_risk_factors.pat_id',
				'patients.pat_sip',
				'patients.pat_nhc',
				'patients.pat_index'
				
            ];
			
			$result = $mysqli->query($query_headers);
			
			$headers = $result->fetch_fields();
                $selectedHeaders = array_filter($headers, function ($column) use ($excludedColumns) {
                    $columnName = $column->name;
                    $tableName = $column->table;

                    // Exclude specified columns
                    if (in_array("$tableName.$columnName", $excludedColumns)) {
                        return false;
                    }

                    return true;
                });
			
			$headerRow = array_map(function ($column) {
                    return $column->name;
                }, $selectedHeaders);

                fputcsv($file, $headerRow);
				
				
			
            $stmt = $mysqli->prepare($query);

			$types = str_repeat('s', count($columnData));
			$stmt->bind_param($types, ...$columnData);

			$stmt->execute();
			$result = $stmt->get_result();

			while ($row = $result->fetch_assoc()) {
				unset($row['vars.pat_id']);
				unset($row['manejo_inicial.pat_id']);
				unset($row['pat_risk_factors.pat_id']);
				unset($row['pat_sip']);
				unset($row['pat_nhc']);
				unset($row['pat_index']);

				$data = array_values($row);
				fputcsv($file, $data);
			}

            fclose($file);
            $stmt->close();

            $response['success'] = true;
            $response['tempFile'] = $tempFile;
            $response['message'] = 'ColumnData es un array válido';
            $response['fileUrl'] = 'assets/inc/csv/' . $filename; // Agregar el nombre del archivo CSV a la respuesta JSON
            $response['filename'] = "hmisepsis-data_" . date('Y-m-d') . ".csv";

            // Guardaremos un registro de las descargas realizadas

            $query_historial = "INSERT INTO `historial_descargas`(`usuario`) VALUES (?)";
            $stmt_hist = $mysqli->prepare($query_historial);
            $rc = $stmt_hist->bind_param('s', $res_id);
            $stmt_hist->execute();
        } else {
            $response['success'] = true;
            $response['message'] = 'ColumnData NO es un array';
        }
    } else {
        $response['message'] = 'Datos faltantes para exportar res_id y columnData.';
    }
} else {
    $response['message'] = 'Datos faltantes para exportar formData.';
}

// Cerrar la sesión
session_write_close();

// Enviar la respuesta JSON
echo json_encode($response);
exit;
?>