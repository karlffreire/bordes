 <?php
require './datos/modelo/conexion.php';
$credenciales = explode('#',$_COOKIE["bordesarch"]);
if (!isset($_COOKIE["bordesarch"]) || $_SESSION['proyecto'] != 'bordes') {
  header('location:./entrando.php');
}
$menda = filter_var($credenciales[0], FILTER_SANITIZE_STRING);
$grupos = ConBD::miembroDe($menda);
$_SESSION["editor"] = false;
foreach ($grupos as $grupo) {
  if ($grupo == 'editor_bordes'){
    $_SESSION["editor"] = true;
  }
};

$edit = $_SESSION["editor"];
unset($_SESSION['persona']);
unset($_SESSION['carta']);
unset($_SESSION['acontecimiento']);
unset($_SESSION['institucion']);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="./css/estilo_index.css">
  <script type="text/javascript" src="./js/funBordes.js"></script>

</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50" >
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid todo">
      <div class="navbar-header">
        <a class="navbar-brand" href="./index.php"><i class="fa fa-home" aria-hidden="true"></i> Bordes del Archivo</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $menda;  ?></a>
          <ul class="dropdown-menu">
            <li><a href="./datos/desconexion.php">Desconectar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
<div class="container" style="margin-bottom:5em;">
  <div class="row" style="margin-top:150px;">
    <div class="col-md-8">
      <div class="row" style="text-align:center;">
        <div class="col-lg-6">
          <div class="icon-menu-init">
            <i class="fa fa-users fa-4x" style="margin-top:40px;"></i>
          </div>
          <h2>Personas</h2>
          <p>Visualizar y gestionar la información de personas incluidas en la base de datos.</p>
          <p><a class="btn btn-primary" href="./principal.php?p=personas&f=" role="button">Ver listado</a></p>
          <p><a class="btn btn-success" href="./nueva-personas.php" role="button">Añadir persona</a></p>
        </div>
        <div class="col-lg-6">
          <div class="icon-menu-init">
            <i class="fa fa-envelope fa-4x" style="margin-top:40px;"></i>
          </div>
          <h2>Cartas</h2>
          <p>Visualizar y gestionar la información de las cartas incluidas en la base de datos.</p>
          <p><a class="btn btn-primary" href="./principal.php?p=cartas&f=" role="button">Ver listado</a></p>
          <p><a class="btn btn-success" href="./nueva-cartas.php" role="button">Añadir carta</a></p>
        </div>
      </div>
      <div class="row">
        <hr style="border:solid 1px;">
      </div>
      <div class="row" style="display: flex;justify-content: space-between;">
        <h4>Visualización y gestión de otros datos:</h4>
      </div>
      <div class="row" style="display: flex;justify-content: space-between;margin-top:25px;">
        <p><a class="btn btn-primary" href="./principal.php?p=acontecimientos&f=" role="button">Acontecimientos</a></p>
        <p><a class="btn btn-primary" href="./principal.php?p=instituciones&f=" role="button">Instituciones</a></p>
      </div>
    </div>
    <div class="col-md-4" style="text-align:center;">
      <h2>Flujo de trabajo</h2>
      <div class="list-group"  style="margin-top:2em;">
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">1 - Introducir personas</h4>
          <p class="list-group-item-text">Para asignar un remitente y destinatario a las cartas es necesario que existan primero como personas en la base de datos.</p><p>¡Ten cuidado de no añadir dos veces a la misma persona!</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">2 - Introducir cartas</h4>
          <p class="list-group-item-text">Para asignar un viaje es necesario que exista primero la carta que lo describe en la base de datos.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">3 - Introducir viajes</h4>
          <p class="list-group-item-text">Los viajes se introducen desde el formulario de modificar cartas utilizando el botón  <i class="fa fa-map-signs" title="Viajes"></i>.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Otros elementos</h4>
          <p class="list-group-item-text">Los acontecimientos y las instituciones se deben introducir previamente para que aparezcan en los desplegables de cartas y personas.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Notas</h4>
          <p class="list-group-item-text">El resto de elementos, mercancías, menciones, objetos, cargos, títulos, parientes o propiedades se rellenan desde las opciones de modificar cartas y personas.</p><p class="list-group-item-text">Es obligatorio rellenar todos los campos con * </p>
        </a>
      </div>
    </div>
  </div>
</div>


<footer>
  <p style="padding-top: 10px;">Unidad de SIG<a href="http://unidadsig.cchs.csic.es/sig/" style="margin-left: 80px;"><img src="./img/logo_usig.png" style="height: 35px;" /></a></p>
</footer>
</body>
</html>
