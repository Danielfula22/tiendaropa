<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FACTURACION</title>
    <link rel="stylesheet" href="../CSS/estilo.css">
    <link rel="stylesheet" href="../CSS/tabla_servicio.css">
</head>
<body>
<?php INCLUDE ('../CONEXION/conexion.php'); ?>
<?php INCLUDE ('../Template/libreta_civil.php'); ?>

<form method="POST" action="FINALIZARFACTURA.2.PHP" enctype="multipart/form-data">
    <table class="styled-table">
        <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>FECHA DEL PAGO</th>
                <th>SOLDADO</th>
                <th>ESTADO</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Consulta para seleccionar solo los roles 4
        $consulta = "
            SELECT libretas.*, persona.Nombre, persona.Apellido 
            FROM libretas
            JOIN persona ON libretas.ID_Soldados = persona.ID_Soldados
            WHERE persona.rol = 4
            ORDER BY libretas.ID_LIBRETA DESC";
        $ejecutar = mysqli_query($conexion, $consulta);

        // Iterar sobre los resultados
        while ($Fila = mysqli_fetch_assoc($ejecutar)) {
            $IDLIBRE = $Fila['ID_LIBRETA'];
            $FECHAPA = $Fila['FECHA_PAGO'];
            $SOLDA = $Fila['ID_Soldados'];
            $ESTA = $Fila['ESTADO_LIBRETA'];

            // Determinar el estado de la libreta
            $estado_libreta = ($ESTA == 1) ? 'Activo' : 'Anulado';
        ?>
        <tr>
            <td><?php echo $IDLIBRE; ?></td>
            <td><?php echo $FECHAPA; ?></td>
            <td><?php echo $Fila['Nombre'] . " " . $Fila['Apellido']; ?></td>  
            <td><?php echo $estado_libreta; ?></td>
            <td>
                <a onClick="javascript: return confirm('¿Estas seguro de anular?');" href="finalizarfactura.php?anular=<?php echo $IDLIBRE;?>">ANULAR</a>&nbsp;&nbsp;&nbsp;
                <a href="pdf.php?factura=<?php echo $IDLIBRE;?>&persona=<?php echo $SOLDA;?>&anularr=<?php echo $ESTA;?>">PDF</a>
            </td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['anular'])) {
        $borrar_id = $_GET['anular'];
        $eliminar = "UPDATE libretas SET ESTADO_LIBRETA=2 WHERE ID_LIBRETA='$borrar_id'";
        $ejecutar = mysqli_query($conexion, $eliminar);

        if ($ejecutar) {
            echo "<script> alert('Factura Anulada') </script>";
            echo "<script> window.open('../FACTURACION/FINALIZARFACTURA.2.PHP','_self') </script>";
        }
    }
    ?>
</form>
<?php INCLUDE ('../TEMPLATE/FOOTER.PHP'); ?>
</body>
</html>
