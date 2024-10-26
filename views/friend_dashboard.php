<?php
include('../includes/functions.php');
$defaultImage = "../img/image.png";
$uploadPath = "../uploads/";
$imagePath = "";

// Obtener todos los árboles en estado "Disponible" de la base de datos
$trees = getAvailableTrees(); 

require('../includes/menu_friend.html');

// Verificar si se ha enviado el ID del árbol por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Función para obtener la información del árbol por ID
    $tree = getTreeById($id); 
}

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/species.css">


<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Available Trees</h1>
        <p class="lead">List of Available Trees</p>
        <hr class="my-4">
    </div><br>

    <div class="row">
        <?php if (!empty($trees)): ?>
            <?php foreach ($trees as $tree): ?>
                <div class="col-md-4 col-lg-3 mb-4"> <!-- Determina el tamaño 3 cards en pantallas grandes, 4 en medianas -->
                    <div class="card">
                        <!-- Muestra la imagen del árbol -->
                        <?php 
                        // Determina la ruta de la imagen
                            $imagePath = !empty($tree['photo_path']) ? $uploadPath . $tree['photo_path'] : $defaultImage;
                        // Nos ayuda a comprobar si la imagen del árbol existe en la carpeta de uploads
                            if (!file_exists($imagePath)) {
                                $imagePath = $defaultImage; // Si no existe usa la imagen por defecto
                            }
                        ?>
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" class="card-img-top" alt="Tree Photo" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Size in meters: <?php echo htmlspecialchars($tree['size']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Specie: <?php echo htmlspecialchars($tree['commercial_name']); ?></h6>
                            <p class="card-text">Location: <?php echo htmlspecialchars($tree['location']); ?></p>
                            <p class="card-text">Price: $ <?php echo htmlspecialchars($tree['price']); ?></p>
                            <p class="card-text">State: <?php echo htmlspecialchars($tree['type_state']); ?></p>
                            <p class="card-text"><small class="text-muted">Last Update: <?php echo htmlspecialchars($tree['last_update_date']); ?></small></p>
                            <a href="purchase_form.php?id=<?php echo urlencode($tree['id']); ?>" class="btn btn-warning">BUY</a>

                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No available trees found.
                </div>
            </div>
        <?php endif; ?>
    </div>
    <br>
   
</div>
<?php require('../includes/footer.html'); ?>
