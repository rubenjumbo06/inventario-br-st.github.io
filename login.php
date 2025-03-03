<?php
// Incluir archivo de conexión a la base de datos
require_once 'conexion.php';

// Inicializar variables de error y éxito
$error = '';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $error = 'Por favor, completa todos los campos.';
    } else {
        // Consultar la base de datos para verificar el usuario
        $query = "SELECT id, username, password, role FROM tbl_users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtener el usuario
        if ($user = $result->fetch_assoc()) {
            // Verificar la contraseña
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirigir según el rol
                switch ($user['role']) {
                    case 'admin':
                        header('Location: index.php');
                        exit;
                    case 'user':
                        header('Location: indexus.php');
                        exit;
                    case 'tecnico':
                        header('Location: indextec.php');
                        exit;
                    default:
                        $error = 'Rol de usuario desconocido.';
                }
            } else {
                $error = 'Usuario o contraseña incorrectos.';
            }
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }

        // Cerrar la declaración
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Starnet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/CSS/style.css">
</head>
<body class="bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('assets/img/fond.jpg');">
    <div class="max-w-[100%] mx-auto">
        <div class="flex justify-center items-center bg-[#AABF70] p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-10">
            <div class="bg-[#D9D2B0] p-6 sm:p-12 rounded-lg flex flex-col sm:flex-row items-center gap-6 sm:gap-12 w-full">
                
                <!-- Mensajes de error o éxito -->
                <?php if (!empty($error)): ?>
                    <div class="w-full text-center text-red-500 font-semibold">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario -->
                <div class="flex-1 flex flex-col justify-center items-center text-left w-full max-w-[90%] sm:max-w-md mx-auto px-4">
                    <h2 class="mt-2 text-xl sm:text-2xl font-bold tracking-tight text-white text-center">Ingresa a tu cuenta:</h2>
                    <form class="mt-6 sm:mt-10 space-y-4 sm:space-y-6 w-full" action="#" method="POST">
                        <div>
                            <label for="username" class="block text-sm font-medium text-white">Usuario:</label>
                            <input type="text" id="username" name="username" class="w-full px-4 py-2 rounded bg-[#D9D9D9] text-gray-900" required>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-white">Contraseña:</label>
                            <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded bg-[#D9D9D9] text-gray-900" required>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="w-[150px] py-2 mt-4 rounded bg-[#54AB74] text-white font-semibold hover:bg-[#1E412B] transition cursor-pointer">
                                Ingresar
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Línea separadora (solo en pantallas grandes) -->
                <div class="hidden sm:block w-px bg-white h-auto min-h-[300px]"></div>
                
                <!-- Imagen -->
                <img class="hidden sm:block h-auto w-full sm:w-[250px] object-cover rounded-lg" src="assets/img/inv .png" alt="Imagen de Starnet">
            </div>
        </div>
    </div>
</body>
</html>