<?php $valor = 1; $section = "Lista de avisos"; include("head.php");
if($_SESSION['Permisos']) {
$avisoss=$t->get_listaAvisoss();
//$meses=$espacio->get_addIn();

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper"> 
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Lista de avisos
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
          <li class="active">Aviso</li>
        </ol>
      </section>
      <section class="content">
        <form name="frm" id="frm" action="acalstAviso.php" method="POST" enctype="multipart/form-data">
        <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
  		  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Avisos creados</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>

                <div class="box-primary">
                  <div class="box-body">
                    <a class="btn btn-app" onclick="window.open('inicio.php','_self')" href="javascript:void(0);">
                      <i class="fa fa-rotate-left"></i> Regresar
                    </a>
                    <a class="btn btn-app" onclick="window.open('acaAviso.php','_self')" href="javascript:void(0);">
                      <i class="fa fa-edit"></i> Nuevo
                    </a>
                  </div>
                </div>

          <div class="box-body">
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Oferta educativa</th>
                  <th>Modulo</th>
                  <th>T&iacute;tulo</th>
                  <th>Descripci&oacute;n</th>
                  <th>FecCap</th>
                </tr>
                <?php for ($i=0;$i< sizeof($avisoss);$i++) { ?>
                <tr>
                  <td><?php echo $i +1; ?></td>
                  <td><?php echo $avisoss[$i]["Nombre"];; ?></td>
                  <td><?php echo $avisoss[$i]["NombreMod"];; ?></td>
                  <td><?php echo $avisoss[$i]["Titulo"];; ?></td>
                  <td><?php echo $avisoss[$i]["Mensaje"];; ?></td>
                  <td><?php echo $avisoss[$i]["FecCap"];; ?></td>
                </tr><?php } ?>
              </tbody></table>
            </div>
          </div>
        </div>
      </form>
      </section>
    </div>
    <?php include("footer.php"); ?>
  </div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", variable + " ACTUALIZADO CON ÉXITO", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
		}
	}
});
</script>
</body>
</html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
