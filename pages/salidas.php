<?php
require_once("../conexion.php"); // Asegúrate de que este archivo exista y tenga la conexión correcta.

$sql = "SELECT id_salidas, fecha_creacion, items, titulo, Destino, body, id_user FROM tbl_reg_salidas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Salidas</title>
    <link rel="stylesheet" href="../assets/CSS/tables.css"> <!-- Archivo CSS separado -->
</head>
<body class="bg-[var(--beige)]">
<?php include 'header.php'; ?>

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

    <main class="container">
        <strong>
        <h1 class="title text-shadow">Tabla de Salidas</h1>    
        </strong>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Creación</th>
                    <th>Items</th>
                    <th>Titulo</th>
                    <th>Destino</th>
                    <th>Cuerpo</th>
                    <th>Id User</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_salidas']; ?></td>
                    <td><?php echo $row['fecha_creacion']; ?></td>
                    <td><?php echo $row['items']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo $row['Destino']; ?></td>
                    <td><?php echo $row['body']; ?></td>
                    <td><?php echo $row['id_user']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id_salidas']; ?>">
                            <button class="editBtn">Editar</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="centered-button">
            <a href="agregar.php">
                <button id="addBtn">Agregar Nuevo</button>
            </a>
        </div>
    </main>
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