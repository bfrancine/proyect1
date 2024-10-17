<?php
// Conectar a la base de datos
require_once('../includes/db_connection.php');

/*// Datos del nuevo administrador
$first_name = 'alondra';
$last_name = 'rodriguez';
$email = 'a@email.com';
$password = 'alo09';

// Encriptar la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar el nuevo administrador
$sql = "INSERT INTO administrator (user_id, password, first_name, last_name, email) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Suponiendo que ya tienes un user_id (esto puede ser un valor real o que lo generes primero)
$user_id = 1; // Cambia esto según tu lógica

$stmt->bind_param("issss", $user_id, $hashed_password, $first_name, $last_name, $email);
$stmt->execute();

echo "Nuevo administrador creado con éxito.";

// Cerrar la conexión
$stmt->close();
$conn->close();
?>*/


<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- diseño CSS-->
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="../logic/login_logic.php" method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
