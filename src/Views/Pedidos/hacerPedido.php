<div class="container">


<h2>Formulario de Pedido</h2>

<?php
$fechaActual = date('Y-m-d');
$horaActual = date('H:i');
?>

<form action="<?=BASE_URL?>Pedido/registrarPedido" method="POST">
    <input type="hidden" name="data[usuario_id]" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
    <input type="hidden" value="enviado" name="data[estado]">
    <input type="hidden" id="fecha" name="data[fecha]" value="<?php echo $fechaActual; ?>">
    <input type="hidden" id="hora" name="data[hora]" value="<?php echo $horaActual; ?>">

    <label for="provincia">Provincia:</label>
    <input type="text" id="provincia" name="data[provincia]" required placeholder="Ejemplo: Madrid"
           value="<?= isset($_POST['data']['provincia']) ? htmlspecialchars($_POST['data']['provincia']) : '' ?>">
    <?php if (isset($_SESSION['errors']['provincia'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['provincia']); ?></div>
    <?php endif; ?>

    <label for="localidad">Localidad:</label>
    <input type="text" id="localidad" name="data[localidad]" required placeholder="Ejemplo: Alcalá de Henares"
           value="<?= isset($_POST['data']['localidad']) ? htmlspecialchars($_POST['data']['localidad']) : '' ?>">
    <?php if (isset($_SESSION['errors']['localidad'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['localidad']); ?></div>
    <?php endif; ?>

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="data[direccion]" required placeholder="Ejemplo: Calle Mayor, 123"
           value="<?= isset($_POST['data']['direccion']) ? htmlspecialchars($_POST['data']['direccion']) : '' ?>">
    <?php if (isset($_SESSION['errors']['direccion'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['direccion']); ?></div>
    <?php endif; ?>

    <p> Coste:
        <?php
        $total = 0;
        foreach ($_SESSION['carrito'] as $producto) {
            $total += (float)$producto['precio'] * $producto['cantidad'];
        }
        echo number_format($total, 2) . ' €';
        ?>
    </p>
    <input type="hidden" name="data[coste]" value="<?php echo number_format($total, 2); ?>">

    <?php foreach ($_SESSION['carrito'] as $index => $producto): ?>
        <input type="hidden" name="data[productos][<?php echo $index; ?>][nombre]"
               value="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <input type="hidden" name="data[productos][<?php echo $index; ?>][imagen]"
               value="<?php echo htmlspecialchars($producto['imagen']); ?>">
        <input type="hidden" name="data[productos][<?php echo $index; ?>][precio]"
               value="<?php echo htmlspecialchars($producto['precio']); ?>">
        <input type="hidden" name="data[productos][<?php echo $index; ?>][producto_id]"
               value="<?php echo htmlspecialchars($producto['id']); ?>">
        <input type="hidden" name="data[productos][<?php echo $index; ?>][unidades]"
               value="<?php echo htmlspecialchars($producto['cantidad']); ?>">
    <?php endforeach; ?>

    <input type="submit" value="Realizar Pedido">
</form>

<?php
unset($_SESSION['errors']);
?>
</div>