<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();


if (!isset($_SESSION['usucod'])) {
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

if (isset($_POST['ticketidboton'])) {
  $ticketid = $_POST['ticketidboton'];
} else {
  $ticketid = $_SESSION['ticketid'];
}

$ticketsql = "SELECT * FROM tickets WHERE TICKID = '$ticketid';";
$ticketquery = mysqli_query($conexion, $ticketsql);
$ticketarray = mysqli_fetch_assoc($ticketquery);
$usucodticket = $ticketarray['USUCOD'];
$ticketcontenido = $ticketarray['TICKCONT'];
$ticketfechahora = $ticketarray['TICKFEC'];
$datetime = new DateTime($ticketfechahora);
$ticketfecha = $datetime->format('H:i:s');
$ticketestado = $ticketarray['TICKEST'];

$usuarioticketsql = "SELECT * FROM usuarios WHERE USUCOD = '$usucodticket';";
$usuarioticketquery = mysqli_query($conexion, $usuarioticketsql);
$usuarioticketarray = mysqli_fetch_assoc($usuarioticketquery);
$usunomticket = $usuarioticketarray['USUNOM'];
$usuimgticket = $usuarioticketarray['USUIMG'];

?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-ticket.css">
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
    <div class="dividir">
      <div class="fila">
        <h1>Ticket #<?php echo $ticketid ?></h1>
        <?php

        if ($usuadm == 1) {
          if ($ticketestado == "Abierto") {
            ?>
            <form class="cerrar-ticket" action="backend/cerrar-ticket.php" method="POST">
              <button id="cerrarticket">Cerrar ticket</button>
              <input name="ticketidcerrarticket" style="display: none" value="<?php echo $ticketid ?>">
            </form>
            <?php
          }
        }
        ?>

        <h2 id="primero">Estado: <?php if ($ticketestado == "Abierto") {
          ?>
            <h2 id="segundo" style="color:lightgreen"><?php echo $ticketestado ?></h2>
            <?php
        } else {
          ?>
            <h2 id="segundo" style="color: red"><?php echo $ticketestado ?></h2>
            <?php
        }
        ?>
        </h2>

      </div>

      <div class="bloque-error">

        <?php

        $mensajesql = "SELECT * FROM mensajes WHERE TICKID = '$ticketid' ORDER BY MENFEC ASC";
        $mensajequery = mysqli_query($conexion, $mensajesql);

        $totalMensajes = mysqli_num_rows($mensajequery);
        if ($usuadm == 1) {
          $esAdmin = true;

        } else {
          $esAdmin = false;
        }

        $ultimoMensaje = null;
        $contador = 0;



        ?>

        <div class="mensajeinicial">
          <div class="credenciales">
            <div class="crgroup1"><img src="<?php echo $usuimgticket ?>">
              <p><?php echo $usunomticket ?></p>
            </div>
            <p id="fecha"><?php echo $ticketfecha ?></p>
          </div>
          <div class="contenido">
            <p><?php echo $ticketcontenido ?></p>
          </div>
        </div>



        <?php

        if ($totalMensajes === 0 && $esAdmin) {

          ?>
          <form class="respondermensaje usuario" action="backend/responder-mensaje.php" method="POST">
            <textarea id="respuesta-contenido" name="respuesta-contenido"></textarea>
            <input name="ticketidmensaje" value="<?php echo $ticketid ?>" style="display: none">
            <button id="buttonreply" type="submit">Responder</button>
          </form>
          <?php

        }

        while ($mensaje = mysqli_fetch_assoc($mensajequery)) {
          $contador++;


          // Verificar si es el último mensaje
        
          $usuariomensaje = $mensaje['USUCOD'];




          $verificarsql = "SELECT * FROM usuarios WHERE USUCOD = '$usuariomensaje';";
          $verificarquery = mysqli_query($conexion, $verificarsql);
          $verificararray = mysqli_fetch_assoc($verificarquery);
          $esAdminMensaje = $verificararray['USUADM'];
          if ($esAdminMensaje == 1) {
            $tipoMensaje = "administrador";
          } else {
            $tipoMensaje = "usuario";
          }
          $usuimgmensaje = $verificararray['USUIMG'];
          $usunommensaje = $verificararray['USUNOM'];
          $fechamensaje = $mensaje['MENFEC'];
          $contenidomensaje = $mensaje['MENCONT'];

          // Determinar la clase CSS para el mensaje (izquierda o derecha)
          $claseMensaje = $tipoMensaje === "usuario" ? 'mensaje-usuario' : 'mensaje-administrador';

          // Mostrar el mensaje con la clase CSS correspondiente
          ?>
          <div class="<?php echo $claseMensaje ?>">
            <div class="credenciales">
              <div class="crgroup1">
                <img src=<?php echo $usuimgmensaje ?>>
                <p><?php echo $usunommensaje ?></p>
              </div>

              <p id="fecha"><?php echo $fechamensaje ?></p>
            </div>
            <div class="contenido">
              <p><?php echo $contenidomensaje ?></p>

            </div>
          </div>
          <?php
          $ultimoMensaje = $tipoMensaje;


        }
        if ($ultimoMensaje) {
          $esUltimoUsuario = $tipoMensaje === 'usuario';
          $puedeResponder = ($esAdmin && $esUltimoUsuario) || (!$esAdmin && !$esUltimoUsuario);


          if ($ticketestado != "Abierto") {
            ?>
            <h3 style="color: white;text-align: center">Este ticket ha sido marcado como cerrado por un administrador del
              sistema.</h3>
            <?php

          } else {
            if ($puedeResponder) {
              ?>
              <form class="respondermensaje <?php echo $ultimoMensaje ?>" action="backend/responder-mensaje.php"
                method="POST">
                <textarea id="respuesta-contenido" name="respuesta-contenido"></textarea>
                <input name="ticketidmensaje" value="<?php echo $ticketid ?>" style="display: none">
                <button id="buttonreply" type="submit"><img src="img/send.png" class="icon"></button>
              </form>
              <?php
            }
          }
        }


        ?>



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