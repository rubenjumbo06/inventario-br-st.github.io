<?php
// Configuración inicial para manejar errores y encabezados
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="../assets/CSS/side.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
<aside class="sidebar">
    <h2>Menú</h2>
    <ul>
        <li><a href="inicio.php">Inicio</a></li>
        <li>
            <button class="menu-button" onclick="toggleSubMenu('listas')">Listas ▾</button>
            <ul id="listas" class="submenu">
                <li><a href="herramientas.php">Herramientas</a></li>
                <li><a href="activos.php">Activos</a></li>
                <li><a href="consumibles.php">Consumibles</a></li>
                <li><a href="empresa.php">Empresa</a></li>
                <li><a href="estados.php">Estados</a></li>
                <li><a href="tecnico.php">Técnico</a></li>
                <li><a href="usuarios.php">Usuarios</a></li>
                <li><a href="utilidad.php">Utilidad</a></li>
                <li><a href="registro_salidas.php">Registro de salidas</a></li>
            </ul>
        </li>
        <!-- Repite para otros menús... -->
    </ul>
</aside>
 <!-- Script para manejar los submenús -->
 <script>
        function toggleSubMenu(submenuId) {
            const submenu = document.getElementById(submenuId);
            if (submenu.classList.contains('active')) {
                submenu.classList.remove('active');
            } else {
                submenu.classList.add('active');
            }
        }
    </script>
</body>
</html>