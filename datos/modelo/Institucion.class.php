<?php

class Institucion{
  public $idinstituciones;
  public $nombre;
  public $administracion;
  public $sede;
  function __construct($nuevo = false, $arrprop = false) {
    if ($nuevo) {
      $mbd = ConBD::conectaBD();
      $sentencia = $mbd->prepare("select nextval('datos.instituciones_idinstituciones_seq'::regclass);");
      $sentencia->execute();
      $mbd = null;
      $this->idinstituciones = $sentencia->fetch()['nextval'];
    }
    if ($arrprop) {
      $this->nombre = (isset($arrprop['nombre'])) ? $arrprop['nombre'] : NULL;
      $this->administracion = (isset($arrprop['administracion'])) ? $arrprop['administracion'] : NULL;
      $this->sede = (isset($arrprop['sede'])) ? $arrprop['sede'] : NULL;
    }
   }
   function almacena(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
         if ($valor) {
           $arrprop[strtolower($nombre)] = $valor;
         }
      }
     OperaBD::inserta('datos.instituciones',$arrprop);
   }
   function modifica(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
       if ($nombre != 'idinstituciones') {
          $arrprop[strtolower($nombre)] = $valor;
       }
      }
      $cual = array('idinstituciones'=>$this->idinstituciones);
     OperaBD::modifica('datos.instituciones',$arrprop,$cual);
   }
   function borra(){
      $cual = array('idinstituciones'=>$this->idinstituciones);
     OperaBD::borra('datos.instituciones',$cual);
   }
}

 ?>
