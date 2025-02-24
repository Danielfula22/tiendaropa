<?php
session_start();
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
    $password = mysqli_real_escape_string($conexion, trim($_POST['password']));

    // Consulta para verificar credenciales
    $query = "SELECT ID_Usuario, ID_Rol, Nombre FROM usuario WHERE Correo = ? AND Contrasena = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if ($user['ID_Rol'] == 6) {
            // Guardar datos necesarios en la sesión
            $_SESSION['ID_Usuario'] = $user['ID_Usuario'];
            $_SESSION['Nombre'] = $user['Nombre'];
            
            // Redirigir al usuario con rol 6
            header("Location: ../INCLUDE/Estadisticas.php");
            exit;
        } else {
            echo "<script>alert('Acceso denegado. No tiene permisos para ingresar.'); window.location.href = '../INDEX.PHP';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href = '../INDEX.PHP';</script>";
        exit;
    }
}
?>
