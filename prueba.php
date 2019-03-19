<?php
require './datos/modelo/conexion.php';
require './datos/modelo/cartas.class.php';
require './datos/modelo/operabd.class.php';


$carta1 = new Carta();
$carta1->numeroRegistro = 'prueba';
$carta1->lugarEmision = 291339;
$carta1->lugarRecepcion = 291339;
$carta1->pagina = 1;
$carta1->asunto = 'asdf';
$carta1->asuntoClave = 'asdf';
//var_dump($carta1);
$carta1->almacena();

 ?>
