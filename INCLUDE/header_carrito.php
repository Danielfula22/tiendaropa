<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="../ESTILOS/estilos_Carrito_cliente.css" rel="stylesheet">
</head>
<body>

<style>
/* Estilos generales */
.icono-carrito {
    position: fixed;
    top: 47px;
    right: 10px;
    background-color: rgb(219, 52, 52);
    color: white;
    padding: 10px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    margin-right: 100px;
}
.icono-carrito:hover {
    background-color: rgb(200, 40, 40);
}
.contador-carrito {
    margin-left: 5px;
    background-color: white;
    color: rgb(219, 52, 52);
    padding: 2px 6px;
    border-radius: 50%;
    font-size: 14px;
    font-weight: bold;
}
.modal-carrito {
    position: fixed;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.7);
    transition: 0.3s;
    z-index: 2000;
    opacity: 0;
    pointer-events: none;
}
.modal-carrito.activo {
    opacity: 1;
    pointer-events: all;
}
.contenido-carrito {
    width: 400px;
    max-width: 90%;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    max-height: 80%;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.btn-cerrar {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgb(219, 52, 52);
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}
.item-carrito {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.item-carrito img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
}
.item-carrito div {
    flex: 1;
    text-align: center;
}
.item-carrito button {
    background-color: rgb(219, 52, 52);
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
}
.item-carrito button:hover {
    background-color: rgb(200, 40, 40);
}
.total-carrito {
    font-size: 18px;
    text-align: right;
    font-weight: bold;
}
.btn-pago {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: rgb(52, 152, 219);
    color: white;
    border: none;
    text-align: center;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
.btn-pago:hover {
    background-color: rgb(41, 128, 185);
}








.icono-perfil {
    position: absolute;
    top: 10px;
    right: 50px;
    width: 40px;
    height: 40px;
}
.icono-perfil img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}


</style>
<div class="icono-carrito" onclick="toggleCart()">
    <i class="fas fa-shopping-cart"></i>
    <span class="contador-carrito">0</span>
</div>

<div class="modal-carrito" id="cartModal">
    <button class="btn-cerrar" onclick="toggleCart()">X</button>
    
   

    <div class="contenido-carrito">
        <h2>Carrito de Compras</h2>

        <div id="cartItems"></div>
        <div class="total-carrito">
            <strong>Total: $<span id="cartTotal">0.00</span></strong>
        </div>
        <button class="btn-pago" onclick="confirmarFinalizarCompra()">Finalizar Compra</button>
    </div>
</div>



<script>
// Abrir/Cerrar el carrito
function toggleCart() {
    document.getElementById('cartModal').classList.toggle('activo');
}

// Agregar productos al carrito
function addToCart(nombre, precio, color, talla, stock, imagen, cantidad, idPrenda, tipo = "prenda") {
    const item = {
        nombre,
        precio: parseFloat(precio),
        color: color || "No especificado",
        talla: talla || "Única",
        stock: parseInt(stock),
        imagen: imagen || "imagen-defecto.png",
        cantidad: parseInt(cantidad) || 1,
        idPrenda,
        tipo
    };

    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    const index = carrito.findIndex(
        (producto) => producto.idPrenda === idPrenda && producto.talla === item.talla && producto.tipo === item.tipo
    );

    if (index > -1) {
        carrito[index].cantidad += item.cantidad;
    } else {
        carrito.push(item);
    }

    guardarCarrito(carrito);
    actualizarCarritoDOM(carrito);
}

// Actualizar el carrito en el DOM
function actualizarCarritoDOM(carrito) {
    const cartItems = document.getElementById('cartItems');
    cartItems.innerHTML = '';

    carrito.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className = 'item-carrito';
        itemElement.innerHTML = `
            <div class="item-contenido">
                <img src="${item.imagen}" alt="${item.nombre}" class="item-imagen">
                <div class="item-detalles">
                    <p><strong>Producto:</strong> ${item.nombre}</p>
                    <p><strong>Precio:</strong> $${item.precio.toFixed(2)}</p>
                    <p><strong>Cantidad:</strong> ${item.cantidad} 
                        <span class="menos" onclick="restarCantidad(${index})">-</span>
                    </p>
                    <p><strong>Talla:</strong> ${item.talla}</p>
                </div>
            </div>
            <button class="btn-eliminar" onclick="eliminarItem(${index})">Eliminar</button>
        `;
        cartItems.appendChild(itemElement);
    });

    actualizarTotalYContador(carrito);
}

