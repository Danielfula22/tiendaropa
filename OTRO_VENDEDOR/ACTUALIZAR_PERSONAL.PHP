<?php
ob_start();
include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_VENDEDOR.PHP");

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

    // Si se proporciona una nueva contraseña, guárdala, de lo contrario, usa la existente
    $contrasena_final = !empty($contrasena) ? $contrasena : $usuario['Contrasena'];

    // Actualizar datos del usuario
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
        // Manejar la subida de la foto solo si se proporciona una nueva
        if ($foto['tmp_name']) {
            $destino = "../IMAGENES/usuarios/" . $id_usuario . ".jpg";
            move_uploaded_file($foto['tmp_name'], $destino);
        }
        echo "<script>alert('Usuario actualizado exitosamente'); window.location.href='../OTRO_VENDEDOR/INTERFAZ_VENDEDOR.PHP';</script>";
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
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>
<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Actualizar Usuario</h2>
        <label>Nombre:</label>
        <input type="text" name="Nombre" value="<?php echo $usuario['Nombre']; ?>" required>
        
        <label>Apellido:</label>
        <input type="text" name="Apellido" value="<?php echo $usuario['Apellido']; ?>" required>

        <label>Correo:</label>
        <input type="email" name="Correo" value="<?php echo $usuario['Correo']; ?>" required>

        <label>Documento:</label>
        <input type="text" name="N_Documento" value="<?php echo $usuario['N_Documento']; ?>" required>

        <label>Dirección:</label>
        <input type="text" name="Direccion" value="<?php echo $usuario['Direccion']; ?>" required>

        <label>Ciudad:</label>
        <input type="text" name="Ciudad" value="<?php echo $usuario['Ciudad']; ?>" required>

        <label>Teléfono:</label>
        <input type="text" name="Telefono" value="<?php echo $usuario['Telefono']; ?>" required>

        <label>Estado:</label>
        <select name="Estado">
            <option value="Activo" <?php echo ($usuario['Estado'] == 'Activo') ? 'selected' : ''; ?>>Activo</option>
            <option value="Inactivo" <?php echo ($usuario['Estado'] == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
        </select>

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

        <label>Contraseña:</label>
        <input type="password" name="Contrasena" placeholder="Dejar en blanco para no cambiar">

        <label>Actualizar Foto:</label>
        <input type="file" name="foto">

        <input type="submit" value="Actualizar">
    </form>
</div>
<?php include("../INCLUDE/FOOTER.PHP"); ?>
</body>
</html>
