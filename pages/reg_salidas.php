<?php
session_start(); // Iniciar la sesión
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'tecnico') {
    header('Location: ../login.php'); // Ajusta la ruta si es necesario
    exit;
}
$usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario no definido'; // Obtener el nombre
$role = $_SESSION['role']; // Obtener el rol

include '../conexion.php'; // Ajusta la ruta según la ubicación real
$conexion = $conn;

// Consultar herramientas
$sql_h = "SELECT id_herramientas, nombre_herramientas, ubicacion_herramientas FROM tbl_herramientas";
$resultado_h = $conexion->query($sql_h);

// Consultar activos
$sql_act = "SELECT id_activos, nombre_activos, ubicacion_activos FROM tbl_activos";
$resultado_act = $conexion->query($sql_act);

// Consultar consumibles
$sql_con = "SELECT id_consumibles, nombre_consumibles, cantidad_consumibles FROM tbl_consumibles";
$resultado_con = $conexion->query($sql_con);

// Obtener lista de usuarios
$usuarios = $conn->query("SELECT id_user, nombre FROM tbl_users");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $destino = $_POST['destino'];
    $id_user = $_POST['id_user'];
    $selectedItems = json_decode($_POST['body'], true);
    $totalItems = 0;
    $body = "";

    // Procesar herramientas
    if (!empty($selectedItems['herramientas'])) {
        $herramientas = array_map(function ($nombre) {
            return $nombre;
        }, $selectedItems['herramientas']);
        $body .= "Herramientas: (" . implode(", ", $herramientas) . "), ";
        $totalItems += count($selectedItems['herramientas']);
    }

    // Procesar activos
    if (!empty($selectedItems['activos'])) {
        $activos = array_map(function ($nombre) {
            return $nombre;
        }, $selectedItems['activos']);
        $body .= "Activos: (" . implode(", ", $activos) . "), ";
        $totalItems += count($selectedItems['activos']);
    }

    // Procesar consumibles
    if (!empty($selectedItems['consumibles'])) {
        $consumibles = [];
        foreach ($selectedItems['consumibles'] as $id => $data) {
            $consumibles[] = $data['nombre'] . "(" . $data['cantidad'] . ")";
            $totalItems += $data['cantidad']; // Sumar la cantidad de consumibles
        }
        $body .= "Consumibles: [" . implode(", ", $consumibles) . "]";
    }

    // Guardar en tbl_reg_salidas
    $stmt = $conn->prepare("INSERT INTO tbl_reg_salidas (titulo, destino, id_user, body, items) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisi", $titulo, $destino, $id_user, $body, $totalItems);
    $stmt->execute();
    $stmt->close();

    // Procesar herramientas
    if (!empty($selectedItems['herramientas'])) {
        foreach ($selectedItems['herramientas'] as $id => $nombre) {
            $stmt = $conn->prepare("UPDATE tbl_herramientas SET ubicacion_herramientas = 'En campo' WHERE id_herramientas = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Procesar activos
    if (!empty($selectedItems['activos'])) {
        foreach ($selectedItems['activos'] as $id => $nombre) {
            $stmt = $conn->prepare("UPDATE tbl_activos SET ubicacion_activos = 'En instalacion' WHERE id_activos = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Procesar consumibles
    if (!empty($selectedItems['consumibles'])) {
        foreach ($selectedItems['consumibles'] as $id => $data) {
            $cantidadSeleccionada = $data['cantidad'];
            $stmt = $conn->prepare("UPDATE tbl_consumibles SET cantidad_consumibles = cantidad_consumibles - ? WHERE id_consumibles = ?");
            $stmt->bind_param("ii", $cantidadSeleccionada, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    echo "<script>alert('Salida registrada exitosamente'); window.location='reg_salidas.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Salidas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let selectedItems = {
                herramientas: {},
                activos: {},
                consumibles: {}
            };

            window.agregarElemento = function (tipo, id, nombre, cantidad = null) {
                let container = selectedItems[tipo];
                if (cantidad !== null) {
                    if (cantidad > 0) {
                        container[id] = { nombre, cantidad };
                    } else {
                        delete container[id];
                    }
                } else {
                    if (container[id]) {
                        delete container[id]; // Deseleccionar
                    } else {
                        container[id] = nombre; // Seleccionar
                    }
                }
                actualizarResumen();
            };

            window.validarCantidad = function (id) {
                let cantidadElemento = document.getElementById(`cantidad-${id}`);
                let errorElemento = document.getElementById(`error-${id}`);
                
                if (!cantidadElemento || !errorElemento) return; // Validar que los elementos existan
                
                let cantidadDisponible = parseInt(cantidadElemento.max) || 0;
                let cantidadIngresada = parseInt(cantidadElemento.value) || 0;

                if (cantidadIngresada < 0) {
                    cantidadIngresada = 0;
                } else if (cantidadIngresada > cantidadDisponible) {
                    cantidadIngresada = cantidadDisponible;
                }
                cantidadElemento.value = cantidadIngresada;

                if (cantidadIngresada > cantidadDisponible) {
                    errorElemento.textContent = `No puedes seleccionar más de ${cantidadDisponible}`;
                } else if (cantidadIngresada < 0) {
                    errorElemento.textContent = "La cantidad no puede ser negativa";
                } else {
                    errorElemento.textContent = "";
                }

                let nombreElemento = cantidadElemento.closest('li')?.querySelector('span');
                let nombre = nombreElemento ? nombreElemento.textContent.split('(')[0].trim() : 'Desconocido';

                if (cantidadIngresada > 0) {
                    selectedItems.consumibles[id] = { nombre, cantidad: cantidadIngresada };
                } else {
                    delete selectedItems.consumibles[id];
                }
                actualizarResumen();
            };

            function actualizarResumen() {
                let resumen = [];
                let totalItems = 0;

                if (Object.keys(selectedItems.herramientas).length > 0) {
                    let herramientas = Object.values(selectedItems.herramientas);
                    resumen.push("Herramientas: (" + herramientas.join(", ") + ")");
                    totalItems += herramientas.length;
                }

                if (Object.keys(selectedItems.activos).length > 0) {
                    let activos = Object.values(selectedItems.activos);
                    resumen.push("Activos: (" + activos.join(", ") + ")");
                    totalItems += activos.length;
                }

                if (Object.keys(selectedItems.consumibles).length > 0) {
                    let consumibles = Object.values(selectedItems.consumibles).map(item => `${item.nombre}(${item.cantidad})`);
                    resumen.push("Consumibles: [" + consumibles.join(", ") + "]");
                    totalItems += Object.values(selectedItems.consumibles).reduce((sum, item) => sum + item.cantidad, 0);
                }

                document.getElementById('selectedList').innerHTML = resumen.map(item => `<li class="bg-gray-100 p-2 rounded-md mb-2">${item}</li>`).join('');
                document.getElementById('bodyField').value = JSON.stringify(selectedItems);
                document.getElementById('totalItems').textContent = totalItems;
            }

            function buscarHerramientas() {
                let input = document.getElementById('searchHerramientas').value.toLowerCase();
                document.querySelectorAll('.herramienta').forEach(herramienta => {
                    let texto = herramienta.textContent.toLowerCase();
                    herramienta.style.display = texto.includes(input) ? 'block' : 'none';
                });
            }

            function buscarActivos() {
                let input = document.getElementById('searchActivos').value.toLowerCase();
                document.querySelectorAll('.activo').forEach(activo => {
                    let texto = activo.textContent.toLowerCase();
                    activo.style.display = texto.includes(input) ? 'block' : 'none';
                });
            }

            document.getElementById("searchHerramientas").addEventListener("input", buscarHerramientas);
            document.getElementById("searchActivos").addEventListener("input", buscarActivos);

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
</head>
<body class="bg-[var(--beige)] p-4">
    <?php include 'header.php'; ?>
    <div class="flex justify-between items-center mt-4 px-4">
        <p class="text-white text-sm sm:text-lg text-shadow">
            <strong>User:</strong> <?php echo htmlspecialchars($usuario); ?> 
            <span id="user-role"><?php echo !empty($role) ? "($role)" : ''; ?></span>
        </p>
        <p id="fechaHora" class="text-white text-sm sm:text-lg text-shadow">
            <strong>Fecha/Hora Ingreso:</strong> Cargando...
        </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4">
        <!-- Herramientas -->
        <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 text-shadow">Herramientas</h3>
            <input type="text" id="searchHerramientas" placeholder="Buscar herramienta..." class="w-full p-2 border rounded mb-4">
            <ul id="listaHerramientas">
                <?php while ($fila = $resultado_h->fetch_assoc()): ?>
                    <?php if ($fila['ubicacion_herramientas'] == 'En almacen'): ?>
                        <li class="herramienta mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" onchange="agregarElemento('herramientas', <?php echo $fila['id_herramientas']; ?>, '<?php echo addslashes($fila['nombre_herramientas']); ?>')" class="mr-2">
                                <span><?php echo htmlspecialchars($fila['nombre_herramientas']); ?></span>
                            </label>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Activos -->
        <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Activos</h3>
            <input type="text" id="searchActivos" placeholder="Buscar activo..." class="w-full p-2 border rounded mb-4">
            <ul id="listaActivos">
                <?php while ($fila = $resultado_act->fetch_assoc()): ?>
                    <?php if ($fila['ubicacion_activos'] == 'En almacen'): ?>
                        <li class="activo mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" onchange="agregarElemento('activos', <?php echo $fila['id_activos']; ?>, '<?php echo addslashes($fila['nombre_activos']); ?>')" class="mr-2">
                                <span><?php echo htmlspecialchars($fila['nombre_activos']); ?></span>
                            </label>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Consumibles -->
        <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Consumibles</h3>
            <ul id="listaConsumibles">
                <?php while ($fila = $resultado_con->fetch_assoc()): ?>
                    <li data-id="<?php echo $fila['id_consumibles']; ?>" data-cantidad="<?php echo $fila['cantidad_consumibles']; ?>" class="flex items-center justify-between p-2 border-b mb-4">
                        <span>
                            <?php echo htmlspecialchars($fila['nombre_consumibles']); ?> 
                            <strong>(Disponibles: <?php echo $fila['cantidad_consumibles']; ?>)</strong>
                        </span>
                        <div class="flex items-center">
                            <input type="number" id="cantidad-<?php echo $fila['id_consumibles']; ?>" 
                                   class="w-20 px-2 py-1 border rounded mr-2" 
                                   min="0" max="<?php echo $fila['cantidad_consumibles']; ?>" 
                                   value="0" 
                                   oninput="validarCantidad(<?php echo $fila['id_consumibles']; ?>)">
                        </div>
                        <span id="error-<?php echo $fila['id_consumibles']; ?>" class="text-red-500 text-sm"></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Resumen de selección -->
        <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Resumen de Selección</h3>
            <ul id="selectedList" class="mb-4"></ul>
            <p><strong>Total de Items:</strong> <span id="totalItems">0</span></p>
            <form method="POST" class="space-y-4">
                <input type="hidden" id="bodyField" name="body">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título:</label>
                    <input type="text" id="titulo" name="titulo" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="destino" class="block text-sm font-medium text-gray-700">Destino:</label>
                    <input type="text" id="destino" name="destino" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="id_user" class="block text-sm font-medium text-gray-700">Usuario:</label>
                    <select id="id_user" name="id_user" required class="w-full p-2 border rounded">
                        <option value="">Seleccione un usuario</option>
                        <?php while ($row = $usuarios->fetch_assoc()): ?>
                            <option value="<?php echo $row['id_user']; ?>"><?php echo $row['nombre']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Registrar Salida</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php $conexion->close(); ?>