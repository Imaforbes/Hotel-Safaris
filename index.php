<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Hotel Safari's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-page">
    <main class="d-flex align-items-center justify-content-center vh-100">
        <div class="card shadow-lg" style="width: 22rem;">
            <div class="card-header text-center bg-primary text-white">
                <h2 class="mb-0">Hotel "Safari's"</h2>
            </div>
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        Usuario o contraseña incorrectos.
                    </div>
                <?php endif; ?>

                <form action="api_hotel/perfiles.php" method="POST">
                    <div class="mb-3 input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                    </div>

                    <div class="mb-4 input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>