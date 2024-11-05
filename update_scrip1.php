<?php
// Incluir el archivo de conexión a la base de datos
require_once ('includes/db_connection.php');

// Obtener la fecha de hace un mes
$oneMonthAgo = date('Y-m-d', strtotime('-1 month'));

// Consulta para obtener árboles que no han sido actualizados en el último mes
$sql = "SELECT id, name FROM arboles WHERE last_update < ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $oneMonthAgo);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Construir el mensaje del correo
    $message = "Los siguientes árboles no han sido actualizados desde hace más de 1 mes:\n";
    while ($row = $result->fetch_assoc()) {
        $message .= "- " . $row['name'] . "\n";
    }

    // Configuración del correo
    $to = 'alondra.rm790@gmail.com'; // Reemplaza con el correo del administrador
    $subject = 'Aviso: Árboles desactualizados';
    $headers = "From: bfrancini1@gmail.com\r\n" .
               "Reply-To: no-reply@example.com\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        echo "Correo enviado correctamente al administrador.";
    } else {
        echo "Error al enviar el correo.";
    }
} else {
    echo "No hay árboles desactualizados.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
