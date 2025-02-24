<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se recibió el parámetro ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idTipoPrenda = intval($_GET['id']); // Convertir el ID a un número entero

    // Consulta SQL para eliminar el tipo de prenda
    $queryEliminar = "DELETE FROM tipo_prenda WHERE ID_Tipo_prenda = ?";
    
    // Preparar la consulta para prevenir inyecciones SQL
    if ($stmt = mysqli_prepare($conexion, $queryEliminar)) {
        // Enlazar el parámetro
        mysqli_stmt_bind_param($stmt, "i", $idTipoPrenda);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('El tipo de prenda ha sido eliminado exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al intentar eliminar el tipo de prenda.');</script>";
        }

        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error al preparar la consulta.');</script>";
    }

    // Redirigir al listado de tipos de prendas
    echo "<script>window.location.href = '../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/PRODUCTOS.PHP';</script>";
} else {
    // Si no se recibe un ID válido
    echo "<script>alert('ID inválido o no proporcionado.');</script>";
    echo "<script>window.location.href = '../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/INSER_TIPO_PRENDA.PHP';</script>";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
