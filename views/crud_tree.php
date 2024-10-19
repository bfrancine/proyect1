<?php
include('../includes/functions.php');

// Obtiene todos los árboles de la base de datos
$trees = getAllTrees(); 

require('../includes/menu_administrator.html');
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/species.css">


<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="display-4">Árboles</h1>
        <p class="lead">Lista de Árboles</p>
        <hr class="my-4">
    </div><br>

    <!-- Botón para agregar nuevo árbol -->
    <a href="add_tree.php" class="btn btn-primary mb-3">Agregar Nuevo Árbol</a>

    <div class="row">
        <?php if (!empty($trees)): ?>
            <?php foreach ($trees as $tree): ?>
                <div class="col-md-4 col-lg-3 mb-4"> <!-- 3 cards en pantallas grandes, 4 en medianas -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tamaño: <?php echo htmlspecialchars($tree['size']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Especie: <?php echo htmlspecialchars($tree['species']); ?></h6>
                            <p class="card-text">Ubicación: <?php echo htmlspecialchars($tree['location']); ?></p>
                            <p class="card-text">Precio: <?php echo htmlspecialchars($tree['price']); ?></p>
                            <p class="card-text">Estado: <?php echo htmlspecialchars($tree['type_state']); ?></p>
                            <p class="card-text"><small class="text-muted">Última Actualización: <?php echo htmlspecialchars($tree['last_update_date']); ?></small></p>
                            <a href="update_tree.php?id=<?php echo urlencode($tree['id']); ?>" class="btn btn-warning">Actualizar</a>
                            <form action="../logic/delete_tree.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tree['id']); ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este árbol?');">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No se encontraron árboles.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <br>

    <!-- Botón para regresar a la página principal del administrador -->
    <a href="dashboard.php" class="btn btn-secondary mb-3">Regresar</a>
</div>

<?php require('../includes/footer.html'); ?>

