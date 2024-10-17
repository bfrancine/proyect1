<?php
include('../includes/functions.php'); 

// Obtiene el email del formulario
$commercial_name = $_POST['commercial_name'] ?? null;

// Validación básica
if (empty($commercial_name)) {
    header("Location: ../views/crud_species.php?error=El email está vacío");
    exit();
}

// Conectar a la base de datos
require_once('../includes/db_connection.php');

// Consulta para eliminar al usuario
$sql = "DELETE FROM species WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $commercial_name);

// Ejecuta la consulta
if ($stmt->execute()) {
    // Redirige a la página de éxito o muestra un mensaje
    header("Location: ../views/crud_species.php"); 
} else {
    // Manejo del error
    header("Location: ../views/crud_species.php?error=Error: " . $stmt->error);
}

// Cierra la declaración y la conexión
$stmt->close();
$conn->close();
?>

