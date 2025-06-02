<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

$prodcod = $_POST['prodcod'];
$usucod = $_SESSION['usucod'];
$contenido = $_POST['contenido'];
$valoracion = $_POST['valoracion'];


$editar = "UPDATE reseñas SET RESVAL = '$valoracion', RESCONT = '$contenido', RESFEC = NOW() WHERE PRODCOD = '$prodcod' AND USUCOD = '$usucod';";
$editarsql = mysqli_query($conexion, $editar);
$editarvaloracion = "UPDATE productos SET PRODVAL = (SELECT AVG(RESVAL) FROM reseñas WHERE reseñas.PRODCOD = productos.PRODCOD AND productos.PRODCOD = '$prodcod') WHERE productos.PRODCOD = '$prodcod';";
$resultadoeditar = mysqli_query($conexion, $editarvaloracion);

if($editarsql){

    header("Content-Type: text/plain");
  echo "success";
} else {
  // Autenticación incorrecta
  $error = mysqli_error($conexion);
  header("Content-Type: text/plain");
  echo $error;
}