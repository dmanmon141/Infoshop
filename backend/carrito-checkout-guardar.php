<?php
session_start();

// Verificar si se recibieron los datos de los productos
if (isset($_POST['products'])) {
  // Obtener los productos del cuerpo de la solicitud
  $productsJSON = $_POST['products'];
  
  // Decodificar la cadena JSON en un array asociativo
  $products = json_decode($productsJSON, true);
  
  // Almacenar los productos en una variable de sesión
  $_SESSION['products'] = $products;
} else {
  // No se recibieron datos de productos, mostrar un mensaje de error o redirigir al usuario a una página de error
  echo "Error: No se recibieron los datos de los productos.";
}
?>
