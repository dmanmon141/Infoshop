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
$valoracion = $_POST['valoracion'];
$prodcod = $_POST['prodcod'];
$usucod = $_SESSION['usucod'];


// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Escapa los valores para prevenir ataques de inyección SQL
//$correo = mysqli_real_escape_string($conexion, $correo);
//$contraseña = mysqli_real_escape_string($conexion, $contraseña);

// Consulta la base de datos para verificar las credenciales
$insertar = "INSERT INTO reseñas (RESCOD, RESVAL, RESCONT, RESFEC, USUCOD, PRODCOD) SELECT (SELECT MAX(RESCOD) +1 FROM reseñas), '$valoracion', '$contenido', NOW(), '$usucod', '$prodcod';";
$resultado = mysqli_query($conexion, $insertar);
$editarvaloracion = "UPDATE productos SET PRODVAL = (SELECT AVG(RESVAL) FROM reseñas WHERE reseñas.PRODCOD = productos.PRODCOD AND productos.PRODCOD = '$prodcod') WHERE productos.PRODCOD = '$prodcod';";
$resultadoeditar = mysqli_query($conexion, $editarvaloracion);

error_log('Verifying credentials...');

if ($resultado) {
  // Autenticación exitosa
  header("Content-Type: text/plain");
  echo "success";
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "error";
}




// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>