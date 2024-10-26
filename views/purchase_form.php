
<?php
include('../includes/functions.php');
// Define la imagen por defecto y la ruta de subida
$defaultImage = "../img/image.png"; //imagen por defecto
$uploadPath = "../uploads/"; //ruta donde se almacenan las imagenes de los arboles.
$imagePath = "";

// Verifica si se ha enviado el ID del árbol por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Obtiene la información del árbol por ID
    $tree = getTreeById($id); 
} else {
    echo "No tree selected.";
    exit();
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/species.css">

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Confirm Purchase</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($tree)): // Verifica si se ha obtenido información del árbol ?>
                <?php 
                // Configura la imagen del árbol
                $imagePath = !empty($tree['photo_path']) ? $uploadPath . $tree['photo_path'] : $defaultImage;
                if (!file_exists($imagePath)) {
                    $imagePath = $defaultImage;
                }
                ?>
                <img src="<?php echo htmlspecialchars($imagePath); ?>" class="img-fluid mb-3" alt="Tree Photo" style="height: 300px; object-fit: cover;">
                
                <h5>Tree Details</h5>
                <ul class="list-unstyled">
                    <li><strong>Size:</strong> <?php echo htmlspecialchars($tree['size']); ?> meters</li>
                    <li><strong>Species:</strong> <?php echo htmlspecialchars($tree['commercial_name']); ?></li>
                    <li><strong>Location:</strong> <?php echo htmlspecialchars($tree['location']); ?></li>
                    <li><strong>Price:</strong> $<?php echo htmlspecialchars($tree['price']); ?></li>
                </ul>

                <form action="buy_tree.php" method="post">
                    <input type="hidden" name="tree_id" value="<?php echo htmlspecialchars($tree['id']); ?>">

                    <div class="form-group">
                        <label for="buyer_name">Your Name</label>
                        <input type="text" class="form-control" id="buyer_name" name="buyer_name" required>
                    </div>

                    <div class="form-group">
                        <label for="buyer_email">Your Email</label>
                        <input type="email" class="form-control" id="buyer_email" name="buyer_email" required>
                    </div>

                    <button type="submit" class="btn btn-success">Confirm Purchase</button>
                    <a href="friend_dashboard.php" class="btn btn-secondary">Cancel</a>
                </form>
            <?php else: ?>
                <p class="text-danger">Tree information not found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require('../includes/footer.html'); ?>
