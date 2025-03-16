<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TailwindCSS | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --celeste: rgb(14, 57, 60);
            --verde-oscuro: #0D4B56;
            --verde-claro: #22694c;
            --mostaza: rgb(131, 157, 57);
            --verde: rgb(122, 149, 54);
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body>
    <div class="flex h-screen bg-gray-100">


		<!-- Menu Toggle Input -->
		<input type="checkbox" id="menu-toggle" class="hidden peer">

		<!-- Mobile Menu Toggle Button -->
		<div class="md:hidden fixed top-4 left-4 z-50 peer-checked:hidden">
			<label for="menu-toggle" class="cursor-pointer p-2 bg-[var(--celeste)] rounded-lg shadow-lg flex items-center justify-center w-12 h-12">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16" />
				</svg>
			</label>
		</div>

        <!-- Sidebar -->
        <input type="checkbox" id="menu-toggle" class="hidden peer">
        <div class="hidden peer-checked:flex md:flex flex-col w-64 bg-gray-800 transition-all duration-300 ease-in-out">
            <div class="flex items-center justify-between h-16 bg-[var(--celeste)] px-4">
                <span class="text-white font-bold uppercase">Menú</span>
                <!-- Close Button for Mobile -->
                <label for="menu-toggle" class="md:hidden cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </label>
            </div>
            <div class="flex flex-col flex-1 overflow-y-auto">
                <nav class="flex-1 px-2 py-4 bg-[var(--verde)]">
                    <!-- Inicio -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Inicio
                    </a>

                    <!-- Herramientas -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m6.364-1.364-1.414 1.414M21 12h-2m1.364 6.364-1.414-1.414M12 21v-2m-6.364 1.364 1.414-1.414M3 12h2m1.364-6.364 1.414 1.414M16.95 7.05a7 7 0 1 1-9.9 9.9"/>
						</svg>
						Herramientas
					</a>


					<!-- Activos -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21V10m4 11V10m4-4H7m10 0h4m-6 0v4H9V6m4 0V2"/>
						</svg>
						Activos
					</a>


					<!-- Consumibles -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 9V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3m-16 0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9m-16 0h16"/>
						</svg>
						Consumibles
					</a>



					<!-- Utilidad -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-9H4m8 0h8"/>
						</svg>
						Utilidad
					</a>


					<!-- Usuarios -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-4-4h-2m-5 6H2v-2a4 4 0 0 1 4-4h2m0-6a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm10 0a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
						</svg>
						Usuarios
					</a>


					<!-- Empresa -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9 21V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v12m-4-8h4m-6 4h6M4 10h16m-2 10H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/>
						</svg>
						Empresa
					</a>


					<!-- Estados -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
						</svg>
						Estado
					</a>


					<!-- Técnico -->
					<a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75 9 3m-4.5 3.75 3.5 4m-3.5-4a1.5 1.5 0 1 0-2 2l3.5 4m4 0 4.5-3.75M9 13.75l-4 3.5m4-3.5 4.5 5m-4.5-5v-6m4.5 11L19.5 21m-4.5-5 5-4m-5 4 3.5 4m1.5-8a1.5 1.5 0 1 1 2-2"/>
						</svg>
						Técnico
					</a>


					<!-- Perfil de Usuario -->
                    <a href="#" class="flex items-center px-6 py-4 text-gray-100 hover:bg-[var(--mostaza)] group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 0 0-7 7m7-7a7 7 0 0 1 7 7m-7-7a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z"/>
						</svg>
						Perfil de Usuario
					</a>

                    
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-4">
        </main>
    </div>
</body>
</html>