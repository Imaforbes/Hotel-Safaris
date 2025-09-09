<?php
require_once 'conexion.php';
if (isset($_POST['codigo_hab'])) {
    $sql = "DELETE FROM habitaciones WHERE codigo_hab = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['codigo_hab']]);
    header("Location: ../recepcion.php");
    exit();
}
