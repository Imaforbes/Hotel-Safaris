<?php
require_once 'conexion.php';
$resultados = [];
$codigo_buscado = '';
$titulo = 'Consulta de Actividades por Cliente';

// Esta consulta siempre requiere un código de cliente.
if (isset($_POST['codigo_cli']) && !empty($_POST['codigo_cli'])) {
    $codigo_buscado = $_POST['codigo_cli'];
    $titulo = "Actividades para el Cliente: " . htmlspecialchars($codigo_buscado);
    $sql = "SELECT * FROM cliente_actividad WHERE codigo_cli = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codigo_buscado]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Actividades por Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h3><?php echo $titulo; ?></h3>
            </div>
            <div class="card-body">
                <?php if (empty($codigo_buscado)): ?>
                    <div class="alert alert-info">Por favor, regresa y proporciona un código de cliente para consultar.</div>
                <?php elseif (!empty($resultados)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Registro</th>
                                    <th>Cód. Cliente</th>
                                    <th>Cód. Actividad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $fila): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fila['Id']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['codigo_cli']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['codigo_act']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">El cliente "<?php echo htmlspecialchars($codigo_buscado); ?>" no tiene actividades registradas.</div>
                <?php endif; ?>
                <a href="../empleados.php" class="btn btn-secondary mt-3">Regresar</a>
            </div>
        </div>
    </main>
</body>

</html>