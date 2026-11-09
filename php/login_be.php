<?php
session_start();
    include 'conexion_be.php';

    $correo = $_POST ['correo'];
    $contrasena = $_POST ['contrasena'];
    $contrasena = hash ('sha512', $contrasena);

    $validar_login = mysqli_query($enlace, "SELECT * FROM introducir WHERE correo='$correo' AND contrasena = '$contrasena'");

    if (mysqli_num_rows($validar_login) > 0){
        $usuario = mysqli_fetch_assoc($validar_login);
        $_SESSION['usuario']= $correo;
        $_SESSION['nombre'] = $usuario['nombre_completo'];
        $_SESSION['id_rol'] = $usuario['id_rol'];
        header("location: ../formulario.php");
          exit;
        
        }
        else{
        echo '
        <script> alert("Usuario o contraseña errado.");
        window.location= "../login.php";
         </script>
        ';
exit;

        }




?>