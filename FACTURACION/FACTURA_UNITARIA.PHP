<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FACTURACION</title>
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/texto.css">
    <link rel="stylesheet" href="../CSS/tabla_servicio.css">
    <link rel="stylesheet" href="../CSS/estilo.css">
</head>
<body>
<?php INCLUDE ('../CONEXION/conexion.php'); ?>
<?php INCLUDE ('../Template/civil.php'); ?>
<form method="POST" action="FINALIZARFACTURA.PHP" >
    <table class="styled-table">
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>FECHA DEL PAGO</th>
                <th>CIVIL</th>
                <th>ESTADO</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta = "SELECT libretas.ID_LIBRETA, libretas.FECHA_PAGO, libretas.ID_Soldados, libretas.ESTADO_LIBRETA, persona.Nombre, persona.Apellido 
                         FROM libretas 
                         JOIN persona ON libretas.ID_Soldados = persona.ID_Soldados 
                         WHERE persona.rol = 4 
                         ORDER BY libretas.ID_LIBRETA DESC";
            $ejecutar = mysqli_query($conexion, $consulta);
            while ($Fila = mysqli_fetch_assoc($ejecutar)) {
                $IDLIBRE = $Fila['ID_LIBRETA'];
                $FECHAPA = $Fila['FECHA_PAGO'];
                $SOLDA = $Fila['ID_Soldados'];
                $ESTA = $Fila['ESTADO_LIBRETA'];
                $NOMBRE = $Fila['Nombre'];
                $APELLIDO = $Fila['Apellido'];
                // Determinar el estado de la libreta
                $estado_libreta = ($ESTA == 1) ? 'Activo' : 'Anulado';
            ?>
            <tr>
                <td><?php echo $IDLIBRE; ?></td>
                <td><?php echo $FECHAPA; ?></td>
                <td><?php echo $NOMBRE . " " . $APELLIDO; ?></td>
                <td><?php echo $estado_libreta; ?></td>
                <td>
                    <a onClick="javascript: return confirm('¿Estás seguro de anular?');" href="../FACTURACION/FINALIZARFACTURA.PHP?anular=<?php echo $IDLIBRE;?>">ANULAR</a>&nbsp;&nbsp;&nbsp;
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
            echo "<script> window.open('FINALIZARFACTURA.PHP','_self') </script>";
        }
    }
    ?>
</form>
<?php INCLUDE ('../TEMPLATE/FOOTER.PHP'); ?>
</body>
</html>