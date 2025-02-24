<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        /* Fondo general */
        body {
            background: linear-gradient(to right, #e6dcd3, #f8f4ef);
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .form-container h3 {
            background: linear-gradient(to right, #593c1f, #402912);
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
        }

        .form-container .form-control {
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-container .form-group label {
            font-weight: bold;
            color: #593c1f;
        }

        .form-container .btn-success {
            background-color: #593c1f;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .form-container .btn-success:hover {
            background-color: #402912;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .decoracion {
            background: linear-gradient(to bottom, #6a4a2f, #402912);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .titu{
            font-size: 25px;
font-family: 'Times New Roman', Times, serif;        }
    </style>
</head>
<body>
    <?php 
        include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP'); 
        include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); 
    ?>

    <div class="container mt-5">
        <div class="row justify-content-between">
            <!-- Formulario -->
            <div class="col-lg-7">
                <div class="form-container">
                    <h3>Facturación</h3>

                    <?php
                    if (isset($_GET['FACTURAR']) && !empty($_GET['FACTURAR'])) {
                        $id_generarfactura = $_GET['FACTURAR'];
                        $consultagenfac = "SELECT * FROM Usuario WHERE ID_Usuario='$id_generarfactura'";
                        $executagenfac = mysqli_query($conexion, $consultagenfac);

                        if ($executagenfac && mysqli_num_rows($executagenfac) > 0) {
                            $Fila = mysqli_fetch_assoc($executagenfac);

                            $ID_USUARIO = $Fila['ID_Usuario'];
                            $NOMBRE = $Fila['Nombre'];
                            $APELLIDO = $Fila['Apellido'];
                            $CORREO = $Fila['Correo'];
                            $DOCUMENTO = $Fila['N_Documento'];
                            $DIRECCION = $Fila['Direccion'];
                            $CIUDAD = $Fila['Ciudad'];
                            $TELEFONO = $Fila['Telefono'];
                        } else {
                            echo "<div class='alert alert-danger'>No se encontraron datos para el usuario con el ID proporcionado.</div>";
                            exit();
                        }
                    } else {
                        echo "<div class='alert alert-warning'>No se ha proporcionado un ID de usuario válido para facturar.</div>";
                        exit();
                    }
                    ?>

                    <form name="INSERT_FACTURA" method="POST" action="../FACTURACION/procesas_factura.php" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo isset($ID_USUARIO) ? $ID_USUARIO : ''; ?>" name="ID_USUARIO">

                          <!-- Sección de Usuario -->
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="DOCUMENTO">N° Documento:</label>
                        <input type="number" class="form-control" id="DOCUMENTO" value="<?php echo isset($DOCUMENTO) ? $DOCUMENTO : ''; ?>" name="DOCUMENTO">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NOMBRE">Nombre:</label>
                        <input type="text" class="form-control" id="NOMBRE" value="<?php echo isset($NOMBRE) ? $NOMBRE : ''; ?>" name="NOMBRE">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="APELLIDO">Apellido:</label>
                        <input type="text" class="form-control" id="APELLIDO" value="<?php echo isset($APELLIDO) ? $APELLIDO : ''; ?>" name="APELLIDO">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="CORREO">Email:</label>
                        <input type="email" class="form-control" id="CORREO" value="<?php echo isset($CORREO) ? $CORREO : ''; ?>" name="CORREO">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="DIRECCION">Dirección:</label>
                        <input type="text" class="form-control" id="DIRECCION" value="<?php echo isset($DIRECCION) ? $DIRECCION : ''; ?>" name="DIRECCION">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="CIUDAD">Ciudad:</label>
                        <input type="text" class="form-control" id="CIUDAD" value="<?php echo isset($CIUDAD) ? $CIUDAD : ''; ?>" name="CIUDAD">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TELEFONO">Teléfono:</label>
                        <input type="text" class="form-control" id="TELEFONO" value="<?php echo isset($TELEFONO) ? $TELEFONO : ''; ?>" name="TELEFONO">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="FECHA">Fecha Facturación:</label>
                        <input type="date" class="form-control" id="FECHA" name="FECHA" required>
                    </div>
                </div>
            </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ID_VENDEDOR">Atendido por:</label>
                                    <select name="ID_VENDEDOR" id="ID_VENDEDOR" class="form-control" required>
                                        <?php
                                        $consulta = "SELECT * FROM Usuario WHERE Estado = 'Activo' AND ID_Rol = 2";
                                        $ejecutar = mysqli_query($conexion, $consulta);
                                        while ($res = mysqli_fetch_assoc($ejecutar)) {
                                            echo "<option value='" . $res['ID_Usuario'] . "'>" . $res['Nombre'] . " " . $res['Apellido'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="OBSERVACIONES">Observaciones:</label>
                                    <textarea name="OBSERVACIONES" id="OBSERVACIONES" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="GENERAR_FACTURA" class="btn btn-success mt-3">Generar Factura</button>
                    </form>
                </div>
            </div>

          
            <!-- Decoración -->
            <div class="col-lg-4">
                <div class="decoracion">
                    <div class="gif-container">
                        <div class="tenor-gif-embed" data-postid="11107745814976204275" data-share-method="host" data-aspect-ratio="1.33155" data-width="100%">
                            <a href="https://tenor.com/view/download2-best-download-downloading-gif-11107745814976204275">Download2 Best Download GIF</a>from <a href="https://tenor.com/search/download2-gifs">Download2 GIFs</a>
                        </div>
                        <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
                        <br>
                        <div class="titu">
                        <p>Se están procesando los datos de la compra</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php 
        include('../INCLUDE/FOOTER.PHP');
    ?>
</body>
</html>
