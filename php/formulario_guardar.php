<?php
include ('conexion_be.php');

$nombre = mysqli_real_escape_string($enlace, $_POST['nombre'] ?? '');
$apellido = mysqli_real_escape_string($enlace, $_POST['apellido'] ?? '');
$cedula = mysqli_real_escape_string($enlace, $_POST['cedula'] ?? '');
$direccion = mysqli_real_escape_string($enlace, $_POST['direccion'] ?? '');
$m = $_POST['m'] ?? null;
$f = $_POST['f'] ?? null;
$p = $_POST['p'] ?? null;
$s = $_POST['s'] ?? null;
$g = mysqli_real_escape_string($enlace, $_POST['g'] ?? '');
$diagnostico = mysqli_real_escape_string($enlace, $_POST['diagnostico'] ?? '');
$tratamiento = mysqli_real_escape_string($enlace, $_POST['tratamiento'] ?? '');
$telefono = mysqli_real_escape_string($enlace, $_POST['telefono'] ?? '');
$fecha = mysqli_real_escape_string($enlace, $_POST['fecha'] ?? '');
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$m_val = isset($m) ? 'sí' : 'no';
$f_val = isset($f) ? 'sí' : 'no';
$p_val = isset($p) ? 'sí' : 'no';
$s_val = isset($s) ? 'sí' : 'no';

if ($id > 0) {
    $query = "UPDATE formulario SET nombre='$nombre', apellido='$apellido', cedula='$cedula', direccion='$direccion', m='$m_val', f='$f_val', p='$p_val', s='$s_val', g='$g', diagnostico='$diagnostico', tratamiento='$tratamiento', telefono='$telefono', fecha='$fecha' WHERE id='$id'";
} else {
    $query = "INSERT INTO formulario (nombre,apellido,cedula,direccion,m,f,p,s,g,diagnostico,tratamiento,telefono,fecha) VALUES ('$nombre', '$apellido', '$cedula', '$direccion', '$m_val', '$f_val', '$p_val', '$s_val', '$g', '$diagnostico', '$tratamiento', '$telefono', '$fecha')";
}

$ejecutar = mysqli_query($enlace, $query);
mysqli_close($enlace);

if ($ejecutar) {
    echo '<script> alert("REGISTRO EXITOSO"); window.location = "../formulario.php"; </script>';
} else {
    echo '<script> alert("ERROR AL REGISTRAR"); window.location = "../formulario.php"; </script>';
}

?>