<?php
require './datos/modelo/conexion.php';
require './datos/modelo/viaje.class.php';
require './datos/modelo/carta.class.php';
require './datos/modelo/persona.class.php';
require './datos/modelo/operabd.class.php';

//INSERCION DE UN NUEVO VIAJE UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'fechainicio' => '27-07-1716',
//   'confianzafechainicio' => 2,
//   'motivoviaje' => 'Gobernar',
//   'observaciones' => 'Lleva ganas',
//   'decoro' => 'false',
//   'embarcaciones' => array('Altamar'),
//   'realizado' => 'true',
//   'honraydecoro' => array('Escritura','Vestimenta')
// );
//  $viaje1 = new Viaje(true,$arrprop);

//var_dump($viaje1);
//$viaje1->almacena();

//SELECCION DE UN VIAJE CON VARIOS ATRIBUTOS
$arrprop  = array('*');
 $where = array('idviajes' => 14);
 $prueba = OperaBD::selec('datos.viajes',$arrprop,'Viaje',$where)[0];
var_dump($prueba->getRecorrido());

//Y MODIFICACIÓN DEL VIAJE SELECCIONADO
 // $prueba->motivoviaje = 'Gobernar';
 // $prueba->modifica();

//$prueba->borra();

//AÑADIR Y RECUPERAR MERCANCÍAS SOLICITADAS SOBRE LA SELECCION ANTERIOR:
 // $arrmercancia = array('mercancia'=>'Café','tipomercancias'=>'Alimentos','tipodemedida'=>'Barril','unidades'=>27);
 // $prueba->setMercanciaTransportada($arrmercancia);
//$prueba->getMercanciasTransportadas()

//AÑADIR Y RECUPERAR VIAJEROS SOBRE LA SELECCIÓN ANTERIOR
//$prueba->setViajeros(array(26,28));
//$prueba->getViajeros();

//AÑADIR Y RECUPERAR RECORRIDOS SOBRE LA SELECCIÓN ANTERIOR:
//$prueba->setRecorrido(array(39,15,40));
//$prueba->getRecorrido();





 ?>
