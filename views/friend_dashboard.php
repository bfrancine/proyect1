<?php
session_start();
require_once('../includes/db_connection.php');

// Verificar si el amigo ha iniciado sesión
if (!isset($_SESSION['friend_id'])) {
    header("Location: ../index.php?error=access_denied");
    exit();
}

// Obtener árboles disponibles
$stmt = $pdo->query("SELECT * FROM tree WHERE state_tree_id = 1"); // Supongamos que 1 es el estado "Disponible"
$trees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Amigo</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
   
</body>
</html>
