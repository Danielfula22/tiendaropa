<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAZER Y GABAN_HOMBRE</title>

    <!-- Enlaces a tus estilos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/FOOTER_ESTILOS.CSS" rel="stylesheet">
    <link href="../INCLUDE - ESTILOS/HEADER_ESTILOS.CSS" rel="stylesheet">
    <link href="../ESTILOS/index.css" rel="stylesheet">
    <link href="../ESTILOS/menu.css" rel="stylesheet">
    <link href="../ESTILOS/categorias.css" rel="stylesheet">
    <link href="../ESTILOS/ico_perfil.css" rel="stylesheet">
    <link href="../ESTILOS/responsiva.css" rel="stylesheet">
    <link href="../ESTILOS/menu_de los demas.css" rel="stylesheet">
    <link href="../ESTILOS/responsivo_articulos.css" rel="stylesheet">

    <style>
        /* Estilos para el header en pantallas grandes */
        header nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        h2 {
            color: white;
            margin: 0;
        }

        /* Estilo del botón de Cerrar Sesión con color rojo */
        .boton-sesion {
            text-decoration: none;
            background-color: red;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
        }

        /* Estilos para el menú desplegable */
        .desplegable {
            position: relative;
            display: inline-block;
        }
        .desplegable .submenu {
    display: none;
    position: absolute;
    top: 120%; /* Incrementa este valor si quieres que aparezca aún más abajo */
    left: 0;
    background-color: #333;
    min-width: 200px;
    padding: 5px;
    list-style: none;
    margin: 0;
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}


        .desplegable:hover .submenu {
            display: block;
        }

        .submenu li a {
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            display: block;
            font-size: 14px; /* Tamaño de letra un poco más grande */
        }

        .submenu li a:hover {
            background-color: #555;
        }

        /* Estilos para pantallas pequeñas (responsivo) */
        @media (max-width: 768px) {
            header nav {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            h2 {
                margin-bottom: 10px;
            }

            .boton-sesion {
                margin-top: 20px;
            }

            .desplegable .submenu {
                position: absolute;
                width: 100%;
                left: 0;
                top: 0;
                z-index: 1;
            }

            .desplegable .submenu li {
                width: 100%;
            }

            /* Mostrar el submenú cuando se haga clic en el item principal */
            .desplegable .submenu {
                display: none;
            }

            .desplegable:hover .submenu {
                display: block;
            }

            .desplegable a {
                cursor: pointer;
            }
        }
        
    </style>
</head>
<body>

<!-- CONTENIDO PRINCIPAL -->
<header>
    <nav>
        
    <h2>
  <a href="../ROLES/INICIO_VENDEDOR.PHP" style="text-decoration:none; color: white;">VENDEDOR</a>
</h2>
        <!-- Barra de navegación con enlaces -->
        <div class="enlaces-nav">
            <!-- Menú Hombre -->
            <div class="desplegable">
                <a href="#">Hombre</a>
                <ul class="submenu">
                    <br>  <br>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/CAMISETAS_H.PHP">Camisetas</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/CHAQUETAS_H.PHP">Chaquetas</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/PANTALONES_H.PHP">Pantalones</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/SHORTS_H.PHP">Shorts</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/BLAZER_H.PHP">Blazer y Gaban</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/BUZOS_H.PHP">Buzos</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/CAMISAS_H.PHP">Camisas</a></li>
                    <li><a href="../VENDEDOR_ROPA_HOMBRE/ROPA_INTERIOR_H.PHP">Ropa Interior</a></li>
                </ul>
            </div>

            <!-- Menú Mujer -->
            <div class="desplegable">
                <a href="#categorias">Mujer</a>
                <ul class="submenu">
                <br>  <br>
                    <li><a href="../VENDEDOR_ROPA_MUJER/CAMISETAS_M.PHP">Camisetas</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/CHAQUETAS_M.PHP">Chaquetas</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/PANTALONES_M.PHP">Pantalones</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/BLAZER_M.PHP">Blazer y Gaban</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/CAMISAS_M.PHP">Camisas</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/ROPS_INTERIOR_M.PHP">Ropa Interior</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/VESTIDOS_M.PHP">Vestidos</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/BLUSAS_M.PHP">Blusas</a></li>
                    <li><a href="../VENDEDOR_ROPA_MUJER/BUZOS_M.PHP">Buzos</a></li>
                </ul>
            </div>

            <!-- Menú Accesorios -->
            <div class="desplegable">
                <a href="#">Accesorios</a>
                <ul class="submenu">
                <br>  <br>
                    <li><a href="../VENDEDOR_ACCESORIOS/GAFAS.PHP">Gafas</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/CINTURON.PHP">Cinturón</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/PAÑUELOS.PHP">Pañuelos</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/BUFANDAS.PHP">Bufandas</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/GUANTES.PHP">Guantes</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/CORBATAS.PHP">Corbatas</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/ARETES.PHP">Aretes</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/ANILLOS.PHP">Anillos</a></li>
                    <li><a href="../VENDEDOR_ACCESORIOS/COLLARES.PHP">Collares</a></li>
                </ul>
            </div>

            <!-- Menú Otros -->
            <div class="desplegable">
                <a href="#">Otros</a>
                <ul class="submenu">
                <br>  <br>
                    <li><a href="../OTRO_VENDEDOR/INTERFAZ_VENDEDOR.PHP">Personal</a></li>
                    <li><a href="../OTRO_VENDEDOR/PROVEEDORES.PHP">Proveedores</a></li>

                    <li><a href="../OTRO_VENDEDOR/ENTREGA.PHP">Entregas</a></li>
                    <li><a href="../PEDIDOS/PEDIDOS.PHP">Pedidos</a></li>
                    <li><a href="../OTRO_VENDEDOR/PRODUCTOS.PHP">Productos</a></li>

                    <li><a href="../OTRO_VENDEDOR/OFERTA_M_J.PHP">Agregar Oferta</a></li>
                    <li><a href="../OTRO_VENDEDOR/COLECCIONES_H_.PHP">Agregar Colección</a></li>
                </ul>
            </div>

            <!-- Botón Cerrar Sesión -->
            <a href="../INDEX.PHP" class="boton-sesion">Cerrar Sesion</a>
        </div>
    </nav>
</header>

<main>
    <!-- Contenido principal aquí -->
</main>

</body>
</html>
