<?php
session_start();
// Guardián de seguridad: solo permite el acceso a administradores y empleados.
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['admin', 'empleado'])) {
    header('Location: index.php');
    exit();
}
require_once 'api_hotel/conexion.php';

// --- LÓGICA PARA ESTADÍSTICAS DEL EMPLEADO ---
// Contar total de clientes
$stmt_clientes = $pdo->query("SELECT COUNT(*) AS total FROM cliente");
$total_clientes = $stmt_clientes->fetch()['total'];

// Contar habitaciones disponibles
$stmt_hab_disp = $pdo->query("SELECT COUNT(*) AS total FROM habitaciones WHERE hab_disp = 'Si'");
$total_hab_disp = $stmt_hab_disp->fetch()['total'];

// Contar habitaciones ocupadas
$stmt_hab_ocup = $pdo->query("SELECT COUNT(*) AS total FROM habitaciones WHERE hab_disp = 'No'");
$total_hab_ocup = $stmt_hab_ocup->fetch()['total'];

// Contar total de actividades
$stmt_actividades = $pdo->query("SELECT COUNT(*) AS total FROM actividades");
$total_actividades = $stmt_actividades->fetch()['total'];
// --- FIN DE LÓGICA PARA ESTADÍSTICAS ---
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado | Hotel Safari's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-person-workspace"></i> Hotel "Safari's" - Panel de Empleado</a>
            <form action="api_hotel/cerrar-sesion.php" method="POST" class="d-flex">
                <button class="btn btn-outline-danger" type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <main class="container mt-4">

        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_clientes; ?></h3>
                        <p class="card-text">Clientes Registrados</p>
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
                <div class="card text-white bg-danger shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-door-closed-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_hab_ocup; ?></h3>
                        <p class="card-text">Habitaciones Ocupadas</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-secondary shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-dice-5-fill fs-1"></i>
                        <h3 class="card-title"><?php echo $total_actividades; ?></h3>
                        <p class="card-text">Actividades Ofrecidas</p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'reserva_ok'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> La reserva se ha creado y la habitación ha sido marcada como no disponible.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['status'] === 'borrado_ok'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> La reserva se ha eliminado y la habitación vuelve a estar disponible.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (in_array($_GET['status'], ['reserva_error', 'borrado_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> No se pudo completar la operación.
                    <?php if (isset($_GET['message'])): ?>
                        <small>Detalle: <?php echo htmlspecialchars($_GET['message']); ?></small>
                    <?php endif; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <ul class="nav nav-tabs nav-fill" id="mainTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#clientes-tab-pane" type="button" role="tab" aria-controls="clientes-tab-pane" aria-selected="true"><i class="bi bi-people-fill"></i> Clientes</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#habitaciones-tab-pane" type="button" role="tab" aria-controls="habitaciones-tab-pane" aria-selected="false"><i class="bi bi-door-closed-fill"></i> Habitaciones</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reservacion-tab-pane" type="button" role="tab" aria-controls="reservacion-tab-pane" aria-selected="false"><i class="bi bi-calendar-check-fill"></i> Reservación</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#actividades-tab-pane" type="button" role="tab" aria-controls="actividades-tab-pane" aria-selected="false"><i class="bi bi-dice-5-fill"></i> Actividades</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#registro-tab-pane" type="button" role="tab" aria-controls="registro-tab-pane" aria-selected="false"><i class="bi bi-person-check-fill"></i> Inscribir Cliente</button></li>
        </ul>

        <div class="tab-content" id="mainTabContent">

            <div class="tab-pane fade show active" id="clientes-tab-pane" role="tabpanel" aria-labelledby="clientes-tab-pane-tab">
                <div class="card shadow-sm border-top-0 rounded-0">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#cli-insertar"><i class="bi bi-person-plus-fill"></i> Insertar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#cli-consultar"><i class="bi bi-search"></i> Consultar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#cli-eliminar"><i class="bi bi-trash-fill"></i> Eliminar</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="cli-insertar">
                                <form action="api_hotel/inserta-cliente.php" method="POST"><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Código de cliente" required><input type="text" class="form-control mb-2" name="nombre" placeholder="Nombre de cliente" required><input type="text" class="form-control mb-2" name="direccion" placeholder="Dirección" required><input type="text" class="form-control mb-2" name="telefono" placeholder="Teléfono" required><input type="text" class="form-control mb-2" name="dni_cli" placeholder="DNI" required><button type="submit" class="btn btn-success w-100">Insertar Cliente</button></form>
                            </div>
                            <div class="tab-pane fade" id="cli-consultar">
                                <form action="api_hotel/consulta-cliente.php" method="post" target="_blank"><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Código de cliente (dejar vacío para ver todos)"><button type="submit" class="btn btn-info w-100">Consultar</button></form>
                            </div>
                            <div class="tab-pane fade" id="cli-eliminar">
                                <form action="api_hotel/borra-clientes.php" method="POST"><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Código de cliente a eliminar" required><button type="submit" class="btn btn-danger w-100">Borrar</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="habitaciones-tab-pane" role="tabpanel" aria-labelledby="habitaciones-tab-pane-tab">
                <div class="card shadow-sm border-top-0 rounded-0">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#hab-insertar"><i class="bi bi-plus-square-fill"></i> Insertar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#hab-consultar"><i class="bi bi-search"></i> Consultar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#hab-eliminar"><i class="bi bi-trash-fill"></i> Eliminar</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="hab-insertar">
                                <form action="api_hotel/inserta-habitaciones.php" method="POST"><input type="text" class="form-control mb-2" name="codigo_hab" placeholder="Código de habitación" required><input type="text" class="form-control mb-2" name="tipo_hab" placeholder="Tipo (Ej: Simple, Doble)" required><input type="text" class="form-control mb-2" name="hab_disp" placeholder="Disponibilidad (Ej: Si)" required><button class="btn btn-success w-100" type="submit">Insertar Habitación</button></form>
                            </div>
                            <div class="tab-pane fade" id="hab-consultar">
                                <form action="api_hotel/consulta-habitaciones.php" method="post" target="_blank"><input type="text" class="form-control mb-2" name="codigo_hab" placeholder="Código (dejar vacío para ver todas)"><button class="btn btn-info w-100" type="submit">Consultar</button></form>
                            </div>
                            <div class="tab-pane fade" id="hab-eliminar">
                                <form action="api_hotel/borrar-habitaciones.php" method="POST"><input type="text" class="form-control mb-2" name="codigo_hab" placeholder="Código de habitación a eliminar" required><button class="btn btn-danger w-100" type="submit">Borrar</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="reservacion-tab-pane" role="tabpanel" aria-labelledby="reservacion-tab-pane-tab">
                <div class="card shadow-sm border-top-0 rounded-0">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#res-insertar"><i class="bi bi-calendar-plus-fill"></i> Insertar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#res-consultar"><i class="bi bi-search"></i> Consultar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#res-eliminar"><i class="bi bi-trash-fill"></i> Eliminar</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="res-insertar">
                                <form action="api_hotel/inserta-reserva.php" method="post"><input type="text" class="form-control mb-2" name="numero_rese" placeholder="Número de reservación (único)" required><input type="text" class="form-control mb-2" name="fecha_inicio_rese" placeholder="Fecha reserva (YYYY-MM-DD)" required><input type="text" class="form-control mb-2" name="fecha_inicio_esta" placeholder="Inicio estancia (YYYY-MM-DD)" required><input type="text" class="form-control mb-2" name="fecha_final_esta" placeholder="Final estancia (YYYY-MM-DD)" required><input type="text" class="form-control mb-2" name="codigo_hab" placeholder="Código de habitación" required><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Código de cliente" required><button class="btn btn-success w-100" type="submit">Insertar Reservación</button></form>
                            </div>
                            <div class="tab-pane fade" id="res-consultar">
                                <form action="api_hotel/consulta-reservacion.php" method="post" target="_blank"><input type="text" class="form-control mb-2" name="numero_rese" placeholder="# Reserva (dejar vacío para ver todas)"><button class="btn btn-info w-100" type="submit">Consultar</button></form>
                            </div>
                            <div class="tab-pane fade" id="res-eliminar">
                                <form action="api_hotel/borra-reserva.php" method="POST"><input type="text" class="form-control mb-2" name="numero_rese" placeholder="Número de reservación a eliminar" required><button class="btn btn-danger w-100" type="submit">Borrar</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="actividades-tab-pane" role="tabpanel" aria-labelledby="actividades-tab-pane-tab">
                <div class="card shadow-sm border-top-0 rounded-0">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#act-insertar"><i class="bi bi-plus-square-fill"></i> Insertar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#act-consultar"><i class="bi bi-search"></i> Consultar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#act-eliminar"><i class="bi bi-trash-fill"></i> Eliminar</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="act-insertar">
                                <form action="api_hotel/inserta-actividades.php" method="POST">
                                    <div class="row g-2">
                                        <div class="col-md-6"><input type="text" class="form-control" name="codigo_act" placeholder="Código de actividad" required></div>
                                        <div class="col-md-6"><input type="text" class="form-control" name="nombre_act" placeholder="Nombre de actividad" required></div>
                                        <div class="col-md-6"><input type="text" class="form-control" name="duracion_act" placeholder="Duración (Ej: 2 horas)" required></div>
                                        <div class="col-md-6"><input type="text" class="form-control" name="horario" placeholder="Horario (Ej: 10:00 AM)" required></div>
                                        <div class="col-12"><textarea class="form-control" name="descripcion" placeholder="Descripción de actividad" required></textarea></div>
                                        <div class="col-md-4"><input type="number" step="0.01" class="form-control" name="precio_act" placeholder="Precio" required></div>
                                        <div class="col-md-4"><input type="number" class="form-control" name="huespedes_regis" placeholder="Huéspedes registrados" required></div>
                                        <div class="col-md-4"><input type="text" class="form-control" name="empl_Codigo" placeholder="Cód. empleado a cargo" required></div>
                                    </div><button type="submit" class="btn btn-success w-100 mt-3">Insertar Actividad</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="act-consultar">
                                <form action="api_hotel/consulta-actividades.php" method="post" target="_blank"><input type="text" class="form-control mb-2" name="codigo_act" placeholder="Código (dejar vacío para ver todas)"><button type="submit" class="btn btn-info w-100">Consultar</button></form>
                            </div>
                            <div class="tab-pane fade" id="act-eliminar">
                                <form action="api_hotel/borrar-actividad.php" method="POST"><input type="text" class="form-control mb-2" name="codigo_act" placeholder="Código de actividad a eliminar" required><button type="submit" class="btn btn-danger w-100">Borrar</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="registro-tab-pane" role="tabpanel" aria-labelledby="registro-tab-pane-tab">
                <div class="card shadow-sm border-top-0 rounded-0">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#reg-insertar"><i class="bi bi-person-plus-fill"></i> Inscribir</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#reg-consultar"><i class="bi bi-search"></i> Consultar</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#reg-eliminar"><i class="bi bi-person-dash-fill"></i> Eliminar Inscripción</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="reg-insertar">
                                <form action="api_hotel/inserta-cliente-actividad.php" method="POST"><input type="text" class="form-control mb-2" name="Id" placeholder="ID de registro (ej: 1, 2, 3...)" required><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Código del cliente" required><input type="text" class="form-control mb-2" name="codigo_act" placeholder="Código de la actividad" required><button type="submit" class="btn btn-success w-100">Inscribir Cliente a Actividad</button></form>
                            </div>
                            <div class="tab-pane fade" id="reg-consultar">
                                <form action="api_hotel/consulta-cliente-actividad.php" method="post" target="_blank"><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Cód. cliente para ver sus actividades" required><button type="submit" class="btn btn-info w-100">Consultar</button></form>
                            </div>
                            <div class="tab-pane fade" id="reg-eliminar">
                                <form action="api_hotel/borrar-cliente-actividad.php" method="post"><input type="text" class="form-control mb-2" name="codigo_cli" placeholder="Cód. cliente para borrar de actividad" required><button type="submit" class="btn btn-danger w-100">Eliminar Inscripción</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>