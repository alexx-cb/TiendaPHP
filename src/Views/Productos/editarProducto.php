<div class="container">
<h1>Editar Producto</h1>

<?php
$fechaActual = date('Y-m-d');
?>

<form action="<?=BASE_URL?>Productos/editarProducto" method="POST">
    <input type="hidden" name="data[id]" value="<?= $producto->getId() ?>">


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
           value="<?= ($producto->getPrecio()) ?>">
    <?php if (isset($_SESSION['errors']['precio'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['precio']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="stock">Stock:</label>
    <input type="number" name="data[stock]" id="stock"
           value="<?= ($producto->getStock()) ?>">
    <?php if (isset($_SESSION['errors']['stock'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['errors']['stock']); ?></div>
    <?php endif; ?>
    <br><br>


    <label for="oferta">Oferta:</label>
    <input type="number" name="data[oferta]" id="oferta"
           value="<?= ($producto->getOferta()) ?>">
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
</div>
<style>
    /* Estilos Generales */
    body {
        font-family: Arial, sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
        background-color: #f4f7fc;
    }

    h1 {
        text-align: center;
        font-size: 32px;
        color: #333;
        margin-top: 20px;
    }

    /* Estilos Contenedor Principal */
    .container {
        width: 100%;
        max-width: 600px;
        margin: 50px auto;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para los Mensajes de Error */
    div.error {
        color: red;
        font-size: 14px;
        margin-top: -10px;
        margin-bottom: 10px;
    }

    div.error ul {
        padding-left: 20px;
    }

    div.error ul li {
        list-style-type: disc;
    }

    /* Estilos para el Formulario */
    form {
        display: flex;
        flex-direction: column;
        margin-top: 20px;
    }

    label {
        font-size: 16px;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        font-size: 16px;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: #0066cc;
        outline: none;
    }

    /* Estilo para el Botón de Enviar */
    button {
        font-size: 16px;
        padding: 12px;
        background-color: #0066cc;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    button:hover {
        background-color: #005bb5;
    }

    /* Estilos para campos con error */
    input[type="text"].error,
    input[type="number"].error,
    textarea.error {
        border-color: red;
    }

    /* Estilos para el Footer */
    footer {
        text-align: center;
        padding: 20px 0;
        background-color: #f1f1f1;
        margin-top: 20px;
    }

    /* Estilos de Responsividad para dispositivos móviles */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        h1 {
            font-size: 28px;
        }

        label,
        input[type="text"],
        input[type="number"],
        textarea,
        button {
            font-size: 14px;
        }
    }

</style>