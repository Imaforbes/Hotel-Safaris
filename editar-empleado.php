<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}
require_once 'api_hotel/conexion.php';

// Verificar que se recibió un código de empleado
if (!isset($_GET['codigo'])) {
    header('Location: administrador.php');
    exit();
}

$codigo_empl = $_GET['codigo'];

// Obtener los datos del empleado de la base de datos
$sql = "SELECT * FROM empleados WHERE Codigo_empl = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$codigo_empl]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el empleado, redirigir
if (!$empleado) {
    header('Location: administrador.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado | Hotel Safari's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">Editando a <?php echo htmlspecialchars($empleado['Nombre']); ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="api_hotel/actualizar-empleado.php" method="POST">
                            <input type="hidden" name="Codigo_empl" value="<?php echo htmlspecialchars($empleado['Codigo_empl']); ?>">

                            <div class="mb-3"><label class="form-label">Usuario</label><input type="text" class="form-control" name="Usuario" value="<?php echo htmlspecialchars($empleado['Usuario']); ?>" required></div>
                            <div class="mb-3"><label class="form-label">Nombre</label><input type="text" class="form-control" name="Nombre" value="<?php echo htmlspecialchars($empleado['Nombre']); ?>" required></div>
                            <div class="mb-3"><label class="form-label">Apellidos</label><input type="text" class="form-control" name="Apellidos" value="<?php echo htmlspecialchars($empleado['Apellidos']); ?>" required></div>
                            <div class="mb-3"><label class="form-label">Cargo</label><input type="text" class="form-control" name="Cargo" value="<?php echo htmlspecialchars($empleado['Cargo']); ?>" required></div>
                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select name="rol" class="form-select" required>
                                    <option value="empleado" <?php if ($empleado['rol'] === 'empleado') echo 'selected'; ?>>Empleado</option>
                                    <option value="admin" <?php if ($empleado['rol'] === 'admin') echo 'selected'; ?>>Administrador</option>
                                </select>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="passwor" placeholder="Dejar en blanco para no cambiar">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                <a href="administrador.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>