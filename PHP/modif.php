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
    // Recibir datos del formulario y asignar valores predeterminados si faltan
    $userId = $_POST['userId']; 
    $name_user = $_POST['name_user'] ?? ''; 
    $apellidoPat = $_POST['apellidoPat'] ?? '';
    $apellidoMar = $_POST['apellidoMar'] ?? '';
    $tipoSangre = $_POST['tipoSangre'] ?? '';
    $lateralidad = $_POST['lateralidad'] ?? ''; 
    $enfermedades = $_POST['enfermedades'] ?? ''; 
    $sexo = $_POST['sexo'] ?? '';
    $edad = $_POST['edad'] ?? 0; 
    $peso = $_POST['peso'] ?? 0.0; 
    $altura = $_POST['altura'] ?? 0.0; 

    // Manejo de control
    echo "User ID: $userId, Nombre: $name_user, Apellido Paterno: $apellidoPat, Apellido Materno: $apellidoMar, Tipo de Sangre: $tipoSangre, Lateralidad: $lateralidad, Enfermedades: $enfermedades, Sexo: $sexo, Edad: $edad, Peso: $peso, Altura: $altura";

    // Actualizar
    $query = $conn->prepare("UPDATE deportistas SET name_user = ?, apellidoPat = ?, apellidoMar = ?, tipoSangre = ?, lateralidad = ?, enfermedades = ?, sexo = ?, edad = ?, peso = ?, altura = ? WHERE userId = ?");

    if (!$query) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // i=Int s=String d = float
    $query->bind_param("ssssssssidd", $name_user, $apellidoPat, $apellidoMar, $tipoSangre, $lateralidad, $enfermedades, $sexo, $edad, $peso, $altura, $userId);

    if ($query->execute()) {
        echo "Datos actualizados correctamente.";
        header("Location: ../HTML/UpdAt.html");
        exit(); // Añade exit() para asegurarte de que el script se detiene después de redireccionar
    } else {
        echo "Error al actualizar los datos: " . $query->error;
    }

    $query->close();
}

$conn->close();
?>