// Actualizar total y contador del carrito
function actualizarTotalYContador(carrito) {
    const total = carrito.reduce((acc, item) => acc + item.precio * item.cantidad, 0);
    document.getElementById('cartTotal').textContent = total.toFixed(2);
    document.querySelector('.contador-carrito').textContent = carrito.length;
}

// Guardar carrito en localStorage
function guardarCarrito(carrito) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}

// Confirmar y finalizar la compra
function confirmarFinalizarCompra() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    if (carrito.length === 0) {
        alert('Tu carrito está vacío.');
        return;
    }

    localStorage.setItem('formularioCompra', JSON.stringify(carrito));
    window.location.href = "../INCLUDE/formularioCompra.php";
}

// Función para eliminar un producto
function eliminarItem(index) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    if (index > -1) {
        const productoEliminado = carrito.splice(index, 1)[0];  // Elimina y obtiene el producto eliminado
        
        // Devolver la cantidad eliminada al stock
        devolverStock(productoEliminado.idPrenda, productoEliminado.talla, productoEliminado.cantidad);
        
        // Actualizar el DOM y guardar el carrito
        guardarCarrito(carrito);
        actualizarCarritoDOM(carrito);
        actualizarTotalYContador(carrito);
    }
}

// Función para devolver la cantidad eliminada al stock
function devolverStock(idPrenda, talla, cantidadEliminada) {
    let cantidades = JSON.parse(localStorage.getItem('cantidades')) || {};
    if (!cantidades[idPrenda]) {
        cantidades[idPrenda] = {};
    }
    if (!cantidades[idPrenda][talla]) {
        cantidades[idPrenda][talla] = 0;
    }
    cantidades[idPrenda][talla] += cantidadEliminada;  // Agregar al stock disponible

    localStorage.setItem('cantidades', JSON.stringify(cantidades));
    actualizarCantidades();  // Actualizar los valores de stock en la vista del catálogo
}

// Cargar el carrito al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    actualizarCarritoDOM(JSON.parse(localStorage.getItem('carrito')) || []);
});

function confirmarFinalizarCompra() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    if (carrito.length === 0) {
        alert('Tu carrito está vacío.');
        return;
    }

    // Guardar productos antes de enviar la compra
    localStorage.setItem('formularioCompra', JSON.stringify(carrito));

    // Limpiar el carrito antes de redirigir al formulario
    localStorage.removeItem('carrito');
    actualizarCarritoDOM([]);  // Vacía la interfaz del carrito
    actualizarTotalYContador([]); // Resetea el contador

    // Redirigir al formulario de compra
    window.location.href = "../INCLUDE/formularioCompra.php";
}


</script>



<style>
/* Estilo para los productos en el carrito */
.item-carrito {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    background-color: #f9f9f9;
}

.item-contenido {
    display: flex;
    align-items: center;
}

.item-imagen {
    width: 50px;
    height: 50px;
    object-fit: cover;
    margin-right: 15px;
}

.item-detalles p {
    margin: 5px 0;
    font-size: 14px;
}

.menos {
    cursor: pointer;
    color: #e74c3c;
    font-weight: bold;
    margin-left: 10px;
}

.menos:hover {
    color: #c0392b;
}

.btn-eliminar {
    padding: 5px 10px;
    background-color: #e74c3c;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 10px;
}

.btn-eliminar:hover {
    background-color: #c0392b;
}

.item-id {
    display: none; /* Hacer que el ID de la prenda sea invisible */
}

#cartTotal {
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
}

.contador-carrito {
    font-size: 16px;
    color: #2980b9;
}
</style>
