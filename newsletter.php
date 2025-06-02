<?php

error_reporting(E_ALL);

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

$usucod = $_SESSION['usucod'];

$suscripcion = $_POST['suscripcion'];


if($suscripcion == "true"){

    $update1sql = "UPDATE usuarios SET USUNEWS = 1 WHERE USUCOD = '$usucod';";
    $update1query = mysqli_query($conexion, $update1sql);

    if($update1query){
        header("Content-Type: text/plain");
        echo "success";
    }else{
        header("Content-Type: text/plain");
        echo "error";
    }

}else{

    $update2sql = "UPDATE usuarios SET USUNEWS = 0 WHERE USUCOD = '$usucod';";
    $update2query = mysqli_query($conexion, $update2sql);
    
    if($update2query){
        header("Content-Type: text/plain");
        echo "success";
    }else{
        header("Content-Type: text/plain");
        echo "error";
    }   
}

?>