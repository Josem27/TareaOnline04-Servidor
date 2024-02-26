<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once 'includes/header.php'; ?>
    <meta charset="UTF-8">
    <title>Detalles de la entrada</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php foreach ($parametros['datos'] as $datos): ?>
        <div class="container cuerpo text-center">
            <h2>Entrada de: <?= $datos['nick']; ?></h2>
            <hr width="50%" color="black">
        </div>
        <div class="container cuerpo text-center">
            <a class="btn btn-primary" href="index.php?accion=listado" role="button">Volver</a>
            <hr width="50%" color="black">
        </div>
        <div class="container text-center">
            <label for="titulo" class="form-label">Título</label><br>
            <label for="titulo"><?= $datos['titulo'] ?></label><br>

            <label for="imagen">Imagen</label><br>
            <img src="fotos/<?= $datos['imagen']; ?>" width="260"><br>

            <label for="categoria">Categoría:</label><br>
            <label for="categoria"><?= $datos['nombre'] ?></label><br>

            <div>
                <label for="descripcion">Descripción:</label><br>
                <label for=""><?= $datos['descripcion'] ?></label><br>

                <?php if(isset($_GET['borrar'])){ ?>
                <a class="btn btn-danger" href="index.php?accion=eliminar&id=<?= $datos['id'] ?>" role="button">Eliminar</a>
                <?php } ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
