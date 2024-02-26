<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once '../includes/header.php';?>
    <meta charset="UTF-8">
    <title>Contenido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>    
    <?php include_once '../includes/menu.php'?>
    <?php foreach ($parametros['datos'] as $datos): ?>
        <div class="card text-center">
            <div class="card-header">
                <?= $datos['nombre']?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $datos['titulo'] ?></h5>
                <p class="card-text"><?= $datos['descripcion'] ?></p>
                
                <?php if($_SESSION['esAdmin']){?>
                    <a class="btn btn-warning" href="index.php?accion=editar&id=<?= $datos['id']?>" role="button">Editar</a>
                    <a class="btn btn-primary" href="index.php?accion=entrada&id=<?= $datos['id']?>" role="button">Detalles</a>
                    <a class="btn btn-danger" href="index.php?accion=entrada&id=<?= $datos['id']?>&borrar=true" role="button">Eliminar</a>
                <?php }else{?>
                <a href="index.php?accion=entrada&id=<?= $datos['id']?>" class="btn btn-primary">Leer Más</a>
                <?php }?>
            </div>
            <div class="card-footer text-muted">
            <?= $datos['fecha']?> // <?= $datos['nick']?>
            </div>
        </div><br>


    <?php endforeach; ?>
    <?php include_once 'paginado.php' ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
