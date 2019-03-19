<?php

class Carta {
  public $idcartas;
  public $identificador;
  public $numeroRegistro;
  public $lugarEmision;
  public $lugarRecepcion;
  public $asunto;
  public $asuntoClave;
  public $fecha;
  public $notas;
  public $pagina;
  public $palabrasClave;
  public $observacionesHonra;
  public $urlImagen;
  public $objetos;
  private $mercanciasYBienes;
  private $tramitesLegales;
  function __construct() {
    $mbd = ConBD::conectaBD();
    $sentencia = $mbd->prepare("select nextval('datos.cartas_idcartas_seq'::regclass);");
    $sentencia->execute();
    $mbd = null;
    $this->idcartas = $sentencia->fetch()['nextval'];
   }
   function almacena(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
       if ($nombre != 'mercanciasYBienes' && $nombre != 'tramitesLegales') { //esto hay que introducirlo utilizando su método
         if ($valor) {
           $arrprop[strtolower($nombre)] = $valor;
         }
       }
      }
     OperaBD::inserta('datos.cartas',$arrprop);
   }


}
?>
