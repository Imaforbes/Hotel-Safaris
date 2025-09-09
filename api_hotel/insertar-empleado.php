<?php
require_once 'conexion.php';
if (isset($_POST['Codigo_empl'], $_POST['Usuario'], $_POST['passwor'], $_POST['Nombre'], $_POST['Apellidos'], $_POST['Cargo'], $_POST['rol'])) {
    $hashed_password = password_hash($_POST['passwor'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO empleados(Codigo_empl, Usuario, passwor, Nombre, Apellidos, Cargo, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['Codigo_empl'],
        $_POST['Usuario'],
        $hashed_password,
        $_POST['Nombre'],
        $_POST['Apellidos'],
        $_POST['Cargo'],
        $_POST['rol']
    ]);

    header("Location: ../administrador.php");
    exit();
}
