<?php
require_once 'conexion.php';
if (isset($_POST['Id'], $_POST['codigo_cli'], $_POST['codigo_act'])) {
    $sql = "INSERT INTO cliente_actividad(Id, codigo_cli, codigo_act) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['Id'], $_POST['codigo_cli'], $_POST['codigo_act']]);
    header("Location: ../empleados.html");
    exit();
}
