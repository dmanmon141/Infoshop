<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

$id = $_GET['id'];


if (isset($_SESSION['usucod'])) {
  $ususesion = $_SESSION['usucod'];
  $comentariousuariocheck = "SELECT * FROM reseñas WHERE PRODCOD = '$id' AND USUCOD = '$ususesion'";
  $comentariousuariocheckresultado = mysqli_query($conexion, $comentariousuariocheck);
  $comentariocheck = "SELECT * FROM reseñas WHERE PRODCOD = '$id' AND USUCOD != '$ususesion' ORDER BY RESFEC DESC";
  $comentariocheckresultado = mysqli_query($conexion, $comentariocheck);
} else {

}

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



$producto = "SELECT * FROM productos WHERE PRODCOD = '$id'";
$productoresultado = mysqli_query($conexion, $producto);
$array = mysqli_fetch_row($productoresultado);

$proveedor = "SELECT * FROM proveedores WHERE PROCOD = '$array[11]';";
$proveedoresultado = mysqli_query($conexion, $proveedor);
$marcasql = mysqli_fetch_assoc($proveedoresultado);
$marca = $marcasql['PRONOM'];
$marcacod = $marcasql['PROCOD'];

$categoriaquery = "SELECT * FROM categorias WHERE CATCOD = '$array[10]';";
$categoriasql = mysqli_query($conexion, $categoriaquery);
$categoriaresultado = mysqli_fetch_assoc($categoriasql);
$categoria = $categoriaresultado['CATNOM'];
$categoriacod = $categoriaresultado['CATCOD'];

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



$imagen = $array[1];
$titulo = $array[2];
$descripcion = $array[3];
$precio = $array[4];
$inventario = $array[5];
$oferta = $array[6];
$preciooriginal = $array[8];
$valoracionsql = $array[9];

if ($array[5] == 0) {
  $stock = 0;
} else {
  $stock = 1;
}

$valoracion = number_format($valoracionsql, 2);



$comentariocheck2 = "SELECT * FROM reseñas WHERE PRODCOD = '$id' ORDER BY RESFEC DESC";
$comentariocheckresultado2 = mysqli_query($conexion, $comentariocheck2);



?>


<!DOCTYPE html>
<html>

