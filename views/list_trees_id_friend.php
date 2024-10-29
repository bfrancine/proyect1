<?php
include('../includes/functions.php');

//Variables para incluir las imágenes
$defaultImage = "../img/image.png";
$uploadPath = "../uploads/";

//Bucle if para verificar que obtenga el ID
if (isset($_GET['friend_id']) && is_numeric($_GET['friend_id'])) {
    $friend_id = htmlspecialchars($_GET['friend_id']);
    $friend = getFriendById($friend_id);
    $trees = getTreesByFriendId($friend_id);

    if ($friend !== null):
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tree List for <?php echo htmlspecialchars($friend['first_name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../css/list_trees.css">  -->
</head>
<body>
    <div class="container-fluid"> <!-- contenedor principal -->
        <div class="jumbotron text-center">
            <h1 class="display-4">Tree List for <?php echo htmlspecialchars($friend['first_name'] . ' ' . $friend['last_name']); ?></h1> <!-- Obtiene el nombre y apellido del usuario para mostrarlo -->
            <p class="lead">Registered trees:</p>
            <hr class="my-4">
        </div>
        <div class="row justify-content-center">
            <?php if (!empty($trees)): ?>
                <?php foreach ($trees as $tree): ?>
                    <div class="col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                        <div class="card" style="width: 100%;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Specie: <?php echo htmlspecialchars($tree['species']); ?></h5>
                                <a href="tree_details.php?id=<?php echo urlencode($tree['id']); ?>&friend_id=<?php echo urlencode($friend_id); ?>" class="btn btn-info">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        There are no trees registered for this friend.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <a href="friend_dashboard.php" class="btn btn-secondary">Go Back</a>
        </div>
    </div>
</body>
</html>
<?php
    else:
        echo "<p>Friend not found.</p>";
    endif;
} else {
    echo "<p>Friend ID not provided or invalid.</p>";
}
?>


