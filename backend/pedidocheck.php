<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$tarjeta = $_POST['tarjeta'];
$caducidad = $_POST['caducidad'];
$codigoseg = $_POST['codigoseg'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$codigopost = $_POST['codigopost'];
$pais = $_POST['pais'];
$telefono = $_POST['telefono'];
$prodcod = $_POST['prodcod'];
$usucod = $_SESSION['usucod'];
$guardar = $_POST['guardar'];

$sql2 = "SELECT * FROM productos WHERE PRODCOD = '$prodcod';";
$resultado2 = mysqli_query($conexion, $sql2);
$productosql = mysqli_fetch_assoc($resultado2);
$prodnom = $productosql['PRODNOM'];
$prodprec = $productosql['PRODPREC'];

$sql = "SELECT * FROM usuarios WHERE USUCOD = '$usucod';";
$resultado = mysqli_query($conexion, $sql);
$correosql = mysqli_fetch_assoc($resultado);
$correo = $correosql['USUCOR'];
$usuariosql = $correosql['USUNOM'];
$usuariosql .= ", " . $correosql['USUAPE'];

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

require '../src/Exception.php';
require '../src/PHPMailer.php';
require '../src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$to = $correo;
$subject = "Factura Compra Infoshop";
$message = "
<html>
<head>
    <meta charset='UTF-8'>
    <style>
    
    .factura {
      table-layout: fixed;
    }
    
    .fact-info > div > h5 {
      font-weight: bold;
    }
    
    .factura > thead {
      border-top: solid 3px #000;
      border-bottom: 3px solid #000;
    }
    
    .factura > thead > tr > th:nth-child(2), .factura > tbod > tr > td:nth-child(2) {
      width: 300px;
    }
    
    .factura > thead > tr > th:nth-child(n+3) {
      text-align: right;
    }
    
    .factura > tbody > tr > td:nth-child(n+3) {
      text-align: right;
    }
    
    .factura > tfoot > tr > th, .factura > tfoot > tr > th:nth-child(n+3) {
      font-size: 24px;
      text-align: right;
    }
    
    .cond {
      border-top: solid 2px #000;
    }

    </style>
</head>
<body>

</div><div id='app' class='col-11'>

    <h2>Factura</h2>

    <div class='row my-3'>
      <div class='col-10'>
        <h1>Infoshop S.L.</h1>
        <p>Avda. Virgen del Carmen 58</p>
        <p>Portal D</p>
        <p>Bajo Izqd.</p>
      </div>
      <div class='col-2'>
        <img src='https://i.imgur.com/OCGIssY.png' />
      </div>
    </div>
  
    <hr />
  
    <div class='row fact-info mt-3'>
      <div class='col-3'>
        <h5>Facturar a</h5>
        <p>" .
           $usuariosql .
       "</p>
      </div>
      <div class='col-3'>
        <h5>Enviar a</h5>
        <p>" .
            $pais . ', ' . $ciudad . ', ' . $direccion .
        "</p>
      </div>
      <div class='col-3'>
        <h5>N° de factura</h5>
        <h5>Fecha</h5>
        <h5>Fecha de vencimiento</h5>
      </div>
      <div class='col-3'>
        <h5>103</h5>
        <p>09/05/2023</p>
        <p>09/05/2023</p>
      </div>
    </div>
  
    <div class='row my-5'>
      <table class='table table-borderless factura'>
        <thead>
          <tr>
            <th>Cant.</th>
            <th>Descripcion</th>
            <th>Precio Unitario</th>
            <th>Importe</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td style='margin-right: 40px;'>" .   $prodnom . "</td>
            <td>" .  $prodprec . ' €' . "</td>
            <td>" .  $prodprec . ' €' . "</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th>Total Factura</th>
            <th>" . ' ' . $prodprec . ' €' . "</th>
          </tr>
        </tfoot>
      </table>
    </div>
  
</div>
</body>
";

$from_email = "infoshopasir.noreply@gmail.com";
$from_name = "Infoshop S.L.";

$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_username = "infoshopasir.noreply@gmail.com";
$smtp_password = "jvmxebntfbovfxth";

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0; // Habilita el depurador SMTP

$newslettersql = "SELECT * FROM usuarios WHERE USUNEWS = 1 AND USUCOD = '$usucod';";
$newsletterquery = mysqli_query($conexion, $newslettersql);
$newsletter = mysqli_num_rows($newsletterquery);



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


if($newsletter > 0){
    $mail->send();
}

} catch (Exception $e) {
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
}

