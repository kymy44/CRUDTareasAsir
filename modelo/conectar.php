<?php
// Conectando a la db
$conexion = 'mysql:host=localhost;dbname=tareas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($conexion, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Conexión fallida: ' . $e->getMessage();
    exit;
}
?>