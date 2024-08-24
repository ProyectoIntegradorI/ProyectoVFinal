<?php
$servername = "localhost";
$username = "root";

$password = "tamara11";
$dbname = "skila";



$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Cambiar en caso de querer agregar más datos
$sql = "SELECT userId, CONCAT(name_user, ' ', apellidoPat, ' ', apellidoMar) AS name_user 
        FROM deportistas 
        WHERE status = 'activo'";
$result = $conn->query($sql);

$atletas = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $atletas[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($atletas);


$conn->close();
?>
