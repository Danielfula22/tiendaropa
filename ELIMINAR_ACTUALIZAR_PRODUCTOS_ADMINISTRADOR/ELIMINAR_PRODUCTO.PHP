<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar que la conexión sea exitosa
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se ha pasado el parámetro ID
if (isset($_GET['ID'])) {
    $idAccesorio = intval($_GET['ID']); // Asegurarse de que sea un entero

    // Preparar la consulta de eliminación
    $queryEliminar = "DELETE FROM accesorio WHERE ID_Accesorio = $idAccesorio";
    $resultadoEliminar = mysqli_query($conexion, $queryEliminar);

    // Verificar si la eliminación fue exitosa
    if ($resultadoEliminar) {
        echo "<script>alert('Accesorio eliminado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar el accesorio');</script>";
    }

    // Redirigir de vuelta a la página anterior automáticamente
    echo "<script>window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
} else {
    echo "<script>alert('No se ha proporcionado un ID válido');</script>";
    echo "<script>window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
}
?>
