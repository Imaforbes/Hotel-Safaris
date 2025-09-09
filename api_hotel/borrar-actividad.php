<?php
require_once 'conexion.php';
if (isset($_POST['codigo_act'])) {
    $sql = "DELETE FROM actividades WHERE codigo_act = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['codigo_act']]);
    header("Location: ../empleados.php");
    exit();
}
