<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Conexión a la base de datos
    include('../includes/db_connection.php'); 

    // consulta SQL para eliminar la especie
    $sql = "DELETE FROM tree WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro id a la consulta
    $stmt->bind_param("i", $id);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Species deleted successfully.";
    } else {
        echo "Error deleting tree: " . $stmt->error;
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();

    // Redirige de vuelta a la lista de especies
    header('Location: ../views/crud_tree.php');
    exit;
}
?>
