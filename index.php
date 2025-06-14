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

$productos1 = "SELECT PRODCOD, PRODNOM, PRODIMG, PRODPREC, PRODOFE, PRODVAL, PRODPRECORI FROM productos WHERE PRODOFE >= 20 ORDER BY PRODOFE DESC LIMIT 12;";
$productosresultado1 = mysqli_query($conexion, $productos1);

$productos2 = "SELECT PRODCOD, PRODNOM, PRODIMG, PRODPREC, PRODINV, PRODVAL, PRODPRECORI FROM productos WHERE PRODINV <= 12 ORDER BY PRODINV ASC LIMIT 12;";
$productosresultado2 = mysqli_query($conexion, $productos2);

$productos3 = "SELECT PRODCOD, PRODNOM, PRODIMG, PRODPREC, PRODINV, PRODVAL, PRODPRECORI, PRODOFE FROM productos ORDER BY PRODNUMVENT DESC LIMIT 12;";
$productosresultado3 = mysqli_query($conexion, $productos3);

$productos4 = "SELECT PRODCOD, PRODNOM, PRODIMG, PRODPREC, PRODINV, PRODVAL, PRODPRECORI, PRODOFE FROM productos ORDER BY PRODVAL DESC LIMIT 12;";
$productosresultado4 = mysqli_query($conexion, $productos4);

