<?php
// generador_hash.php
$password_para_admin = 'admin123';
$nuevo_hash = password_hash($password_para_admin, PASSWORD_DEFAULT);

echo "<h1>Usa este código SQL para arreglar tu admin</h1>";
echo "<p>Copia y pega todo el contenido del siguiente recuadro en la pestaña SQL de tu base de datos:</p>";
echo "<hr>";
echo "<pre style='background-color:#f0f0f0; padding:15px; border:1px solid #ccc; font-family: monospace;'>";
echo "-- 1. Borra el usuario admin antiguo por si acaso.<br>";
echo "DELETE FROM recepcion WHERE Usuario = 'admin';<br><br>";
echo "-- 2. Inserta el nuevo usuario admin con un hash 100% compatible.<br>";
echo "INSERT INTO `recepcion` (`Usuario`, `Passwor`, `Nombre`, `Apellidos`) VALUES<br>";
echo "('admin', '" . htmlspecialchars($nuevo_hash) . "', 'Administrador', 'Principal');";
echo "</pre>";
