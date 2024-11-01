<?php
session_start();

// Inicializa el arreglo de productos si no existe
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

// Funciones
function mostrarProductos($productos) {
    if (empty($productos)) {
        return "No hay productos disponibles.";
    }
    $lista = "<ul>";
    foreach ($productos as $producto) {
        $lista .= "<li>" . $producto['nombre'] . " - $" . number_format($producto['precio'], 2) . "</li>";
    }
    $lista .= "</ul>";
    return $lista;
}

function agregarProducto($nombre, $precio) {
    if (!empty($nombre) && is_numeric($precio) && $precio > 0) {
        $_SESSION['productos'][] = ['nombre' => $nombre, 'precio' => (float)$precio];
    }
}

function calcularPrecioPromedio($productos) {
    if (empty($productos)) {
        return 0;
    }
    $total = 0;
    foreach ($productos as $producto) {
        $total += $producto['precio'];
    }
    return $total / count($productos);
}

// Manejo de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';
    agregarProducto($nombre, $precio);
}
?>

<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <main class="presentacion__contenido"> 
        
        <div class="seccion__titulo__logo">
            <div class="presentacion__logo">
                <img class="Logo" src="./assets/Logo.png" alt="Logotipo">
            </div>

            <h1 class="presentacion__titulo">CATÁLOGO DE PRODUCTOS</h1>

            <h2 class="presentacion_subtitulo">
                Selecciona una de las siguientes opciones para realizar la actividad correspondiente:</h2>
        </div>

        <div class="container">
            <form method="POST">
                <label>Ingresa los productos que deseas añadir a la lista.</label>
                <input type="text" name="nombre" placeholder="Nombre del producto" required>
                <input type="number" step="0.01" name="precio" placeholder="Precio del producto" required>
                <button type="submit">AGREGAR PRODUCTO</button>
            </form>

            <div class="resultados">
                <h2>LISTA DE PRODUCTOS</h2>
                <div class="resultados">
                    <?php echo mostrarProductos($_SESSION['productos']); ?>
                </div>

                <label>Precio promedio de productos: $<?php echo number_format(calcularPrecioPromedio($_SESSION['productos']), 2); ?></label>
            </div>    
        </div>


        <footer class="footer">
            <p>Desarrollado por Brenda Paola Navarro Alatorre</p>
        </footer>
    </main>
</body>
</html>
