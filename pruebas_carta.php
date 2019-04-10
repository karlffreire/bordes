<?php
require './datos/modelo/conexion.php';
require './datos/modelo/carta.class.php';
require './datos/modelo/persona.class.php';
require './datos/modelo/viaje.class.php';
require './datos/modelo/acontecimiento.class.php';
require './datos/modelo/operabd.class.php';

//INSERCION DE UNA NUEVA CARTA UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'identificador' => 789,
//   'pagina' => 15,
//   'asunto' => 'Otra prueba constructor con array',
//   'asuntoclave' => 'Enésima prueba',
//   'lugaremision' => 291339,
//   'tramiteslegales' => array('Deudas','Poderes')
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
  // $carta1->palabrasclave = 'una,dos';


//var_dump($carta1);

 //$carta1->almacena();

//SELECCION DE UNA CARTA CON VARIOS ATRIBUTOS
$arrprop  = array('*');
 $where = array('idcartas' => 55);
 $prueba = OperaBD::selec('datos.cartas',$arrprop,'Carta',$where)[0];
//var_dump($prueba);

$prueba->palabrasclave = 'Una,Dos';
var_dump($prueba->modifica());

//Y MODIFICACIÓN DE LA CARTA SELECCIONADA
 // $prueba->numeroregistro = 'prueba modificada otra vez';
 // $prueba->asuntoclave = 'estoy en ello';
 // $prueba->lugarrecepcion = NULL;
 // $prueba->modifica();

//$prueba->borra();

//AÑADIR Y RECUPERAR OBJETOS SOBRE LA SELECCIÓN ANTERIOR:
//$prueba->setObjeto(2);
// $objetos = $prueba->getObjetos();
// foreach ($objetos as $key => $value) {
//   echo $value['nombre'].'<br>';
// }

//AÑADIR Y RECUPERAR MERCANCÍAS SOLICITADAS SOBRE LA SELECCION ANTERIOR:
// $arrmercancia = array('mercancia'=>'Algodón','tipomercancias'=>'Vestidos','tipodemedida'=>'Mochila','unidades'=>5);
// $prueba->setMercanciaSolicitada($arrmercancia);
//$prueba->getMercanciasSolicitadas()

//RECUPERAR EMISOR, RECEPTOR Y MENCIONES SOBRE LA SELECCIÓN ANTERIOR:
//$prueba->getEmisor();
//$prueba->getReceptor();
//$prueba->setMenciones(array(28,29));
//$prueba->getMenciones();

//RECUPERAR LUGARES DE EMISIÓN Y RECEPCIÓN:
//$prueba->getLugarEmision();
//$prueba->getLugarRecepcion();
//$lugar = array('nombre' => "Taberna de los Milagros", 'tipolugar' => 'Iglesia', 'gid' => '88795' );
 // ["lugares_nombre"]=> string(22) "Misión de las pruebas" ["tipolugar"]=> string(7) "Iglesia" ["paisemision"]=> string(3) "202" ["lugaremision"]=> string(5) "88795" ["paisrecepcion"]=> string(2) "48" ["lugarrecepcion"]=> string(6) "101989"
// $prueba->setLugarEmision($lugar);
// $prueba->modifica();

//ASIGNAR VIAJE SOBRE LA SELECCIÓN ANTERIOR
//$prueba->setViaje(14);
//$prueba->getViajes();

//EJEMPLO VER RECORRIDO DE VIAJE DE CARTA:
// $recorrido = $prueba->getViajes()[0]->getRecorrido();
// foreach ($recorrido as $key => $etapa) {
//   echo var_dump($etapa).'<br>';
// }

//ASIGNAR Y RECUPERAR UN ACONTECIMIENTO SOBRE LA SELECCIÓN ANTERIOR
//$prueba->setAcontecimiento(4);
//$prueba->getAcontecimientos();

 ?>
