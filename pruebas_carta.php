<?php
require './datos/modelo/conexion.php';
require './datos/modelo/carta.class.php';
require './datos/modelo/persona.class.php';
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


//var_dump($carta1);

 //$carta1->almacena();

//SELECCION DE UNA CARTA CON VARIOS ATRIBUTOS
// $arrprop  = array('idcartas','numeroregistro','lugaremision','lugarrecepcion','pagina','asunto','palabrasclave','identificador');
//  $where = array('idcartas' => 55);
//  $prueba = OperaBD::selec('datos.cartas',$arrprop,'Carta',$where)[0];
//var_dump($prueba);

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

//AÑADIR Y RECUPERAR EMISOR, RECEPTOR Y MENCIONES SOBRE LA SELECCIÓN ANTERIOR:
//$prueba->setEmisor(22);
//$prueba->getEmisor();
//$prueba->setReceptor(24);
//$prueba->getReceptor();
//$prueba->setMenciones(array(28,29));
//$prueba->getMenciones();

//AÑADIR Y RECUPERAR LUGARES DE EMISIÓN Y RECEPCIÓN:



 ?>
