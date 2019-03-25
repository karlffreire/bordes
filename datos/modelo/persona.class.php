<?php
class Persona{
  public $idpersonas;
  public $nombre;
  public $apellidos;
  public $nacionalidad;
  public $genero;
  public $profesion;
  public $fechanacimiento;
  public $lugarnacimiento;
  public $fechadefuncion;
  public $lugardefuncion;
  public $urlimagen;
  public $confianzafechanacimiento;
  public $confianzafechadefuncion;
  public $tipopersona;
  private $propiedades;
  private $ejerce;
  private $ostenta;
  private $titulos;
  private $homonimia;
  function __construct($nuevo = false, $arrprop = false) {
    if ($nuevo) {
      $mbd = ConBD::conectaBD();
      $sentencia = $mbd->prepare("select nextval('datos.personas_idpersonas_seq'::regclass);");
      $sentencia->execute();
      $mbd = null;
      $this->idpersonas = $sentencia->fetch()['nextval'];
    }
    if ($arrprop) {
      $this->nombre = (isset($arrprop['nombre'])) ? $arrprop['nombre'] : NULL;
      $this->apellidos = (isset($arrprop['apellidos'])) ? $arrprop['apellidos'] : NULL;
      $this->nacionalidad = (isset($arrprop['nacionalidad'])) ? $arrprop['nacionalidad'] : NULL;
      $this->genero = (isset($arrprop['genero'])) ? $arrprop['genero'] : NULL;
      $this->profesion = (isset($arrprop['profesion'])) ? $arrprop['profesion'] : NULL;
      $this->fechanacimiento = (isset($arrprop['fechanacimiento'])) ? $arrprop['fechanacimiento'] : NULL;
      $this->lugarnacimiento = (isset($arrprop['lugarnacimiento'])) ? $arrprop['lugarnacimiento'] : NULL;
      $this->fechadefuncion = (isset($arrprop['fechadefuncion'])) ? $arrprop['fechadefuncion'] : NULL;
      $this->lugardefuncion = (isset($arrprop['lugardefuncion'])) ? $arrprop['lugardefuncion'] : NULL;
      $this->propiedades = (isset($arrprop['propiedades'])) ? $arrprop['propiedades'] : NULL;
      $this->urlimagen = (isset($arrprop['urlimagen'])) ? $arrprop['urlimagen'] : NULL;
      $this->confianzafechanacimiento = (isset($arrprop['confianzafechanacimiento'])) ? $arrprop['confianzafechanacimiento'] : NULL;
      $this->confianzafechadefuncion = (isset($arrprop['confianzafechadefuncion'])) ? $arrprop['confianzafechadefuncion'] : NULL;
      $this->tipopersona = (isset($arrprop['tipopersona'])) ? $arrprop['tipopersona'] : NULL;
    }
  }
  function almacena(){
    $arrprop;
    foreach ($this as $nombre => $valor) {
      if ($nombre != 'ejerce' && $nombre != 'ostenta' && $nombre != 'titulos' && $nombre != 'homonimia') { //esto hay que introducirlo utilizando su método
        if ($valor) {
          $arrprop[strtolower($nombre)] = $valor;
        }
      }
     }
    OperaBD::inserta('datos.personas',$arrprop);
  }
  function modifica(){
    $arrprop;
    foreach ($this as $nombre => $valor) {
      if ($nombre != 'ejerce' && $nombre != 'ostenta' && $nombre != 'titulos' && $nombre != 'homonimia') {
         $arrprop[strtolower($nombre)] = $valor;
      }
     }
     $cual = array('idpersonas'=>$this->idpersonas);
    OperaBD::modifica('datos.personas',$arrprop,$cual);
  }
  function borra(){
     $cual = array('idpersonas'=>$this->idpersonas);
    OperaBD::borra('datos.personas',$cual);
  }
  function getNacionalidad(){
    $campo = array('pais');
    $id = array('idpaises' => $this->nacionalidad);
    $txtnac = OperaBD::selec('datos.paises',$campo,null,$id)[0];
    return $txtnac['pais'];
  }
  function setHomonimia($arrhomonimia){//$arrhomonimia: array asociativo con el nombre del campo en la clave y el valor en el valor
    $arrhomonimia['idpersonas'] = $this->idpersonas;
    OperaBD::inserta('datos.homonimias',$arrhomonimia);
  }
  function getHomonimias(){
    $campos = array('tipohomonimia','nombre','apellidos');
    $id = array('idpersonas' => $this->idpersonas );
    $orden = array('tipohomonimia');
    $homonimias = OperaBD::selec('datos.homonimias',$campos,null,$id,$orden);
    return $homonimias;
  }
  function setOficio($arroficio){//$arroficio: array asociativo con el nombre del campo en la clave y el valor en el valor
    $arroficio['idpersonas'] = $this->idpersonas;
    OperaBD::inserta('datos.oficio',$arroficio);
  }
  function getOficios(){
    $campos = array('nombre','observaciones');
    $id = array('idpersonas' => $this->idpersonas );
    $orden = array('nombre');
    $oficios = OperaBD::selec('datos.oficio',$campos,null,$id,$orden);
    return $oficios;
  }
  function setCargo($arrcargo){//$arrcargo: array asociativo con el nombre del campo en la clave y el valor en el valor
    $arrcargo['idpersonas'] = $this->idpersonas;
    OperaBD::inserta('datos.cargos',$arrcargo);
  }
  function getCargos(){
    $campos = array('cargo','fechainicio','confianzafechainicio','fechafin','confianzafechafin','instituciones.nombre');
    $id = array('idpersonas' => $this->idpersonas );
    $orden = array('fechainicio');
    $cargos = OperaBD::selec('datos.cargos INNER JOIN datos.instituciones ON cargos.idinstituciones = instituciones.idinstituciones',$campos,null,$id,$orden);
    return $cargos;
  }
  function setTitulo($arrtitulo){//$arrtitulo: array asociativo con el nombre del campo en la clave y el valor en el valor
    $arrtitulo['idpersonas'] = $this->idpersonas;
    OperaBD::inserta('datos.titulos',$arrtitulo);
  }
  function getTitulos(){
    $campos = array('denominacion','fechaconcesion','confianzafechaconcesion','fechadesposesion','confianzafechadesposesion','observaciones');
    $id = array('idpersonas' => $this->idpersonas );
    $orden = array('fechaconcesion');
    $titulos = OperaBD::selec('datos.titulos',$campos,null,$id,$orden);
    return $titulos;
  }
  function setPropiedad($arrobjeto){//$arrobjeto: array asociativo con el nombre del campo en la clave y el valor en el valor
    $arrobjeto['idpersonas'] = $this->idpersonas;
    OperaBD::inserta('datos.personasobjetos',$arrobjeto);
  }
  function getPropiedades(){
    $objetos;
    $id = array('idpersonas' => $this->idpersonas );
    $arrprop =  array('idobjetos');
    $idsobjetos = OperaBD::selec('datos.personasobjetos',$arrprop,null,$id);
    foreach ($idsobjetos as $key => $value) {
      $objetos[] = OperaBD::selec('datos.objetos',array('nombre'),null,$value)[0];
    }
    return $objetos;
  }
  function setPariente($arrpariente){//$arrpariente: array asociativo con el nombre del campo en la clave y el valor en el valor
    $arrpariente['idsujeto'] = $this->idpersonas;
    OperaBD::inserta('datos.parentesco',$arrpariente);
  }
  function getParientes(){
    $campos = array('idsujeto','idobjeto','idtiporel');//¿NO SERÍA MEJOR UNA FUNCIÓN ALMACENADA EN BASE DE DATOS, QUE DEVUELVA LOS IDPERSONAS?
    $condicion = array('idsujeto' => $this->idpersonas,'idobjeto' => $this->idpersonas );
    $parientes = OperaBD::selec('datos.parentesco',$campos,null,$condicion,null,'OR');
    return $parientes;
  }
}



 ?>
