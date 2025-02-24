<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>+LIBRETA</title>
    <link rel="stylesheet" href="../CSS/formulario_estilo.css">
    <link rel="stylesheet" href="../CSS/actu.css">

</head>
<body>
    <?php INCLUDE ('../CONEXION/conexion.php'); ?>
    <?php INCLUDE ('../Template/header.administrador.php'); ?>

    <center>
        <h2> LIBRETA MILITAR </h2>
        <br><br>

        <?php
            if (isset($_GET['FACTURA'])) {
                $id_generarfactura = $_GET['FACTURA'];
                // Consultar los datos de la persona basada en la ID obtenida
                $consultagenfac = "SELECT * FROM persona WHERE ID_Soldados='$id_generarfactura'";
                $executegenfac = mysqli_query($conexion, $consultagenfac);

                if (!$executegenfac) {
                    die('Error en la consulta: ' . mysqli_error($conexion));
                }

                $Fila = mysqli_fetch_assoc($executegenfac);

                // Recuperar la información de la persona, con verificación
                $IDP = isset($Fila['ID_Soldados']) ? $Fila['ID_Soldados'] : '';
                $NOM = isset($Fila['Nombre']) ? $Fila['Nombre'] : '';
                $APE = isset($Fila['Apellido']) ? $Fila['Apellido'] : '';
                $NDOC = isset($Fila['N_Doc']) ? $Fila['N_Doc'] : '';
                $SANG = isset($Fila['Tipo_Sangre']) ? $Fila['Tipo_Sangre'] : '';
                $RAN = isset($Fila['Rango']) ? $Fila['Rango'] : '';
                $CONTA = isset($Fila['Contacto']) ? $Fila['Contacto'] : '';
                $FECHAINI = isset($Fila['Fecha_Inicio']) ? $Fila['Fecha_Inicio'] : '';
                $FECHAFIN = isset($Fila['Fecha_Fin']) ? $Fila['Fecha_Fin'] : '';
            }
        ?>

        <form name="UPDATE" method="POST" action="" enctype="multipart/form-data" class="formulario">
            <input type="hidden" value="<?php echo $IDP;?>" name="TXTID" disabled> 
            <p> NOMBRE: 
            <input type="text" value="<?php echo $NOM;?>" name="TZTNOMBRE" disabled class="form-control">       
            <p> APELLIDO: 
            <input type="text" value="<?php echo $APE;?>" name="TXTAPELLIDO" disabled class="form-control"> 
            <p> NUMERO DOCUMENTO:
            <input type="text" value="<?php echo $NDOC;?>" name="TXTNUMERO_DOC" disabled class="form-control">
            <p> RH:
            <input type="text" value="<?php echo $SANG;?>" name="TXTRH" disabled class="form-control">
            <p> RANGO: 
            <input type="text" value="<?php echo $RAN;?>" name="TXTRANGO" disabled class="form-control"> 
            <p> CONTACTO: 
            <input type="text" value="<?php echo $CONTA;?>" name="TXTCONTACTO" disabled class="form-control"> 
            <p> FECHA INICIO: 
            <input type="text" value="<?php echo $FECHAINI;?>" name="TXTFECHA_INI" disabled class="form-control"> 
            <p> FECHA FIN:
            <input type="text" value="<?php echo $FECHAFIN;?>" name="TXTFECHA_FIN" disabled class="form-control"> 
            <p> FECHA EXPEDICION: 
            <input type="date" name="txtfecha" required class="form-control">
            
            <div class="modal-footer">
                <input type="submit" name="INSERTARP" value="Insertar Datos" class="btn btn-primary">                                        
            </div>

            <?php
                if (isset($_POST['INSERTARP'])) {
                    // Obtener los datos del formulario
                    $fecha_pago = $_POST['txtfecha'];  // Fecha de pago

                    // Asignar un valor por defecto para TOTAL_LIBRETA y ESTADO_LIBRETA
                    $total_libreta = 0;  // Suponemos que el total se inicializa en 0
                    $estado_libreta = 1;  // Estado activo, suponiendo que 1 es activo

                    // Consulta de inserción en la tabla libretas
                    $sql = "INSERT INTO libretas (FECHA_PAGO, ID_Soldados, Precio, ESTADO_LIBRETA) 
                            VALUES ('$fecha_pago', '$id_generarfactura', $total_libreta, $estado_libreta)";

                    // Ejecutar la consulta y manejar errores
                    $result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));

                    // Obtener el ID de la última inserción
                    $IDP = mysqli_insert_id($conexion);

                    // Mensaje de confirmación y redirección
                    echo "<script>alert('Datos insertados correctamente en libretas')</script>";
                    echo "<script> window.open('../FACTURACION/FINALIZARFACTURA.PHP', '_self') </script>";
                }
            ?>
        </form>
    </center>

    <?php INCLUDE ('../Template/footer.php'); ?>
</body>
</html>
