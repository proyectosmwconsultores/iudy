<?php
include("php/estructura/session.php");
require('php/clases/registro.php');
$Regis=new Registro();
$configuracion=$Regis->get_configuracionPri();
// $datos=$Regis->get_usuarioCode($cod);
if(isset($_POST["Mov"]) && ($_POST["Mov"] == "envContinuar")){
  $_SESSION["Folio"]=$_POST["Folio"];

  header("Location: registroDoc.php");
  exit;
}

if(isset($_POST["Mov"]) && ($_POST["Mov"] == "envCorreo")){
  $correo=$_POST["txtCorreo"];
  $Regis->env_correo_codigo($correo);

  exit;
}
?>
<html>
  <head>
    <meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Proceso de registro</title>
    <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">
    <meta content='assets/images/campus/logo_inicio.png' property='og:image'/>
    <meta name="description" content="Esta plataforma es capaz de crear tareas, foros, evaluaciones y tener los recursos de apoyo.  Con una estructura modular que hace posible su adaptacion a la realidad de los diferentes centros educativos" />
    <meta name="keywords" content="Sistema de educacion en linea, educacion, linea, educacion en linea, sistema" />
    <meta name="author" content="MWConsultores">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  </head>
  <style>

  .register-left img{
      margin-top: 1%;
      margin-bottom: 5%;
      width: 180px;
      -webkit-animation: mover 2s infinite  alternate;
      animation: mover 1s infinite  alternate;
  }
  @-webkit-keyframes mover {
      0% { transform: translateX(0); }
      100% { transform: translateX(-20px); }
  }
  @keyframes mover {
      0% { transform: translateX(0); }
      100% { transform: translateX(20px); }
  }

  </style>
  <body>
    <div class="container">
        <div id="loginbox" style="margin-top:50px; text-align: center;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 register-left">
          <img src="assets/images/campus/logo_inicio.png" style="width: 200px; ">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <center><div class="panel-title">Proceso de registro</div></center>
                    </div><br>
                    <b>Por favor escribe el n&uacute;mero de folio que te enviamos por correo para terminar el registro. </b>
                     <div style="padding-top:30px" class="panel-body" >
                        <form class="form-horizontal" name="frm" id="frm" action="continuar.php" method="POST" enctype="multipart/form-data">
                          <input id="Mov" name="Mov" value="" type="hidden"/>


                          <center>Ingresa tu folio aqu&iacute;</center><br>
                          <div class="col-sm-7" style="text-align: right; color: black;">
                            <input type="text" name="Folio" id="Folio" class="form-control" placeholder="Mi folio">
                          </div>
                          <div class="col-sm-5">
                          <button type="button" onClick="val_continuar()" class="btn btn-primary">CONTINUAR</button>
                          </div>
                          <br>
                          <hr>


                                                    <center><a href="continuar.php">¿No recuerdas tu <b>Folio</b>?</a></center><br>
                                                    <div class="col-sm-7" style="text-align: right; color: black;">
                                                      <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="Mi correo">
                                                    </div>
                                                    <div class="col-sm-5">
                                                      <button type="button" onClick="val_EnvCorreo()" class="btn btn-primary btn-success btn-sm">Enviar mi <b>folio</b> a mi correo</button>
                                                    </div>
                                                    <hr>
                                                    <?php if((isset($_GET["x"])) && ($_GET["x"] == 3)){ ?>
                                                      <div class="alert alert-info alert-dismissible">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                          <h4><i class="icon fa fa-info"></i> Folio enviado</h4>
                                                          Se ha enviado a su correo el folio de su registro.
                                                        </div>

                                                    <?php } ?>
<br><hr>


					</form>
				</div>
			</div>
    </div>
		</div>
  </body>
  <script>

  function val_continuar()
  {
  	if (document.frm.Folio.value.length==''){
          document.getElementById("Folio").focus();
          return 0;
      } else {
        document.frm.Mov.value='envContinuar';document.frm.submit();
      }
  }
  function val_EnvCorreo()
  {
    if (document.frm.txtCorreo.value.length==''){
          document.getElementById("txtCorreo").focus();
          return 0;
      } else {
        document.frm.Mov.value='envCorreo';document.frm.submit();
      }
  }


  </script>
</html>
