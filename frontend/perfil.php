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

$ticketsql = "SELECT * FROM tickets WHERE USUCOD = '$usucod' ORDER BY TICKFEC DESC LIMIT 1;";
$ticketquery = mysqli_query($conexion, $ticketsql);

$pedidos = mysqli_num_rows($pedidoquery);

$reseñasql = "SELECT * FROM reseñas WHERE USUCOD = '$usucod';";
$reseñaquery = mysqli_query($conexion, $reseñasql);
$reseñas = mysqli_num_rows($reseñaquery);

$newslettersql = "SELECT * FROM usuarios WHERE USUNEWS = 1 AND USUCOD = '$usucod';";
$newsletterquery = mysqli_query($conexion, $newslettersql);
$newsletter = mysqli_num_rows($newsletterquery);
?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-perfil.css">
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
  <script src="js/newsletter.js"></script>
  <script src="js/actualizar-imagen.js"></script>


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

        <div class="secciondatos">

          <a href="perfil">Perfil</a>
        </div>

        <a href="datospago">
          <div class="seccionconfiguracion">Datos de pago</div>
        </a>
        <a href="historial">
          <div class="seccionhistorial">Historial</div>
        </a>
      </div class="bloque1">


      <div class="bloque2" id="producto-contenedor">
        <div id="contenido">
          <div class="perfil">
            <div class="perfil-imagen">
              <img class="imagen-original" id="imagen" src="<?php echo $usuimg ?>">
              <img class="imagen-hover" onclick="abrirInputFile()" src="img/añadir.png">
            </div>
            <form action="subir-imagen" method="POST" enctype="multipart/form-data">
              <input type="file" id="inputFile" accept="image/*" style="display: none" name="imagen">
              <input type="submit" id="aplicarimagen" value="Aplicar">
            </form>
            <div class="perfil-nombre">
              <h2><?php echo $usunom . " " . $usuape ?></h2>
            </div>
          </div>
          <div class="datosusuario">
            <div class="fila">
              <img src="img/pdata.png" class="icon">
              <h2>Datos personales</h2>
            </div>
            <div class="personales">
              <form id="datospersonales">
                <div class="separar">
                  <div class="filagap">
                    <div class="columna">
                      <h5>Nombre</h5>
                      <div class="input"><input type="text" id="nombre" class="disabled" name="nombre"
                          value="<?php echo $usunom ?>" readonly><img onclick="permitirEditar('nombre')" class="editar"
                          src="img/editar.png"></div>
                    </div>
                    <div class="columna">
                      <h5>Apellidos</h5>
                      <div class="input"><input type="text" id="apellidos" class="disabled" name="apellidos"
                          value="<?php echo $usuape ?>" readonly><img onclick="permitirEditar('apellidos')"
                          class="editar" src="img/editar.png"></div>
                    </div>

                  </div>
                  <div class="filagap">
                    <div class="estadisticas">
                      <h2>Productos comprados:</h2>
                      <p><?php echo $pedidos ?></p>
                    </div>
                  </div>
                </div>
                <div class="separar">
                  <div class="filagap">
                    <div class="columna">
                      <h5>Dirección de correo electrónico</h5>
                      <div class="input"><input type="text" id="correo" class="disabled" name="correo"
                          value="<?php echo $usucor ?>" readonly><img onclick="permitirEditar('correo')" class="editar"
                          src="img/editar.png"></div>
                    </div>
                    <div class="columna">
                      <h5>Contraseña</h5>
                      <div class="input" style="margin-bottom: 20px"><input type="text" id="contraseña" class="disabled"
                          name="contraseña" value="*******************" readonly><img
                          onclick="permitirEditar('contraseña')" class="editar" src="img/editar.png"></div>
                    </div>
                  </div>
                  <div class="filagap">
                    <div class="estadisticas">
                      <h2>Reseñas:</h2>
                      <p><?php echo $reseñas ?></p>
                    </div>
                  </div>
                </div>





                <?php

                if ($newsletter > 0) {
                  ?>
                  <div class="checkbox"><input type="checkbox" id="suscripcion" name="suscripcion" checked
                      onclick="checkDatos()">
                    <p style="font-size: 11px;margin-left: 0px;">Quiero recibir correos sobre ofertas, facturas y pedidos
                    </p>
                  </div>
                  <?php
                } else {
                  ?>
                  <div class="checkbox"><input type="checkbox" id="suscripcion" name="suscripcion" onclick="checkDatos()">
                    <p style="font-size: 11px;margin-left: 0px;">Quiero recibir correos sobre ofertas, facturas y pedidos
                    </p>
                  </div>
                  <?php
                }
                ?>
                <button id="aplicar" onclick="mostrarPopup(event)">Aplicar cambios</button>
                <div id="mensaje"></div>
              </form>
            </div>

          </div>
          <div class="datostickets">
            <div class="fila">
              <img src="img/support.png" class="icon">
              <h2>Soporte al cliente</h2>
              <a href="perfil-tickets" id="historialBtn"><img src="img/history-icon.png">Historial de tickets</a>
            </div>
            <div class="customercare">
                <img src="img/customercare.png" class="picture">
                <p>¡Hola! ¿Tienes algún problema? Estamos aquí para ayudarte. <a href="enviar-ticket">Hablar con un técnico</a></p>
            </div>
            <div class="historial">
                <h2>Ticket más reciente</h2>
                 <?php
                    if(mysqli_num_rows($ticketquery) == 0){
                    ?>
                    <p>No ha creado ningún ticket aún.</p>

                    <?php
                    
                    }else{
                    $ticketarray = mysqli_fetch_assoc($ticketquery);
                    $ticketid = $ticketarray['TICKID'];
                    $ticketcontenido = $ticketarray['TICKCONT'];
                    $ticketestado = $ticketarray['TICKEST'];
                    $ticketfecha = $ticketarray['TICKFEC'];
                    ?>
                    <div class="ticket">
                    <div class="credenciales">
                            <input type="text" id="ticketid" value="<?php echo $ticketid ?>" style="display: none">
                            <p id="ticketid">Ticket con ID <?php echo $ticketid ?> </p>
                            <p id="fecha"> <?php echo $ticketfecha ?> </p>
                        </div>
                        <p id="contenidoreseña"> <?php echo '"' . $ticketcontenido . '"' ?> </p>
                        <div class="botonesticket">
                            <p>Estado: <?php if($ticketestado == "Abierto"){
                                ?>
                                <p style="color:#00FF00"><?php echo $ticketestado ?></p>
                                <?php
                            }else{
                                ?>
                                <p style="color: red"><?php echo $ticketestado ?></p>
                                <?php
                                } 
                                ?>
                            </p>
                            <form class="verticket" action="ticket" method="POST">
                            <button name="ticketidboton" value="<?php echo $ticketid ?>">Ver ticket</button>
                            </form>
                            <?php
                            if($ticketestado == "Abierto"){
                            ?>
                            <button onclick="mostrarPopup('popup1')">Eliminar</button>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                   
                }
                    ?>
            </div>
            
              


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