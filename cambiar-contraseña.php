<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario


$contraseña = $_POST['contraseña'];
$token = $_POST['token'];

$contraseñaEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);

// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

$expcheck = "SELECT VERTOK FROM verificar WHERE VEREXP < NOW();";
$expcheckresult = mysqli_query($conexion, $expcheck);

// Consulta la base de datos para verificar las credenciales

if(mysqli_num_rows($expcheckresult) > 0){
    Header("Content-Type: text/plain");
    echo "expirado";
}else{

$buscar = "SELECT USUCOD FROM verificar WHERE VERTOK = '$token';";
$resultadobuscar = mysqli_query($conexion, $buscar);

if($fila = mysqli_fetch_assoc($resultadobuscar)) {
    
    $usucod = $fila['USUCOD'];

    $update = "UPDATE usuarios SET USUCONT = '$contraseñaEncriptada' WHERE USUCOD = '$usucod';";
    $resultado = mysqli_query($conexion, $update);  

    if($resultado){
        $borrar = "DELETE FROM verificar WHERE VERTOK = '$token';";
        $borrarresult = mysqli_query($conexion, $borrar);



// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

 
  // Autenticación exitosa
  header("Content-Type: text/plain");
  echo "success";
} else {
  // Autenticación incorrecta
  $error = mysqli_error($conexion);
  header("Content-Type: text/plain");
  echo $error;
}
}else{
    header("Content-Type: text/plain");
    echo "Usuario inválido";
}
}
// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>