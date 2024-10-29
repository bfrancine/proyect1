<?php
session_start();
include('../includes/functions.php');

// Envío de ID de árbol en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $tree_id = htmlspecialchars($_GET['id']);
    $tree = getTreeById($tree_id); 

    // Verificación de ID del amigo
    if (isset($_GET['friend_id']) && is_numeric($_GET['friend_id'])) {
        $friend_id = htmlspecialchars($_GET['friend_id']);
        $friend = getFriendById($friend_id);
        $trees = getTreesByFriendId($friend_id);

        // Verifica que el árbol y el amigo existan
        if ($tree !== null && $friend !== null):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tree Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/species.css">
</head>
<body>
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <h1 class="display-4">Tree Details</h1>
            <p class="lead">Learn more about your tree!</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <?php 
                // Ruta de la imagen
                $defaultImage = "../img/image.png";
                $uploadPath = "../uploads/";
                $imagePath = !empty($tree['photo_path']) ? $uploadPath . $tree['photo_path'] : $defaultImage;

                // Verificación de imagen existente
                if (!file_exists($imagePath)) {
                    $imagePath = $defaultImage; // Utiliza la imagen por defecto si no existe una
                }
                ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Tree Photo" class="card-img-top" style="height: auto; max-height: 400px; object-fit: cover;">
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Information</h3>
                        <p><strong>Species:</strong> <?php echo htmlspecialchars($tree['commercial_name']); ?></p>
                        <p><strong>Size:</strong> <?php echo htmlspecialchars($tree['size']); ?> m</p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($tree['location']); ?></p>
                        <p><strong>Price:</strong> $ <?php echo htmlspecialchars($tree['price']); ?></p>
                        <a href="list_trees_id_friend.php?friend_id=<?php echo urlencode($friend_id); ?>" class="btn btn-secondary mb-3">Go Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer mt-4">
            <?php require('../includes/footer.html'); // pie de página ?>
        </div>
    </div>
</body>
</html>
<?php
        else:
            echo "<p>Tree or friend not found.</p>";
        endif;
    } else {
        echo "<p>Friend ID not provided or invalid.</p>";
    }
} else {
    echo "<p>Tree ID not provided or invalid.</p>";
}
?>

