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

if ($usuadm != 1) {
  header("Location: index");
  exit;
}

//if(empty($_GET)){
//  header("Location: index");
//}


$pedidosql = "SELECT * FROM pedidos WHERE USUCOD = '$usucod';";
$pedidoquery = mysqli_query($conexion, $pedidosql);

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
  <link rel="stylesheet" type="text/css" href="../css/estilo-panel-administrador.css">
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
  <script src="js/popup-admin.js"></script>


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
    <div class="dividir">

      <div class="bloque1">
        <a href="panel-administrador?productos">
          <div class="seccionproductos">Productos</div>
        </a>
        <a href="panel-administrador?tickets">
          <div class="secciontickets">Tickets</div>
        </a>
        <a href="panel-administrador?notificaciones">
          <div class="seccionnotificaciones">Notificaciones</div>
        </a>
        <a href="panel-administrador?basedatos">
          <div class="seccionbasedatos">Base de datos</div>
        </a>
      </div class="bloque1">

      <!-- Contenido de la pagina -->

      <div class="bloque2" id="producto-contenedor">
        <div id="contenido">
          <?php

          if (isset($_GET['productos'])) {
            ?>
            <!-- Contenido para productos -->
            <div id="popup1" class="popup">
              <div class="popup-contenido">
                <h3>AVISO</h3>
                <p>Va a eliminar un producto de la base de datos.<br> ¿Está seguro?</p>
                <div class="popup-botones">
                  <button onclick="eliminarProducto()">Sí</button>
                  <button onclick="cerrarPopup('popup1')">No</button>
                </div>
              </div>
            </div>

            <h1>Moderar productos</h1>
            <div class="acciones">
              <div class="añadir">
                <h2>Añadir un producto</h2>
                <form class="añadirform" action="backend/añadir-producto.php" method="POST" enctype="multipart/form-data">
                  <div class="fila">
                    <div class="columna">
                      <h4>Imagen del producto:</h4>
                      <input type="file" accept="image/*" id="inputFile" name="imagenproducto">
                    </div>
                  </div>
                  <div class="fila">
                    <div class="columna">
                      <h4>Nombre del producto:</h4>
                      <input type="text" name="nombreproducto">
                    </div>
                  </div>
                  <div class="fila">
                    <div class="columna">
                      <h4>Descripción del producto</h4>
                      <textarea name="descripcionproducto"></textarea>
                    </div>
                  </div>
                  <div class="fila" id="numeros">
                    <div class="columna">
                      <h4>Precio original del producto</h4>
                      <input type="number" name="precioproducto">
                    </div>
                    <div class="columna">
                      <h4>Oferta (En %)</h4>
                      <input type="number" name="ofertaproducto">
                    </div>
                    <div class="columna">
                      <h4>Inventario (Unidades)</h4>
                      <input type="number" name="inventarioproducto">
                    </div>
                  </div>
                  <div class="fila">
                    <div class="columna">
                      <h4>Marca del producto</h4>
                      <select name="marcaproducto">
                        <option value="1">Gigabyte</option>
                        <option value="2">MSI</option>
                        <option value="3">Nvidia</option>
                        <option value="4">AMD</option>
                        <option value="5">Kingston</option>
                        <option value="6">Logitech</option>
                        <option value="7">Corsair</option>
                        <option value="8">Mars Gaming</option>
                      </select>
                    </div>
                    <div class="columna">
                      <h4>Categoría del producto</h4>
                      <select name="categoriaproducto">
                        <option value="1">Placas Base</option>
                        <option value="2">GPUs</option>
                        <option value="3">Memorias RAM</option>
                        <option value="4">CPUs</option>
                        <option value="5">Fuentes de Alimentación</option>
                        <option value="6">Discos Duros</option>
                        <option value="7">Ratones</option>
                        <option value="8">Teclados</option>
                        <option value="9">Monitores</option>
                        <option value="10">Auriculares</option>
                      </select>
                    </div>
                  </div>
                  <br><br>
                  <div class="fila">
                    <button>Añadir el producto</button>
                  </div>
                </form>
              </div>
              <div class="editar">
                <h2>Editar / Eliminar un producto</h2>
                <div class="fila">
                  <form method="POST" action="" id="buscarForm">
                    <div class="columna">
                      <h5>Introduce el id del producto a modificar:</h5>
                      <input type="number" name="prodcod" id="idProducto">
                    </div>
                </div>
                <br><br>
                <button type="submit" name="buscar">Buscar</button>
                </form>
                <br><br>

                <?php
                if (isset($_POST['buscar'])) {

                  $prodcod = $_POST['prodcod'];
                  $productosql = "SELECT * FROM productos WHERE PRODCOD = '$prodcod';";
                  $productoquery = mysqli_query($conexion, $productosql);
                  $productoarray = mysqli_fetch_assoc($productoquery);

                  if (!empty($productoarray)) {
                    ?>


                    <form id="editarform" action="editar-producto" method="POST">
                      <div class="columna">
                        <h4>ID - <?php echo $productoarray['PRODCOD'] ?></h4>
                        <input type="text" name="prodcod2" id="prodcod2" style="display: none"
                          value="<?php echo $productoarray['PRODCOD'] ?>">
                      </div>
                      <div class="fila">

                        <div class="columna">
                          <img src="<?php echo $productoarray['PRODIMG'] ?>" id="imagenproductoform">
                          <input type="file" accept="image/*" name="imagenproducto2">
                        </div>
                      </div>
                      <div class="fila">
                        <div class="columna">

                          <h4>Nombre del producto:</h4>
                          <input type="text" name="nombreproducto2" value="<?php echo $productoarray['PRODNOM'] ?>">
                        </div>
                        <div class="columna">
                          <h4>Descripción del producto:</h4>
                          <input type="text" name="descripcionproducto2" value="<?php echo $productoarray['PRODDESC'] ?>">
                        </div>
                      </div>
                      <div class="fila" id="numeros">
                        <div class="columna">
                          <h4>Precio original del producto:</h4>
                          <input type="number" name="precioproducto2" value="<?php echo $productoarray['PRODPRECORI'] ?>">
                        </div>
                        <div class="columna">
                          <h4>Oferta (en %)</h4>
                          <input type="number" name="ofertaproducto2" value="<?php echo $productoarray['PRODOFE'] ?>">
                        </div>
                        <div class="columna">
                          <h4>Inventario de producto (unidades)</h4>
                          <input type="number" name="inventarioproducto2" value="<?php echo $productoarray['PRODINV'] ?>">
                        </div>
                      </div>
                      <div class="fila">
                        <div class="columna">
                          <h4>Marca del producto:</h4>
                          <input type="text" name="marcaproducto2" value="<?php echo $productoarray['PROCOD'] ?>">
                        </div>
                        <div class="columna">
                          <h4>Categoría del producto:</h4>
                          <input type="text" name="categoriaproducto2" value="<?php echo $productoarray['CATCOD'] ?>">
                        </div>
                      </div>
                      <br><br>
                      <div class="fila" id="filabotones">
                        <button type="submit" name="aplicar">Aplicar</button>
                        <button onclick="mostrarPopup('popup1')">Eliminar</button>
                    </form>

                    <?php

                  } else {
                    ?>
                    <p>No se ha encontrado ningún producto con esa ID.</p>
                    <?php
                  }
                }
                ?>
              </div>
            </div>


            <!-- Fin de contenido para productos -->
            <?php
          } elseif (isset($_GET['tickets'])) {
            ?>
            <!-- Contenido para tickets -->
            <h1>Tickets</h1>
            <form action="" method="POST">
              <h3>Buscar ticket por id:</h3>
              <div class="columna">
                <input type="text" name="tickid" id="tickid">
                <br>
                <button type="submit" name="buscar2">Buscar</button>
              </div>
            </form>
            <br><br>

            <?php

            if (isset($_POST['buscar2'])) {

              $tickid = $_POST['tickid'];
              $ticketsql = "SELECT * FROM tickets WHERE TICKID = '$tickid';";
              $ticketsquery = mysqli_query($conexion, $ticketsql);

              if (mysqli_num_rows($ticketsquery) != 0) {
                while ($ticketsarray = mysqli_fetch_assoc($ticketsquery)) {


                  ?>

                  <div class="ticket">
                    <div class="credenciales">
                      <p>Ticket #<?php echo $ticketsarray['TICKID']; ?></p>
                      <p id="fechaticket"><?php echo $ticketsarray['TICKFEC']; ?></p>
                    </div>
                    <div class="contenido-ticket">
                      <p id="contenidoticket"><?php echo '"' . $ticketsarray['TICKCONT'] . '"' ?></p>
                    </div>
                    <div class="estado">
                      <p>Estado: <?php if ($ticketsarray['TICKEST'] == "Abierto") {
                        ?>
                        <p style="color:lightgreen"><?php echo $ticketsarray['TICKEST'] ?></p>
                        <?php
                      } else {
                        ?>
                        <p style="color: red"><?php echo $ticketsarray['TICKEST'] ?></p>
                        <?php
                      }
                      ?>
                      </p>
                      <form class="verticket" action="ticket" method="POST">
                        <button name="ticketidboton" value="<?php echo $ticketsarray['TICKID'] ?>">Ver ticket</button>
                      </form>
                      <?php

                      if ($ticketsarray['TICKEST'] == "Cerrado") {
                      } else {
                        ?>
                        <form class="cerrarticket" action="cerrar-ticket" method="POST">
                          <input type="text" name="ticketidcerrarticket" value="<?php echo $tickid ?>" style="display: none">
                          <input type="text" name="direccion" value="panel-administrador?tickets" style="display: none">
                          <button name="cerrar" value="cerrar">Cerrar ticket</button>
                        </form>

                        <?php
                      }
                      ?>
                    </div>
                  </div>


                  <?php

                }



              } else {
                ?>
                <p>No se ha encontrado ningún ticket con esa ID.</p>

                <?php
              }
            }
            ?>

            <!-- Fin de contenido para tickets -->
            <?php
          } elseif (isset($_GET['notificaciones'])) {


            $notificacionesql = "SELECT * FROM paneladmin ORDER BY ADMCOD DESC;";
            $notificacionesquery = mysqli_query($conexion, $notificacionesql);

            ?>

            <!-- Contenido para notificaciones -->

            <h1 id="h1notificaciones">Notificaciones</h1>
            <?php
            $i = 1;
            while ($notificacionesarray = mysqli_fetch_assoc($notificacionesquery)) {
              $tipos = array(
                '1' => 'Devolución',
                '2' => 'Reemplazo',
                '3' => 'Ticket usuario',
                '4' => 'Reseña reportada'
              );
              $notcod = $notificacionesarray['NOTCOD'];
              $tipo = $tipos[$notcod];
              $instruccionessql = "SELECT * FROM notificaciones WHERE NOTCOD = '$notcod';";
              $instruccionesquery = mysqli_query($conexion, $instruccionessql);
              $instruccionesarray = mysqli_fetch_assoc($instruccionesquery);
              $instrucciones = $instruccionesarray['NOTDESC'];
              ?>
              <div id="popup<?php echo $notificacionesarray['ADMCOD'] ?>" class="popup">
                <div class="popup-contenido">
                  <h3>AVISO</h3>
                  <p>Asegúrese de haber tomado las acciones necesarias.<br> ¿Quiere continuar?</p>
                  <div class="popup-botones">
                    <button onclick="limpiarNotificacion(<?php echo $notificacionesarray['ADMCOD'] ?>)">Sí</button>
                    <button onclick="cerrarPopup('popup<?php echo $notificacionesarray['ADMCOD'] ?>')">No</button>
                  </div>
                </div>
              </div>
              <div class="notificacion">
                <input type="text" style="display:none" id="notcod-input<?php echo $notificacionesarray['ADMCOD'] ?>"
                  name="notcod" value="<?php echo $notificacionesarray['ADMCOD'] ?>">
                <img src="img/bell.png">
                <div class="columna2">
                  <h3 class="notificacion1">ID de Notificación:</h3>
                  <h3 class="notificacion2"><?php echo $notificacionesarray['ADMCOD'] ?></h3>
                </div>
                <div class="columna2">
                  <h3 class="notificacion1">Tipo de notificación:</h3>
                  <h3 class="notificacion2"><?php echo $tipo ?></h3>
                </div>
                <div class="columna2">
                  <h3 class="notificacion1">Acción a realizar:</h3>
                  <h3 class="notificacion2"><?php echo $instrucciones ?></h3>
                </div>
                <div class="columna2">
                  <h3 class="notificacion1">Contenido:</h3>
                  <h3 class="notificacion2"><?php echo $notificacionesarray['ADMCONT'] ?></h3>
                </div>
                <button onclick="mostrarPopup('popup<?php echo $notificacionesarray['ADMCOD'] ?>')">Limpiar</button>

              </div>


              <?php
              $i++;
            }

            ?>


            <!-- Fin de contenido para notificaciones -->
            <?php
          } elseif (isset($_GET['basedatos'])) {
            ?>
            <!-- Contenido para base de datos -->

            <h1 id="h1base">Base de datos</h1>
            <div class="dividir2">
              <div class="exportar">
                <h3>Exportar base de datos en formato PDF</h3>
                <form action="backend/exportar-pdf.php" method="POST">
                  <button><img src="img/exportar.png"></button>
                </form>
              </div>
              <div class="backup">
                <h3>Realizar backup manual de base de datos SQL</h3>
                <form action="backend/backup.php" method="POST">
                  <button><img src="img/backup.png"></button>
                </form>
              </div>
            </div>

            <!-- Fin de contenido para base de datos -->
            <?php
          }
          ?>
        </div>
      </div>
      <!-- Fin de contenido de la pagina-->
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