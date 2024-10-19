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
    function getFriendById($id) {
        include('../includes/db_connection.php');// Conexión a la base de datos
    
        // Prepara la consulta para obtener la especie por ID
        $sql = "SELECT * FROM friends WHERE id = ?";
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
    /*function getAllTrees() {
        include('../includes/db_connection.php');// Conexión a la base de datos
        // Consulta para obtener todos los arbolitos
        $sql = "SELECT id, size, species_id, location, price, photo_path, state_tree_id, last_update FROM tree"; 
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
    }*/

    // Función para obtener todas las especies de la tabla 'species'
    function getSpecies() {
        include('../includes/db_connection.php'); // Conexión a la base de datos
    
        $query = "SELECT id, commercial_name FROM species";  // Consulta SQL
        $result = $conn->query($query);  // Ejecutar la consulta
    
        // Verifica si se obtuvieron resultados
        if ($result->num_rows > 0) {
            $species = []; // Array para almacenar las especies
            while ($row = $result->fetch_assoc()) {
                $species[] = $row; // Agregar cada fila al array
            }
            return $species; // Devolver el array de especies
        } else {
            return []; // Devolver un array vacío si no hay resultados
        }
    }    

    // Función para obtener todos los estados de la tabla 'state_tree'
    function getTreeStates() {
        include('../includes/db_connection.php'); // Conexión a la base de datos
    
        $query = "SELECT id, type_state FROM state_tree"; // Consulta SQL
        $result = $conn->query($query); // Ejecutar la consulta
    
        // Verifica si se obtuvieron resultados
        if ($result->num_rows > 0) {
            $states = []; // Array para almacenar los estados
            while ($row = $result->fetch_assoc()) {
                $states[] = $row; // Agregar cada fila al array
            }
            return $states; // Devolver el array de estados
        } else {
            return []; // Devolver un array vacío si no hay resultados
        }
    }
    

    function getAllTrees() {
        include('../includes/db_connection.php');// Conexión a la base de datos
        $trees = [];
        // Consulta SQL para obtener los árboles
        $sql = "SELECT t.id, t.size, s.commercial_name AS species, t.location, t.price, st.type_state, t.last_update_date 
                FROM tree t 
                JOIN species s ON t.species_id = s.id 
                JOIN state_tree st ON t.state_tree_id = st.id";
    
        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $trees[] = $row;
            }
            $result->free();
        } else {
            echo "Error: " . $conn->error; 
        }
    
        return $trees;
    }
// Obtener árboles por ID de amigo
function getTreesByFriendId($friend_id) {
    include('../includes/db_connection.php'); // Conexión a la base de datos
    $stmt = $conn->prepare("
        SELECT t.id, t.size, s.commercial_name AS species, t.location 
        FROM tree t
        JOIN tree_friend tf ON t.id = tf.tree_id
        JOIN species s ON t.species_id = s.id
        WHERE tf.friend_id = ?
    ");
    
    // Vincular el parámetro friend_id
    $stmt->bind_param("i", $friend_id);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado
    $result = $stmt->get_result(); // Obtener el resultado como un objeto de resultados

    $trees = []; // Inicializar el array para almacenar árboles
    
    // Recorrer los resultados y agregarlos al array
    while ($row = $result->fetch_assoc()) {
        $trees[] = $row; // Agregar cada árbol al array
    }

    // Cerrar el statement y la conexión
    $stmt->close();
    $conn->close();

    return $trees; // Devolver el array de árboles
}

    
?>
