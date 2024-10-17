<?php
// Incluir la conexión a la base de datos
include('../includes/db_connection.php'); 

// Recibir datos del formulario
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


// Verificar que los campos no estén vacíos
if (empty($email) || empty($password)) {
    die("Por favor, completa todos los campos.");
}

// Consultar si el usuario es un administrador
$sql = "SELECT * FROM administrator WHERE email = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    
    // Verificar la contraseña usando MD5
    if (md5($password) === $admin['password']) {
        // Contraseña correcta
        session_start(); // Iniciar sesión
        $_SESSION['admin_logged_in'] = true; // Marca que el usuario es un administrador
        header("Location: ../views/dashboard.php"); // Redirige al dashboard
        exit(); // Termina el script
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    // Consultar si el usuario es un amigo
    $sql_friends = "SELECT * FROM friends WHERE email = ?";
    $stmt_friends = $conn->prepare($sql_friends);
    $stmt_friends->bind_param("s", $email);
    $stmt_friends->execute();
    $result_friends = $stmt_friends->get_result();

    if ($result_friends->num_rows > 0) {
        // Si es amigo, mostrar mensaje de error
        echo '<div class="error-message">No puedes acceder a esta página porque no eres un administrador.</div>';
    } else {
        echo '<div class="error-message">Usuario no encontrado.</div>';
    }
    
    
}

// Cerrar la conexión
$stmt->close();
$stmt_friends->close();
$conn->close();
?>
