<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Insertar datos en la tabla proveedor
    $SQL = "INSERT INTO proveedor (Nombre, Telefono, Correo) 
            VALUES ('$nombre', '$telefono', '$correo')";
    $RESULT = mysqli_query($conexion, $SQL) or die(mysqli_error($conexion));

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT) {
        echo "<script>alert('Proveedor registrado exitosamente'); window.location.href='../PROVEEDORES/PROVEEDORES.PHP';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Contenedor del formulario */
        .form-container {
            max-width: 90%; /* Ocupar el 90% del ancho de la pantalla */
            margin: 30px auto;
            background: #fffaf0; /* Beige claro */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: 2px solid #f4a261; /* Color terracota */
            animation: fadeIn 1s ease-out; /* Aplicar la animación */
        }

        /* Animación para que el formulario aparezca suavemente */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Títulos */
        h2 {
            text-align: center;
            color: #264653; /* Verde oscuro */
            margin-bottom: 30px;
            font-size: 32px;
        }

        /* Estilo del grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsivo */
            gap: 25px;
        }

        /* Labels */
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #6b705c; /* Marrón suave */
            font-size: 16px;
        }

        /* Campos de entrada */
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #b7b7a4; /* Beige oscuro */
            border-radius: 8px;
            font-size: 16px;
            background-color: #fefae0; /* Beige claro */
            transition: all 0.3s ease;
        }

        /* Enfocar campos */
        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #e76f51; /* Terracota */
            outline: none;
            background-color: #ffffff;
        }

        /* Botón de guardar */
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #2a9d8f; /* Verde turquesa */
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            grid-column: span 2;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #264653; /* Verde oscuro */
            transform: scale(1.02);
        }

        /* Campos de ancho completo */
        .full-width {
            grid-column: span 2;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form name="insert_proveedor" action="" method="POST">
        <h2>Registrar Proveedor Nuevo</h2>

        <div class="form-grid">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" name="correo" required>
            </div>
            <div class="full-width">
                <input type="submit" name="ENVIAR" value="Guardar">
            </div>
        </div>
    </form>
</div>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>

<?php
ob_end_flush(); // Cierra el buffer de salida
?>
