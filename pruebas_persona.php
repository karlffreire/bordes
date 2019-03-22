<?php
require './datos/modelo/conexion.php';
require './datos/modelo/persona.class.php';
require './datos/modelo/operabd.class.php';

//INSERCION DE UNA NUEVA PERSONA UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'nombre' => 'Fernando',
//   'apellidos' => 'Gomillas',
//   'genero' => 'Hombre',
//   'nacionalidad' => 1,
// );
// $persona1 = new Persona(true,$arrprop);
//
//  $persona1->almacena();

//SELECCION DE UNA PERSONA CON VARIOS ATRIBUTOS
 $arrprop  = array('idpersonas','nombre','apellidos','nacionalidad','genero','profesion');
 $where = array('idpersonas' => 25);
 $prueba = OperaBD::selec('datos.personas',$arrprop,'Persona',$where)[0];


//Y MODIFICACIÓN DE LA PERSONA SELECCIONADA
// $prueba->apellidos = 'Palotes Pirulo';
// $prueba->modifica();


$prueba->borra();

//$prueba->setObjeto(2);
// $objetos = $prueba->getObjetos();
// foreach ($objetos as $key => $value) {
//   echo $value['nombre'].'<br>';
// }

 ?>
