<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Colecciones')");
$RESULT_REGISTROS = mysqli_fetch_array($SQL_REGISTROS);
$TOTAL = $RESULT_REGISTROS['TOTAL'];

$POR_PAGINA = 15;
$PAGINA = empty($_GET['PAGINA']) ? 1 : $_GET['PAGINA'];
$DESDE = ($PAGINA - 1) * $POR_PAGINA;
$TOTAL_PAGINAS = ceil($TOTAL / $POR_PAGINA);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATEGORIAS DISPONIBLES</title>
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
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../ESTILOS/SEGUNDOS _ESTILOS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../ESTILOS/iniciar_sesion.css" rel="stylesheet">
    <link href="../ESTILOS/estilos del loguin.css" rel="stylesheet">
    <link href="../CSS_BOTONES/agregar_carrito.css" rel="stylesheet">
    <link href="../ESTILOS/footer.css" rel="stylesheet">
</head>
<body>
<!-- HEADER Y MENÚ DE NAVEGACIÓN -->
<header>
    <nav>
        <!-- Botones de Iniciar Sesión y Registrarse -->
        <div class="botones-sesion">
            <a href="#" class="boton-sesion" onclick="openModal()">Iniciar Sesión</a>
            <a href="#registrarse" class="boton-sesion">Registrarse</a>
        </div>
        <!-- Configuración del inicio de sesión -->
        <div class="modal" id="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Iniciar Sesión</h2>
                <form method="POST" action="../LOGIN/LOGUIN.PHP">
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
        <script>
            function openModal() {
                document.getElementById('modal').style.display = 'flex';
            }
            function closeModal() {
                document.getElementById('modal').style.display = 'none';
            }
            window.onclick = function(event) {
                if (event.target == document.getElementById('modal')) {
                    closeModal();
                }
            }
        </script>
        <!-- Links de navegación -->
        <div class="enlaces-nav">
            <a href="../INDEX.PHP">Inicio</a>
            <div class="desplegable">
                <a href="#">Hombre</a>
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
                    </ul>
                </div>
            </div>
            <!-- ...otros menús desplegables... -->
            <a href="https://tu-sitio.com/perfil" class="profile-icon"><i class="fas fa-user"></i></a>
            <div class="icono-carrito" onclick="toggleCart()"><i class="fas fa-shopping-cart"></i><span class="contador-carrito">0</span></div>
        </div>
    </nav>
</header>

<main>
    <br>
    <center><h1>CATEGORIAS DISPONIBLES</h1></center>

    <div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Colecciones" con paginación
    $CONSULTA = "SELECT * FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Colecciones') LIMIT $DESDE, $POR_PAGINA";
    $EJECUTAR = mysqli_query($conexion, $CONSULTA);

    while ($FILA = mysqli_fetch_assoc($EJECUTAR)) {
        $ID_PRENDA = $FILA['ID_Prenda'];
        $NOMBRE = $FILA['Nombre'];
        $COLOR = $FILA['Color'];
        $TALLA = $FILA['Talla'];
        $COSTO = $FILA['Costo'];
        $STOCK = $FILA['Stock'];
        $IMAGEN = "../IMAGENES/" . $FILA['Foto'];
    ?>
        <div class="producto-card">
            <img src="<?php echo $IMAGEN; ?>" alt="<?php echo $NOMBRE; ?>" class="producto-imagen">
            <div class="producto-info">
                <h3 class="producto-nombre"><?php echo $NOMBRE; ?></h3>
                <p class="producto-color"><strong>Color:</strong> <?php echo $COLOR; ?></p>
                <p class="producto-talla"><strong>Talla:</strong> <?php echo $TALLA; ?></p>
                <p class="producto-precio"><strong>Precio:</strong> $<?php echo number_format($COSTO, 2); ?></p>
                <p class="producto-stock"><strong>Stock:</strong> <?php echo $STOCK; ?></p>
                <button class="btn-agregar" onclick="addToCart('<?php echo $NOMBRE; ?>', <?php echo $COSTO; ?>)">Agregar al carrito</button>
            </div>
        </div>
        <?php } ?>
    </div>
</main>

<!-- Carrito de compras -->
<div class="modal-carrito" id="cartModal">
    <button class="btn-cerrar" onclick="toggleCart()">X</button>
    <div class="contenido-carrito">
        <h2>Carrito de Compras</h2>
        <div id="cartItems"></div>
        <div class="total-carrito">
            <strong>Total: $<span id="cartTotal">0.00</span></strong>
        </div>
        <button class="btn-pago" onclick="finalizarCompra()">Finalizar Compra</button>
    </div>
</div>

<script>
    function toggleCart() {
        document.getElementById('cartModal').classList.toggle('activo');
    }

    function addToCart(nombre, precio) {
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');

        const item = document.createElement('div');
        item.className = 'item-carrito';
        item.innerHTML = `
            <div>
                <p>${nombre}</p>
                <p>Precio: $${precio.toFixed(2)}</p>
            </div>
            <button class="btn-eliminar" onclick="eliminarItem(this, ${precio})">Eliminar</button>
        `;
        cartItems.appendChild(item);
        const totalActual = parseFloat(cartTotal.innerText);
        cartTotal.innerText = (totalActual + precio).toFixed(2);

        const contadorCarrito = document.querySelector('.contador-carrito');
        contadorCarrito.innerText = parseInt(contadorCarrito.innerText) + 1;
    }

    function eliminarItem(boton, precio) {
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');

        boton.parentNode.remove();
        const totalActual = parseFloat(cartTotal.innerText);
        cartTotal.innerText = (totalActual - precio).toFixed(2);

        const contadorCarrito = document.querySelector('.contador-carrito');
        contadorCarrito.innerText = parseInt(contadorCarrito.innerText) - 1;
    }

    function finalizarCompra() {
        alert('Compra finalizada. ¡Gracias por su compra!');
        document.getElementById('cartItems').innerHTML = '';
        document.getElementById('cartTotal').innerText = '0.00';
        document.querySelector('.contador-carrito').innerText = '0';
        toggleCart();
    }
</script>

<!-- Footer -->
<?php include('../INCLUDE/FOOTER.PHP'); ?>

</body>
</html>

