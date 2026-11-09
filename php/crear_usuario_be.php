<?php
session_start();
include 'conexion_be.php';

// Verificar que sea admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1 && $_SESSION['id_rol'] != 3){
    echo '<script>alert("No tienes permisos para crear usuarios."); window.location = "../login.php";</script>';
    exit;
}

// Recibir datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
$id_rol = isset($_POST['id_rol']) ? intval($_POST['id_rol']) : '';

// Validar campos
if (empty($nombre) || empty($apellido) || empty($correo) || empty($contrasena) || empty($id_rol)) {
    echo '<script>alert("Todos los campos son requeridos."); window.history.back();</script>';
    exit;
}

// Verificar si el correo ya existe
$verificar_correo = mysqli_query($enlace, "SELECT * FROM introducir WHERE correo = '$correo'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '<script>alert("El correo ya está registrado."); window.history.back();</script>';
    exit;
}

// Encriptar contraseña
$contrasena_encriptada = hash('sha512', $contrasena);

// Crear nombre de usuario basado en nombre y apellido
$usuario = strtolower($nombre . '.' . $apellido);

// Insertar nuevo usuario
$insertar = mysqli_query($enlace, "INSERT INTO introducir (nombre_completo, usuario, correo, contrasena, id_rol) 
                                     VALUES ('$nombre $apellido', '$usuario', '$correo', '$contrasena_encriptada', $id_rol)");

if ($insertar) {
    echo '<script>alert("Usuario creado exitosamente."); window.location = "../crear_usuario.php";</script>';
} else {
    echo '<script>alert("Error al crear el usuario: ' . mysqli_error($enlace) . '"); window.history.back();</script>';
}

mysqli_close($enlace);
?>