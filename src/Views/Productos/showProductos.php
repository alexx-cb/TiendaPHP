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
