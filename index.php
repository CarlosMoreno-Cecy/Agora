<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: Templates/login.php');
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

define('BASE_URL', '/Agora/Modules/Config_User/');

$conn = new mysqli("localhost", "root", "", "Agora");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario_id = $_SESSION['id_usuario'];

$sql = "SELECT ruta FROM imagenes WHERE usuario_id = $usuario_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = BASE_URL . $row['ruta'];
} else {
    $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/style.css">
</head>

<body>

    <!-- Menú lateral -->
    <div id="sidebar" class="collapsed">
        <button id="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/home.php'">
            <i class="fas fa-home"></i><span>Inicio</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/contactos.php'">
            <i class="fas fa-user"></i><span>Contactos</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/Gestion_usuarios.html'">
            <i class="fas fa-chart-line"></i><span>Gestión de usuarios</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Modules/Inscribir/inscribir.php'">
            <i class="fa-solid fa-file"></i><span>Inscribir</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/alumnos.php'">
        <i class="fa-solid fa-person"></i><span>Alumnos</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Modules/Config_User/config.php'">
            <i class="fas fa-cog"></i><span>Configuraciones</span>
        </div>
    </div>

    <!-- Contenido principal con barra superior e iframe -->
    <div id="main-container">
        <!-- Barra superior -->
        <div id="topbar">
            <div class="user-icon-container">
                <label for="btn-user"><img src="<?php echo $imagePath; ?>" alt="" class="rounded-circle border mt-3 user-icon"></label>
                <input type="checkbox" id="btn-user" style="display: none;">
                <div class="container config" id="user-config">
                    <div class="text-center">
                        <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
                        <p><?php echo $_SESSION['email']; ?></p>
                    </div>
                    <a href="Modules/Login/logout.php" class="btn btnC">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <!-- Frame principal para mostrar el contenido -->
        <iframe id="main-frame" src="Templates/home.php"></iframe>
    </div>



    <script>
        document.getElementById("menu-toggle").addEventListener("click", function() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
            
            if (window.innerWidth <= 768) {
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    item.addEventListener('click', () => {
                        sidebar.classList.remove('collapsed');
                    });
                });
            }
        });
    
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById("sidebar");
            const menuToggle = document.getElementById("menu-toggle");
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target)) {
                sidebar.classList.remove('collapsed');
            }
        });
    
        document.getElementById("main-frame").addEventListener("load", function() {
            this.contentWindow.document.addEventListener("click", function() {
                const btnUser = document.getElementById("btn-user");
                btnUser.checked = false;
            });
        });
    </script>
