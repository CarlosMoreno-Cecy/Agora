<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="datosUsuario">
                <div class="form-group">
                    <h4>Tu correo ha sido validado, ahora por favor ingresa los siguientes datos:</h4>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" readonly value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" placeholder="Ingresa la contraseña" required name="password">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required name="nombre">
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apaterno" placeholder="Ingresa el apellido paterno" name="apaterno">
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno:</label>
                    <input type="text" class="form-control" id="amaterno" placeholder="Ingresa el apellido materno" name="amaterno">
                </div>
                <div class="form-group" style="display: none;">
                    <label for="estado">Estado:</label>
                    <select class="form-control" id="estado" required name="estado">
                        <option value="1">Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuario:</label>
                    <input type="text" class="form-control" id="tipo_usuario" name="tipo_usuario" readonly  value="<?php echo isset($_GET['tipo_usuario']) ? htmlspecialchars($_GET['tipo_usuario']) : ''; ?>">
                </div>
             <!--   <div class="form-group">
                    <label for="permisos" id="permisos">Permisos: A</label> -->
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" name="submit" id="validar">Guardar</button>
            </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit'])) {
            require '../../Config/conexion.php';

            $email = $_POST["email"];
            $password = $_POST["password"];
            $nombre = $_POST["nombre"];
            $apaterno = $_POST["apaterno"];
            $amaterno = $_POST["amaterno"];
            
            // Hash de la contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = mysqli_query($connection, "INSERT INTO usuario (password, nombre, apaterno, amaterno) VALUES ('$password', '$nombre', '$apaterno', '$amaterno') WHERE email = '$email'");
            if ($sql) {
                echo "<script>
                    window.onload = function() {
                        document.getElementById('overlay').style.display = 'flex';
                    }
                </script>";
            } else {
                echo "No se creó el usuario";
            }
        }
    }
    ?>

            <!-- Ventana emergente de éxito -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Usuario creado exitosamente!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
    </div>
</div>

<script>
    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>
</body>
</html>