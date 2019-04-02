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
<div class="container">
  <div class="row" style="margin-top:150px;text-align:center;">
    <div class="col-lg-6">
      <div class="icon-menu-init">
        <i class="fa fa-users fa-4x" style="margin-top:40px;"></i>
      </div>
      <h2>Personas</h2>
      <p>Visualizar y gestionar la información de personas incluidas en la base de datos.</p>
      <p><a class="btn btn-default" href="./principal.php?p=personas&f=" role="button">Lista</a></p>
      <p><a class="btn btn-default" href="./nueva-persona.php" role="button">Añadir</a></p>
    </div>
    <div class="col-lg-6">
      <div class="icon-menu-init">
        <i class="fa fa-envelope fa-4x" style="margin-top:40px;"></i>
      </div>
      <h2>Cartas</h2>
      <p>Visualizar y gestionar la información de las cartas incluidas en la base de datos.</p>
      <p><a class="btn btn-default" href="./principal.php?p=cartas&f=" role="button">Lista</a></p>
      <p><a class="btn btn-default" href="./nueva-carta.php" role="button">Añadir</a></p>
    </div>
    <!-- <div class="col-lg-4">
      <div class="icon-menu-init">
        <i class="fa fa-map-signs fa-4x" style="margin-top:40px;"></i>
      </div>
      <h2>Viajes</h2>
      <p>Visualizar y gestionar la información de los viajes incluidos en la base de datos.</p>
      <p><a class="btn btn-default" href="./principal.php?p=viajes" role="button">Viajes</a></p>
    </div> -->
  </div>
  <div class="row">
    <hr style="border:solid 1px;">
  </div>
  <div class="row" style="display: flex;justify-content: space-between;">
    <h4>Visualización y gestión de otros datos:</h4>
  </div>
  <div class="row" style="display: flex;justify-content: space-between;margin-top:25px;">
    <p><a class="btn btn-default" href="./principal.php?p=acontecimientos&f=" role="button">Acontecimientos</a></p>
    <p><a class="btn btn-default" href="./principal.php?p=instituciones&f=" role="button">Instituciones</a></p>
  </div>
</div>


<footer>
  <p style="padding-top: 10px;">Unidad de SIG<a href="http://unidadsig.cchs.csic.es/sig/" style="margin-left: 80px;"><img src="./img/logo_usig.png" style="height: 35px;" /></a></p>
</footer>
</body>
</html>
