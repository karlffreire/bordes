<?php
$fallo = $_GET['fallo'];
if (isset($_COOKIE["bordes"])) {
  $credenciales = explode('#',$_COOKIE["bordes"]);
  session_start();
  $usedired = false;
  if (isset($_SESSION['proyecto']) && $_SESSION['proyecto']=='bordes') {
    $grupos = miembroDe($credenciales[0]);
    foreach ($grupos as $grupo) {
      if ($grupo == 'lector_bordes' || $grupo == 'editor_bordes'){
        $usedired = true;
      }
    };
  }
  if ($usedired) {
    header('location:./index.php');
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Entrada</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/estilo_index.css">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid todo">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Bordes del Archivo: Identificación</a>
        </div>
        <div class="navbar-header navbar-right">
          <a href="http://unidadsig.cchs.csic.es/sig/"><img src="./img/logo_usig.png" style="height: 35px;margin-top: 5px;cursor: pointer;" /></a>
        </div>
      </div>
    </nav>
    <div class="container">
        <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3">
            <div class="panel-body" style="margin-top: 100px;">
            <?php
            	if ($fallo == 'su') {
            		echo "<strong>No te puedes registrar como superusuario</strong>";
            	}
            	if ($fallo == 'ident') {
            		echo "<strong>Usuario o contraseña incorrectos</strong>";
            	}
            ?>
                <form method="POST" action='./datos/pas_ctr.php'>
                    <div class="form-group required">
                        <label class="control-label col-md-4">Nombre usuario</label>
                        <div class="controls col-md-12 ">
                            <input class="form-control" name="usr" value="" style="margin-bottom: 10px" type="text" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-md-4">Contraseña</label>
                        <div class="controls col-md-12 ">
                            <input type="password" class="form-control" name="ctr" value="" style="margin-bottom: 10px" type="text" />
                        </div>
                    </div>
                    <div class="col-md-8 ">
                        <input type="submit" value="Iniciar sesión" class="btn btn-success" />
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-4 col-md-offset-2" style="margin-top: 50px;">
                Utiliza tu usuario de la base de datos de Bordes del Archivo.<br>Si no sabes cuál es, ponte en contacto con la Unidad SIG.
            </div>
            <div class="col-md-4" style="margin-top: 50px;text-align: center;">
                Es mejor si usas Firefox o Chrome<br><img src="./img/firefoxchrome.jpg">
            </div>
        </div>
    </div>
</body>
</html>
