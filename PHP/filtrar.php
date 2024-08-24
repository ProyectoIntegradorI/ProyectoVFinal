<?php
$servername = "localhost";
$username = "root";

$password = "Sanchez18.";
$dbname = "proyectoint1";



// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener datos
$sql = "SELECT userId, name_user FROM deportistas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generar opciones del combobox
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($row["userId"]) . "'>" . htmlspecialchars($row["name_user"]) . "</option>";
    }
} else {
    echo "<option value=''>No hay datos disponibles</option>";
}

$conn->close();
?>
