<?php
require './datos/modelo/conexion.php';
require './datos/modelo/persona.class.php';
require './datos/modelo/operabd.class.php';

//INSERCION DE UNA NUEVA PERSONA UTILIZANDO ARRAY DE PROPIEDADES
// $arrprop = array(
//   'nombre' => 'Pedro',
//   'apellidos' => 'Palotes Pirulo',
//   'genero' => 'Hombre',
//   'nacionalidad' => 1,
// );
// $persona1 = new Persona(true,$arrprop);
//var_dump($persona1);
//  $persona1->almacena();

//SELECCION DE UNA PERSONA CON VARIOS ATRIBUTOS
 $arrprop  = array('idpersonas','nombre','apellidos','nacionalidad','genero','profesion');
 $where = array('idpersonas' => 3);
 $prueba = OperaBD::selec('datos.personas',$arrprop,'Persona',$where)[0];


//Y MODIFICACIÓN DE LA PERSONA SELECCIONADA
$prueba->lugarnacimiento = 1;
$prueba->modifica();

var_dump($prueba);
//$prueba->borra();

//$prueba->setObjeto(2);
// $objetos = $prueba->getObjetos();
// foreach ($objetos as $key => $value) {
//   echo $value['nombre'].'<br>';
// }

 ?>
