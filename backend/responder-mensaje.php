<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$contenido = $_POST['respuesta-contenido'];
$ticketid = $_POST['ticketidmensaje'];
$usucod = $_SESSION['usucod'];
unset($_SESSION['ticketid']);
$_SESSION['ticketid'] = $ticketid;



// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales


$insertar = "INSERT INTO mensajes (MENID, MENCONT, MENFEC, USUCOD, TICKID) SELECT (SELECT MAX(MENID) +1 FROM mensajes), '$contenido', NOW(), '$usucod', '$ticketid';";
$resultado = mysqli_query($conexion, $insertar);


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if ($resultado) {
  // Autenticación exitosa
  header("Location: ticket");
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "duplicado";
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>