<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$nombreproducto = $_POST['nombreproducto'];
$descripcionproducto = $_POST['descripcionproducto'];
$precioproducto = $_POST['precioproducto'];
$ofertaproducto = $_POST['ofertaproducto'];
$inventarioproducto = $_POST['inventarioproducto'];
$marcaproducto = $_POST['marcaproducto'];
$categoriaproducto = $_POST['categoriaproducto'];

$preciofinalproductooperador = (($precioproducto * $ofertaproducto)/100);
echo $preciofinalproductooperador . "<br><br>";

$preciofinalproducto = $precioproducto - $preciofinalproductooperador;
echo $preciofinalproducto;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_FILES['imagenproducto'])){
  $nombreArchivo = $_FILES["imagenproducto"]["name"];
  $rutaArchivo = $_FILES["imagenproducto"]["tmp_name"];
  $rutaDestino = "../img/productos/" . $nombreArchivo;
  }
}


if (move_uploaded_file($rutaArchivo, $rutaDestino)) {
$insertar = "INSERT INTO productos (PRODCOD, PRODIMG, PRODNOM, PRODDESC, PRODPREC, PRODINV, PRODOFE, PRODNUMVENT, PRODPRECORI, PRODVAL, CATCOD, PROCOD) SELECT (SELECT MAX(PRODCOD) +1 FROM productos), '$rutaDestino', '$nombreproducto', '$descripcionproducto', '$preciofinalproducto', '$inventarioproducto', '$ofertaproducto', 0, '$precioproducto', 0, '$categoriaproducto', '$marcaproducto';";
$resultado = mysqli_query($conexion, $insertar);
}
// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}








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