<div class="container">
<h1>Login</h1>

<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
    <div style="color: red; margin-bottom: 10px;">
        <p><?= $_SESSION['errors'] ?></p>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL ?>Auth/login" method="POST">
    <label for="email">Correo</label>
    <input type="text" name="data[email]" id="email" value="<?= isset($userData['email']) ? htmlspecialchars($userData['email']) : '' ?>">
    <?php if (isset($_SESSION['errors']['email'])): ?>
        <div style="color: red;"><?= htmlspecialchars($_SESSION['errors']['email']); ?></div>
    <?php endif; ?>
    <br><br>

    <label for="pass">Contraseña</label>
    <input type="password" name="data[pass]" id="pass">
    <?php if (isset($_SESSION['errors']['pass'])): ?>
        <div style="color: red;"><?= htmlspecialchars($_SESSION['errors']['pass']); ?></div>
    <?php endif; ?>
    <br><br>

    <input type="submit" value="Iniciar Sesion">
</form>
</div>

<?php
unset($_SESSION['errors']);
?>