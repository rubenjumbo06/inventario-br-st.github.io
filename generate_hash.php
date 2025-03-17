<?php
// Contraseña original
$password = '123456';

// Generar el hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Mostrar el hash
echo "Hash generado: " . $hash;
?>