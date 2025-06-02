<?php

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();

// Obtener la sección enviada por la solicitud AJAX
$seccion = $_GET['seccion'];

$usucod = $_SESSION['usucod'];

$datosusuario = "SELECT * FROM usuarios WHERE USUCOD = '$usucod';";
$datosusuariosql = mysqli_query($conexion, $datosusuario);
$datosusuarioarray = mysqli_fetch_assoc($datosusuariosql);

$usunom = $datosusuarioarray['USUNOM'];
$usuape = $datosusuarioarray['USUAPE'];
$usucor = $datosusuarioarray['USUCOR'];
$usucont = $datosusuarioarray['USUCONT'];


// Realizar las operaciones y generar el contenido correspondiente a la sección seleccionada
if ($seccion === 'datos') {
   echo " 
    <div class='perfil'>
    <div class='perfil-imagen'><img src='img/user.png'></div>
    <div class='perfil-nombre'><h2><?php echo $usunom . ' ' . $usuape ?></h2></div>
</div>
<div class='datosusuario'>
    <div class='personales'>
    <form id='datospersonales'>
    <h5>Nombre</h5>
    <div class='input'><input type='text' id='nombre' class ='disabled' name='nombre' value='<?php echo '$usunom' ?>' readonly><img onclick='permitirEditar('nombre')' class ='editar' src='img/editar.png'></div>
    <h5>Apellidos</h5>
    <div class='input'><input type='text' id='apellidos' class ='disabled' name='apellidos' value='<?php echo $usuape ?>' readonly><img onclick='permitirEditar('apellidos')' class ='editar' src='img/editar.png'></div> 
    <h5>Dirección de correo electrónico</h5>
    <div class='input'><input type='text' id='correo' class ='disabled' name ='correo' value='<?php echo $usucor ?>' readonly><img onclick='permitirEditar('correo')' class ='editar' src='img/editar.png'></div>
    <h5>Contraseña</h5>
    <div class='input' style='margin-bottom: 20px'><input type='text' id='contraseña' class ='disabled'name='contraseña' value='*******************' readonly><img onclick='permitirEditar('contraseña')' class ='editar' src='img/editar.png'></div>
    <button id='aplicar' onclick='mostrarPopup(event)'>Aplicar cambios</button>
    <div id='mensaje'></div>
    </form>
    </div>
    <div class='estadisticas'>
    <h2 style='margin-top: 50px;'>Productos comprados:</h2>
    <p><?php echo $pedidos ?></p>
    <br>
    <h2>Reseñas:</h2>
    <p><?php echo $reseñas ?></p>
    </div>
</div>";
} elseif ($seccion === 'configuracion') {
  
} elseif ($seccion === 'historial') {
  
} else {
  // Manejo de caso inválido
  echo "Sección no válida";
}
?>
