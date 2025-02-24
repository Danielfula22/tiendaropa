<?php
// Verifica si la sesión no está iniciada antes de llamar a session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../CONEXION/CONEXION_BASE_DE_DATOS.PHP');

// Verifica si el usuario está autenticado
if (!isset($_SESSION['ID_Usuario'])) {
    echo "<script>alert('Debe iniciar sesión para acceder a esta página'); window.location.href = '../INDEX.PHP';</script>";
    exit();
}

// Obtenemos el ID del usuario desde la sesión
$USUARIO_ID = $_SESSION['ID_Usuario'];

// Procesar actualización si se envío el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $documento = mysqli_real_escape_string($conexion, $_POST['documento']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);

    $actualizar_query = "
        UPDATE usuario
        SET Nombre = '$nombre', Apellido = '$apellido', Correo = '$correo',
            N_Documento = '$documento', Direccion = '$direccion', Ciudad = '$ciudad',
            Telefono = '$telefono'
        WHERE ID_Usuario = '$USUARIO_ID'
    ";

    if (mysqli_query($conexion, $actualizar_query)) {
        echo "<script>alert('Datos actualizados correctamente.'); window.location.href = 'PERFIL_USUARIO.PHP';</script>";
        exit();
    } else {
        echo "<script>alert('Error al actualizar los datos.');</script>";
    }
}

// Consulta para obtener los datos del usuario junto con el rol
$USUARIO_QUERY = "
    SELECT u.Nombre, u.Apellido, u.Correo, u.N_Documento AS Documento, 
           u.Direccion, u.Ciudad, u.Telefono AS Contacto, r.Nombre AS Rol
    FROM usuario u
    INNER JOIN rol r ON u.ID_Rol = r.ID_Rol
    WHERE u.ID_Usuario = '$USUARIO_ID'";
$USUARIO_RESULT = mysqli_query($conexion, $USUARIO_QUERY);

// Validamos que la consulta no falle y obtenemos los datos del usuario
if ($USUARIO_RESULT && mysqli_num_rows($USUARIO_RESULT) > 0) {
    $USUARIO_DATOS = mysqli_fetch_assoc($USUARIO_RESULT);
} else {
    echo "<script>alert('No se encontraron datos del usuario.'); window.location.href = '../INDEX.PHP';</script>";
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <style>
        .editable {
            border: 1px solid transparent;
            transition: border-color 0.3s, background-color 0.3s;
        }
        .editable:focus {
            border-color: #007bff;
            background-color: #e9f7ff;
            outline: none;
        }
    </style>
</head>
<body onload="$('#perfilModal').modal('show')">

<div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        
            <div class="modal-header">
                <h5 class="modal-title" id="perfilModalLabel">Actualizar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.history.back();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateForm">
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-3 col-form-label">Nombre:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editable" id="nombre" name="nombre" value="<?php echo htmlspecialchars($USUARIO_DATOS['Nombre']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apellido" class="col-sm-3 col-form-label">Apellido:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editable" id="apellido" name="apellido" value="<?php echo htmlspecialchars($USUARIO_DATOS['Apellido']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="correo" class="col-sm-3 col-form-label">Correo:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control editable" id="correo" name="correo" value="<?php echo htmlspecialchars($USUARIO_DATOS['Correo']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="documento" class="col-sm-3 col-form-label">Documento:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editable" id="documento" name="documento" value="<?php echo htmlspecialchars($USUARIO_DATOS['Documento']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="direccion" class="col-sm-3 col-form-label">Dirección:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editable" id="direccion" name="direccion" value="<?php echo htmlspecialchars($USUARIO_DATOS['Direccion']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ciudad" class="col-sm-3 col-form-label">Ciudad:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editable" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($USUARIO_DATOS['Ciudad']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editable" id="telefono" name="telefono" value="<?php echo htmlspecialchars($USUARIO_DATOS['Contacto']); ?>" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.history.back();">Cerrar</button>
                        <button type="button" class="btn btn-info" id="editButton">Editar</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" style="display: none;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#editButton').on('click', function () {
            $('.editable').removeAttr('readonly').focus();
            $(this).hide();
            $('#saveButton').show();
        });

        $('#saveButton').on('click', function () {
            $(this).text('Guardando...').prop('disabled', true);
            $('#updateForm').submit();
        });
    });
</script>

</body>
</html>