$comprobacion = "SELECT * FROM datos WHERE USUCOD = '$usucod';";
$comprobacionsql = mysqli_query($conexion, $comprobacion);
// Consulta la base de datos para verificar las credenciales

if($guardar == "true"){
    if(mysqli_num_rows($comprobacionsql) < 3){
      $insertardatos = "INSERT INTO datos (USUCOD, DATOSNOM, DATOSAPE, DATOSTAR, DATOSCAD, DATOSCODSEG, DATOSCIU, DATOSDIR, DATOSCP, DATOSPAIS, DATOSTEL) VALUES ('$usucod', '$nombre', '$apellidos', '$tarjeta', '$caducidad', '$codigoseg', '$ciudad', '$direccion', '$codigopost', '$pais', '$telefono');";
      $resultadodatos = mysqli_query($conexion, $insertardatos);
      $insertarpedido = "INSERT INTO pedidos (PEDCOD, PEDFECCOMP, PEDFECDEV, USUCOD, PRODCOD, PEDEST, PEDTAR, PEDCAD, PEDCODSEG, PEDCIU, PEDDIR, PEDCP, PEDPAIS, PEDTEL) SELECT (SELECT MAX(PEDCOD) + 1 FROM pedidos), NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), '$usucod', '$prodcod', 'En envío', '$tarjeta', '$caducidad', '$codigoseg', '$ciudad', '$direccion', '$codigopost', '$pais', '$telefono';";
      $resultadopedido = mysqli_query($conexion, $insertarpedido);
      $updateproducto = "UPDATE productos SET PRODINV = PRODINV + 1 WHERE PRODCOD = '$prodcod';";
      $resultadoupdate = mysqli_query($conexion, $updateproducto);
    }else{
        echo "error1";
    }
}else{
  $insertarpedido = "INSERT INTO pedidos (PEDCOD, PEDFECCOMP, PEDFECDEV, USUCOD, PRODCOD, PEDEST, PEDTAR, PEDCAD, PEDCODSEG, PEDCIU, PEDDIR, PEDCP, PEDPAIS, PEDTEL) SELECT (SELECT MAX(PEDCOD) + 1 FROM pedidos), NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), '$usucod', '$prodcod', 'En envío', '$tarjeta', '$caducidad', '$codigoseg', '$ciudad', '$direccion', '$codigopost', '$pais', '$telefono';";
$resultadopedido = mysqli_query($conexion, $insertarpedido);
$updateproducto = "UPDATE productos SET PRODINV = PRODINV + 1 WHERE PRODCOD = '$prodcod';";
$resultadoupdate = mysqli_query($conexion, $updateproducto);
}


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if($guardar == "true"){
  if(isset($resultadopedido)){
if ($resultadopedido && mysqli_num_rows($comprobacionsql) < 3) {
  // Autenticación exitosa
  header("Content-Type: text/plain");
  echo "success";
}
}else{
  if(mysqli_num_rows($comprobacionsql) < 3){
    header("Content-Type: text/plain");
   echo "success";
  }
}
}else{
  if(isset($resultadopedido)){
  if($resultadopedido){
    header("Content-Type: text/plain");
   echo "success";
  }
}else{
  header("Content-Type: text/plain");
   echo "error1";
}
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>