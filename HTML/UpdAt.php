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
                        document.getElementById('name_user').value = data.name_user;
                        document.getElementById('apellidoPat').value = data.apellidoPat;
                        document.getElementById('apellidoMar').value = data.apellidoMar;
                        document.getElementById('tipoSangre').value = data.tipoSangre;
                        document.getElementById('lateralidad').value = data.lateralidad;
                        document.getElementById('enfermedades').value = data.enfermedades;
                        document.getElementById('sexo').value = data.sexo;
                        document.getElementById('edad').value = data.edad;
                        document.getElementById('peso').value = data.peso;
                        document.getElementById('altura').value = data.altura;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</head>
<body>
    <div class="container mt-3">
        <img src="../img/headerimage.png" alt="Encabezado" class="header-image">
        <h1 class="mt-3 mb-4">Actualizar Atleta</h1>
       
  
        <form action="../PHP/modif.php" method="POST">
            <div class="mb-3">
                <label for="deportistas" class="form-label">Seleccionar Deportista:</label>
                <select id="deportista" name="userId" onchange="getDetails(this.value)">
                 
                 <?php include '../PHP/filtrar.php'; ?>
                  
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="userId" class="form-label">Cedula:</label>
                    <input type="text" class="form-control" id="userId" name="userId" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name_user" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="name_user" name="name_user" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidoPat" class="form-label">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apellidoPat" name="apellidoPat" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellidoMar" class="form-label">Apellido Materno:</label>
                    <input type="text" class="form-control" id="apellidoMar" name="apellidoMar" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipoSangre" class="form-label">Tipo de Sangre:</label>
                    <select class="form-control" id="tipoSangre" name="tipoSangre" required>
                        <option value="">Seleccione</option> 
                        <option value="">A</option> 
                        <option value="">B</option> 
                        <option value="">AB+</option> 
                        <option value="">O+</option>
                        <option value="">O-</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lateralidad" class="form-label">Lateralidad:</label>
                    <select class="form-control" id="latelaridad" name="latelaridad" required>
                        <option value="">Seleccione</option> 
                        <option value="">Izquierda</option> 
                        <option value="">Derecha</option> 
                </div>
                <div class="col-md-6 mb-3">
                    <label for="enfermedades" class="form-label">Enfermedades:</label>
                    <select class="form-control" id="enfermedades" name="enfermedades" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sexo" class="form-label">Sexo:</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="">Seleccione</option> 
                        <option value="">M</option> 
                        <option value="">F</option> 
                        <option value="">O</option> 
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="edad" class="form-label">Edad:</label>
                    <input type="text" class="form-control" id="edad" name="edad" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="peso" class="form-label">Peso:</label>
                    <input type="text" class="form-control" id="peso" name="peso" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="altura" class="form-label">Altura:</label>
                    <input type="text" class="form-control" id="altura" name="altura" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Atleta</button>
            <a href="../HTML/admin.php" class="btn-primary">Panel de control</a>
           
        </form>
    </div>
  
  
</body>
</html>
