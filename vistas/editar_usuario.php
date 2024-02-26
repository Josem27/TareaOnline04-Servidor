<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Usuario</h2>
        <form method="post" action="index.php?accion=actualizarUsuario" enctype="multipart/form-data">
            <input type="hidden" name="idUsuario" value="<?php echo $usuario['ID']; ?>">
            
            <div class="form-group">
                <label for="nuevoNick">Nick:</label>
                <input type="text" id="nuevoNick" name="nuevoNick" class="form-control" value="<?php echo $usuario['NICK']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nuevoNombre">Nombre:</label>
                <input type="text" id="nuevoNombre" name="nuevoNombre" class="form-control" value="<?php echo $usuario['NOMBRE']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nuevoApellido">Apellidos:</label>
                <input type="text" id="nuevoApellido" name="nuevoApellido" class="form-control" value="<?php echo $usuario['APELLIDOS']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nuevoEmail">Email:</label>
                <input type="email" id="nuevoEmail" name="nuevoEmail" class="form-control" value="<?php echo $usuario['EMAIL']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nuevoPassword">Contraseña:</label>
                <input type="password" id="nuevoPassword" name="nuevoPassword" class="form-control" value="<?php echo $usuario['PASSWORD']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nuevaFoto">Nueva Foto:</label>
                <input type="file" id="nuevaFoto" name="nuevaFoto" class="form-control-file" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <a href="listado_usuarios.php" class="btn btn-secondary mt-3">Volver al Listado</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
