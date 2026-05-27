<?php $valor = 1; $section = "Plan de estudio"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar un plan de estudio'); }
if(isset($_POST["Mov"]) && $_POST["Mov"]=="updOferta"){
  $t->upd_OfertaE();
  exit;
}
$ofertaIdGet = substr($_GET["IdEducativa"], 10, 10);
$vstImg = 0;
$ofertaId=$t->get_ofertaId($ofertaIdGet);
$img = "assets/images/oferta/".$ofertaId[0]["Clave"].'.png';
if (file_exists($img)) {
  $vstImg = 1;
} else {
  $vstImg = 0;
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php");

   ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Oferta educativa
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Actualizar</a></li>
        <li class="active">Nombre</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-fw fa-folder-open"></i> Actualizar informaci&oacute;n</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
  		  <form name="frm" id="frm" action="adUpdOferta.php" method="POST" enctype="multipart/form-data">
        <input id="TipoGuardar" name="TipoGuardar" value="val_adUpdOferta" type="hidden"/>
        <input id="IdEducativa" name="IdEducativa" value="<?php echo $ofertaIdGet; ?>" type="hidden"/>
        <input id="ClaveO" name="ClaveO" value="<?php echo $ofertaId[0]["Clave"]; ?>" type="hidden"/>
        <input id="Mov" name="Mov" value="" type="hidden"/>
      <div class="col-md-3">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Clave:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-key"></i>
						  </div>
						  <input disabled class="form-control" id="txtClave" name="txtClave" placeholder="Clave" type="text" value="<?php echo $ofertaId[0]["Clave"]; ?>" >
						</div>
					</div>
				  </div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Tipo:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-list-alt"></i>
						  </div>
						  <select class="form-control" name="txtTipo" id="txtTipo">
							<option value=""> - Seleccione - </option>
              				<option value="1" <?php if($ofertaId[0]["IdGrado"] == "1"){?>selected="selected"<?php }?>> DOCTORADO </option>
							<option value="2" <?php if($ofertaId[0]["IdGrado"] == "2"){?>selected="selected"<?php }?>> MAESTRIA </option>
							<option value="3" <?php if($ofertaId[0]["IdGrado"] == "3"){?>selected="selected"<?php }?>> LICENCIATURA </option>
							<option value="4" <?php if($ofertaId[0]["IdGrado"] == "4"){?>selected="selected"<?php }?>> BACHILLERATO </option>
							<option value="7" <?php if($ofertaId[0]["IdGrado"] == "7"){?>selected="selected"<?php }?>> DIPLOMADO</option>
							<option value="8" <?php if($ofertaId[0]["IdGrado"] == "8"){?>selected="selected"<?php }?>> CURSO</option>
						  </select>
						</div>
					</div>
				  </div>
			  </div>
			</div>
      <!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Rvoe:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-book"></i>
						  </div>
						  <input class="form-control" id="txtRvoe" name="txtRvoe" placeholder="Rvoe" type="text" value="<?php echo $ofertaId[0]["Rvoe"]; ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div> -->
			<div class="col-md-6">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Nombre:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-book"></i>
						  </div>
						  <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" value="<?php echo $ofertaId[0]["Nombre"]; ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div>
      <div class="col-md-3">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Grados:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-qrcode"></i>
						  </div>
						  <select class="form-control" name="txtGrado" id="txtGrado">
							<option value=""> - Seleccione - </option>
              <option value="1" <?php if($ofertaId[0]["Numero"] == "1"){?>selected="selected"<?php }?>> 1 </option>
							<option value="2" <?php if($ofertaId[0]["Numero"] == "2"){?>selected="selected"<?php }?>> 2 </option>
              <option value="3" <?php if($ofertaId[0]["Numero"] == "3"){?>selected="selected"<?php }?>> 3 </option>
              <option value="4" <?php if($ofertaId[0]["Numero"] == "4"){?>selected="selected"<?php }?>> 4 </option>
              <option value="5" <?php if($ofertaId[0]["Numero"] == "5"){?>selected="selected"<?php }?>> 5 </option>
              <option value="6" <?php if($ofertaId[0]["Numero"] == "6"){?>selected="selected"<?php }?>> 6 </option>
              <option value="7" <?php if($ofertaId[0]["Numero"] == "7"){?>selected="selected"<?php }?>> 7 </option>
              <option value="8" <?php if($ofertaId[0]["Numero"] == "8"){?>selected="selected"<?php }?>> 8 </option>
              <option value="9" <?php if($ofertaId[0]["Numero"] == "9"){?>selected="selected"<?php }?>> 9 </option>
						  </select>
						</div>
					</div>
				  </div>
			  </div>
			</div>
      <div class="col-md-9">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Imagen de la oferta:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-book"></i>
						  </div>
						  <input class="form-control" id="txtImagen" name="txtImagen" placeholder="Nombre" type="file">
              <?php if($vstImg == 1){ ?>
              <span class="input-group-btn">
                <button onClick="window.open('<?php echo $img; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-info btn-flat"><i class="fa fa-file-image-o"></i> Ver imagen de la oferta</button>
              </span><?php } ?>
						</div>
					</div>
				  </div>
			  </div>
			</div>
      <!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Vigencia:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-book"></i>
						  </div>
						  <input class="form-control" id="txtVigencia" name="txtVigencia" placeholder="Vigencia" type="text" value="<?php echo $ofertaId[0]["Vigencia"]; ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div> -->
			<!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Ciclo escolar:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-hourglass-2"></i>
						  </div>
						  <select class="form-control" name="txtCiclo" id="txtCiclo">
							<option value=""> - Seleccione - </option>
              <option value="Semestre" <?php if($ofertaId[0]["Ciclo"] == "Semestre"){?>selected="selected"<?php }?>> Semestre </option>
              <option value="Cuatrimestre" <?php if($ofertaId[0]["Ciclo"] == "Cuatrimestre"){?>selected="selected"<?php }?>> Cuatrimestre </option>
						  </select>
						</div>
					</div>
				  </div>
			  </div>
			</div> -->
			<!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Duración (No. semestres y/o cuatrimestres):</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-tag"></i>
						  </div>
						  <input class="form-control" data-inputmask="&quot;mask&quot;: &quot;99&quot;" data-mask="" type="text" name="txtTotal" id="txtTotal" value="<?php if( $ofertaId[0]["Duracion"] < 10 ){ $var = "0"; } else { $var = ""; }  echo $var.$ofertaId[0]["Duracion"]; ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div> -->
			<!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Total créditos:</label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-tasks"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="txtCreditos" id="txtCreditos" value="<?php echo $ofertaId[0]["Creditos"]; ?>">
						</div>
					  </div>
				  </div>
			  </div>
			</div> -->
      <!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Rvoe:</label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-qrcode"></i>
						  </div>
						  <input type="text" class="form-control pull-right" name="txtRvoe" id="txtRvoe" value="<?php echo $ofertaId[0]["Rvoe"]; ?>">
						</div>
					  </div>
				  </div>
			  </div>
			</div> -->
      <!-- <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Estatus:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-hourglass-2"></i>
						  </div>
						  <select class="form-control" name="txtEstatus" id="txtEstatus">
							<option value=""> - Seleccione - </option>
              <option value="Activo" <?php if($ofertaId[0]["Estatus"] == "Activo"){?>selected="selected"<?php }?>> Activo </option>
              <option value="Inactivo" <?php if($ofertaId[0]["Estatus"] == "Inactivo"){?>selected="selected"<?php }?>> Inactivo </option>
						  </select>
						</div>
					</div>
				  </div>
			  </div>
			</div> -->
			<div class="col-md-12">
			    <div class="box-primary">
				    <div class="box-body">
						<div class="box-footer" style=" text-align: center;">
							<button type="button" class="btn btn-default" onClick="window.open('adAddOferta.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-rotate-left"></i> Regresar </button>
              <button type="button" class="btn bg-maroon btn-flat" onClick="val_adUpdOferta()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
						</div>
				    </div>
			    </div>
			  <!-- /.box -->
			</div>
      <?php
      function listarArchivos( $path ){
          // Abrimos la carpeta que nos pasan como parámetro
          $dir = opendir($path);
          // Leo todos los ficheros de la carpeta
          while ($elemento = readdir($dir)){
              // Tratamos los elementos . y .. que tienen todas las carpetas
              if( $elemento != "." && $elemento != ".."){
                  // Si es una carpeta
                  if( is_dir($path.$elemento) ){
                      // Muestro la carpeta
                      echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                  // Si es un fichero
                  } else {
                      // Muestro el fichero
                      echo "<br />". $elemento;
                  }
              }
          }
      }

      // listarArchivos("./assets/images/oferta/");
      ?>

			</form>
			<br><br><br><br>
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php


  // Llamamos a la función para que nos muestre el contenido de la carpeta gallery


   include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- SlimScroll
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1
<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
$(document).ready(function(){
    $("#txtServicio").change(function () {
      $("#txtServicio option:selected").each(function () {
        idServicio = $(this).val();
        if(idServicio == 1){
           document.getElementById("Campus").style.display = 'none';
        } else {
          document.getElementById("Campus").style.display = 'block';
        }
      });
    })
  });

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()



    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
