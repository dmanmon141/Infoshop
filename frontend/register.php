<?php

$servidor = "localhost";
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
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-registro.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
  <link rel="icon" type="image/png" href="img/Logo.png">
</head>

<body>

  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/togglepass.js"></script>
  <script src="js/register.js"></script>
  <script src="js/togglepassrp.js"></script>





  <div class="contenedor">
    <div class="logo">
      <a href="index"><img src="img/Logo.png" alt="Logo"></a>
    </div>


    <div class="contenedor2">
      <div class="block recomendaciones">
          <div>
            <img src="img/comprar.png" style="width:50px;height:50px;margin-top:25px;">
            <h3> Adquiere nuestros productos a los mejores precios</h3>
          </div>
          <div>
            <img src="img/delivery.png" style="width:50px;height:50px;margin-top:25px;">
            <h3> Consulta tu historial de pedidos</h3>
          </div>
          <div>
            <img src="img/tarjeta.png" style="width:50px;height:50px;margin-top:20px;">
            <h3> Guarda tus datos de compra</h3>
          </div>
        </div>

      <?php



      if (isset($_SESSION['usucod'])) {
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
      } else {
        session_destroy();
        ?>

        <div class="block formulario">
          <h2>Crear cuenta</h2>
          <form id="login-form" onsubmit="enviarFormulario(event)" method="POST" action="">
            <fieldset>
              <input type="text" id="nombre-input" class="primero" name="nombre" placeholder="¿Cuál es tu nombre?">
              <input type="text" id="apellidos-input" class="primero" name="apellidos" placeholder="Apellidos">
              <input type="mail" id="correo-input" class="primero" name="correo"
                placeholder="Dirección de correo electrónico*">
              <div class="password-container">
                <input type="password" id="contraseña-input" name="contraseña" placeholder="Contraseña">
                <span class="toggle-password" onclick="togglePasswordVisibility()"></span>
              </div>
              <div class="password-container">
                <input type="password" id="repetir-contraseña-input" name="repetir-contraseña"
                  placeholder="Repetir Contraseña">
                <span class="toggle-password-rp" onclick="togglePasswordVisibilityrp()"></span>
              </div>
              <div class="fila">
                <input type="checkbox" id="politicas-input" class="politica" name="politicas">
                <label for="politicas">He leído y acepto la <a href="privacidad">política de privacidad</a></label>
              </div>

              <div id="mensaje"></div>
              <input type="submit" name="enviar" value="Registrarse" id="btn-login" class="btnenviar">
              <h3>Ya tienes cuenta?</h3>
              <a class="login" href="login">Iniciar sesión</a>
            </fieldset>
          </form>
        </div>
      </div>

      <footer>
        <div class="contenedor-footer">
          <div class="logo-footer">
            <img src="img/Logo.png" alt="Logo">
            <h3>Infoshop</h3>
          </div>
          <div class="redes-sociales">
            <a href="#" class="icono-social"><img src="img/fblogo.png" alt="Facebook"></i></a>
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

  <?php

      }
      ?>