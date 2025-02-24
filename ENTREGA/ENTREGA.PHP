<?php
// Incluir la conexión a la base de datos
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verificar si la conexión se ha establecido correctamente
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se envió el formulario para insertar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEntrega = mysqli_real_escape_string($conexion, $_POST['ID_Entrega']);
    $fechaEntrega = mysqli_real_escape_string($conexion, $_POST['Fecha_de_entrega']);
    $departamento = mysqli_real_escape_string($conexion, $_POST['Departamento']);
    $nombreCliente = mysqli_real_escape_string($conexion, $_POST['Nombre_del_cliente']);
    $cedulaCliente = mysqli_real_escape_string($conexion, $_POST['Cedula_del_cliente']);
    $correo = mysqli_real_escape_string($conexion, $_POST['Correo']);
    $estado = mysqli_real_escape_string($conexion, $_POST['Estado']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['Direccion_de_la_entrega']);
    $modoEntrega = mysqli_real_escape_string($conexion, $_POST['ID_Modo_entrega']);
    $domiciliario = mysqli_real_escape_string($conexion, $_POST['ID_Domiciliario']);

    // Insertar en la tabla entrega si no existe
    $verificarEntrega = "SELECT * FROM entrega WHERE ID_Entrega = '$idEntrega'";
    $resultadoVerificacion = mysqli_query($conexion, $verificarEntrega);

    if (mysqli_num_rows($resultadoVerificacion) === 0) {
        $insertarEntrega = "INSERT INTO entrega (ID_Entrega, Fecha_de_entrega, Departamento, Nombre_del_cliente, Cedula_del_cliente, Correo, Estado, Direccion_de_la_entrega, ID_Modo_entrega, ID_Domiciliario) 
                            VALUES ('$idEntrega', '$fechaEntrega', '$departamento', '$nombreCliente', '$cedulaCliente', '$correo', '$estado', '$direccion', '$modoEntrega', '$domiciliario')";
        mysqli_query($conexion, $insertarEntrega);
    }
}

// Obtener el término de búsqueda desde el formulario (si existe)
$searchTerm = isset($_GET['TXTBUSCAR']) ? mysqli_real_escape_string($conexion, $_GET['TXTBUSCAR']) : '';

// Contar los registros en la tabla entrega con búsqueda opcional
$countQuery = "SELECT COUNT(*) AS TOTAL FROM entrega";
if ($searchTerm) {
    $countQuery .= " WHERE Nombre_del_cliente LIKE '%$searchTerm%' 
                     OR Cedula_del_cliente LIKE '%$searchTerm%' 
                     OR Departamento LIKE '%$searchTerm%' 
                     OR Estado LIKE '%$searchTerm%'";
}
$SQL_REGISTROS = mysqli_query($conexion, $countQuery);
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

// Configurar paginación
$POR_PAGINA = 5;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

// Consulta para obtener los datos de la tabla entrega
$CONSULTA = "SELECT * FROM entrega";
if ($searchTerm) {
    $CONSULTA .= " WHERE Nombre_del_cliente LIKE '%$searchTerm%' 
                   OR Cedula_del_cliente LIKE '%$searchTerm%' 
                   OR Departamento LIKE '%$searchTerm%' 
                   OR Estado LIKE '%$searchTerm%'";
}
$CONSULTA .= " LIMIT $DESDE, $POR_PAGINA";
$EJECUTAR = mysqli_query($conexion, $CONSULTA);

// Consultar las descripciones de los modos de entrega
$modoEntregaQuery = "SELECT ID_Modo_entrega, Descripcion FROM modo_entrega";
$modoEntregaResult = mysqli_query($conexion, $modoEntregaQuery);

// Consultar los nombres de los domiciliarios
$domiciliariosQuery = "SELECT ID_Domiciliario, Nombre FROM domiciliario";
$domiciliariosResult = mysqli_query($conexion, $domiciliariosQuery);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entregas</title>
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
    <link href="../estilos_importattt.css" rel="stylesheet">

    <script>
        function confirmarEliminacion(idEntrega) {
            if (confirm("¿Estás seguro de que deseas eliminar esta entrega?")) {
                window.location.href = "eliminar_entrega.php?ID_Entrega=" + idEntrega;
            }
        }
    </script>
