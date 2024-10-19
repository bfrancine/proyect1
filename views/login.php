<?php
// Conectar a la base de datos
require_once('../includes/db_connection.php');

// Datos del nuevo administrador
$first_name = 'Francine';
$last_name = 'Barquero';
$email = 'f@gmail.com';
$password = '123';

// Encriptar la contraseña
$hashed_password = md5($password);;

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
?>
