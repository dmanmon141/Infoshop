<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario

$usucod = $_SESSION['usucod'];

$tarjetaoriginal = $_POST['tarjetaoriginal'];




// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales



$insertar = "DELETE FROM datos WHERE USUCOD = '$usucod' AND DATOSTAR = '$tarjetaoriginal'";
$resultado = mysqli_query($conexion, $insertar);


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