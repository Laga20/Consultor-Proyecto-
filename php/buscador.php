<?php
session_start();
if (!isset($_SESSION['usuario'])){
echo'
<script> alert("DEBES INICIAR SESIÓN.");
window.location = "../login.php";
</script>

';
//header("location: login.php");
session_destroy();
die();


}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Buscador</title>
</head>
<body class="bg-light bg-info-subtle">
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid justify-content-center">
        <form class="d-flex" role="search" method="POST" action="">
            <input class="form-control me-2" type="search" name="cedula" placeholder="Buscar cédula" aria-label="Buscar" required>
            <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="text-dark">Buscador de Reportes</h1>
    </div>

    <?php
    include 'conexion_be.php';
    
    $cedula_buscada = '';
   
    if (isset($_POST['eliminar'])){
        if ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 3) {
            $id = mysqli_real_escape_string($enlace, $_POST['id']);
            $delete_query = "DELETE FROM formulario WHERE id = '$id'";
            $delete_ejecutar = mysqli_query($enlace, $delete_query);
            if($delete_ejecutar){
                echo '<script> alert("REGISTRO ELIMINADO");
                window.location = "buscador.php";</script>';
            }
        }
    }

   

    if (isset($_POST['cedula'])) {
        $cedula = mysqli_real_escape_string($enlace, $_POST['cedula']);
        $cedula_buscada = $_POST['cedula'];  // Guardar para pre-cargar en el formulario
        $query = "SELECT * FROM formulario WHERE cedula = '$cedula'";
        $resultado = mysqli_query($enlace, $query);

 if ($resultado){ $cantidad = mysqli_num_rows($resultado);
    echo '<div class="alert alert-success text-center ">Hay ' . $cantidad . ' resultado(s)</div>';}

  
      

        if (mysqli_num_rows($resultado) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-bordered">';
            echo '<thead class="table-primary">';
            echo '<tr>';
        
            echo '<th>Nombre</th>';
            echo '<th>Apellido</th>';
            echo '<th>Cédula</th>';
            echo '<th>Teléfono</th>';
            echo '<th>Dirección</th>';
            echo '<th>M</th>';
            echo '<th>F</th>';
            echo '<th>P</th>';
            echo '<th>S</th>';
            echo '<th>G</th>';
            if ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 3) {
                echo '<th>Diagnóstico</th>';
                echo '<th>Tratamiento</th>';
            }
            echo '<th>Fecha</th>';
            if ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 3) {
                echo '<th>Acciones</th>';
            }
           
            echo '</tr>';
            
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($resultado))
                 {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
                echo '<td>' . htmlspecialchars($row['apellido']) . '</td>';
                echo '<td>' . htmlspecialchars($row['cedula']) . '</td>';
                echo '<td>' . htmlspecialchars($row['telefono']) . '</td>';
                echo '<td>' . htmlspecialchars($row['direccion']) . '</td>';
                echo '<td>' . htmlspecialchars($row['m']) . '</td>';
                echo '<td>' . htmlspecialchars($row['f']) . '</td>';
                echo '<td>' . htmlspecialchars($row['p']) . '</td>';
                echo '<td>' . htmlspecialchars($row['s']) . '</td>';
                echo '<td>' . htmlspecialchars($row['g']) . '</td>';
                if ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 3) {
                    echo '<td>' . htmlspecialchars($row['diagnostico']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['tratamiento']) . '</td>';
                }
                echo '<td>' . htmlspecialchars($row['fecha']) . '</td>';
                if ($_SESSION['id_rol'] == 1 || $_SESSION['id_rol'] == 3) {
                echo '<td><form method="GET" action="../formulario.php" class="d-inline">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <input type="submit" class="btn btn-sm btn-outline-secondary" value="Editar">
                </form>
                <form method="POST" action="" class="d-inline ms-1">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <input type="submit" class="btn btn-sm btn-outline-danger" name="eliminar" value="Eliminar">
                </form></td>';
                }
                echo '</tr>';
            }
            
            
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning" role="alert">No se encontraron resultados para la cédula: ' . htmlspecialchars($cedula) . '</div>';
        }


        
        mysqli_close($enlace);

    }
    ?>

    <div class="card mt-4 p-3 border-primary shadow-sm  bg-success bg-opacity-10">
        <h5 class="text-primary">Generar Reporte PDF</h5>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Cédula</label>
                <input type="text" id="filtro_cedula" class="form-control" placeholder="Ej: 12345678" value="<?php echo htmlspecialchars($cedula_buscada); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input type="date" id="filtro_fecha" class="form-control">
            </div>
            <div class="col-md-6 d-flex align-items-end gap-2">
                <button type="button" class="btn btn-primary w-100" onclick="descargarConFiltros()">Descargar con Filtros</button>
                <a href="../pdf.php" target="_blank" class="btn btn-success w-100 text-center">Descargar Todo</a>
            </div>
        </div>
        <div class="mt-2 text-muted">
            
        </div>
    </div>
    <br>
    <a href="../formulario.php" class="btn btn-outline-primary">volver</a><br>
    <a href="cerrar_sesion.php" class="btn btn-outline-danger">Cerrar sesión</a>
</div>
 
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
function descargarConFiltros() {
    const cedula = document.getElementById('filtro_cedula').value.trim();
    const fecha = document.getElementById('filtro_fecha').value.trim();
    
    // Validar que al menos uno tenga valor
    if (cedula === "" && fecha === "") {
        alert("Debes ingresar al menos Cédula o Fecha para descargar con filtros.");
        return;
    }
    
    // Construir URL
    let url = "../pdf.php?";
    const params = [];
    
    if (cedula !== "") {
        params.push("cedula=" + encodeURIComponent(cedula));
    }
    if (fecha !== "") {
        params.push("fecha=" + encodeURIComponent(fecha));
    }
    
    url += params.join("&");
    
    // Abrir en nueva ventana
    window.open(url, '_blank');
}
</script>
</body>
</html>
