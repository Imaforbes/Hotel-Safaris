<?php
// perfiles.php (VERSIÓN FINAL Y CORREGIDA)
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario'], $_POST['contrasena'])) {

   $usuario_form = $_POST['usuario'];
   $contrasena_form = $_POST['contrasena'];

   // 1. Buscamos al usuario en la tabla UNIFICADA 'empleados'.
   $sql = "SELECT Usuario, passwor, rol FROM empleados WHERE Usuario = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$usuario_form]);
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // 2. Verificamos si el usuario existe y si la contraseña coincide.
   if ($user && password_verify($contrasena_form, $user['passwor'])) {

      // ¡Login exitoso! Guardamos los datos en la sesión.
      $_SESSION['usuario'] = $user['Usuario'];
      $_SESSION['rol'] = $user['rol'];

      // 3. Redirigimos al panel correcto según el rol del usuario.
      if ($user['rol'] === 'admin') {
         header("Location: ../administrador.php");
      } else {
         // Si el rol es 'empleado' (o cualquier otro que no sea admin), va al panel general.
         header("Location: ../panel-empleado.php");
      }
      exit();
   }
}

// 4. Si el login falla por cualquier motivo, redirigimos con error.
header("Location: ../index.php?error=1");
exit();
