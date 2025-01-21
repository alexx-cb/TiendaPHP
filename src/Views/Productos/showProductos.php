<h2 style="text-align: center; margin: 20px 0;">Listado de todos los productos</h2>

<div class="productos-container">

    <?php if (!empty($productos) && is_array($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <h3><?php echo htmlspecialchars($producto->getNombre()); ?></h3>
                <div class="imagen-container">
                    <img src="<?php echo htmlspecialchars($producto->getImagen()); ?>" alt="Imagen de <?php echo htmlspecialchars($producto->getNombre()); ?>">
                </div>
                <p><?php echo htmlspecialchars($producto->getDescripcion()); ?></p>
                <p>Precio: <?php echo number_format($producto->getPrecio(), 2); ?> €</p>
                <p>Stock: <?php echo (int)$producto->getStock(); ?></p>


                <form action="<?=BASE_URL?>Carrito/addCarrito" method="POST">
                    <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">
                    <input type="submit" value="Añadir al carrito">
                </form>

                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === "admin"): ?>
                    <div class="admin-buttons">

                        <form action="<?=BASE_URL?>Productos/editarProductoForm" method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">
                            <button type="submit" style="background-color: #007bff; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;">Editar</button>
                        </form>


                        <form action="<?=BASE_URL?>Productos/eliminarProducto" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                            <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">
                            <button type="submit" style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;">Eliminar</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center; width: 100%;">No hay productos disponibles.</p>
    <?php endif; ?>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .productos-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
        padding: 20px;
    }
    .producto {
        width: calc(25% - 20px); /* Ajusta al 25% menos el espacio entre los productos */
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
        padding: 10px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .producto h3 {
        font-size: 1.5rem;
        margin: 10px 0;
    }
    .imagen-container {
        width: 100%;
        max-height: 300px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        border-radius: 15px;
    }
    .imagen-container img {
        width: 100%;
        height: auto;
        object-fit: contain;
        border-radius: 5px;
    }
    .producto p {
        margin: 5px 0;
        font-size: 0.9rem;
    }
    .producto button {
        margin-top: 10px;
        padding: 8px 15px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
    }
    .producto button:hover {
        background-color: #0056b3;
    }

    /* Estilos responsivos */
    @media (max-width: 1200px) {
        .producto {
            width: calc(33.33% - 20px); /* 3 productos por fila */
        }
    }
    @media (max-width: 768px) {
        .producto {
            width: calc(50% - 20px); /* 2 productos por fila */
        }
    }
    @media (max-width: 480px) {
        .producto {
            width: calc(100% - 20px); /* 1 producto por fila */
        }
    }
</style>
