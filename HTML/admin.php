<?php
// esta validacion es para que si se redirecciona a otra pagina no se vuelva a iniciar si ya hay una
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
// Establecer tiempo de expiración de sesión
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1200)) {
    // Sesión en 20 minutos
    //si se pasa el tiempo se destruyen las variables de sesion
    session_unset();
    session_destroy();
    header("Location: ../HTML/login.html?error=Sesión expirada");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); 

// Proteccion de ruta
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirigir a la página de inicio de sesión si no está autenticado
    header("Location: ../HTML/login.html?error=Acceso no autorizado");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asociación Esparzana de Tenis de Mesa</title>
   
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a82054a465.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/admin.css">
 
</head>
<body>
    <header>
        <div class="container-fluid header-container">
            <span>ASOCIACIÓN ESPARZANA</span>
            <img src="../img/pelotaicon.png" alt="Logo" width="100" height="100" />
            <span>DE TENIS DE MESA</span>
        </div>
    </header>

    <div class="encabezado collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../HTML/evalFis.php">Evaluación física</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../HTML/visualEval.php">Visualizar Evaluaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../HTML/filtrado.php">Jugadores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../HTML/InsAt.php">Agregar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../HTML/UpdAt.php">Editar Deportistas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../HTML/borrarAtleta.html">Borrar</a>
            </li>
           
        </ul>
    </div>
    
    <footer class="footer">
        <div class="box">
            <h4>Síguenos</h4>
            <div class="social-net">
                <a href="https://www.facebook.com/aeteme.esparza.9" class="fa fa-facebook"></a>
                <a href="https://www.instagram.com/aetemecr?igsh=Z2hvbWkxMHJpd3B4" class="fa fa-instagram"></a>
                <a href="https://wa.me/50686596969" class="fa fa-whatsapp"></a>
            </div>
        </div>
        <div class="group-2">
            <small>&copy; 2024 <b>AETEME</b> - All rights reserved</small>
        </div>
    </footer>
</body>
</html>
