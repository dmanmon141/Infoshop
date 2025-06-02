<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();



// Obtén los valores enviados desde el formulario
$nombreproducto = $_POST['nombreproducto2'];
$descripcionproducto = $_POST['descripcionproducto2'];
$precioproducto = $_POST['precioproducto2'];
$ofertaproducto = $_POST['ofertaproducto2'];
$inventarioproducto = $_POST['inventarioproducto2'];
$marcaproducto = $_POST['marcaproducto2'];
$categoriaproducto = $_POST['categoriaproducto2'];
$prodcod = $_POST['prodcod2'];

$preciofinalproductooperador = (($precioproducto * $ofertaproducto)/100);
echo $preciofinalproductooperador . "<br><br>";

$preciofinalproducto = $precioproducto - $preciofinalproductooperador;
echo $preciofinalproducto;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_FILES['imagenproducto2'])){
  $nombreArchivo = $_FILES["imagenproducto2"]["name"];
  $rutaArchivo = $_FILES["imagenproducto2"]["tmp_name"];
  $rutaDestino = "img/productos/" . $nombreArchivo;
  }
}

if(isset($_FILES['imagenproducto2'])){
if (move_uploaded_file($rutaArchivo, $rutaDestino)) {
$insertar = "UPDATE productos SET PRODIMG = '$rutaDestino', PRODNOM = $nombreproducto, PRODDESC = '$descripcionproducto', PRODPREC = '$preciofinalproducto', PRODINV = '$inventarioproducto', PRODOFE = '$ofertaproducto', PRODPRECORI = '$precioproducto', CATCOD = '$categoriaproducto', PROCOD = '$marcaproducto' WHERE PRODCOD = '$prodcod';";
$resultado = mysqli_query($conexion, $insertar);
}
}else{
$insertar = "UPDATE productos SET PRODNOM = '$nombreproducto', PRODDESC = '$descripcionproducto', PRODPREC = '$preciofinalproducto', PRODINV = '$inventarioproducto', PRODOFE = '$ofertaproducto', PRODPRECORI = '$precioproducto', CATCOD = '$categoriaproducto', PROCOD = '$marcaproducto' WHERE PRODCOD = '$prodcod';";
$resultado = mysqli_query($conexion, $insertar);
}
// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


// Consulta la base de datos para verificar las credenciales





// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if ($resultado) {
  // Autenticación exitosa
  header("Location: panel-administrador?productos");
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "duplicado";
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>