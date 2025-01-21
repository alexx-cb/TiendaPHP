<div class="container">
<h3>Crea un nuevo Producto</h3>
<form action="<?= BASE_URL ?>Productos/newProducto" method="POST">
    <?php $fecha = date("Y-m-d"); ?>
    <input type="hidden" name="data[fecha]" value="<?= $fecha; ?>">

    <label for="idCategoria">Id de Categoría</label>
    <input type="number" name="data[categoria_id]" id="idCategoria"
           value="<?= $_SESSION['old_data']['categoria_id'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['categoria_id'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['categoria_id']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="nombre">Nombre Producto</label>
    <input type="text" name="data[nombre]" id="nombre"
           value="<?= $_SESSION['old_data']['nombre'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['nombre'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['nombre']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="descripcion">Descripción Producto</label>
    <input type="text" name="data[descripcion]" id="descripcion"
           value="<?= $_SESSION['old_data']['descripcion'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['descripcion'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['descripcion']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="precio">Precio Producto</label>
    <input type="text" name="data[precio]" id="precio"
           value="<?= $_SESSION['old_data']['precio'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['precio'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['precio']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="stock">Stock Producto</label>
    <input type="text" name="data[stock]" id="stock"
           value="<?= $_SESSION['old_data']['stock'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['stock'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['stock']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="oferta">Oferta Producto</label>
    <input type="text" name="data[oferta]" id="oferta"
           value="<?= $_SESSION['old_data']['oferta'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['oferta'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['oferta']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="imagen">Imagen Producto</label>
    <input type="text" name="data[imagen]" id="imagen"
           value="<?= $_SESSION['old_data']['imagen'] ?? '' ?>">
    <?php if (isset($_SESSION['errors']['imagen'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['imagen']); ?></div>
    <?php endif; ?>
    <br><br>

    <input type="submit" value="Crear">
</form>
<?php
unset($_SESSION['errors'], $_SESSION['old_data']);
?>
<style>
    .error{
        color: red;
    }
</style>
</div>