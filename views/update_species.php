
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Species</title>
        <link rel="stylesheet" href="../css/updateSpecies.css"> <!-- Archivo CSS para el diseño -->
    
    <body>
        <div class="container">
            <?php
            include '../includes/functions.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $species = getSpecieById($id); // Función para obtener la especie por ID
        }
    ?>
    <form action="../logic/update_species.php" method="post">
        <h1>Update</h1>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="text" name="commercial_name" value="<?php echo htmlspecialchars($species['commercial_name']); ?>">
        <input type="text" name="scientific_name" value="<?php echo htmlspecialchars($species['scientific_name']); ?>">
        <button type="submit">Update</button>
    </form>

        
    </body>
</html>
