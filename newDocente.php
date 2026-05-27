<?php
include("php/estructura/session.php");
require('php/clases/registro.php');
$Regis=new Registro();
$configuracion=$Regis->get_configuracionPri();
$ofertaE=$Regis->get_OfertaEduc();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar")
{
    $Regis->add_registroDoc();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de Docentes</title>
    <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">

    <meta name="description" content="Esta plataforma es capaz de crear tareas, foros, evaluaciones y tener los recursos de apoyo.  Con una estructura modular que hace posible su adaptacion a la realidad de los diferentes centros educativos" />
    <meta name="keywords" content="Sistema de educacion en linea, educacion, linea, educacion en linea, sistema" />
    <meta name="author" content="MWConsultores">
    <link href="assets/fancy/1bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/fancy/1bootstrap.min.js"></script>
    <script src="assets/fancy/1jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="php/js/modulo.js"></script>
    <script src="assets/alert/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="assets/alert/dist/sweetalert.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!------ Include the above in your HEAD tag ---------->
</head>
<style>
.body{
  font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-bottom: 3%;
    cursor: pointer;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 50%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
    font-family: Arial Narrow, Century Gothic,sans-serif;
}
</style>
<body>
<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="assets/images/campus/logo_inicio.png"  width="120px" alt=""/>
                        <h3>Bienvenido</h3>
                        <p>Estas a 30 segundos de formar parte de nuestros <b style="color: black;">docentes</b> de la <b>Universidad VIRTUAL</b></p>

                    </div>

                    <div class="col-md-9 register-right">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Registrate como docente Ahora!</h3>
                                <form action="newDocente.php" name='frm' method='post' id="frm">
                                  <input id="Mov" name="Mov" value="<?php echo $_GET["Mov"];?>" type="hidden"/>
                                <div class="row register-form">

                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre *" type="text">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input class="form-control" id="txtAPaterno" name="txtAPaterno" placeholder="Apellido Paterno *" type="text">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input class="form-control" id="txtAMaterno" name="txtAMaterno" placeholder="Apellido Materno *" type="text">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Teléfono *" type="text">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Correo" type="email" >
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input type="text" class="form-control pull-right" placeholder="Fec. de Nacimiento (yyyy/mm/dd)" name="datepicker" id="datepicker">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="maxl">
                                            <label class="radio inline">
                                                <input type="radio" id="gender" name="gender" value="MUJER">
                                                <span> Mujer </span>
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" id="gender" name="gender" value="HOMBRE">
                                                <span> Hombre </span>
                                            </label>
                                        </div>
                                    </div>
                                  </div>
                                    <div class="col-md-6">
                                        <input type="button" onClick="val_registroDoc()"  class="btnRegister"  value="Registrarse"/>
                                    </div>
                                </div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
          </body>
          <script>
            $(function () {
              //Date picker
              $('#datepicker').datepicker({
                autoclose: true
              })
            })
          </script>
          <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
</html>
