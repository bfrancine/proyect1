<?php
$defaultImage = "../img/image.png";
$uploadPath = "../uploads/";
$imagePath = "";
include('../includes/functions.php');

if (isset($_GET['friend_id'])) {
    $friend_id = htmlspecialchars($_GET['friend_id']);
    $friend = getFriendById($friend_id);
    $trees = getTreesByFriendId($friend_id);

    if ($friend !== null):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profile of <?php echo htmlspecialchars($friend['first_name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/species.css"> 
</head>
<body>
    <div class="container-fluid">
        <div class="jumbotron">
            <h1 class="display-4">Profile of <?php echo htmlspecialchars($friend['first_name'] . ' ' . $friend['last_name']); ?></h1>
            <p class="lead">Registered trees:</p>
            <hr class="my-4">
        </div>

        <div class="row">
            <?php if (!empty($trees)): ?>
                <?php foreach ($trees as $tree): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card">
                            <?php 
                            // Construir la ruta de la imagen
                            $imagePath = !empty($tree['photo_path']) ? $uploadPath . $tree['photo_path'] : $defaultImage;

                            // Verificar si la imagen existe
                            if (!file_exists($imagePath)) {
                                $imagePath = $defaultImage; // Usa la imagen por defecto si no existe
                            }
                            ?>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" class="card-img-top" alt="Tree Photo" style="height: 200px; object-fit: cover;">
                                
                            <div class="card-body">
                                <h5 class="card-title">Specie: <?php echo htmlspecialchars($tree['species']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Size: <?php echo htmlspecialchars($tree['size']); ?></h6>
                                <p class="card-text">Location: <?php echo htmlspecialchars($tree['location']); ?></p>
                                <a href="update_tree.php?id=<?php echo urlencode($tree['id']); ?>" class="btn btn-warning">Update</a>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                    There are no trees registered for this friend.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <a href="list_friends.php" class="btn btn-secondary mb-3">Go Back</a>
    </div>
</body>
</html>
<?php
    else:
        echo "<p>Friend not found.</p>";
    endif;
} else {
    echo "<p>Friend ID not provided.</p>";
}
?>