</head>
<body>
<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>


<!-- Título con línea debajo -->
<div class="title-container">
    <h1>LISTA DE ENTREGAS</h1>
    <hr>
</div>
<br>

<!-- Barra de búsqueda -->
<div class="search-bar-container">
    <form method="get" action="" class="search-form">
        <input type="search" name="TXTBUSCAR" placeholder="Buscar por cliente, cédula, departamento o estado..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <input type="submit" class="search-btn" value="Consultar">
    </form>
    <a class="add-personnel-btn" href="../ENTREGA/INSERTAR_PEDIDO.PHP">AGREGAR PEDIDO</a>
</div>

<!-- Tabla para mostrar los resultados -->
<table class="styled-table">
    <thead>
        <tr>
            <th>Nombre del Cliente</th>
            <th>Cédula del Cliente</th>
            <th>Correo</th>
            <th>Departamento</th>
            <th>Estado</th>
            <th>Fecha de Entrega</th>
            <th>Dirección de la Entrega</th>
            <th>Modo de Entrega</th>
            <th>Domiciliario</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($FILA = mysqli_fetch_assoc($EJECUTAR)) { 
            // Obtener el modo de entrega y el domiciliario por sus IDs
            $modoEntregaDesc = '';
            $domiciliarioNombre = '';

            // Obtener el nombre del modo de entrega
            mysqli_data_seek($modoEntregaResult, 0);  // Resetear el resultado de la consulta
            while ($modo = mysqli_fetch_assoc($modoEntregaResult)) {
                if ($FILA['ID_Modo_entrega'] == $modo['ID_Modo_entrega']) {
                    $modoEntregaDesc = $modo['Descripcion'];
                    break;
                }
            }

            // Obtener el nombre del domiciliario
            mysqli_data_seek($domiciliariosResult, 0); // Resetear el resultado de la consulta
            while ($domiciliario = mysqli_fetch_assoc($domiciliariosResult)) {
                if ($FILA['ID_Domiciliario'] == $domiciliario['ID_Domiciliario']) {
                    $domiciliarioNombre = $domiciliario['Nombre'];
                    break;
                }
            }
        ?>
        <tr>
            <td><?php echo $FILA['Nombre_del_cliente']; ?></td>
            <td><?php echo $FILA['Cedula_del_cliente']; ?></td>
            <td><?php echo $FILA['Correo']; ?></td>
            <td><?php echo $FILA['Departamento']; ?></td>
            <td><?php echo $FILA['Estado']; ?></td>
            <td><?php echo $FILA['Fecha_de_entrega']; ?></td>
            <td><?php echo $FILA['Direccion_de_la_entrega']; ?></td>
            <td><?php echo $modoEntregaDesc; ?></td>
            <td><?php echo $domiciliarioNombre; ?></td>
            <td>
                <a href="../ENTREGA/ACTUALIZAR_ENTREGA.PHP?id=<?php echo  $FILA['ID_Entrega']; ?>">
                    <img src="../IMAGENES/actualizar.png" alt="Actualizar" style="width: 40px; height: 40px;">
                </a>
            </td>
            <td>
            <a href="../ENTREGA/ELIMINAR_ENTREGA.PHP?id=<?php echo  $FILA['ID_Entrega']; ?>">
                    <img src="../IMAGENES/eliminar.png" alt="Actualizar" style="width: 40px; height: 40px;">
                </a>
              
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Paginación -->
<div class="pagination">
    <?php for ($i = 1; $i <= $TOTAL_PAGINAS; $i++) { ?>
        <a href="?PAGINA=<?php echo $i; ?>&TXTBUSCAR=<?php echo urlencode($searchTerm); ?>" class="<?php echo $i == $PAGINA ? 'active' : 'page-link'; ?>"><?php echo $i; ?></a>
    <?php } ?>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
