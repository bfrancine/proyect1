<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tree</title>
    <link rel="stylesheet" href="../css/updateSpecies.css"> <!-- Archivo CSS para el diseño -->
</head>

<body>
    <div class="container">
        <?php
        include '../includes/functions.php';
        
        // Verifica si se ha enviado el ID del árbol por la URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Función para obtener la información del árbol por ID
            $tree = getTreeById($id); 
        } else {
            echo "No tree selected.";
            exit();
        }
        ?>

        <!-- Formulario para actualizar la información del árbol -->
        <form action="../logic/update_tree.php" method="post" enctype="multipart/form-data">
            <h1>Update Tree</h1>

            <!-- Campo oculto con el ID de árbol -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <br>
            <!-- Tamaño del árbol -->
            <label for="size">Size</label>
            <input type="text" name="size" value="<?php echo htmlspecialchars($tree['size']); ?>" required>
            <br>
            <!-- ID de la especie -->
            <label for="species_id">Species</label>
            <select name="species_id" required>
                <?php
                // Obtener todas las especies para mostrarlas en el dropdown
                $speciesList = getAllSpecies();
                foreach ($speciesList as $species) {
                    echo "<option value=\"" . htmlspecialchars($species['id']) . "\"";
                    if ($tree['species_id'] == $species['id']) {
                        echo " selected";
                    }
                    echo ">" . htmlspecialchars($species['commercial_name']) . "</option>";
                }
                ?>
            </select>
            <br>
            <!-- Ubicación del árbol -->
            <label for="location">Location</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($tree['location']); ?>" required>
            <br>
            <!-- Precio del árbol -->
            <label for="price">Price</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($tree['price']); ?>" required>
            <br>
            <?php if (!empty($tree['photo_path'])): ?>
                <!-- Si el estado del árbol es vendido o inactivo, aplica los estilos de imagen apagada directamente -->
                <img src="../uploads/<?php echo htmlspecialchars($tree['photo_path']); ?>" alt="Tree Photo" 
                    style="height: 200px; object-fit: cover; 
                    <?php echo ($tree['state_tree_id'] == 2) ? 'filter: grayscale(100%); opacity: 0.5;' : ''; ?>">
            <?php endif; ?>
            <br>
            <!-- Estado del árbol -->
            <label for="state_tree_id">State</label>
            <select name="state_tree_id" required>
                <?php
                // Obtener todos los estados del árbol para mostrarlos en el dropdown
                $stateList = getTreeStates();
                foreach ($stateList as $state) {
                    echo "<option value=\"" . htmlspecialchars($state['id']) . "\"";
                    if ($tree['state_tree_id'] == $state['id']) {
                        echo " selected";
                    }
                    echo ">" . htmlspecialchars($state['type_state']) . "</option>";
                }
                ?>
            </select>
            <br>
            <br>
            <!-- Botón para enviar el formulario -->
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

