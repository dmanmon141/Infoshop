<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtenemos los valores enviados desde el formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales


$insertar = "INSERT INTO usuarios (USUCOD, USUNOM, USUAPE, USUIMG, USUCOR, USUCONT, USUADM) SELECT (SELECT MAX(USUCOD) +1 FROM usuarios), '$nombre', '$apellidos', 'img/users/default.jpg','$correo', '$contraseñaEncriptada', 0;";
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