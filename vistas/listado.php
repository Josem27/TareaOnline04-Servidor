<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once 'includes/header.php';?>
    <meta charset="UTF-8">
    <title>Contenido</title>
</head>
<body>    
    <?php include_once 'includes/menu.php'?>
    
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Nick</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parametros['datos'] as $datos): ?>
                    <tr>
                        <td><?= $datos['nombre'] ?></td>
                        <td><?= $datos['titulo'] ?></td>
                        <td><?= substr($datos['descripcion'], 0, 45) . (strlen($datos['descripcion']) > 45 ? '...' : '') ?></td>
                        <td><?= $datos['fecha'] ?></td>
                        <td><?= $datos['nick'] ?></td>
                        <td>
                            <?php if ($_SESSION['esAdmin']): ?>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-primary" href="index.php?accion=editar&id=<?= $datos['id'] ?>" role="button">Editar</a>
                                    <a class="btn btn-info" href="index.php?accion=entrada&id=<?= $datos['id'] ?>" role="button">Detalles</a>
                                    <a class="btn btn-danger" href="index.php?accion=eliminar&id=<?= $datos['id'] ?>" role="button">Eliminar</a>
                                </div>
                            <?php else: ?>
                                <a href="index.php?accion=entrada&id=<?= $datos['id'] ?>" class="btn btn-info">Detalles</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include_once 'paginado.php' ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
