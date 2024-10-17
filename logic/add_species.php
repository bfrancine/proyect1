<?php
// Incluye el archivo de  conexión a la base de datos 
include('../includes/functions.php');

// Verifica si se enviaron los datos a través del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $commercial_name = $_POST['commercial_name'];
    $scientific_name = isset($_POST['scientific_name']) ? $_POST['scientific_name'] : '';

    // Validación de los campos 
    if (!empty($commercial_name)) {
      // Conectar a la base de datos
        require_once('../includes/db_connection.php');

        // Consulta para agregar especies
        $stmt = $conn->prepare("INSERT INTO species (commercial_name, scientific_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $commercial_name, $scientific_name);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Redirige de nuevo a la lista de especies si la inserción es exitosa
            header('Location: ../views/crud_species.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cierra la conexión
        $stmt->close();
        $conn->close();
    } else {
        echo "The commercial name is required.";
    }
} else {
    echo "Invalid request.";
}
