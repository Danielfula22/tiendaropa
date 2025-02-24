<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda MAFE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/index.css" rel="stylesheet">
    <link href="../ESTILOS/menu.css" rel="stylesheet">
    <link href="../ESTILOS/Menu_hamburguesa.css" rel="stylesheet">
    <link href="../ESTILOS/iniciar_sesion.css" rel="stylesheet">
    <link href="../ESTILOS/estilos del loguin.css" rel="stylesheet">



    <style>
        .logo {
            font-size: 40px;
        }
        .enlaces-nav {
            margin-bottom: -19px;
        }
        .boton-sesion {
            font-size: 16px;
            margin-right: 10px;
            margin-top: 30px;
        }

        /* Estilo para el icono de WhatsApp */
        .whatsapp-icon {
            position: fixed;
            bottom: 18px;
            right: 20px;
            background-color: #25D366;
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            color: white;
            font-size: 40px;
            text-decoration: none;
            z-index: 100;
        }

        .whatsapp-icon:hover {
            background-color: #128C7E;
        }
        .form-label i {
    position: relative;
    top: 5px; /* Ajusta este valor según sea necesario */
    margin-right: 5px; /* Espacio entre el icono y el texto */
}

    </style>
</head>
<body>
<header>
    <!-- Menú de navegación -->
    <nav>
        <div class="logo">LIFER</div>

        <!-- Contenedor del perfil y botón -->
        <div class="perfil-boton-container">
            <?php include('../INCLUDE/header_perfil.php'); ?>
        </div>
        
        <div class="botones-sesion">
            <a href="../INDEX.PHP" class="boton-sesion">Cerrar Sesión</a>
        </div>
        
        <div class="enlaces-nav">
            <div class="desplegable">
                <a href="../ROLES/INICIO_CLIENTES.PHP">Inicio</a>
                <ul class="submenu">
                    <li><a href="#novedades">Novedades</a></li>
                    <li><a href="#populares">Más Populares</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#">Hombre</a>
                <ul class="submenu">
                    <li><a href="../ROPA_CLIENTE_HOMBRE/CAMISETAS_H.PHP">Camisetas</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/CHAQUETAS_H.PHP">Chaquetas</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/JEANS_H.PHP">Pantalones</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/SHORTS_H.PHP">Shorts</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/BLAZER_H.PHP">Gaban Y Blazer</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/BUZOS_H.PHP">Buzos</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/CAMISAS_H.PHP">Camisas</a></li>
                    <li><a href="../ROPA_CLIENTE_HOMBRE/ROPA_INTERIOR_H.PHP">Ropa Interior</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#categorias">Mujer</a>
                <ul class="submenu">
                    <li><a href="../ROPA_CLIENTE_MUJER/CAMISETAS_M.PHP">Camisetas</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/CHAQUETAS_M.PHP">Chaquetas</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/JEANS_M.PHP">Pantalones</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/BLAZER_M.PHP">Blazer y Gaban</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/CAMISAS_M.PHP">Camisas</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/ROPA_INT_M.PHP">Ropa Interior</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/VESTIDOS_M.PHP">Vestidos</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/BLUSAS_M.PHP">Blusas</a></li>
                    <li><a href="../ROPA_CLIENTE_MUJER/BUZOS_M.PHP">Buzos</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#contacto">Accesorios</a>
                <ul class="submenu">
                    <li><a href="../ACCESORIOS_CLIENTE/ACCESORIOS.PHP">Gafas</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/CINTURON.PHP">Cinturón</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/PAÑUELOS.PHP">Pañuelos</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/BUFANDAS.PHP">Bufandas</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/GUANTES.PHP">Guantes</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/CORBATAS.PHP">Corbatas</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/ARETES.PHP">Aretes</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/ANILLOS.PHP">Anillos</a></li>
                    <li><a href="../ACCESORIOS_CLIENTE/COLLARES.PHP">Collares</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#accesorios">Contacto</a>
                <ul class="submenu">
                    <li><a href="#ayuda">Ayuda</a></li>
                    <li><a href="#ubicacion">Ubicación</a></li>
                    <li><a href="#email">Email</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br>

    <!-- Imagen bajo el menu -->
    <div class="imagen-decorativa"></div>

    <!-- Icono flotante de WhatsApp -->
    <a href="https://wa.me/1234567890" class="whatsapp-icon" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
</header>

</body>
</html>
