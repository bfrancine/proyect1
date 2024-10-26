<?php
// Incluir la conexión a la base de datos
include('../includes/db_connection.php'); 

// Iniciar sesión antes de la lógica de redirección
session_start();

// Recibir datos del formulario
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    die("Please complete all fields.");
}

// Consultar si el usuario es un administrador
$sql = "SELECT * FROM administrator WHERE email = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (md5($password) === $admin['password']) { // Comparar el hash
        // Contraseña correcta
        $_SESSION['admin_logged_in'] = true; // Marca que el usuario es un administrador
        header("Location: ../views/dashboard.php");
        exit(); 
    } else {
        header("Location: ../index.php?error=incorrect_password");
        exit(); 
    }
} else {
    // Consultar si el usuario es un amigo
    $sql_friends = "SELECT * FROM friends WHERE email = ?";
    $stmt_friends = $conn->prepare($sql_friends);
    $stmt_friends->bind_param("s", $email);
    $stmt_friends->execute();
    $result_friends = $stmt_friends->get_result();

    if ($result_friends->num_rows > 0) {
        $friend = $result_friends->fetch_assoc();
        
        // Verificar la contraseña
        if (md5($password) === $friend['password']) { // Comparar el hash
            // Contraseña correcta
            $_SESSION['friend_logged_in'] = true; // Marca que el usuario es un amigo
            $_SESSION['friend_id'] = $friend['id']; // Almacenar el ID del amigo en la sesión
            header("Location: ../views/friend_dashboard.php");
            exit();
        } else {
            header("Location: ../index.php?error=incorrect_password");
            exit();
        }
    } else {
        header("Location: ../index.php?error=user_not_found");
        exit();
    }
}

// Cerrar la conexión
$stmt->close();
$stmt_friends->close();
$conn->close();
?>
