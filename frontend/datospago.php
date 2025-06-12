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

$pedidosql = "SELECT * FROM pedidos WHERE USUCOD = '$usucod';";
$pedidoquery = mysqli_query($conexion, $pedidosql);

$pedidos = mysqli_num_rows($pedidoquery);

$reseñasql = "SELECT * FROM reseñas WHERE USUCOD = '$usucod';";
$reseñaquery = mysqli_query($conexion, $reseñasql);
$reseñas = mysqli_num_rows($reseñaquery);


?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-datospago.css">
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
  <script src="js/cambiar-datos-pago.js"></script>

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

      <div class="bloque1">
        <a href="perfil">
          <div class="secciondatos">Perfil</div>
        </a>
        <div class="seccionconfiguracion">
          <a href="datospago">
            Datos de pago
          </a>
        </div>

        <a href="historial">
          <div class="seccionhistorial">Historial</div>
        </a>
      </div class="bloque1">


      <div class="bloque2" id="producto-contenedor">
        <div id="contenido">
          <div class="perfil">
            <div class="perfil-imagen"><img src="<?php echo $usuimg ?>"></div>
            <div class="perfil-nombre">
              <h2><?php echo $usunom . " " . $usuape ?></h2>
            </div>
          </div>
          <div class="datosguardados">
            <?php
            $usucod = $_SESSION['usucod'];
            $datosguardadosql = "SELECT * FROM datos WHERE USUCOD='$usucod';";
            $datosguardadosresultado = mysqli_query($conexion, $datosguardadosql);
            $i = 1;

            if (mysqli_num_rows($datosguardadosresultado) != 0) {
              while ($arraydatos = mysqli_fetch_row($datosguardadosresultado)) {
                ?>
                <div id="<?php echo $i ?>" class="popup popupestilo">
                  <div class="popup-contenido">
                    <h3>AVISO</h3>
                    <p>Va a eliminar uno de sus datos guardados.<br> ¿Quiere continuar?</p>
                    <div class="popup-botones">
                      <button onclick="Eliminar(<?php echo $i ?>)">Sí</button>
                      <button onclick="cerrarPopup(<?php echo $i ?>)">No</button>
                    </div>
                  </div>
                </div>
                <?php

                $ultimosDos = substr($arraydatos[3], -2);
                $asteriscos = str_repeat("*", strlen($arraydatos[3]) - 2);

                $tarjeta = $asteriscos . $ultimosDos;

                ?>
                <div class="columna">
                  <img src="img/tarjeta.png" class="tarjetaimg">
                  <h4><?php echo "Tarjeta " . $tarjeta ?></h4>
                </div>
                <div class="datocontainer">
                  <div class="dato">
                    <form class="pago">
                      <h4>1. Método de pago</h4>
                      <div class="organizar2">
                        <p>Número de tarjeta</p>
                        <input type="text" maxlength="16" class="disabled" minlength="16" id="tarjeta-input<?php echo $i ?>"
                          value="************" readonly></input>
                      </div>
                      <div class="filagap">
                        <div class="organizar2">
                          <p>Fecha de caducidad</p>
                          <input type="text" maxlength="5" class="disabled" id="caducidad-input<?php echo $i ?>"
                            value="<?php echo $arraydatos[4] ?>" readonly></input>
                        </div>
                        <div class="organizar2">
                          <p>Código de seguridad</p>
                          <input type="number" maxlength="3" class="disabled" id="codigoseg-input<?php echo $i ?>"
                            value="<?php echo $arraydatos[5] ?>" readonly></input>
                        </div>
                      </div>
                    </form>



                    <form class="direccion">
                      <h4>2. Dirección</h4>
                      <div class="organizar">
                        <p>Nombre</p>
                        <p>Apellidos</p>
                        <p>Ciudad</p>
                      </div>
                      <div class="tarjetahidden" id="tarjeta-hidden<?php echo $i ?>" style="display: none"
                        data-value="<?php echo $arraydatos[3] ?>"></div>
                      <div class="organizar">
                        <input type="text" class="disabled" id="nombre-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[1] ?>" value="<?php echo $arraydatos[1] ?>"
                          readonly></input>
                        <input type="text" class="disabled" id="apellidos-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[2] ?>" value="<?php echo $arraydatos[2] ?>"
                          readonly></input>
                        <input type="text" class="disabled" id="ciudad-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[6] ?>" value="<?php echo $arraydatos[6] ?>"
                          readonly></input>
                      </div>
                      <div class="organizar">
                        <p>Dirección</p>
                        <p>Código Postal</p>
                      </div>
                      <div class="organizar">
                        <input type="text" class="disabled" id="direccion-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[7] ?>" value="<?php echo $arraydatos[7] ?>"
                          readonly></input>
                        <input type="number" class="disabled" maxlength="5" id="codigopost-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[8] ?>" value="<?php echo $arraydatos[8] ?>"
                          readonly></input>
                      </div>
                      <div class="organizar">
                        <p>País</p>
                        <p>Teléfono</p>
                      </div>
                      <div class="organizar">
                        <input type="text" class="disabled" id="pais-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[9] ?>" value="<?php echo $arraydatos[9] ?>"
                          readonly></input>
                        <input type="number" class="disabled" id="telefono-input<?php echo $i ?>"
                          data-original-value="<?php echo $arraydatos[10] ?>" value="<?php echo $arraydatos[10] ?>"
                          readonly></input>
                      </div>
                      <button id="aplicarcambios<?php echo $i ?>" class="botonfinal"
                        onclick="cambiarDatos(<?php echo $i ?>)" style="display: none">Aplicar cambios</button>
                    </form>

                  </div>
                  <div class="fila">
                    <button id="editar<?php echo $i ?>" onclick="permitirEditar(<?php echo $i ?>)"
                      class="botonfinal">Editar</button>
                    <button id="eliminar<?php echo $i ?>" onclick="mostrarPopup(<?php echo $i ?>)"
                      class="botonfinal">Eliminar</button>
                  </div>
                  <div id="mensaje"></div>
                </div>
              </div>
              <?php
              $i++;
              }
            } else {
              ?>

            <h4>No se han guardado datos de pago / direcciones aún.</h4>
            <?php
            }
            ?>

        </div>
      </div>
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

</body>

</html>