<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="../css/estilo-misc.css">
  <link rel="stylesheet" type="text/css" href="../css/estilo-producto.css">
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
  <script src="js/redireccionar-checkout.js"></script>
  <script src="js/rating.js"></script>
  <script src="js/eliminar-rating.js"></script>
  <script src="js/editar-rating.js"></script>
  <script src="js/filtros.js"></script>
  <script src="js/carrito-checkout.js"></script>
  <script src="js/reportar.js"></script>

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


      <div id="popup" class="popup">
        <div class="popup-contenido">
          <p>¿Estás seguro de que quieres eliminar tu reseña?</p>
          <div class="popup-botones">
            <button onclick="eliminarReseña()">Sí</button>
            <button onclick="cerrarPopup()">No</button>
          </div>
        </div>
      </div>
      <div id="popup3" class="popup">
        <div class="popup-contenido">
          <h2>¿Está seguro de que quiere reportar esta reseña?</h2>
          <div class="popup-botones">
            <button onclick="reportar()">Sí</button>
            <button onclick="cerrarPopup3()">No</button>
          </div>
        </div>
      </div>
      <div class="product">
        <div class="reseñas">
          <h1 class="product-title"><?php echo $titulo ?></h1>
          <img src="<?php echo $imagen ?>" alt="Producto" class="product-image">
          <h3 id="primeroh3">Descripción</h3>
          <p id="descripcion"><?php echo $descripcion ?></p>

          <h3>Reseñas</h3>
          <?php

          if (isset($_SESSION['usucod'])) {


            if (mysqli_num_rows($comentariousuariocheckresultado) > 0) {
              $array2 = mysqli_fetch_row($comentariousuariocheckresultado);
              ?>





              <div id="popup2" class="popup2">
                <div class="popup-contenido">
                  <div class="credenciales2">
                    <img src="<?php echo $usuimg ?>">
                    <p id="usureseña2"> Tú </p>
                    <p id="fecha"> <?php echo $array2[3] ?> </p>
                  </div>
                  <form id="resena-form2" onsubmit="editarReseña(event)" method="POST" action="">
                    <textarea name="comentario" id="comentario-input2"><?php echo $array2[2] ?></textarea>
                    <select name="valoracion" id="valoracion-input2" style="display: none;">
                      <option value="1">1 estrellas</option>
                      <option value="2">2 estrellas</option>
                      <option value="3">3 estrellas</option>
                      <option value="4">4 estrellas</option>
                      <option value="5">5 estrellas</option>
                    </select>
                    <div id="ratings">
                      <ul class="rating">
                        <li class="star" data-value="1"><img src="img/star-off.png" alt="Estrella"></li>
                        <li class="star" data-value="2"><img src="img/star-off.png" alt="Estrella"></li>
                        <li class="star" data-value="3"><img src="img/star-off.png" alt="Estrella"></li>
                        <li class="star" data-value="4"><img src="img/star-off.png" alt="Estrella"></li>
                        <li class="star" data-value="5"><img src="img/star-off.png" alt="Estrella"></li>
                      </ul>
                      <input type="hidden" id="prodcod" value="<?php echo $id ?>">
                    </div>
                    <div id="mensaje2"></div>
                  </form>



                  <div class="popup-botones">
                    <button onclick="submitForm()">Publicar</button>
                    <button onclick="cerrarPopup2()">Cancelar</button>
                  </div>
                </div>
              </div>
              </form>
              <div class="reseña">
                <div class="credenciales">
                  <img src="<?php echo $usuimg ?>">
                  <p id="usureseña"> Tú </p>
                  <?php

                  $n = $array2[1];
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


                  <p id="fecha"> <?php echo $array2[3] ?> </p>
                </div>

                <p id="contenidoreseña"> <?php echo '"' . $array2[2] . '"' ?> </p>
                <div class="reseñabotones">
                  <a onclick="mostrarPopup2()" style="margin-right: 20px;">Editar</a>
                  <a onclick="mostrarPopup()">Eliminar</a>
                </div>

              </div>

              <?php

            } else {

              ?>

              <form id="resena-form" onsubmit="enviarFormulario(event)" method="POST" action="">
                <textarea name="comentario" id="comentario-input" placeholder="Escribe tu reseña"></textarea>
                <select name="valoracion" id="valoracion-input" style="display: none;">
                  <option value="1">1 estrellas</option>
                  <option value="2">2 estrellas</option>
                  <option value="3">3 estrellas</option>
                  <option value="4">4 estrellas</option>
                  <option value="5">5 estrellas</option>
                </select>
                <div id="ratings">
                  <ul class="rating">
                    <li class="star" data-value="1"><img src="img/star-off.png" alt="Estrella"></li>
                    <li class="star" data-value="2"><img src="img/star-off.png" alt="Estrella"></li>
                    <li class="star" data-value="3"><img src="img/star-off.png" alt="Estrella"></li>
                    <li class="star" data-value="4"><img src="img/star-off.png" alt="Estrella"></li>
                    <li class="star" data-value="5"><img src="img/star-off.png" alt="Estrella"></li>
                  </ul>
                  <input type="hidden" id="prodcod" value="<?php echo $id ?>">
                  <input type="submit" value="Publicar">
                </div>
                <div id="mensaje"></div>
              </form>

              <?php
            }
          } else {

            ?>

            <p id="loginreminder">Inicia sesión para poder publicar una reseña sobre el producto.</p>

            <?php
          }

          if (isset($ususesion)) {

            while ($array3 = mysqli_fetch_row($comentariocheckresultado)) {
              $usunom2query = "SELECT * from usuarios WHERE USUCOD = '$array3[4]';";
              $usunom2sql = mysqli_query($conexion, $usunom2query);
              $usunom2final = mysqli_fetch_assoc($usunom2sql);
              $usunom2 = $usunom2final['USUNOM'];
              $usuimg2 = $usunom2final['USUIMG'];
              ?>


              <div class="reseña">
                <div class="credenciales">
                  <img src="<?php echo $usuimg2 ?>">
                  <p id="usureseña"> <?php echo $usunom2 ?> </p>
                  <?php

                  $n = $array3[1];
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


                  <p id="fecha"> <?php echo $array3[3] ?> </p>
                </div>

                <p id="contenidoreseña"> <?php echo '"' . $array3[2] . '"' ?> </p>
                <input type="text" id="rescod" value="<?php echo $array3[0] ?>" style="display: none">
                <div class="reportar"><img src="img/report.png"><a onclick="mostrarPopup3()" id="reportar">Reportar</a>
                </div>
              </div>

              <?php
            }
          } else {
            while ($array4 = mysqli_fetch_row($comentariocheckresultado2)) {
              $usunom3query = "SELECT * from usuarios WHERE USUCOD = '$array4[4]';";
              $usunom3sql = mysqli_query($conexion, $usunom3query);
              $usunom3final = mysqli_fetch_assoc($usunom3sql);
              $usunom3 = $usunom3final['USUNOM'];
              $usuimg3 = $usunom3final['USUIMG'];
              ?>


              <div class="reseña">
                <div class="credenciales">
                  <img src="<?php echo $usuimg3 ?>">
                  <p id="usureseña"> <?php echo $usunom3 ?> </p>
                  <?php

                  $n = $array4[1];
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


                  <p id="fecha"> <?php echo $array4[3] ?> </p>
                </div>

                <p id="contenidoreseña"> <?php echo '"' . $array4[2] . '"' ?> </p>
                <input type="text" id="rescod" value="<?php echo $array4[0] ?>" style="display: none">
                <div class="reportar"><img src="img/report.png"><a onclick="mostrarPopup3()" id="reportar">Reportar</a>
                </div>
              </div>

              <?php



            }
          }



          ?>
        </div>
        <div class="column">
          <div class="product-details">
            <div class="precio-oferta">
              <p class="product-price"><?php echo $precio . " €" ?></p>
              <p class="product-price-original"><?php echo $preciooriginal . " €" ?></p>
              <p class="product-offer"><?php echo "- " . $oferta . "%" ?></p>
            </div>
            <div class="separar">
              <p><?php echo $valoracion ?>/5 <span style="color: gold">★</span></p>
              <p class="product-stock">
                <?php if ($stock == 1) {
                  echo "✅ En stock" . " (" . $inventario . ")";
                } else {
                  echo "Fuera de stock";
                } ?>
              </p>
            </div>




            <div class="bloque2">
              <p class="info">🚚 Envío: Gratis</p>
              <p>📅 Entrega estimada: 2-3 días</p>
            </div>
            <div class="botones">
              <button class="product-btn" onclick="redireccionarCheckout('<?php echo $id ?>')">Comprar ahora</button>
              <button class="product-btn"
                onclick="addToCart('<?php echo $titulo ?>', '<?php echo $imagen ?>', '<?php echo $precio . '€' ?>')">Añadir
                al carrito</button>
            </div>
            <div class="bloque1">
              Etiquetas:
              <a href="buscar?categorias=<?php echo $categoriacod ?>"><?php echo $categoria ?></a>
              <a href="buscar?marcas=<?php echo $marcacod ?>" id="margen"><?php echo $marca ?></a>
            </div>
          </div>
          <div class="customercare">
            <img src="img/customercare.png" class="picture">
            <p>¡Hola! ¿Tienes algún problema? <a href="enviar-ticket">Habla con un técnico</a></p>
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

<?php
echo '<span id="idProducto" data-id="' . $id . '"></span>';
if (isset($_SESSION['usucod'])) {
  echo '<span id="idUsuario" data-id="' . $ususesion . '"></span>';
}
?>