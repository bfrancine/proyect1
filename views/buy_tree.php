<?php
include('../includes/db_connection.php');
include('../includes/functions.php');
session_start();

// Verificar si el usuario está logueado y es amigo
if (!isset($_SESSION['friend_logged_in']) || !$_SESSION['friend_logged_in']) {
    header('Location: ../index.php');
    exit();
}

// Asegurarse de que el ID del amigo está en la sesión
if (!isset($_SESSION['friend_id'])) {
    // Redirigir si no hay un ID de amigo válido en la sesión
    header("Location: friend_dashboard.php?error=friend_not_logged_in");
    exit();
}

$friend_id = $_SESSION['friend_id']; // Obtener el ID del amigo de la sesión

// Verificar que se haya pasado un ID de árbol a través del formulario
if (isset($_POST['tree_id'])) {
    $treeId = $_POST['tree_id'];

    // Llamar a la función de compra
    if (purchaseTree($treeId, $friend_id)) { // Asegúrate de pasar el friend_id aquí
        // Redirigir a la página de dashboard con un mensaje de éxito
        header("Location: friend_dashboard.php?success=tree_bought");
        exit();
    } else {
        // Redirigir con un mensaje de error si algo salió mal
        header("Location: friend_dashboard.php?error=buy_failed");
        exit();
    }
} else {
    // Redirigir si no hay un ID válido
    header("Location: friend_dashboard.php?error=invalid_tree");
    exit();
}

