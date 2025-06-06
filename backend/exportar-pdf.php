 <?php
$servidor= "localhost";
$usuario = "root";
$password = "";
$conexion = mysqli_connect($servidor, $usuario, $password);

$fecha = date('d/m/Y');

mysqli_select_db($conexion, "infoshop");

session_start();
header('Content-Type: text/html; charset=utf-8');
                         
                        define('FPDF_FONTPATH', 'font/');

                          require('../fpdf.php');

                          // Conexión a la base de datos y consulta de datos
                          
                          $categoriasql = mysqli_query($conexion, "SELECT * FROM categorias");
                          $datosql = mysqli_query($conexion, "SELECT * FROM datos");
                          $devolucionesql = mysqli_query($conexion, "SELECT * FROM devoluciones");
                          $mensajesql = mysqli_query($conexion, "SELECT * FROM mensajes ORDER BY MENFEC DESC");
                          $notificacionesql = mysqli_query($conexion, "SELECT * FROM notificaciones");
                          $paneladminsql = mysqli_query($conexion, "SELECT * FROM paneladmin");
                          $pedidosql = mysqli_query($conexion, "SELECT * FROM pedidos");
                          $productosql = mysqli_query($conexion, "SELECT * FROM productos");
                          $proveedoresql = mysqli_query($conexion, "SELECT * FROM proveedores");
                          $reseñasql = mysqli_query($conexion, "SELECT * FROM reseñas");
                          $ticketsql = mysqli_query($conexion, "SELECT * FROM tickets");
                          $usuariosql = mysqli_query($conexion, "SELECT * FROM usuarios");
                          $verificarsql = mysqli_query($conexion, "SELECT * FROM verificar");


                          // Crear el archivo PDF
                          $pdf = new FPDF();
                          $pdf->AddPage();

                          $pdf->SetFont('Arial', 'B', 30);

                          $pdf->Cell(0, 10, 'INFOSHOP DB 2023', 0, 1, 'C');
                          $pdf->Ln();
                          $pdf->Ln();

                          // BLOQUE PARA CATEGORIAS
                          $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'CATEGORIAS', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 10);
                          $pdf->Cell(40, 10, 'CATCOD', 1, 0, 'C');
                          $pdf->Cell(40, 10, 'CATNOM', 1, 0, 'C');
                          $pdf->Cell(80, 10, 'CATDESC', 1, 1, 'C');

                        

                          $pdf->SetFont('Arial', '', 10);

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($categoriasql)) {

                          
                              $pdf->Cell(40, 10, utf8_decode($fila['CATCOD']), 1, 0, 'C');
                              $pdf->Cell(40, 10, utf8_decode($fila['CATNOM']), 1, 0, 'C');
                              $anchoCampo3 = $pdf->GetStringWidth($fila['CATDESC']);
                                if ($anchoCampo3 > 80) {
                                    // Si el ancho es mayor a 80, reducir el tamaño de la fuente
                                    $pdf->SetFont('Arial', '', 8);
                                }
                              $pdf->Cell(80, 10, utf8_decode($fila['CATDESC']), 1, 0, 'C');

                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();

                          //BLOQUE PARA DATOS//

                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'DATOS', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 6);
                          $pdf->Cell(18, 20, 'USUCOD', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSNOM', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSAPE', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSTAR', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSCAD', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSCODSEG', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSCIU', 1, 0, 'C');
                          $pdf->Cell(22, 20, 'DATOSDIR', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSCP', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSPAIS', 1, 0, 'C');
                          $pdf->Cell(18, 20, 'DATOSTEL', 1, 1, 'C');

                        

                          $pdf->SetFont('Arial', '', 6);

                          
                          while ($fila2 = mysqli_fetch_assoc($datosql)) {

                          
                              $pdf->Cell(18, 20, utf8_decode($fila2['USUCOD']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSNOM']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSAPE']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSTAR']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSCAD']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSCODSEG']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSCIU']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 4);
                              $pdf->Cell(22, 20, utf8_decode($fila2['DATOSDIR']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 6);
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSCP']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSPAIS']), 1, 0, 'C');
                              $pdf->Cell(18, 20, utf8_decode($fila2['DATOSTEL']), 1, 0, 'C');

                              $pdf->SetFont('Arial', '', 6);
                              
                              $pdf->Ln();
                          }


                            $pdf -> Ln();




                          //BLOQUE PARA DEVOLUCIONES//



                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'DEVOLUCIONES', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 10);
                          $pdf->Cell(15, 10, 'DEVCOD', 1, 0, 'C');
                          $pdf->Cell(35, 10, 'DEVRAZ', 1, 0, 'C');
                          $pdf->Cell(115, 10, 'DEVDET', 1, 0, 'C');
                          $pdf->Cell(15, 10, 'PEDCOD', 1, 1, 'C');

                        

                          $pdf->SetFont('Arial', '', 10);

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($devolucionesql)) {

                          
                              $pdf->Cell(15, 10, utf8_decode($fila['DEVCOD']), 1, 0, 'C');
                              $pdf->Cell(35, 10, utf8_decode($fila['DEVRAZ']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(115, 10, utf8_decode($fila['DEVDET']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 10);
                              $pdf->Cell(15, 10, utf8_decode($fila['PEDCOD']), 1, 0, 'C');

                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();




                          //BLOQUE PARA MENSAJES//


                             $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'MENSAJES', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 10);
                          $pdf->Cell(135, 10, 'MENCONT', 1, 0, 'C');
                          $pdf->Cell(20, 10, 'MENFEC', 1, 0, 'C');
                          $pdf->Cell(15, 10, 'USUCOD', 1, 0, 'C');
                          $pdf->Cell(20, 10, 'TICKID', 1, 1, 'C');

                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($mensajesql)) {

                                $pdf->SetFont('Arial', '', 5);
                              $pdf->Cell(135, 10, utf8_decode($fila['MENCONT']), 1, 0, 'C');
                               $pdf->SetFont('Arial', '', 6);
                              $pdf->Cell(20, 10, utf8_decode($fila['MENFEC']), 1, 0, 'C');
                              
                              $pdf->Cell(15, 10, utf8_decode($fila['USUCOD']), 1, 0, 'C');
                             
                              $pdf->Cell(20, 10, utf8_decode($fila['TICKID']), 1, 0, 'C');

                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();



                          //BLOQUE PARA NOTIFICACIONES//


                         $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'NOTIFICACIONES', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 10);
                          $pdf->Cell(20, 10, 'NOTCOD', 1, 0, 'C');
                          $pdf->Cell(40, 10, 'NOTNOM', 1, 0, 'C');
                          $pdf->Cell(120, 10, 'NOTDESC', 1, 1, 'C');
                          

                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($notificacionesql)) {

                                $pdf->SetFont('Arial', '', 8);
                              $pdf->Cell(20, 10, utf8_decode($fila['NOTCOD']), 1, 0, 'C');
                              $pdf->Cell(40, 10, utf8_decode($fila['NOTNOM']), 1, 0, 'C');
                              
                              $pdf->Cell(120, 10, utf8_decode($fila['NOTDESC']), 1, 0, 'C');
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();





                          //BLOQUE PARA PANELADMIN


                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'PANELADMIN', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 10);
                          $pdf->Cell(20, 10, 'ADMCOD', 1, 0, 'C');
                         
                          $pdf->Cell(130, 10, 'ADMCONT', 1, 0, 'C');
                         
                          $pdf->Cell(20, 10, 'NOTCOD', 1, 1, 'C');
                          

                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($paneladminsql)) {

                                $pdf->SetFont('Arial', '', 10);
                              $pdf->Cell(20, 10, utf8_decode($fila['ADMCOD']), 1, 0, 'C');
                              
                              $pdf->Cell(130, 10, utf8_decode($fila['ADMCONT']), 1, 0, 'C');
                              
                              $pdf->Cell(20, 10, utf8_decode($fila['NOTCOD']), 1, 0, 'C');
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();






                          //BLOQUE PARA PEDIDOS

                           $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'PEDIDOS', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 5.5);

                          $pdf->Cell(14, 10, 'PEDCOD', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDFECCOMP', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDFECDEV', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'USUCOD', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PRODCOD', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDEST', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDTAR', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDCAD', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDCODSEG', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDCIU', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDDIR', 1, 0, 'C');     
                          $pdf->Cell(14, 10, 'PEDCP', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDPAIS', 1, 0, 'C');
                          $pdf->Cell(14, 10, 'PEDTEL', 1, 1, 'C');
                        

                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($pedidosql)) {

                                $pdf->SetFont('Arial', '', 5.5);
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDCOD']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDFECCOMP']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDFECDEV']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['USUCOD']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PRODCOD']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDEST']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDTAR']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDCAD']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDCODSEG']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDCIU']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDDIR']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDCP']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDPAIS']), 1, 0, 'C');
                              $pdf->Cell(14, 10, utf8_decode($fila['PEDTEL']), 1, 0, 'C');

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();
                          $pdf->Ln();







                          //BLOQUE PARA PRODUCTOS

                         $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'PRODUCTOS', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 3.2);

                          $pdf->Cell(6.5, 10, 'PRODCOD', 1, 0, 'C');
                          $pdf->SetFont('Arial', 'B', 5.5);
                          $pdf->Cell(25, 10, 'PRODIMG', 1, 0, 'C');
                          $pdf->Cell(30, 10, 'PRODNOM', 1, 0, 'C');
                          
                          $pdf->Cell(80, 10, 'PRODDESC', 1, 0, 'C');
                          $pdf->SetFont('Arial', 'B', 3.2);
                          $pdf->Cell(6.5, 10, 'PRODPREC', 1, 0, 'C');
                          $pdf->Cell(6.5, 10, 'PRODINV', 1, 0, 'C');
                          $pdf->Cell(6.5, 10, 'PRODOFE', 1, 0, 'C');
                          $pdf->Cell(9, 10, 'PRODNUMVENT', 1, 0, 'C');
                          $pdf->Cell(9, 10, 'PRODPRECORI', 1, 0, 'C');
                          $pdf->Cell(6.5, 10, 'PRODVAL', 1, 0, 'C');
                          $pdf->Cell(6.5, 10, 'CATCOD', 1, 0, 'C');     
                          $pdf->Cell(6.5, 10, 'PROCOD', 1, 1, 'C');
                        

                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($productosql)) {

                                $pdf->SetFont('Arial', '', 5.5);
                              $pdf->Cell(6.5, 10, utf8_decode($fila['PRODCOD']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 4.5);
                              $pdf->Cell(25, 10, utf8_decode($fila['PRODIMG']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 3.2);
                              $pdf->Cell(30, 10, utf8_decode($fila['PRODNOM']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 4.5);
                              $pdf->Cell(80, 10, utf8_decode((substr($fila['PRODDESC'], 0, 100) . '...')), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 5.5);
                              $pdf->Cell(6.5, 10, utf8_decode($fila['PRODPREC']), 1, 0, 'C');
                              $pdf->Cell(6.5, 10, utf8_decode($fila['PRODINV']), 1, 0, 'C');
                              $pdf->Cell(6.5, 10, utf8_decode($fila['PRODOFE']), 1, 0, 'C');
                              $pdf->Cell(9, 10, utf8_decode($fila['PRODNUMVENT']), 1, 0, 'C');
                              $pdf->Cell(9, 10, utf8_decode($fila['PRODPRECORI']), 1, 0, 'C');
                              $pdf->Cell(6.5, 10, utf8_decode($fila['PRODVAL']), 1, 0, 'C');
                              $pdf->Cell(6.5, 10, utf8_decode($fila['CATCOD']), 1, 0, 'C');
                              $pdf->Cell(6.5, 10, utf8_decode($fila['PROCOD']), 1, 0, 'C');

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();







                          //BLOQUE PARA PROVEEDORES

                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'PROVEEDORES', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 11);

                          $pdf->Cell(90, 10, 'PROCOD', 1, 0, 'C');
                          $pdf->Cell(90, 10, 'PRONOM', 1, 1, 'C');
                          

                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($proveedoresql)) {

                                $pdf->SetFont('Arial', '', 11);
                              $pdf->Cell(90, 10, utf8_decode($fila['PROCOD']), 1, 0, 'C');
                              $pdf->Cell(90, 10, utf8_decode($fila['PRONOM']), 1, 0, 'C');
                              

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();





                          //BLOQUE PARA RESEÑAS
                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, utf8_decode('RESEÑAS'), 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 7);

                          $pdf->Cell(20, 10, 'RESCOD', 1, 0, 'C');
                          $pdf->Cell(20, 10, 'RESVAL', 1, 0, 'C');
                          $pdf->Cell(80, 10, 'RESCONT', 1, 0, 'C');
                          $pdf->Cell(40, 10, 'RESFEC', 1, 0, 'C');
                          $pdf->Cell(20, 10, 'USUCOD', 1, 0, 'C');
                          $pdf->Cell(20 , 10, 'PRODCOD', 1, 1, 'C');
                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($reseñasql)) {

                                $pdf->SetFont('Arial', '', 8);
                              $pdf->Cell(20, 10, utf8_decode($fila['RESCOD']), 1, 0, 'C');
                              $pdf->Cell(20, 10, utf8_decode($fila['RESVAL']), 1, 0, 'C');
                              $pdf->Cell(80, 10, utf8_decode((substr($fila['RESCONT'], 0, 55) . '...')), 1, 0, 'C');
                              $pdf->Cell(40, 10, utf8_decode($fila['RESFEC']), 1, 0, 'C');
                              $pdf->Cell(20, 10, utf8_decode($fila['USUCOD']), 1, 0, 'C');
                              $pdf->Cell(20, 10, utf8_decode($fila['PRODCOD']), 1, 0, 'C');
                             

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();




                          //BLOQUE PARA TICKETS

                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, utf8_decode('TICKETS'), 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 7);

                          $pdf->Cell(30, 10, 'TICKID', 1, 0, 'C');
                          $pdf->Cell(90, 10, 'TICKCONT', 1, 0, 'C');
                          $pdf->Cell(30, 10, 'TICKEST', 1, 0, 'C');
                          $pdf->Cell(30, 10, 'TICKFEC', 1, 0, 'C');
                          $pdf->Cell(20 , 10, 'USUCOD', 1, 1, 'C');
                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($ticketsql)) {

                                $pdf->SetFont('Arial', '', 8);
                              $pdf->Cell(30, 10, utf8_decode($fila['TICKID']), 1, 0, 'C');
                              $pdf->Cell(90, 10, utf8_decode((substr($fila['TICKCONT'], 0, 55) . '...')), 1, 0, 'C');
                              $pdf->Cell(30, 10, utf8_decode($fila['TICKEST']), 1, 0, 'C');
                              $pdf->Cell(30, 10, utf8_decode($fila['TICKFEC']), 1, 0, 'C');
                              $pdf->Cell(20, 10, utf8_decode($fila['USUCOD']), 1, 0, 'C');
                             

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();




                          //BLOQUE PARA USUARIOS

                         $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, utf8_decode('USUARIOS'), 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 7);

                          $pdf->Cell(10, 10, 'USUCOD', 1, 0, 'C');
                          $pdf->Cell(15, 10, 'USUNOM', 1, 0, 'C');
                          $pdf->Cell(22, 10, 'USUAPE', 1, 0, 'C');
                          $pdf->Cell(40, 10, 'USUCOR', 1, 0, 'C');
                          $pdf->Cell(60, 10, 'USUCONT', 1, 0, 'C');
                          $pdf->SetFont('Arial', 'B', 5.5);
                          $pdf->Cell(10, 10, 'USUADM', 1, 0, 'C');
                          $pdf->Cell(10, 10, 'USUNEWS', 1, 0, 'C');
                          $pdf->SetFont('Arial', 'B', 7);
                          $pdf->Cell(30, 10, 'USUIMG', 1, 1, 'C');
                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($usuariosql)) {

                                $pdf->SetFont('Arial', '', 8);
                              $pdf->Cell(10, 10, utf8_decode($fila['USUCOD']), 1, 0, 'C');
                              $pdf->Cell(15, 10, utf8_decode($fila['USUNOM']), 1, 0, 'C');
                              $pdf->Cell(22, 10, utf8_decode($fila['USUAPE']), 1, 0, 'C');
                              $pdf->SetFont('Arial', '', 7.5);
                              $pdf->Cell(40, 10, utf8_decode($fila['USUCOR']), 1, 0, 'C');
                              $pdf->Cell(60, 10, utf8_decode((substr($fila['USUCONT'], 0, 30) . '...')), 1, 0, 'C');
                              $pdf->Cell(10, 10, utf8_decode($fila['USUADM']), 1, 0, 'C');
                              $pdf->Cell(10, 10, utf8_decode($fila['USUNEWS']), 1, 0, 'C');
                              $pdf->Cell(30, 10, utf8_decode($fila['USUIMG']), 1, 0, 'C');
                             

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();





                          //BLOQUE PARA VERIFICAR

                        $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(0, 10, 'VERIFICAR', 0, 1, 'C');
                          $pdf->Ln();

                          $pdf->SetFont('Arial', 'B', 12);

                          $pdf->Cell(60, 10, 'VERTOK', 1, 0, 'C');
                          $pdf->Cell(60, 10, 'VEREXP', 1, 0, 'C');
                          $pdf->Cell(60, 10, 'USUCOD', 1, 1, 'C');
                          
                        

                          

                          // Recorrer los resultados de la consulta y agregarlos al PDF
                          while ($fila = mysqli_fetch_assoc($verificarsql)) {

                                $pdf->SetFont('Arial', '', 11);
                              $pdf->Cell(60, 10, utf8_decode($fila['VERTOK']), 1, 0, 'C');
                              $pdf->Cell(60, 10, utf8_decode($fila['VEREXP']), 1, 0, 'C');
                              $pdf->Cell(60, 10, utf8_decode($fila['USUCOD']), 1, 0, 'C');
                              

                              
                              
                            
                             
                      
                              $pdf->SetFont('Arial', '', 10);
                              // Agregar más celdas si es necesario
                              $pdf->Ln();
                              
                          }
                          
                          $pdf->Ln();







                        $nombre = 'INFOSHOP-DB';
                        $nombre .= ' ' . $fecha . '.pdf';

                          // Descargar el archivo PDF
                          $pdf->Output($nombre, 'D');
?>