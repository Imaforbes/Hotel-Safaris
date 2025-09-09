<?php
require_once 'conexion.php';
if (isset($_POST['codigo_hab'], $_POST['tipo_hab'], $_POST['hab_disp'])) {
    $sql = "INSERT INTO habitaciones(codigo_hab, tipo_hab, hab_disp) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['codigo_hab'], $_POST['tipo_hab'], $_POST['hab_disp']]);
    header("Location: ../recepcion.php");
    exit();
}
