<?php

$servername = "localhost"; 
$username = "root";
$password = "Sanchez18.";
$dbname = "proyectoint1"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el término de búsqueda si existe
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Modificar la consulta SQL para filtrar por el término de búsqueda
$sql = "SELECT e.evalId, CONCAT(d.name_user, ' ', d.apellidoPat, ' ', d.apellidoMar) AS nombreCompleto, e.admiId, e.IMC, e.porcentGras, e.aguaCorp, e.pesoEnMusc, e.nivProt, e.fecha, e.observa 
        FROM evalFis e 
        JOIN deportistas d ON e.userId = d.userId";

if (!empty($searchTerm)) {
    $escapedSearchTerm = $conn->real_escape_string($searchTerm);
    $sql .= " WHERE d.name_user LIKE '%$escapedSearchTerm%' 
              OR d.apellidoPat LIKE '%$escapedSearchTerm%' 
              OR d.apellidoMar LIKE '%$escapedSearchTerm%' 
              OR CONCAT(d.name_user, ' ', d.apellidoPat, ' ', d.apellidoMar) LIKE '%$escapedSearchTerm%'";
}

$result = $conn->query($sql);

// Initialize $selectedPlayer before using it
$selectedPlayer = '';

// Check if the 'search' parameter is set in the GET request
if (isset($_GET['search'])) {
    $selectedPlayer = $_GET['search'];
}
?>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
// Establecer tiempo de expiración de sesión
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1200)) {
    session_unset();
    session_destroy();
    header("Location: ../HTML/login.html?error=Sesión expirada");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); 

// Proteccion de ruta
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../HTML/login.html?error=Acceso no autorizado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluaciones Físicas</title>
    <link rel="stylesheet" href="../CSS/visualEval.css">
   
</head>

<body>
    <div class="encabezado">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./admin.php">Panel de control</a>
            </li>
        </ul>
    </div>

    <h1>Lista de Evaluaciones</h1>

    <!-- Formulario para filtrar por jugador -->
    <!-- Formulario para filtrar por jugador -->
<div class="search-form-container">
    <form method="get" action="">
        <label for="search">Buscar Jugador:</label>
        <input type="text" id="search" name="search" class="styled-search" value="<?php echo htmlspecialchars($selectedPlayer); ?>">
        <button type="submit" class="btn-primary1">Buscar</button>
    </form>
</div>



    <form action="../FPDF/generarPDF.php" method="post">
    <table>
    <thead>
        <tr>
            <th></th>
            <th>Id Evaluación</th>
            <th>Nombre del Atleta</th>
            <th>Id Administrador</th>
            <th>IMC</th>
            <th>Porcentaje Grasa</th>
            <th>Agua Corporal</th>
            <th>Peso en Músculo</th>
            <th>Nivel de Proteína</th>
            <th>Fecha</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input class='form-check-input' type='checkbox' name='selectedRows[]' value='" . htmlspecialchars($row['evalId']) . "'></td>"; 
            echo "<td>" . htmlspecialchars($row['evalId']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nombreCompleto']) . "</td>";
            echo "<td>" . htmlspecialchars($row['admiId']) . "</td>";
            echo "<td>" . htmlspecialchars($row['IMC']) . "</td>";
            echo "<td>" . htmlspecialchars($row['porcentGras']) . "</td>";
            echo "<td>" . htmlspecialchars($row['aguaCorp']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pesoEnMusc']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nivProt']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($row['observa']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No se encontraron evaluaciones</td></tr>";
    }
    ?>
    </tbody>
    </table>
    <button type="submit" class="btn-primary">Generar PDF</button>
    </form>


    <script>
function filterTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toLowerCase();
    table = document.querySelector("table tbody");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Columna de "Nombre del Atleta"
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}
</script>


</body>
</html>

<?php
$conn->close();
?>
