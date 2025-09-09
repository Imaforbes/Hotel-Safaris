<?php
require_once 'conexion.php';
if (isset($_POST['codigo_cli'])) {
    $sql = "DELETE FROM cliente WHERE codigo_cli = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['codigo_cli']]);
    header("Location: ../recepcion.php");
    exit();
}
