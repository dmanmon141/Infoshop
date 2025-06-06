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


if (isset($_GET['categorias'])) {

  $categoriasproductosget = $_GET['categorias'];
  $categoriasproductosarray = explode(',', $categoriasproductosget);
  $categoriasproductos = "'" . implode("','", $categoriasproductosarray) . "'";
}

if (isset($_GET['marcas'])) {
  $marcasproductosget = $_GET['marcas'];
  $marcasproductosarray = explode(',', $marcasproductosget);
  $marcasproductos = "'" . implode("','", $marcasproductosarray) . "'";
}

if (isset($_GET['query'])) {
  $query = $_GET['query'];
}

if (isset($_GET['precio'])) {
  $precio = $_GET['precio'];
}

$sqlproductos = "SELECT * FROM productos WHERE 1";

if (isset($categoriasproductos)) {
  $sqlproductos .= " AND CATCOD IN ($categoriasproductos)";
}

if (isset($marcasproductos)) {
  $sqlproductos .= " AND PROCOD IN ($marcasproductos)";
}

if (isset($query)) {
  $sqlproductos .= " AND PRODNOM LIKE '%$query%' OR PRODDESC LIKE '%$query'";
}



if (isset($precio)) {
  if ($precio == 1) {
    $sqlproductos .= " ORDER BY PRODPREC DESC";
  } elseif ($precio == 2) {
    $sqlproductos .= " ORDER BY PRODPREC ASC";
  }
} else {
  if (isset($categoriasproductos) || isset($marcasproductos) || isset($query)) {
    $sqlproductos .= " ORDER BY CATCOD";
    $n = 0;
  } else {
    $h = 0;
  }
}

if (isset($n)) {
} else {
  if (isset($h)) {
  } else {
    $sqlproductos .= " , CATCOD";
  }
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


$sqlproductosfinal = mysqli_query($conexion, $sqlproductos);


?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-buscar.css">
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

    <div class="dividir">

      <div class="bloque1">
        <h1>Filtrar por:</h1>
        <div class="filtro">
          <h3>Precio</h3>
          <label id="primeras">
            <input type="radio" name="filtroprecio" id="radiohide1" value="1" onchange="aplicarFiltro()">
            <span class="radio-icon"></span>
            De mayor a menor
          </label>
          <label id="primeras">
            <input type="radio" name="filtroprecio" id="radiohide2" value="2" onchange="aplicarFiltro()">
            <span class="radio-icon"></span>
            De menor a mayor
          </label>
        </div>
        <div class="filtro">
          <h3>Categoría</h3>

          <?php
          $categorias2 = "SELECT * FROM categorias";
          $categoriasql2 = mysqli_query($conexion, $categorias2);

          while ($arraycat2 = mysqli_fetch_row($categoriasql2)) {

            ?>
            <label>
              <input type="checkbox" name="filtrocategoria" id="checkbox-left" onchange="aplicarFiltro()"
                value="<?php echo $arraycat2[0] ?>">
              <?php echo $arraycat2[1] ?>
            </label>
            <?php
          }

          ?>

        </div>
        <div class="filtro" id="ultimo">
          <h3>Marca</h3>

          <?php
          $marcas = "SELECT * FROM proveedores";
          $marcassql = mysqli_query($conexion, $marcas);

          while ($arraymarcas = mysqli_fetch_row($marcassql)) {

            ?>
            <label>
              <input type="checkbox" name="filtromarca" id="checkbox-left" onchange="aplicarFiltro()"
                value="<?php echo $arraymarcas[0] ?>">
              <?php echo $arraymarcas[1] ?>
            </label>

            <?php
          }

          ?>


        </div>
      </div class="bloque1">


      <div class="bloque2" id="producto-contenedor">

        <?php

        if (mysqli_num_rows($sqlproductosfinal) <= 0) {
          ?>
          <p style="color: white; font-size: 20px;">No se ha encontrado ningún producto.</p>
          <?php
        } else {
          while ($arrayproductos = mysqli_fetch_row($sqlproductosfinal)) {


            ?>
            <div class="producto" onclick="redireccionar('<?php echo $arrayproductos[0] ?>')">
              <img id="productoimg" src="<?php echo $arrayproductos[1] ?>">
              <p><?php echo $arrayproductos[2] ?></p>
              <div class="precio-oferta">
                <p id="primero"><?php echo $arrayproductos[4] . " €" ?> </p>
                <p id="tachar"><?php echo $arrayproductos[8] . " €" ?></p>
                <p class="product-offer"><?php echo "- " . $arrayproductos[6] . "%" ?></p>
              </div>
              <div class="estrella">
                <?php

                $n = $arrayproductos[9];
                for ($i = 1; $i <= $n; $i++) {
                  ?>
                  <img id="estrella" src="img/star-on.png">
                  <?php
                }

                for ($n; $n < 5; $n++) {
                  ?>
                  <img id="estrella" src="img/star-off.png">
                  <?php
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
  <!--Footer -->

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
        <p> Infoshop &copy; 2023</p>
        <p><a href="contacto" class="politica">Contacto</a></p>
        <p><a href="privacidad" class="politica">Política de Privacidad</a></p>
      </div>
    </div>
  </footer>



</body>

</html>