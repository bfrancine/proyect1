<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Amigos</title>
</head>
<body>
    <h1>Lista de Amigos</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Número de Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Comienza la sección para incluir amigos -->
            <?php
            // Incluir el archivo que obtiene los amigos
            include('../includes/functions.php');

            // Llamar a la función para obtener los amigos
            $friends = getAllFriends(); // Llamada a la función

            if (!empty($friends)): ?>
                <?php foreach ($friends as $friend): ?>
                    <tr>
                     
                        <td><?php echo htmlspecialchars($friend['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($friend['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($friend['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($friend['email']); ?></td>
                        <td><?php echo htmlspecialchars($friend['address']); ?></td>
                        <td>
                            <a href="view_trees.php?friend_id=<?php echo htmlspecialchars($friend['id']); ?>">Ver Árboles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay amigos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
