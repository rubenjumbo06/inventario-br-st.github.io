<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>TailwindCSS | Dashboard</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="">
<style>
</style>

<script src="https://cdn.tailwindcss.com"></script>

<body>
	<div class="flex h-screen bg-gray-100">
		<!-- Mobile menu toggle button -->
		<input type="checkbox" id="menu-toggle" class="hidden peer">

		<!-- Sidebar -->
		<div class="hidden peer-checked:flex md:flex flex-col w-64 bg-gray-800 transition-all duration-300 ease-in-out">
			<div class="flex items-center justify-between h-16 bg-gray-900 px-4">
				<span class="text-white font-bold uppercase">Sidebar</span>
				<label for="menu-toggle" class="text-white cursor-pointer">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 lg:hidden" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M6 18L18 6M6 6l12 12" />
					</svg>
				</label>
				<!-- <span class="text-white font-bold uppercase">Sidebar</span> -->
			</div>
			<div class="flex flex-col flex-1 overflow-y-auto">
				<nav class="flex-1 px-2 py-4 bg-gray-800">
					<!-- Login -->
					<a href="#" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 group">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
							stroke="currentColor" class="group-hover:hidden h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
						</svg>
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden group-hover:block h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
						  </svg>						  
						Login
					</a>

					<!-- Messages with subitems -->
					<div class="mb-2 relative group">
						<input type="checkbox" id="messages-toggle" class="hidden peer">
					
						<label for="messages-toggle"
							class="flex items-center px-12 py-2 mt-2 text-gray-100 hover:bg-gray-700 cursor-pointer w-full">
							Messages
						</label>
					
						<!-- SVG Icons op hetzelfde niveau als input -->
						<!-- <div class="absolute left-4 top-2 transform #dis-translate-y-1/2 flex items-center text-white"> -->
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
							class="absolute top-2 left-4 text-white group-hover:hidden h-6 w-6 mr-2 peer-checked:hidden">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
						</svg>
				
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
							class="absolute top-2 left-4 text-white hidden group-hover:block peer-checked:block h-6 w-6 mr-2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
						</svg>
						<!-- </div> -->
					
						<!-- Arrow Icon -->
						<svg xmlns="http://www.w3.org/2000/svg"
							class="h-4 w-4 ml-auto transition-transform transform peer-checked:rotate-180 absolute right-4 top-3 transform #dis--translate-y-1/2 text-white"
							fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
						</svg>
					
						<div class="hidden peer-checked:flex flex-col bg-white text-gray-800 mt-1 transition-all duration-300">
							<a href="#" class="block px-4 py-2 hover:bg-gray-200">Subitem 1</a>
							<a href="#" class="block px-4 py-2 hover:bg-gray-200">Subitem 2</a>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
</body>
</html>