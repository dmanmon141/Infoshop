<?php
session_start();

if (isset($_POST['cartContent'])) {
  // Obtener el contenido del carrito desde la solicitud AJAX
  $cartContent = $_POST['cartContent'];

  // Guardar el contenido del carrito en la variable de sesión
  $_SESSION['cartContent'] = $cartContent;

  // Responder con un mensaje de éxito
  echo 'Carrito guardado en la sesión de PHP';
} else {
  // Responder con un mensaje de error si no se proporciona el contenido del carrito
  echo 'Error al guardar el carrito en la sesión de PHP';
}
?>