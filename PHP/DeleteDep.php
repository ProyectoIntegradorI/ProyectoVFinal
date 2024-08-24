<?php
session_start();

$servername = "localhost";
$username = "root";

$password = "Sanchez18.";
$dbname = "proyectoint1";


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(array('status' => 'error', 'message' => 'Error al conectar con la base de datos')));
}

$response = array('status' => 'error', 'message' => 'Error al borrar el atleta');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario de manera segura
    $deleteUserId = isset($_POST['deleteUserId']) ? intval($_POST['deleteUserId']) : 0;

    if ($deleteUserId > 0) {
        // Consulta para borrar el atleta
        $query = $conn->prepare("DELETE FROM deportistas WHERE userId = ?");
        if (!$query) {
            die(json_encode(array('status' => 'error', 'message' => 'Error en la preparación de la consulta')));
        }
        $query->bind_param("i", $deleteUserId);
        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Atleta borrado exitosamente';
            } else {
                $response['message'] = 'ID de atleta no encontrado';
            }
        } else {
            $response['message'] = 'Error en la consulta';
        }

        $query->close();
    } else {
        $response['message'] = 'ID de atleta inválido';
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>