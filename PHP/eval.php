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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $userId = $_POST['userId']; // Asegúrate de que este valor se está enviando desde el formulario
    $admiId = $_POST['admiId'];
    $IMC = $_POST['IMC'];
    $porcentGras = $_POST['porcentGras'];
    $aguaCorp = $_POST['aguaCorp'];
    $pesoEnMusc = $_POST['pesoEnMusc'];
    $nivProt = $_POST['nivProt'];
    $fecha = $_POST['fecha'] ?? date('Y-m-d H:i:s');
    $observa =  $_POST['observa'];

    // Manejo de control
   // echo "User ID: $userId, Nombre: $name_user, Apellido Paterno: $apellidoPat, Apellido Materno: $apellidoMar, Tipo de Sangre: $tipoSangre, Lateralidad: $lateralidad, Enfermedades: $enfermedades, Sexo: $sexo, Edad: $edad, Peso: $peso, Altura: $altura";

    // Insert
    $query = $conn->prepare("INSERT INTO evalfis (userId, admiId, IMC, porcentGras, aguaCorp, pesoEnMusc, nivProt, fecha, observa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$query) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // i=Int s=String d = float
    $query->bind_param("iidddddss", $userId, $admiId, $IMC, $porcentGras, $aguaCorp, $pesoEnMusc, $nivProt, $fecha, $observa);

    if ($query->execute()) {
        echo "Datos insertados correctamente.";
        header("Location: ../HTML/admin.php");
    } else {
        echo "Error al insertar los datos: " . $query->error;
    }

    $query->close();
}

$conn->close();
?>
