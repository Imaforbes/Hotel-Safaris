<?php
require_once 'conexion.php';
if (isset($_POST['codigo_act'], $_POST['nombre_act'], $_POST['duracion_act'], $_POST['horario'], $_POST['descripcion'], $_POST['precio_act'], $_POST['huespedes_regis'], $_POST['empl_Codigo'])) {
    $sql = "INSERT INTO actividades(codigo_act, nombre_act, duracion_act, horario, descripcion, precio_act, huespedes_regis, empl_Codigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['codigo_act'], $_POST['nombre_act'], $_POST['duracion_act'], $_POST['horario'], $_POST['descripcion'], $_POST['precio_act'], $_POST['huespedes_regis'], $_POST['empl_Codigo']]);
    header("Location: ../empleados.php");
    exit();
}
