<div class="container text-center">
    <!-- Paginación -->
    <nav aria-label="...">
        <ul class="pagination">
            <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            
            if ($page > 0) { // Si la página es mayor que 0, muestra el botón "Anterior"
            ?>
            <li class="page-item">
                <a class="page-link" href="index.php?accion=listado&page=<?= $page - 1 ?>">Anterior</a>
            </li>
            <?php
            }
            
            // Si la página es mayor o igual a 1, muestra un botón que va a la página anterior
            if ($page >= 1) {
            ?>
            <li class="page-item">
                <a class="page-link" href="index.php?accion=listado&page=<?= $page - 1 ?>"><?= $page ?></a>
            </li>
            <?php
            }
            ?>
            <!-- Este botón es continuo y muestra en qué página se encuentra el usuario -->
            <li class="page-item active">
                <span class="page-link"><?= $page + 1 ?></span>
            </li>
            <?php
            // Si la cantidad total de registros es mayor que offset + longitudPag, se muestran los botones de la siguiente página
            if ($resultModelo['paginas'] > ($resultModelo['offset'] + $resultModelo['longitudPag'])) {
            ?>
            <li class="page-item">
                <a class="page-link" href="index.php?accion=listado&page=<?= $page + 1 ?>"><?= $page + 2 ?></a>
            </li>
            <li class="page-item">
                <a class="page-link" href="index.php?accion=listado&page=<?= $page + 1 ?>">Siguiente</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</div>
