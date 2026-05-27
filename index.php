<?php
include("php/estructura/session.php");
require('php/clases/login.php');
$log=new Login();
if(isset($_POST["txtUser"]) and isset($_POST["txtPass"]))
{
    $log->logueo();
}

if(isset($_SESSION['IdUsua'])){
  if(($_SESSION['Permisos'] == 2) || ($_SESSION['Permisos'] == 4)) {
    if($_SESSION['Permisos'] == 4){
      header("Location:viewSupervisor.php");
    }
    header("Location:misClases.php");

  }elseif($_SESSION['Permisos'] == 3) {

    $_SESSION['Tipo'] = 2;
    header("Location:clase.php");
  } else {
      $_SESSION['Tipo'] = 1;
      header("Location:welcome.php");
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>INGRESAR</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">
<meta name="description" content="Plataforma de gestión, cuenta con módulos para el proceso de admisiones, finanzas, servicios escolares, académicos y seguimiento al desempeño, así cómo aula virtual para el docente y alumno." />
<meta name="keywords" content="MWComenius" />
<meta name="author" content="MWConsultores">
<!-- Bootstrap Core CSS -->
<link href="dist/login/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<!-- <link href="css/animate.css" rel="stylesheet"> -->
<!-- Custom CSS -->
<link href="dist/login/style.css" rel="stylesheet">
<script src="assets/alert/dist/sweetalert-dev.js"></script>
<link rel="stylesheet" href="assets/alert/dist/sweetalert.css">

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="new-login-register">
      <div class="lg-info-panel">
              <div class="inner-panel">
                  <a href="javascript:void(0)" class="p-20 di"></a>
                  <div class="lg-content">
                      <h2><br><br></h2><br><br>
                      <p>
                          <!--Es una plataforma tecnológica educativa que permite facilitar el proceso de enseñanza-aprendizaje obteniendo el mejor y mayor resultado.

Es una plataforma en el que fácilmente se pueden crear y organizar todas las actividades de aprendizaje, evaluando a los estudiantes, fomentando el trabajo colaborativo o dando seguimiento al desempeño y logro de los alumnos.

¡Bienvenidos a su portal!-->
</p>
                  </div>
              </div>
      </div>
      <div class="new-login-box">
                <div class="white-box">
                  <p onClick="window.open('./','_self')" href="javascript:void(0);" style="cursor: pointer; text-align: center;"><img src="assets/images/campus/logo_inicio.png" style="width: 100%"></p>

                  <?php if((isset($_GET['x'])) && ($_GET['x'] == 5)){ ?><small style="text-align: justify; color: blue; font-size: 14px;">Estimado usuario su <b>registro ha sido exitoso</b>, favor de <b>revisar su correo</b> ya que se le ha enviado sus datos de acceso, en caso de no ver el correo, revisar en <b>correos no deseados</b>.</small><?php } ?>
                    <?php if((isset($_GET['x'])) && ($_GET['x'] == 6)){ ?><small style="text-align: justify; color: blue; font-size: 14px;">Estimado docente su <b>registro ha sido exitoso</b>, favor de <b>revisar su correo</b> ya que se le ha enviado sus datos de acceso, en caso de no ver el correo, revisar en <b>correos no deseados</b>.</small><?php } ?>
                  <form class="form-horizontal new-lg-form" action="index.php" name='test' method='post' class='form-validate' id="loginform">
                    <input type="hidden" name="Mov" id="Mov">
                    <h3 class="box-title m-b-0" style="text-align: center;">Iniciar sesión</h3>
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>Usuario:</label>
                        <input name="txtUser" id="txtUser" class="form-control" type="text" required="" placeholder="Usuario">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>Password:</label>
                        <input name="txtPass" id="txtPass" class="form-control" type="password" required="" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> ¿Olvido su contraseña?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Ingresar</button>
                      </div>
                    </div><!--
                    <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                        <p>¿Soy un alumno nuevo? <a onClick="window.open('registroAlumno.php','_self')" href="javascript:void(0);" class="text-primary m-l-5"><b>Registrate</b></a></p>
                      </div>
                    </div>-->
                  </form>
                  <form class="form-horizontal" id="recoverform" action="index.php">
                    <input type="hidden" name="Mov" id="Mov">
                    <h3 class="box-title m-b-0" style="text-align: center;">Recuperar acceso</h3>

                    <div class="form-group ">
                      <div class="col-xs-12">
                        <p class="text-muted">Ingrese su correo electrónico y se le enviarán su password. </p>
                      </div>
                    </div>
                    <div class="form-group text-center m-t-20" id='btn_img1' style="display: none;">
                      <div class="col-xs-12">
                        <img src="assets/images/procesando.gif">
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" name="txt_emails" id='txt_emails' type="text" required="" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button id='btn1' class="btn btn-primary btn-lg btn-block waves-effect waves-light" type="button" onclick="recuperarMails()">Recuperar password</button>
                        <button id='btn2' onClick="window.open('./','_self')" href="javascript:void(0);" style="display: none;" class="btn btn-primary btn-lg btn-block waves-effect waves-light" type="button" >Regresar</button>
                      </div>
                    </div>

                  </form>
                </div>
      </div>


</section>

<script>
  function recuperarMails(){
    valor = document.getElementById("txt_emails").value;
    if( !(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(valor)) ) {
      document.getElementById("txt_emails").value='';
      swal("Correo invalido", "Su correo no es válido, favor de escribirlo nuevamemente.", "error");
      return false;
    }

    var TipoGuardar = "recupCount";
		swal({
			title: "\u00BFEst\u00E1 seguro que desea recuperar sus datos de acceso?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
		},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("btn_img1").style.display = 'block';
        document.getElementById("txt_emails").value='';
				$(".confirm").attr('disabled', 'disabled');
				$.ajax({
		         url:"formConsulta/setting.php",
		         method:"POST",
		         data:{TipoGuardar:TipoGuardar, valor:valor},
		         success:function(data){


		         }
		    })
				.done(function(data) {
					if(data==1){
            document.getElementById("txt_emails").value='';
            document.getElementById("btn_img1").style.display = 'none';
						swal("Correo no encontrado", "El correo ingresado no se encuentra registrado en la Plataforma MWComenius.", "error");
					}
					if(data==3){
            document.getElementById("btn1").style.display = 'none';
            document.getElementById("btn2").style.display = 'block';
            document.getElementById("btn_img1").style.display = 'none';
						swal("Recuperado correctamente", "Sus datos de acceso fueron enviados a su correo, favor de revisar en correos no deseados.", "success");
					}
				})
				.error(function(data) {
					swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
				});
			}

		});
  }
</script>
<!-- jQuery -->
<script src="dist/login/jquery.min.js"></script>

<script src="dist/login/custom.min.js"></script>

</body>
</html>
