<?php
class Persona{
  public $idpersona;
  public $nombre;
  public $apellidos;
  public $nacionalidad;
  public $genero;
  public $profesion;
  public $fechanacimiento;
  public $lugarnacimiento;
  public $fechadefuncion;
  public $lugardefuncion;
  public $objetos;
  public $urlimagen;
  public $confianzafechanacimiento;
  public $confianzafechadefuncion;
  public $tipopersona;
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
      $this->idpersona = $sentencia->fetch()['nextval'];
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
      $this->objetos = (isset($arrprop['objetos'])) ? $arrprop['objetos'] : NULL;
      $this->urlimagen = (isset($arrprop['urlimagen'])) ? $arrprop['urlimagen'] : NULL;
      $this->confianzafechanacimiento = (isset($arrprop['confianzafechanacimiento'])) ? $arrprop['confianzafechanacimiento'] : NULL;
      $this->confianzafechadefuncion = (isset($arrprop['confianzafechadefuncion'])) ? $arrprop['confianzafechadefuncion'] : NULL;
      $this->tipopersona = (isset($arrprop['tipopersona'])) ? $arrprop['tipopersona'] : NULL;
    }
  }

}



 ?>
