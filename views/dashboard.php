<link rel="stylesheet" href="../css/dashboard.css"> 
<?php
include '../includes/menu_administrator.html';
// Conectar a la base de datos
require_once('../includes/db_connection.php');

 
// Consulta total de usuarios
$sql_users = "SELECT COUNT(*) AS total_users FROM friends";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

// Consulta total de árboles disponibles
$sql_trees = "SELECT COUNT(*) AS total_trees FROM tree WHERE state_tree_id = (SELECT id FROM state_tree WHERE type_state = 'Disponible')";
$result_trees = $conn->query($sql_trees);
$total_trees = $result_trees->fetch_assoc()['total_trees'];

// Consulta total de árboles vendidos
$sql_sold_trees = "SELECT COUNT(DISTINCT tree_id) AS total_sold_trees FROM purchase_tree";
$result_sold_trees = $conn->query($sql_sold_trees);
$total_sold_trees = $result_sold_trees->fetch_assoc()['total_sold_trees'];

// Mostrar los resultados
echo "<h2>Dashboard</h2>";
echo "<p>Cantidad de Amigos Registrados: " . $total_users . "</p>";
echo "<p>Cantidad de Árboles disponibles: " . $total_trees . "</p>";
echo "<p>Cantidad de Árboles vendidos: " . $total_sold_trees . "</p>";

// Cerrar la conexión
$conn->close();
?>
