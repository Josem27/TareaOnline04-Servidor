<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Entradas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Listado de Entradas</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Contenido</th>
                    <th>Categoría</th>
                    <th>Autor</th>
                    <th><a href="?dir=<?php echo ($direccion === 'asc') ? 'desc' : 'asc'; ?>">Fecha de Creación <?php echo ($direccion === 'asc') ? '▲' : '▼'; ?></a></th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entradas as $entrada) { ?>
                    <tr>
                        <td>
                            <?php
                            $titulo = $entrada['TITULO'];
                            echo strlen($titulo) > 20 ? substr($titulo, 0, 20) . '...' : $titulo;
                            ?>
                        </td>
                        <td>
                            <?php
                            $contenido = $entrada['DESCRIPCION'];
                            echo strlen($contenido) > 50 ? substr($contenido, 0, 50) . '...' : $contenido;
                            ?>
                        </td>
                        <td><?php echo $entrada['NOMBRE_CATEGORIA']; ?></td>
                        <td><?php echo $entrada['NICK_USUARIO']; ?></td>
                        <td><?php echo $entrada['FECHA']; ?></td>
                        <td>
                            <?php if ($tipoUsuario == 1 || ($tipoUsuario == 0 && $idUsuario == $entrada['USUARIO_ID'])) { ?>
                                <a href="editar_entrada.php?id=<?php echo $entrada['ID']; ?>">Editar</a> |
                                <a href="eliminar_entrada.php?id=<?php echo $entrada['ID']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a> |
                            <?php } ?>
                            <a href="detalles_entrada.php?id=<?php echo $entrada['ID']; ?>">Detalles</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?php echo ($i == $paginaActual) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <!-- Ir a página específica -->
        <form class="form-inline float-right" action="" method="get">
            <label class="mr-2" for="irAPagina">Ir a página:</label>
            <input type="number" class="form-control mr-2" id="irAPagina" name="pagina" min="1" max="<?php echo $totalPaginas; ?>" value="<?php echo $paginaActual; ?>">
            <button type="submit" class="btn btn-primary">Ir</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Inicio</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
