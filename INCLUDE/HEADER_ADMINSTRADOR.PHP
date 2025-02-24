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
    <a href="../ROLES/INICIO_ADM.PHP" style="text-decoration:none; color: white;  font-size: 32px;">ADMINISTRADOR</a>
    </h2>        <!-- Barra de navegación con enlaces -->



    
        <div class="enlaces-nav">




            <!-- Menú Hombre -->
            <div class="desplegable">
                <a href="#">Hombre</a>
                <ul class="submenu">
                    <br>  <br>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/CAMISETAS_H.PHP">Camisetas</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/CHAQUETAS_H.PHP">Chaquetas</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/PANTALONES_H.PHP">Pantalones</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/SHORTS_H.PHP">Shorts</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/BLAZER_H.PHP">Blazer y Gaban</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/BUZOS_H.PHP">Buzos</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/CAMISAS_H.PHP">Camisas</a></li>
                    <li><a href="../INSERTAR_ROPA_HOMBRE/ROPA_INTERIOR_H.PHP">Ropa Interior</a></li>
                </ul>
            </div>

            <!-- Menú Mujer -->
            <div class="desplegable">
                <a href="#categorias">Mujer</a>
                <ul class="submenu">
                <br>  <br>
                    <li><a href="../INSETAR_ROPA_MUJER/CAMISETAS_M.PHP">Camisetas</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/CHAQUETAS_M.PHP">Chaquetas</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/PANTALONES_M.PHP">Pantalones</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/BLAZER_M.PHP">Blazer y Gaban</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/CAMISAS_M.PHP">Camisas</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/ROPS_INTERIOR_M.PHP">Ropa Interior</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/VESTIDOS_M.PHP">Vestidos</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/BLUSAS_M.PHP">Blusas</a></li>
                    <li><a href="../INSETAR_ROPA_MUJER/BUZOS_M.PHP">Buzos</a></li>
                </ul>
            </div>

            <!-- Menú Accesorios -->
            <div class="desplegable">
                <a href="#">Accesorios</a>
                <ul class="submenu">
                <br>  <br>
                    <li><a href="../INSERTAR_ACCESORIOS/GAFAS.PHP">Gafas</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/CINTURON.PHP">Cinturón</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/PAÑUELOS.PHP">Pañuelos</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/BUFANDAS.PHP">Bufandas</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/GUANTES.PHP">Guantes</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/CORBATAS.PHP">Corbatas</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/ARETES.PHP">Aretes</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/ANILLOS.PHP">Anillos</a></li>
                    <li><a href="../INSERTAR_ACCESORIOS/COLLARES.PHP">Collares</a></li>
                </ul>
            </div>

            <!-- Menú Otros -->
            <div class="desplegable">
                <a href="#">Otros</a>
                <ul class="submenu">
                <br>  <br>
                <li>
    <a href="../INCLUDE/Estadisticas.php" onclick="openLoginModal(); return false;">Estadísticas</a></li>
                <li><a href="../REPORTES/reporte_compras.php">Reportes</a></li>
                    <li><a href="../ROLES/INTERFAZ_ADMINISTRADOR.PHP">Personal</a></li>
                    <li><a href="../FACTURACION/factura_tienda.php">Factura + </a></li>
                    <li><a href="../FACTURACION/finalizarfactu.php">Facturas Realizadas</a></li>

                    <li><a href="../PROVEEDORES/PROVEEDORES.PHP">Proveedores</a></li>
                    <li><a href="../ENTREGA/ENTREGA.PHP">Entregas</a></li>
                    <li><a href="../FACTURACION/FINALIZARFACTURA.PHP">Compras en linea</a></li>
                    <li><a href="../INSERTAR_TIPO_DE_PRENDA_Y_ACCESORIO/PRODUCTOS.PHP">Productos</a></li>

                    <li><a href="../INSERTAR_ROPA_OFERTA/OFERTA_M_J.PHP">Agregar Oferta</a></li>
                    <li><a href="../INSERTAR_ROPA_OFERTA/COLECCIONES_H_.PHP">Agregar Colección</a></li>

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


