<?php
require_once 'modelo/modelo.php';
require_once 'config.php';

$dbh = include 'config.php';

if ($dbh === null) {
    die("Error: La conexión a la base de datos es nula.");
}

class Controlador {

    public static function iniciarSesion($dbh, $nick, $password) {
        $user = Modelo::validarCredenciales($dbh, $nick, $password);

        if ($user && $password === $user['PASSWORD']) {
            $_SESSION["ID"] = $user['ID'];
            header("Location: vistas/panelControl.php");
            exit();
        } else {
            return "Credenciales incorrectas";
        }
    }

    public static function listarUsuarios($dbh, $paginaActual, $registrosPorPagina) {
        $offset = ($paginaActual - 1) * $registrosPorPagina;
        $usuarios = Modelo::obtenerUsuariosPaginados($dbh, $offset, $registrosPorPagina);
        $totalUsuarios = Modelo::obtenerTotalUsuarios($dbh);
        $totalPaginas = ceil($totalUsuarios / $registrosPorPagina);
        $tipoUsuario = Modelo::obtenerTipoUsuario($dbh, $_SESSION["ID"]);

        include 'listado_usuarios.php';
    }

    public static function listarLogs($dbh, $paginaActual, $registrosPorPagina) {
        $offset = ($paginaActual - 1) * $registrosPorPagina;
        $registros = Modelo::obtenerRegistrosPaginados($dbh, $offset, $registrosPorPagina);
        $totalRegistros = Modelo::obtenerTotalRegistros($dbh);
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        include 'listado_logs.php';
    }

    public static function listarEntradas($dbh, $paginaActual, $registrosPorPagina, $direccion) {
        $offset = ($paginaActual - 1) * $registrosPorPagina;
        $entradas = Modelo::obtenerEntradasPaginadas($dbh, $offset, $registrosPorPagina, $direccion);
        $totalEntradas = Modelo::obtenerTotalEntradas($dbh);
        $totalPaginas = ceil($totalEntradas / $registrosPorPagina);

        include 'listado_entradas.php';
    }

    public static function registrarUsuario($dbh, $nick, $nombre, $apellidos, $email, $password, $imagen, $tipo) {
        $resultado = Modelo::registrarUsuario($dbh, $nick, $nombre, $apellidos, $email, $password, $imagen, $tipo);
        if ($resultado === true) {
            header("Location: vistas/panelControl.php");
            exit();
        } else {
            return $resultado;
        }
    }

    public static function registrarEntrada($dbh, $categoriaId, $titulo, $imagen, $contenido, $idUsuario) {
        $resultado = Modelo::registrarEntrada($dbh, $categoriaId, $titulo, $imagen, $contenido, $idUsuario);
        if ($resultado === true) {
            header("Location: vistas/panelControl.php");
            exit();
        } else {
            return $resultado;
        }
    }

    public static function registrarCategoria($dbh, $nombreCategoria, $idUsuario) {
        $resultado = Modelo::registrarCategoria($dbh, $nombreCategoria, $idUsuario);
        if ($resultado === true) {
            header("Location: vistas/panelControl.php");
            exit();
        } else {
            return $resultado;
        }
    }

    public static function eliminarUsuario($dbh, $idUsuario) {
        $stmtUsuario = $dbh->prepare("SELECT NICK FROM usuarios WHERE ID = ?");
        $stmtUsuario->execute([$_SESSION["ID"]]);
        $nombreUsuario = $stmtUsuario->fetchColumn();

        $stmtEliminar = $dbh->prepare("DELETE FROM usuarios WHERE ID = ?");
        $stmtEliminar->execute([$idUsuario]);

        $stmtLog = $dbh->prepare("INSERT INTO logs (fecha, hora, usuario, tipo_operacion) VALUES (CURDATE(), CURTIME(), ?, 'Eliminación de usuario (ID: $idUsuario)')");
        $stmtLog->execute([$nombreUsuario]);

        echo "El usuario se eliminó correctamente.";
        header("Location: listado_usuarios.php");
        exit();
    }

    public static function eliminarEntrada($dbh, $idEntrada) {
        $stmtUsuario = $dbh->prepare("SELECT NICK FROM usuarios WHERE ID = ?");
        $stmtUsuario->execute([$_SESSION["ID"]]);
        $nombreUsuario = $stmtUsuario->fetchColumn();

        $stmtEliminar = $dbh->prepare("DELETE FROM entradas WHERE ID = ?");
        $stmtEliminar->execute([$idEntrada]);

        $stmtLog = $dbh->prepare("INSERT INTO logs (fecha, hora, usuario, tipo_operacion) VALUES (CURDATE(), CURTIME(), ?, 'Eliminación de entrada (ID: $idEntrada)')");
        $stmtLog->execute([$nombreUsuario]);

        echo "La entrada se eliminó correctamente.";
        header("Location: listado_entradas.php");
        exit();
    }

    public static function editarUsuario($idUsuario) {
        $usuario = Modelo::obtenerUsuario($idUsuario);
        require_once 'views/editar_usuario.php';
    }

    public static function actualizarUsuario($idUsuario, $nuevoNick, $nuevoNombre, $nuevoApellido, $nuevoEmail, $nuevoPassword, $rutaFoto) {
        Modelo::actualizarUsuario($idUsuario, $nuevoNick, $nuevoNombre, $nuevoApellido, $nuevoEmail, $nuevoPassword, $rutaFoto);
        header("Location: listado_usuarios.php");
    }

    public static function editarEntrada($dbh, $idEntrada) {
        $entrada = EntradaModelo::obtenerEntradaPorId($dbh, $idEntrada);
        $categorias = Modelo::obtenerTodasLasCategorias($dbh);
        require_once 'views/editar_entrada.php';
    }

    public static function actualizarEntrada($dbh, $idEntrada, $nuevoTitulo, $nuevoContenido, $nuevaCategoria, $nuevaImagen) {
        Modelo::actualizarEntrada($dbh, $idEntrada, $nuevoTitulo, $nuevoContenido, $nuevaCategoria, $nuevaImagen);
        header("Location: listado_entradas.php");
    }

    public static function detallesUsuario($dbh, $idUsuario) {
        if (!isset($idUsuario) || !is_numeric($idUsuario)) {
            header("Location: listado_usuarios.php");
            exit();
        }

        $usuario = Modelo::obtenerUsuarioPorId($dbh, $idUsuario);

        if (!$usuario) {
            header("Location: listado_usuarios.php");
            exit();
        }

        require_once 'views/detalles_usuario.php';
    }

    public static function detallesEntrada($dbh, $idEntrada) {
        if (!isset($idEntrada) || !is_numeric($idEntrada)) {
            header("Location: listado_entradas.php");
            exit();
        }

        $entrada = Modelo::obtenerEntradaPorId($dbh, $idEntrada);

        if (!$entrada) {
            header("Location: listado_entradas.php");
            exit();
        }

        $autor = Modelo::obtenerUsuarioPorId($dbh, $entrada['USUARIO_ID']);
        $categoria = Modelo::obtenerCategoriaPorId($dbh, $entrada['CATEGORIA_ID']);

        require_once 'views/detalles_entrada.php';
    }
}

?>