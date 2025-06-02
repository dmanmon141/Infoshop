<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$contenido = $_POST['contenido'];

$usucod = $_SESSION['usucod'];

$ticketid = uniqid();

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales


$insertar = "INSERT INTO tickets (TICKID, TICKCONT, TICKEST, TICKFEC, USUCOD) VALUES ('$ticketid', '$contenido', 'Abierto', NOW(), '$usucod');";
$resultado = mysqli_query($conexion, $insertar);

$insertar2 = "INSERT INTO paneladmin (ADMCOD, ADMCONT, NOTCOD) SELECT (SELECT MAX(ADMCOD) +1 FROM paneladmin), '$ticketid', 3;";
$resultado2 = mysqli_query($conexion, $insertar2);


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if ($resultado) {
  // Autenticación exitosa
  header("Content-Type: text/plain");
  echo "success";
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "duplicado";
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>