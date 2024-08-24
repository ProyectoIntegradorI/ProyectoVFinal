<?php
$servername = "localhost";
$username = "root";

$password = "tamara11";
$dbname = "skila";



header('Content-Type: application/json');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el userId del query string
$userId = $_GET['userId'];

$sql = "SELECT * FROM deportistas WHERE userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$conn->close();
?>
