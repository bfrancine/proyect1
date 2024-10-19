<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $commercial_name = $_POST['commercial_name'];
    $scientific_name = $_POST['scientific_name'];

    // Conexión a la base de datos
    include('../includes/db_connection.php'); 

    // Prepara la consulta SQL para actualizar la especie
    $sql = "UPDATE species SET commercial_name = ?, scientific_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Vincula los parámetros a la consulta
    $stmt->bind_param("ssi", $commercial_name, $scientific_name, $id);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Species updated successfully.";
    } else {
        echo "Error updating species: " . $stmt->error;
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();

    // Redirige al crud de especies
    header('Location: ../views/crud_species.php');
    exit;
}

?>
