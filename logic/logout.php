<?php
// Iniciar la sesión
session_start();

// Verificar si hay una sesión activa
if (isset($_SESSION['user_id'])) {
    // Destruir todas las variables de sesión
    $_SESSION = array();

    // Si se desea destruir completamente la sesión, también hay que eliminar la cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalmente, destruir la sesión
    session_destroy();
}

// Redirigir a la página de inicio o de login
header("Location: ../index.php");
exit();
?>
