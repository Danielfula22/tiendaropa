<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda MAFE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #333;
            color: white;
        }
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .botones-sesion a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-left: 2px;
            font-size: 13px;
        }
        .botones-sesion a:first-child {
            background-color: red; /* Azul para Iniciar Sesión */
        }
        .botones-sesion a:last-child {
            background-color: red; /* Verde para Registrarse */
        }
        .botones-sesion a:hover {
            opacity: 0.8;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .success, .error {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">LIFER</div>
        <div class="botones-sesion">
        <a href="#" class="boton-sesion" onclick="openLoginModal()">Iniciar Sesión</a>
        <a href="#" onclick="openRegisterModal()">Registrarse</a>
        </div>

        

<div class="enlaces-nav">
            <div class="desplegable">
            <a href="./INDEX.PHP">Inicio</a>
                <ul class="submenu">
                    <li><a href="#novedades">Novedades</a></li>
                    <li><a href="#populares">Más Populares</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#">Hombre</a>
                <ul class="submenu">
                    <li><a href="./ROPA HOMBRE/CAMISETAS_H.PHP">Camisetas</a></li>
                    <li><a href="./ROPA HOMBRE/CHAQUETAS_H.PHP">Chaquetas</a></li>
                    <li><a href="./ROPA HOMBRE/JEANS_H.PHP">Pantalones</a></li>
                    <li><a href="./ROPA HOMBRE/SHORTS_H.PHP">Shorts</a></li>
                    <li><a href="./ROPA HOMBRE/BLAZER_H.PHP">Gaban Y Blazer</a></li>
                    <li><a href="./ROPA HOMBRE/BUZOS_H.PHP">Buzos</a></li>
                    <li><a href="./ROPA HOMBRE/CAMISAS_H.PHP">Camisas</a></li>
                    <li><a href="./ROPA HOMBRE/ROPA_INTERIOR_H.PHP">Ropa Interior</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#categorias">Mujer</a>
                <ul class="submenu">
                    <li><a href="./ROPA MUJER/CAMISETAS_M.PHP">Camisetas</a></li>
                    <li><a href="./ROPA MUJER/CHAQUETAS_M.PHP">Chaquetas</a></li>
                    <li><a href="./ROPA MUJER/JEANS_M.PHP">Pantalones</a></li>
                    <li><a href="./ROPA MUJER/BLAZER_M.PHP">Blazer y Gaban</a></li>
                    <li><a href="./ROPA MUJER/CAMISAS_M.PHP">Camisas</a></li>
                    <li><a href="./ROPA MUJER/ROPA_INT_M.PHP">Ropa Interior</a></li>
                    <li><a href="./ROPA MUJER/VESTIDOS_M.PHP">Vestidos</a></li>
                    <li><a href="./ROPA MUJER/BLUSAS_M.PHP">Blusas</a></li>
                    <li><a href="./ROPA MUJER/BUZOS_M.PHP">Buzos</a></li>
                </ul>
            </div>
            <div class="desplegable">
                <a href="#contacto">Accesorios</a>
                <ul class="submenu">
                    <li><a href="./ACCESORIOS/ACCESORIOS.PHP">Gafas</a></li>
                    <li><a href="./ACCESORIOS/CINTURON.PHP">Cinturón</a></li>
                    <li><a href="./ACCESORIOS/PAÑUELOS.PHP">Pañuelos</a></li>
                    <li><a href="./ACCESORIOS/BUFANDAS.PHP">Bufandas</a></li>
                    <li><a href="./ACCESORIOS/GUANTES.PHP">Guantes</a></li>
                    <li><a href="./ACCESORIOS/CORBATAS.PHP">Corbatas</a></li>
                    <li><a href="./ACCESORIOS/ARETES.PHP">Aretes</a></li>
                    <li><a href="./ACCESORIOS/ANILLOS.PHP">Anillos</a></li>
                    <li><a href="./ACCESORIOS/COLLARES.PHP">Collares</a></li>
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
</header>

<!-- Modal para Iniciar Sesión -->
<div class="modal" id="loginModal">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../Proyecto_Tienda_Ropa/LOGIN/LOGUIN.PHP">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</div>

    </nav>
</header>
<!-- Modal para Registrarse -->
<div class="modal" id="registerModal">
    <div class="modal-content">
        <span class="close" onclick="closeRegisterModal()">&times;</span>
        <h2>Registrate con nosotros</h2>
        <form method="POST" action="">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="N_Documento" placeholder="Número de documento" required>
            <input type="text" name="direccion" placeholder="Dirección" required>
            <input type="text" name="ciudad" placeholder="Ciudad" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>

            <!-- Campo de Contraseña con ícono de ojo -->
            <div class="password-container">
                <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                <i id="togglePassword" class="fa fa-eye" onclick="togglePasswordVisibility()" style="cursor: pointer;"></i>
            </div>

            <button type="submit" name="register">Registrarse</button>
        </form>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda de ropa";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("<div class='error'>Error de conexión: " . $conn->connect_error . "</div>");
    }

    // Recibir datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $documento = $conn->real_escape_string($_POST['N_Documento']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $ciudad = $conn->real_escape_string($_POST['ciudad']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $contrasena = $conn->real_escape_string($_POST['contrasena']); // No encriptar la contraseña

    // Establecer el ID_Rol predeterminado como 3
    $rol = 3;

    // Insertar datos en la base de datos (corrección aquí con la columna ID_Rol)
    $sql = "INSERT INTO usuario (Nombre, Apellido, Correo, N_Documento, Direccion, Ciudad, Telefono, Contrasena, ID_Rol) 
            VALUES ('$nombre', '$apellido', '$correo', '$documento', '$direccion', '$ciudad', '$telefono', '$contrasena', '$rol')";

    if ($conn->query($sql) === TRUE) {
        // Guardar el nombre en localStorage para mostrarlo en el popup
        echo "<script>localStorage.setItem('registro_exitoso', 'true'); localStorage.setItem('usuario_nombre', '$nombre');</script>";
    } else {
        echo "<div class='error'>Error al registrar: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!-- Ventana emergente de éxito -->
<div id="popupMessage" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close-popup" onclick="closePopup()">&times;</span>
        <h2>Registro exitoso</h2>
        <p>¡Bienvenido, <span id="usuarioNombre"></span>!</p>
    </div>
</div>

<!-- CSS -->
<style>
/* Estilo para la ventana emergente */
.popup {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
}

.close-popup {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

/* Contenedor de la contraseña y el ícono */
.password-container {
    position: relative;
    display: inline-block;
}

.password-container input {
    width: 100%;
    padding-right: 30px; /* Para dejar espacio al ícono */
}

.password-container i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: #888;
}
</style>

<!-- JavaScript -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Para Font Awesome -->

<script>
// Verifica si el mensaje de registro ya se ha mostrado usando localStorage
window.onload = function() {
    if (localStorage.getItem('registro_exitoso') === 'true') {
        showPopup();
        localStorage.removeItem('registro_exitoso'); // Eliminar para que no se repita
    }
};

// Mostrar el popup
function showPopup() {
    const popup = document.getElementById('popupMessage');
    const nombreUsuario = localStorage.getItem('usuario_nombre'); // Obtener el nombre del usuario
    document.getElementById('usuarioNombre').textContent = nombreUsuario; // Mostrar el nombre en el popup
    popup.style.display = 'flex';

    // Cerrar el popup después de 3 segundos
    setTimeout(function() {
        closePopup();
    }, 3000); // 3000 ms = 3 segundos
}

// Función para cerrar el popup
function closePopup() {
    const popup = document.getElementById('popupMessage');
    popup.style.display = 'none';
}

// Función para alternar la visibilidad de la contraseña
function togglePasswordVisibility() {
    const passwordField = document.getElementById('contrasena');
    const toggleButton = document.getElementById('togglePassword');
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.classList.remove('fa-eye');
        toggleButton.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        toggleButton.classList.remove('fa-eye-slash');
        toggleButton.classList.add('fa-eye');
    }
}

// Modal de registro
function openRegisterModal() {
    document.getElementById('registerModal').style.display = 'flex';
}
function closeRegisterModal() {
    document.getElementById('registerModal').style.display = 'none';
}
window.onclick = function(event) {
    if (event.target == document.getElementById('registerModal')) {
        closeRegisterModal();
    }
}
</script>








<script>
    function openRegisterModal() {
        document.getElementById('registerModal').style.display = 'flex';
    }
    function closeRegisterModal() {
        document.getElementById('registerModal').style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target == document.getElementById('registerModal')) {
            closeRegisterModal();
        }
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

</body>
</html>
