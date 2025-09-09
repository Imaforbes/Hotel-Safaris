<?php
require_once 'conexion.php';
$resultados = [];
$codigo_buscado = '';
$titulo = 'Consulta de Clientes';

// Lógica para obtener los datos
if (isset($_POST['codigo_cli']) && !empty($_POST['codigo_cli'])) {
    $codigo_buscado = $_POST['codigo_cli'];
    $titulo = "Resultados para el Cliente: " . htmlspecialchars($codigo_buscado);
    $sql = "SELECT * FROM cliente WHERE codigo_cli = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codigo_buscado]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no se busca un código específico, muestra todos los clientes.
    $titulo = 'Todos los Clientes';
    $sql = "SELECT * FROM cliente";
    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Comienza la presentación HTML
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Clientes</title>
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
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>DNI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $fila): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fila['codigo_cli']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['direccion']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['dni_cli']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">No se encontraron resultados para la búsqueda.</div>
                <?php endif; ?>
                <a href="../recepcion.php" class="btn btn-secondary mt-3">Regresar</a>
            </div>
        </div>
    </main>
</body>

</html>