<?php

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

if (isset($_SESSION['correo'])) {
  $correo = $_POST['correo'];
  $usulogin = "SELECT USUNOM FROM usuarios WHERE USUCOR = '$correo';";
  $usuloginsql = mysqli_query($conexion, $usulogin);
  $usuloginsesion = mysqli_fetch_assoc($usuloginsql);
  $_SESSION['usunom'] = $usuloginsesion['USUNOM'];

  
  $usucod = "SELECT USUCOD FROM usuarios WHERE USUCOR = '$correo';";
  $usucodsql = mysqli_query($conexion, $usucod);
  $usucodsesion =  mysqli_fetch_assoc($usucodsql);
  $_SESSION['usucod'] = $usucodsesion['USUCOD'];

}else{
  //Si no está el correo guardado
}

if(isset($_SESSION['usucod'])){

$usucodsesion = $_SESSION['usucod'];

$datosql = "SELECT * FROM usuarios WHERE USUCOD = '$usucodsesion';";
$datosquery = mysqli_query($conexion, $datosql);
$datosarray = mysqli_fetch_assoc($datosquery);
$usunom = $datosarray['USUNOM'];
$usuape = $datosarray['USUAPE'];
$usucor = $datosarray['USUCOR'];
$usucont = $datosarray['USUCONT'];
$usuimg = $datosarray['USUIMG'];
$usuadm = $datosarray['USUADM'];
}


?>


<!DOCTYPE html>
<html>
<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="estilo-privacidad.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
<link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
<link rel="icon" type="image/png" href="img/Logo.png">
</head>
<body>
<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/slick/slick.min.js"></script>
<script src="js/slider.js"></script>
<script src="js/carrito.js"></script>
<script src="js/dropdown.js"></script>
<script src="js/dropdowntienda.js"></script>
<script src="js/redireccionar-producto.js"></script>
<script src="js/filtros.js"></script>
<script src="js/carrito-checkout.js"></script>

<div id="overlay"></div>

  <nav class="navbar">
    <div class="logo">
      <a href="index"><img src="img/Logo.png"></a>
    </div>
    <ul class="nav-links">
    <li class="categorias"><button onclick="mostrarMenuTienda()" class="dropbtn" id="menuButtonShop">
          <div class="button-content-tienda">   
 <img id="rayas" src="img/rayas.png">         
<h3>Todas las categorías</h3>
  
          </div>
            <div id="myDropdownTienda" class="dropdown-content">
              
            <?php
            $categorias = "SELECT * FROM categorias";
            $categoriasql= mysqli_query($conexion, $categorias);

            while($arraycat = mysqli_fetch_row($categoriasql)){

            ?>
              <a href="buscar?categorias=<?php echo $arraycat[0] ?>"><?php echo $arraycat[1] ?></a>

            <?php
            }

            ?>

            </div>      
    </li>
      <li class="busqueda">
        <!-- Formulario de búsqueda -->
        <form method="GET" action="buscar" class="busqueda-formulario" onsubmit="aplicarFiltro()">
            <input type="text" name="query" class="busqueda-texto" placeholder="Buscar productos">
            <input type="submit" value="" class="busqueda-boton">
        </form>
      </li>
      <li class="carrito">
            <div class="cart-menu" onclick="toggleCartSidebar()">
                <img src="img/carrito.png" alt="Carrito de compras">
                <span>Mi carrito</span>
            </div>
            <div class="cart-sidebar" id="cart-sidebar" style="text-align: left;">
                <p style="font-size:20px">Mi carrito</p>
                <?php 
                if(isset($_SESSION['usucod'])){

                ?>  

                <ul id="cart-items" class="cart-items"></ul>
                <div class="cart-sidebar-footer" id="cart-sidebar-footer">
                <p id="cart-total">TOTAL  0.00€</p>
                <button id="carritoVaciarBtn" class="carrito-vaciar-btn" onclick="emptyCart()">Vacíar carrito</button>
                <a  id="carritoCheckout" class="carrito-checkout" onclick="checkout()">Ver artículos del carrito</a>

                <?php
                }else {
                  ?>

                  <img id="carrito-error" src="img/carritoerror.png">
                  <p id="login-carrito">Inicia sesión para utilizar el carrito.</p>

                  <?php
                }

                ?>
                </div>
           
      </li>
      <?php
            if(isset($_SESSION['usucod'])){
              if($usuadm == 1){
                ?>
                <a href="panel-administrador?productos" id="administrador"><li class="panel-adm">
                  <div class="panel-administrador">
                    <img src="img/panel.png">
                    <span>Panel de administrador</span>
                  </div>
                </li></a>
                <?php
              }
            }
            ?>
    </ul>
    <ul class="sesiones">
      <?php 

        if(isset($_SESSION['usucod'])){
          $usuloginsesion = $_SESSION['usunom'];
          ?>
          <div class="cuenta">
          <button onclick="mostrarMenu()" class="dropbtn" id="menuButton">
          <div class="button-content">
          <div class="perfil-imagen">
          <img class ="userlogo" src="<?php echo $usuimg ?>">
          </div>
          <h3><?php echo $usuloginsesion ?></h3>
          <img id="flecha" src="img/flecha.png">
          </div>
            <div id="myDropdown" class="dropdown-content menu-contenedor">
              <a href="perfil">Mi cuenta</a>
              <a href="historial">Historial de pedidos</a>
              <a href="#" onclick="cerrarSesion()">Cerrar sesión</a>
            </div>
            </button>
         </div>

         <?php 
        }else{
          session_destroy();
          ?> 
          <a href='login'><li>Iniciar sesión</li></a>
                <a href='register'><li>Registrarse</li></a>
          <?php
        }
      
      
      ?>
    </ul>
  </nav>

