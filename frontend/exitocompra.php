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
  header("Location: ../index");
  exit();
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


?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-checkout.css">
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
  <script src="js/filtros.js"></script>
  <script src="js/carrito-checkout.js"></script>

  <div id="overlay"></div>

  <div class="contenedor">
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
                <?php
                if (isset($_SESSION['usucod'])) {
                  if ($usuadm == 1) {
                    ?>
                    <a href="panel-administrador?productos" id="administrador">
                      <span>Panel de administrador</span>
                    </a>
                    <?php
                  }
                }
                ?>
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

    <!-- Resto del contenido de la página -->


    <div class="main">
      <div class="block sesion" id="sesioniniciada">
        <img src="img/envio.png">
        <h1>!Listo!</h1>
        <h3>Tu paquete está de camino. !Disfruta!</h3>
        <a href="index" id="seguir">Seguir comprando</a>
      </div>
    </div>



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
  </div>



</body>

</html>