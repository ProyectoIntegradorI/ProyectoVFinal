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
    $userId = $_POST['userId'];
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

    // Actualizar los datos
    $query = $conn->prepare("UPDATE deportistas SET name_user = ?, apellidoPat = ?, apellidoMar = ?, tipoSangre = ?, lateralidad = ?, enfermedades = ?, sexo = ?, edad = ?, peso = ?, altura = ? WHERE userId = ?");

    if (!$query) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Asignar los parámetros correspondientes
    $query->bind_param("ssssssssidd", $name_user, $apellidoPat, $apellidoMar, $tipoSangre, $lateralidad, $enfermedades, $sexo, $edad, $peso, $altura, $userId);

    if ($query->execute()) {
        echo "Datos actualizados correctamente.";
        header("Location: ../HTML/UpdAt.php");
    } else {
        echo "Error al actualizar los datos: " . $query->error;
    }

    $query->close();
}

$conn->close();
?>
