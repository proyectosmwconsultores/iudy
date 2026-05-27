<?php $mnA = 43;  $section = "Planeación UDS"; include("head.php"); $var = 15;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el modulo de planeación UDS'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datOfe = $t->get_lstOfertauds();
$oferta = $t->get_ofertaId(substr($_GET["idLibro"],10,10));
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Mi planeación UDS</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Planeación UDS</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="planeacion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="IdOferta" id="IdOferta" value="<?php echo substr($_GET["idLibro"],10,10); ?>">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header" style=" background: #04152b; color: white;">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/oferta/<?php echo $oferta[0]["Clave"]; ?>.png" alt="User Avatar" style="width: 60px; height: 60px;">
              </div>
              <h3 class="widget-user-username"><?php echo $oferta[0]["Nombre"].'--'.$oferta[0]["IdEducativa"]; ?></h3>
              <h5 class="widget-user-desc">Planeacón UDS <?php $num = $oferta[0]["Numero"]; ?></h5>
            </div>
            <div class="box-footer">
              <ul class="mailbox-attachments clearfix">
                <?php if(($oferta[0]["IdGrado"] == 1) || ($oferta[0]["IdGrado"] == 2) | ($oferta[0]["IdGrado"] == 3)){ ?>
                  <?php for ($cx=1;$cx<=$oferta[0]["Numero"];$cx++) { ?>
                  <li onclick="mostrarCuadro(<?php echo $cx; ?>,'<?php echo $oferta[0]["Modalidad"]; ?>')" href="javascript:void(0);" style="cursor: pointer;">
                    <span class="mailbox-attachment-icon has-img"><img src="assets/images/grado/<?php echo $oferta[0]["Modalidad"]; ?>/<?php echo $cx; ?>.png" alt="Attachment"></span>
                  </li>
                  <?php } ?>
              <?php }  ?>



              <?php if($oferta[0]["IdGrado"] == 6){
                 for ($v=1;$v<=6;$v++) { ?>
                <li onclick="mostrarCuadro(<?php echo $v; ?>,'<?php echo $oferta[0]["Modalidad"]; ?>')" href="javascript:void(0);" style="cursor: pointer;">
                  <span class="mailbox-attachment-icon has-img"><img style="height: 200px;" src="assets/images/grado/<?php echo $oferta[0]["Modalidad"]; ?>/<?php echo $v; ?>.png" alt="Attachment"></span>
                </li>
              <?php } } ?>
              </ul>
            </div>
            <div class="box-footer" id="enviadosIGSI" style="display: none;"></div>

            <div class="box-footer">

            </div>

          </div>
        </div>

      </div>
    </form>
    </section>
  </div>

  <?php include("footer.php"); ?>

</div>
<div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: #04152b; color: white; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Planeación UDS</h4>
               </div>
               <div class="modal-body" id="employee_detailGrp">
               </div>
          </div>
     </div>
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>

function mostrarLib(IdLibro){
  $.ajax({
       url:"formConsulta/verLibro.php",
       method:"POST",
       data:{IdLibro:IdLibro},
       success:function(data){
            $('#employee_detailGrp').html(data);
            $('#dataModalGrp').modal('show');
       }
  });
}
function mostrarCuadro(Grado,Modalidad){
    var IdOferta = document.getElementById("IdOferta").value;
    var Capa = "#enviadosIGSI";
    document.getElementById("enviadosIGSI").style.display = 'block';
    $(Capa).load("formConsulta/mostrarPlaneacion.php",{IdOferta:IdOferta,Grado:Grado,Modalidad:Modalidad}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
  }
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
