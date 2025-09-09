<?php
header('Content-Type: application/json');
require_once 'conexion.php';
session_start();

$response = ['success' => false, 'message' => 'Petición incorrecta o no autorizada.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin' && isset($_POST['Codigo_empl'])) {

    $codigo_empl = $_POST['Codigo_empl'];

    try {
        // Primero, verificamos que el admin no se esté eliminando a sí mismo.
        $stmt_check = $pdo->prepare("SELECT Usuario FROM empleados WHERE Codigo_empl = ?");
        $stmt_check->execute([$codigo_empl]);
        $empleado = $stmt_check->fetch();

        if ($empleado && $empleado['Usuario'] === $_SESSION['usuario']) {
            $response['message'] = 'Error: No puedes eliminar tu propia cuenta.';
        } else {
            // Si no es el mismo usuario, proceder con el borrado.
            $stmt_delete = $pdo->prepare("DELETE FROM empleados WHERE Codigo_empl = ?");
            if ($stmt_delete->execute([$codigo_empl])) {
                $response['success'] = true;
                $response['message'] = 'Empleado eliminado con éxito.';
            } else {
                $response['message'] = 'La operación de borrado no se completó.';
            }
        }
    } catch (PDOException $e) {
        // Si ocurre un error en la base de datos, lo capturamos.
        $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    }
}

echo json_encode($response);
exit();
