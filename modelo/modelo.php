<?php

class Modelo {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public static function validarCredenciales($dbh, $nick, $password) {
        $stmt = $dbh->prepare("SELECT * FROM usuarios WHERE NICK = ? AND PASSWORD = ?");
        $stmt->execute([$nick, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function obtenerTipoUsuario($idUsuario) {
        $stmt = $this->dbh->prepare("SELECT tipo FROM usuarios WHERE ID = ?");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchColumn();
    }

    public static function obtenerUsuariosPaginados($dbh, $offset, $registrosPorPagina) {
        $stmtUsuarios = $dbh->prepare("SELECT * FROM usuarios LIMIT $offset, $registrosPorPagina");
        $stmtUsuarios->execute();
        return $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerTotalUsuarios($dbh) {
        $stmtTotalUsuarios = $dbh->query("SELECT COUNT(*) FROM usuarios");
        return $stmtTotalUsuarios->fetchColumn();
    }

    public static function obtenerRegistrosPaginados($dbh, $offset, $registrosPorPagina) {
        $stmtRegistros = $dbh->prepare("SELECT * FROM logs ORDER BY fecha DESC LIMIT $offset, $registrosPorPagina");
        $stmtRegistros->execute();
        return $stmtRegistros->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerTotalRegistros($dbh) {
        $stmtTotalRegistros = $dbh->query("SELECT COUNT(*) FROM logs");
        return $stmtTotalRegistros->fetchColumn();
    }

    public static function obtenerEntradasPaginadas($dbh, $offset, $registrosPorPagina, $direccion) {
        $stmtEntradas = $dbh->prepare("SELECT entradas.*, categorias.NOMBRE AS NOMBRE_CATEGORIA, usuarios.NICK AS NICK_USUARIO
                    FROM entradas
                    LEFT JOIN categorias ON entradas.CATEGORIA_ID = categorias.ID
                    LEFT JOIN usuarios ON entradas.USUARIO_ID = usuarios.ID
                    ORDER BY FECHA $direccion
                    LIMIT $offset, $registrosPorPagina");
        $stmtEntradas->execute();
        return $stmtEntradas->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerTotalEntradas($dbh) {
        $stmtTotalEntradas = $dbh->query("SELECT COUNT(*) FROM entradas");
        return $stmtTotalEntradas->fetchColumn();
    }

    public static function registrarUsuario($dbh, $nick, $nombre, $apellidos, $email, $password, $imagen, $tipo) {
        try {
            // Mover la imagen a la carpeta de uploads
            $ruta = "images/" . $imagen["name"];
            move_uploaded_file($imagen["tmp_name"], $ruta);

            // Realizar el registro del usuario
            $stmt = $dbh->prepare("INSERT INTO usuarios (NICK, NOMBRE, APELLIDOS, EMAIL, PASSWORD, IMAGEN_AVATAR, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nick, $nombre, $apellidos, $email, $password, $ruta, $tipo]);

            // Obtener el ID del usuario recién registrado
            $idUsuario = $dbh->lastInsertId();

            // Obtener el nombre de usuario
            $stmtUsuario = $dbh->prepare("SELECT NICK FROM usuarios WHERE ID = ?");
            $stmtUsuario->execute([$idUsuario]);
            $nombreUsuario = $stmtUsuario->fetchColumn();

            // Registrar el log con el ID del usuario
            $stmtLog = $dbh->prepare("INSERT INTO logs (fecha, hora, usuario, tipo_operacion) VALUES (CURDATE(), CURTIME(), ?, 'Registro de usuario (ID: $idUsuario)')");
            $stmtLog->execute([$nombreUsuario]);

            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function registrarEntrada($dbh, $categoriaId, $titulo, $imagen, $contenido, $idUsuario) {
        try {
            // Mover la imagen a la carpeta de images
            $ruta = "images/" . $imagen["name"];
            move_uploaded_file($imagen["tmp_name"], $ruta);

            // Realizar el registro de la entrada
            $stmt = $dbh->prepare("INSERT INTO entradas (CATEGORIA_ID, TITULO, IMAGEN, DESCRIPCION, USUARIO_ID, FECHA) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$categoriaId, $titulo, $ruta, $contenido, $idUsuario]);

            // Obtener el ID de la entrada recién añadida
            $idEntrada = $dbh->lastInsertId();

            // Obtener el nombre de usuario
            $stmtUsuario = $dbh->prepare("SELECT NICK FROM usuarios WHERE ID = ?");
            $stmtUsuario->execute([$idUsuario]);
            $nombreUsuario = $stmtUsuario->fetchColumn();

            // Registrar el log con el ID de la entrada
            $stmtLog = $dbh->prepare("INSERT INTO logs (fecha, hora, usuario, tipo_operacion) VALUES (CURDATE(), CURTIME(), ?, 'Registro de entrada (ID: $idEntrada)')");
            $stmtLog->execute([$nombreUsuario]);

            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function registrarCategoria($dbh, $nombreCategoria, $idUsuario) {
        try {
            // Realizar el registro de la categoría
            $stmt = $dbh->prepare("INSERT INTO categorias (NOMBRE) VALUES (?)");
            $stmt->execute([$nombreCategoria]);

            // Obtener el nombre de usuario
            $stmtUsuario = $dbh->prepare("SELECT NICK FROM usuarios WHERE ID = ?");
            $stmtUsuario->execute([$idUsuario]);
            $nombreUsuario = $stmtUsuario->fetchColumn();

            // Obtener el ID de la categoría recién creada
            $idCategoria = $dbh->lastInsertId();

            // Registrar el log con el ID de la categoría
            $stmtLog = $dbh->prepare("INSERT INTO logs (fecha, hora, usuario, tipo_operacion) VALUES (CURDATE(), CURTIME(), ?, 'Registro de categoría (ID: $idCategoria)')");
            $stmtLog->execute([$nombreUsuario]);

            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public function obtenerUsuario($idUsuario) {
        $stmt = $this->dbh->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarUsuario($idUsuario, $nuevoNick, $nuevoNombre, $nuevoApellido, $nuevoEmail, $nuevoPassword, $rutaFoto) {
        $stmt = $this->dbh->prepare("UPDATE usuarios SET NICK = ?, NOMBRE = ?, APELLIDOS = ?, EMAIL = ?, PASSWORD = ?, IMAGEN_AVATAR = ? WHERE ID = ?");
        return $stmt->execute([$nuevoNick, $nuevoNombre, $nuevoApellido, $nuevoEmail, $nuevoPassword, $rutaFoto, $idUsuario]);
    }

    public function obtenerEntradaPorId($id) {
        $stmt = $this->dbh->prepare("SELECT * FROM entradas WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerTodasLasCategorias() {
        $stmt = $this->dbh->query("SELECT * FROM categorias");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEntrada($idEntrada, $nuevoTitulo, $nuevoContenido, $nuevaCategoria, $nuevaImagen) {
        $stmt = $this->dbh->prepare("UPDATE entradas SET TITULO = ?, DESCRIPCION = ?, CATEGORIA_ID = ? WHERE ID = ?");
        $stmt->execute([$nuevoTitulo, $nuevoContenido, $nuevaCategoria, $idEntrada]);

        if ($nuevaImagen["size"] > 0) {
            $imagen = $nuevaImagen["name"];
            $imagen_temporal = $nuevaImagen["tmp_name"];
            $ruta = "images/" . $imagen;
            move_uploaded_file($imagen_temporal, $ruta);

            $stmtImagen = $this->dbh->prepare("UPDATE entradas SET IMAGEN = ? WHERE ID = ?");
            $stmtImagen->execute([$ruta, $idEntrada]);
        }
    }

    public function obtenerUsuarioPorId($idUsuario) {
        $stmt = $this->dbh->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerCategoriaPorId($idCategoria) {
        $stmt = $this->dbh->prepare("SELECT NOMBRE FROM categorias WHERE ID = ?");
        $stmt->execute([$idCategoria]);
        return $stmt->fetchColumn();
    }
}

?>