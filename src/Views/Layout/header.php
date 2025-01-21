</<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="<?=BASE_URL?>">
</head>
<body>

    <h1>Mi Tienda</h1>
    <nav>
        <?php if (!isset($_SESSION['user'])): ?>
        <ul>
            <li><a href="<?=BASE_URL?>">Inicio</a></li>
            <li><a href="<?=BASE_URL?>Auth/register">Registrar</a></li>
            <li><a href="<?=BASE_URL?>Auth/login">Iniciar Sesion</a></li>
            <li><a href="<?=BASE_URL?>Carrito/verCarrito">Carrito</a></li>
        </ul>

        <?php else: ?>

        <h2>Hola <?= $_SESSION['user']?></h2>
        <ul>
            <li><a href="<?=BASE_URL?>">Inicio</a></li>
            <li><a href="<?=BASE_URL?>Productos/showProductos">Ver Productos</a></li>
            <li><a href="<?=BASE_URL?>Carrito/verCarrito">Carrito</a></li>



        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <li><a href="<?=BASE_URL?>Productos/newProducto">Crear Producto</a></li>
            <li><a href="<?=BASE_URL?>Categorias/newCategoria">Crear Categoria</a></li>

            </ul>
        <?php endif; ?>
        <li><a href="<?=BASE_URL?>Auth/logout">Cerrar Sesion</a></li>
    </nav>
        <?php endif; ?>
