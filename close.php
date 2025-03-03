<?php
session_start();
session_destroy(); // Cierra la sesión completamente
header("Location: login.php"); // Redirige al login
exit;
?>
