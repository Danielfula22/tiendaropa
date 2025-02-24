<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda de ropa";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Ingresos totales
$ventasQuery = "SELECT SUM(Total) as total FROM compras";
$ventasResult = $conn->query($ventasQuery);
$ingresoTotal = $ventasResult->fetch_assoc()["total"] ?? 0;

// Productos más vendidos
$productosQuery = "SELECT p.Nombre, SUM(d.Cantidad) as cantidad FROM detalle_factura d 
                   JOIN prenda p ON d.ID_Prenda = p.ID_Prenda 
                   GROUP BY p.Nombre ORDER BY cantidad DESC LIMIT 5";
$productosResult = $conn->query($productosQuery);
$productos = [];
$cantidades = [];
while ($row = $productosResult->fetch_assoc()) {
    $productos[] = $row['Nombre'];
    $cantidades[] = $row['cantidad'];
}

// Ventas por categoría
$categoriaQuery = "SELECT t.Nombre, SUM(d.Cantidad) as cantidad FROM detalle_factura d 
                   JOIN prenda p ON d.ID_Prenda = p.ID_Prenda 
                   JOIN tipo_prenda t ON p.ID_Tipo_prenda = t.ID_Tipo_prenda 
                   GROUP BY t.Nombre";
$categoriaResult = $conn->query($categoriaQuery);
$categorias = [];
$ventasCategorias = [];
while ($row = $categoriaResult->fetch_assoc()) {
    $categorias[] = $row['Nombre'];
    $ventasCategorias[] = $row['cantidad'];
}

// Clientes con más compras
$clientesQuery = "SELECT Nombre, COUNT(ID_Compra) as compras FROM compras 
                  GROUP BY Nombre ORDER BY compras DESC LIMIT 5";
$clientesResult = $conn->query($clientesQuery);
$clientes = [];
$comprasClientes = [];
while ($row = $clientesResult->fetch_assoc()) {
    $clientes[] = $row['Nombre'];
    $comprasClientes[] = $row['compras'];
}

// Ventas de Accesorios
$accesoriosQuery = "SELECT a.Nombre, SUM(d.Cantidad) as cantidad FROM detalle_factura d 
                     JOIN accesorio a ON d.ID_Accesorio = a.ID_Accesorio 
                     GROUP BY a.Nombre ORDER BY cantidad DESC LIMIT 5";
$accesoriosResult = $conn->query($accesoriosQuery);
$accesorios = [];
$cantidadesAccesorios = [];
while ($row = $accesoriosResult->fetch_assoc()) {
    $accesorios[] = $row['Nombre'];
    $cantidadesAccesorios[] = $row['cantidad'];
}

// Consulta para obtener el porcentaje de usuarios activos e inactivos
$usuariosQuery = "SELECT TRIM(LOWER(Estado)) as Estado, COUNT(*) as cantidad FROM usuario GROUP BY Estado";
$usuariosResult = $conn->query($usuariosQuery);

$estados = [];
$cantidadEstados = [];

while ($row = $usuariosResult->fetch_assoc()) {
    // Normalizamos el estado para que solo existan "Activo" e "Inactivo"
    $estadoNormalizado = ($row['Estado'] === 'activo') ? 'Activo' : 'Inactivo';

    // Verificamos si ya existe el estado en el array para evitar duplicados
    $index = array_search($estadoNormalizado, $estados);
    if ($index !== false) {
        // Si ya existe, sumamos la cantidad
        $cantidadEstados[$index] += $row['cantidad'];
    } else {
        // Si no existe, lo agregamos
        $estados[] = $estadoNormalizado;
        $cantidadEstados[] = $row['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de la Tienda</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #eef1f7; padding: 20px; }
        .container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; max-width: 1200px; margin: auto; }
        .chart-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        .chart-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
        .stats { font-size: 22px; font-weight: bold; margin-bottom: 25px; color: #2a9d8f; }
    </style>
</head>
<body>
    <h1>📊 Estadísticas de la Tienda de Ropa</h1>
    <p class="stats">💰 Ingreso Total: $<?php echo number_format($ingresoTotal, 2); ?></p>
    <div class="container">
        <div class="chart-container">
            <div class="chart-title">🔥 Productos Más Vendidos</div>
            <canvas id="productosChart"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">📦 Ventas por Categoría</div>
            <canvas id="categoriaVentasChart"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">👥 Clientes con Más Compras</div>
            <canvas id="clientesChart"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">👜 Ventas de Accesorios</div>
            <canvas id="accesoriosChart"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">📈 Usuarios Activos e Inactivos</div>
            <canvas id="usuariosChart"></canvas>
        </div>
    </div>

<script>
    new Chart(document.getElementById('productosChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($productos); ?>,
            datasets: [{
                label: 'Productos Más Vendidos',
                data: <?php echo json_encode($cantidades); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true }
            }
        }
    });

    new Chart(document.getElementById('categoriaVentasChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($categorias); ?>,
            datasets: [{
                data: <?php echo json_encode($ventasCategorias); ?>,
                backgroundColor: ['#ffb703', '#fb8500', '#219ebc', '#023047', '#8ecae6']
            }]
        }
    });

    new Chart(document.getElementById('clientesChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($clientes); ?>,
            datasets: [{
                label: 'Compras Realizadas',
                data: <?php echo json_encode($comprasClientes); ?>,
                borderColor: '#ff006e',
                backgroundColor: 'rgba(255, 0, 110, 0.5)',
                borderWidth: 2,
                fill: true
            }]
        }
    });

    new Chart(document.getElementById('accesoriosChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($accesorios); ?>,
            datasets: [{
                label: 'Ventas de Accesorios',
                data: <?php echo json_encode($cantidadesAccesorios); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });

    new Chart(document.getElementById('usuariosChart'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($estados); ?>,
            datasets: [{
                data: <?php echo json_encode($cantidadEstados); ?>,
                backgroundColor: ['#4CAF50', '#FF5733']
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
