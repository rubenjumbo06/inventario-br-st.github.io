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
            --mostaza: yellow; /* Cambia este valor al color que desees */
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        .header {
            top: 0;
            left: 250px;
            position: fixed;
            width: calc(100% - 250px); 
            height: 64px;
            background-color: white; 
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1050;
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">
    <!-- Encabezado -->
    <div class="main-content w-full" style="margin-left: 230px;">
        <header class="bg-[var(--verde-claro)] text-white p-4 sm:p-6 flex justify-between items-center fixed top-0 left-[250px] right-0 z-50">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-shadow">
                Inventario <span class="text-[var(--mostaza)]">BARUC - STARNET</span>
            </h2>
            <a href="/Inventario/logout.php">
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition cursor-pointer text-sm sm:text-base">
                    Log Out
                </button>
            </a>
        </header>
    </div>
</body>
</html>