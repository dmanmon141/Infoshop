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
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$codigopost = $_POST['codigopost'];
$pais = $_POST['pais'];
$telefono = $_POST['telefono'];
$tarjetaoriginal = $_POST['tarjetaoriginal'];
$tarjeta = $_POST['tarjeta'];
$caducidad = $_POST['caducidad'];
$codigoseg = $_POST['codigoseg'];



// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales


if($tarjeta <> "************"){
$insertar = "UPDATE datos SET DATOSNOM = '$nombre', DATOSAPE = '$apellidos', DATOSCIU = '$ciudad', DATOSDIR = '$direccion', DATOSCP = '$codigopost', DATOSPAIS = '$pais', DATOSTEL = '$telefono', DATOSTAR = '$tarjeta', DATOSCAD = '$caducidad', DATOSCODSEG = '$codigoseg' WHERE USUCOD = '$usucod' AND DATOSTAR = '$tarjetaoriginal';";
$resultado = mysqli_query($conexion, $insertar);
}else{
    $insertar2 = "UPDATE datos SET DATOSNOM = '$nombre', DATOSAPE = '$apellidos', DATOSCIU = '$ciudad', DATOSDIR = '$direccion', DATOSCP = '$codigopost', DATOSPAIS = '$pais', DATOSTEL = '$telefono', DATOSCAD = '$caducidad', DATOSCODSEG = '$codigoseg'  WHERE USUCOD = '$usucod' AND DATOSTAR = '$tarjetaoriginal';";
    $resultado2 = mysqli_query($conexion, $insertar2);
}

// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');


if($tarjeta <> "************"){
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