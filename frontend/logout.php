<?php

session_start();

// Destruir la sesión
unset($_SESSION['cartContent']);
session_destroy();

// Redirigir a la página "index.php"
header("Location: index");
exit();
?>