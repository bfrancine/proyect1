<?php
// Incluye el archivo de conexión a la base de datos 
require_once('../includes/db_connection.php');

// Verifica si se enviaron los datos a través del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $size = $_POST['size'];
    $species_id = $_POST['species']; // Asegúrate que este campo tenga el name="species"
    $location = $_POST['location'];
    $price = $_POST['price'];
    $photo_path = isset($_POST['photo_path']) ? $_POST['photo_path'] : ''; // foto opcional
    $state_tree_id = $_POST['tree_state']; // Asegúrate que este campo tenga el name="tree_state"

    // Validación de los campos obligatorios
    if (empty($size) || empty($species_id) || empty($location) || empty($price) || empty($state_tree_id)) {
        echo "Todos los campos obligatorios deben ser llenados.";
    } else {
        // Preparar la consulta para agregar el árbol
        $stmt = $conn->prepare("INSERT INTO tree (size, species_id, location, price, photo_path, state_tree_id, last_update_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");

        // Asegúrate de que los tipos de datos sean correctos
        $stmt->bind_param("sissis", $size, $species_id, $location, $price, $photo_path, $state_tree_id);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Redirige de nuevo a la lista de árboles si la inserción es exitosa
            header('Location: ../views/crud_tree.php');
            exit;
        } else {
            echo "Error: " . $stmt->error; // Muestra el error si hay alguno
        }

        // Cierra la conexión
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request."; // Corrige el texto de respuesta
}
?>

