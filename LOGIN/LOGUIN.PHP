<?php
session_start();
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta para verificar credenciales
    $query = "SELECT ID_Usuario, ID_Rol, Nombre FROM usuario WHERE Correo = '$email' AND Contrasena = '$password'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Guardar datos necesarios en la sesión
        $_SESSION['ID_Usuario'] = $user['ID_Usuario'];
        $_SESSION['Nombre'] = $user['Nombre'];

        // Redirigir al usuario según su rol
        switch ($user['ID_Rol']) {
            case 1:
                header("Location: ../ROLES/INICIO_ADM.PHP");
                exit;
            case 2:
                header("Location: ../ROLES/INICIO_VENDEDOR.PHP");
                exit;
            case 3:
                header("Location: ../ROLES/INICIO_CLIENTES.PHP");
                exit;
            case 4:
                header("Location: ../ROLES/INTERFAZ_ASESOR_MODA.PHP");
                exit;
            case 5:
                header("Location: ../ROLES/INICIO_DOMICILIARIO.PHP");
                exit;
            case 6:
                header("Location: ../ROLES/INICIO_ADM.PHP");
                exit;
            default:
                echo "<script>alert('Rol no reconocido'); window.location.href = '../INDEX.PHP';</script>";
                exit;
        }
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href = '../INDEX.PHP';</script>";
        exit;
    }
}
?>
