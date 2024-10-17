<?php
function getAllSpecies() {
    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'project1');

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Consulta para obtener todos las especies
    $sql = "SELECT id, commercial_name, scientific_name FROM species"; 
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        // Almacena los usuarios en un array
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    // Cierra la conexión
    $conn->close();

    return $users;
}
?>
