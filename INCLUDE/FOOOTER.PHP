<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionStyle - Footer</title>
    <link href="../ESTILOS/footer.css" rel="stylesheet">
</head>
<body>
<style>
    .social-icon {
    width: 40px; /* Ajusta el tamaño según lo necesites */
    height: 40px; /* Ajusta el tamaño según lo necesites */
    border-radius: 50%; /* Hace que la imagen sea redonda */
    object-fit: cover; /* Asegura que la imagen se ajuste bien dentro del círculo */
    margin-right: 10px; /* Espacio entre los íconos */
    transition: transform 0.3s ease; /* Agrega una animación al pasar el cursor */
}

.social-icon:hover {
    transform: scale(1.1); /* Agranda ligeramente la imagen cuando se pasa el cursor */
}


</style>

    <footer>
        <div class="column">
            <h3>FashionStyle</h3>
            <p>Tu tienda de ropa en línea para toda la familia.</p>
        </div>
        <div class="column">
            <h3>Enlaces</h3>
            <a href="#">Inicio</a>
            <a href="#">Hombres</a>
            <a href="#">Mujeres</a>
            <a href="#">Niños</a>
            <a href="#">Contacto</a>
        </div>
        <div class="column">
            <h3>Redes Sociales</h3>
            <a href="#">
                <img src="./IMAGENES/Youtube.png" alt="Facebook" class="social-icon">
            </a>
            <a href="#">
                <img src="instagram-icon.png" alt="Instagram" class="social-icon">
            </a>
            <a href="#">
                <img src="twitter-icon.png" alt="Twitter" class="social-icon">
            </a>
        </div>
    </footer>
</body>
</html>
