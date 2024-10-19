<?php
include('../includes/functions.php');

// Obtén todas las especies de la base de datos
$species = getAllSpecies(); 

require('../includes/menu_administrator.html');
?>
<link rel="stylesheet" href="../css/species.css"> 

<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Species</h1>
        <p class="lead">List of Species</p>
        <hr class="my-4">
    </div><br>

    <!-- Botón para agregar nueva especie -->
    <a href="add_specie.html" class="btn btn-primary mb-3">Add New Species</a>

    <table class="table">
        <thead>
            <tr>
                <th>Commercial Name</th>
                <th>Scientific Name</th>
                <th>Action</th> <!-- Columna para acciones como editar o eliminar -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($species)): ?>
                <?php foreach ($species as $specie): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($specie['commercial_name']); ?></td>
                        <td><?php echo htmlspecialchars($specie['scientific_name']); ?></td>
                        <td>
                            <!-- Botón de editar -->
                            <a href="update_species.php?id=<?php echo urlencode($specie['id']); ?>" class="btn btn-warning">Update</a>

                            <!-- Formulario para eliminar la especie -->
                            <form action="../logic/delete_species.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($specie['id']); ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this species?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No species found.</td> <!--  colspan en 3 para que coincida con las columnas -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>

      <!-- Botón para regresar a la pagina principal del admi -->
      <a href="dashboard.php" class="btn btn-secondary mb-3">Go Back</a>

</div>

<?php require('../includes/footer.html'); ?>
