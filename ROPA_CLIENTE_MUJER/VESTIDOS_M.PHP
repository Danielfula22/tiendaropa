<?php
// Desactivar la visualización de errores
error_reporting(0);
ini_set('display_errors', 0);

session_start(); // Ahora puedes iniciar la sesión sin problemas
?>

<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Vestidos')");
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
    <title>VESTIDO MUJER</title>

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

    
<!-- CSS  para ocultar los botone de las tallas-->
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
</head>
<body>
    <header>
        <!-- Logo -->
        <a href="#" class="logo">Elegance</a>

        <!-- Menú de Navegación -->
        <nav>

        
        <!-- Botones de Iniciar Sesión y Registrarse -->
    <div class="botones-sesion">
    <a href="../INDEX.PHP" class="boton-sesion">Cerrar Sesión</a>
    </div>
    <a href="../ROLES/INICIO_CLIENTES.PHP">Inicio</a>
    <div class="desplegable">
                <a href="#">
                     Hombre
                    <span class="desplegable-icono">&#9662;</span>
                </a>
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
                <a href="#">
                     Mujer
                    <span class="desplegable-icono">&#9662;</span>
                </a>
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
                <a href="#">
                     Accesorios
                    <span class="desplegable-icono">&#9662;</span>
                </a>
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



            <a href="#contacto">Contacto</a>

            <a href="../FAVORITOS.PHP" class="icono">
                <i>&#9825;</i> Favoritos
            </a>
        </nav>

       
         <br>
        <!-- Iconos de acciones -->
        <div class="menu-acciones">
            <a href="../CARRITO.PHP" class="icono">
            <h2>VESTIDOS DE MUJER</h2>            </a>
            
        </div>


    <!-- Ícono del Perfil -->

    <div id="icono-carrito">
<?php include('../INCLUDE/header_carrito.php'); ?>
</div>

 <!-- Mini icono de perfil -->
 <div class="icono-perfil">
        <?php include('../INCLUDE/header_perfil.php'); ?>
    </div>

    <style>
        .icono-perfil {
    position: absolute;
    top: 20px;
    right: 35px;
    width: 40px;
    height: 40px;
}
.icono-perfil img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}


.icono-carrito{
    position: absolute;
    top: 56px;
   
}

    </style>
</header>

   
    
<div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Vestidos" con paginación
    $CONSULTA = "SELECT * FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Vestidos') LIMIT $DESDE, $POR_PAGINA";
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
                <h3 class="producto-nombre"><?php echo $NOMBRE; ?></h3>
                <div class="tallas-container">
                    <?php foreach ($TALLAS as $TALLA) { ?>
                        <div class="talla-cantidad-container">
                            <label class="talla" data-id-prenda="<?php echo $ID_PRENDA; ?>" id="talla-<?php echo $ID_PRENDA; ?>-<?php echo $TALLA; ?>">
                                <input type="radio" name="talla-<?php echo $ID_PRENDA; ?>" value="<?php echo $TALLA; ?>" <?php echo $TALLA === 'M' ? 'checked' : ''; ?> disabled>
                                <?php echo $TALLA; ?>
                                <span class="cantidad" id="cantidad-<?php echo $ID_PRENDA . '-' . $TALLA; ?>"><?php echo $STOCK; ?></span>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <p class="producto-color"><strong>Color:</strong> <?php echo $COLOR; ?></p>
    
                <p class="producto-precio"><strong>Precio:</strong> $<?php echo number_format($COSTO, 0, ',', '.'); ?></p>
    
                 <!-- Stock oculto -->
    
                <p class="producto-stock" style="display: none;"><strong>Disponibles:</strong> <?php echo $STOCK; ?></p>
    
                <?php if ($STOCK > 0) { ?>
                <div class="contador">
                    <button class="btn-disminuir" onclick="disminuirCantidad(this)">-</button>
                    <input type="number" class="input-cantidad" value="1" min="1">
                    <button class="btn-aumentar" onclick="aumentarCantidad(this, '<?php echo $ID_PRENDA; ?>', document.querySelector('input[name=\'talla-<?php echo $ID_PRENDA; ?>\']:checked').value)">+</button>
                </div>
    
                <button class="btn-agregar" 
                    onclick="agregarYDescontarStock(this, 
                        '<?php echo $NOMBRE; ?>', 
                        <?php echo $COSTO; ?>, 
                        '<?php echo $COLOR; ?>', 
                        document.querySelector('input[name=\'talla-<?php echo $ID_PRENDA; ?>\']:checked').value, 
                        '<?php echo $STOCK; ?>', 
                        '<?php echo $IMAGEN; ?>', 
                        this.previousElementSibling.querySelector('.input-cantidad').value,
                        '<?php echo $ID_PRENDA; ?>'
                    )">Agregar al carrito</button>
    
                <?php } else { ?>
                    <br><br>
                <p class="sin-stock-texto">Este producto no está disponible actualmente.</p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        actualizarCantidades();
    });
    
    function actualizarCantidades() {
        let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
        for (let idPrenda in cantidades) {
            for (let talla in cantidades[idPrenda]) {
                let clave = `cantidad-${idPrenda}-${talla}`;
                let cantidadElement = document.getElementById(clave);
                if (cantidadElement) {
                    cantidadElement.textContent = cantidades[idPrenda][talla];
                    verificarStock(idPrenda, talla, cantidades[idPrenda][talla]);
                }
            }
        }
    }
    
    function verificarStock(idPrenda, talla, cantidad) {
        let clave = `talla-${idPrenda}-${talla}`;
        let tallaElement = document.getElementById(clave);
        let inputElement = tallaElement.querySelector('input');
        if (cantidad === 0) {
            tallaElement.classList.add('sin-stock');
            inputElement.disabled = true;
            tallaElement.style.pointerEvents = "none";
        } else {
            tallaElement.classList.remove('sin-stock');
            inputElement.disabled = false;
            tallaElement.style.pointerEvents = "auto";
        }
    }
    
    function disminuirCantidad(boton) {
        let input = boton.nextElementSibling;
        let valor = parseInt(input.value);
        if (valor > 1) {
            input.value = valor - 1;
        }
    }
    
    function aumentarCantidad(boton, idPrenda, talla) {
        let input = boton.previousElementSibling;
        let valor = parseInt(input.value);
        let stockDisponible = parseInt(document.getElementById(`cantidad-${idPrenda}-${talla}`).textContent);
        if (valor < stockDisponible) {
            input.value = valor + 1;
        }
    }
    
    function agregarYDescontarStock(boton, nombre, costo, color, talla, stock, imagen, cantidad, idPrenda) {
        addToCart(nombre, costo, color, talla, stock, imagen, cantidad, idPrenda);
        
        let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
        if (!cantidades[idPrenda]) {
            cantidades[idPrenda] = {};
        }
        if (!cantidades[idPrenda][talla]) {
            cantidades[idPrenda][talla] = stock;
        }
        cantidades[idPrenda][talla] = Math.max(0, cantidades[idPrenda][talla] - cantidad);
        localStorage.setItem('cantidades', JSON.stringify(cantidades));
        actualizarCantidades();
    }
    
    
    </script>
    
    