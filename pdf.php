<?php
session_start(); // Iniciar la sesión para acceder a $_SESSION['id_rol']
include_once "php/conexion_be.php";
require_once "pdf/dompdf/autoload.inc.php";
use Dompdf\Dompdf;

// Verificar si el usuario tiene el rol de Doctora (1) o Programador (3)
$is_doctor_or_programmer = (isset($_SESSION['id_rol']) && ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 3));

// Recibir parámetros GET
$cedula = isset($_GET['cedula']) && !empty(trim($_GET['cedula'])) ? mysqli_real_escape_string($enlace, trim($_GET['cedula'])) : null;
$fecha = isset($_GET['fecha']) && !empty(trim($_GET['fecha'])) ? mysqli_real_escape_string($enlace, trim($_GET['fecha'])) : null;

// Definir las columnas base que siempre se seleccionan y muestran
$select_columns_sql = [
    'nombre', 'apellido', 'cedula', 'telefono', 'direccion', 'm', 'f', 'p', 's', 'g', 'fecha'
];
$display_columns_html = [
    'nombre', 'apellido', 'cedula', 'telefono', 'direccion', 'm', 'f', 'p', 's', 'g'
];

// Añadir diagnóstico y tratamiento si el rol lo permite
if ($is_doctor_or_programmer) {
    $select_columns_sql[] = 'diagnostico';
    $select_columns_sql[] = 'tratamiento';
    $display_columns_html[] = 'diagnostico';
    $display_columns_html[] = 'tratamiento';
}

// Construir la parte SELECT de la consulta SQL
$query_select_part = implode(', ', $select_columns_sql);
$query = "SELECT $query_select_part FROM formulario WHERE 1=1";
if ($cedula) $query .= " AND cedula = '$cedula'";
if ($fecha) $query .= " AND DATE(fecha) = '$fecha'";
$query .= " ORDER BY fecha DESC";

// Ejecutar consulta
$res = mysqli_query($enlace, $query);
if (!$res) die("<h2>Error en la consulta SQL</h2><p>" . mysqli_error($enlace) . "</p>");

// Inicializar variables
$num_registros = mysqli_num_rows($res);
$nombre_paciente = '';

// Construir HTML
$html = '<html><head><meta charset="UTF-8"></head><body>';
$html .= '<h2>Reporte de Pacientes</h2>';
if ($cedula) $html .= '<p><strong>Cédula:</strong> ' . htmlspecialchars($cedula) . '</p>';
if ($fecha) $html .= '<p><strong>Fecha:</strong> ' . htmlspecialchars($fecha) . '</p>';
$html .= '<p><strong>Total:</strong> ' . $num_registros . '</p>';

if ($num_registros > 0) {
    $primer_fila = mysqli_fetch_assoc($res);
    $nombre_paciente = $primer_fila['nombre'] . '_' . $primer_fila['apellido'];
    mysqli_data_seek($res, 0); // Resetear el puntero del resultado para el bucle principal
    
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; font-size: 9px;">';
    $html .= '<tr>';
    foreach ($display_columns_html as $col) {
        $html .= '<th>' . ucfirst($col) . '</th>';
    }
    $html .= '<th>Fecha</th>'; // La fecha siempre se muestra
    $html .= '</tr>';
    
    while ($row = mysqli_fetch_assoc($res)) {
        $html .= '<tr>';
        foreach ($display_columns_html as $col) {
            $html .= '<td>' . htmlspecialchars($row[$col]) . '</td>';
        }
        $html .= '<td>' . htmlspecialchars(date('d-m-Y H:i', strtotime($row['fecha']))) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
} else {
    $html .= '<p style="color: red;"><strong>No se encontraron registros.</strong></p>';
}
$html .= '</body></html>';

// Generar PDF
$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper("A4", "landscape");
$pdf->render();

// Crear nombre del archivo con el nombre del paciente
$filename = 'reporte_' . (!empty($nombre_paciente) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $nombre_paciente) : 'paciente') . '.pdf';
$pdf->stream($filename, array("Attachment" => true));

mysqli_close($enlace);
?>