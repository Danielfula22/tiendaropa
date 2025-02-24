<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio del Administrador</title>

    <!-- Enlaces a estilos -->
  <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/index.css" rel="stylesheet">
    <link href="../ESTILOS/menu.css" rel="stylesheet">
    <link href="../ESTILOS/categorias.css" rel="stylesheet">
    <link href="../ESTILOS/ico_perfil.css" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/menu_de los demas.css" rel="stylesheet">
    <link href="../ESTILOS/responsivo_articulos.css" rel="stylesheet">
    <link href="../ESTILOS/TABLA_ADMINISTRADOR.CSS" rel="stylesheet">
</head>
<body>

<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['Nombre'])) {
    header("Location: ../LOGIN.PHP"); // Redirige al formulario de inicio de sesión si no está autenticado
    exit();
}

// Obtener el nombre del usuario desde la sesión
$nombre = htmlspecialchars($_SESSION['Nombre'], ENT_QUOTES, 'UTF-8');
?>

<?php include('../INCLUDE/HEADER_VENDEDOR.PHP'); ?>

<center>
    <div class="bienvenida">
        <h1 class="titulo">¡Bienvenido a nuestra tienda de ropa!</h1>
        <br>
        <p class="mensaje">Hola, <?php echo $nombre; ?>. ¡Esperamos que disfrutes tu experiencia!</p>
    </div>
</center>

<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f6f9;
        color: #333;
    }

    /* Caja de bienvenida */
    .bienvenida {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 30px;
        max-width: 400px;
        width: 80%;
        margin-top: 20px;
    }

    .titulo {
        font-size: 2rem;
        color: #4a90e2;
        margin-bottom: 15px;
    }

    .mensaje {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 20px;
    }

    button {
        background-color: #4a90e2;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #357ab7;
    }
</style>

<?php include("../INCLUDE/FOOTER.PHP"); ?>

</body>
</html>
