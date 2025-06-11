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
if(!isset($_POST['pedidocod'])){
  header("Location: ../index");
  exit();
}

$pedidocod = $_POST['pedidocod'];

$pedidosql = "SELECT * FROM pedidos WHERE PEDCOD = '$pedidocod';";
$pedidoquery = mysqli_query($conexion, $pedidosql);
$pedidoarray = mysqli_fetch_assoc($pedidoquery);
$prodcod = $pedidoarray['PRODCOD'];
$productosql = "SELECT * FROM productos WHERE PRODCOD = '$prodcod';";
$productoquery = mysqli_query($conexion, $productosql);
$productoarray = mysqli_fetch_assoc($productoquery);
$prodimg = $productoarray['PRODIMG'];
$prodnom = $productoarray['PRODNOM'];
$prodprec = $productoarray['PRODPREC'];

?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Devolver pedido</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-devolver.css">
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
        <a href="index"><img src="img/Logo.png"></a>
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
    <div class="container">
      <div class="bloque">
        <h2>Detalles del pedido</h2>
        <div class="fila">
          <p>Imagen del producto</p>
          <p>Nombre del producto</p>
          <p>Fecha del pedido</p>
          <p>Estado del pedido</p>
        </div>
        <div class="producto-detalles">
          <div class="producto-imagen">
            <img src="<?php echo $prodimg ?>">
          </div>
          <p><?php echo $prodnom ?></p>
          <?php

          $fechasql = $pedidoarray['PEDFECCOMP'];
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
          $fecha = $dia . ' de ' . $mes . ' de ' . $año;
          ?>
          <div class="fechas">
            <p><?php echo $fecha ?></p>
          </div>
          <div class="estado">
            <?php
            if ($pedidoarray['PEDEST'] == "En envío") {
              ?>
              <p style="color: lightgreen"><?php echo $pedidoarray['PEDEST']; ?></p>
              <?php
            } else {
              ?>
              <p style="color: black"><?php echo $pedidoarray['PEDEST']; ?></p>
              <?php
            }
            ?>
          </div>
        </div>

      </div>
      <div class="bloque2">
        <div class="formulario">
          <form class="formulariodevolucion" action="backend/devolvercheck.php" method="POST">
            <input type="text" name="pedcod" value="<?php echo $pedidocod ?>" style="display: none">
            <div class="formulariodatos">
              <div class="razon">
                <p>¿Por qué quiere devolver este producto?</p>
                <select class="razon" name="razon">
                  <option value="Defectuoso">El producto se encuentra defectuoso.</option>
                  <option value="Decepcion">El producto no era lo que yo esperaba.</option>
                  <option value="Arrepentir">No necesito este producto actualmente.</option>
                  <option value="Otros">Otro motivo.</option>
                </select>
              </div>
            </div>
            <div class="detalles">
              <p>Otorga más detalles (Opcional):</p>
              <textarea name="detalles"></textarea>
            </div>
            <div class="tarjetaformulario">
              <p style="font-size: 14px;"><em>El coste será reembolsado a tu tarjeta en un plazo de 7 días</em></P>
              <div class="boton">
                <button>Devolver</button>
              </div>
            </div>
          </form>
        </div>
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

  </div>





  </div>
  </div>



</body>

</html>