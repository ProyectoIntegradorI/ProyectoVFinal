<?php
$servername = "localhost";
$username = "root";

$password = "tamara11";
$dbname = "skila";



// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $userId = $_POST['userId']; // Asegúrate de que este valor se está enviando desde el formulario
    $name_user = $_POST['name_user'];
    $apellidoPat = $_POST['apellidoPat'];
    $apellidoMar = $_POST['apellidoMar'];
    $tipoSangre = $_POST['tipoSangre'];
    $lateralidad = $_POST['lateralidad'];
    $enfermedades = $_POST['enfermedades'];
    $sexo = $_POST['sexo'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];

    // Manejo de control
    //echo "User ID: $userId, Nombre: $name_user, Apellido Paterno: $apellidoPat, Apellido Materno: $apellidoMar, Tipo de Sangre: $tipoSangre, Lateralidad: $lateralidad, Enfermedades: $enfermedades, Sexo: $sexo, Edad: $edad, Peso: $peso, Altura: $altura";

    // Insert
    $query = $conn->prepare("INSERT INTO deportistas (userId, name_user, apellidoPat, apellidoMar, tipoSangre, lateralidad, enfermedades, sexo, edad, peso, altura) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$query) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // i=Int s=String d = float
    $query->bind_param("isssssssidd", $userId, $name_user, $apellidoPat, $apellidoMar, $tipoSangre, $lateralidad, $enfermedades, $sexo, $edad, $peso, $altura);

    if ($query->execute()) {
        echo "Datos insertados correctamente.";
        header("Location: ../HTML/InsAt.php");
    } else {
        echo "Error al insertar los datos: " . $query->error;
    }

    $query->close();
}

$conn->close();
?>
