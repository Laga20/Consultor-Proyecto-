<?php
session_start();
if (!isset($_SESSION['usuario'])){
    header("location: login.php");
    exit;
}

// Verificar si es admin (id_rol = 1 o 3 para admin)
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1 and $_SESSION['id_rol'] != 3){
    echo '<script>alert("No tienes permisos para crear usuarios."); window.location = "formulario.php";</script>';
    exit;
}

include 'php/conexion_be.php';

// Obtener roles disponibles
$roles_query = mysqli_query($enlace, "SELECT id, descripcion FROM rol");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Crear Nuevo Usuario</title>
</head>
<body class="bg-light bg-info-subtle">
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand text-white">Crear Nuevo Usuario</span>
        <a href="formulario.php" class="btn btn-outline-light">Volver</a>
    </div>
</nav>

<div class="container py-5 shadow-sm">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Formulario de Nuevo Usuario</h5>
                    <form action="php/crear_usuario_be.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido</label>
                            <input type="text" class="form-control" name="apellido" placeholder="Ingresa el apellido" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" name="correo" placeholder="correo@ejemplo.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" placeholder="Ingresa una contraseña" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-select" name="id_rol" required>
                                <option value="">-- Selecciona un rol --</option>
                                <?php while ($rol = mysqli_fetch_assoc($roles_query)): ?>
                                    <option value="<?php echo $rol['id']; ?>"><?php echo htmlspecialchars($rol['descripcion']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Crear Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
