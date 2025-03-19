<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Estilos personalizados para la sidebar */
        .sidebar {
            position: fixed; /* Fija la sidebar en la pantalla */
            top: 0;
            left: 0;
            height: 100vh; /* Altura completa de la pantalla */
            width: 250px; /* Ancho de la sidebar */
            background-color: #2d3748; /* Color de fondo de la sidebar */
            overflow-y: auto; /* Permite el desplazamiento vertical si es necesario */
            z-index: 1000;
        }
        :root {
            --celeste: rgb(14, 57, 60);
            --verde-oscuro: #0D4B56;
            --verde-claro: #22694c;
            --mostaza: yellow;
            --verde: rgb(122, 149, 54);
        }
        /* Estilos para el botón de alternar en móviles */
        .menu-toggle-button {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1200; /* Asegura que el botón esté por encima de la sidebar y el header */
        }
        .main-content {

            padding: 20px; /* Espaciado interno */
            width: calc(100% - 250px); /* Calcula el ancho restante */
            box-sizing: border-box; /* Incluye padding en el cálculo del ancho */
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Botón de alternar menú en móviles -->
    <input type="checkbox" id="menu-toggle" class="hidden peer">
    <div class="menu-toggle-button md:hidden">
        <label for="menu-toggle" class="cursor-pointer p-2 bg-[var(--celeste)] rounded-lg shadow-lg flex items-center justify-center w-12 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>
    </div>

    <!-- Sidebar -->
    <div class="sidebar hidden peer-checked:flex md:flex flex-col">
        <div class="flex items-center justify-between h-16 bg-[var(--celeste)] px-4">
            <span class="text-white font-bold uppercase">Menú</span>
            <label for="menu-toggle" class="md:hidden cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </label>
        </div>
        <div class="flex flex-col flex-1 overflow-y-auto">
            <nav class="flex-1 px-2 py-4 bg-[var(--verde)]">
                <!-- Enlaces de la sidebar -->
                <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Inicio
                </a>
                <!-- Repite los demás enlaces de la sidebar aquí -->
            </nav>
        </div>
    </div>

</body>
</html>