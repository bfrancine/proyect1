<?php
// Incluir las funciones necesarias para la aplicación
include('../includes/functions.php');

// Verificar si se ha proporcionado un ID de amigo a través de la URL
if (isset($_GET['friend_id'])) {
    // Obtener el ID del amigo de la URL y asegurarnos de que sea seguro para usar.
    $friend_id = htmlspecialchars($_GET['friend_id']);
    
    // Obtener la información del amigo utilizando la función definida
    $friend = getFriendById($friend_id); // Función para obtener la información del amigo
    
    // Obtener los árboles asociados al amigo
    $trees = getTreesByFriendId($friend_id); // Función para obtener los árboles del amigo

    // Verificar si se encontró el amigo
    if ($friend !== null):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profile of <?php echo htmlspecialchars($friend['first_name']); ?></title>
    <!-- Enlace a la hoja de estilos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/species.css"> 
</head>
<body>
    <div class="container-fluid">
        <div class="jumbotron">
            <!-- Título del perfil del amigo -->
            <h1 class="display-4">Profile of <?php echo htmlspecialchars($friend['first_name'] . ' ' . $friend['last_name']); ?></h1>
            <p class="lead">Registered trees:</p>
            <hr class="my-4"> <!-- Línea horizontal para separación -->
        </div>

        <div class="row">
            <?php if (!empty($trees)): ?> <!-- Verificar si hay árboles registrados -->
                <?php foreach ($trees as $tree): ?> <!-- Iterar sobre cada árbol o recorrer cada árbol recuperado de la base de datos -->
                    <div class="col-md-4 col-lg-3 mb-4"> <!-- Diseño responsivo: 4 tarjetas en pantallas grandes -->
                        <div class="card"> <!-- Tarjeta de Bootstrap para cada árbol -->
                            <div class="card-body">
                                <h5 class="card-title">Specie: <?php echo htmlspecialchars($tree['species']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Size: <?php echo htmlspecialchars($tree['size']); ?></h6>
                                <p class="card-text">Location: <?php echo htmlspecialchars($tree['location']); ?></p>
                                <!-- Botón para editar el árbol -->
                                <a href="edit_tree.php?tree_id=<?php echo htmlspecialchars($tree['id']); ?>" class="btn btn-warning">Edit</a>
                                <!-- Formulario para eliminar el árbol -->
                                <form action="../logic/delete_tree.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($tree['id']); ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Are you sure you want to delete this tree?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mensaje si no hay árboles registrados -->
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                    There are no trees registered for this friend.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botón para regresar a la lista de amigos -->
        <a href="list_friends.php" class="btn btn-secondary mb-3">Go Back</a>
    </div>
</body>
</html>
<?php
    else:
        // Mensaje si no se encuentra al amigo
        echo "<p>Friend not found.</p>";
    endif;
} else {
    // Mensaje si no se proporciona el ID del amigo
    echo "<p>Friend ID not provided.</p>";
}
?>

