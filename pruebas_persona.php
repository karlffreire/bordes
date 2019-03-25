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
 $arrprop  = array('idpersonas','nombre','apellidos','nacionalidad','genero');
 $where = array('nombre' => 'Pedro');
 $orden = array('nombre');
 $prueba = OperaBD::selec('datos.personas',$arrprop,'Persona',$where,$orden)[0];


//Y MODIFICACIÓN DE LA PERSONA SELECCIONADA
// $prueba->lugarnacimiento = 1;
// $prueba->modifica();
//$prueba->borra();

//CREAR Y VER HOMONIMIA SOBRE LA SELECCIÓN ANTERIOR
// $homonimia = array('nombre' => 'Pedrín','tipohomonimia' => 'Nombre propio' );
// $prueba->setHomonimia($homonimia);
//$prueba->getHomonimias();

//CREAR Y VER OFICIOS SOBRE LA SELECCIÓN ANTERIOR
// $oficio = array('nombre' => 'Grumete','Observaciones' => 'Sólo en barcos' );
// $prueba->setOficio($oficio);
//$prueba->getOficios();

//CREAR Y VER CARGOS DE LA SELECCIÓN ANTERIOR
// $cargo = array('cargo' => 'Mozo','fechainicio' => '1774-05-21','confianzafechainicio'=>2,'idinstituciones'=>9 );
// $prueba->setCargo($cargo);
//$prueba->getCargos();

//CREAR Y VER TITULOS DE LA SELECCIÓN ANTERIOR
// $titulos = array('denominacion' => 'Paseante','fechaconcesion'=>'1785-08-04','confianzafechaconcesion'=>2,'observaciones'=>'Sólo en corte' );
// $prueba->setTitulo($titulos);
//$prueba->getTitulos();

//CREAR Y VER PARIENTES DE LA SELECCIÓN ANTERIOR
//$pariente = array('idobjeto' => 24,'idtiporel'=> );

//$prueba->setObjeto(2);
// $objetos = $prueba->getObjetos();
// foreach ($objetos as $key => $value) {
//   echo $value['nombre'].'<br>';
// }

 ?>
