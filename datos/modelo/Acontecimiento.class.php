<?php

class Acontecimiento{
  public $idacontecimiento;
  public $nombre;
  public $fecha;
  public $confianzafecha;
  public $lugar;
  function __construct($nuevo = false, $arrprop = false) {
    if ($nuevo) {
      $mbd = ConBD::conectaBD();
      $sentencia = $mbd->prepare("select nextval('datos.acontecimiento_idacontecimiento_seq'::regclass);");
      $sentencia->execute();
      $mbd = null;
      $this->idacontecimiento = $sentencia->fetch()['nextval'];
    }
    if ($arrprop) {
      $this->nombre = (isset($arrprop['nombre'])) ? $arrprop['nombre'] : NULL;
      $this->fecha = (isset($arrprop['fecha'])) ? $arrprop['fecha'] : NULL;
      $this->confianzafecha = (isset($arrprop['confianzafecha'])) ? $arrprop['confianzafecha'] : NULL;
      $this->lugar = (isset($arrprop['lugar'])) ? $arrprop['lugar'] : NULL;
    }
   }
   function almacena(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
         if ($valor) {
           $arrprop[strtolower($nombre)] = $valor;
         }
      }
     OperaBD::inserta('datos.acontecimiento',$arrprop);
   }
   function modifica(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
       if ($nombre != 'idacontecimiento') {
          $arrprop[strtolower($nombre)] = $valor;
       }
      }
      $cual = array('idacontecimiento'=>$this->idacontecimiento);
     OperaBD::modifica('datos.acontecimiento',$arrprop,$cual);
   }
   function borra(){
      $cual = array('idacontecimiento'=>$this->idacontecimiento);
     OperaBD::borra('datos.acontecimiento',$cual);
   }
   function getCartas(){
     $cartas;
     $idcartas = OperaBD::selec('datos.cartasacontecimiento',array('idcartas'),null,array('idacontecimiento'=>$this->idacontecimiento));
     foreach ($idcartas as $key => $value) {
       $cartas[] = OperaBD::selec('datos.cartas',array('*'),'Carta',$value)[0];
     }
     return $cartas;
   }
   function setLugar($lugar,$nuevo=false){//REQUIERE UN ARRAY ASOCIATIVO CON nombre, tipolugar, gid. Modifica el objeto pero no la BD. Si no es nuevo, $lugar es sólo un id
     if (!$nuevo) {
       $this->lugaremision = $lugar;
     }
     else {
       $mbd = ConBD::conectaBD();
       $sentencia = $mbd->prepare("select nextval('datos.ciudadesnuevas_id_seq'::regclass);");
       $sentencia->execute();
       $idlugar = $sentencia->fetch()['nextval'];
       $lugar['idlugares']=$idlugar;
       $insertlugar = OperaBD::inserta('datos.lugares',$lugar);
       $mbd = null;
       if (!$insertlugar) {
         $this->lugar = $idlugar;
       }
       else {
         return 'Error al insertar el lugar';
       }
     }
   }
}

 ?>
