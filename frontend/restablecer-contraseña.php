<?php

$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

mysqli_select_db($conexion, "infoshop");

session_start();


if(isset($_GET['token'])){
    $token = $_GET['token'];
}else{
    Header("Location: index");
}

// Consulta la base de datos para verificar el token y su expiración
$sql = "SELECT * FROM verificar WHERE VERTOK = '$token' AND VEREXP > NOW()";
$resultado = mysqli_query($conexion, $sql);


?>

<!DOCTYPE html>
<html>
<head>
  <title>Infoshop | Las mejoras ofertas en Informática!</title>
  <link rel="stylesheet" type="text/css" href="js/jquery-3.7.0.min.js">
  <link rel="stylesheet" type="text/css" href="../css/estilo-restablecer.css">
  <link rel="stylesheet" type="text/css" href="js/slick/slick.css">
<link rel="stylesheet" type="text/css" href="js/slick/slick-theme.css">
<link rel="icon" type="image/png" href="img/Logo.png">
</head>
<body>

<script src="js/restablecer.js"></script>
<script src="js/togglepass.js"></script>
<script src="js/togglepassrp.js"></script>





<div class="contenedor">
<div class="logo">
    <a href="index"><img src="img/Logo.png" alt="Logo"></a>
</div>

<?php

if(isset($_SESSION['usucod'])){
    ?>


    <div class="block sesion" id="sesioniniciada">
        <h2>Usted ya ha iniciado sesión. Redirigiendo...</h2>
        <?php
        ob_start();
        Header("Refresh: 2; URL=index");
        ob_end_flush();
        ?>
    </div>


    <?php
    }else{
        session_destroy();

        if (mysqli_num_rows($resultado) > 0) {
        ?>
    
    <div class="formulario-container">
        <div class="block formulario">
            <h2>Restablecer contraseña</h2>
            <form id="login-form" method="POST" action="">
            <div class="password-container">
                <input type="password" id="contraseña-input" name ="contraseña" placeholder="Contraseña" style="margin-bottom: 15px;">
                <span class="toggle-password" onclick="togglePasswordVisibility()"></span>
            </div>
            <div class="password-container">
                <input type="password" id="repetir-contraseña-input" name ="repetir-contraseña" placeholder="Repetir Contraseña" style="margin-bottom: 15px;">
                <span class="toggle-password-rp" onclick="togglePasswordVisibilityrp()"></span>
            </div>
                <input type="submit" name="enviar" value="Restablecer contraseña" data-token="<?php echo $token; ?>" id="btn-login">
                <div id="loader"></div>
                <div id="mensaje"></div>
                <a class ="login" href="login">Volver a inicio de sesión</a>
            </form>
            <div id="mensaje"></div>
            </div>
        </div>
    </div>

    <?php
    
    }else{
        ?>
    <div class="centrar">
        <div class="block token-expired" id="token-exp">
            <h2>La sesión ha expirado. Vuelva a generar el enlace.</h2>
            <a href="olvidar-contraseña" class="volver">Volver</a>
        <?php
        $borrar = "DELETE FROM verificar WHERE VERTOK = '$token';";
        $borrarresult = mysqli_query($conexion, $borrar);
        ?>

        </div>
    </div>
        <?php
    }


}




?>




 

<footer>
  <div class="contenedor-footer">
    <div class="logo-footer">
      <img src="img/Logo.png" alt="Logo">
      
    </div>
    <div class="redes-sociales">
      <a href="#" class="icono-social"><img src ="img/fblogo.png" alt="Facebook"></i></a>
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


