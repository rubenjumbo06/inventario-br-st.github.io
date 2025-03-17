<?php
require_once("../conexion.php");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id_empresa']) && is_numeric($_GET['id_empresa'])) {
    $id_empresa = intval($_GET['id_empresa']);
    $sql = "SELECT * FROM tbl_empresa WHERE id_empresa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_empresa);
    $stmt->execute();
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();

    if (!$empresa) {
        die("Empresa no encontrada.");
    }
} else {
    die("ID inválido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST); // Verificar los datos del formulario

    // Obtener los valores del formulario
    $nombre = $_POST['nombre'] ?? null;
    $ruc = $_POST['ruc'] ?? null;
    $servicio_empresa = $_POST['servicio_empresa'] ?? null;

    // Construir la consulta SQL dinámicamente
    $sql = "UPDATE tbl_empresa SET ";
    $params = [];
    $types = "";

    if (!empty($nombre)) {
        $sql .= "nombre=?, ";
        $params[] = $nombre;
        $types .= "s";
    }
    if (!empty($ruc)) {
        $sql .= "ruc=?, ";
        $params[] = $ruc;
        $types .= "i";
    }
    if (!empty($servicio_empresa)) {
        $sql .= "servicio_empresa=?, ";
        $params[] = $servicio_empresa;
        $types .= "i"; // Cambia a "i" si id_empresa es un entero
    }
    
    // Si no hay campos para actualizar, redirigir sin hacer cambios
    if (empty($params)) {
        echo "<script>alert('No se realizaron cambios'); window.location.href='../pages/empresa.php';</script>";
        exit();
    }

    // Eliminar la última coma y espacio
    $sql = rtrim($sql, ", ");

    // Agregar la condición WHERE
    $sql .= " WHERE id_empresa=?";
    $params[] = $id_empresa;
    $types .= "i";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>window.location.href='../pages/empresa.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la empresa');</script>";
        echo $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Datos</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/CSS/agg.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="p-10 rounded-lg shadow-lg">
        <div class="flex flex-wrap gap-5 items-center w-full max-md:max-w-full mb-10">
            <div class="flex flex-wrap flex-1 shrink gap-5 items-center self-stretch my-auto basis-0 min-w-[240px] max-md:max-w-full">
                <div class="flex flex-col self-stretch my-auto min-w-[240px]">
                    <strong>
                        <div class="text-base text-[var(--verde-oscuro)]">Agregar Datos</div>
                    </strong>
                    <div class="mt-2 text-sm text-[var(--verde-oscuro)]">
                        Editando tabla: Empresa
                    </div>
                </div>
            </div>
        </div>

        <form method="POST">

            <div class="grid grid-cols-2 gap-6 mb-10">
                <!-- Nombre -->
                <div id="input" class="relative">
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($empresa['nombre']) ?>"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Nombre"/>
                    <label for="nombre"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Nombre
                    </label>
                </div>

                <!-- RUC -->
                <div id="input" class="relative">
                    <input type="number" id="ruc" name="ruc" value="<?= htmlspecialchars($empresa['ruc']) ?>"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="RUC"/>
                    <label for="ruc"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        RUC
                    </label>
                </div>
                
                <!-- Empresa -->
                <div id="input" class="relative">
                    <select name="servicio_empresa" id="empresa_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona una Empresa</option>
                    </select>
                    <label
                        for="floating_outlined"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Servicio de Empresa
                    </label>
                </div>
            </div>

            <div class="sm:flex sm:flex-row-reverse flex gap-4">
                <!-- Botón Guardar -->
                <button type="submit"
                    class="w-fit rounded-lg text-sm px-6 py-3 h-[50px] border border-[var(--verde-oscuro)] bg-[var(--verde-claro)] text-white font-semibold shadow-md hover:bg-green-900 transition-all duration-300">
                    <div class="flex gap-2 items-center">Actualizar</div>
                </button>
                <!-- Botón Cancelar -->
                <button type="reset"
                    class="w-fit rounded-lg text-sm px-6 py-3 h-[50px] border border-[var(--verde-oscuro)] text-[var(--verde-oscuro)] font-semibold shadow-md hover:bg-red-500 hover:text-white transition-all duration-300"
                    onclick="window.history.back();">
                    <div class="flex gap-2 items-center">Cancelar</div>
                </button>
            </div>
        </form>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    function cargarDatos(endpoint, selectId) {
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data)) {
                    console.error("Error: Respuesta no válida", data);
                    return;
                }
                let select = document.getElementById(selectId);
                let placeholderText = "";
                switch (selectId) {
                    case "empresa_select":
                        placeholderText = "Selecciona una Empresa";
                        break;
                    case "estado_select":
                        placeholderText = "Selecciona un Estado";
                        break;
                    case "utilidad_select":
                        placeholderText = "Selecciona una Utilidad";
                        break;
                    case "users_select":
                        placeholderText = "Selecciona un Usuario";
                        break;
                    default:
                        placeholderText = "Selecciona una opción";
                }
                // Limpiar y agregar el texto predeterminado
                select.innerHTML = `<option value="" disabled selected>${placeholderText}</option>`;

                data.forEach(item => {
                    let option = document.createElement("option");
                    option.value = item.id_empresa || item.id_estado || item.id_utilidad || item.id_user;
                    option.textContent = item.nombre || item.nombre_estado || item.nombre_utilidad || item.username ;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error("Error cargando los datos:", error));
    }
        cargarDatos("get_empresas.php", "empresa_select");
        cargarDatos("get_estados.php", "estado_select");
        cargarDatos("get_users.php", "users_select");
        cargarDatos("get_utilidades.php", "utilidad_select");
        });
    </script>
</body>
</html>