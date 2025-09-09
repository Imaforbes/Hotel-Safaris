<?php
session_start();
require_once 'conexion.php';

// Seguridad: solo los administradores pueden actualizar
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir todos los datos del formulario
    $codigo_empl = $_POST['Codigo_empl'];
    $usuario = $_POST['Usuario'];
    $nombre = $_POST['Nombre'];
    $apellidos = $_POST['Apellidos'];
    $cargo = $_POST['Cargo'];
    $rol = $_POST['rol'];
    $nueva_pass = $_POST['passwor'];

    // Lógica para actualizar la contraseña SÓLO si se proporcionó una nueva
    if (!empty($nueva_pass)) {
        // Si hay nueva contraseña, la hasheamos y la incluimos en la consulta
        $hashed_password = password_hash($nueva_pass, PASSWORD_DEFAULT);
        $sql = "UPDATE empleados SET Usuario=?, Nombre=?, Apellidos=?, Cargo=?, rol=?, passwor=? WHERE Codigo_empl=?";
        $params = [$usuario, $nombre, $apellidos, $cargo, $rol, $hashed_password, $codigo_empl];
    } else {
        // Si no hay nueva contraseña, la consulta no la modifica
        $sql = "UPDATE empleados SET Usuario=?, Nombre=?, Apellidos=?, Cargo=?, rol=? WHERE Codigo_empl=?";
        $params = [$usuario, $nombre, $apellidos, $cargo, $rol, $codigo_empl];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: ../administrador.php");
    exit();
}
