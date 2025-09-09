<?php
// Evitar recrear la conexión si ya existe
if (!isset($pdo) || !($pdo instanceof PDO)) {
    $host = 'localhost';
    $bd = 'hotel';
    $user = 'root';
    $pw = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$bd;charset=$charset";

    try {
        $pdo = new PDO($dsn, $user, $pw, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        die('Error al conectar con la base de datos: ' . $e->getMessage());
    }
}
