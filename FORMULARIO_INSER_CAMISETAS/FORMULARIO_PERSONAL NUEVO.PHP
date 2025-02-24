<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $documento = $_POST['N_Documento'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];
    $rol = $_POST['rol'];
    $contrasena = $_POST['contrasena'];

    // Insertar datos en la tabla usuario
    $SQL = "INSERT INTO usuario (Nombre, Apellido, Correo, N_Documento, Direccion, Ciudad, Telefono, Estado, ID_Rol, Contrasena) 
            VALUES ('$nombre', '$apellido', '$correo', '$documento', '$direccion', '$ciudad', '$telefono', '$estado', '$rol', '$contrasena')";
    $RESULT = mysqli_query($conexion, $SQL) or die(mysqli_error($conexion));

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT) {
        echo "<script>alert('Registro exitoso'); window.location.href='../ROLES/INTERFAZ_ADMINISTRADOR.PHP';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: white; /* Beige claro */
            margin: 0;
            padding: 0;
        }

        /* Contenedor del formulario */
        .form-container {
            max-width: 90%; /* Ocupar el 90% del ancho de la pantalla */
            margin: 30px auto;
            background: #fffaf0; /* Beige más claro */
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
        input[type="email"],
        input[type="password"],
        select {
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
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
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
    <form name="insert_usuario" action="" method="POST">
        <h2>Registrar Nuevo Usuario</h2>
        <div class="form-grid">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" name="correo" required>
            </div>
            <div>
                <label for="N_Documento">Número de Documento:</label>
                <input type="text" name="N_Documento" required>
            </div>
            <div>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" required>
            </div>
            <div>
                <label for="ciudad">Ciudad:</label>
                <input type="text" name="ciudad" required>
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" required>
            </div>
            <div>
                <label for="estado">Estado:</label>
                <select name="estado" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
            <div>
                <label for="rol">Rol:</label>
                <select name="rol" required>
                    <option value="">Seleccione un rol</option>
                    <?php
                    // Consulta para obtener los roles de la base de datos
                    $sql_rol = "SELECT ID_Rol, Nombre FROM rol";
                    $result_rol = mysqli_query($conexion, $sql_rol);
                    while ($row = mysqli_fetch_assoc($result_rol)) {
                        echo "<option value='" . $row['ID_Rol'] . "'>" . $row['Nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="full-width">
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" required>
            </div>
            <div class="full-width">
                <input type="submit" name="ENVIAR" value="Guardar">
            </div>
        </div>
    </form>
</div>

</body>
</html>

<?php include("../INCLUDE/FOOTER.PHP"); ?>
<?php ob_end_flush(); ?>
