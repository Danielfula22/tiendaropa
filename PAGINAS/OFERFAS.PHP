

<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Ofertas')");
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
    <title>BLAZER Y GABAN_HOMBRE</title>
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
    <link href="../ESTILOS/ofertas.css" rel="stylesheet">
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">

</head>
<body>

<style>
     .boton-sesion{
                 background-color: red;   
                 margin-right: 40px; 
               
                }
                </style>

<header>
    <nav>
      <div class="botones-sesion">
                <a href="#iniciar-sesion" class="boton-sesion">Iniciar Sesión</a>
                <a href="#registrarse" class="boton-sesion">Registrarse</a>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="enlaces-nav">
                <a href="../INDEX.PHP">Inicio</a>
                <div class="desplegable">
                    <a href="#">Hombre</a>
                    <ul class="submenu">
                        <li><a href="../ROPA HOMBRE/CAMISAS_H.PHP">Camisas</a></li>
                        <li><a href="../ROPA HOMBRE/BUZOS_H.PHP">Buzos</a></li>
                        <li><a href="../ROPA HOMBRE/CAMISETAS_H.PHP">Camisetas</a></li>
                        <li><a href="../ROPA HOMBRE/JEANS_H.PHP">Jeans</a></li>
                        <li><a href="../ROPA HOMBRE/BLAZER_H.PHP">Blazer y Gaban</a></li>
                        <li><a href="../ROPA HOMBRE/ROPA_INT_H.PHP">Ropa Interior</a></li>
                    </ul>
                </div>
                <div class="desplegable">
                    <a href="#categorias">Mujer</a>
                    <ul class="submenu">
                        <li><a href="../ROPA MUJER/VESTIDOS_M.PHP">Vestidos</a></li>
                        <li><a href="../ROPA MUJER/BLUSAS_M.PHP">Blusas</a></li>
                        <li><a href="../ROPA MUJER/BUZOS_M.PHP">Buzos</a></li>
                        <li><a href="../ROPA MUJER/JEANS_M.PHP">Jeans</a></li>
                        <li><a href="../ROPA MUJER/CAMISETAS_M.PHP">Camisetas</a></li>
                        <li><a href="../ROPA MUJER/BLAZER_M.PHP">Blazer y Gaban</a></li>
                        <li><a href="../ROPA MUJER/CAMISAS_M.PHP">Camisas</a></li>
                        <li><a href="../ROPA MUJER/ROPA_INT_M.PHP">Ropa Interior</a></li>
                    </ul>
                </div>
                <div class="desplegable">
                    <a href="#contacto">Accesorios</a>

                    <ul class="submenu">
                        <li><a href="#ayuda">Gafas</a></li>
                        <li><a href="#ubicacion">Bufanda</a></li>
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
            <!-- Icono de perfil -->
            <a href="https://tu-sitio.com/perfil" class="profile-icon">
                <i class="fas fa-user"></i>
            </a>
            <!-- Icono del carrito -->
            <div class="icono-carrito" onclick="toggleCart()">
                <i class="fas fa-shopping-cart"></i>
                <span class="contador-carrito">0</span>
                &nbsp;&nbsp;
            </div>
        </nav>
    </header>

    <!-- Modal del carrito -->
    <div class="modal-carrito" id="cartModal">
        <div class="contenido-carrito">
            <div class="encabezado-carrito">
                <h2>Carrito de Compras</h2>
                <span class="cerrar-carrito" onclick="toggleCart()">&times;</span>
            </div>
            <div class="items-carrito" id="cartItems"></div>
            <div class="total-carrito">
                <strong>Total: $<span id="cartTotal">0.00</span></strong>
            </div>
            <button class="btn-pago">Proceder al Pago</button>
        </div>
    </div>
    <main>

  
<div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Ofertas" con paginación
    $CONSULTA = "SELECT * FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Ofertas') LIMIT $DESDE, $POR_PAGINA";
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
                <p class="producto-color">Color: <?php echo $COLOR; ?></p>
                <p class="producto-talla">Talla: <?php echo $TALLA; ?></p>
                <p class="producto-precio">Precio: $<?php echo number_format($COSTO, 2); ?></p>
                <p class="producto-stock">Stock: <?php echo $STOCK; ?></p>
                <div class="acciones">
                    <button class="btn-actualizar" onclick="window.location.href='../INSERTAR_OFERTAS/ACTUALIZAR_OFERTAS.PHP?id=<?php echo $ID_PRENDA; ?>'">Actualizar</button>
                    <button class="btn-eliminar" onclick="window.location.href='../INSERTAR_OFERTAS/ELIMINAR_OFERTAS.PHP?id=<?php echo $ID_PRENDA; ?>'">Eliminar</button>
                </div>
            </div>
        </div>
    <?php } ?>

    
    </section>
    </main>


   

<?php include('../INCLUDE/FOOTER.PHP'); ?>
</body>
</html>








<script>
    // Función para alternar la visibilidad del carrito
    function toggleCart() {
        document.getElementById('cartModal').classList.toggle('activo');
    }

    // Función para añadir productos al carrito
    function addToCart(nombre, precio) {
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartCounter = document.querySelector('.contador-carrito'); // Elemento para contar los productos en el carrito

        // Crear un nuevo item en el carrito
        const item = document.createElement('div');
        item.className = 'item-carrito';
        item.innerHTML = `
            <div>
                <p>${nombre}</p> <!-- Nombre de la prenda -->
                <p><strong>$${precio.toFixed(2)}</strong></p> <!-- Precio de la prenda -->
                <button class="btn-eliminar" onclick="removeFromCart(this, ${precio})">Eliminar</button>
            </div>
        `;
        cartItems.appendChild(item);

        // Actualizar el total del carrito
        let total = parseFloat(cartTotal.innerText) + precio;
        cartTotal.innerText = total.toFixed(2);

        // Actualizar el contador del carrito
        const currentCount = parseInt(cartCounter.innerText);
        cartCounter.innerText = currentCount + 1;
    }

    // Función para eliminar productos del carrito
    function removeFromCart(button, precio) {
        const item = button.parentElement.parentElement;
        item.remove();

        const cartTotal = document.getElementById('cartTotal');
        const cartCounter = document.querySelector('.contador-carrito'); // Elemento para contar los productos en el carrito

        // Actualizar el total del carrito
        let total = parseFloat(cartTotal.innerText) - precio;
        cartTotal.innerText = total.toFixed(2);

        // Actualizar el contador del carrito
        const currentCount = parseInt(cartCounter.innerText);
        cartCounter.innerText = currentCount - 1;
    }
</script>


</body>
</html>



