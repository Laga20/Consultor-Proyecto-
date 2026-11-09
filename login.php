<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("location: formulario.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="min-vh-100 w-100" style="background-image: url('image/hd-medical-health-icon-with-nurse-v1txjiifhv3bssoo.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

    <div class="container ">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <!-- Card de Bootstrap con fondo de imagen y overlay celeste -->
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden" 
                     style="background-image: linear-gradient(rgba(224, 242, 254, 0.9), rgba(224, 242, 254, 0.9)), url('image/fondo_login.jpg'); background-size: cover; background-position: center;">
                    <div class="card-body p-5">
                        <h2 class="text-center text-primary fw-bold mb-4">INICIAR SESIÓN</h2>
                        <form action="php/login_be.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label text-primary fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg border-primary border-opacity-25 shadow-sm" placeholder="Correo@gmil.com" name="correo" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-primary fw-semibold">Contraseña</label>
                                <input type="password" class="form-control form-control-lg border-primary border-opacity-25 shadow-sm" placeholder="Contraseña" name="contrasena" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow fw-bold">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
