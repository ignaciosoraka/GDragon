<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.html");
    exit;
}

// Clave secreta de reCAPTCHA
$secretkey = "6LeMnysqAAAAADb0D28_vPhTyI9MWAGGI_MPZHgK";

// Captura la respuesta del captcha y la IP del usuario
$captcha = $_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'];

// Validación de Captcha
$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
$atributos = json_decode($respuesta, true);

// Comprueba si la respuesta del captcha es válida
if (!$atributos['success']) {
    echo "Verificación de CAPTCHA fallida. Por favor, intenta de nuevo.";
    exit;
}

// Envios
$nombre = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$telefono = htmlspecialchars(trim($_POST['phone']));
$mensaje = htmlspecialchars(trim($_POST['message']));

if (empty(trim($nombre))) $nombre = 'Anónimo';

// Construcción del mensaje para WhatsApp
$whatsappMessage = "Hola, soy $nombre.\n";
$whatsappMessage .= "Email: $email\n";
$whatsappMessage .= "Teléfono: $telefono\n";
$whatsappMessage .= "Mensaje: $mensaje";

// Codificar el mensaje para la URL de WhatsApp
$whatsappMessage = urlencode($whatsappMessage);

// Número de teléfono de WhatsApp (formato internacional para Argentina)
$whatsappNumber = "5493458433560";

// Redirigir al usuario al enlace de WhatsApp
header("Location: https://wa.me/$whatsappNumber?text=$whatsappMessage");
exit;
?>
