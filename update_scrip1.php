<?php
// Incluir el archivo de conexión a la base de datos
require_once('includes/db_connection.php');

// Incluir los archivos de PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Obtener la fecha de hace un mes
$oneMonthAgo = date('Y-m-d', strtotime('-1 month'));

// Consulta para obtener árboles que no han sido actualizados en el último mes
$sql = "
    SELECT tree.id, species.commercial_name 
    FROM tree
    JOIN species ON tree.species_id = species.id
    WHERE tree.last_update_date < ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $oneMonthAgo);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Construir el mensaje del correo
    $message = "Los siguientes árboles no han sido actualizados desde hace más de 1 mes:\n";
    while ($row = $result->fetch_assoc()) {
        $message .= "- " . $row['commercial_name'] . " (ID: " . $row['id'] . ")\n";
    }

    // Configuración de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'alondra.rm790@gmail.com'; // Reemplaza con tu correo de Gmail
        $mail->Password = 'uvma ohif pkpp imxk'; // Reemplaza con tu contraseña de Gmail o una contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('alondra.rm790@gmail.com', 'Nombre del remitente');
        $mail->addAddress('alondra.rm790@gmail.com'); // Dirección del administrador

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Aviso: Árboles desactualizados';
        $mail->Body = $message;

        // Enviar el correo
        $mail->send();
        echo "Correo enviado correctamente al administrador.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "No hay árboles desactualizados.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
