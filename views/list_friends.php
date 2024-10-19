<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Amigos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/list_friends.css"> 
</head>
<body>
    <div class="container"> <!-- Contenedor principal -->
        <h1>Friends list</h1> 
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>phone number</th>
                    <th>address</th>
                    <th>Direction</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!--  sección para incluir amigos -->
                <?php
                include('../includes/functions.php');
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
                                <a href="profile.php?friend_id=<?php echo htmlspecialchars($friend['id']); ?>">See Trees</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">There are no registered friends.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Go Back</a>
    </div>
   
</body>
</html>