<div contenedor>
<div class="block">


<h1>Política de Privacidad</h1>

<h2 id="primero">Última actualización: 15 de Mayo de 2023</h2>

<p>En Infoshop, estamos comprometidos con la protección de tu privacidad. Esta Política de Privacidad describe cómo recopilamos, utilizamos, divulgamos y protegemos la información personal que obtenemos de los usuarios de nuestro sitio web y clientes. Al utilizar nuestros servicios, aceptas los términos y prácticas descritos en esta Política de Privacidad.</p>

<h2>1. Recopilación de Información</h2>
<h3>1.1 Información Personal</h3>

<p>Podemos recopilar información personal identificable de distintas formas, incluyendo cuando nos la proporcionas voluntariamente al realizar una compra, crear una cuenta, suscribirte a nuestro boletín de noticias, participar en encuestas o completar formularios en nuestro sitio web. Esta información puede incluir tu nombre, dirección de correo electrónico, número de teléfono, dirección de envío y facturación, entre otros datos necesarios para brindarte nuestros servicios.</p>

<h3>1.2 Información de Pago</h3>

<p>Cuando realizas una compra en nuestro sitio web, podemos recopilar información de pago, como los detalles de tu tarjeta de crédito o débito, para procesar y completar la transacción. Esta información se maneja de forma segura utilizando tecnologías de encriptación y no se almacena en nuestros servidores.</p>

<h3>2. Uso de la Información</h3>
<p>Utilizamos la información recopilada para brindarte nuestros servicios, procesar tus pedidos, comunicarnos contigo sobre tu cuenta y proporcionarte información relevante sobre nuestros productos, promociones y actualizaciones. También podemos utilizar la información para mejorar nuestros servicios, personalizar tu experiencia de usuario y realizar análisis internos.</p>

<h3>3. Divulgación de la Información</h3>
<p>No compartimos tu información personal con terceros, excepto en los siguientes casos:

Proveedores de servicios: Podemos compartir tu información con proveedores de servicios externos que nos ayudan en la operación de nuestro negocio, como procesadores de pagos, empresas de envío y servicios de atención al cliente. Estos proveedores están obligados a utilizar la información de acuerdo con nuestras instrucciones y mantener su confidencialidad.

Cumplimiento legal: Podemos divulgar tu información personal cuando sea requerido por la ley, una orden judicial o una autoridad gubernamental.</p>

<h3>4. Seguridad de la Información</h3>
<p>Tomamos medidas razonables para proteger la información personal que recopilamos y almacenamos, tanto durante la transmisión como una vez recibida. Utilizamos tecnologías de seguridad adecuadas para proteger contra el acceso no autorizado, el uso indebido, la alteración o la divulgación de la información.</p>

<h3>5. Enlaces a Sitios Externos</h3>
<p>Nuestro sitio web puede contener enlaces a sitios web de terceros. No nos responsabilizamos de las prácticas de privacidad o el contenido de dichos sitios. Te recomendamos que revises las políticas de privacidad de esos sitios antes de proporcionar cualquier información personal.</p>

<h3>6. Cambios en la Política de Privacidad</h3>
<p>Nos reservamos el derecho de actualizar o modificar esta Política de Privacidad en cualquier momento. Te notificaremos sobre cualquier cambio relevante publicando la versión actualizada en nuestro sitio web. Es tu responsabilidad revisar periódicamente esta Política de Privacidad para estar informado sobre cualquier cambio.</p>

<h3>7. Contacto</h3>

<p>Si tienes alguna pregunta, inquietud o solicitud relacionada con esta Política de Privacidad o el manejo de tu información personal, puedes comunicarte con nosotros a través de los siguientes medios:

<ul class="lista-privacidad">
<li>INFOSHOP S.L</li>
<li>Dirección: Avda. Virgen del Carmen 58 Portal D Bajo Izqd</li>
<li>Teléfono: 956 09 72 35</li>
<li>Correo electrónico: infoshopasir@gmail.com</li>
<ul>
Estaremos encantados de atenderte y responder a tus consultas.

Recuerda que el uso de nuestro sitio web y servicios está sujeto a los términos y condiciones establecidos en nuestros Términos de Servicio y esta Política de Privacidad.

Gracias por confiar en Infoshop.
</p>
</div>
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
    <p> Infoshop &copy; 2023</p>
    <p><a href="contacto" class="politica">Contacto</a></p>
    <p><a href="privacidad" class="politica">Política de Privacidad</a></p>
  </div>
</div>
</footer>
</div>
</div>
</body>
</html>