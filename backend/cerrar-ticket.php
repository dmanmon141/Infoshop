<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$ticketid = $_POST['ticketidcerrarticket'];
unset($_SESSION['ticketid']);
$_SESSION['ticketid'] = $ticketid;

if(isset($_POST['direccion'])){
$redireccion = $_POST['direccion'];
}

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales


$eliminar = "UPDATE tickets SET TICKEST = 'Cerrado' WHERE TICKID = '$ticketid';";
$resultado = mysqli_query($conexion, $eliminar);


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if ($resultado) {
if($redireccion){
    sleep(1);
    header("Location: $redireccion");
}else{
  // Autenticación exitosa
  header("Location: ../ticket");
}
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "duplicado";
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>