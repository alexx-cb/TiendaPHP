<h3>Formulario de Registro</h3>

<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
    <div style="color: red; margin-bottom: 10px;">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']);?>
<?php endif; ?>

<form action="<?= BASE_URL ?>Auth/register" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="data[nombre]" id="nombre" value="<?= isset($userData['nombre']) ? htmlspecialchars($userData['nombre']) : '' ?>">
    <?php if (isset($errors['nombre'])): ?>
        <div style="color: red;"><?= $errors['nombre']; ?></div>
    <?php endif; ?>
    <br><br>

    <label for="apellidos">Apellidos</label>
    <input type="text" name="data[apellidos]" id="apellidos" value="<?= isset($userData['apellidos']) ? htmlspecialchars($userData['apellidos']) : '' ?>">
    <?php if (isset($errors['apellidos'])): ?>
        <div style="color: red;"><?= $errors['apellidos']; ?></div>
    <?php endif; ?>
    <br><br>

    <label for="email">Email</label>
    <input type="text" name="data[email]" id="email" value="<?= isset($userData['email']) ? htmlspecialchars($userData['email']) : '' ?>">
    <?php if (isset($errors['email'])): ?>
        <div style="color: red;"><?= $errors['email']; ?></div>
    <?php endif; ?>
    <br><br>

    <label for="pass">Contraseña</label>
    <input type="password" name="data[password]" id="pass">
    <?php if (isset($errors['password'])): ?>
        <div style="color: red;"><?= $errors['password']; ?></div>
    <?php endif; ?>
    <br><br>

    <input type="submit" value="Registrarse">
</form>
