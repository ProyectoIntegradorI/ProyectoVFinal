<?php

$$servername = "localhost";
$username = "root";

$password = "Sanchez18.";
$dbname = "proyectoint1";



$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$userId = $_POST['userId'];

// Preparar y ejecutar la consulta para actualizar el estado
$sql = "UPDATE deportistas SET status = 'inactivo' WHERE userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    // Establecer una variable en localStorage para mostrar el mensaje
    echo "<script>
            localStorage.setItem('atletaEliminado', 'true');
            window.location.href = '../HTML/borrarAtleta.html';
          </script>";
    exit();
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>
