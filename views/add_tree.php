<?php
include('../includes/functions.php'); // Incluimos las funciones
$species = getSpecies(); // Obtenemos las especies
$treeStates = getTreeStates(); // Obtenemos los estados
// var_dump($species);
// var_dump($treeStates);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/updateSpecies.css"> <!-- Usar el mismo CSS -->
    <title>Add New Tree</title>
</head>
<body>
    <div class="container">
        <h1>Add New Tree</h1>
        <form action="../logic/add_tree.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" id="size" name="size" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="species">Species:</label>
                <select id="species" class="form-control" name="species" required>
                    <?php
                    // Rellena el select de especies
                    foreach($species as $specie) {
                        echo "<option value=\"{$specie['id']}\">{$specie['commercial_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="photo_path">Tree Photo:</label>
                <input type="file" class="form-control" name="photo_path" id="photo_path" accept="image/png, image/jpeg" multiple="true" required>
            </div>
            <div class="form-group">
                <label for="tree_state">Tree Status:</label>
                <select id="tree_state" class="form-control" name="tree_state" required>
                    <?php
                    // Rellenar el select de estados de los árboles
                    foreach($treeStates as $state) {
                        echo "<option value=\"{$state['id']}\">{$state['type_state']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Tree</button>
        </form>
    </div>
</body>
</html>