<!-- Modal para Iniciar Sesión -->
<div class="modal" id="loginModal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <div class="modal-header">
            <h2>🔐 Acceso a Estadísticas</h2>
            <p>Ingrese sus credenciales para ver las estadísticas de la tienda.</p>
        </div>
        <form method="POST" action="../INCLUDE/loguin_propietario.php">
            <div class="input-group">
                <label for="email">📧 Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="Ejemplo: usuario@email.com" required>
            </div>
            <div class="input-group">
                <label for="password">🔑 Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                    <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
                </div>
            </div>
            <button type="submit" class="btn-login">Acceder</button>
        </form>
        <div class="modal-footer">
            <p>¿Olvidó su contraseña? <a href="#" onclick="openRecoveryModal(); return false;">Recupérala aquí</a></p>
        </div>
    </div>
</div>

<!-- Modal para Recuperar Contraseña -->
<div class="modal" id="recoveryModal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeRecoveryModal()">&times;</span>
        <div class="modal-header">
            <h2>🔄 Recuperar Contraseña</h2>
            <p>Ingrese su correo electrónico y le enviaremos un enlace para restablecer su contraseña.</p>
        </div>
        <form method="POST" action="../Proyecto_Tienda_Ropa/LOGIN/RECUPERAR.PHP">
            <div class="input-group">
                <label for="recovery-email">📧 Correo Electrónico</label>
                <input type="email" id="recovery-email" name="recovery-email" placeholder="Ingrese su correo" required>
            </div>
            <button type="submit" class="btn-login">Enviar enlace</button>
        </form>
    </div>
</div>

<!-- Estilos Mejorados -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 10;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-in-out;
    }

    .modal-content {
        background: linear-gradient(135deg, #ffffff, #f2f2f2);
        padding: 30px;
        width: 380px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        animation: slideDown 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideDown {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .close {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #555;
    }

    .modal-header h2 {
        color: #333;
        font-size: 22px;
        margin-bottom: 10px;
    }

    .modal-header p {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }

    .input-group {
        text-align: left;
        margin-bottom: 15px;
    }

    .input-group label {
        display: block;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .input-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .input-group input:focus {
        border-color: #007BFF;
        outline: none;
    }

    .password-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-container input {
        flex: 1;
        padding-right: 40px;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        cursor: pointer;
        font-size: 18px;
        color: black;
    }

    .toggle-password:hover {
        color: #007BFF;
    }

    .btn-login {
        width: 100%;
        background: #007BFF;
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
        font-weight: bold;
    }

    .btn-login:hover {
        background: #0056b3;
    }

    .modal-footer {
        margin-top: 15px;
    }

    .modal-footer p {
        font-size: 14px;
        color: #555;
    }

    .modal-footer a {
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
    }

    .modal-footer a:hover {
        text-decoration: underline;
    }
</style>

<!-- JavaScript para controlar la apertura, cierre y el ojito 👁️ -->
<script>
    function openLoginModal() {
        document.getElementById('loginModal').style.display = 'flex';
    }

    function closeLoginModal() {
        document.getElementById('loginModal').style.display = 'none';
    }

    function openRecoveryModal() {
        closeLoginModal();
        document.getElementById('recoveryModal').style.display = 'flex';
    }

    function closeRecoveryModal() {
        document.getElementById('recoveryModal').style.display = 'none';
    }

    window.onclick = function(event) {
        let loginModal = document.getElementById('loginModal');
        let recoveryModal = document.getElementById('recoveryModal');

        if (event.target === loginModal) {
            closeLoginModal();
        }
        if (event.target === recoveryModal) {
            closeRecoveryModal();
        }
    }

    function togglePassword(fieldId) {
        let passwordField = document.getElementById(fieldId);
        passwordField.type = (passwordField.type === "password") ? "text" : "password";
    }
</script>


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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            data: { accion: 'descartar' },
            success: function(response) {
                if (response.trim() === "success") {
                    $('#notificaciones-lista').html('');
                    $('#contador').text('0');
                    $('#sin-notificaciones').show(); 
                    $('#botones-notificaciones').hide(); 
                } else {
                    alert("Error al descartar notificaciones.");
                }
            },
            error: function() {
                alert("Error en la solicitud AJAX.");
            }
        });
    }
</script>
</body>
</html>
