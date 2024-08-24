<?php
session_start();

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
    
    $inputUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $inputPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Gt del nombre
    $query = $conn->prepare("SELECT password_hash FROM usuarios WHERE name = ?");
    $query->bind_param("s", $inputUsername);
    $query->execute();
    $result = $query->get_result();

    // Verifica si se encontró un usuario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHash = $row['password_hash'];

        $inputPasswordHash = hash('sha256', $inputPassword); // aqui encripta la contraseña del login 

        // Aqui lo que hace es comparar la contraseña encriptada que nos da el login y la compara con la bd
        if (hash_equals($storedHash, $inputPasswordHash)) {
            $_SESSION['name'] = $inputUsername;
            session_regenerate_id(true);

            $_SESSION['loggedin'] = true;
            $_SESSION['LAST_ACTIVITY'] = time();

            header("Location: ../HTML/admin.php");
            exit();
        } else {
            header("Location: ../HTML/login.html?error=Contraseña incorrecta");
            exit();
        }
     
        
    }else{
        echo "<script>alert('Usuario o Contraseña incorrecta');</script>";
        header("Location: ../HTML/login.html?error=Usuario no encontrado");
        exit();
    }
    $query->close();
}

$conn->close();
?>
