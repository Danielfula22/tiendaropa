<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

// Verificar si la tabla 'pedido' existe y crearla si no existe
$checkTableQuery = "SHOW TABLES LIKE 'pedido'";
$tableExists = mysqli_query($conexion, $checkTableQuery);

if (mysqli_num_rows($tableExists) == 0) {
    // Crear la tabla si no existe
    $createTableSQL = "
        CREATE TABLE pedido (
            ID_Pedido INT AUTO_INCREMENT PRIMARY KEY,
            Nombre_del_cliente VARCHAR(20) NOT NULL,
            Cedula_del_cliente INT NOT NULL,
            Fecha DATE NOT NULL,
            ID_Entrega INT,
            FOREIGN KEY (ID_Entrega) REFERENCES modo_entrega(ID_Entrega)
        );
    ";
    if (!mysqli_query($conexion, $createTableSQL)) {
        die("Error al crear la tabla 'pedido': " . mysqli_error($conexion));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = mysqli_real_escape_string($conexion, $_POST['nombre_cliente']);
    $cedula_cliente = mysqli_real_escape_string($conexion, $_POST['cedula_cliente']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $id_entrega = mysqli_real_escape_string($conexion, $_POST['id_entrega']);
    $direccion_entrega = mysqli_real_escape_string($conexion, $_POST['direccion_entrega']);
    $departamento = mysqli_real_escape_string($conexion, $_POST['departamento']);
    $estado = mysqli_real_escape_string($conexion, $_POST['estado']);

    // Insertar datos en la tabla 'pedido'
    $SQL = "INSERT INTO pedido (Nombre_del_cliente, Cedula_del_cliente, Fecha, ID_Entrega) 
            VALUES ('$nombre_cliente', '$cedula_cliente', '$fecha', '$id_entrega')";
    $RESULT = mysqli_query($conexion, $SQL);

    // Insertar datos en la tabla 'entrega'
    $SQL_ENTREGA = "INSERT INTO entrega (Direccion_de_la_entrega, Fecha_de_entrega, Departamento, Nombre_del_cliente, Cedula_del_cliente, Estado, ID_Entrega) 
                    VALUES ('$direccion_entrega', '$fecha', '$departamento', '$nombre_cliente', '$cedula_cliente', '$estado', '$id_entrega')";
    $RESULT_ENTREGA = mysqli_query($conexion, $SQL_ENTREGA);

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT && $RESULT_ENTREGA) {
        echo "<script>alert('Pedido y entrega registrados exitosamente'); window.location.href='../PEDIDOS/PEDIDOS.PHP';</script>";
        exit();
    } else {
        die("Error al registrar el pedido o la entrega: " . mysqli_error($conexion));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pedido</title>
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>

<div class="form-container">
    <form name="insert_pedido" action="" method="POST">
        <h2> Insertar Nuevo Pedido </h2>

        <div class="form-group">
            <label for="nombre_cliente">Nombre del Cliente:</label>
            <input type="text" name="nombre_cliente" required>
        </div>

        <div class="form-group">
            <label for="cedula_cliente">Cédula del Cliente:</label>
            <input type="number" name="cedula_cliente" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required>
        </div>

        <div class="form-group">
            <label for="direccion_entrega">Dirección de la Entrega:</label>
            <input type="text" name="direccion_entrega" required>
        </div>

        <div class="form-group">
            <label for="departamento">Departamento:</label>
            <input type="text" name="departamento" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado de Entrega:</label>
            <input type="text" name="estado" required>
        </div>

        <div class="form-group">
            <label for="id_entrega">ID Entrega:</label>
            <input type="number" name="id_entrega" required>
        </div>

        <div class="form-group">
            <input type="submit" name="ENVIAR" value="Guardar" class="btn-submit">
        </div>
    </form>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>

<?php
ob_end_flush(); // Cierra el buffer de salida
?>
