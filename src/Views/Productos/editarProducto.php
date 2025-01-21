<h1>Editar Producto</h1>

<?php
$fechaActual = date('Y-m-d');
?>

<form action="<?= BASE_URL ?>Productos/editarProducto" method="POST">
    <input type="hidden" name="data[id]" value="<?= htmlspecialchars($producto->getId()) ?>">


    <label for="nombre">Nombre:</label>
    <input type="text" name="data[nombre]" id="nombre"
           value="<?= htmlspecialchars($producto->getNombre()) ?>">
    <?php if (isset($_SESSION['errors']['nombre'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['nombre']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="descripcion">Descripción:</label>
    <textarea name="data[descripcion]" id="descripcion"><?= htmlspecialchars($producto->getDescripcion()) ?></textarea>
    <?php if (isset($_SESSION['errors']['descripcion'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['descripcion']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="precio">Precio:</label>
    <input type="text" name="data[precio]" id="precio"
           value="<?= htmlspecialchars($producto->getPrecio()) ?>">
    <?php if (isset($_SESSION['errors']['precio'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['precio']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="stock">Stock:</label>
    <input type="number" name="data[stock]" id="stock"
           value="<?= htmlspecialchars($producto->getStock()) ?>">
    <?php if (isset($_SESSION['errors']['stock'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['stock']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="oferta">Oferta:</label>
    <input type="number" name="data[oferta]" id="oferta"
           value="<?= htmlspecialchars($producto->getOferta()) ?>">
    <?php if (isset($_SESSION['errors']['oferta'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['oferta']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="imagen">Imagen:</label>
    <input type="text" name="data[imagen]" id="imagen"
           value="<?= htmlspecialchars($producto->getImagen()) ?>">
    <?php if (isset($_SESSION['errors']['imagen'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['imagen']); ?></div>
    <?php endif; ?>
    <br><br>

    <input type="hidden" name="data[fecha]" value="<?= $fechaActual ?>">

    <button type="submit">Actualizar Producto</button>
</form>

<?php
unset($_SESSION['errors']);
?>