?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="css/estilo-main.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
  <link rel="icon" type="image/png" href="img/Logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

  <div contenedor>
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


    <div class="anuncios">
      <div><img src="img/anuncio1.jpeg" class="anuncio1" onclick="scrollToSection('ofertas')"></div>
      <div><a href="https://www.logitech.com/es-es" target="_blank"><img src="img/anuncio2.jpg" class="anuncio2"></a>
      </div>
    </div>
    <div class="sectionTitle">
      <h1>Mejor valorado</h1>
      <a href="buscar">Ver más</a>
    </div>

    <div class="separator"></div>
    <div class="slider-container">
      <div class="slider">
        <?php
        while ($array4 = mysqli_fetch_row($productosresultado4)) {

          ?>

          <div class="product">
            <div class="contenedor-imagen" onclick="redireccionar('<?php echo $array4[0] ?>')">
              <img src="<?php echo $array4[2] ?>" alt="Imagen" class="product-image">
              <div class="oferta-fondo">
                <h3 class="oferta"><?php echo "- " . $array4[7] . "%" ?> </h3>
              </div>
              <div class="texto-fondo">
                <h2 class="product-title"><?php echo $array4[1] ?></h2>
              </div>
            </div>
            <div class="product-info">
              <div class="precio-fondo2">
                <p class="product-price"><?php echo $array4[3] . " €" ?></p>
              </div>
              <div class="precio-sin-oferta">
                <p class="product-price-sin-oferta"><?php echo $array4[6] . " €" ?></p>
              </div>
              <div class="oferta-fondo2">



                <?php

                $n = $array4[5];
                for ($i = 1; $i <= $n; $i++) {
                  ?>
                  <img class="estrella" src="img/star-on.png">
                  <?php
                }

                for ($n; $n < 5; $n++) {
                  ?>
                  <img class="estrella" src="img/star-off.png">
                  <?php
                }
                ?>

              </div>
            </div>
          </div>

          <?php
        }
        ?>

      </div>
    </div>

    <div class="sectionTitle">
      <h1>Lo más vendido</h1>
      <a href="buscar">Ver más</a>
    </div>
    <div class="separator"></div>
    <div class="slider-container">
      <div class="slider">
        <?php
        while ($array3 = mysqli_fetch_row($productosresultado3)) {

          ?>

          <div class="product">
            <div class="contenedor-imagen" onclick="redireccionar('<?php echo $array3[0] ?>')">
              <img src="<?php echo $array3[2] ?>" alt="Imagen" class="product-image">
              <div class="oferta-fondo">
                <h3 class="oferta"><?php echo "- " . $array3[7] . "%" ?> </h3>
              </div>
              <div class="texto-fondo">
                <h2 id="product-title"><?php echo $array3[1] ?></h2>
              </div>
            </div>
            <div class="product-info">
              <div class="precio-fondo2">
                <p class="product-price"><?php echo $array3[3] . " €" ?></p>
              </div>
              <div class="precio-sin-oferta">
                <p class="product-price-sin-oferta"><?php echo $array3[6] . " €" ?></p>
              </div>
              <div class="oferta-fondo2">



                <?php

                $n = $array3[5];
                for ($i = 1; $i <= $n; $i++) {
                  ?>
                  <img class="estrella" src="img/star-on.png">
                  <?php
                }

                for ($n; $n < 5; $n++) {
                  ?>
                  <img class="estrella" src="img/star-off.png">
                  <?php
                }
                ?>

              </div>
            </div>
          </div>

          <?php
        }
        ?>

      </div>
    </div>

    <div class="sectionTitle">
      <h1>Últimas unidades</h1>
      <a href="buscar">Ver más</a>
    </div>
    <div class="separator"></div>
    <div class="slider-container">
      <div class="slider">
        <?php

        while ($array2 = mysqli_fetch_row($productosresultado2)) {
          ?>

          <div class="product">
            <div class="contenedor-imagen" onclick="redireccionar('<?php echo $array2[0] ?>')">
              <img src="<?php echo $array2[2] ?>" alt="Imagen" class="product-image">
              <div class="unidades-fondo">
                <h3 class="oferta"><?php echo $array2[4] . " uds. restantes" ?> </h3>
              </div>
              <div class="texto-fondo">
                <h2 id="product-title"><?php echo $array2[1] ?></h2>
              </div>
            </div>
            <div class="product-info">
              <div class="precio-fondo2">
                <p class="product-price"><?php echo $array2[3] . " €" ?></p>
              </div>
              <div class="precio-sin-oferta">
                <p class="product-price-sin-oferta"><?php echo $array2[6] . " €" ?></p>
              </div>
              <div class="oferta-fondo2">



                <?php

                $n = $array2[5];
                for ($i = 1; $i <= $n; $i++) {
                  ?>
                  <img class="estrella" src="img/star-on.png">
                  <?php
                }

                for ($n; $n < 5; $n++) {
                  ?>
                  <img class="estrella" src="img/star-off.png">
                  <?php
                }
                ?>

              </div>
            </div>
          </div>

          <?php
        }
        ?>

      </div>
    </div>

    <div class="sectionTitle" id="ofertas">
      <h1>Aprovecha nuestras mejores ofertas</h1>
      <a href="buscar">Ver más</a>
    </div>
    <div class="separator"></div>
    <div class="slider-container">

      <div class="slider">
        <?php
        while ($array1 = mysqli_fetch_row($productosresultado1)) {

          ?>

          <div class="product">
            <div class="contenedor-imagen" onclick="redireccionar('<?php echo $array1[0] ?>')">
              <img src="<?php echo $array1[2] ?>" alt="Imagen" class="product-image">
              <div class="oferta-fondo">
                <h3 class="oferta"><?php echo "- " . $array1[4] . "%" ?> </h3>
              </div>
              <div class="texto-fondo">
                <h2 id="product-title"><?php echo $array1[1] ?></h2>
              </div>
            </div>
            <div class="product-info">
              <div class="precio-fondo2">
                <p class="product-price"><?php echo $array1[3] . " €" ?></p>
              </div>
              <div class="precio-sin-oferta">
                <p class="product-price-sin-oferta"><?php echo $array1[6] . " €" ?></p>
              </div>
              <div class="oferta-fondo2">



                <?php

                $n = $array1[5];
                for ($i = 1; $i <= $n; $i++) {
                  ?>
                  <img class="estrella" src="img/star-on.png">
                  <?php
                }

                for ($n; $n < 5; $n++) {
                  ?>
                  <img class="estrella" src="img/star-off.png">
                  <?php
                }
                ?>

              </div>
            </div>
          </div>

          <?php
        }
        ?>

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