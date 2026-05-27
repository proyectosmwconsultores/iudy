<?php $section = "Mis reconocimientos"; include("head.php"); $var = 153;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está consultado sus datos personsales'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datUs=$t->get_karUser($_SESSION['IdUsua']);

$misDocs=$t->get_mis_reco_id($datUs[0]["Usuario"]);

$tm = substr($datUs[0]["CveGrupo"], 7,1);
if($tm == 'C'){ $_txa = "CUATRIMESTRE"; } else { $_txa = "SEMESTRE"; }


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Mis reconocimientos</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Reconocimientos</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="misReconocimientos.php" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["NombreUser"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <?php
                  include("datEspacio.php");  ?>
              </ul>

            </div>
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-9">
          <div class="box box-primary">
            <table class="table table-striped">
              <tr>
                <td style="text-align: center;" colspan="4">MIS RECONOCIMIENTOS ALCANZADOS</td>
              </tr>
              <tr>
                <td style="text-align: right;"><b>NOMBRE:</b></td>
                <td><?php echo $datUs[0]["Nombre"].' '.$datUs[0]["APaterno"].' '.$datUs[0]["AMaterno"]; ?></td>
                <td style="text-align: right;"><b>MATRÍCULA:</b></td>
                <td><?php echo $datUs[0]["Usuario"]; ?></td>
              </tr>
              <tr>
                <td style="text-align: right;"><b>CARRERA:</b></td>
                <td><?php echo $datUs[0]["Educativa"]; ?></td>
                <td style="text-align: right;"><b>GRUPO:</b></td>
                <td><?php echo $datUs[0]["CveGrupo"]; ?></td>
              </tr>
            </table>
              <div class="box-footer">

                <ul class="mailbox-attachments clearfix">

                  <?php if(isset($misDocs[0])) {
                    for ($i=0;$i< sizeof($misDocs);$i++) {

                  ?>
                    <li style="cursor: pointer; width: 32%;" onclick="window.open('repositorio/portafolio/miReconocimiento.php?idToks=<?php echo time().$misDocs[$i]["IdConstancia"]; ?>','_blank')" href="javascript:void(0);">
                    <span class="mailbox-attachment-icon"><i class="fa fa-trophy" style="color: #14274D;"></i><span class="label label-primary" style="font-size: 14px; position: absolute;"><?php echo $misDocs[$i]['Lugar']; ?></span></span>

                    <div class="mailbox-attachment-info" style="text-align: center;">
                      <a href="#" class="mailbox-attachment-name" style="font-size: 12px;"><?php echo $misDocs[$i]['Grado'].'° '.$_txa; ?></a>
                          <span class="mailbox-attachment-size" >
                            <?php echo $misDocs[$i]['Ciclo']; ?>
                          </span>
                          <span class="mailbox-attachment-size" style='color: blue;'>
                          <?php echo obtenerFechaEnLetra($misDocs[$i]['Fecha']); ?>.
                        </span>
                    </div>
                  </li><?php } } else { ?><br><br>
                    <div class="alert alert-info alert-dismissible">
                      <h4><i class="icon fa fa-info-circle"></i> Reconocimiento</h4>
                      Por el momento aun no tiene activo ningun reconocimiento.
                    </div>
                  <?php } ?>
                </ul>
              </div>
              </div>
        </div>
      </div>
    </form>
    </section>
  </div>

  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->

<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
