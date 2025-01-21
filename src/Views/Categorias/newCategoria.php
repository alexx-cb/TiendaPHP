<div class="container">
<h2>Crear una Categoria</h2>

<form action="<?= BASE_URL ?>Categorias/newCategoria" method="POST">
    <label for="nombre">Nombre de la categoría</label>
    <input type="text" name="data[nombre]" id="nombre" value="<?= isset($_POST['data']['nombre']) ? htmlspecialchars($_POST['data']['nombre']) : '' ?>">
    <br><br>

    <?php if (isset($_SESSION['errors']['nombre'])): ?>
        <div style="color: red; font-size: 14px;">
            <?= $_SESSION['errors']['nombre'] ?>
        </div>
        <?php unset($_SESSION['errors']['nombre']); ?>
    <?php endif; ?>

    <input type="submit" value="Crear">
</form>

<?php
//limpiar errores
if (isset($_SESSION['errors']) && empty($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>
</div>