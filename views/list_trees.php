<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Árboles</title>
    <link rel="stylesheet" href="../styles.css"> 
</head>
<body>
    <h1>Lista de Árboles</h1>
    <table>
        <thead>
            <tr>
                <th>Tamaño</th>
                <th>Especie</th>
                <th>Ubicación</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Última Actualización</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Comienza la sección para incluir árboles -->
            <?php
            // Incluir el archivo que obtiene los árboles
            include('../includes/functions.php');

            // Llama a la función para obtener los árboles
            $trees = getAllTrees(); // Llamada a la función

            if (!empty($trees)): ?>
                <?php foreach ($trees as $tree): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tree['size']); ?></td>
                        <td><?php echo htmlspecialchars($tree['species']); ?></td>
                        <td><?php echo htmlspecialchars($tree['location']); ?></td>
                        <td><?php echo htmlspecialchars($tree['price']); ?></td>
                        <td><?php echo htmlspecialchars($tree['type_state']); ?></td>
                        <td><?php echo htmlspecialchars($tree['last_update_date']); ?></td>
                        <td>
                            <a href="edit_tree.php?tree_id=<?php echo htmlspecialchars($tree['id']); ?>">Editar</a>
                            <a href="delete_tree.php?tree_id=<?php echo htmlspecialchars($tree['id']); ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay árboles registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
