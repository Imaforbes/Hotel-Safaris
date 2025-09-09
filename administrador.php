<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}
require_once 'api_hotel/conexion.php';

// --- LÓGICA PARA ESTADÍSTICAS DEL ADMINISTRADOR ---
// Contar total de empleados
$stmt_empleados = $pdo->query("SELECT COUNT(*) AS total FROM empleados");
$total_empleados = $stmt_empleados->fetch()['total'];

// Contar total de clientes
$stmt_clientes = $pdo->query("SELECT COUNT(*) AS total FROM cliente");
$total_clientes = $stmt_clientes->fetch()['total'];

// Contar habitaciones disponibles
$stmt_hab_disp = $pdo->query("SELECT COUNT(*) AS total FROM habitaciones WHERE hab_disp = 'Si'");
$total_hab_disp = $stmt_hab_disp->fetch()['total'];

// Contar total de reservas
$stmt_reservas = $pdo->query("SELECT COUNT(*) AS total FROM reserva");
$total_reservas = $stmt_reservas->fetch()['total'];
// --- FIN DE LÓGICA PARA ESTADÍSTICAS ---


// Lógica para obtener la lista de empleados para la tabla
$sql = "SELECT Codigo_empl, Usuario, Nombre, Apellidos, Cargo, rol FROM empleados ORDER BY Nombre";
$stmt = $pdo->query($sql);
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <a class="navbar-brand" href="#"><i class="bi bi-shield-lock-fill"></i> Hotel "Safari's" - Modo Administrador</a>
            <form action="api_hotel/cerrar-sesion.php" method="POST" class="d-flex">
                <button class="btn btn-outline-danger" type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <main class="container mt-4">

        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-primary shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_empleados; ?></h3>
                        <p class="card-text">Empleados Registrados</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_clientes; ?></h3>
                        <p class="card-text">Clientes Totales</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-info shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-door-open-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_hab_disp; ?></h3>
                        <p class="card-text">Habitaciones Libres</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-warning shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar2-check-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_reservas; ?></h3>
                        <p class="card-text">Reservas Activas</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="bi bi-person-badge"></i> Lista de Empleados</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleados as $user): ?>
                                        <tr data-row-codigo="<?php echo htmlspecialchars($user['Codigo_empl']); ?>">
                                            <td><?php echo htmlspecialchars($user['Usuario']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Nombre'] . ' ' . $user['Apellidos']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Cargo']); ?></td>
                                            <td><span class="badge bg-<?php echo $user['rol'] === 'admin' ? 'warning' : 'info'; ?>"><?php echo htmlspecialchars($user['rol']); ?></span></td>
                                            <td class="d-flex">
                                                <a href="editar-empleado.php?codigo=<?php echo htmlspecialchars($user['Codigo_empl']); ?>" class="btn btn-warning btn-sm me-2" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                                <?php if ($user['Usuario'] !== $_SESSION['usuario']): ?>
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-codigo="<?php echo htmlspecialchars($user['Codigo_empl']); ?>" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled title="No puedes eliminarte a ti mismo"><i class="bi bi-trash-fill"></i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Registrar Empleado</h4>
                    </div>
                    <div class="card-body">
                        <form action="api_hotel/insertar-empleado.php" method="POST">
                            <div class="mb-2"><label class="form-label">Código Empleado</label><input type="text" class="form-control" name="Codigo_empl" required></div>
                            <div class="mb-2"><label class="form-label">Usuario</label><input type="text" class="form-control" name="Usuario" required></div>
                            <div class="mb-2"><label class="form-label">Contraseña</label><input type="password" class="form-control" name="passwor" required></div>
                            <div class="mb-2"><label class="form-label">Nombre</label><input type="text" class="form-control" name="Nombre" required></div>
                            <div class="mb-2"><label class="form-label">Apellidos</label><input type="text" class="form-control" name="Apellidos" required></div>
                            <div class="mb-2"><label class="form-label">Cargo</label><input type="text" class="form-control" name="Cargo" required></div>
                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select name="rol" class="form-select" required>
                                    <option value="empleado" selected>Empleado</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('click', function(event) {
            const deleteButton = event.target.closest('.delete-btn');
            if (deleteButton) {
                const codigoEmpleado = deleteButton.dataset.codigo;
                if (confirm(`¿Estás seguro de que quieres eliminar al empleado con código ${codigoEmpleado}?`)) {
                    const formData = new FormData();
                    formData.append('Codigo_empl', codigoEmpleado);
                    fetch('api_hotel/borrar-empleado.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                document.querySelector(`tr[data-row-codigo="${codigoEmpleado}"]`)?.remove();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        }).catch(error => console.error('Error:', error));
                }
            }
        });
    </script>
</body>

</html>