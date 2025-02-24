<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_ADMINSTRADOR.PHP");

if (isset($_GET['ID']) && is_numeric($_GET['ID'])) {
    $id_usuario = $_GET['ID'];

    // Consultar datos del usuario
    $sql_usuario = "SELECT * FROM usuario WHERE ID_Usuario = $id_usuario";
    $resultado = mysqli_query($conexion, $sql_usuario);
    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario) {
        echo "<script>alert('Usuario no encontrado'); window.location.href='LISTA_USUARIOS.PHP';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de usuario no válido'); window.location.href='LISTA_USUARIOS.PHP';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $correo = $_POST['Correo'];
    $documento = $_POST['N_Documento'];
    $direccion = $_POST['Direccion'];
    $ciudad = $_POST['Ciudad'];
    $telefono = $_POST['Telefono'];
    $estado = $_POST['Estado'];
    $rol = $_POST['Rol'];
    $contrasena = $_POST['Contrasena'];
    $foto = $_FILES['foto'];

    $contrasena_final = !empty($contrasena) ? $contrasena : $usuario['Contrasena'];

    $sql_update = "UPDATE usuario SET 
                    Nombre='$nombre', 
                    Apellido='$apellido', 
                    Correo='$correo', 
                    N_Documento='$documento', 
                    Direccion='$direccion', 
                    Ciudad='$ciudad', 
                    Telefono='$telefono', 
                    Estado='$estado', 
                    ID_Rol='$rol', 
                    Contrasena='$contrasena_final' 
                    WHERE ID_Usuario=$id_usuario";

    if (mysqli_query($conexion, $sql_update)) {
        if ($foto['tmp_name']) {
            $destino = "../IMAGENES/usuarios/" . $id_usuario . ".jpg";
            move_uploaded_file($foto['tmp_name'], $destino);
        }
        echo "<script>alert('Usuario actualizado exitosamente'); window.location.href='../ROLES/INTERFAZ_ADMINISTRADOR.PHP';</script>";
    } else {
        echo "<script>alert('Error al actualizar usuario'); window.location.href='LISTA_USUARIOS.PHP';</script>";
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Usuario</title>
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
            opacity: 0; /* Inicialmente oculto */
            animation: fadeIn 1s forwards; /* Aparece con la animación */
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
        input[type="file"],
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

        /* Botón de actualizar */
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

        /* Efecto de fade-in */
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
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <h2>Actualizar Usuario</h2>
            <div class="form-grid">
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="Nombre" value="<?php echo $usuario['Nombre']; ?>" required>
                </div>
                <div>
                    <label>Apellido:</label>
                    <input type="text" name="Apellido" value="<?php echo $usuario['Apellido']; ?>" required>
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="email" name="Correo" value="<?php echo $usuario['Correo']; ?>" required>
                </div>
                <div>
                    <label>Documento:</label>
                    <input type="text" name="N_Documento" value="<?php echo $usuario['N_Documento']; ?>" required>
                </div>
                <div>
                    <label>Dirección:</label>
                    <input type="text" name="Direccion" value="<?php echo $usuario['Direccion']; ?>" required>
                </div>
                <div>
                    <label>Ciudad:</label>
                    <input type="text" name="Ciudad" value="<?php echo $usuario['Ciudad']; ?>" required>
                </div>
                <div>
                    <label>Teléfono:</label>
                    <input type="text" name="Telefono" value="<?php echo $usuario['Telefono']; ?>" required>
                </div>
                <div>
                    <label>Estado:</label>
                    <select name="Estado">
                        <option value="Activo" <?php echo ($usuario['Estado'] == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                        <option value="Inactivo" <?php echo ($usuario['Estado'] == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
                <div>
                    <label>Rol:</label>
                    <select name="Rol">
                        <?php
                        $roles_query = "SELECT * FROM rol";
                        $roles_result = mysqli_query($conexion, $roles_query);
                        while ($rol = mysqli_fetch_assoc($roles_result)) {
                            $selected = ($rol['ID_Rol'] == $usuario['ID_Rol']) ? 'selected' : '';
                            echo "<option value='{$rol['ID_Rol']}' $selected>{$rol['Nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="full-width">
                    <label>Contraseña:</label>
                    <input type="password" name="Contrasena" placeholder="Dejar en blanco para no cambiar">
                </div>
                <div class="full-width">
                    <label>Actualizar Foto:</label>
                    <input type="file" name="foto">
                </div>
                <div class="full-width">
                    <input type="submit" value="Actualizar">
                </div>
            </div>
        </form>
    </div>
    <?php include("../INCLUDE/FOOTER.PHP"); ?>

</body>
</html>
