<?php

$servidor= "localhost";
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
  $usucodsesion =  mysqli_fetch_assoc($usucodsql);
  $_SESSION['usucod'] = $usucodsesion['USUCOD'];

  

}elseif(!isset($_SESSION['usucod'])){
  session_destroy();
}

if(isset($_SESSION['usucod'])){



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
  <link rel="stylesheet" type="text/css" href="estilo-checkout-carrito.css">
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
<script src="js/popupaviso.js"></script>
<script src="js/carrito-checkout-carga.js"></script>
<script src="js/usar-datos.js"></script>


<div id="overlay"></div>

<div contenedor>
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
            <div id="myDropdownTienda" class="dropdown-content">
              
            <?php
            $categorias = "SELECT * FROM categorias";
            $categoriasql= mysqli_query($conexion, $categorias);

            while($arraycat = mysqli_fetch_row($categoriasql)){

            ?>
              <a href="buscar?categorias=<?php echo $arraycat[0] ?>"><?php echo $arraycat[1] ?></a>

            <?php
            }

            ?>

            </div>      
    </li>
      <li class="busqueda">
        <!-- Formulario de búsqueda -->
        <form method="GET" action="buscar" class="busqueda-formulario" onsubmit="aplicarFiltro()">
            <input type="text" name="query" class="busqueda-texto" placeholder="Buscar productos">
            <input type="submit" value="" class="busqueda-boton">
        </form>
      </li>
      <li class="carrito">
            <div class="cart-menu" onclick="toggleCartSidebar()">
                <img src="img/carrito.png" alt="Carrito de compras">
                <span>Mi carrito</span>
            </div>
            <div class="cart-sidebar" id="cart-sidebar" style="text-align: left;">
                <p style="font-size:20px">Mi carrito</p>
                <?php 
                if(isset($_SESSION['usucod'])){

                ?>  

                <ul id="cart-items" class="cart-items"></ul>
                <div class="cart-sidebar-footer" id="cart-sidebar-footer">
                <p id="cart-total">TOTAL  0.00€</p>
                <button id="carritoVaciarBtn" class="carrito-vaciar-btn" onclick="emptyCart()">Vacíar carrito</button>
                <a id="carritoCheckout" class="carrito-checkout" onclick="checkout()">Ver artículos del carrito</a>

                <?php
                }else {
                  ?>

                  <img id="carrito-error" src="img/carritoerror.png">
                  <p id="login-carrito">Inicia sesión para utilizar el carrito.</p>

                  <?php
                }

                ?>
                </div>
           
      </li>
      <?php
            if(isset($_SESSION['usucod'])){
              if($usuadm == 1){
                ?>
                <a href="panel-administrador?productos" id="administrador"><li class="panel-adm">
                  <div class="panel-administrador">
                    <img src="img/panel.png">
                    <span>Panel de administrador</span>
                  </div>
                </li></a>
                <?php
              }
            }
            ?>
    </ul>
    <ul class="sesiones">
      <?php 

        if(isset($_SESSION['usucod'])){
          $usuloginsesion = $_SESSION['usunom'];
          ?>
          <div class="cuenta">
          <button onclick="mostrarMenu()" class="dropbtn" id="menuButton">
          <div class="button-content">
          <div class="perfil-imagen">
          <img class ="userlogo" src="<?php echo $usuimg ?>">
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
        }else{
          ?> 
          <a href='login'><li>Iniciar sesión</li></a>
                <a href='register'><li>Registrarse</li></a>
          <?php
        }
      
      
      ?>
    </ul>
  </nav>

  <!-- Resto del contenido de la página -->



  <?php 

  $productos = array();

foreach ($_GET as $paramName => $paramValue) {
  if (strpos($paramName, 'name') !== false) {
    $index = filter_var($paramName, FILTER_SANITIZE_NUMBER_INT);
    $name = $paramValue;
    $price = $_GET['price' . $index];
    $count = $_GET['count' . $index];

    $producto = array(
      'name' => $name,
      'price' => $price,
      'count' => $count
    );

    $productos[] = $producto;
  }
}


?>

<script>
  var productos = <?php echo json_encode($productos); ?>;
  console.log(productos);
</script>
<script src="js/carrito-finalizar-compra.js"></script>

<div class="container">
<div class="block datosguardados">
            <h2>Usar datos guardados</h2>
            <?php
            $usucod = $_SESSION['usucod'];
            $datosguardadosql = "SELECT * FROM datos WHERE USUCOD='$usucod';";
            $datosguardadosresultado = mysqli_query($conexion, $datosguardadosql);
            $i = 1;
            if(mysqli_num_rows($datosguardadosresultado) != 0){
            while($arraydatos = mysqli_fetch_row($datosguardadosresultado)){
              
              $ultimosDos = substr($arraydatos[3], -2);
              $asteriscos = str_repeat("*", strlen($arraydatos[3]) - 2);

              $tarjeta = $asteriscos . $ultimosDos;
              $nombre = $arraydatos[1];
              $apellidos = $arraydatos[2];
              $nombrefull = $apellidos . ", " . $nombre;
              ?>
              <div id="<?php echo $i ?>" class="popup">
          <div class="popup-contenido">
            <h3>AVISO</h3>
            <p>Si ya tiene datos introducidos, se sobreescribirán.<br> ¿Quiere continuar?</p>
            <div class="popup-botones">
              <button onclick="usardatos(<?php echo $arraydatos[3] ?>)">Sí</button>
              <button onclick="cerrarPopup(<?php echo $i ?>)">No</button>
            </div>
          </div>
        </div>      
              <div class="filadatos" onclick="mostrarPopup(<?php echo $i ?>)">
                <div class="imagen">
                <img src="img/tarjeta.png" style="width:50px;margin-bottom: 15px;">
            </div>
                <a id="datosclick"><?php echo $i . " ." ?> <?php echo "Tarjeta " . $tarjeta . " a nombre de " . $nombrefull ?></a>
              </div>

              <?php
              $i += 1;
            }
          }else{
            ?>
            <p style="font-size:13px;">Aún no tienes datos guardados.</p>
            <?php
          }

          ?>
          

         
          </div>
            <div class="block formulario">
              <h2>1. Método de pago</h2>
              <form class="pago">
                <div class="organizar">
                <p>Número de tarjeta</p>
                <p>Fecha de caducidad</p>
                <p>Código de seguridad</p>
                </div>
                
                <div class="organizar">
                <input type="text" maxlength="14" minlength="14" id="tarjeta-input"></input>
                <input type="text" maxlength="5" id="caducidad-input"></input>
                <input type="number" maxlength="3" id="codigoseg-input"></input>
                </div>
              </form>
             <h2>2. Dirección</h2>
                <form class="direccion">
                    <div class="organizar">
                    <p>Nombre</p>
                    <p>Apellidos</p>
                    <p>Ciudad</p>
                    </div>
                    <div class="organizar">
                    <input type="text" id="nombre-input"></input>
                    <input type="text" id="apellidos-input"></input>
                    <input type="text" id="ciudad-input"></input>
                    </div>
                    <div class="organizar">
                    <p>Dirección</p>
                    <p>Código Postal</p>
                    </div>
                    <div class="organizar">
                    <input type="text" id="direccion-input"></input>
                    <input type="number" maxlength="5" id="codigopost-input"></input>
                    </div>
                    <div class="organizar">
                    <p>País</p>
                    <p>Teléfono</p>
                    </div>
                    <div class="organizar">
                        <input type="text" id="pais-input"></input>
                        <input type="number" id="telefono-input"></input>
                    </div>
                    <div class="organizar2">
                    <input type="checkbox" id="guardar"><p>Guardar mis datos para la próxima compra</p></input>
                    </div>
            </div>

            <div class="block datos">
            <h2>Datos del producto</h2>
            <div class="caracteristicas">
                <p id="caracteristicanombre">Nombre</p>
                <p style="font-size:15px;">Cantidad</p>
                <p>Precio</p>
            </div>

            <?php
                    $total = 0;

                    foreach ($productos as $producto) {
                        $nombreproducto = $producto['name'];
                        $productosql = "SELECT * FROM productos WHERE PRODNOM = '$nombreproducto';";
                        $productosqlresultado = mysqli_query($conexion, $productosql);
                        $productoarray = mysqli_fetch_assoc($productosqlresultado);
                        $prodcod = $productoarray['PRODCOD'];
                        $img = $productoarray['PRODIMG'];
                        $precio = $producto['price']; // Obtener el precio del producto actual
                        $cantidad = $producto['count']; // Obtener la cantidad del producto actual
                        $subtotal = $precio * $cantidad; // Calcular el subtotal (precio x cantidad)
                        $total += $subtotal;
                        ?>
                        <div class="organizar" id="producto">
                        <div id="product-image"><img src="<?php echo $img ?>"> </div>
                        <div id="product-name"><a id="producto-alink" href="producto?id=<?php echo $prodcod ?>"><?php echo $producto['name']  ?></a> </div>
                        <div id="product-count"><?php echo "x" . $producto['count'] ?> </div>
                        <div id="product-price"><?php echo $producto['price'] . " €"?> </div>
                        </div>
                    <?php
                    }
                        
                    ?>
                    <div id="totalprecio">
                    <p>Total : <?php echo $total ?> € </span></p>
                    </div>
            <div class="organizar2">
            <input type="checkbox" id="politicas-input"><p>He leído y acepto la política de privacidad</p></input>
            </div>
            <button id="finalizar-compra" onclick="enviarFormulario(event)">Finalizar la compra</button>
            <div id="mensaje"></div>
            </div>
        </div>
            <?php
        
        

        ?>
       




<footer>
  <div class="contenedor-footer">
    <div class="logo-footer">
      <img src="img/Logo.png" alt="Logo">
      <h3>Infoshop</h3>
    </div>
    <div class="redes-sociales">
      <a href="#" class="icono-social"><img src ="img/fblogo.png" alt="Facebook"></i></a>
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

                  </div>

</div>
</div>



</body>
</html>

