<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Pantalones Hombre')");
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

$POR_PAGINA = 15;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANTALONES HOMBRE</title>

         <!-- ESTILOS GENERALES -->

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
    <link href="../ESTILOS/SEGUNDOS _ESTILOS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../ESTILOS/iniciar_sesion.css" rel="stylesheet">
    <link href="../ESTILOS/estilos del loguin.css" rel="stylesheet">
    <link href="../CSS_BOTONES/agregar_carrito.css" rel="stylesheet">
    <link href="../estilos_cliente/estilos menu.css" rel="stylesheet">
    <link href="../cliente.css" rel="stylesheet">
    <link href="../ROPA_CLIENTE_HOMBRE/estilos_generales_ropa_h.css" rel="stylesheet">






</head>
<body>

<style>
        body {
            font-family: 'Georgia', serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f0f0f0, #d1d1d1); /* Fondo suave y elegante */
            background-size: cover;
        }

        header {
            background: linear-gradient(135deg, #1a1a1a, #333333); /* Fondo con un toque moderno */
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            transition: all 0.3s ease;
            border-bottom: 5px solid #b2976b;
        }

        header:hover {
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-size: 2.5em;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
            color: #f2f2f2;
        }

        nav {
            display: flex;
            gap: 40px;
        }

        nav a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: color 0.3s ease, border-bottom 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
        }

        nav a:hover {
            color: #ffffff;
            background-color: #b2976b;
            border-bottom: 2px solid #ffffff;
            transform: scale(1.1);
        }

        .desplegable {
            position: relative;
        }

        .desplegable > a {
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .desplegable > a:hover {
            color: #ffffff;
        }

        .desplegable-icono {
            margin-left: 6px;
            font-size: 1.2em;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .desplegable:hover .desplegable-icono {
            transform: rotate(180deg);
        }

        .submenu {
            display: none;
            position: absolute;
            top: 50px;
            left: 0;
            background-color: #444444;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
            min-width: 240px;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .submenu li {
            list-style: none;
        }

        .submenu li a {
            display: block;
            padding: 12px 20px;
            color: #dcdcdc;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        .submenu li a:hover {
            background-color: #555555;
            color: #ffffff;
            transform: translateX(10px);
        }

        .desplegable:hover .submenu {
            display: block;
        }

        .menu-acciones {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .icono {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 1.3em;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .icono:hover {
            color: #ffffff;
            transform: scale(1.1);
        }

        .icono i {
            font-size: 1.7em;
        }

        /* Estilo para sección de colecciones */
        .coleccion {
            color: #ffffff;
            font-size: 1.4em;
            font-weight: bold;
            margin-top: 20px;
            display: flex;
            gap: 50px;
            justify-content: center;
        }

        .coleccion a {
            color: #e0e0e0;
            text-decoration: none;
            padding: 12px 24px;
            background-color: #333333;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .coleccion a:hover {
            background-color: #b2976b;
            color: #ffffff;
            transform: scale(1.05);
        }

        /* Diseño responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                gap: 20px;
            }

            nav {
                flex-wrap: wrap;
                gap: 20px;
            }

            .submenu {
                top: 40px;
            }

            .coleccion {
                flex-direction: column;
                gap: 20px;
            }
        }
        
    </style>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance - Tienda de Ropa Formal</title>
    <style>
      
    </style>
</head>
<body>
<header>
        <!-- Logo -->
        <a href="#" class="logo">Elegance</a>


        <!-- Menú de Navegación -->
        <nav>
            
          <!-- Botones de Iniciar Sesión y Registrarse -->
          <div class="botones-sesion">
            <a href="#" class="boton-sesion" onclick="openLoginModal()">Iniciar Sesión</a>
            <a href="#" class="boton-sesion" onclick="openRegisterModal()">Registrarse</a>
        </div>
            <a href="../INDEX.PHP">Inicio</a>
            <div class="desplegable">
                <a href="#">
                     Hombre
                    <span class="desplegable-icono">&#9662;</span>
                </a>
                <ul class="submenu">
                <li><a href="../ROPA HOMBRE/CAMISETAS_H.PHP">Camisetas</a></li>
                    <li><a href="../ROPA HOMBRE/CHAQUETAS_H.PHP">Chaquetas</a></li>
                    <li><a href="../ROPA HOMBRE/JEANS_H.PHP">Pantalones</a></li>
                    <li><a href="../ROPA HOMBRE/SHORTS_H.PHP">Shorts</a></li>
                    <li><a href="../ROPA HOMBRE/BLAZER_H.PHP">Gaban Y Blazer</a></li>
                    <li><a href="../ROPA HOMBRE/BUZOS_H.PHP">Buzos</a></li>
                    <li><a href="../ROPA HOMBRE/CAMISAS_H.PHP">Camisas</a></li>
                    <li><a href="../ROPA HOMBRE/ROPA_INTERIOR_H.PHP">Ropa Interior</a></li>
                </ul>
            </div>
            <div class="desplegable">
                    <a href="#categorias">Mujer</a>
                    <ul class="submenu">
                    <li><a href="../ROPA MUJER/CAMISETAS_M.PHP">Camisetas</a></li>
                <li><a href="../ROPA MUJER/CHAQUETAS_M.PHP">Chaquetas</a></li>
                <li><a href="../ROPA MUJER/JEANS_M.PHP">Pantalones</a></li>
                <li><a href="../ROPA MUJER/BLAZER_M.PHP">Blazer y Gaban</a></li>
                <li><a href="../ROPA MUJER/CAMISAS_M.PHP">Camisas</a></li>
                <li><a href="../ROPA MUJER/ROPA_INT_M.PHP">Ropa Interior</a></li>
                    <li><a href="../ROPA MUJER/VESTIDOS_M.PHP">Vestidos</a></li>
                    <li><a href="../ROPA MUJER/BLUSAS_M.PHP">Blusas</a></li>
                    <li><a href="../ROPA MUJER/BUZOS_M.PHP">Buzos</a></li>

                    </ul>
                </div>
                <div class="desplegable">
                    <a href="#contacto">Accesorios</a>

                    <ul class="submenu">
                    <li><a href="../ACCESORIOS/ACCESORIOS.PHP">Gafas</a></li>
                    <li><a href="../ACCESORIOS/CINTURON.PHP">Cinturón</a></li>
                    <li><a href="../ACCESORIOS/PAÑUELOS.PHP">Pañuelos</a></li>
                    <li><a href="../ACCESORIOS/BUFANDAS.PHP">Bufandas</a></li>
                    <li><a href="../ACCESORIOS/GUANTES.PHP">Guantes</a></li>
                    <li><a href="../ACCESORIOS/CORBATAS.PHP">Corbatas</a></li>
                    <li><a href="../ACCESORIOS/ARETES.PHP">Aretes</a></li>
                    <li><a href="../ACCESORIOS/ANILLOS.PHP">Anillos</a></li>
                    <li><a href="../ACCESORIOS/COLLARES.PHP">Collares</a></li>
                    </ul>
                </div>
                <div class="contacto">
                    <a href="#accesorios">Contacto</a>

                    <ul class="submenu">
                        <li><a href="#ayuda">Ayuda</a></li>
                        <li><a href="#ubicacion">Ubicación</a></li>
                        <li><a href="#email">Email</a></li>
        </nav>

            <!-- Iconos de acciones -->
            <div class="menu-acciones">
    <a href="../CARRITO.PHP" class="icono" onclick="return verificarSesion(event)">
        <i>&#128722;</i> Carrito
    </a>
    
            <a href="#" class="icono" onclick="mostrarFavoritos(); return false;">
    <i>&#9825;</i> Favoritos
</a>
            
        </div>
    </header>

     <!-- Modal para Iniciar Sesión -->
<div class="modal" id="loginModal">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../LOGIN/LOGUIN.PHP">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</div>

<!-- Modal para Registrarse -->
<div class="modal" id="registerModal">
    <div class="modal-content">
        <span class="close" onclick="closeRegisterModal()">&times;</span>
        <h2>Registrar Nuevo Usuario</h2>
        <form method="POST" action="../REPORTES/procesar_reguistro.php">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="N_Documento" placeholder="Número de documento" required>
            <input type="text" name="direccion" placeholder="Dirección" required>
            <input type="text" name="ciudad" placeholder="Ciudad" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
    </div>
</div>

<!-- CSS -->
<style>
    .modal {
        display: none; /* Oculto por defecto */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Fondo oscuro semitransparente */
        z-index: 1000; /* Para que esté sobre todo */
        justify-content: center;
        align-items: center;
    }
    
    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
</style>

<!-- JavaScript -->
<script>
    function openRegisterModal() {
        document.getElementById("registerModal").style.display = "flex";
    }

    function closeRegisterModal() {
        document.getElementById("registerModal").style.display = "none";
    }
</script>

<script>
    function openLoginModal() {
        document.getElementById('loginModal').style.display = 'flex';
    }
    function closeLoginModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    function openRegisterModal() {
        document.getElementById('registerModal').style.display = 'flex';
    }
    function closeRegisterModal() {
        document.getElementById('registerModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('loginModal')) {
            closeLoginModal();
        }
        if (event.target == document.getElementById('registerModal')) {
            closeRegisterModal();
        }
    }
</script>

   

    <br><br><br>


    <div class="catalogo-container">
<?php
$CONSULTA = "SELECT * FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Pantalones Hombre') LIMIT $DESDE, $POR_PAGINA";
$EJECUTAR = mysqli_query($conexion, $CONSULTA);

while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
    $ID_PRENDA = $FILA['ID_Prenda'];
    $NOMBRE = $FILA['Nombre'];
    $COLOR = $FILA['Color'];
    $COSTO = $FILA['Costo'];
    $STOCK = $FILA['Stock'];
    $IMAGEN = "../IMAGENES/" . $FILA['Foto'];
    $TALLAS = ['S', 'M', 'L', 'XL', 'XXL'];
?>
    <div class="producto-card">
        <div class="producto-imagen-container">
            <img src="<?php echo $IMAGEN; ?>" alt="<?php echo $NOMBRE; ?>" class="producto-imagen">
        </div>
        <div class="producto-info">
            <h3 class="producto-nombre"> <?php echo $NOMBRE; ?> </h3>
            <div class="tallas-container">
                <?php foreach ($TALLAS as $TALLA) { ?>
                    <label class="talla" data-id-prenda="<?php echo $ID_PRENDA; ?>">
                        <input type="radio" name="talla-<?php echo $ID_PRENDA; ?>" value="<?php echo $TALLA; ?>" <?php echo $TALLA === 'M' ? 'checked' : ''; ?>>
                        <?php echo $TALLA; ?>
                    </label>
                <?php } ?>
            </div>
            <div class="producto-detalle">
                <p class="producto-color"><strong>Color:</strong> <?php echo $COLOR; ?></p>
                <p class="producto-precio"><strong>Precio:</strong> $<?php echo number_format($COSTO, 0, ',', '.'); ?></p>
            </div>
          
            <div class="botones-container">
    <button class="btn-agregar" onclick="mostrarVentana()">Agregar al carrito</button>
    <button class="btn-favorito" onclick="toggleFavorito(this, '<?php echo $ID_PRENDA; ?>', '<?php echo $NOMBRE; ?>', '<?php echo $COLOR; ?>', '<?php echo $COSTO; ?>', '<?php echo $IMAGEN; ?>')">
        &#9829;
    </button>
</div>

</div>
</div>
<?php } ?>
</div>

<!-- Ventana emergente de favoritos -->
<div class="modal-favoritos" id="modalFavoritos">
    <div class="contenido-favoritos">
        <h2>Prendas en Favoritos</h2>
        <div id="listaFavoritos"></div>
        <button class="btn-cerrar-favoritos" onclick="cerrarFavoritos()">Cerrar</button>
    </div>
</div>

<script>
    let favoritos = [];
    
    function toggleFavorito(button, idPrenda, nombre, color, costo, imagen) {
        button.classList.toggle('favorito-activo');
        let index = favoritos.findIndex(prenda => prenda.id === idPrenda);
        if (index !== -1) {
            favoritos.splice(index, 1);
        } else {
            favoritos.push({ id: idPrenda, nombre, color, costo, imagen });
        }
        actualizarListaFavoritos();
    }
    
    function mostrarFavoritos() {
        document.getElementById('modalFavoritos').classList.add('activo');
        actualizarListaFavoritos();
    }

    function cerrarFavoritos() {
        document.getElementById('modalFavoritos').classList.remove('activo');
    }

    function actualizarListaFavoritos() {
        let lista = document.getElementById('listaFavoritos');
        lista.innerHTML = favoritos.length > 0 ? favoritos.map(prenda => `
            <div class='favorito-item'>
                <img src='${prenda.imagen}' alt='${prenda.nombre}' class='favorito-imagen'>
                <p><strong>${prenda.nombre}</strong></p>
                <div class='favorito-detalle'>
                    <p>Color: ${prenda.color}</p>
                    <p>Precio: $${prenda.costo}</p>
                </div>
            </div>
        `).join('') : '<p>No hay prendas en favoritos.</p>';
    }
</script>

<script>
    function verificarSesion(event) {
        var usuarioLogueado = false;
        if (!usuarioLogueado) {
            event.preventDefault();
            alert("El carrito no está disponible hasta iniciar sesión.");
            return false;
        }
        return true;
    }
</script>

<style>
    .botones-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-favorito {
        background: none;
        border: none;
        font-size: 32px;
        color: gray;
        cursor: pointer;
        margin-left: 19px;
        margin-bottom: -15px;
    }
    .favorito-activo {
        color: red;
    }
    .modal-favoritos {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 400px;
        height: 100vh;
        background: white;
        padding: 20px;
        border-left: 2px solid #ccc;
        box-shadow: -5px 0 10px rgba(0,0,0,0.2);
        overflow-y: auto;
    }
    .modal-favoritos.activo {
        display: block;
    }
    .favorito-item {
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
    }
    .favorito-detalle {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .favorito-imagen {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
    .btn-cerrar-favoritos {
        display: block;
        margin: 10px auto;
        padding: 5px 10px;
        background: red;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<!-- Footer -->
<?php include('../INCLUDE/FOOTER.PHP'); ?>

<!-- Ventana emergente -->
<div class="modal-sesion" id="modalSesion">
    <div class="contenido-sesion">
        <p>Debes iniciar sesión para acceder y poder comprar con nosotros.</p>
        <button class="btn-cerrar-sesion" onclick="cerrarVentana()">Cerrar</button>
    </div>
</div>

<script>
    function mostrarVentana() {
        document.getElementById('modalSesion').classList.add('activo');
    }

    function cerrarVentana() {
        document.getElementById('modalSesion').classList.remove('activo');
    }
</script>
