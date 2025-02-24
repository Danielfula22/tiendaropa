<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el usuario tiene sesión activa
if (!isset($_SESSION['ID_Usuario']) || empty($_SESSION['ID_Usuario'])) {
    echo "<script>alert('Debe iniciar sesión para acceder a esta página'); window.location.href = '../INDEX.PHP';</script>";
    exit();
}

// Incluir la conexión a la base de datos
require_once('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

$USUARIO_ID = $_SESSION['ID_Usuario'];

// Procesar la actualización del perfil si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevoNombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $nuevoApellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $nuevoCorreo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $nuevoDocumento = mysqli_real_escape_string($conexion, $_POST['documento']);
    $nuevaDireccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $nuevaCiudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);
    $nuevoTelefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $nuevaContrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    $actualizarQuery = "
        UPDATE usuario 
        SET Nombre = '$nuevoNombre', 
            Apellido = '$nuevoApellido', 
            Correo = '$nuevoCorreo', 
            N_Documento = '$nuevoDocumento', 
            Direccion = '$nuevaDireccion', 
            Ciudad = '$nuevaCiudad', 
            Telefono = '$nuevoTelefono', 
            Contrasena = '$nuevaContrasena'
        WHERE ID_Usuario = '$USUARIO_ID'";

    if (mysqli_query($conexion, $actualizarQuery)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
          Swal.fire({
            title: 'Perfil Actualizado',
            text: 'Tus cambios han sido guardados correctamente.',
            icon: 'info',
            iconColor: '#e74c3c', // Rojo suave
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
          });
        </script>";
  
    } else {
        echo "<script>alert('Error al actualizar los datos');</script>";
    }
}

// Consultar los datos del usuario
$USUARIO_QUERY = "
    SELECT u.Nombre, u.Apellido, u.Correo, u.N_Documento AS Documento, 
           u.Direccion, u.Ciudad, u.Telefono AS Telefono, u.Contrasena AS Contrasena, r.Nombre AS Rol
    FROM usuario u
    INNER JOIN rol r ON u.ID_Rol = r.ID_Rol
    WHERE u.ID_Usuario = '$USUARIO_ID'";
$USUARIO_RESULT = mysqli_query($conexion, $USUARIO_QUERY);

if ($USUARIO_RESULT && mysqli_num_rows($USUARIO_RESULT) > 0) {
    $USUARIO_DATOS = mysqli_fetch_assoc($USUARIO_RESULT);
} else {
    echo "<script>alert('No se encontraron datos del usuario.'); window.location.href = '../INDEX.PHP';</script>";
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../ESTILOS/estilos_include_perfil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../INCLUDE/estilos.actualizar_perfil.css">
</head>
<body>

<!-- Notificación de éxito -->
<div id="successAlert" class="alert alert-success" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000;">
    <strong>Éxito:</strong> Datos actualizados correctamente.
</div>

<div class="perfil-boton-container text-center">
    <a href="#" data-toggle="modal" data-target="#perfilModal">
        <i class="fas fa-user-circle"></i>
    </a>
    <div class="tooltip-perfil">
        <strong></strong> <?php echo htmlspecialchars($USUARIO_DATOS['Nombre']); ?><br>
        <strong></strong> <?php echo htmlspecialchars($USUARIO_DATOS['Correo']); ?><br>
    </div>
</div>

<style>
    .modal-body {
        max-height: 550px;
        overflow-y: auto;
        padding-right: 10px;
        position: relative;
    }

    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .close-btn {
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 24px;
        color: black;
        cursor: pointer;
    }

    .close-btn:hover {
        color:rgb(112, 49, 32);
    }

    .modal-header {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-header h5 {
        flex-grow: 1;
        text-align: center;
        margin: 0;
    }

    .form-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 16px;
        width: 180px;
    }

    .form-label i {
        margin-right: 8px;
        font-size: 18px;
        color: #555;
    }

    .form-control {
        font-size: 16px;
        width: calc(100% - 200px);
        height: 40px;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 5px 10px;
        background-color: #f8f9fa;
    }

    .password-container {
        position: relative;
        width: calc(100% - 200px);
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #ccc;
        height: 40px;
        padding: 0 10px;
    }

    .password-container input {
        border: none;
        background: transparent;
        flex: 1;
        font-size: 16px;
        outline: none;
        padding-left: 5px;
    }

    .password-toggle {
        font-size: 12px;
        font-weight: bold;
        color: black;
        cursor: pointer;
        background: #ddd;
        border-radius: 10px;
        padding: 3px 8px;
        margin-left: 10px;
    }

    .password-toggle:hover {
        background: #bbb;
    }

    /* Diseño responsivo */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%;
        }
        .form-label {
            width: 100%;
            justify-content: center;
        }
        .form-control, .password-container {
            width: 100%;
        }
        .password-toggle {
            right: 15px;
        }
    }






    .custom-alert-box {
    position: fixed;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
    z-index: 1000;
}

</style>

<div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white position-relative">
                <h5 class="modal-title w-100 text-center">Mi Perfil</h5>
                <!-- Botón de cierre alineado con "Mi Perfil" -->
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Cerrar">
                    &times;
                </button>
            </div>

            <div class="modal-body px-4 py-3">
                <form method="POST" id="updateForm">
                    <div class="container">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user"></i> Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($USUARIO_DATOS['Nombre']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user"></i> Apellido</label>
                            <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars($USUARIO_DATOS['Apellido']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-envelope"></i> Correo</label>
                            <input type="email" class="form-control" name="correo" value="<?php echo htmlspecialchars($USUARIO_DATOS['Correo']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-id-card"></i> Doc</label>
                            <input type="text" class="form-control" name="documento" value="<?php echo htmlspecialchars($USUARIO_DATOS['Documento']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars($USUARIO_DATOS['Direccion']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-city"></i> Ciudad</label>
                            <input type="text" class="form-control" name="ciudad" value="<?php echo htmlspecialchars($USUARIO_DATOS['Ciudad']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo htmlspecialchars($USUARIO_DATOS['Telefono']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                            <div class="password-container">
                                <input type="password" name="contrasena" id="password" value="<?php echo htmlspecialchars($USUARIO_DATOS['Contrasena']); ?>" readonly>
                                <span class="password-toggle" id="togglePassword">Mostrar</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-info btn-lg" id="editButton">Editar</button>
                        <button type="submit" class="btn btn-primary btn-lg" id="saveButton" style="display: none;">Guardar</button>
                        <button type="button" class="btn btn-warning btn-lg" id="historyButton" onclick="window.open('../INCLUDE/historial.php', 'Historial')">Facturas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            this.textContent = "Ocultar";
        } else {
            passwordField.type = "password";
            this.textContent = "Mostrar";
        }
    });
</script>



<script>
$(document).ready(function() {
    $("#editButton").click(function() {
        $("#updateForm input").prop("readonly", false);
        $("#editButton").hide();
        $("#saveButton").show();
    });
});
</script>

<script>
    document.getElementById("editButton").addEventListener("click", function () {
        let alertBox = document.createElement("div");
        alertBox.innerHTML = "✔ Ahora puedes editar los datos";
        alertBox.className = "custom-alert-box";
        document.body.appendChild(alertBox);

        setTimeout(() => {
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }, 2500);
    });
</script>


</body>
</html>
