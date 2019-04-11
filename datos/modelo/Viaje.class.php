<?php

class Viaje {
  public $idviajes;
  public $fechainicio;
  public $fechafin;
  public $confianzafechainicio;
  public $confianzafechafin;
  public $motivoviaje;
  public $observaciones;
  public $decoro;
  public $realizado;
  public $observacionesdecoro;
  public $embarcaciones;
  public $honraydecoro;
  public $consejosviaje;
  private $mercanciastransportadas;
  private $recorrido;
  private $viajeros;
  function __construct($nuevo = false, $arrprop = false) {
    if ($nuevo) {
      $mbd = ConBD::conectaBD();
      $sentencia = $mbd->prepare("select nextval('datos.viajes_idviajes_seq'::regclass);");
      $sentencia->execute();
      $mbd = null;
      $this->idviajes = $sentencia->fetch()['nextval'];
    }
    if ($arrprop) {
      $this->fechainicio = (isset($arrprop['fechainicio'])) ? $arrprop['fechainicio'] : NULL;
      $this->fechafin = (isset($arrprop['fechafin'])) ? $arrprop['fechafin'] : NULL;
      $this->confianzafechainicio = (isset($arrprop['confianzafechainicio'])) ? $arrprop['confianzafechainicio'] : NULL;
      $this->confianzafechafin = (isset($arrprop['confianzafechafin'])) ? $arrprop['confianzafechafin'] : NULL;
      $this->motivoviaje = (isset($arrprop['motivoviaje'])) ? $arrprop['motivoviaje'] : NULL;
      $this->observaciones = (isset($arrprop['observaciones'])) ? $arrprop['observaciones'] : NULL;
      $this->decoro = (isset($arrprop['decoro'])) ? $arrprop['decoro'] : NULL;
      $this->observacionesdecoro = (isset($arrprop['observacionesdecoro'])) ? $arrprop['observacionesdecoro'] : NULL;
      $this->embarcaciones = (isset($arrprop['embarcaciones'])) ? $arrprop['embarcaciones'] : NULL;
      $this->honraydecoro = (isset($arrprop['honraydecoro'])) ? $arrprop['honraydecoro'] : NULL;
      $this->consejosviaje = (isset($arrprop['consejosviaje'])) ? $arrprop['consejosviaje'] : NULL;
      $this->realizado = (isset($arrprop['realizado'])) ? $arrprop['realizado'] : NULL;
    }
  }
  function almacena(){
    $arrprop;
    foreach ($this as $nombre => $valor) {
      if ($nombre != 'mercanciastransportadas' && $nombre != 'recorrido') { //esto hay que introducirlo utilizando su método
        if ($valor) {
          if (($nombre == 'embarcaciones' || $nombre == 'honraydecoro' || $nombre == 'consejosviaje') && is_array($valor)) {
            $arrprop[strtolower($nombre)] = '{'.implode(",",$valor).'}';
          }
          else if (($nombre == 'embarcaciones' || $nombre == 'honraydecoro' || $nombre == 'consejosviaje')) {
            $arrprop[strtolower($nombre)] = '{'.$valor.'}';
          }
          else{
            $arrprop[strtolower($nombre)] = $valor;
          }
        }
      }
     }
    OperaBD::inserta('datos.viajes',$arrprop);
  }
  function modifica(){
    $arrprop;
    foreach ($this as $nombre => $valor) {
      if ($nombre != 'mercanciastransportadas' && $nombre != 'recorrido' && $nombre != 'idviajes') {
         $arrprop[strtolower($nombre)] = $valor;
      }
     }
     $cual = array('idviajes'=>$this->idviajes);
    OperaBD::modifica('datos.viajes',$arrprop,$cual);
  }
  function borra(){
     $cual = array('idviajes'=>$this->idviajes);
    OperaBD::borra('datos.viajes',$cual);
  }
  function setMercanciaTransportada($arrmercancia){
    $arrmercancia['idviajes'] = $this->idviajes;
    OperaBD::inserta('datos.mercanciasybienes',$arrmercancia);
  }
  function getMercanciasTransportadas(){
    $arrid = array('idviajes' => $this->idviajes);
    $mercancias = OperaBD::selec('datos.mercanciasybienes',array('*'),null,$arrid);
    return $mercancias;
  }
  function setViajeros($arridpersonas){
    foreach ($arridpersonas as $key => $idpersona) {
      $arrviajero = array('idpersonas' => $idpersona,'idviajes'=>$this->idviajes );
      OperaBD::inserta('datos.viajeros',$arrviajero);
    }
  }
  function getViajeros(){
    $viajeros;
    $idviajeros = OperaBD::selec('datos.viajeros',array('idpersonas'),null,array('idviajes'=>$this->idviajes));
    foreach ($idviajeros as $key => $value) {
      $viajeros[] = OperaBD::selec('datos.personas',array('*'),'Persona',$value)[0];
    }
    return $viajeros;
  }
  function setRecorrido($arrgids){//NOTA: el orden de $arrgids determina la secuencia del viaje
    $i=0;
    foreach ($arrgids as $key => $gid) {
      ++$i;
      $recorrido = array('idviajes' => $this->idviajes,'gid'=>$gid,'orden'=>$i*10 );
      OperaBD::inserta('datos.recorrido',$recorrido);
    }
  }
  function getRecorrido(){
    $recorrido;
    $idrecorridos = OperaBD::selec('datos.recorrido',array('gid'),null,array('idviajes'=>$this->idviajes));
    foreach ($idrecorridos as $key => $value) {
      $recorrido[] = OperaBD::selec('datos.geometrias',array('gid,toponimo, st_asgeojson(geometrias.geom) as geojson'),null,$value)[0];
    }
    return $recorrido;
  }
}
?>
