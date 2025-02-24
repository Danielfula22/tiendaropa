<?php
ob_start(); // Inicia el buffer de salida para evitar errores de "headers already sent"

include("../CONEXION/CONEXION_BASE_DE_DATOS.PHP");
include("../INCLUDE/HEADER_VENDEDOR.PHP");

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
    $contrasena = $_POST['contrasena']; // Encriptación de la contraseña

    // Insertar datos en la tabla usuario
    $SQL = "INSERT INTO usuario (Nombre, Apellido, Correo, N_Documento, Direccion, Ciudad, Telefono, Estado, ID_Rol, Contrasena) 
            VALUES ('$nombre', '$apellido', '$correo', '$documento', '$direccion', '$ciudad', '$telefono', '$estado', '$rol', '$contrasena')";
    $RESULT = mysqli_query($conexion, $SQL) or die(mysqli_error($conexion));

    // Mostrar una alerta de registro exitoso y redirigir
    if ($RESULT) {
        echo "<script>alert('Registro exitoso'); window.location.href='../OTRO_VENDEDOR/INTERFAZ_VENDEDOR.PHP';</script>";
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
    <link rel="stylesheet" href="../CSS/update.css">
</head>
<body>

<div class="form-container">
    <form name="insert_usuario" action="" method="POST">
        <h2> Insertar Nuevo Usuario </h2>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" required>
        </div>

        <div class="form-group">
            <label for="N_Documento">Número de Documento:</label>
            <input type="text" name="N_Documento" required>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required>
        </div>

        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" name="ciudad" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>

        <div class="form-group">
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

        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>
        </div>

        <div class="form-group">
            <input type="submit" name="ENVIAR" value="Guardar" class="btn-submit">
        </div>
    </form>
</div>


</body>
</html>

<?php include("../INCLUDE/FOOTER.PHP"); ?>


<?php
ob_end_flush(); // Cierra el buffer de salida
?>
