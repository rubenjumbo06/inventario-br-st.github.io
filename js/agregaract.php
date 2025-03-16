<?php
include '../conexion.php';

// Inicializar variables del formulario
$nombre_activos = $cantidad_activos = $estado_activos = $id_empresa = $IP = $MAC = $SN = $ubicacion_activos = "";
$mensaje = "";

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario y sanitizar
    $nombre_activos = htmlspecialchars($_POST['nombre_activos']);
    $cantidad_activos = htmlspecialchars($_POST['cantidad_activos']);
    $estado_activos = htmlspecialchars($_POST['estado_activos']);
    $id_empresa = htmlspecialchars($_POST['id_empresa']);
    $IP = htmlspecialchars($_POST['IP']);
    $MAC = htmlspecialchars($_POST['MAC']);
    $SN = htmlspecialchars($_POST['SN']);
    $ubicacion_activos = htmlspecialchars($_POST['ubicacion_activos']);

    // Validar que los campos no estén vacíos
    if (!empty($nombre_activos) && !empty($cantidad_activos) && !empty($estado_activos) && !empty($id_empresa) && !empty($IP) && !empty($MAC) && !empty($SN) && !empty($ubicacion_activos)) {
        // Nombre fijo de la tabla
        $tabla = "tbl_activos";

        // Preparar la consulta SQL para insertar datos
        $sql = "INSERT INTO $tabla (nombre_activos, cantidad_activos, estado_activos, id_empresa, IP, MAC, SN, ubicacion_activos) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        if ($stmt = $conn->prepare($sql)) {
            // Enlazar los parámetros
            $stmt->bind_param("ssssssss", $nombre_activos, $cantidad_activos, $estado_activos, $id_empresa, $IP, $MAC, $SN, $ubicacion_activos);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $mensaje = "¡Datos guardados correctamente!";
            } else {
                $mensaje = "Error al guardar los datos: " . $stmt->error;
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            $mensaje = "Error al preparar la consulta: " . $conn->error;
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
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
                        Editando tabla: Consumibles
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="mb-10 text-green-500"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="grid grid-cols-2 gap-6 mb-10">
                <!-- Nombre -->
                <div id="input" class="relative">
                    <input type="text" id="nombre_consumibles" name="nombre_consumibles"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Nombre" value="<?php echo $nombre; ?>" required />
                    <label for="nombre"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Nombre
                    </label>
                </div>

                <!-- Cantidad -->
                <div id="input" class="relative">
                    <input type="number" id="cantidad_consumibles" name="cantidad_consumibles"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Cantidad" value="<?php echo $cantidad_consumibles; ?>" required />
                    <label for="cantidad"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Cantidad
                    </label>
                </div>

                <!-- Empresa -->
                <div id="input" class="relative">
                    <select id="floating_outlined"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona una Empresa</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <label
                        for="floating_outlined"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Empresa
                    </label>
                </div>

                <!-- Estado -->
                <div id="input" class="relative">
                    <select id="floating_outlined"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona un Estado</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <label
                        for="floating_outlined"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Estado
                    </label>
                </div>

                <!-- Utilidad -->
                <div id="input" class="relative">
                    <select id="floating_outlined"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona un Utilidad</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <label
                        for="floating_outlined"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Utilidad
                    </label>
                </div>

                <!-- Tecnico -->
                <div id="input" class="relative">
                    <select id="floating_outlined"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona un Tecnico</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <label
                        for="floating_outlined"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Tecnico
                    </label>
                </div>

            </div>

            <div class="sm:flex sm:flex-row-reverse flex gap-4">
                <!-- Botón Guardar -->
                <button type="submit"
                    class="w-fit rounded-lg text-sm px-6 py-3 h-[50px] border border-[var(--verde-oscuro)] bg-[var(--verde-claro)] text-white font-semibold shadow-md hover:bg-green-900 transition-all duration-300">
                    <div class="flex gap-2 items-center">Guardar</div>
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
</body>
</html>