<?php

session_start();
session_destroy();
echo'
<script>alert("Sesión cerrada.");
window.location = "../login.php";</script>
';
//header("location: ../login.php");



?>