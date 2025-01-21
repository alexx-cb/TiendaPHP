<h1>Carrito de Compras</h1>

<?php if (isset($_SESSION['error_stock'])): ?>
    <div style="color: red; text-align: center;">
        <?= $_SESSION['error_stock']; ?>
    </div>
    <?php unset($_SESSION['error_stock']); ?>
<?php endif; ?>

<?php if (empty($_SESSION['carrito'])): ?>
    <p>El carrito está vacío.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['carrito'] as $productoId => $producto): ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($producto['imagen']); ?>" alt="<?= htmlspecialchars($producto['nombre']); ?>"
                         style="max-width: 100px;">
                </td>
                <td><?= htmlspecialchars($producto['nombre']); ?></td>
                <td><?= htmlspecialchars($producto['descripcion']); ?></td>
                <td><?= number_format((float)$producto['precio'], 2); ?> €</td>
                <td>
                    <div class="cantidad-group">
                        <!-- Botón para restar cantidad -->
                        <form action="<?= BASE_URL ?>Carrito/restarProducto" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($productoId); ?>">
                            <button type="submit" style="padding: 5px;">-</button>
                        </form>
                        <span><?= htmlspecialchars($producto['cantidad']); ?></span>
                        <!-- Botón para sumar cantidad -->
                        <form action="<?= BASE_URL ?>Carrito/sumarProducto" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($productoId); ?>">
                            <button type="submit" style="padding: 5px;">+</button>
                        </form>
                    </div>
                </td>
                <td><?= number_format((float)$producto['precio'] * $producto['cantidad'], 2); ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" align="right"><strong>Total del Carrito:</strong></td>
            <td>
                <?php
                $total = 0;
                foreach ($_SESSION['carrito'] as $producto) {
                    $total += (float)$producto['precio'] * $producto['cantidad'];
                }
                echo number_format($total, 2) . ' €';
                ?>
            </td>
        </tr>
        </tfoot>
    </table>

    <form action="<?= BASE_URL ?>Pedido/hacerPedido" method="POST">
        <?php foreach ($_SESSION['carrito'] as $productoId => $producto): ?>
            <input type="hidden" name="productos[<?= htmlspecialchars($productoId); ?>][id]" value="<?= htmlspecialchars($productoId); ?>">
            <input type="hidden" name="productos[<?= htmlspecialchars($productoId); ?>][cantidad]" value="<?= htmlspecialchars($producto['cantidad']); ?>">
        <?php endforeach; ?>
        <div style="margin-top: 20px; text-align: center;">
            <button type="submit" style="padding: 10px 20px; font-size: 16px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Pagar Carrito</button>
        </div>
    </form>
<?php endif; ?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
        color: #333;
    }
    h1 {
        text-align: center;
        color: #444;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background: #fff;
    }
    table th, table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }
    table th {
        background-color: #f4f4f4;
    }
    table img {
        max-width: 80px;
        height: auto;
    }
    .cantidad-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    .cantidad-group form {
        margin: 0;
    }
    .cantidad-group button {
        padding: 4px 8px;
        border: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    .cantidad-group button:hover {
        background-color: #0056b3;
    }
    tfoot td {
        font-weight: bold;
    }
</style>
