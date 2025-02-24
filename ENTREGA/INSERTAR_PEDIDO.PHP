<?php
ob_start();
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');
include('../INCLUDE/HEADER_ADMINSTRADOR.PHP');

// Consultas para obtener modos de entrega y domiciliarios
$modosEntregaResult = mysqli_query($conexion, "SELECT ID_Modo_entrega, Descripcion FROM modo_entrega") or die("Error al obtener modos de entrega");
$domiciliariosResult = mysqli_query($conexion, "SELECT ID_Domiciliario, Nombre FROM domiciliario") or die("Error al obtener domiciliarios");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escapar y almacenar datos del formulario
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion'] ?? '');
    $fechaEntrega = mysqli_real_escape_string($conexion, $_POST['fecha_entrega'] ?? '');
    $departamento = mysqli_real_escape_string($conexion, $_POST['departamento'] ?? '');
    $nombreCliente = mysqli_real_escape_string($conexion, $_POST['Nombre_cliente'] ?? '');
    $cedulaCliente = mysqli_real_escape_string($conexion, $_POST['cedula_cliente'] ?? '');
    $correo = mysqli_real_escape_string($conexion, $_POST['correo'] ?? '');
    $estado = mysqli_real_escape_string($conexion, $_POST['Estado'] ?? '');
    $idModoEntrega = mysqli_real_escape_string($conexion, $_POST['id_modo_entrega'] ?? '');
    $idDomiciliario = mysqli_real_escape_string($conexion, $_POST['id_domiciliario'] ?? '');

    // Verificar existencia de un registro similar
    $checkResult = mysqli_query($conexion, "SELECT * FROM entrega WHERE Direccion_de_la_entrega = '$direccion' AND Fecha_de_entrega = '$fechaEntrega' AND Cedula_del_cliente = '$cedulaCliente'");
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Ya existe un registro con los mismos datos.'); window.location.href='../ENTREGA/INSERTAR_PEDIDO.PHP';</script>";
        exit();
    }

    // Verificar que los IDs de Modo de entrega y Domiciliario sean válidos
    $checkModoEntrega = mysqli_query($conexion, "SELECT * FROM modo_entrega WHERE ID_Modo_entrega = '$idModoEntrega'");
    if (mysqli_num_rows($checkModoEntrega) == 0) {
        echo "<script>alert('El modo de entrega seleccionado no es válido.'); window.location.href='../ENTREGA/INSERTAR_PEDIDO.PHP';</script>";
        exit();
    }

    $checkDomiciliario = mysqli_query($conexion, "SELECT * FROM domiciliario WHERE ID_Domiciliario = '$idDomiciliario'");
    if (mysqli_num_rows($checkDomiciliario) == 0) {
        echo "<script>alert('El domiciliario seleccionado no es válido.'); window.location.href='../ENTREGA/INSERTAR_PEDIDO.PHP';</script>";
        exit();
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO entrega (Direccion_de_la_entrega, Fecha_de_entrega, Departamento, Nombre_del_cliente, Cedula_del_cliente, Correo, Estado, ID_Modo_entrega, ID_Domiciliario) 
            VALUES ('$direccion', '$fechaEntrega', '$departamento', '$nombreCliente', '$cedulaCliente', '$correo', '$estado', '$idModoEntrega', '$idDomiciliario')";
    
    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Entrega registrada exitosamente'); window.location.href='../ENTREGA/ENTREGA.PHP';</script>";
    } else {
        echo "<script>alert('Error al registrar la entrega.'); window.location.href='../ENTREGA/INSERTAR_PEDIDO.PHP';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pedido y Entrega</title>
    <link rel="stylesheet" href="../CSS/update.css">
    <script>
        function verificarModoEntrega() {
            const modoEntrega = document.querySelector('select[name="id_modo_entrega"]').value;
            const direccionInput = document.querySelector('input[name="direccion"]');
            direccionInput.value = (modoEntrega === "1") ? "No aplica" : "";
            direccionInput.readOnly = (modoEntrega === "1");
        }
    </script>
    <style>
        /* Animación de Fade-In */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 1200px; /* Aumenté el ancho máximo */
            margin: 30px auto;
            padding: 40px;
            background: #fffaf0;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 2px solid #f4a261;
            animation: fadeIn 1.5s ease-out; /* Aplicamos la animación */
        }

        h2 {
            text-align: center;
            color: #264653;
            font-size: 32px;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Distribuir 4 columnas */
            gap: 20px; /* Espacio entre los campos */
        }

        label {
            font-weight: bold;
            color: #6b705c;
            display: block;
            margin-bottom: 10px;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #b7b7a4;
            border-radius: 8px;
            background-color: #fefae0;
            font-size: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #2a9d8f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 30px;
        }

        .btn-submit:hover {
            background-color: #264653;
            transform: scale(1.02);
        }

        .form-group-last {
            display: grid;
            grid-template-columns: 3fr 1fr; /* El botón "Guardar" al lado del domiciliario */
            gap: 20px;
            align-items: center; /* Centrar verticalmente */
        }

        @media (max-width: 1024px) {
            .form-group {
                grid-template-columns: repeat(2, 1fr); /* Cambiar a 2 columnas para pantallas más pequeñas */
            }

            .form-group-last {
                grid-template-columns: 1fr; /* Poner el botón debajo en pantallas más pequeñas */
            }
        }

        @media (max-width: 768px) {
            .form-group {
                grid-template-columns: 1fr; /* Una sola columna en pantallas pequeñas */
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="POST">
            <h2>Insertar Nueva Entrega</h2>
            <div class="form-group">
                <div>
                    <label for="Nombre_cliente">Nombre del Cliente:</label>
                    <input type="text" name="Nombre_cliente" required>
                </div>
                <div>
                    <label for="cedula_cliente">Cédula del Cliente:</label>
                    <input type="text" name="cedula_cliente" required>
                </div>
                <div>
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" required>
                </div>
                <div>
                    <label for="departamento">Departamento:</label>
                    <input type="text" name="departamento">
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" required>
                </div>
                <div>
                    <label for="fecha_entrega">Fecha de Entrega:</label>
                    <input type="date" name="fecha_entrega" required>
                </div>
                <div>
                    <label for="Estado">Estado:</label>
                    <input type="text" name="Estado" required>
                </div>
                <div>
                    <label for="id_modo_entrega">Modo de Entrega:</label>
                    <select name="id_modo_entrega" required onchange="verificarModoEntrega()">
                        <?php while($row = mysqli_fetch_assoc($modosEntregaResult)): ?>
                            <option value="<?= $row['ID_Modo_entrega'] ?>"><?= $row['Descripcion'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="form-group-last">
                <div>
                    <label for="id_domiciliario">Domiciliario:</label>
                    <select name="id_domiciliario" required>
                        <?php while($row = mysqli_fetch_assoc($domiciliariosResult)): ?>
                            <option value="<?= $row['ID_Domiciliario'] ?>"><?= $row['Nombre'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>
