<?php
session_start();
if (!isset($_SESSION['usuario'])){
echo'
<script> alert("DEBES INICIAR SESIÓN.");
window.location = "login.php";
</script>

';
//header("location: login.php");
session_destroy();
die();

}
include 'php/conexion_be.php';
$usuario = $_SESSION['usuario'];
$consulta = mysqli_query($enlace, "SELECT * FROM introducir WHERE   correo='$usuario' OR usuario = '$usuario' ");
$usuario_db = mysqli_fetch_array($consulta);

date_default_timezone_set('America/Caracas');
$fecha_actual = date('Y-m-d H:i:s');

    $datos_paciente = null;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_buscar = intval($_GET['id']);
        $query = "SELECT * FROM formulario WHERE id = '$id_buscar' LIMIT 1";
        $resultado = mysqli_query($enlace, $query);
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $datos_paciente = mysqli_fetch_array($resultado);
        }
    } elseif (isset($_POST['buscar_cedula'])) {
       
        $cedula_buscar = mysqli_real_escape_string($enlace, $_POST['cedula']);
    
        $query = "SELECT * FROM formulario WHERE cedula = '$cedula_buscar' ORDER BY id DESC LIMIT 1";
        $resultado = mysqli_query($enlace, $query);
      
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $datos_paciente = mysqli_fetch_array($resultado);
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>Registro</title>
</head>
<body class="bg-light bg-info-subtle">

<!-- Barra Superior Derecha -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1000;">
    <div class="d-flex gap-2">
        
        <?php if ($usuario_db['id_rol'] == 1): ?>
            <a href="crear_usuario.php" class="btn btn-success">Crear Usuario</a>
        <?php endif; ?>
        <?php if ($usuario_db['id_rol'] == 3): ?>
            <a href="crear_usuario.php" class="btn btn-success">Crear Usuario</a>
        <?php endif; ?>
    </div>
</div>

<div>
    <?php  
    if ($usuario_db['id_rol'] == '1') {
        echo '<p class="text-primary ">Cargo: Doctora.</p>';
    }
    else if ($usuario_db['id_rol'] == '2') {
        echo '<p class="text-primary ">Cargo: Recepcionista.</p>';
    }
    else if ($usuario_db['id_rol'] == '3') {
        echo '<p class="text-primary ">Cargo: Programador.</p>';
    }
    else {
        // Si no tiene rol, cerramos sesión por seguridad
        session_destroy();
        echo '
        <script>alert("No tiene rol asignado.");
        window.location = "login.php";</script>
        ';
        exit;
    }
    ?>
</div>


<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="text-dark">Registro Pacientes</h1>
    </div>
    <?php if (isset($_POST['cedula']) && !$datos_paciente): ?>
        <div class="alert alert-warning text-center">No se encontró ningún registro previo para esta cédula.</div>
    <?php endif; ?>

<form class="row g-3 card border-primary bg-primary bg-opacity-10 shadow-sm p-8" action="php/formulario_guardar.php" method="POST">
        <?php if ($datos_paciente): ?>
            <input type="hidden" name="id" value="<?php echo $datos_paciente['id']; ?>">
        <?php endif; ?>
        <div class="d-flex justify-content-end">
<a href="php/buscador.php" class="btn btn-primary" role="button">Pacientes registrados</a>
    </div>
    <div class="col-3">
        <label class="form-label text-primary" for="cedula">Cédula</label>
        <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['cedula']) : (isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : ''); ?>" required>
        <button class="btn btn-outline-success mt-2" type="submit" name="buscar_cedula" formaction="formulario.php" formnovalidate>Buscar</button>
    </div>

    <div class="col-3">
        <label class="form-label text-primary" for="nombre">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['nombre']) : ''; ?>" required>
    </div>

    <div class="col-3">
        <label class="form-label text-primary" for="apellido">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['apellido']) : ''; ?>" required>
    </div>

    <div class="col-6">
        <label class="form-label text-primary" for="telefono">Teléfono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['telefono']) : ''; ?>" required>
    </div>
<div class= "col-12">
    <label class="form-label text-primary" for="direccion">Dirección</label>
    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['direccion']) : ''; ?>">
</div>

<div class="col-2 form-check">
    <input class="form-check-input" type="checkbox" id="m" name="m" value="m" <?php echo ($datos_paciente && $datos_paciente['m'] == 'sí') ? 'checked' : ''; ?>>
    <label class="form-check-label text-primary" for="m">M (Masculino)</label>
</div>

<div class="col-2 form-check">
    <input class="form-check-input" type="checkbox" id="f" name="f" value="f" <?php echo ($datos_paciente && $datos_paciente['f'] == 'sí') ? 'checked' : ''; ?>>
    <label class="form-check-label text-primary" for="f">F  (Femenino)</label>
</div>

<div class="col-2 form-check">
    <input class="form-check-input" type="checkbox" id="p" name="p" value="p" <?php echo $datos_paciente && $datos_paciente['p'] == 'sí' ? 'checked' : (!$datos_paciente ? 'checked' : ''); ?> >
    <label class="form-check-label text-primary" for="p">P (Primera vez)</label>
</div>

<div class="col-2 form-check">
    <input class="form-check-input" type="checkbox" id="s" name="s" value="s" <?php echo $datos_paciente && $datos_paciente['s'] == 'sí' ? 'checked' : ''; ?>>
    <label class="form-check-label text-primary" for="s">S (Sucesivo)</label>
</div>

<div class="col-2"> 
    <label class="form-check-label text-primary" for="g">G (Gremio)</label>
    <select name="g" id="opciones" class="form-select"required>

        <option disabled selected>Seleccionar</option>
        <option <?php echo ($datos_paciente && $datos_paciente['g'] == 'Administrativo') ? 'selected' : ''; ?>>Administrativo</option>
        <option <?php echo ($datos_paciente && $datos_paciente['g'] == 'Estudiante') ? 'selected' : ''; ?>>Estudiante</option>
        <option <?php echo ($datos_paciente && $datos_paciente['g'] == 'Docente') ? 'selected' : ''; ?>>Docente</option>
        <option <?php echo ($datos_paciente && $datos_paciente['g'] == 'Obrero') ? 'selected' : ''; ?>>Obrero</option>
    </select>
    
</div>

 <?php if ($usuario_db['id_rol'] == 1 || $usuario_db['id_rol'] == 3): ?>

    <div class= "col-12">
    <label class="form-label text-primary" for="diagnostico">Diagnóstico</label>
    <input type="text" class="form-control" id="diagnostico" name="diagnostico" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['diagnostico']) : ''; ?>" required>
</div>
<div class= "col-12 ">
    <label class="form-label text-primary" for="tratamiento">Tratamiento</label>
    <input type="text" class="form-control" id="tratamiento" name="tratamiento" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['tratamiento']) : ''; ?>" required>
</div>

            
        <?php endif; ?>


<div class="">
    <label class="form-label text-primary" for="fecha">Fecha y hora</label>
    <input type="datetime" name="fecha" value="<?php echo $datos_paciente ? htmlspecialchars($datos_paciente['fecha']) : $fecha_actual; ?>" required>
</div>
<div class="col-12 d-flex gap-3">
    <button type="submit" class="btn btn-primary">Registrar</button>
   
    <a href="php/cerrar_sesion.php" class="btn btn-outline-danger">Cerrar sesión</a>
</div>

    </form>
</div>
<div class="text-success justify-content-end d-flex"> V1.2.1</div>

<script src="./js/bootstrap.bundle.min.js"></script>
    
</body>
</html>