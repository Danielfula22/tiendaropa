<?php
session_start();

// Verificar si el usuario ha iniciado sesión y obtener su ID
$id_usuario = isset($_SESSION['ID_Usuario']) ? $_SESSION['ID_Usuario'] : null;

if ($id_usuario) {
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'tienda de ropa');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    // Consulta para obtener los datos del usuario
    $sql = "SELECT Nombre, Apellido, Correo, N_Documento, Direccion, Ciudad, Telefono 
            FROM usuario WHERE ID_Usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        die('No se encontraron datos para el usuario.');
    }

    $stmt->close();
    $conexion->close();
} else {
    die('Usuario no autenticado.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Su Compra</title>
    <link href="../INCLUDE/formulariocompra.css" rel="stylesheet">

</head>
<body>
<div class="form-container">
    <form id="formCompra" method="POST" action="procesar_compra.php" onsubmit="procesarFormulario(event)">
        <h2>Detalles de Compra</h2>
        <div class="form-grid">
            <div>
                <label for="id_usuario">ID Usuario:</label>
                <input type="text" id="id_usuario" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>" readonly>
            </div>
            <div>
                <label for="nombre_cliente">Nombre:</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo htmlspecialchars($usuario['Nombre'] . ' ' . $usuario['Apellido']); ?>" readonly>
            </div>
            <div>
                <label for="email_cliente">Email:</label>
                <input type="email" id="email_cliente" name="email_cliente" value="<?php echo htmlspecialchars($usuario['Correo']); ?>" readonly>
            </div>
            <div>
                <label for="cedula_cliente">Cédula:</label>
                <input type="text" id="cedula_cliente" name="cedula_cliente" value="<?php echo htmlspecialchars($usuario['N_Documento']); ?>" readonly>
            </div>
            <div>
                <label for="direccion_entrega">Dirección de Entrega:</label>
                <input type="text" id="direccion_entrega" name="direccion_entrega" value="<?php echo htmlspecialchars($usuario['Direccion']); ?>" readonly>
            </div>
            <div>
                <label for="id_tipo_pago">Tipo de Pago:</label>
                <select id="id_tipo_pago" name="id_tipo_pago">
                    <option value="1">Transferencia</option>
                    <option value="2">Tarjeta de Crédito</option>
                </select>
            </div>
            <div>
                <label for="lugar_envio">Lugar de Envío:</label>
                <input type="text" id="lugar_envio" name="lugar_envio" value="<?php echo htmlspecialchars($usuario['Ciudad']); ?>" readonly>
            </div>
            <div>
                <label for="numero_telefono">Número de Teléfono:</label>
                <input type="text" id="numero_telefono" name="numero_telefono" value="<?php echo htmlspecialchars($usuario['Telefono']); ?>" readonly>
            </div>
        </div>
        <div class="productos-container">
            <h3>Detalles de los Productos:</h3>
            <div id="detallesProductos"></div>
        </div>
        <div class="total-confirmar">
            <div class="total-container">
                <label for="totalCompra">Total:</label>
                <input type="text" id="totalCompra" name="total" value="0.00" readonly>
            </div>
            <div class="confirmar-container">
                <input type="submit" value="Confirmar Compra">
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const productos = JSON.parse(localStorage.getItem('formularioCompra')) || [];
        let total = 0;
        const detallesProductos = document.getElementById('detallesProductos');
        if (productos.length > 0) {
            productos.forEach((item, index) => {
                const producto = document.createElement('div');
                producto.className = 'producto-detalle';
                producto.innerHTML = `
                    <div>
                        <p><strong>Producto:</strong> ${item.nombre}</p>
                        <p><strong>Precio:</strong> $${item.precio.toFixed(2)}</p>
                        <p><strong>Cantidad:</strong> ${item.cantidad}</p>
                        <p><strong>Talla:</strong> ${item.talla}</p> <!-- La talla sigue visible -->
                    </div>
                    <img src="${item.imagen}" alt="${item.nombre}">
                    <input type="hidden" name="productos[${index}][nombre]" value="${item.nombre}">
                    <input type="hidden" name="productos[${index}][precio]" value="${item.precio}">
                    <input type="hidden" name="productos[${index}][cantidad]" value="${item.cantidad}">
                    <input type="hidden" name="productos[${index}][total]" value="${(item.precio * item.cantidad).toFixed(2)}">
                    <input type="hidden" name="productos[${index}][id_prenda]" value="${item.idPrenda}">
                    <input type="hidden" name="productos[${index}][stock]" value="${item.stock}">
                `;
                detallesProductos.appendChild(producto);
                total += parseFloat(item.precio) * item.cantidad;
            });
        } else {
            detallesProductos.innerHTML = '<p>No hay productos en el carrito.</p>';
        }
        document.getElementById('totalCompra').value = total.toFixed(2);
    });

    async function procesarFormulario(event) {
        event.preventDefault();
        const form = document.getElementById("formCompra");
        const formData = new FormData(form);
        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: formData,
            });
            const result = await response.text();
            if (result.includes("Compra realizada con éxito")) {
                alert("¡Compra realizada con éxito!");
                window.location.href = "../ROPA_CLIENTE_HOMBRE/CAMISETAS_H.PHP";
            } else {
                alert("Hubo un error en la compra: " + result);
            }
        } catch (error) {
            alert("Error en la comunicación con el servidor.");
        }
    }
</script>
