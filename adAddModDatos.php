<?php $valor = 2; $section = "Datos de la asignatura"; include("head.php");
if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar información a la asigantura de una oferta educativa'); }

if($_SESSION['Permisos'] == 9){
	$oferta=$t->get_OfertaCoordinador($_SESSION['IdUsua']);
} else {
	$oferta=$t->get_OfertaE($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
}



	$moduloId=$t->get_ModuloId($_POST["txtOferta"]);
	$moduloDatos=$t->get_datosModulo($_POST["txtOferta"],$_POST["txtModulo"]);
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_ModuloDatos();
		exit;
	}elseif(isset($_POST["Mov"]) && $_POST["Mov"]=="Actualizar"){
		$t->act_ModuloDatosDoc();
		exit;
  }

$id=  $_POST["txtModulo"]; $tok = time(); $toks = $tok.$id;
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Informaci&oacute;n general de la asignatura
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Asignatura</a></li>
        <li class="active">Datos de la asigantura</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Datos de la asignatura</h3>
			<!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
		  <form name="frm" id="frm" action="adAddModDatos.php" method="POST" enctype="multipart/form-data">
		  <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
		  <input id="IdDatosM" name="IdDatosM" value="<?php echo $moduloDatos[0]["IdDatosM"];?>" type="hidden"/>
		  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
		  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
            <div class="col-md-6">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Oferta educativa:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-gears"></i>
									  </div>
									  <select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Rvoe"].' / '.$oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Asignatura:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-book"></i>
									  </div>
									  <select class="form-control" name="txtModulo" id="txtModulo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($moduloId);$i++) { ?>
										<option value="<?php echo $moduloId[$i]["IdModulo"]; ?>"<?php if($_POST['txtModulo']==$moduloId[$i]["IdModulo"]){?>selected="selected"<?php }?>><?php echo $moduloId[$i]["CodeModulo"].' - '.$moduloId[$i]["NombreMod"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<?php if($moduloDatos[0]){ ?>
						<!-- <div class="col-md-2">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Descargar:</label>
									<div class="input-group">

										<a href="repositorio/pdf/cartaDescriptiva.php?token=<?php echo $toks; ?>" target="_blank">
	                      <button type="button" class="btn btn-block btn-success btn-sm"> <i class="fa fa-fw fa-cloud-download"></i> Carta descriptiva </button></td>
	                      </a>
									</div>
								</div>
							  </div>
						  </div>
						</div> -->
					<?php } ?>
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<label>Objetivos general de la asignatura:</label>
					</div>
					<div class="box-body pad">
						<textarea name="txtObjetivo" id="txtObjetivo" class="textarea" placeholder="Escriba el objetivo general de la asignatura..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Objetivo"]; ?></textarea>
					</div>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<label>Introducción de la asignatura:</label>
					</div>
					<div class="box-body pad">
						<textarea name="txtIntro" id="txtIntro" class="textarea" placeholder="Escriba la introduccion de la asignatura..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Introduccion"]; ?></textarea>
					</div>
			  </div>
			</div>
			<div class="col-md-12">
			    <div class="box-primary">
				    <div class="box-body">
						<div class="box-footer" style=" text-align: center;">
							<?php if($moduloDatos[0]["IdDatosM"]){ ?>
							<button type="button" class="btn btn-primary" onClick="val_adActModDatos()">ACTUALIZAR</button>
							<?php } else { ?>
							<button type="button" class="btn btn-primary" onClick="val_adAddModDatos()">GUARDAR</button>
							<?php } ?>
						</div>
				    </div>
			    </div>
			  <!-- /.box -->
			</div>
			</form>
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", variable + " actualizado con exito", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
		}
	}
});
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
