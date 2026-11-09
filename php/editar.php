<?php
include 'conexion_be.php';

$id = mysqli_real_escape_string($enlace, $_POST['id']);
$nombre = mysqli_real_escape_string($enlace, $_POST['nombre'] ?? '');
$apellido = mysqli_real_escape_string($enlace, $_POST['apellido'] ?? '');
$cedula = mysqli_real_escape_string($enlace, $_POST['cedula'] ?? '');
$direccion = mysqli_real_escape_string($enlace, $_POST['direccion'] ?? '');
$m = isset($_POST['m']) ? 'sí' : 'no';
$f = isset($_POST['f']) ? 'sí' : 'no';
$p = isset($_POST['p']) ? 'sí' : 'no';
$s = isset($_POST['s']) ? 'sí' : 'no';
$g = isset($_POST['g']) ? 'sí' : 'no';
$diagnostico = mysqli_real_escape_string($enlace, $_POST['diagnostico'] ?? '');
$telefono = mysqli_real_escape_string($enlace, $_POST['telefono'] ?? '');
$fecha = mysqli_real_escape_string($enlace, $_POST['fecha'] ?? '');

$query = "UPDATE formulario SET nombre='$nombre', apellido='$apellido', cedula='$cedula', direccion='$direccion', m='$m', f='$f', p='$p', s='$s', g='$g', diagnostico='$diagnostico', telefono='$telefono', fecha='$fecha' WHERE id='$id'";

if (mysqli_query($enlace, $query)) {
    header('Location: buscador.php?status=ok');
} else {
    header('Location: buscador.php?status=error');
}
exit;
?>
