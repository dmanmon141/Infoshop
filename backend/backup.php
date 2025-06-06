 <?php
$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);
$database = "infoshop";

$fecha = date('d-m-Y-H-i');



$archivoBackup = "C:/xampp/htdocs/backup/backup" . $fecha . ".sql";



$backup = 'C:/xampp/mysql/bin/mysqldump -h ' . $servidor . ' -u ' . $usuario . ' ' . $database . ' > ' . $archivoBackup;



exec($backup, $output, $retorno);

if($retorno === 0) {
    echo "Backup realizado correctamente. Redirigiendo...";
    ob_start();
        Header("Refresh: 2; URL=../panel-administrador?basedatos");
        ob_end_flush();
    
} else{
    echo "Error al realizar el backup.";
}