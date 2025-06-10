<?php
session_start();

// Verificar si el carrito está almacenado en la sesión
if (isset($_SESSION['cartContent'])) {
  // Obtener el contenido del carrito desde la sesión
  $cartContent = $_SESSION['cartContent'];

  // Devolver el contenido del carrito en el formato adecuado (HTML en este caso)
  echo $cartContent;
} else {
  // Responder con un mensaje de error si el carrito no está almacenado en la sesión
  echo '';
}
?>