<?php
$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();
// Obtener la tarjeta enviada por la solicitud GET
$tarjeta = $_GET['tarjeta'];
$usucod = $_SESSION['usucod'];

$datosql = "SELECT * FROM DATOS WHERE USUCOD = '$usucod' AND DATOSTAR = '$tarjeta';";


$datosresultado = mysqli_query($conexion, $datosql);
$datos = mysqli_fetch_assoc($datosresultado);

// Devolver los datos como respuesta JSON
header('Content-Type: application/json');
echo json_encode($datos);
?>