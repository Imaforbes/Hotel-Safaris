<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero_rese'])) {
    $numero_rese = $_POST['numero_rese'];

    try {
        // Antes de borrar, necesitamos saber qué habitación estaba asociada
        $stmt_get_hab = $pdo->prepare("SELECT codigo_hab FROM reserva WHERE numero_rese = ?");
        $stmt_get_hab->execute([$numero_rese]);
        $reserva = $stmt_get_hab->fetch();

        if ($reserva) {
            $codigo_hab = $reserva['codigo_hab'];

            // Iniciar una transacción
            $pdo->beginTransaction();

            // 1. Eliminar la reserva
            $stmt_delete = $pdo->prepare("DELETE FROM reserva WHERE numero_rese = ?");
            $stmt_delete->execute([$numero_rese]);

            // 2. Actualizar la habitación para que vuelva a estar disponible
            $stmt_update = $pdo->prepare("UPDATE habitaciones SET hab_disp = 'Si' WHERE codigo_hab = ?");
            $stmt_update->execute([$codigo_hab]);

            // Confirmar la transacción
            $pdo->commit();

            header("Location: ../panel-empleado.php?status=borrado_ok");
            exit();
        } else {
            header("Location: ../panel-empleado.php?status=borrado_error&message=Reserva no encontrada.");
            exit();
        }
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: ../panel-empleado.php?status=borrado_error&message=" . urlencode($e->getMessage()));
        exit();
    }
}
