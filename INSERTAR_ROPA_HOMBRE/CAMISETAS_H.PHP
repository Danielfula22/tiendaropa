<?php
include('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Paginación
$SQL_REGISTROS = mysqli_query($conexion, "SELECT COUNT(*) AS TOTAL FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Camisetas Hombre')");
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
    <title>Catálogo de Prendas</title>
    <link href="../ESTILOS/CATALOGO_PRUEBA.CSS" rel="stylesheet">
    <link href="../ESTILOS/MAS_IMPORTANTES.CSS" rel="stylesheet">
    <link href="../CSS_BOTONES/actualizar_eliminar.css" rel="stylesheet">
    <link href="../CSS_BOTONES/actualizar_eliminar_prendas.css" rel="stylesheet">
    <style>
        .tallas-container {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .talla {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<?php include('../INCLUDE/HEADER_ADMINSTRADOR.PHP'); ?>
<br>


<center>
    <h1>CAMISETAS HOMBRE</h1>
</center><br>
<div class="catalogo-container">
    <?php
    // Consultar los registros de tipo "Camisetas" con paginación
    $CONSULTA = "SELECT * FROM prenda WHERE ID_Tipo_prenda IN (SELECT ID_Tipo_prenda FROM tipo_prenda WHERE Nombre = 'Camisetas Hombre') LIMIT $DESDE, $POR_PAGINA";
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
            <img src="<?php echo $IMAGEN; ?>" alt="<?php echo $NOMBRE; ?>" class="producto-imagen">
            <div class="producto-info">
                <h3 class="producto-nombre"><?php echo $NOMBRE; ?></h3>
                <div class="tallas-container">
                    <?php foreach ($TALLAS as $TALLA) { ?>
                        <div class="talla-wrapper">
                            <div class="talla" id="talla-<?php echo $ID_PRENDA . '-' . $TALLA; ?>" data-id-prenda="<?php echo $ID_PRENDA; ?>" data-talla="<?php echo $TALLA; ?>">
                                <?php echo $TALLA; ?>
                                <span class="cantidad" id="cantidad-<?php echo $ID_PRENDA . '-' . $TALLA; ?>">0</span>
                            </div>
                            <div class="botones-cantidad">
                                <button class="btn-cantidad" onclick="cambiarCantidad('<?php echo $ID_PRENDA; ?>', '<?php echo $TALLA; ?>', 1)">+</button>
                                <button class="btn-cantidad" onclick="cambiarCantidad('<?php echo $ID_PRENDA; ?>', '<?php echo $TALLA; ?>', -1)">-</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <p class="producto-color">Color: <?php echo $COLOR; ?></p>
                <p class="producto-precio">Precio: $<?php echo number_format($COSTO, 2); ?></p>

                <!-- Nuevo contador debajo del precio -->
                <p class="producto-contador"><strong>Total en tallas:</strong> <span id="contador-<?php echo $ID_PRENDA; ?>">0</span></p>

 <!-- Stock oculto -->
 <p class="producto-stock" id="stock-<?php echo $ID_PRENDA; ?>" style="display: none;">Disponibles: <?php echo $STOCK; ?></p>
                <div class="acciones">
                    <button class="btn-actualizar" onclick="window.location.href='../EILIMINAR_ACTUALIZAR_PRENDAS/ACTUALIZAR_PRENDAS.PHP?ID=<?php echo $ID_PRENDA; ?>'">Actualizar</button>
                    <a href="../EILIMINAR_ACTUALIZAR_PRENDAS/ELIMINAR_PRENDAS.PHP?ID=<?php echo $ID_PRENDA; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta prenda?')" class="btn-eliminar">Eliminar</a>
                </div>
                <div class="acciones-cancelar">
                    <button class="btn-cancelar" onclick="cancelarTodasTallas('<?php echo $ID_PRENDA; ?>')">&#x26D4; Cancelar</button>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Tarjeta de Agregar Nueva Prenda -->
    <div class="producto-card">
        <img src="../IMAGENES/mas.png" alt="Agregar nueva prenda" class="producto-imagen">
        <div class="producto-info">
            <h3 class="producto-nombre">Agregar Nuevo Pantalón</h3>
            <div class="acciones">
                <button class="btn-agregar" onclick="window.location.href='../FORMULARIO_INSER_CAMISETAS/CAMISETAS_HOMBRE.PHP'">Agregar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    actualizarCantidades();
});

function cambiarCantidad(idPrenda, talla, cambio) {
    let clave = `cantidad-${idPrenda}-${talla}`;
    let cantidadElement = document.getElementById(clave);
    let cantidad = parseInt(cantidadElement.textContent) || 0;

    cantidad = Math.max(0, cantidad + cambio);
    cantidadElement.textContent = cantidad;

    let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
    if (!cantidades[idPrenda]) {
        cantidades[idPrenda] = {};
    }
    cantidades[idPrenda][talla] = cantidad;
    localStorage.setItem('cantidades', JSON.stringify(cantidades));

    actualizarContadorTotal(idPrenda);
}

function actualizarCantidades() {
    let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
    for (let idPrenda in cantidades) {
        for (let talla in cantidades[idPrenda]) {
            let clave = `cantidad-${idPrenda}-${talla}`;
            let cantidadElement = document.getElementById(clave);
            if (cantidadElement) {
                cantidadElement.textContent = cantidades[idPrenda][talla];
            }
        }
        actualizarContadorTotal(idPrenda);
    }
}

function actualizarContadorTotal(idPrenda) {
    let total = 0;
    let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
    if (cantidades[idPrenda]) {
        for (let talla in cantidades[idPrenda]) {
            total += cantidades[idPrenda][talla];
        }
    }
    let contadorElement = document.getElementById(`contador-${idPrenda}`);
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}

function cancelarTodasTallas(idPrenda) {
    let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
    if (cantidades[idPrenda]) {
        for (let talla in cantidades[idPrenda]) {
            cantidades[idPrenda][talla] = 0;
            let clave = `cantidad-${idPrenda}-${talla}`;
            let cantidadElement = document.getElementById(clave);
            if (cantidadElement) {
                cantidadElement.textContent = 0;
            }
        }
    }
    localStorage.setItem('cantidades', JSON.stringify(cantidades));
    actualizarContadorTotal(idPrenda);
}
</script>


<style>
/* Contenedor del catálogo */
.catalogo-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    padding: 20px;
}

/* Estilo de cada tarjeta de producto */
.producto-card {
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #fff;
}

.producto-imagen {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.producto-info {
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.producto-nombre {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

.producto-color {
    font-size: 14px;
    color: #666;
}

.tallas-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin: 10px 0;
}

.talla-wrapper {
    text-align: center;
}

.talla {
    background-color: #f1f1f1;
    padding: 5px;
    border-radius: 5px;
    cursor: pointer;
}

.talla:hover {
    background-color: #ddd;
}

.botones-cantidad {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.btn-cantidad {
    background-color: #ddd;
    border: none;
    padding: 5px;
    cursor: pointer;
    border-radius: 5px;
}

.producto-precio {
    font-size: 16px;
    font-weight: bold;
    margin: 10px 0;
}

.producto-stock {
    font-size: 14px;
    color: #666;
}

.acciones {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.btn-actualizar, .btn-eliminar {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.btn-actualizar:hover, .btn-eliminar:hover {
    background-color: #2980b9;
}

.acciones-cancelar {
    margin-top: 10px;
    text-align: center;
}

.btn-cancelar {
    font-size: 14px;
    padding: 5px 10px;
    background-color:rgb(168, 153, 152);
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.btn-cancelar:hover {
    background-color: #c0392b;
}
</style>









<style>
    .talla.sin-stock {
        text-decoration: line-through;
        color: red;
    }
</style>


<style>
.tallas-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.talla-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 60px;
    position: relative;
}

.talla {
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
    position: relative;
    width: 100%;
}

.cantidad {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff5722;
    color: white;
    font-size: 12px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.botones-cantidad {
    display: flex;
    gap: 5px;
    margin-top: 5px;
}

.btn-cantidad {
    background: #007bff;
    color: white;
    border: none;
    padding: 4px 6px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
}

.btn-cantidad:hover {
    background: #0056b3;
}

.acciones {
    margin-top: 12px;
}

.btn-actualizar, .btn-eliminar {
    padding: 6px 12px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-actualizar {
    background: #28a745;
    color: white;
}

.btn-eliminar {
    background: #dc3545;
    color: white;
}

.btn-actualizar:hover {
    background: #218838;
}

.btn-eliminar:hover {
    background: #c82333;
}
</style>



<style>
/* Estilo general */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

/* Contenedor del catálogo */
.catalogo-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

/* Estilo de las tarjetas de producto */
.producto-card {
    width: 250px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
}

.producto-imagen {
    width: 100%;
    height: auto;
    border-bottom: 1px solid #eee;
}

.producto-info {
    padding: 15px;
}

.producto-nombre {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.producto-color {
    color: #777;
}

.producto-precio, .producto-stock {
    font-size: 16px;
    margin-top: 10px;
}

/* Estilo de los botones de acción */
.acciones {
    margin-top: 20px;
}

button, .btn-eliminar {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-actualizar {
    background-color: #4CAF50;
    color: white;
    border: none;
    margin-right: 10px;
}

.btn-actualizar:hover {
    background-color: #45a049;
}

.btn-eliminar {
    background-color: #f44336;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
}

.btn-eliminar:hover {
    background-color: #e53935;
}

.btn-agregar {
    background-color: #1e88e5;
    color: white;
    border: none;
}

.btn-agregar:hover {
    background-color: #1976d2;
}

/* Estilo para las tallas */
.tallas-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.talla {
    padding: 8px 15px;
    background-color: #e0e0e0;
    border-radius: 20px;
    cursor: pointer;
}

.talla:hover {
    background-color: #bdbdbd;
}

/* Estilo para marcar una talla como agotada */
.agotado {
    text-decoration: line-through;
    color: red;
    cursor: not-allowed;
}
</style>







    <!-- DETALLES DE LA CAMPANITA COMLPLETA (NOTIFICACIONES) -->


<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "tienda de ropa";

// Conectar a la base de datos
$conn = new mysqli($servidor, $usuario, $password, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$notificaciones = [];

// Obtener solo las notificaciones no leídas (estado = 0)
$sql = "SELECT n.ID_Notificacion, n.mensaje, n.fecha, CONCAT(u.Nombre, ' ', u.Apellido) AS Comprador 
        FROM notificaciones n
        JOIN usuario u ON u.ID_Usuario = n.ID_Usuario
        WHERE n.estado = 0 
        ORDER BY n.fecha DESC";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if (strpos($row['mensaje'], 'has realizado una compra') !== false) {
            $row['mensaje'] = "🛒 Nueva compra realizada por " . $row['Comprador'];
        } elseif (strpos($row['mensaje'], 'tu pedido ha sido enviado') !== false) {
            $row['mensaje'] = "📦 Tu pedido ha sido enviado";
        } else {
            $row['mensaje'] = "🔔 Nueva notificación";
        }
        
        $row['mensaje'] .= " el " . date("d-m-Y H:i", strtotime($row['fecha']));
        $notificaciones[] = $row;
    }
} else {
    error_log("Error en la consulta SQL: " . $conn->error);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .notificaciones-container {
            position: absolute;
            cursor: pointer;
            z-index: 1000;
        }
        
        .icono-notificacion {
            font-size: 29px;
            position: relative;
        }
        .icono-notificacion .contador {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 4px 7px;
            border-radius: 50%;
        }

        /* 📌 LISTA DE NOTIFICACIONES MEJORADA */
        .lista-notificaciones {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: fadeIn 0.3s ease-in-out;
            padding: 10px;
            transition: all 0.3s ease-in-out;
            max-height: 400px; /* Evita que se salga de la pantalla */
            overflow-y: auto;
        }

        .lista-notificaciones ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lista-notificaciones li {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            transition: background 0.3s;
        }

        .lista-notificaciones li:hover {
            background: #f5f5f5;
        }

        .lista-notificaciones p {
            margin: 0;
            color: #333;
        }

        .botones-notificaciones {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
        }

        .boton-notificacion {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease-in-out;
        }

        .descartar-todas {
            background: #d9534f;
            color: white;
        }

        .descartar-todas:hover {
            background: #c9302c;
        }

        .ir-notificaciones {
            background: #0275d8;
            color: white;
        }

        .ir-notificaciones:hover {
            background: #0256a3;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 📱 MODO RESPONSIVO - LISTA ADAPTADA PARA CELULARES */
        @media (max-width: 768px) {
            .notificaciones-container {
                top: 32px;
                right: 39px;
            }
            .icono-notificacion {
                font-size: 22px;
            }
            .icono-notificacion .contador {
                font-size: 10px;
                padding: 2px 4px;
            }
            .lista-notificaciones {
                position: fixed; /* Fija la lista en la pantalla */
                top: 70px; /* Espacio debajo de la barra superior */
                left: 5%;
                right: 5%;
                width: 90%;
                max-height: 60vh; /* No se desborda la pantalla */
                overflow-y: auto;
                z-index: 1050;
            }
        }
        
        @media (min-width: 769px) {
            .notificaciones-container {
                top: 24px;
                right: 1320px;
            }
        }
    </style>
</head>
<body>
<div class="notificaciones-container" onclick="toggleNotificaciones()">
    <span class="icono-notificacion">🔔
        <span class="contador" id="contador"><?= count($notificaciones) ?></span>
    </span>
    <div id="lista-notificaciones" class="lista-notificaciones">
        <?php if (empty($notificaciones)): ?>
            <p id="sin-notificaciones" style="padding: 15px; text-align: center; color: gray;">
                No hay notificaciones en este momento.
            </p>
        <?php else: ?>
            <ul id="notificaciones-lista">
                <?php foreach ($notificaciones as $notif): ?>
                    <li>
                        <p><?= htmlspecialchars($notif['mensaje']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div id="botones-notificaciones" class="botones-notificaciones">
                <button class="boton-notificacion descartar-todas" onclick="descartarTodas()">Descartar todas</button>
                <button class="boton-notificacion ir-notificaciones" onclick="irANotificaciones()">Ir a las Compras</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleNotificaciones() {
        let lista = document.getElementById('lista-notificaciones');
        let contador = document.getElementById('contador').innerText.trim();
        if (contador !== "0") {
            lista.style.display = (lista.style.display === 'block') ? 'none' : 'block';
        }
    }

    function irANotificaciones() {
        window.location.href = '../FACTURACION/FINALIZARFACTURA.PHP'; 
    }

    function descartarTodas() {
        $.ajax({
            url: 'descartar_notificaciones.php',
            method: 'POST',
            success: function(response) {
                if (response.trim() === "success") {
                    $('#notificaciones-lista').html('');
                    $('#contador').text('0');
                    $('#sin-notificaciones').show(); 
                    $('#botones-notificaciones').hide(); 
                } else {
                    alert("Error al descartar notificaciones.");
                }
            }
        });
    }
</script>
</body>
</html>
