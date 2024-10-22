<?php
require_once('../includes/db_connection.php'); // Incluye el archivo de conexión a la base de datos
$uploads_folder = '../uploads/'; // Define la carpeta donde se subirán las fotos

// Verifica si se enviaron los datos a través del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos del formulario
    $size = $_POST['size'];
    $species_id = $_POST['species'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $state_tree_id = $_POST['tree_state'];
    
    // Manejo de fotografía
    if (isset($_FILES["photo_path"]) && $_FILES["photo_path"]["error"] == UPLOAD_ERR_OK) {
        //Obtener la información del archivo
        $file_tmp = $_FILES["photo_path"]["tmp_name"];
        $file_name = uniqid() . '_' . basename($_FILES["photo_path"]["name"]); //uniqid crea nombres aleatorios de manera rápida.
        $target_file = $uploads_folder . $file_name;

        //Mueve el archivo a la carpeta de destino
        if (move_uploaded_file($file_tmp, $target_file)) {
            $photo_path = $file_name;
        } else {
            echo "Error al mover la imagen.";
            exit;
        }
    } else {
        $photo_path = null; //Si no se cargó ninguna foto
    }

    //Validación de campos obligatorios
    if (empty($size) || empty($species_id) || empty($location) || empty($price) || empty($state_tree_id)) {
        echo "Todos los campos obligatorios deben ser llenados.";
    } else {
        // Prepara la consulta para agregar el árbol
        $stmt = $conn->prepare("INSERT INTO tree (size, species_id, location, price, photo_path, state_tree_id, last_update_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sisssi", $size, $species_id, $location, $price, $photo_path, $state_tree_id);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Redirige de nuevo a la lista de árboles si la inserción es exitosa
            header('Location: ../views/crud_tree.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        // Cierra la conexión
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Solicitud inválida.";
}
?>
