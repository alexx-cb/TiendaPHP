<h3>Crea un nuevo Producto</h3>
<form action="<?= BASE_URL ?>Productos/newProducto" method="POST">

    <?php
    $fecha = date("Y-m-d");
    ?>
    <input type="hidden" name="data[fecha]" id="fecha" value="<?= $fecha; ?>">


    <label for="idCategoria">Id de Categoria</label>
    <input type="number" name="data[categoria_id]" id="idCategoria"
           value="<?= isset($_POST['data']['categoria_id']) ? htmlspecialchars($_POST['data']['categoria_id']) : '' ?>">
    <?php if (isset($_SESSION['errors']['categoria_id'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['categoria_id']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="nombre">Nombre Producto</label>
    <input type="text" name="data[nombre]" id="nombre"
           value="<?= isset($_POST['data']['nombre']) ? htmlspecialchars($_POST['data']['nombre']) : '' ?>">
    <?php if (isset($_SESSION['errors']['nombre'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['nombre']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="descripcion">Descripcion Producto</label>
    <input type="text" name="data[descripcion]" id="descripcion"
           value="<?= isset($_POST['data']['descripcion']) ? htmlspecialchars($_POST['data']['descripcion']) : '' ?>">
    <?php if (isset($_SESSION['errors']['descripcion'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['descripcion']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="precio">Precio Producto</label>
    <input type="text" name="data[precio]" id="precio"
           value="<?= isset($_POST['data']['precio']) ? htmlspecialchars($_POST['data']['precio']) : '' ?>">
    <?php if (isset($_SESSION['errors']['precio'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['precio']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="stock">Stock Producto</label>
    <input type="text" name="data[stock]" id="stock"
           value="<?= isset($_POST['data']['stock']) ? htmlspecialchars($_POST['data']['stock']) : '' ?>">
    <?php if (isset($_SESSION['errors']['stock'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['stock']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="oferta">Oferta Producto</label>
    <input type="text" name="data[oferta]" id="oferta"
           value="<?= isset($_POST['data']['oferta']) ? htmlspecialchars($_POST['data']['oferta']) : '' ?>">
    <?php if (isset($_SESSION['errors']['oferta'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['oferta']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="imagen">Imagen Producto</label>
    <input type="text" name="data[imagen]" id="imagen"
           value="<?= isset($_POST['data']['imagen']) ? htmlspecialchars($_POST['data']['imagen']) : '' ?>">
    <?php if (isset($_SESSION['errors']['imagen'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['imagen']); ?></div>
    <?php endif; ?>
    <br><br>

    <input type="submit" value="Crear">
</form>

<?php
unset($_SESSION['errors']);
?>
