<?php
// Incluir el archivo de conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se ha pasado el parámetro ID
if (isset($_GET['id'])) {
    $idEntrega = intval($_GET['id']); // Asegurarse de que sea un entero
?>

    <!-- Mostrar la ventana emergente de confirmación -->
    <script>
        // Mostrar la ventana emergente de confirmación
        var confirmation = confirm('¿Estás seguro de que deseas eliminar este registro de entrega?');

        // Si el usuario confirma
        if (confirmation) {
            // Redirigir para realizar la eliminación en el archivo PHP
            window.location.href = 'eliminar_entrega.php?id=<?php echo $idEntrega; ?>';
        } else {
            // Si el usuario cancela, redirigimos a la página de entregas
            window.location.href = '../ENTREGA/ENTREGA.PHP';
        }
    </script>

<?php
} else {
    echo "<script>alert('No se ha proporcionado un ID válido');</script>";
    echo "<script>window.location.href = '../ENTREGA/LISTADO_ENTREGA.PHP';</script>";
}
?>
