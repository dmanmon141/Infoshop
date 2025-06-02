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
$usucod = $_SESSION['usucod'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
if(isset($_POST['contraseña'])){
$contraseña = $_POST['contraseña'];
$contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);
}

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales

$_SESSION['usunom'] = $nombre;

if(isset($_POST['contraseña'])){
$insertar = "UPDATE usuarios SET USUNOM = '$nombre', USUAPE = '$apellidos', USUCOR = '$correo', USUCONT = '$contraseñaEncriptada' WHERE USUCOD = '$usucod';";
$resultado = mysqli_query($conexion, $insertar);
} else{
    $insertar2 = "UPDATE usuarios SET USUNOM = '$nombre', USUAPE = '$apellidos', USUCOR = '$correo' WHERE USUCOD = '$usucod';";
    $resultado2 = mysqli_query($conexion, $insertar2);
}

// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if(isset($_POST['contraseña'])){

if ($resultado) {
  // Autenticación exitosa
  header("Content-Type: text/plain");
  echo "success";
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "duplicado";
}
}else{
    if ($resultado2) {
        // Autenticación exitosa
        header("Content-Type: text/plain");
        echo "success";
      } else {
        // Autenticación incorrecta
        header("Content-Type: text/plain");
        echo "duplicado";
      }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>