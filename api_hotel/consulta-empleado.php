<?php
require_once 'conexion.php';
$resultados = [];
$codigo_buscado = '';
$titulo = 'Consulta de Empleados';

// Omitimos la columna 'passwor' por seguridad
$columnas_seguras = 'Codigo_empl, Usuario, Nombre, Apellidos, Cargo';

if (isset($_POST['Codigo_empl']) && !empty($_POST['Codigo_empl'])) {
  $codigo_buscado = $_POST['Codigo_empl'];
  $titulo = "Resultados para el Empleado: " . htmlspecialchars($codigo_buscado);
  $sql = "SELECT $columnas_seguras FROM empleados WHERE Codigo_empl = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$codigo_buscado]);
  $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  $titulo = 'Todos los Empleados';
  $sql = "SELECT $columnas_seguras FROM empleados";
  $stmt = $pdo->query($sql);
  $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de Empleados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <main class="container mt-4">
    <div class="card shadow">
      <div class="card-header bg-secondary text-white">
        <h3><?php echo $titulo; ?></h3>
      </div>
      <div class="card-body">
        <?php if (!empty($resultados)): ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>Código</th>
                  <th>Usuario</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Cargo</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($resultados as $fila): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($fila['Codigo_empl']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Usuario']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Cargo']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-warning">No se encontraron resultados.</div>
        <?php endif; ?>
        <a href="../administrador.php" class="btn btn-secondary mt-3">Regresar</a>
      </div>
    </div>
  </main>
</body>

</html>