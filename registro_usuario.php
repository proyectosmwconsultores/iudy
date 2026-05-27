<?php
require('php/clases/registro.php');
$Regis=new Registro();
$oferta=$Regis->get_OfertaEduc();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">
    <meta name="description" content="Esta plataforma es capaz de crear tareas, foros, evaluaciones y tener los recursos de apoyo.  Con una estructura modular que hace posible su adaptacion a la realidad de los diferentes centros educativos" />
    <meta name="keywords" content="Instituto de Capacitacion y Vinculacion Tecnologica del Estado de Chiapas" />
    <meta name="author" content="MWConsultores">
    <link href="dist/login/bootstrap.min.css" rel="stylesheet">
    <link href="dist/login/steps.css" rel="stylesheet">
    <link href="dist/login/style.css" rel="stylesheet">
    <script src="assets/alert/dist/sweetalert-dev.js"></script>
  	<link rel="stylesheet" href="assets/alert/dist/sweetalert.css">
  </head>
<body>
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="step-register">
  <div class="register-box">
    <div class="">
       <a onClick="window.open('./','_self')" href="javascript:void(0);" class="text-center db m-b-40"><img src="assets/images/campus/logo_inicio.png" style="width: 20%"></a>
        <form id="msform">
        <input type="hidden" name="val" id="val" value="1" >
        <input type="hidden" name="valc" id="valc" value="1" >
        <ul id="eliteregister">
        <li class="active">Configuración de la cuenta</li>
        <li>Información personal</li>
        <li>Datos generales</li>
        </ul>
        <!-- fieldsets -->
        <fieldset id='btn1'>
        <h2 class="fs-title">¡Registrate ahora!</h2>
        <h3 class="fs-subtitle">En este espacio podrá crear su cuenta con su información general</h3>
        <input type="text" name="txtEmail" onchange="valEmail()" id="txtEmail" placeholder="Correo electrónico" />
        <select class="form-control" name="txtTipo" id="txtTipo">
          <option value="">- SELECCIONE PLAN DE ESTUDIOS - </option>
          <?php for ($i=0;$i< sizeof($oferta);$i++) {  ?>
          <option value="<?php echo $oferta[$i]['IdEducativa']; ?>"><?php echo $oferta[$i]['Nombre']; ?></option>
        <?php } ?>
        </select>
          <input onClick="window.open('continuar.php','_self')" href="javascript:void(0);" type="button" name="previous" class="previous action-button" value="Tengo un folio" />
          <input type="button" name="next" class="next action-button" value="Siguiente" />

        </fieldset>
        <fieldset id='btn2'>
        <h2 class="fs-title">Información personal</h2>
        <h3 class="fs-subtitle">Ingrese sus datos personales.</h3>
        <input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre" />
        <input type="text" name="txtPaterno" id="txtPaterno" placeholder="Apellido paterno" />
        <input type="text" name="txtMaterno" id="txtMaterno" placeholder="Apellido materno" />
        <input type="button" name="previous" class="previous action-button" value="Anterior" />
        <input type="button" name="next" class="next action-button" value="Siguiente" />
        </fieldset>
        <fieldset id='btn1'>
          <div id="div_img" style="position: absolute; display: none; width: 89%;"><img src="assets/images/procesando.gif"></div>
        <h2 class="fs-title">Datos generales</h2>
        <h3 class="fs-subtitle">Ingrese sus datos.</h3>
        <input type="text" name="txtTelefono" id="txtTelefono" placeholder="Celular" maxlength="10" />
        <select class="form-control" name="txtSexo" id="txtSexo">
          <option value="">- Seleccione - </option>
          <option value="M">Masculino</option>
          <option value="F">Femenino</option>
        </select>

        <input id="btn_1" type="button" name="previous" class="previous action-button" value="Anterior" />
        <input id="btn_2" type="button" name="submit" class="submit action-button" value="Registrarme" />
        </fieldset>
        </form>
        <div class="clear"></div>
    </div>
  </div>
</section>
<!-- jQuery -->
<script>

  // function mostrax(){
  //   var valc = document.getElementById("valc").value;
  //   alert(valc);
  //   if(valc == 2){
  //     document.getElementById("div_btn1").style.display = 'none';
  //     document.getElementById("div_btn2").style.display = 'block';
  //     // document.getElementById("val").value = 2;
  //   }
  //   // else {
  //   //   document.getElementById("div_btn1").style.display = 'none';
  //   //   document.getElementById("div_btn2").style.display = 'block';
  //   // }
  //
  // }
  function valEmail(){
    valor = document.getElementById("txtEmail").value;
    if( !(/\w+([-+.']\w+)*@\w+([-.]\w+)/.test(valor)) ) {
      document.getElementById("txtEmail").value='';
      swal("Correo invalido", "Favor de ingresar nuevamemente su correo.", "error");
      return false;
    }

    var Email = document.getElementById("txtEmail").value;
    var TipoGuardar = "validar_email_docs";
    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, Email:Email},
         success:function(data){

         }
    })
    .done(function(data) {

      if(data==1){
        swal("Correo existente", "Su correo ya esta dado de alta en la plataforma, le sugerimos recuperar sus datos de acceso.", "error");
        document.getElementById("txtEmail").focus();
        document.getElementById("txtEmail").value='';
        return false;
      }
      if(data==2){
        document.getElementById("valc").value = '2';
      }
    })
  }

</script>
<script src="dist/login/jquery.min.js"></script>
<script src="dist/login/jquery.easing.min.js"></script>
<script src="dist/login/register-init_doc.js"></script>
<script src="dist/login/custom.min.js"></script>
</body>
</html>
