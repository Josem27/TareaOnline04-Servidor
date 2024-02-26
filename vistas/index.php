<?php
$dbHost = 'localhost';
$dbName = 'bdblog';
$dbUser = 'root';
$dbPass = '';

try {
    $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit();
}

require_once '../config.php';
require_once '../modelo/modelo.php';
require_once '../controlador/controlador.php'; 

$controlador = new Controlador($dbh);

// Verificar si se ha proporcionado una acción en la URL
if ($_GET && isset($_GET['accion'])) {
    $accion = filter_input(INPUT_GET, "accion", FILTER_SANITIZE_STRING);

    // Verificar si la acción existe en el controlador y llamarla si es así
    if (method_exists($controlador, $accion)) {
        // Pasar parámetros adicionales si los hay
        $params = array_slice($_GET, 2); // Ignorar 'accion' y otros parámetros
        call_user_func_array(array($controlador, $accion), $params);
    } else {
        // Si la acción no existe, llamar al método index por defecto
        $controlador->index(); 
    }
} else {
    // Si no se proporciona ninguna acción, llamar al método index por defecto
    $controlador->index(); 
}
?>
