<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();


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
$guardar = $_POST['guardar'];

$usucod = $_SESSION['usucod'];

$sql = "SELECT * FROM usuarios WHERE USUCOD = '$usucod';";


$correosql = "SELECT * FROM usuarios WHERE USUCOD = '$usucod';";
$correoarray = mysqli_query($conexion, $correosql);
$correofetch = mysqli_fetch_assoc($correoarray);
$correo = $correofetch['USUCOR'];
$usuariosql = $correofetch['USUNOM'];
$usuariosql .= ", " . $correofetch['USUAPE'];


$productosJson = $_POST['productos'];


$productos = json_decode($productosJson, true);

if ($productos === null && json_last_error() !== JSON_ERROR_NONE) {
  // Ocurrió un error al decodificar el JSON
  echo 'Error al decodificar el JSON: ' . json_last_error_msg();
  // Aquí puedes agregar más lógica para manejar el error
  return;
}


foreach ($productos as $producto) {
    $nombreproducto = $producto['name'];
    $precio = $producto['price'];
    $cantidad = $producto['count'];

    
}
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
        <p>
          " . $usuariosql . "
        </p>
      </div>
      <div class='col-3'>
        <h5>Enviar a</h5>
        <p>
          " . $pais . ', ' . $ciudad . ', ' . $direccion . "
        </p>
      </div>
      <div class='col-3'>
        <h5>N° de factura</h5>
        <h5>Fecha</h5>
        <h5>Fecha de vencimiento</h5>
      </div>
      <div class='col-3'>
        <h5>103</h5>
        <p>09/05/2019</p>
        <p>09/05/2019</p>
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
        <tbody>";

        $total = 0;
        foreach ($productos as $producto) {
            $precio = $producto['price']; // Obtener el precio del producto actual
                        $cantidad = $producto['count']; // Obtener la cantidad del producto actual
                        $subtotal = $precio * $cantidad; // Calcular el subtotal (precio x cantidad)
                        $total += $subtotal;
         $message .="   
         <tr>
            <td>" . $producto['count'] . "</td>
            <td><p style='margin-right:50px;'>" . $producto['name'] . "</p></td>
            <td>" . $producto['price'] . ' €' . "</td>
            <td>" . $subtotal . ' €' . "</td>
          </tr>";
        }
          
    $message .= " </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th>Total Factura</th>
            <th>" . ' ' . $total . ' €' . "</th>
          </tr>
        </tfoot>
      </table>
    </div>
  
</div>
</body>";


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
      foreach ($productos as $producto) {

        $prodnom = $producto['name'];
      
      $prodcodsql = "SELECT * FROM productos WHERE PRODNOM = '$prodnom';";
      $prodcodarray = mysqli_query($conexion, $prodcodsql);
      $prodcodfetch = mysqli_fetch_assoc($prodcodarray);
      $prodcod = $prodcodfetch['PRODCOD'];
      
      for($i = $cantidad;$i > 0;$i--){
      $insertarpedido = "INSERT INTO pedidos (PEDCOD, PEDFECCOMP, PEDFECDEV, USUCOD, PRODCOD, PEDEST, PEDTAR, PEDCAD, PEDCODSEG, PEDCIU, PEDDIR, PEDCP, PEDPAIS, PEDTEL) SELECT (SELECT MAX(PEDCOD) + 1 FROM pedidos), NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), '$usucod', '$prodcod', 'En envío', '$tarjeta', '$caducidad', '$codigoseg', '$ciudad', '$direccion', '$codigopost', '$pais', '$telefono';";
      $resultadopedido = mysqli_query($conexion, $insertarpedido);
      $updateproducto = "UPDATE productos SET PRODINV = PRODINV + 1 WHERE PRODCOD = '$prodcod';";
      $resultadoupdate = mysqli_query($conexion, $updateproducto);
      }
      }
    }else{
      echo "error1";
    }
    
}else{
  foreach ($productos as $producto) {

    $prodnom = $producto['name'];
  
  $prodcodsql = "SELECT * FROM productos WHERE PRODNOM = '$prodnom';";
  $prodcodarray = mysqli_query($conexion, $prodcodsql);
  $prodcodfetch = mysqli_fetch_assoc($prodcodarray);
  $prodcod = $prodcodfetch['PRODCOD'];
  
  for($i = $cantidad;$i > 0;$i--){
  $insertarpedido = "INSERT INTO pedidos (PEDCOD, PEDFECCOMP, PEDFECDEV, USUCOD, PRODCOD, PEDEST, PEDTAR, PEDCAD, PEDCODSEG, PEDCIU, PEDDIR, PEDCP, PEDPAIS, PEDTEL) SELECT (SELECT MAX(PEDCOD) + 1 FROM pedidos), NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), '$usucod', '$prodcod', 'En envío', '$tarjeta', '$caducidad', '$codigoseg', '$ciudad', '$direccion', '$codigopost', '$pais', '$telefono';";
  $resultadopedido = mysqli_query($conexion, $insertarpedido);
  
  $updateproducto = "UPDATE productos SET PRODINV = PRODINV + 1 WHERE PRODCOD = '$prodcod';";
      $resultadoupdate = mysqli_query($conexion, $updateproducto);
  }
  }
}


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if($guardar == "true"){
  if(isset($resultadopedido)){
if ($resultadopedido && mysqli_num_rows($comprobacionsql) < 3) {
  // Autenticación exitosa
  unset($_SESSION['cartContent']);
  header("Content-Type: text/plain");
  echo "success";
}
}else{
  if(mysqli_num_rows($comprobacionsql) < 3){
    unset($_SESSION['cartContent']);
    header("Content-Type: text/plain");
   echo "success";
  }
}
}else{
  if(isset($resultadopedido)){
  if($resultadopedido){
    unset($_SESSION['cartContent']);
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