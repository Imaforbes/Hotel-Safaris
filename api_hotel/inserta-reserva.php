<?php
require_once 'conexion.php';
session_start(); // Necesitamos la sesión para manejar mensajes

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo_hab'], $_POST['codigo_cli'])) {

    $codigo_hab = $_POST['codigo_hab'];
    $codigo_cli = $_POST['codigo_cli'];
    // ... otros campos del formulario
    $numero_rese = $_POST['numero_rese'];
    $fecha_inicio_rese = $_POST['fecha_inicio_rese'];
    $fecha_inicio_esta = $_POST['fecha_inicio_esta'];
    $fecha_final_esta = $_POST['fecha_final_esta'];

    try {
        // 1. Verificar la disponibilidad de la habitación ANTES de empezar
        $stmt_check = $pdo->prepare("SELECT hab_disp FROM habitaciones WHERE codigo_hab = ?");
        $stmt_check->execute([$codigo_hab]);
        $habitacion = $stmt_check->fetch();

        if ($habitacion && strtolower($habitacion['hab_disp']) === 'si') {

            // 2. Iniciar una transacción
            $pdo->beginTransaction();

            // 3. Insertar la nueva reserva
            $sql_insert = "INSERT INTO reserva(numero_rese, fecha_inicio_rese, fecha_inicio_esta, fecha_final_esta, codigo_hab, codigo_cli) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->execute([$numero_rese, $fecha_inicio_rese, $fecha_inicio_esta, $fecha_final_esta, $codigo_hab, $codigo_cli]);

            // 4. Actualizar el estado de la habitación a "No"
            $sql_update = "UPDATE habitaciones SET hab_disp = 'No' WHERE codigo_hab = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$codigo_hab]);

            // 5. Confirmar la transacción (guardar todos los cambios)
            $pdo->commit();

            // Redirigir con mensaje de éxito
            header("Location: ../panel-empleado.php?status=reserva_ok");
            exit();
        } else {
            // La habitación no existe o no está disponible
            header("Location: ../panel-empleado.php?status=reserva_error&message=Habitacion no disponible o no existe.");
            exit();
        }
    } catch (PDOException $e) {
        // Si algo falla, revertir todos los cambios
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: ../panel-empleado.php?status=reserva_error&message=" . urlencode($e->getMessage()));
        exit();
    }
}
