<div class="container">
    <h3>Formulario de Registro</h3>

    <form action="<?= BASE_URL ?>Auth/register" method="POST">

        <!-- Campo Nombre -->
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]" id="nombre" value="<?= isset($_SESSION['userData']['nombre']) ?
            htmlspecialchars($_SESSION['userData']['nombre']) : '' ?>"
               class="<?= isset($_SESSION['errors']['nombre']) ? 'error' : '' ?>">

        <?php if (isset($_SESSION['errors']['nombre'])): ?>
            <div class="error"><?= $_SESSION['errors']['nombre']; ?></div>
        <?php endif; ?>

        <!-- Campo Apellidos -->
        <label for="apellidos">Apellidos</label>
        <input type="text" name="data[apellido]" id="apellidos" value="<?= isset($_SESSION['userData']['apellido']) ?
            htmlspecialchars($_SESSION['userData']['apellido']) : '' ?>"
               class="<?= isset($_SESSION['errors']['apellido']) ? 'error' : '' ?>">

        <?php if (isset($_SESSION['errors']['apellido'])): ?>
            <div class="error"><?= $_SESSION['errors']['apellido']; ?></div>
        <?php endif; ?>

        <!-- Campo Email -->
        <label for="email">Email</label>
        <input type="text" name="data[email]" id="email" value="<?= isset($_SESSION['userData']['email']) ?
            htmlspecialchars($_SESSION['userData']['email']) : '' ?>"
               class="<?= isset($_SESSION['errors']['email']) ? 'error' : '' ?>">

        <?php if (isset($_SESSION['errors']['email'])): ?>
            <div class="error"><?= $_SESSION['errors']['email']; ?></div>
        <?php endif; ?>

        <!-- Campo Contraseña -->
        <label for="pass">Contraseña</label>
        <input type="password" name="data[password]" id="pass" class="<?= isset($_SESSION['errors']['password']) ? 'error' : '' ?>">
        <?php if (isset($_SESSION['errors']['password'])): ?>
            <div class="error"><?= $_SESSION['errors']['password']; ?></div>
        <?php endif; ?>

        <!-- Botón de Envío -->
        <input type="submit" value="Registrarse">
    </form>
</div>
<?php
unset($_SESSION['errors']);
?>