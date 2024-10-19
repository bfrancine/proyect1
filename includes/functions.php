<?php
//Funcio para obtener todas las especies
function getAllSpecies() {
    include('../includes/db_connection.php');// Conexión a la base de datos
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
//funcion para obtener el ID de especie 
function getSpecieById($id) {
    include('../includes/db_connection.php');// Conexión a la base de datos

    // Prepara la consulta para obtener la especie por ID
    $sql = "SELECT * FROM species WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Vincula el parámetro ID para evitar inyecciones SQL
    $stmt->bind_param("i", $id);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene el resultado
    $result = $stmt->get_result();

    // Verifica si se encontró una fila y la devuelve como un array asociativo
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc(); // Devuelve los datos de la especie
    } else {
        $data = null; // Si no se encuentra, devuelve null
    }

    // Cierra el statement y la conexión
    $stmt->close();
    $conn->close();

    return $data; // Devuelve los datos o null
}


// Función para obtener todos los amigos
    function getAllFriends() {
        // Incluir la conexión a la base de datos
        include('../includes/db_connection.php');
    
        // Obtener todos los amigos con los campos necesarios
        $sql = "SELECT id, first_name, last_name, phone_number, email, address FROM friends";
        $result = $conn->query($sql);
    
        // Inicializar un array para almacenar los amigos
        $friends = [];
    
        if ($result->num_rows > 0) {
            while ($friend = $result->fetch_assoc()) {
                $friends[] = $friend; // Agrega cada amigo al array
            }
        }
    
        // Cerrar la conexión
        $conn->close();
    
        return $friends; // Devolver el array de amigos
    }
?>
