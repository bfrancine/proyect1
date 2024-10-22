<?php
echo('HELLO');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $species_id = $_POST['species_id'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $state_tree_id = $_POST['state_tree_id'];

    // Conexión a la base de datos
    include('../includes/db_connection.php'); 

    // Verifica si se ha subido una nueva imagen
    $photo_path = null; //Se inicializa en null y en caso de que se suba una nueva foto se omite la actualización para este campo
    if (isset($_FILES['photo_path']) && $_FILES['photo_path']['error'] == UPLOAD_ERR_OK) {
        // Define la carpeta de destino
        $uploads_folder = '../uploads/';
        // Genera un nombre único para la imagen
        $file_name = uniqid() . '_' . basename($_FILES['photo_path']['name']);
        $target_file = $uploads_folder . $file_name;

        // Mueve la imagen al directorio de uploads
        if (move_uploaded_file($_FILES['photo_path']['tmp_name'], $target_file)) {
            $photo_path = $file_name;
        } else {
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Prepara la consulta SQL para actualizar el árbol
    if ($photo_path) {
        // Si hay una nueva imagen, también se actualiza el campo de la foto
        $sql = "UPDATE tree SET size = ?, species_id = ?, location = ?, price = ?, state_tree_id = ?, photo_path = ?, last_update_date = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissisi", $size, $species_id, $location, $price, $state_tree_id, $photo_path, $id);
    } else {
        // Si no hay nueva imagen, se omite la actualización del campo de la foto
        $sql = "UPDATE tree SET size = ?, species_id = ?, location = ?, price = ?, state_tree_id = ?, last_update_date = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissii", $size, $species_id, $location, $price, $state_tree_id, $id);
    }

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Tree updated successfully.";
    } else {
        echo "Error updating tree: " . $stmt->error;
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();

    // Redirige al CRUD de árboles
    header('Location: ../views/crud_tree.php');
    exit;
}
?>
