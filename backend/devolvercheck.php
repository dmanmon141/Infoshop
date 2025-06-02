<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$razon = $_POST['razon'];
$detalles = $_POST['detalles'];
$pedcod = $_POST['pedcod'];


// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales
$pedidosql = "SELECT * FROM pedidos WHERE PEDCOD = '$pedcod'";
$pedidoquery = mysqli_query($conexion, $pedidosql);
$pedidoarray = mysqli_fetch_assoc($pedidoquery);
$tarjeta = $pedidoarray['PEDTAR'];

$notificacionsql = "INSERT INTO paneladmin (ADMCOD, ADMCONT, NOTCOD) SELECT (SELECT MAX(ADMCOD) +1 FROM paneladmin), '$tarjeta', 1;";
$notificacionquery = mysqli_query($conexion, $notificacionsql);

$insertar = "INSERT INTO devoluciones (DEVCOD, DEVRAZ, DEVDET, PEDCOD) SELECT (SELECT MAX(DEVCOD) +1 FROM devoluciones), '$razon', '$detalles', '$pedcod';";
$resultado = mysqli_query($conexion, $insertar);
$update = "UPDATE pedidos SET PEDEST = 'Devuelto' WHERE PEDCOD = '$pedcod'";
$resultadoupdate = mysqli_query($conexion, $update);


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if ($resultado && $resultadoupdate) {
  // Autenticación exitosa
  Header("Location: historial");
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "error";
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>