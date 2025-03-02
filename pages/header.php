<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener datos del usuario y el rol desde la sesión
$usuario = $_SESSION['username'] ?? 'Invitado';
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --celeste: #00797E;
            --verde-oscuro: #0D4B56;
            --verde-claro: #22694c;
            --beige: #D8E6B5;
            --mostaza: yellow;
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        
    </style>
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">
    <!-- Encabezado -->
    <header class="w-full bg-[var(--verde-claro)] text-white p-4 sm:p-6 flex justify-between items-center">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-shadow">
            Inventario <span class="text-[var(--mostaza)]">BARUC - STARNET</span>
        </h2>
        <a href="/logout.php">
            <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition cursor-pointer text-sm sm:text-base">
                Log Out
            </button>
        </a>
    </header>

    <!-- Contenedor Principal -->

        <div class="flex justify-between items-center mt-4 px-4">
            <p class="text-white text-sm sm:text-lg text-shadow">
                <strong>User:</strong> <?php echo htmlspecialchars($usuario); ?> 
                <span id="user-role"><?php echo !empty($role) ? "($role)" : ''; ?></span>
            </p>
            <p id="fechaHora" class="text-white text-sm sm:text-lg text-shadow">
                <strong>Fecha/Hora Ingreso:</strong> Cargando...
            </p>
        </div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function actualizarFechaHora() {
                const ahora = new Date();
                const fechaHoraFormateada = ahora.toLocaleString('es-ES', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
                const fechaHoraElemento = document.getElementById("fechaHora");
                if (fechaHoraElemento) {
                    fechaHoraElemento.textContent = `Fecha/Hora Ingreso: ${fechaHoraFormateada}`;
                }
            }
            actualizarFechaHora();
            setInterval(actualizarFechaHora, 1000);
        });
    </script>
</body>
</html>