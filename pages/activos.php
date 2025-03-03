<?php
// Configuración inicial para manejar errores y encabezados
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el parámetro "tabla" de la URL
$tabla = $_GET['tabla'] ?? 'Sin especificar';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Tabla Activos</title>
    <link rel="stylesheet" href="../assets/CSS/tables.css"> <!-- Enlace al archivo CSS externo -->
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="flex">
        <!-- Contenido principal -->
        <main class="flex-1 p-6 sm:p-10">
            <!-- Encabezado -->
            <div class="header-container mb-8">
                <h1 class="text-center text-2xl sm:text-3xl font-bold">
                    Visualización de Tabla Activos
                </h1>
            </div>

            <!-- Tabla de datos -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="ID">1</td>
                            <td data-label="Nombre">Producto A</td>
                            <td data-label="Acciones">
                                <a href="editar.php">
                                    <button class="editBtn">Editar</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="ID">2</td>
                            <td data-label="Nombre">Producto B</td>
                            <td data-label="Acciones">
                                <a href="editar.php">
                                    <button class="editBtn">Editar</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="ID">3</td>
                            <td data-label="Nombre">Producto C</td>
                            <td data-label="Acciones">
                                <a href="editar.php">
                                    <button class="editBtn">Editar</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="ID">4</td>
                            <td data-label="Nombre">Producto D</td>
                            <td data-label="Acciones">
                                <a href="editar.php">
                                    <button class="editBtn">Editar</button>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Botón Agregar Nuevo -->
            <div class="centered-button mt-6">
                <a href="agregar.php">
                    <button id="addBtn">Agregar Nuevo</button>
                </a>
            </div>
        </main>
    </div>
</body>
</html>