<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();


$usucod = $_SESSION['usucod'];

// Obtén los valores enviados desde el formulario
$razon = $_POST['razon'];
$detalles = $_POST['detalles'];
$pedcod = $_POST['pedcod'];


// Verifica si la conexión a la base de datos fue exitosa
if (!$conexion) {
  die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

$seleccionarsql = "SELECT * FROM productos PROD, pedidos PED WHERE PED.PRODCOD = PROD.PRODCOD AND PED.PEDCOD ='$pedcod';";
$seleccionarquery = mysqli_query($conexion, $seleccionarsql);
$seleccionararray = mysqli_fetch_assoc($seleccionarquery);
$prodcod = $seleccionararray['PRODCOD'];

$pedidosql = "SELECT * FROM pedidos WHERE PEDCOD = '$pedcod'";
$pedidoquery = mysqli_query($conexion, $pedidosql);
$pedidoarray = mysqli_fetch_assoc($pedidoquery);
$direccion = $pedidoarray['PEDPAIS'];
$direccion .= ", " . $pedidoarray['PEDCIU'];
$direccion .= ", " . $pedidoarray['PEDDIR'];
$tarjeta = $pedidoarray['PEDTAR'];
$caducidad = $pedidoarray['PEDCAD'];
$codigoseg = $pedidoarray['PEDCODSEG'];
$ciudad = $pedidoarray['PEDCIU'];
$direccion2 = $pedidoarray['PEDDIR'];
$codigopost = $pedidoarray['PEDCP'];
$pais = $pedidoarray['PEDPAIS'];
$telefono = $pedidoarray['PEDTEL'];

$notificacionsql = "INSERT INTO paneladmin (ADMCOD, ADMCONT, NOTCOD) SELECT (SELECT MAX(ADMCOD) +1 FROM paneladmin), '$direccion', 2;";
$notificacionquery = mysqli_query($conexion, $notificacionsql);

// Consulta la base de datos para verificar las credenciales


$insertar = "INSERT INTO devoluciones (DEVCOD, DEVRAZ, DEVDET, PEDCOD) SELECT (SELECT MAX(DEVCOD) +1 FROM devoluciones), '$razon', '$detalles', '$pedcod';";
$resultado = mysqli_query($conexion, $insertar);
$insertar2 = "INSERT INTO pedidos (PEDCOD, PEDFECCOMP, PEDFECDEV, USUCOD, PRODCOD, PEDEST, PEDTAR, PEDCAD, PEDCODSEG, PEDCIU, PEDDIR, PEDCP, PEDPAIS, PEDTEL) SELECT (SELECT MAX(PEDCOD) +1 FROM pedidos), NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), '$usucod', '$prodcod', 'En envío', '$tarjeta', '$caducidad', '$codigoseg', '$ciudad', '$direccion2', '$codigopost', '$pais', '$telefono';";
$resultado2 = mysqli_query($conexion, $insertar2);
$update = "UPDATE pedidos SET PEDEST = 'Reemplazado' WHERE PEDCOD = '$pedcod'";
$resultadoupdate = mysqli_query($conexion, $update);


// Verifica si se encontró un registro coincidente
error_log('Verifying credentials...');

if ($resultado && $resultadoupdate) {
  // Autenticación exitosa
  Header("Location: historial");
} else {
  // Autenticación incorrecta
  header("Content-Type: text/plain");
  echo "error";
}


// Cierra la conexión a la base de datos
mysqli_close($conexion);

?>