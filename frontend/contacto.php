<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();


if (isset($_POST['correo'])) {
  $correo = $_POST['correo'];
  $usulogin = "SELECT USUNOM FROM usuarios WHERE USUCOR = '$correo';";
  $usuloginsql = mysqli_query($conexion, $usulogin);
  $usuloginsesion = mysqli_fetch_assoc($usuloginsql);
  $_SESSION['usunom'] = $usuloginsesion['USUNOM'];


  $usucod = "SELECT USUCOD FROM usuarios WHERE USUCOR = '$correo';";
  $usucodsql = mysqli_query($conexion, $usucod);
  $usucodsesion = mysqli_fetch_assoc($usucodsql);
  $_SESSION['usucod'] = $usucodsesion['USUCOD'];



} elseif (!isset($_SESSION['usucod'])) {
  session_destroy();
}

if (isset($_SESSION['usucod'])) {

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


$productos = "SELECT PRODCOD, PRODNOM, PRODIMG, PRODPREC, PRODOFE FROM productos ORDER BY PRODOFE DESC LIMIT 6;";
$productosresultado = mysqli_query($conexion, $productos);

?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-contacto.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
  <link rel="icon" type="image/png" href="img/Logo.png">
</head>

<body>
  <script src="js/jquery-3.7.0.min.js"></script>
  <script src="js/slick/slick.min.js"></script>
  <script src="js/slider.js"></script>
  <script src="js/dropdown.js"></script>
  <script src="js/dropdowntienda.js"></script>
  <script src="js/carrito.js"></script>
  <script src="js/redireccionar-producto.js"></script>
  <script src="js/carrito-checkout.js"></script>

  <div id="overlay"></div>

  <div class="contenedor">
    <div id="myDropdownTienda" class="category-sidebar">

              <?php
              $categorias = "SELECT * FROM categorias";
              $categoriasql = mysqli_query($conexion, $categorias);

              while ($arraycat = mysqli_fetch_row($categoriasql)) {

                ?>
                <div class="categoria-item">
                  <img src="img/<?php echo $arraycat[0] ?>.png" class="cross" onclick="cerrarMenuTienda()">
                  <a href="buscar?categorias=<?php echo $arraycat[0] ?>"><?php echo $arraycat[1] ?></a>
                </div>
                <?php
              }

              ?>

    </div>
    <nav class="navbar">
      <div class="logo">
        <a href="index">
          <picture>
            <source srcset="img/LogoShort.png" media="(max-width: 1335px)">
            <img src="img/Logo.png">
          </picture>
          
        </a>
      </div>
      <ul class="nav-links">
        <li class="categorias"><button onclick="mostrarMenuTienda()" class="dropbtn" id="menuButtonShop">
            <div class="button-content-tienda">
              <img id="rayas" src="img/rayas.png">
              <h3>Todas las categorías</h3>
            </div>
        </li>
        <li class="busqueda">
          <!-- Formulario de búsqueda -->
          <form method="GET" action="buscar" class="busqueda-formulario" onsubmit="aplicarFiltro()">
            <input type="text" name="query" class="busqueda-texto" placeholder="Buscar productos">
            <input type="submit" value="" class="busqueda-boton">
          </form>
        </li>
        <?php
        if (isset($_SESSION['usucod'])) {
          if ($usuadm == 1) {
            ?>
            <a href="panel-administrador?productos" id="administrador">
              <li class="panel-adm">
                <div class="panel-administrador">
                  <img src="img/panel.png">
                  <span>Panel de administrador</span>
                </div>
              </li>
            </a>
            <?php
          }
        }
        ?>
      </ul>
      <ul class="sesiones">
        <?php

        if (isset($_SESSION['usucod'])) {
          $usuloginsesion = $_SESSION['usunom'];
          ?>
          <div class="cuenta">
            <button onclick="mostrarMenu()" class="dropbtn" id="menuButton">
              <div class="button-content">
                <div class="perfil-imagen">
                  <img class="userlogo" src="<?php echo $usuimg ?>">
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
        } else {
          ?>
          <a href='login'>
            <li>Iniciar sesión</li>
            <img src="img/login.png" class="sessionicon">
          </a>
          <a href='register'>
            <li>Registrarse</li>
            <img src="img/register.png" class="sessionicon">
          </a>
          <?php
        }


        ?>
        <div class="carrito">
          <div class="cart-menu" onclick="toggleCartSidebar()">
            <p id="productCount">0</p>
            <img src="img/carrito.png" alt="Carrito de compras">
            <span>Mi carrito</span>
          </div>
          <div class="cart-sidebar" id="cart-sidebar" style="text-align: left;">
            <div class="cart-title">
              <p style="font-size:20px">Mi carrito</p><img src="img/cross.png" alt="Cerrar" class="cart-close"
                onclick="toggleCartSidebar()">
            </div>
            <?php
            if (isset($_SESSION['usucod'])) {

              ?>

              <ul id="cart-items" class="cart-items"></ul>
              <p id="empty-message">No hay artículos en tu carrito</p>
              <div class="cart-sidebar-footer" id="cart-sidebar-footer">
                <p id="cart-total">TOTAL 0.00€</p>
                <button id="carritoVaciarBtn" class="carrito-vaciar-btn" onclick="emptyCart()">Vacíar carrito</button>
                <a id="carritoCheckout" class="carrito-checkout" onclick="checkout()">Ver artículos del carrito</a>

                <?php
            } else {
              ?>

                <img id="carrito-error" src="img/carritoerror.png">
                <p id="login-carrito">Inicia sesión para utilizar el carrito.</p>

                <?php
            }

            ?>
            </div>

          </div>
      </ul>
    </nav>

    <div id="main-container">
      <div class="bloque-error">
        <h1>Contáctanos</h1>
        <div class="dividir-bloque">
          <div class="bloque1">
            <h2>Información de contacto</h2>
            <h3>Dirección</h3>
            <h4>Avda. Virgen del Carmen 58</h4>
            <h3>Teléfono</h3>
            <h4>956 09 72 35</h4>
            <h3>Dirección de correo electrónico</h3>
            <h4>infoshopasir@gmail.com</h4>
          </div>
          <div class="bloque2">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3098.3289076972123!2d-1.837702587883776!3d39.0534180373642!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd665fadf1f402a1%3A0xd9fed63ef8ddd2aa!2sGrupo%20Infoshop!5e0!3m2!1sen!2ses!4v1685605791736!5m2!1sen!2ses"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
            <h3>¡Visitanos!</h3>
          </div>
        </div>
      </div>


      <!-- Resto del contenido de la página -->
      <footer>
        <div class="contenedor-footer">
          <div class="logo-footer">
            <img src="img/Logo.png" alt="Logo">
            
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