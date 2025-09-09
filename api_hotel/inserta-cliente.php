<?php
require_once 'conexion.php';
if (isset($_POST['codigo_cli'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['dni_cli'])) {
    $sql = "INSERT INTO cliente(codigo_cli, nombre, direccion, telefono, dni_cli) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['codigo_cli'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['dni_cli']]);
    header("Location: ../recepcion.php");
    exit();
}
