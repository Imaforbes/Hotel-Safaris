<?php
require_once 'conexion.php';
$resultados = [];
$codigo_buscado = '';
$titulo = 'Consulta de Reservaciones';

if (isset($_POST['numero_rese']) && !empty($_POST['numero_rese'])) {
    $codigo_buscado = $_POST['numero_rese'];
    $titulo = "Resultados para la Reservación: " . htmlspecialchars($codigo_buscado);
    $sql = "SELECT * FROM reserva WHERE numero_rese = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codigo_buscado]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $titulo = 'Todas las Reservaciones';
    $sql = "SELECT * FROM reserva";
    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Reservaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3><?php echo $titulo; ?></h3>
            </div>
            <div class="card-body">
                <?php if (!empty($resultados)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th># Reserva</th>
                                    <th>Inicio Reserva</th>
                                    <th>Inicio Estancia</th>
                                    <th>Fin Estancia</th>
                                    <th>Cód. Habitación</th>
                                    <th>Cód. Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $fila): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fila['numero_rese']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['fecha_inicio_rese']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['fecha_inicio_esta']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['fecha_final_esta']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['codigo_hab']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['codigo_cli']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">No se encontraron resultados.</div>
                <?php endif; ?>
                <a href="../recepcion.php" class="btn btn-secondary mt-3">Regresar</a>
            </div>
        </div>
    </main>
</body>

</html>