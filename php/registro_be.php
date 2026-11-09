<?php 

include 'conexion_be.php';
$nombre_completo = $_POST ['nombre_completo'];
$usuario = $_POST ['usuario'];
$correo = $_POST ['correo'];
$contrasena = $_POST ['contrasena'];
$contrasena = hash ('sha512', $contrasena);

$query = "INSERT INTO introducir (nombre_completo, usuario, correo, contrasena) 
VALUES('$nombre_completo', '$usuario', '$correo', '$contrasena')";

$verificar_correo = mysqli_query($enlace, "SELECT * FROM introducir WHERE correo='$correo'" );
$verificar_usuario = mysqli_query($enlace, "SELECT * FROM introducir WHERE usuario='$usuario'" );

if (mysqli_num_rows($verificar_correo) > 0){
    echo '
    <script> alert("CORREO YA EXISTENTE");
    window.location = "../login.php"; </script>
    ';
    
}
else {
    if (mysqli_num_rows($verificar_usuario) > 0){
    echo '
    <script> alert("USUARIO YA EXISTENTE");
    window.location = "../login.php"; </script>
    ';
}
else{
$ejecutar = mysqli_query($enlace,$query);

if ($ejecutar){
echo '
<script> alert("REGISTRO EXITOSO");
window.location = "../login.php";
</script>;
'

;

}
else {echo'
<script> alert("ERROR"); </script>
}
';}
}
}
mysqli_close($enlace);
?>