<?php

class Carta {
  public $idcartas;
  public $identificador;
  public $numeroregistro;
  public $lugaremision;
  public $lugarrecepcion;
  public $asunto;
  public $asuntoclave;
  public $fecha;
  public $notas;
  public $pagina;
  public $palabrasclave;
  public $observacioneshonra;
  public $urlimagen;
  public $tramiteslegales;
  private $objetos;
  private $mercanciassolicitadas;
  function __construct($nuevo = false, $arrprop = false) {
    if ($nuevo) {
      $mbd = ConBD::conectaBD();
      $sentencia = $mbd->prepare("select nextval('datos.cartas_idcartas_seq'::regclass);");
      $sentencia->execute();
      $mbd = null;
      $this->idcartas = $sentencia->fetch()['nextval'];
    }
    if ($arrprop) {
      $this->identificador = (isset($arrprop['identificador'])) ? $arrprop['identificador'] : NULL;
      $this->numeroregistro = (isset($arrprop['numeroregistro'])) ? $arrprop['numeroregistro'] : NULL;
      $this->lugaremision = (isset($arrprop['lugaremision'])) ? $arrprop['lugaremision'] : NULL;
      $this->lugarrecepcion = (isset($arrprop['lugarrecepcion'])) ? $arrprop['lugarrecepcion'] : NULL;
      $this->asunto = (isset($arrprop['asunto'])) ? $arrprop['asunto'] : NULL;
      $this->asuntoclave = (isset($arrprop['asuntoclave'])) ? $arrprop['asuntoclave'] : NULL;
      $this->fecha = (isset($arrprop['fecha'])) ? $arrprop['fecha'] : NULL;
      $this->notas = (isset($arrprop['notas'])) ? $arrprop['notas'] : NULL;
      $this->pagina = (isset($arrprop['pagina'])) ? $arrprop['pagina'] : NULL;
      $this->palabrasclave = (isset($arrprop['palabrasclave'])) ? $arrprop['palabrasclave'] : NULL;
      $this->observacioneshonra = (isset($arrprop['observacioneshonra'])) ? $arrprop['observacioneshonra'] : NULL;
      $this->urlimagen = (isset($arrprop['urlimagen'])) ? $arrprop['urlimagen'] : NULL;
      $this->tramiteslegales = (isset($arrprop['tramiteslegales'])) ? $arrprop['tramiteslegales'] : NULL;
    }
   }
   function almacena(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
       if ($nombre != 'mercanciassolicitadas' && $nombre != 'objetos') { //esto hay que introducirlo utilizando su método
         if ($valor) {
           if (($nombre == 'palabrasclave' || $nombre == 'tramiteslegales') && is_array($valor)) {
             $arrprop[strtolower($nombre)] = '{'.implode(",",$valor).'}';
           }
           else{
             $arrprop[strtolower($nombre)] = $valor;
           }
         }
       }
      }
     OperaBD::inserta('datos.cartas',$arrprop);
   }
   function modifica(){
     $arrprop;
     foreach ($this as $nombre => $valor) {
       if ($nombre != 'mercanciassolicitadas' && $nombre != 'objetos' && $nombre != 'idcartas') {
          $arrprop[strtolower($nombre)] = $valor;
       }
      }
      $cual = array('idcartas'=>$this->idcartas);
     OperaBD::modifica('datos.cartas',$arrprop,$cual);
   }
   function borra(){
      $cual = array('idcartas'=>$this->idcartas);
     OperaBD::borra('datos.cartas',$cual);
   }
   function setObjeto($idobjeto){//$arrobjeto: array asociativo con el nombre del campo en la clave y el valor en el valor
     $arrobjeto['idpersonas'] = $this->idpersonas;
     OperaBD::inserta('datos.objetoscartas',$arrobjeto);
   }
   function getObjetos(){
     $objetos;
     $id = array('idcartas' => $this->idcartas );
     $arrprop =  array('idobjetos');
     $idsobjetos = OperaBD::selec('datos.objetoscartas',$arrprop,null,$id);
     foreach ($idsobjetos as $key => $value) {
       $objetos[] = OperaBD::selec('datos.objetos',array('nombre'),null,$value)[0];
     }
     return $objetos;
   }
   function setMercanciaSolicitada($arrmercancia){
     $arrmercancia['idcartas'] = $this->idcartas;
     OperaBD::inserta('datos.mercanciasybienes',$arrmercancia);
   }
   function getMercanciasSolicitadas(){
     $arrid = array('idcartas' => $this->idcartas);
     $mercancias = OperaBD::selec('datos.mercanciasybienes',array('*'),null,$arrid);
     return $mercancias;
   }
   function setEmisor($idpersona){
     $arremite = array('idpersonas'=>$idpersona,'idcartas'=>$this->idcartas,'rolpersona'=>'Emisor');
     OperaBD::inserta('datos.cartaspersonas',$arremite);
   }
   function getEmisor(){
     $idemisor = OperaBD::selec('datos.cartaspersonas',array('idpersonas'),null,array('idcartas'=>$this->idcartas, 'rolpersona'=>'Emisor'))[0];
     $arridemisor = array('idpersonas'=>$idemisor['idpersonas']);
     $emisor = OperaBD::selec('datos.personas',array('*'),'Persona',$arridemisor);
     return $emisor;
   }
   function setReceptor($idpersona){
     $arrrecibe = array('idpersonas'=>$idpersona,'idcartas'=>$this->idcartas,'rolpersona'=>'Receptor');
     OperaBD::inserta('datos.cartaspersonas',$arrrecibe);
   }
   function getReceptor(){
     $idreceptor = OperaBD::selec('datos.cartaspersonas',array('idpersonas'),null,array('idcartas'=>$this->idcartas, 'rolpersona'=>'Receptor'))[0];
     $arridreceptor = array('idpersonas'=>$idreceptor['idpersonas']);
     $receptor = OperaBD::selec('datos.personas',array('*'),'Persona',$arridreceptor);
     return $receptor;
   }
   function setMenciones($arridpersonas){
     foreach ($arridpersonas as $key => $idpersona) {
       $arrmenciona = array('idpersonas'=>$idpersona,'idcartas'=>$this->idcartas,'rolpersona'=>'Otro');
       OperaBD::inserta('datos.cartaspersonas',$arrmenciona);
     }
   }
   function getMenciones(){
     $mencionados;
     $idmenciones = OperaBD::selec('datos.cartaspersonas',array('idpersonas'),null,array('idcartas'=>$this->idcartas, 'rolpersona'=>'Otro'));
     foreach ($idmenciones as $key => $value) {
       $mencionados[] = OperaBD::selec('datos.personas',array('*'),'Persona',$value,null,'OR')[0];
     }
     return $mencionados;
   }
}
?>
