<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

$usucod = $_POST['idUsuario'];
$prodcod = $_POST['idProducto'];

$eliminar = "DELETE FROM reseñas WHERE PRODCOD = '$prodcod' AND USUCOD = '$usucod';";
$eliminarsql = mysqli_query($conexion, $eliminar);
$editarvaloracion = "UPDATE productos SET PRODVAL = (SELECT AVG(RESVAL) FROM reseñas WHERE reseñas.PRODCOD = productos.PRODCOD AND productos.PRODCOD = '$prodcod') WHERE productos.PRODCOD = '$prodcod';";
$resultadoeditar = mysqli_query($conexion, $editarvaloracion);

if($eliminarsql){

    header("Content-Type: text/plain");
  echo "success";
} else {
  // Autenticación incorrecta
  $error = mysqli_error($conexion);
  header("Content-Type: text/plain");
  echo $error;
}