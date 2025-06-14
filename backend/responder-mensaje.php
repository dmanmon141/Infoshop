<?php

require '../vendor/autoload.php'; // ← Corregido: faltaba la barra

use WebSocket\Client;

error_reporting(E_ALL);
session_start();

$servidor = "localhost";
$usuario  = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);
mysqli_select_db($conexion, "infoshop");

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtén los valores enviados desde el formulario
$contenido = $_POST['respuesta-contenido'] ?? '';
$ticketid  = $_POST['ticketidmensaje'] ?? '';
$usucod    = $_SESSION['usucod'] ?? '';

if (empty($contenido) || empty($ticketid) || empty($usucod)) {
  http_response_code(400);
  echo "Faltan datos";
  exit;
}

unset($_SESSION['ticketid']);
$_SESSION['ticketid'] = $ticketid;

// Insertar mensaje
$insertar = "INSERT INTO mensajes (MENID, MENCONT, MENFEC, USUCOD, TICKID)
             SELECT IFNULL(MAX(MENID), 0) + 1, '$contenido', NOW(), '$usucod', '$ticketid' FROM mensajes";
$resultado = mysqli_query($conexion, $insertar);

if ($resultado) {
  // Obtener datos del mensaje y usuario
  $querymensaje = mysqli_query($conexion, "SELECT * FROM mensajes ORDER BY MENID DESC LIMIT 1");
  $resultadomensaje = mysqli_fetch_assoc($querymensaje);

  $queryusuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE USUCOD = '$usucod'");
  $resultadousuario = mysqli_fetch_assoc($queryusuario);

  $clase = $resultadousuario['USUADM'] == 1 ? "mensaje-administrador" : "mensaje-usuario";

  $mensaje = [
    "clase"   => $clase,
    "imagen"  => $resultadousuario['USUIMG'],
    "usuario" => $resultadousuario['USUNOM'],
    "hora"    => date("H:i"),
    "texto"   => $contenido,
    "usucod" => $usucod,
    "ticketid" => $ticketid
  ];

  $mensajeJSON = json_encode($mensaje);

  // Enviar al WebSocket
  try {
    $client = new Client("ws://127.0.0.1:8080");
    $client->send($mensajeJSON);
    $client->close();
  } catch (Exception $e) {
    error_log("Error al conectar al WebSocket: " . $e->getMessage());
  }

  http_response_code(200);
  echo "ok";

} else {
  http_response_code(500);
  echo "Error al insertar";
}

mysqli_close($conexion);
