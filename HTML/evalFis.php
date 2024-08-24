<?php
// esta validacion es para que si se redirecciona a otra pagina no se vuelva a iniciar si ya hay una
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
// Establecer tiempo de expiración de sesión
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1200)) {
    // Sesión en 20 minutos
    //si se pasa el tiempo se destruyen las variables de sesion
    session_unset();
    session_destroy();
    header("Location: ../HTML/login.html?error=Sesión expirada");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); 

// Proteccion de ruta
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirigir a la página de inicio de sesión si no está autenticado
    header("Location: ../HTML/login.html?error=Acceso no autorizado");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Atleta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="../CSS/insAt.css" rel="stylesheet">

    
    <script>
        function getDetails(userId) {
            if (userId) {
                fetch(`../PHP/getDetalles.php?userId=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('userId').value = data.userId;
                      
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</head>
<body>
    <div class="container mt-3">
        <img src="../img/headerimage.png" alt="Encabezado" class="header-image">
        <h1 class="mt-3 mb-4">Evaluación Física</h1>
       
  
        <form action="../PHP/eval.php" method="POST">
            <div class="mb-3">
                <label for="deportistas" class="form-label">Seleccionar Deportista:</label>
                <select id="deportista" name="userId" onchange="getDetails(this.value)">
                 
                 <?php include '../PHP/filtrar.php'; ?>
                  
                </select>
            </div>
            <div class="row">
        

                <div class="col-md-6 mb-3">
                    <label for="userId" class="form-label">Cedula de Atleta:</label>
                    <input type="text" class="form-control" id="userId" name="userId" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="admiId" class="form-label">Identificador de administrador:</label>
                    <input type="text" class="form-control" id="admiId" name="admiId" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="IMC" class="form-label">IMC:</label>
                    <input type="text" class="form-control" id="IMC" name="IMC" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="porcentGras" class="form-label"> Porcentaje de gras</label>
                    <input type="text" class="form-control" id="porcentGras" name="porcentGras" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="aguaCorp" class="form-label">Agua corporal:</label>
                    <input type="text" class="form-control" id="aguaCorp" name="aguaCorp" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pesoEnMusc" class="form-label">Peso en musculo:</label>
                    <input type="text" class="form-control" id="pesoEnMusc" name="pesoEnMusc" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nivProt" class="form-label">Nivel de proteina:</label>
                    <input type="text" class="form-control" id="nivProt" name="nivProt" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nivProt" class="form-label">Observaciones:</label>
                    <textarea name="observa" class="form-control" id="observa" required></textarea>
                </div>
            

              
            </div>
            <button type="submit" class="btn btn-primary">Agregar Evaluacion</button>
            <a href="../HTML/admin.php" class="btn-primary">Panel de control</a>
           
        </form>
    </div>
  
  
</body>
</html>
