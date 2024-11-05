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

// Consulta SQL para verificar los árboles que no han sido actualizados
$sql = "
    SELECT tree.id, species.commercial_name, tree.location, tree.price 
    FROM tree
    JOIN species ON tree.species_id = species.id
    WHERE tree.last_update_date < ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $oneMonthAgo);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Mensaje que se verá en el correo
    $message = "Los siguientes árboles no han sido actualizados desde hace más de 1 mes:\n";
    while ($row = $result->fetch_assoc()) {
        $message .= "- " . $row['commercial_name'] . " (ID: " . $row['id'] . ", Ubicación: " . $row['location'] . ", Precio: " . $row['price'] . ")\n";
    }

    // Configuración de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'alondra.rm790@gmail.com'; // Correo de Gmail
        $mail->Password = 'uvma ohif pkpp imxk'; // Contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('alondra.rm790@gmail.com', 'Nombre del remitente');
        $mail->addAddress('alondra.rm790@gmail.com'); // Correo del administrador1
        $mail->addAddress('bfrancini1@gmail.com'); // Correo del administrador2

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Aviso: Árboles desactualizados';
        $mail->Body = $message;

        // Envia el correo
        $mail->send();
        echo "Correo enviado correctamente a los administradores.";
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
