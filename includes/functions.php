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
        $result = $conn->query($query); // Ejecuta la consulta
    
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

    //Funcion para obtener todos los árboles
    function getAllTrees() {
        include('../includes/db_connection.php'); // Conexión a la base de datos
        $trees = [];
        
        // Consulta SQL con JOIN para obtener los árboles
        $sql = "SELECT t.id, t.size, s.commercial_name AS species, t.location, t.price, st.type_state, t.photo_path, t.last_update_date 
                FROM tree t 
                JOIN species s ON t.species_id = s.id 
                JOIN state_tree st ON t.state_tree_id = st.id";
    
        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $trees[] = $row; // Agrega cada árbol al array
            }
            $result->free();
        } else {
            echo "Error: " . $conn->error; 
        }
        return $trees; // Devuelve el array con los árboles
    }

    function getTreeById($id) {
        include('../includes/db_connection.php');
        $sql = "SELECT t.id, t.size, t.location, t.price, t.photo_path, t.species_id, t.state_tree_id, s.commercial_name
                FROM tree t
                JOIN species s ON t.species_id = s.id
                WHERE t.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
    
    
    
    // Obtener árboles por ID de amigo
function getTreesByFriendId($friend_id) {
    include('../includes/db_connection.php'); // Conexión a la base de datos
    $stmt = $conn->prepare("
        SELECT t.id, t.size, s.commercial_name AS species, t.location, t.photo_path 
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
function getAvailableTrees(){
    // Incluir la conexión a la base de datos
    include('../includes/db_connection.php'); 

    // Consulta para obtener los árboles que están en estado "Disponible"
    $sql = "SELECT tree.*, species.commercial_name, state_tree.type_state 
            FROM tree 
            JOIN species ON tree.species_id = species.id
            JOIN state_tree ON tree.state_tree_id = state_tree.id
            WHERE state_tree.type_state = 'Disponible'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Inicializar un array para almacenar los árboles
    $availableTrees = [];

    // Verificar si hay resultados y almacenarlos en el array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $availableTrees[] = $row;
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Devolver los árboles disponibles
    return $availableTrees;
}
function purchaseTree($treeId, $friend_id) {
    include('../includes/db_connection.php'); // Conexión a la base de datos

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Cambiar el estado del árbol a 'Vendido'
        $updateTreeSql = "UPDATE tree SET state_tree_id = (SELECT id FROM state_tree WHERE type_state = 'Vendido') WHERE id = ?";
        $stmt = $conn->prepare($updateTreeSql);
        $stmt->bind_param("i", $treeId);
        $stmt->execute();

        // Registrar la compra en la tabla `purchase`
        $insertPurchaseSql = "INSERT INTO purchase (friend_id, purchase_date, total_amount) VALUES (?, NOW(), (SELECT price FROM tree WHERE id = ?))";
        $stmt = $conn->prepare($insertPurchaseSql);
        $stmt->bind_param("ii", $friend_id, $treeId);
        $stmt->execute();

        // Obtener el ID de la compra recién creada
        $purchaseId = $conn->insert_id;

        // Registrar la relación entre la compra y el árbol en la tabla `purchase_tree`
        $insertPurchaseTreeSql = "INSERT INTO purchase_tree (purchase_id, tree_id, price_at_purchase) VALUES (?, ?, (SELECT price FROM tree WHERE id = ?))";
        $stmt = $conn->prepare($insertPurchaseTreeSql);
        $stmt->bind_param("iii", $purchaseId, $treeId, $treeId);
        $stmt->execute();

        // relacionar el árbol con el amigo en `tree_friend`
        $insertTreeFriendSql = "INSERT INTO tree_friend (friend_id, tree_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertTreeFriendSql);
        $stmt->bind_param("ii", $friend_id, $treeId);
        $stmt->execute();
        
        // Confirmar la transacción
        $conn->commit();
        return true; // Compra exitosa
    } catch (Exception $e) {
        // En caso de error, deshacer la transacción
        $conn->rollback();
        return false; // Fallo en la compra
    }
}


?>
