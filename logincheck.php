<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];


// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Escapa los valores para prevenir ataques de inyección SQL
$correo = mysqli_real_escape_string($conexion, $correo);
$contraseña = mysqli_real_escape_string($conexion, $contraseña);

// Consulta la base de datos para verificar las credenciales
$check = "SELECT * FROM usuarios WHERE USUCOR = '$correo'";
$resultado = mysqli_query($conexion, $check);

if (mysqli_num_rows($resultado) > 0) {
  $fila = mysqli_fetch_assoc($resultado);
  $contraseñaAlmacenada = $fila['USUCONT'];

  // Verifica si la contraseña ingresada coincide con la contraseña almacenada
  if (password_verify($contraseña, $contraseñaAlmacenada)) {
    // Autenticación exitosa
    header("Content-Type: text/plain");
    echo 'success';
  } else {
    // Autenticación incorrecta
    header("Content-Type: text/plain");
    echo 'error';
  }
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo 'error';
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>