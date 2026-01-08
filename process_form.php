<?php
// Habilitar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar el autoload de Composer
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanear los datos del formulario
    $name         = strip_tags(trim($_POST["customerName"]));
    $email        = filter_var(trim($_POST["customerEmail"]), FILTER_SANITIZE_EMAIL);
    $phone        = strip_tags(trim($_POST["customerPhone"]));
    $address      = strip_tags(trim($_POST["customerAddress"]));
    $orderDetails = strip_tags(trim($_POST["orderDetails"]));

    // Validar que los campos requeridos no estén vacíos
    if (empty($name) || empty($email) || empty($orderDetails)) {
        echo "Por favor, complete todos los campos obligatorios.";
        exit;
    }

    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Activar la depuración SMTP (nivel 2 muestra información básica)
        $mail->SMTPDebug = 0;
        
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ilusionplanetcr@gmail.com'; // Tu dirección de Gmail
        $mail->Password   = 'hnjb kctn pofz nmtu'; // Tu contraseña o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configurar el correo:
        // Para evitar problemas de autenticación, se utiliza el mismo correo autenticado como remitente.
        $mail->setFrom('ilusionplanetcr@gmail.com', 'Illusion Planet');
        $mail->addAddress('ilusionplanetcr@gmail.com', 'Illusion Planet');
        // El "Reply-To" es el correo del usuario que llenó el formulario, para que puedas responderle.
        $mail->addReplyTo($email, $name);

        // Contenido del correo
        $mail->isHTML(false); // Enviar en texto plano
        $mail->Subject = 'Nuevo Pedido - Illusion Planet';
        $mail->Body    = "Nombre: $name\nCorreo Electrónico: $email\nTeléfono: $phone\nDirección de Envío: $address\n\nDetalles del Pedido:\n$orderDetails\n";

        // Enviar el correo
        $mail->send();
        echo "¡Pedido enviado correctamente! Gracias por confiar en Illusion Planet.";
    } catch (Exception $e) {
        echo "Hubo un error al enviar el pedido. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Método de solicitud no válido.";
}
