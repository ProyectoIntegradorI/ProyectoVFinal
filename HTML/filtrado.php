<?php

$servername = "localhost"; 
$username = "root";
$password = "tamara11";
$dbname = "skila"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$sql = "SELECT userId, name_user, apellidoPat, apellidoMar, tipoSangre, lateralidad, enfermedades, sexo, edad, peso, altura, status FROM deportistas";
$result = $conn->query($sql);
?>
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Atletas</title>
    <link rel="stylesheet" href="../CSS/table.css">
    
</head>

<body>
    
   

    <div class="encabezado collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="home.php">Inicio</a>
            </li>
         
            <li class="nav-item">
              <a class="nav-link" href="./admin.php">Panel de control</a>
            </li>
          </ul>
    </div>
    <h1 class = "center" >Lista de Deportistas</h1>
    <table>
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Tipo de Sangre</th>
            <th>Lateralidad</th>
            <th>Enfermedades</th>
            <th>Sexo</th>
            <th>Edad</th>
            <th>Peso</th>
            <th>Altura</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
       
        if ($result->num_rows > 0) {
            // Aqui estoy iterando en la lista
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['userId']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name_user']) . "</td>";
                echo "<td>" . htmlspecialchars($row['apellidoPat']) . "</td>";
                echo "<td>" . htmlspecialchars($row['apellidoMar']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tipoSangre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lateralidad']) . "</td>";
                echo "<td>" . htmlspecialchars($row['enfermedades']) . "</td>";
                echo "<td>" . htmlspecialchars($row['sexo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['edad']) . "</td>";
                echo "<td>" . htmlspecialchars($row['peso']) . "</td>";
                echo "<td>" . htmlspecialchars($row['altura']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No se encontraron deportistas</td></tr>";
        }
        ?>
    </tbody>
</table>


</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
