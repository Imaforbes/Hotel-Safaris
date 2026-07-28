<?php
// Evitar recrear la conexión si ya existe
if (!isset($pdo) || !($pdo instanceof PDO)) {
    $bd = 'hotel';
    $user = 'root';
    $charset = 'utf8mb4';

    // Soporte universal para MAMP (macOS) y XAMPP/WAMP (Windows/Linux)
    $socket_mamp = '/Applications/MAMP/tmp/mysql/mysql.sock';
    if (file_exists($socket_mamp)) {
        $dsn = "mysql:unix_socket=$socket_mamp;dbname=$bd;charset=$charset";
    } else {
        $dsn = "mysql:host=localhost;dbname=$bd;charset=$charset";
    }

    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Intenta primero con contraseña 'root' (estándar de MAMP macOS) y si falla intenta vacía '' (estándar XAMPP)
    try {
        $pdo = new PDO($dsn, $user, 'root', $opciones);
    } catch (PDOException $e1) {
        try {
            $pdo = new PDO($dsn, $user, '', $opciones);
        } catch (PDOException $e2) {
            die('Error al conectar con la base de datos (MAMP/XAMPP): ' . htmlspecialchars($e2->getMessage()));
        }
    }
}
