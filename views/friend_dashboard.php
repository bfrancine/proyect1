<?php
session_start();
include('../includes/functions.php');

$defaultImage = "../img/image.png";
$uploadPath = "../uploads/";
$imagePath = "";

// Verifica si se ha pasado un ID de amigo en la URL, si no, usa el ID de la sesión
if (isset($_GET['friend_id'])) {
    $friend_id = htmlspecialchars($_GET['friend_id']);
} elseif (isset($_SESSION['friend_id'])) {
    $friend_id = $_SESSION['friend_id'];
} else {
    // Si no hay ID de amigo en la URL ni en la sesión, redirige o muestra un mensaje de error
    echo "<p>Friend ID not provided. Please log in again.</p>";
    exit; // Termina la ejecución si no hay ID
}

// Obtener información del amigo utilizando su ID
$friend = getFriendById($friend_id); 

if ($friend !== null) {
    
    // Obtiene todos los árboles en estado "Disponible" de la base de datos
    $trees = getAvailableTrees(); 

    require('../includes/menu_friend.html'); // Incluir el menú de amigos

    echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
    echo '<link rel="stylesheet" href="../css/species.css">';

    echo '<div class="container-fluid">';
    echo '<div class="jumbotron">';
    echo "<h1>Welcome, " . htmlspecialchars($friend['first_name']) . "</h1>"; // bienvenida con el nombre del amigo
    //echo '<h1 class="display-4">Available Trees</h1>';
    echo '<p class="lead">List of Available Trees that you can buy</p>';
    echo '<hr class="my-4">';
    echo '</div><br>';

    echo '<div class="row">';
    if (!empty($trees)) {
        foreach ($trees as $tree) {
            echo '<div class="col-md-4 col-lg-3 mb-4">'; // Tamaño de las tarjetas
            echo '<div class="card">';
            
            // Determina la ruta de la imagen
            $imagePath = !empty($tree['photo_path']) ? $uploadPath . $tree['photo_path'] : $defaultImage;
            
            // Verificar si la imagen existe
            if (!file_exists($imagePath)) {
                $imagePath = $defaultImage; // Usa la imagen por defecto si no existe
            }

            echo '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top" alt="Tree Photo" style="height: 200px; object-fit: cover;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Size in meters: ' . htmlspecialchars($tree['size']) . '</h5>';
            echo '<h6 class="card-subtitle mb-2 text-muted">Specie: ' . htmlspecialchars($tree['commercial_name']) . '</h6>';
            echo '<p class="card-text">Location: ' . htmlspecialchars($tree['location']) . '</p>';
            echo '<p class="card-text">Price: $ ' . htmlspecialchars($tree['price']) . '</p>';
            echo '<p class="card-text">State: ' . htmlspecialchars($tree['type_state']) . '</p>';
            echo '<p class="card-text"><small class="text-muted">Last Update: ' . htmlspecialchars($tree['last_update_date']) . '</small></p>';
            echo '<a href="purchase_form.php?id=' . urlencode($tree['id']) . '" class="btn btn-warning">BUY</a>';
            echo '</div></div></div>'; // Cierre de tarjeta y columna
        }
    } else {
        echo '<div class="col-12">';
        echo '<div class="alert alert-warning" role="alert">No available trees found.</div>';
        echo '</div>';
    }
    echo '</div>'; // Cierre de fila
    echo '<br></div>'; // Cierre de contenedor

    require('../includes/footer.html'); // Incluir el pie de página

} else {
    echo "<p>Friend not found.</p>";
}
?>

