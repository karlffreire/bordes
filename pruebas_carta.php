<?php
require './datos/modelo/conexion.php';
require './datos/modelo/carta.class.php';
require './datos/modelo/operabd.class.php';

//INSERCION DE UNA NUEVA CARTA UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'identificador' => 786,
//   'pagina' => 54,
//   'asunto' => 'Prueba constructor con array',
//   'asuntoclave' => 'Prueba',
//   'lugaremision' => 1
// );
//  $carta1 = new Carta(true,$arrprop);

//INSERCION DE UNA NUEVA CARTA SIN ARRAY DE PROPIEDADES
//  $carta1 = new Carta(true);
  // $carta1->identificador = 478;
  // $carta1->lugaremision = 291339;
  // $carta1->asunto = 'Prueba array 2';
  // $carta1->asuntoclave = 'Prueba array 2';
  // $carta1->pagina = 9;
  // $carta1->palabrasclave = array('una','dos');


//var_dump($carta1);

 //$carta1->almacena();

//SELECCION DE UNA CARTA CON VARIOS ATRIBUTOS
$arrprop  = array('idcartas','numeroregistro','lugaremision','lugarrecepcion','pagina','asunto','palabrasclave','identificador');
 $where = array('idcartas' => 4);
 $prueba = OperaBD::selec('datos.cartas',$arrprop,'Carta',$where)[0];
var_dump($prueba);

//Y MODIFICACIÓN DE LA CARTA SELECCIONADA
 // $prueba->numeroregistro = 'prueba modificada otra vez';
 // $prueba->asuntoclave = 'estoy en ello';
 // $prueba->lugarrecepcion = NULL;
 // $prueba->modifica();

//$prueba->borra();

//$prueba->setObjeto(2);
// $objetos = $prueba->getObjetos();
// foreach ($objetos as $key => $value) {
//   echo $value['nombre'].'<br>';
// }

 ?>
