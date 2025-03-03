<?php
session_start();
 // Limpia las variables de sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Sesión - Starnet</title>
    <link rel="stylesheet" href="assets/CSS/out.css">
</head>
<body>
<div class="container">
        <div class="form-container">
            <div class="form-inner">
                <!-- Imagen -->
                <img src="assets/img/starnet.png" alt="Imagen de Starnet">
                <!-- Título -->
                <h1>CERRAR SESIÓN</h1>
                <!-- Mensaje -->
                <p>
                    Hola Admin, ¿Estás seguro de cerrar sesión en<br>Inventario BARUC - STARNET?
                </p>
                <!-- Botones -->
                <div class="button-container">
                    <a href="close.php">
                        <button id="yes">Sí</button>
                    </a>
                    <a href="javascript:history.back();">
                        <button id="no">No</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Script para mostrar alerta y cerrar sesión correctamente -->
    <script>
        document.getElementById('yes').addEventListener('click', function () {
            alert("Gracias por su visita. Cerrando sesión...");
            
            window.location.href = "login.php"; // Redirige al login después de cerrar sesión
        });
    </script>
</body>
</html>
