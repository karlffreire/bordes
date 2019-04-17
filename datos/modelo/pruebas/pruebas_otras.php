<?php
require './datos/modelo/conexion.php';
require './datos/modelo/acontecimiento.class.php';
require './datos/modelo/carta.class.php';
require './datos/modelo/operabd.class.php';

//INSERCION DE UNA NUEVA INSTITUCION UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'nombre' => 'Real convento de las pruebas',
//   'administracion' => 'Religiosa',
//   'sede' => 2
// );
//   $institucion1 = new Institucion(true,$arrprop);

//var_dump($institucion1);

 //$institucion1->almacena();

//SELECCION DE UNA INSTITUCION CON ATRIBUTOS
// $arrprop  = array('*');
//  $where = array('idinstituciones' => 13);
//  $prueba = OperaBD::selec('datos.instituciones',$arrprop,'Institucion',$where)[0];
//var_dump($prueba);

//Y MODIFICACIÓN DE LA INSTITUCION SELECCIONADA
 //$prueba->sede = 1;

// $prueba->modifica();

//$prueba->borra();

//INSERCION DE UN NUEVO ACONTECIMIENTO UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'nombre' => 'Batalla de las pruebas borradas',
//   'fecha' => '14-05-1845',
//   'confianzafecha' => 3,
//   'lugar' => 3
// );
//   $acontecimiento1 = new Acontecimiento(true,$arrprop);
//
// var_dump($acontecimiento1);
//
//  $acontecimiento1->almacena();

 //SELECCION DE UN ACONTECIMIENTO CON ATRIBUTOS
  $arrprop  = array('*');
  $where = array('idacontecimiento' => 4);
  $prueba = OperaBD::selec('datos.acontecimiento',$arrprop,'Acontecimiento',$where)[0];
  //
  // $prueba->lugar=1;
  //
  // $prueba->modifica();
  //$prueba->borra();
//var_dump($prueba)
  var_dump($prueba->getCartas());
 ?>
