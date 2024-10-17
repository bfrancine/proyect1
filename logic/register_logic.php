<?php
include('../includes/db_connection.php'); 

// Recibir datos del formulario
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];

// Encriptar la contraseña usando MD5
$hashed_password = md5($password);

// se tiene user_id para el amigo 
$user_id = 1; //en este caso amigo = 1 

// Insertar el nuevo amigo
$sql = "INSERT INTO friends (user_id, first_name, last_name, phone_number, email, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", $user_id, $first_name, $last_name, $phone_number, $email, $address, $hashed_password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Nuevo amigo registrado con éxito.";
} else {
    echo "Error al registrar el amigo: " . $conn->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
