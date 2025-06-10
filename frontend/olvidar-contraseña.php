<?php

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();


?>

<!DOCTYPE html>
<html>
<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="js/jquery-3.7.0.min.js">
  <link rel="stylesheet" type="text/css" href="../css/estilo-olvidar.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
<link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
<link rel="icon" type="image/png" href="img/Logo.png">
</head>
<body>

<script src="js/recuperacion.js"></script>





<div class="contenedor">
<div class="logo">
    <a href="index"><img src="img/Logo.png" alt="Logo"></a>
</div>


<div class="contenedor2">
    <div class="block recomendaciones">
        <div class="bloque1">
          <img src="img/comprar.png" style="width:50px;height:50px;margin-top:25px;">
          <h3> Accede a tu historial de pedidos</h3>
        </div>
        <div class="bloque2">
          <img src="img/tarjeta.png" style="width:50px;height:50px;margin-top:20px;">
          <h3> Guarda tus datos de compra como:</h3>
          <ul style="list-style:none;padding:5px;">
            <li> Método de pago</li>
            <li>Número de Teléfono</li>
            <li>Dirección</li>
          </ul>
        </div>
    </div>

    <?php

    

    if(isset($_SESSION['usucod'])){
    ?>


    <div class="block sesion" id="sesioniniciada">
        <h2>Usted ya ha iniciado sesión. Redirigiendo...</h2>
        <?php
        ob_start();
        Header("Refresh: 2; URL=index");
        ob_end_flush();
        ?>
    </div>


    <?php
    }else{

    ?>

    <div class="block formulario">
        <h2>Recuperar contraseña</h2>
        <form id="login-form" method="POST" action="">
        <fieldset>
            <input type="mail" id="correo-input" class ="primero" name="correo" placeholder="Dirección de correo electrónico*">
            <input type="submit" name="enviar" value="Restablecer contraseña" id="btn-login">
            <div id="loader"></div>
            <a class ="login" href="login">Volver a inicio de sesión</a>
        </fieldset>
        </form>
        <div id="mensaje"></div>
    </div>
</div>

<?php

}

?>


<footer>
  <div class="contenedor-footer">
    <div class="logo-footer">
      <img src="img/Logo.png" alt="Logo">
      <h3>Infoshop</h3>
    </div>
    <div class="redes-sociales">
      <a href="#" class="icono-social"><img src ="img/fblogo.png" alt="Facebook"></i></a>
      <a href="#" class="icono-social"><img src="img/twlogo.png" alt="Twitter"></a>
      <a href="#" class="icono-social"><img src="img/iglogo.png" alt="Instagram"></a>
      <a href="#" class="icono-social"><img src="img/tklogo.png" alt="Tik Tok"></a>
    </div>
  <div class="derechos">
    <p> Infoshop &copy; 2025</p>
    <p><a href="contacto" class="politica">Contacto</a></p>
    <p><a href="privacidad" class="politica">Política de Privacidad</a></p>
  </div>
</div>
</footer>

</div>

</body>
</html>


