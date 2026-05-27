<?php $section = "Mis documentos solicitados"; include("head.php"); $var = 15;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está consultado sus datos personsales'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datUs=$t->get_karUser($_SESSION['IdUsua']);
$t->get_vermisDocsDispo($_SESSION['IdUsua']);
$misDocs=$t->get_misDocsDispo($_SESSION['IdUsua']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Mis documentos solicitados disponibles</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Mi documentos</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="misSolicitudes.php" method="POST" enctype="multipart/form-data">
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
                <td style="text-align: center;" colspan="4">MIS DOCUMENTOS SOLICITADOS DISPONIBLES</td>
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
                  <?php for ($i=0;$i< sizeof($misDocs);$i++) {
                    $va = substr($misDocs[$i]['Code'],0,1); $hoy = date("Y-m-d"); $Lim = $misDocs[$i]['FecLimite'];
                     if($hoy <= $Lim){
                  ?>
                  <?php if($va == 1){ ?>
                    <li style="cursor: pointer; width: 32%; "onclick="javascript:window.open('repositorio/pdf/miDocumento.php?tokenId=<?php echo time().time().$misDocs[$i]['IdDocumento']; ?>');" href="javascript:void(0);">
                      <?php } else { ?>
                      <li style="cursor: pointer; width: 32%; "onclick="javascript:window.open('repositorio/pdf/miDocumentoxc.php?tokenId=<?php echo time().time().$misDocs[$i]['IdDocumento']; ?>');" href="javascript:void(0);">
                      <?php } ?>
                      
                    <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                    <div class="mailbox-attachment-info">
                      <a href="#" class="mailbox-attachment-name" style="font-size: 12px;"><?php echo $misDocs[$i]['NomPlan']; ?></a>
                          <span class="mailbox-attachment-size">
                            <?php echo $misDocs[$i]['Ciclo']; ?>
                          </span>
                          <span class="mailbox-attachment-size" style='color: blue;'>
                          Disponible hasta el <?php echo obtenerFechaEnLetra($misDocs[$i]['FecLimite']); ?>.
                        </span>
                    </div>
                  </li><?php } } ?>
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
