<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles de Entrada</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Detalles de Entrada</h2>

        <div class="card">
            <?php if ($entrada['IMAGEN'] != null) { ?>
                <img src="<?php echo $entrada['IMAGEN']; ?>" class="card-img-top img-fluid" alt="Imagen de la entrada">
            <?php } ?>
            <div class="card-body">
                <h5 class="card-title"><?php echo $entrada['TITULO']; ?></h5>
                <p class="card-text"><?php echo $entrada['DESCRIPCION']; ?></p>
                <p class="card-text"><strong>Autor:</strong> <?php echo $autor; ?></p>
                <p class="card-text"><strong>Categoría:</strong> <?php echo $categoria; ?></p>
                <p class="card-text"><strong>Fecha de Creación:</strong> <?php echo $entrada['FECHA']; ?></p>
            </div>
        </div>

        <form method="post" class="mt-3">
            <button type="submit" name="generar_pdf" class="btn btn-primary">Generar PDF</button>
        </form>

        <a href="listado_entradas.php" class="btn btn-secondary mt-3">Volver al Listado</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
