<?php
// ================== CÓDIGO GUARDIÁN DE SEGURIDAD ==================
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// =========== OBTENER LA LISTA DE USUARIOS PARA MOSTRARLA ===========
require_once 'conexion.php';
// Omitimos la contraseña por seguridad al consultar
$sql = "SELECT Usuario, Nombre, Apellidos FROM recepcion ORDER BY Nombre";
$stmt = $pdo->query($sql);
$recepcionistas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Hotel Safari's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-shield-lock-fill"></i>
                Hotel "Safari's" - Modo Administrador
            </a>
            <form action="api_hotel/cerrar-sesion.php" method="POST" class="d-flex">
                <button class="btn btn-outline-danger" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-badge"></i> Administradores y Recepcionistas</h4>
                    </div>
                    <div class="card-body">
                        <h5>Usuarios Actuales</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recepcionistas as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['Usuario']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Apellidos']); ?></td>
                                            <td>
                                                <form action="api_hotel/borrar-recepcion.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
                                                    <input type="hidden" name="Usuario" value="<?php echo htmlspecialchars($user['Usuario']); ?>">
                                                    <?php if ($user['Usuario'] !== $_SESSION['usuario']): ?>
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash-fill"></i> Eliminar
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                            (En uso)
                                                        </button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Registrar Nuevo Usuario</h4>
                    </div>
                    <div class="card-body">
                        <form action="api_hotel/insertar-recepcion.php" method="POST">
                            <div class="mb-3">
                                <label for="rec-usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="rec-usuario" name="Usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="rec-pass" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="rec-pass" name="Passwor" required>
                            </div>
                            <div class="mb-3">
                                <label for="rec-nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="rec-nombre" name="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="rec-apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="rec-apellidos" name="Apellidos" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrar Usuario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>