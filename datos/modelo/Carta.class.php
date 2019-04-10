<?php

class Carta {
  public $idcartas;
  public $identificador;
  public $idemisor;
  public $idreceptor;
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
      $this->idemisor =  (isset($arrprop['idemisor'])) ? $arrprop['idemisor'] : NULL;
      $this->idreceptor =  (isset($arrprop['idreceptor'])) ? $arrprop['idreceptor'] : NULL;
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
           else if (($nombre == 'palabrasclave' || $nombre == 'tramiteslegales')){
             $arrprop[strtolower($nombre)] = '{'.$valor.'}';
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
         if (($nombre == 'palabrasclave' || $nombre == 'tramiteslegales') && is_array($valor)) {
           $arrprop[strtolower($nombre)] = '{'.implode(",",$valor).'}';
         }
         else if (($nombre == 'palabrasclave' || $nombre == 'tramiteslegales')){
           $arrprop[strtolower($nombre)] = '{'.$valor.'}';
         }
         else {
           $arrprop[strtolower($nombre)] = $valor;
         }
       }
      }
      $cual = array('idcartas'=>$this->idcartas);
     OperaBD::modifica('datos.cartas',$arrprop,$cual);
   }
   function borra(){//COMPROBAR PRIMERO SI TIENE VIAJES
     $viajes = OperaBD::selec('datos.cartasviajes',array('idviajes'),null,array('idcartas'=>$this->idcartas));
     if ($viajes) {
       return 'No se puede borrar porque tiene viajes asociados';
     }
     else {
       $cual = array('idcartas'=>$this->idcartas);
       $resultado =  OperaBD::borra('datos.cartas',$cual);
       return $resultado;
     }
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
     if (isset($objetos)) {
       return $objetos;
     }
     return null;
   }
   function setMercanciaSolicitada($arrmercancia){
     $arrmercancia['idcartas'] = $this->idcartas;
     OperaBD::inserta('datos.mercanciasybienes',$arrmercancia);
   }
   function getMercanciasSolicitadas(){
     $arrid = array('idcartas' => $this->idcartas);
     $mercancias = OperaBD::selec('datos.mercanciasybienes',array('*'),null,$arrid);
     if ($mercancias) {
       return $mercancias;
     }
     return null;
   }
   function getEmisor(){
     $arridemisor = array('idpersonas'=>$this->idemisor);
     $emisor = OperaBD::selec('datos.personas',array('*'),'Persona',$arridemisor)[0];
     if ($emisor) {
       return $emisor;
     }
     return null;
   }
   function getReceptor(){
     $arridreceptor = array('idpersonas'=>$this->idreceptor);
     $receptor = OperaBD::selec('datos.personas',array('*'),'Persona',$arridreceptor)[0];
     if ($receptor) {
       return $receptor;
     }
     return null;
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
       $mencionados[] = OperaBD::selec('datos.personas',array('*'),'Persona',$value)[0];
     }
     if (isset($mencionados)) {
       return $mencionados;
     }
     return null;
   }
   function setLugarEmision($lugar,$nuevo=false){//REQUIERE UN ARRAY ASOCIATIVO CON nombre, tipolugar, gid. Modifica el objeto pero no la BD. Si no es nuevo, $lugar es sólo un id
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
         $this->lugaremision = $idlugar;
       }
       else {
         return 'Error al insertar el lugar';
       }
     }
   }
   function getLugarEmision(){
     if($this->lugaremision == NULL){
       return NULL;
     }
     $idlugar = array('idlugares'=>$this->lugaremision);
     $lugar = OperaBD::selec('datos.lugares inner join datos.geometrias on lugares.gid = geometrias.gid',array('nombre, tipolugar,toponimo, st_asgeojson(geometrias.geom) as geojson'),null,$idlugar)[0];
     return $lugar;
   }
   function getLugarRecepcion(){
     if($this->lugarrecepcion == NULL){
       return NULL;
     }
     $idlugar = array('idlugares'=>$this->lugarrecepcion);
     $lugar = OperaBD::selec('datos.lugares inner join datos.geometrias on lugares.gid = geometrias.gid',array('nombre, tipolugar,toponimo, st_asgeojson(geometrias.geom) as geojson'),null,$idlugar)[0];
     if ($lugar) {
       return $lugar;
     }
     return null;
   }
   function setLugarRecepcion($lugar,$nuevo = false){//REQUIERE UN ARRAY ASOCIATIVO CON nombre, tipolugar, gid. Modifica el objeto pero no la BD. Si no es nuevo, $lugar es sólo un id
     if (!$nuevo) {
       $this->lugarrecepcion = $lugar;
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
         $this->lugarrecepcion = $idlugar;
       }
       else {
         return 'Error al insertar el lugar';
       }
     }
   }
   function setViaje($idviajes){
     $arrcartasviajes = array('idviajes' => $idviajes,'idcartas'=>$this->idcartas);
     OperaBD::inserta('datos.cartasviajes',$arrcartasviajes);
   }
   function getViajes(){
     $viajes;
     $idmenciones = OperaBD::selec('datos.cartasviajes',array('idviajes'),null,array('idcartas'=>$this->idcartas));
     foreach ($idmenciones as $key => $value) {
       $viajes[] = OperaBD::selec('datos.viajes',array('*'),'Viaje',$value)[0];
     }
     if (isset($viajes)) {
       return $viajes;
     }
     return null;
   }
   function setAcontecimiento($idacontecimiento){
     $arrcartasacontecimiento = array('idacontecimiento' => $idacontecimiento,'idcartas'=>$this->idcartas);
     OperaBD::inserta('datos.cartasacontecimiento',$arrcartasacontecimiento);
   }
   function getAcontecimientos(){
     $acontecimientos;
     $idacontecimientos = OperaBD::selec('datos.cartasacontecimiento',array('idacontecimiento'),null,array('idcartas'=>$this->idcartas));
     foreach ($idacontecimientos as $key => $value) {
       $acontecimientos[] = OperaBD::selec('datos.acontecimiento',array('*'),'Acontecimiento',$value)[0];
     }
     if (isset($acontecimientos)) {
       return $acontecimientos;
     }
     return null;
   }
}
?>
