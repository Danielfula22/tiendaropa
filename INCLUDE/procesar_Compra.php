<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda de ropa"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica que las claves necesarias están en $_POST
$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
$id_tipo_pago = isset($_POST['id_tipo_pago']) ? $_POST['id_tipo_pago'] : null;
$nombre_cliente = isset($_POST['nombre_cliente']) ? $_POST['nombre_cliente'] : null;
$email_cliente = isset($_POST['email_cliente']) ? $_POST['email_cliente'] : null;
$cedula_cliente = isset($_POST['cedula_cliente']) ? $_POST['cedula_cliente'] : null;
$direccion_entrega = isset($_POST['direccion_entrega']) ? $_POST['direccion_entrega'] : null;
$productos_comprados = isset($_POST['productos']) ? $_POST['productos'] : null; // Array de productos
$total = isset($_POST['total']) ? $_POST['total'] : 0;
$lugar_envio = isset($_POST['lugar_envio']) ? $_POST['lugar_envio'] : null;
$numero_telefono = isset($_POST['numero_telefono']) ? $_POST['numero_telefono'] : null;

// Validar datos requeridos
if (!$id_usuario || !$id_tipo_pago || !$nombre_cliente || !$email_cliente || !$cedula_cliente || !$direccion_entrega || !$lugar_envio || !$numero_telefono || !$productos_comprados) {
    die("Error: Faltan datos obligatorios en el formulario.");
}

// Validar que el usuario y el tipo de pago existan en la base de datos
$validar_usuario = "SELECT COUNT(*) AS existe_usuario FROM usuario WHERE ID_Usuario = '$id_usuario'";
$result_usuario = $conn->query($validar_usuario);
$usuario_existe = $result_usuario->fetch_assoc()['existe_usuario'];

$validar_tipo_pago = "SELECT COUNT(*) AS existe_tipo_pago FROM tipo_pago WHERE ID_Tipo_Pago = '$id_tipo_pago'";
$result_tipo_pago = $conn->query($validar_tipo_pago);
$tipo_pago_existe = $result_tipo_pago->fetch_assoc()['existe_tipo_pago'];

if ($usuario_existe > 0 && $tipo_pago_existe > 0) {
    // Inicia la transacción
    $conn->begin_transaction();

    try {
        // Verificar stock antes de registrar la compra
        foreach ($productos_comprados as $producto) {
            $id_prenda = $producto['id_prenda'];
            $cantidad = $producto['cantidad'];

            // Verificar si el producto es una prenda
            $sql_verificar_stock_prenda = "SELECT Stock FROM prenda WHERE ID_Prenda = '$id_prenda'";
            $result_stock_prenda = $conn->query($sql_verificar_stock_prenda);

            if ($result_stock_prenda->num_rows > 0) {
                $row_stock = $result_stock_prenda->fetch_assoc();
                $stock_disponible = $row_stock['Stock'];

                if ($stock_disponible < $cantidad) {
                    throw new Exception("Stock insuficiente para la prenda con ID $id_prenda. Disponible: $stock_disponible, solicitado: $cantidad.");
                }
            } else {
                // Verificar si es un accesorio
                $sql_verificar_stock_accesorio = "SELECT Stock FROM accesorio WHERE ID_Accesorio = '$id_prenda'";
                $result_stock_accesorio = $conn->query($sql_verificar_stock_accesorio);

                if ($result_stock_accesorio->num_rows > 0) {
                    $row_stock = $result_stock_accesorio->fetch_assoc();
                    $stock_disponible = $row_stock['Stock'];

                    if ($stock_disponible < $cantidad) {
                        throw new Exception("Stock insuficiente para el accesorio con ID $id_prenda. Disponible: $stock_disponible, solicitado: $cantidad.");
                    }
                } else {
                    throw new Exception("El producto con ID $id_prenda no existe en la base de datos.");
                }
            }
        }

        // Inserta los detalles de la compra
        $productos_json = json_encode($productos_comprados);
        $sql_compra = "INSERT INTO compras (
            ID_Usuario, ID_Tipo_Pago, Nombre, Email, Cedula, Direccion_Entrega, 
            Productos_Comprados, Total, Lugar_Envio, Numero_Telefono
        ) VALUES (
            '$id_usuario', '$id_tipo_pago', '$nombre_cliente', '$email_cliente', '$cedula_cliente', 
            '$direccion_entrega', '$productos_json', '$total', '$lugar_envio', '$numero_telefono'
        )";

        if ($conn->query($sql_compra) === TRUE) {
            $id_compra = $conn->insert_id;

        // Insertar notificación de compra
$mensaje = "Has realizado una nueva compra. ID de compra: $id_compra.";
$sql_notificacion = "INSERT INTO notificaciones (ID_Usuario, mensaje, estado) VALUES ('$id_usuario', '$mensaje', 'no leído')";
$conn->query($sql_notificacion);


            // Actualizar stock después de la compra
            foreach ($productos_comprados as $producto) {
                $id_prenda = $producto['id_prenda'];
                $cantidad = $producto['cantidad'];
                $sql_stock_prenda = "UPDATE prenda SET Stock = Stock - $cantidad WHERE ID_Prenda = '$id_prenda' AND Stock >= $cantidad";
                $conn->query($sql_stock_prenda);
                $sql_stock_accesorio = "UPDATE accesorio SET Stock = Stock - $cantidad WHERE ID_Accesorio = '$id_prenda' AND Stock >= $cantidad";
                $conn->query($sql_stock_accesorio);
            }

            $conn->commit();
            echo "Compra realizada con éxito.";
            echo "<script>
                localStorage.removeItem('carrito');
                localStorage.clear();
                sessionStorage.clear();
                document.cookie.split(';').forEach(function(c) { 
                    document.cookie = c.replace(/^ +/, '').replace(/=.*/, '=;expires=' + new Date().toUTCString() + ';path=/'); 
                });
                window.location.href = 'carrito.php';
            </script>";
        } else {
            throw new Exception("Error al registrar la compra: " . $conn->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        die("Hubo un error en la compra: " . $e->getMessage());
    }
} else {
    if ($usuario_existe == 0) {
        echo "El usuario no existe.";
    }
    if ($tipo_pago_existe == 0) {
        echo "El tipo de pago no es válido.";
    }
}

$conn->close();
?>