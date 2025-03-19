<?php
session_start(); // Iniciar sesión para acceder a los datos del usuario

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_user'])) {
    // Si no está autenticado, redirigir al login
    header('Location: login.php');
    exit;
}

// Obtener el rol del usuario desde la sesión
$role = $_SESSION['role']; // Ejemplo: 'admin', 'user', 'tecnico'

// Conexión a la base de datos
require_once("../conexion.php");

// Consulta para obtener los activos
$sql = "SELECT id_activos, nombre_activos, cantidad_activos, estado_activos, id_empresa, IP, MAC, SN, ubicacion_activos, fecha_ingreso FROM tbl_activos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Activos</title>
    <link rel="stylesheet" href="../assets/CSS/tables.css">
    <style>
        /* Estilos para la sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px; 
            background-color: #2d3748; 
            z-index: 1000;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px); 
            margin-top: 15px;
        }
    </style>
</head>
<body class="bg-[var(--beige)]">
<?php include 'header.php'; ?> 

<!-- Incluir la sidebar correspondiente según el rol del usuario -->
<?php
switch ($role) {
    case 'admin':
        include '../sidebarad.php'; // Sidebar para administradores
        break;
    case 'user':
        include '../sidebarus.php'; // Sidebar para usuarios normales
        break;
    case 'tecnico':
        include '../sidebartec.php'; // Sidebar para técnicos
        break;
    default:
        // Si no hay un rol válido, no incluir ninguna sidebar
        break;
}
?>

<!-- Contenido principal -->
<div class="main-content">
    <div class="flex justify-between items-center mt-4 px-4">
        <p class="text-white text-sm sm:text-lg text-shadow">
            <strong>User:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?> 
            <span id="user-role"><?php echo !empty($role) ? "($role)" : ''; ?></span>
        </p>
        <p id="fechaHora" class="text-white text-sm sm:text-lg text-shadow">
            <strong>Fecha/Hora Ingreso:</strong> Cargando...
        </p>
    </div>

    <main class="container">
        <strong>
            <h1 class="title text-shadow">Inventario de Activos</h1>    
        </strong>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Empresa</th>
                    <th>IP</th>
                    <th>MAC</th>
                    <th>Serie</th>
                    <th>Ubicación</th>
                    <th>Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_activos']; ?></td>
                    <td><?php echo $row['nombre_activos']; ?></td>
                    <td><?php echo $row['cantidad_activos']; ?></td>
                    <td><?php echo $row['estado_activos']; ?></td>
                    <td><?php echo $row['id_empresa']; ?></td>
                    <td><?php echo $row['IP']; ?></td>
                    <td><?php echo $row['MAC']; ?></td>
                    <td><?php echo $row['SN']; ?></td>
                    <td><?php echo $row['ubicacion_activos']; ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                    <td>
                        <a href="../Uses/editaract.php?id_activos=<?php echo $row['id_activos']; ?>">
                            <button class="editBtn">Editar</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="centered-button">
            <a href="../Uses/agregaract.php">
                <button id="addBtn">Agregar Nuevo</button>
            </a>
        </div>
    </main>
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