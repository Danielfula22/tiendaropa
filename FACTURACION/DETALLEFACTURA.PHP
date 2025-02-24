<!doctype html>
  <html lang="en">
    <head>
    <!-- Required meta tags -->
      <meta charset="utf-8">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">∫
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title> FACTURACION DETALLE FACTURA </title>
    </head>

<BODY>
    <?php INCLUDE ('../CONEXION/CONEXION.PHP');?>
    <?php INCLUDE ('../TEMPLATE/HEADER.PHP'); ?>
    <?php INCLUDE ('../TEMPLATE/CONTENIDO.PHP');?>

    <H2> FACTURACIÓN - DETALLE FACTURA</H2>

    <form method="POST" action="">
    <BR>           
    <p>TRATAMIENTO:
    <select name="selecttratamiento">
    <?php
        $consulta = "SELECT * FROM TRATAMIENTO";
        $ejecutar = mysqli_query($conexion, $consulta);
            while ($res = mysqli_fetch_assoc($ejecutar)) {
                echo "<option value = '" . $res['IDTRATAMIENTO'] . "'>" . $res['NOMBRE'] . "</option>";
            }
    ?>
    </select>
   
    <BR><P>CANTIDAD: 
    <input type="TEXT" NAME="TXTCANTIDAD"> <BR><BR>
    <input type="submit"  name="txtinserttra" value="Agregar Tratamiento">
     
    <?php
        if (isset($_POST['txtinserttra'])) {
            $IDTRATAMIENTO = $_POST['selecttratamiento'];
            $Sql = "SELECT * FROM TRATAMIENTO WHERE IDTRATAMIENTO=" . $IDTRATAMIENTO;
            $EJECUTAR = mysqli_query($conexion, $Sql);
            $TRATAMIENTO = mysqli_fetch_assoc($EJECUTAR);
            $PRECIO = $TRATAMIENTO['VALOR'];
            
            $CANTIDAD = $_POST['TXTCANTIDAD'];
        
             $IDTRATAMIENTO = $TRATAMIENTO['IDTRATAMIENTO'];
             $TOTAL = $PRECIO * $CANTIDAD;
             

            $SELECCIONARTFACTURA = "SELECT MAX(IDFACTURA) as 'IDFACTURA' FROM FACTURA";
            $EJECUTAR = mysqli_query($conexion, $SELECCIONARTFACTURA);
            $FACTURA = mysqli_fetch_assoc($EJECUTAR);
            $IDFACTURA = $FACTURA['IDFACTURA'];

            $INSERTDETALLET = "INSERT INTO DETALLE_FACTURA_TEMP (IDTRATAMIENTO, IDFACTURA, CANTIDAD,PRECIO, PRECIOTOTAL) 
            VALUES ($IDTRATAMIENTO, $IDFACTURA, $CANTIDAD, $PRECIO, $TOTAL)";

            $ID = mysqli_insert_id($conexion);
            $EJECUTAR = mysqli_query($conexion, $INSERTDETALLET) or die(mysqli_error($conexion));

            echo "<script>window.open ('DETALLEFACTURA.PHP','_self')</script>";
        }
    ?>
        <br>   <br>
                            
        <h2>TRATAMIENTOS AGREGADOS</h2> <br>   <br>
            <table>
                <tr style="text-align: center;">
                    <td> ITEM </td>
                    <td> TRATAMIENTO </td>
                    <td> CANTIDAD </td>
                    <td> PRECIO UNITARIO </td>
                    <td> TOTAL </td>
                    <td> ACCION </td>
                </tr>
            <?php
            
                $suma=0;
                $consulta = "SELECT * FROM DETALLE_FACTURA_TEMP";
                $ejecutar = mysqli_query($conexion, $consulta);
                $i = 0;

                while ($Fila = mysqli_fetch_assoc($ejecutar)) {
                    $iddt = $Fila['IDDETALLEFACTURATEMP'];
                    $idtratamientov = $Fila['IDTRATAMIENTO'];
                    $cantidadd = $Fila['CANTIDAD'];
                    $precioU = $Fila['PRECIO'];
                    $totaldt = $Fila['PRECIOTOTAL'];
                    $i++;
            ?>   

                <tr>
                    <td align="center"><?php echo $iddt; ?></td>
                    <td>
                    <?php
                        $sub_sql_2 = "SELECT NOMBRE FROM TRATAMIENTO WHERE IDTRATAMIENTO=" .$idtratamientov;
                        $execute = mysqli_query($conexion, $sub_sql_2);
                        $tratventa = mysqli_fetch_assoc($execute);
                        echo $tratventa['NOMBRE'];
                    ?>
                    </td>
                    <td><?php echo $cantidadd; ?></td>
                    <td><?php echo $precioU; ?></td>
                    <td><?php echo $totaldt; ?></td>
                    <td>
                        <a onClick="javascript: return confirm('¿Estas seguro que quieres eliminar ese Tratamiento?');" href="DETALLEFACTURA.PHP?eliminar=<?php echo $iddt; ?>"> Eliminar
                    </td>
                </tr>     
            <?php
             $suma = $suma + $totaldt;            
             }       
            ?>
                <tr>
                    <td colspan="6">   </td>
                </tr>   
                <tr>
                    <td colspan="4" align="center"> GRAN TOTAL  </td>
                    <td colspan="2"><?php echo $suma;?> </td>
                </tr>
        </table>


         <?php
            if (isset($_GET['eliminar'])) {
                $borrar_id = $_GET['eliminar'];
                $eliminar = "DELETE FROM DETALLE_FACTURA_TEMP WHERE IDDETALLEFACTURATEMP ='$borrar_id'";
                $ejecutar = mysqli_query($conexion, $eliminar);

                    if ($ejecutar) {
                        echo "<script> alert ('El tratamiento ha sido eliminado') </script>";
                        echo "<script> window.open ('DETALLEFACTURA.PHP','_self') </script>";
                    } else {
                            echo "<script> alert ('Tratamiento no eliminado, está relacionado con otro registro') </script>";
                             echo "<script> window.open ('DETALLEFACTURA.PHP','_self') </script>";
                         }
            }
        ?>

        <br>

                <form action="DETALLEFACTURA.PHP" method="POST">
                    <div class="modal-footer">

                        <input type="hidden" name="IDFACTURA" value="<?php $IDFACTURA?>">
                        <input type="submit" name="txtfinalizar" value=" Finalizar Factura">
                        <input type="button" value="Cancelar Factura" onclick="location='../paciente/select.php'" />
                    </div>
                </form>
                        
            <?php
                if (isset($_POST['txtfinalizar'])) {
                    $consultafac = "SELECT MAX(IDfACTURA) AS 'IDFACTURA' FROM FACTURA";
                    $ejecutarconsultafac = mysqli_query($conexion,  $consultafac) or die(mysqli_error($conexion));
                    $maxfactura = mysqli_fetch_assoc($ejecutarconsultafac);
                    $consulta1 = $maxfactura['IDFACTURA'];

                    $sumtotal = "SELECT SUM(PRECIOTOTAL) as 'TOTALFACTURA' FROM DETALLE_FACTURA_TEMP WHERE IDFACTURA='".$consulta1."'";
                    $ejectasumatotal = mysqli_query($conexion, $sumtotal) or die(mysqli_error($conexion));
                    $grantotal = mysqli_fetch_assoc($ejectasumatotal);
                    $consulta2 = $grantotal['TOTALFACTURA'];
        
                    $insertfinal = "INSERT INTO DETALLE_FACTURA (VALOR, VALORTOTAL, IDFACTURA, IDTRATAMIENTO, CANTIDAD) SELECT PRECIO, PRECIOTOTAL, IDFACTURA, IDTRATAMIENTO, CANTIDAD FROM DETALLE_FACTURA_TEMP where IDFACTURA= $consulta1";
                                
                    $ejecutarfin = mysqli_query($conexion, $insertfinal) or die("Error mysql 201: " . mysqli_error($conexion));
                              
                        if ($ejecutarfin > 0) {
                            $updatefin = "UPDATE FACTURA SET TOTAL_FACTURA = $consulta2 WHERE IDFACTURA = $consulta1";
                            $ejecutarupdate = mysqli_query($conexion, $updatefin) or die(mysqli_error($conexion));
                                    
                            $eliminacionfinal = "DELETE FROM DETALLE_FACTURA_TEMP";
                            $execudelete = mysqli_query($conexion, $eliminacionfinal) or die(mysqli_error($conexion));
                                echo "<script>alert('Factura Realizada')</script>";
                                echo "<script> window.open ('FINALIZARFACTURA.PHP','_self') </script>";
                        }else{
                                echo "<script>alert('Error')</script>";
                                echo "<script> window.open ('DETALLEFACTURA.PHP','_self') </script>";
                            }
                }
            ?> 
    </FORM>
</DIV>
<?php INCLUDE ('../TEMPLATE/FOOTER.PHP');?>
</body>
</html>