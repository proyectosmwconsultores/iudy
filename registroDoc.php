<?php
include("php/estructura/session.php");
require('php/clases/registro.php');
require('php/clases/espacio.php');
$espacio =new Espacio();
$Regis=new Registro();
$configuracion=$Regis->get_configuracionPri();
$ofertaE=$Regis->get_OfertaEduc();

if($_SESSION["Folio"]){
  $id=$_SESSION["Folio"];
} elseif($_GET["Folio"]) {
  $id=$_GET["Folio"];
} else { $id = ""; }

if($id){
  if(isset($_POST["Mov"]) && $_POST["Mov"]=="SubPago"){
    $Regis->add_com_pago();
    exit;
  }

$usuarioLst=$Regis->get_usuariosLST($id);
$misPagos = $Regis->get_mis_pagos($usuarioLst[0]['IdUsua']);
if($usuarioLst[0])
{
  if(isset($_POST['txtTipoDoc'])){ $_POST['txtTipoDoc'] = $_POST['txtTipoDoc']; } else { $_POST['txtTipoDoc'] = ''; }
  $tipoDocumentos = $espacio->get_lstTipoDoc($usuarioLst[0]["IdOferta"]);

  $misDocumentos = $espacio->get_misDocAlumnos($usuarioLst[0]["IdUsua"]);
  if(isset($_POST["Mov"]) && $_POST["Mov"]=="SubDocAlum"){
    $espacio->add_docAlumnoR();
    exit;
  }

if(isset($_POST["Mov"]) && $_POST["Mov"]=="Salir"){
  session_destroy();
  unset($_SESSION['Folio']);
    header("Location: continuar.php?x=1");
    exit;
  exit;
}
$y = 0;
for ($X=0;$X< sizeof($tipoDocumentos);$X++) {
 $y = $y + 1;
}
 // $y = $y - 1;
 $por = (100/$y);

$avance = ($usuarioLst[0]["NoDoc"] * $por);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro de Aspirantes</title>
    <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">

    <meta name="description" content="Esta plataforma es capaz de crear tareas, foros, evaluaciones y tener los recursos de apoyo.  Con una estructura modular que hace posible su adaptacion a la realidad de los diferentes centros educativos" />
    <meta name="keywords" content="Sistema de educacion en linea, educacion, linea, educacion en linea, sistema" />
    <meta name="author" content="MWConsultores">
    <script language="javascript" type="text/javascript" src="php/js/funciones.js"></script>
  	<script language="javascript" type="text/javascript" src="php/js/modulo.js"></script>
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  	<script src="assets/alert/dist/sweetalert-dev.js"></script>
  	<link rel="stylesheet" href="assets/alert/dist/sweetalert.css">

</head>
<style>

body{
    background:#f9f9fb;
}
.view-account{
    background:#FFFFFF;
    margin-top:20px;
}
.view-account .pro-label {
    font-size: 13px;
    padding: 4px 5px;
    position: relative;
    top: -5px;
    margin-left: 10px;
    display: inline-block
}

.view-account .side-bar {
    padding-bottom: 30px
}

.view-account .side-bar .user-info {
    text-align: center;
    margin-bottom: 15px;
    padding: 30px;
    color: #616670;
    border-bottom: 1px solid #f3f3f3
}

.view-account .side-bar .user-info .img-profile {
    width: 120px;
    height: 120px;
    margin-bottom: 15px
}

.view-account .side-bar .user-info .meta li {
    margin-bottom: 10px
}

.view-account .side-bar .user-info .meta li span {
    display: inline-block;
    width: 100px;
    margin-right: 5px;
    text-align: right
}

.view-account .side-bar .user-info .meta li a {
    color: #616670
}

.view-account .side-bar .user-info .meta li.activity {
    color: #a2a6af
}

.view-account .side-bar .side-menu {
    text-align: center
}

.view-account .side-bar .side-menu .nav {
    display: inline-block;
    margin: 0 auto
}

.view-account .side-bar .side-menu .nav>li {
    font-size: 14px;
    margin-bottom: 0;
    border-bottom: none;
    display: inline-block;
    float: left;
    margin-right: 15px;
    margin-bottom: 15px
}

.view-account .side-bar .side-menu .nav>li:last-child {
    margin-right: 0
}

.view-account .side-bar .side-menu .nav>li>a {
    display: inline-block;
    color: #9499a3;
    padding: 5px;
    border-bottom: 2px solid transparent
}

.view-account .side-bar .side-menu .nav>li>a:hover {
    color: #616670;
    background: none
}

.view-account .side-bar .side-menu .nav>li.active a {
    color: #40babd;
    border-bottom: 2px solid #40babd;
    background: none;
    border-right: none
}

.theme-2 .view-account .side-bar .side-menu .nav>li.active a {
    color: #6dbd63;
    border-bottom-color: #6dbd63
}

.theme-3 .view-account .side-bar .side-menu .nav>li.active a {
    color: #497cb1;
    border-bottom-color: #497cb1
}

.theme-4 .view-account .side-bar .side-menu .nav>li.active a {
    color: #ec6952;
    border-bottom-color: #ec6952
}

.view-account .side-bar .side-menu .nav>li .icon {
    display: block;
    font-size: 24px;
    margin-bottom: 5px
}

.view-account .content-panel {
    padding: 30px
}

.view-account .content-panel .title {
    margin-bottom: 15px;
    margin-top: 0;
    font-size: 18px
}

.view-account .content-panel .fieldset-title {
    padding-bottom: 15px;
    border-bottom: 1px solid #eaeaf1;
    margin-bottom: 30px;
    color: #616670;
    font-size: 16px
}

.view-account .content-panel .avatar .figure img {
    float: right;
    width: 64px
}

.view-account .content-panel .content-header-wrapper {
    position: relative;
    margin-bottom: 30px
}

.view-account .content-panel .content-header-wrapper .actions {
    position: absolute;
    right: 0;
    top: 0
}

.view-account .content-panel .content-utilities {
    position: relative;
    margin-bottom: 30px
}

.view-account .content-panel .content-utilities .btn-group {
    margin-right: 5px;
    margin-bottom: 15px
}

.view-account .content-panel .content-utilities .fa {
    font-size: 16px;
    margin-right: 0
}

.view-account .content-panel .content-utilities .page-nav {
    position: absolute;
    right: 0;
    top: 0
}

.view-account .content-panel .content-utilities .page-nav .btn-group {
    margin-bottom: 0
}

.view-account .content-panel .content-utilities .page-nav .indicator {
    color: #a2a6af;
    margin-right: 5px;
    display: inline-block
}

.view-account .content-panel .mails-wrapper .mail-item {
    position: relative;
    padding: 10px;
    border-bottom: 1px solid #f3f3f3;
    color: #616670;
    overflow: hidden
}

.view-account .content-panel .mails-wrapper .mail-item>div {
    float: left
}

.view-account .content-panel .mails-wrapper .mail-item .icheck {
    background-color: #fff
}

.view-account .content-panel .mails-wrapper .mail-item:hover {
    background: #f9f9fb
}

.view-account .content-panel .mails-wrapper .mail-item:nth-child(even) {
    background: #fcfcfd
}

.view-account .content-panel .mails-wrapper .mail-item:nth-child(even):hover {
    background: #f9f9fb
}

.view-account .content-panel .mails-wrapper .mail-item a {
    color: #616670
}

.view-account .content-panel .mails-wrapper .mail-item a:hover {
    color: #494d55;
    text-decoration: none
}

.view-account .content-panel .mails-wrapper .mail-item .checkbox-container,
.view-account .content-panel .mails-wrapper .mail-item .star-container {
    display: inline-block;
    margin-right: 5px
}

.view-account .content-panel .mails-wrapper .mail-item .star-container .fa {
    color: #a2a6af;
    font-size: 16px;
    vertical-align: middle
}

.view-account .content-panel .mails-wrapper .mail-item .star-container .fa.fa-star {
    color: #f2b542
}

.view-account .content-panel .mails-wrapper .mail-item .star-container .fa:hover {
    color: #868c97
}

.view-account .content-panel .mails-wrapper .mail-item .mail-to {
    display: inline-block;
    margin-right: 5px;
    min-width: 120px
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject {
    display: inline-block;
    margin-right: 5px
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label {
    margin-right: 5px
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label:last-child {
    margin-right: 10px
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label a,
.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label a:hover {
    color: #fff
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-1 {
    background: #f77b6b
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-2 {
    background: #58bbee
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-3 {
    background: #f8a13f
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-4 {
    background: #ea5395
}

.view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-5 {
    background: #8a40a7
}

.view-account .content-panel .mails-wrapper .mail-item .time-container {
    display: inline-block;
    position: absolute;
    right: 10px;
    top: 10px;
    color: #a2a6af;
    text-align: left
}

.view-account .content-panel .mails-wrapper .mail-item .time-container .attachment-container {
    display: inline-block;
    color: #a2a6af;
    margin-right: 5px
}

.view-account .content-panel .mails-wrapper .mail-item .time-container .time {
    display: inline-block;
    text-align: right
}

.view-account .content-panel .mails-wrapper .mail-item .time-container .time.today {
    font-weight: 700;
    color: #494d55
}

.drive-wrapper {
    padding: 15px;
    background: #f5f5f5;
    overflow: hidden
}

.drive-wrapper .drive-item {
    width: 130px;
    margin-right: 15px;
    display: inline-block;
    float: left
}

.drive-wrapper .drive-item:hover {
    box-shadow: 0 1px 5px rgba(0, 0, 0, .1);
    z-index: 1
}

.drive-wrapper .drive-item-inner {
    padding: 15px
}

.drive-wrapper .drive-item-title {
    margin-bottom: 15px;
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
}

.drive-wrapper .drive-item-title a {
    color: #494d55
}

.drive-wrapper .drive-item-title a:hover {
    color: #40babd
}

.theme-2 .drive-wrapper .drive-item-title a:hover {
    color: #6dbd63
}

.theme-3 .drive-wrapper .drive-item-title a:hover {
    color: #497cb1
}

.theme-4 .drive-wrapper .drive-item-title a:hover {
    color: #ec6952
}

.drive-wrapper .drive-item-thumb {
    width: 100px;
    height: 80px;
    margin: 0 auto;
    color: #616670
}

.drive-wrapper .drive-item-thumb a {
    -webkit-opacity: .8;
    -moz-opacity: .8;
    opacity: .8
}

.drive-wrapper .drive-item-thumb a:hover {
    -webkit-opacity: 1;
    -moz-opacity: 1;
    opacity: 1
}

.drive-wrapper .drive-item-thumb .fa {
    display: inline-block;
    font-size: 36px;
    margin: 0 auto;
    margin-top: 20px
}

.drive-wrapper .drive-item-footer .utilities {
    margin-bottom: 0
}

.drive-wrapper .drive-item-footer .utilities li:last-child {
    padding-right: 0
}

.drive-list-view .name {
    width: 60%
}

.drive-list-view .name.truncate {
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
}

.drive-list-view .type {
    width: 15px
}

.drive-list-view .date,
.drive-list-view .size {
    max-width: 60px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
}

.drive-list-view a {
    color: #494d55
}

.drive-list-view a:hover {
    color: #40babd
}

.theme-2 .drive-list-view a:hover {
    color: #6dbd63
}

.theme-3 .drive-list-view a:hover {
    color: #497cb1
}

.theme-4 .drive-list-view a:hover {
    color: #ec6952
}

.drive-list-view td.date,
.drive-list-view td.size {
    color: #a2a6af
}

@media (max-width:767px) {
    .view-account .content-panel .title {
        text-align: center
    }
    .view-account .side-bar .user-info {
        padding: 0
    }
    .view-account .side-bar .user-info .img-profile {
        width: 60px;
        height: 60px
    }
    .view-account .side-bar .user-info .meta li {
        margin-bottom: 5px
    }
    .view-account .content-panel .content-header-wrapper .actions {
        position: static;
        margin-bottom: 30px
    }
    .view-account .content-panel {
        padding: 0
    }
    .view-account .content-panel .content-utilities .page-nav {
        position: static;
        margin-bottom: 15px
    }
    .drive-wrapper .drive-item {
        width: 100px;
        margin-right: 5px;
        float: none
    }
    .drive-wrapper .drive-item-thumb {
        width: auto;
        height: 54px
    }
    .drive-wrapper .drive-item-thumb .fa {
        font-size: 24px;
        padding-top: 0
    }
    .view-account .content-panel .avatar .figure img {
        float: none;
        margin-bottom: 15px
    }
    .view-account .file-uploader {
        margin-bottom: 15px
    }
    .view-account .mail-subject {
        max-width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis
    }
    .view-account .content-panel .mails-wrapper .mail-item .time-container {
        position: static
    }
    .view-account .content-panel .mails-wrapper .mail-item .time-container .time {
        width: auto;
        text-align: left
    }
}

@media (min-width:768px) {
    .view-account .side-bar .user-info {
        padding: 0;
        padding-bottom: 15px
    }
    .view-account .mail-subject .subject {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis
    }
}

@media (min-width:992px) {
    .view-account .content-panel {
        min-height: auto;
        border-left: 1px solid #f3f3f7;
        margin-left: 200px
    }
    .view-account .mail-subject .subject {
        max-width: 280px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis
    }
    .view-account .side-bar {
        position: absolute;
        width: 200px;
        min-height: auto;
    }
    .view-account .side-bar .user-info {
        margin-bottom: 0;
        border-bottom: none;
        padding: 30px
    }
    .view-account .side-bar .user-info .img-profile {
        width: 120px;
        height: 120px
    }
    .view-account .side-bar .side-menu {
        text-align: left
    }
    .view-account .side-bar .side-menu .nav {
        display: block
    }
    .view-account .side-bar .side-menu .nav>li {
        display: block;
        float: none;
        font-size: 14px;
        border-bottom: 1px solid #f3f3f7;
        margin-right: 0;
        margin-bottom: 0
    }
    .view-account .side-bar .side-menu .nav>li>a {
        display: block;
        color: #9499a3;
        padding: 10px 15px;
        padding-left: 30px
    }
    .view-account .side-bar .side-menu .nav>li>a:hover {
        background: #f9f9fb
    }
    .view-account .side-bar .side-menu .nav>li.active a {
        background: #f9f9fb;
        border-right: 4px solid #40babd;
        border-bottom: none
    }
    .theme-2 .view-account .side-bar .side-menu .nav>li.active a {
        border-right-color: #6dbd63
    }
    .theme-3 .view-account .side-bar .side-menu .nav>li.active a {
        border-right-color: #497cb1
    }
    .theme-4 .view-account .side-bar .side-menu .nav>li.active a {
        border-right-color: #ec6952
    }
    .view-account .side-bar .side-menu .nav>li .icon {
        font-size: 24px;
        vertical-align: middle;
        text-align: center;
        width: 40px;
        display: inline-block
    }
}
.module {
    border: 1px solid #f3f3f3;
    border-bottom-width: 2px;
    background: #fff;
    margin-bottom: 30px;
    position: relative;
    border-radius: 4px;
    background-clip: padding-box;
}
.module .module-footer {
    background: #fff;
    border-top: 1px solid #f3f3f7;
    padding: 15px;
}
.module .module-footer a {
    color: #9499a3;
}
</style>
<body>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->


  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <div class="container">
      <div class="view-account">
          <section class="module">
              <div class="module-inner">
                  <div class="side-bar">
                      <div class="user-info">
                          <img class="img-profile img-circle img-responsive center-block" src="assets/images/campus/icono.png" alt="">
                          <ul class="meta list list-unstyled">
                              <li class="name"><b><?php echo $usuarioLst[0]["Nombre"]; ?></b><br><?php echo $usuarioLst[0]["APaterno"].' '.$usuarioLst[0]["AMaterno"]; ?></li>
                              <li class="activity">Fecha de registro: <?php echo $usuarioLst[0]["FecCap"]; ?></li>
                              <li class="activity" style="color: black;"><b><h4>Folio: <?php echo $usuarioLst[0]["Folio"]; ?></h4></b> (Apunta tu folio en un lugar seguro)</li>
                          </ul>
                      </div>
                      <!-- <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <h4>Revalidar materia.</h4>
                          <p style="texta-align: right;">Deber&aacute; subir toda su documentaci&oacute;n, para cualquier duda comunicarse al (961) 654 4067.</p>

                      </div> -->
                  </div>

                  <form class="form-horizontal" name="frm" id="frm" action="registroDoc.php" method="POST" enctype="multipart/form-data">
                    <input id="Mov" name="Mov" value="" type="hidden"/>
                    <input id="IdUsua" name="IdUsua" value="<?php echo $usuarioLst[0]["IdUsua"] ?>" type="hidden"/>
                    <input id="IdOferta" name="IdOferta" value="<?php echo $usuarioLst[0]["IdOferta"] ?>" type="hidden"/>
                    <input id="IdPago" name="IdPago" value="<?php if(isset($_GET['IdPago'])){ echo $_GET['IdPago']; } ?>" type="hidden"/>
                  <div class="content-panel">
                      <div class="content-header-wrapper">
                        <h1 class="title"><b>Bienvenido</b><br>Registro de Aspirantes</h1>
                          <div class="actions">
                            <button onClick="val_salir()" class="btn btn-danger"><i class="fa fa-close"></i> Salir</button>
                        </div>
                      </div>
                      <div class="content-utilities">
                          <div class="actions">
                              <div class="btn-group">
                                <h2 class="title">Documentos requeridos del aspirante a estudiante</h2>
                              </div>
                              <?php if($avance > 99) { ?>
                              <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <h4>Estimad<?php if($usuarioLst[0]["Sexo"] == "HOMBRE") { echo "o: ";} else { echo "a:"; }  ?>  <b><?php echo $usuarioLst[0]["Nombre"]; ?></b></h4>
                                  Su documentaci&oacute;n estar&aacute; en proceso de revisi&oacute;n, nosotros le enviaremos nuevamente un correo para darle seguimiento a su inscripci&oacute;n.

                              </div><?php } ?>
                          </div>
                      </div>
                      <div class="drive-wrapper drive-grid-view">
                          <div class="progress progress-sm active">
                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $avance; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avance; ?>%">
                              <span class="sr-only"><?php echo $avance; ?>% Complete</span>
                            </div>
                          </div>

                        <div class="form-group" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
                          <div class="col-sm-12" style="text-align: center;">
                              <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-4 control-label" style="text-align: left;">Tipo  de Documento: <br>
                            <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
                							<option value=""> - Seleccione - </option>
                							<?php for ($i=0;$i< sizeof($tipoDocumentos);$i++) { ?>
                							<option value="<?php echo $tipoDocumentos[$i]["IdTipoDoc"]; ?>"<?php if($_POST["txtTipoDoc"]==$tipoDocumentos[$i]["IdTipoDoc"]){?>selected="selected"<?php }?>><?php echo $tipoDocumentos[$i]["Nombre"];  ?></option>
                							<?php } ?>
              						  </select>
                         </label>

                          <div class="col-sm-5">
                            <label for="inputPassword3" style="text-align: left;">Buscar: <br>
                            <input id="txtDocumento" name="txtDocumento" type="file" onchange="validarPDF(this,'txtDocumento');">
                            <p class="help-block">El archivo puede ser en formato .pdf/.png/.jpg</p>
                          </div>
                          <div class="col-sm-3">
                            <button name="btnDocAlumno" id="btnDocAlumno" onClick="val_addDocAlumno()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-check-circle"></i> Guardar</button>
                          </div>
                          <label for="inputPassword3" class="col-sm-12 control-label" style="text-align: left; color: red; margin-top: -26px;">* Nota: Su archivo debe pesar menos de 10 MB.</label>
                        </label>
                        </div>

                      </div>
<style>
.table tbody tr td{ padding: 8px;}
</style>
                      <div class="drive-wrapper drive-list-view">
                          <div class="table-responsive drive-items-table-wrapper">
                              <table>
                                  <thead>
                                      <tr>
                                          <th class="name truncate">Tipo documento</th>
                                          <th class="date">Fec. Captura</th>
                                          <th class="size">Estatus</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php for ($i=0;$i< sizeof($misDocumentos);$i++) { $id = $misDocumentos[$i]["IdDocAlumno"];
                                      if($misDocumentos[$i]["Estatus"] == "No Aprobado"){ $color = "red"; } else { $color = "blue"; }
                                       ?>
                                      <tr>
                                        <td style="width: 50% !important; padding: 6px;"><?php echo $misDocumentos[$i]["NomDocumento"]; ?></td>
                                        <td><?php echo $misDocumentos[$i]["FecCap"]; ?></td>
                                        <td><b style=" color: <?php echo $color; ?>;"><?php echo $misDocumentos[$i]["Estatus"]; ?></b></td>
                                        <td style=" padding: 8px;">
                                          <a onClick="window.open('assets/docs/files/<?php echo $misDocumentos[$i]["Anio"].'/'.$misDocumentos[$i]["Mes"].'/'.$misDocumentos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
                                            <button type="button" class="btn btn-primary pull-left"> <i class="fa fa-fw fa-cloud-download"></i></button>
                                          </a>
                                          <?php if($misDocumentos[$i]["Estatus"] != "Aprobado"){ ?>
                                          <button onClick="val_delDocAspirante(this,<?php echo $id; ?>)"  type="button" class="btn btn-danger pull-right"> <i class="fa fa-times-circle"></i></button>
                                        <?php } ?>
                                        </td>
                                      </tr><?php } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php if(isset($misPagos[0])){ ?>
                      <h1 class="title"><b>Subir comprobantes de pago</b></h1>

                      <div class="drive-wrapper drive-grid-view">
                        <div class="tab-pane active" id="activity">
                            <div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
                              <div class="col-sm-12" style="text-align: center;">
                                  <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
                              </div>
                            </div>
                            <?php // $recargos = 0;
                            for ($i=0;$i< sizeof($misPagos);$i++) {


                               $Id = $misPagos[$i]["IdPago"]; //$recargos = $misPagos[$i]["Recargos"]; ?>
                            <div class="form-group" id="<?php echo $Id; ?>">
                              <label for="inputPassword3" class="col-sm-5 control-label">Tipo Pago: <?php echo $misPagos[$i]["NomPlan"]; ?> <br>
                                Fecha: <b style="color: red;"> <?php echo $misPagos[$i]["FecBase"]; ?></b><br>
                               <?php $var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid(); ?>
                               <button type="button" class="btn btn-block btn-danger btn-xs" onclick="javascript:window.open('repositorio/pdf/boucherId.php?tokenId=<?php echo time().$misPagos[$i]["IdPago"]; ?>');" href="javascript:void(0);" title="Descargar boucher de pago"><i class="fa fa-fw fa-cloud-download"></i> Descargar ficha de pago</button>
                             </label>

                              <div class="col-sm-3">
                                <input id="txtPago-<?php echo $Id; ?>" name="txtPago-<?php echo $Id; ?>" type="file" onchange="validarPDF(this,'txtPago-<?php echo $Id; ?>');" >
                                <p class="help-block">El archivo debe ser en formato pdf | png | jpg.</p>
                              </div>
                              <div class="col-sm-3">
                                <button onClick="val_addPago(this,'txtPago-<?php echo $Id; ?>','<?php echo $Id; ?>')" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-check-circle"></i> Guardar</button>
                              </div>
                              <div class="col-sm-1">
                                <?php if($misPagos[$i]["Archivo"]) { ?>
                                  <a onClick="window.open('assets/docs/Pagos/<?php echo $misPagos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
                                    <button type="button" class="btn btn-danger pull-right"> <i class="fa fa-fw fa-cloud-download"></i></button>
                                  </a>
                                <?php } ?>
                              </div>
                            </div>
                          <?php } //}  ?>

                        </div>

                      </div><?php } ?>
                  </div>


                </form>
              </div>
          </section>
      </div>
  </div>
</body>
<script>

function val_salir()
{
  document.frm.Mov.value='Salir';document.frm.submit();
}
</script>

<script>
$(function(){
    $("[data-toggle='tooltip']").tooltip();
})
</script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
</html>
<?php } else {
  header("Location: continuar.php?x=1");
  exit;
}
} else {
  unset($_SESSION['IdUsua']);
  unset($_SESSION['Folio']);
  header("Location: continuar.php?x=1");
//echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
