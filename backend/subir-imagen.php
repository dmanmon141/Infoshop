<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



$usucod = $_SESSION['usucod'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_FILES['imagen'])){
  $nombreArchivo = $_FILES["imagen"]["name"];
  $rutaArchivo = $_FILES["imagen"]["tmp_name"];
  $rutaDestino = "../img/users/" . $nombreArchivo;

  if (move_uploaded_file($rutaArchivo, $rutaDestino)) {
    $update = "UPDATE usuarios SET USUIMG = 'img/users/$nombreArchivo' WHERE USUCOD ='$usucod';";
    $updatequery = mysqli_query($conexion, $update);
    Header("Location: ../perfil");
    exit;
  } else {
    error_log("FALLO DE IMAGEN");
    Header("Location: ../perfil");
    exit;
  }
  }else{
    error_log("FALLO DE IMAGEN");
    Header("Location: ../perfil");
  }
}
?>
