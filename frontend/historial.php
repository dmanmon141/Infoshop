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
  header("Location: login");
  exit;
}

$usucod = $_SESSION['usucod'];

$datosql = "SELECT * FROM usuarios WHERE USUCOD = '$usucod';";
$datosquery = mysqli_query($conexion, $datosql);
$datosarray = mysqli_fetch_assoc($datosquery);
$usunom = $datosarray['USUNOM'];
$usuape = $datosarray['USUAPE'];
$usucor = $datosarray['USUCOR'];
$usucont = $datosarray['USUCONT'];
$usuimg = $datosarray['USUIMG'];
$usuadm = $datosarray['USUADM'];

$pedidosql = "SELECT * FROM pedidos WHERE USUCOD = '$usucod' ORDER BY PEDFECCOMP DESC, PEDCOD DESC;";
$pedidoquery = mysqli_query($conexion, $pedidosql);


$reseñasql = "SELECT * FROM reseñas WHERE USUCOD = '$usucod';";
$reseñaquery = mysqli_query($conexion, $reseñasql);
$reseñas = mysqli_num_rows($reseñaquery);

$fechaactual = date("Y-m-d");

?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-historial.css">
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
  <script src="js/cambiar-datos.js"></script>

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
          </a>
          <a href='register'>
            <li>Registrarse</li>
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
    <div id="popup" class="popup">
      <div class="popup-contenido">
        <h3>AVISO</h3>
        <p>Va a cambiar sus datos personales / de inicio de sesión.<br> ¿Está seguro?</p>
        <div class="popup-botones">
          <button onclick="cambiarDatos()">Sí</button>
          <button onclick="cerrarPopup()">No</button>
        </div>
      </div>
    </div>
    <div class="dividir">
      <div class="bloque2" id="producto-contenedor">
        <div class="navmenu">
          <div class="secciondatos">
            <a href="perfil"><img src="img/user.png" class="profileicon"><p>Perfil</p></a>
          </div>
          <div class="seccionconfiguracion">
            <a href="datospago"><img src="img/tarjeta.png" class="profileicon"><p>Datos de pago</p> </a>
          </div>
         
            <div class="seccionhistorial">
              <a href="historial"><img src="img/deliveryChosen.png" class="profileicon"><p>Historial</p></a>
            </div>
          
        </div>
        <div id="contenido">
          <div class="filagap">
            <img src="img/delivery.png" class="icon">
            <h2>Historial de pedidos</h2>
          </div>
          <div class="pedidos">
            <?php
            if (mysqli_num_rows($pedidoquery) == 0) {
              ?>

              <p>No se ha realizado ningún pedido aún.</p>
              <?php
            } else {
              while ($arraypedidos = mysqli_fetch_row($pedidoquery)) {
                $productosql = "SELECT * FROM productos WHERE PRODCOD = '$arraypedidos[4]'";
                $productosquery = mysqli_query($conexion, $productosql);
                $productosarray = mysqli_fetch_assoc($productosquery);
                $prodnom = $productosarray['PRODNOM'];
                $prodimg = $productosarray['PRODIMG'];
                $fechasql = $arraypedidos[1];
                $fechasql2 = $arraypedidos[2];
                $meses = array(
                  '01' => 'enero',
                  '02' => 'febrero',
                  '03' => 'marzo',
                  '04' => 'abril',
                  '05' => 'mayo',
                  '06' => 'junio',
                  '07' => 'julio',
                  '08' => 'agosto',
                  '09' => 'septiembre',
                  '10' => 'octubre',
                  '11' => 'noviembre',
                  '12' => 'diciembre'
                );

                $dia = date('d', strtotime($fechasql));
                $mes = $meses[date('m', strtotime($fechasql))];
                $año = date('Y', strtotime($fechasql));
                $dia2 = date('d', strtotime($fechasql2));
                $mes2 = $meses[date('m', strtotime($fechasql2))];
                $año2 = date('Y', strtotime($fechasql2));


                $fecha = $dia . ' de ' . $mes . ' de ' . $año;
                $fecha2 = $dia2 . ' de ' . $mes2 . ' de ' . $año2;
                ?>
                <div class="pedido">


                  <div class="pedido-imagen">
                    <img src="<?php echo $prodimg ?>">
                  </div>
                  <div class="pedido-nombre">
                    <p><?php echo $prodnom ?></p>
                  </div>
                  <div class="detalles">
                    <p style="color: black">Realizado el:</p>
                    <p><?php echo $fecha ?></p>
                  </div>
                  <div class="detalles2">
                    <p style="color: black">Devolución disponible hasta el</p>
                    <?php
                    if ($arraypedidos[2] <= $fechaactual) {
                      ?>
                      <p style="color: red"><?php echo $fecha2 ?></p>
                      <?php
                    } else {
                      ?>
                      <p style="color: #00FF00"><?php echo $fecha2 ?></p>
                      <?php
                    }
                    ?>
                  </div>
                  <div class="estado">
                    <p style="color: black">Estado del paquete</p>
                    <?php
                    if ($arraypedidos[5] == "En envío") {
                      ?>
                      <p style="color: #00FF00"><?php echo $arraypedidos[5] ?></p>
                      <?php
                    } elseif ($arraypedidos[5] == "Devuelto" || $arraypedidos[5] == "Reemplazado") {
                      ?>
                      <p style="color: red"><?php echo $arraypedidos[5] ?></p>
                      <?php
                    } else {
                      ?>
                      <p style="color: black"><?php echo $arraypedidos[5] ?></p>

                      <?php

                    }
                    ?>
                  </div>
                  <div class="botones">
                    <?php
                    if ($arraypedidos[5] == "Devuelto" || $arraypedidos[5] == "Reemplazado") {
                    } elseif ($arraypedidos[5] == "En envío") {
                      ?>
                      <form class="rastrear" action="rastrear" method="POST">
                        <input type="text" value="<?php echo $arraypedidos[0] ?>" name="pedidocod" style="display: none">
                        <button>Rastrear</button>
                      </form>
                      <?php
                    } else {

                      if ($arraypedidos[2] >= $fechaactual) {
                        ?>

                        <form class="devolver" action="devolver" method="POST">
                          <input type="text" value="<?php echo $arraypedidos[0] ?>" name="pedidocod" style="display: none">
                          <button>Devolver</button>
                        </form>
                        <form class="reemplazar" action="reemplazar" method="POST">
                          <input type="text" value="<?php echo $arraypedidos[0] ?>" name="pedidocod" style="display: none">
                          <button>Reemplazar</button>
                        </form>



                        <?php
                      }
                    }

                    ?>
                  </div>
                </div>

                <?php
              }
            }
            ?>
          </div>
        </div>
      </div>

    </div>
    <!--Footer -->

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



</body>

</html>