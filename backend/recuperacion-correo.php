<?php


$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

$correo = $_POST['correo'];
$usucod = "SELECT USUCOD FROM usuarios WHERE USUCOR = '$correo';";
$usucodsql = mysqli_query($conexion, $usucod);
$usucodsesion = mysqli_fetch_assoc($usucodsql);
$usuariocod = $usucodsesion['USUCOD'];
$sql = "SELECT * FROM usuarios WHERE USUCOR = '$correo'";
$resultado = mysqli_query($conexion, $sql);


require '../src/Exception.php';
require '../src/PHPMailer.php';
require '../src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$to = $correo;
$token = bin2hex(random_bytes(16));
$url = "localhost/restablecer-contraseña?token=" . urlencode($token);
$subject = "Recuperación de contraseña Infoshop";
$message = "
<html>
<head>
    <meta charset='UTF-8'>
</head>
<body>
    <h1>Recuperación de contraseña</h1>
    <p>Estás recibiendo este correo porque has solicitado restablecer tu contraseña de Infoshop. Haz click en el siguiente botón para restablecerla:</p>
    <a href='$url' style='display: inline-block; background-color: purple; color: white; padding: 10px 20px; text-decoration: none;'>Restablecer contraseña</a>
    <p>Si no has solicitado este cambio, puedes simplemente ignorar este correo.</p>
    <div class='contenedor' style='display: flex;background-color: #f1f1f1;width: 600px;'>
    <img src='https://i.imgur.com/fnRODbN.png' style='width:260px;height:210px;margin-top:50px'/>
    <div class='texto'><h1 style='margin-left: 54px;color: black'>INFOSHOP S.L.</h1>
    <ul style='list-style-type: none'>
    <li><h2>Dirección: Avda. Virgen del Carmen 58 Portal D Bajo Izqd</h2></li>
    <li><h2>Teléfono: 956 09 72 35</h2></li>
    <li><h2>Correo electrónico: infoshopasir@gmail.com</h2></li>
    </ul>
    </div>
</body>
</html>
";

$from_email = "infoshopasir.noreply@gmail.com";
$from_name = "Infoshop S.L.";

$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_username = "infoshopasir.noreply@gmail.com";
$smtp_password = "jvmxebntfbovfxth";

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0; // Habilita el depurador SMTP





try {
    $mail->isSMTP();
    $mail->Host = $smtp_host;
    $mail->Port = $smtp_port;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    
    $mail->isHTML(true);
    $mail->setFrom($from_email, $from_name);
    $mail->addAddress($to);
    $mail->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
    $mail->Body = $message;
    $mail->send();


    $insert = "INSERT INTO verificar (VERTOK, VEREXP, USUCOD) VALUES ('$token', DATE_ADD(NOW(), INTERVAL 5 MINUTE), '{$usucodsesion['USUCOD']}');";
    mysqli_query($conexion, $insert);
    echo "success";
} catch (Exception $e) {
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
}

?>