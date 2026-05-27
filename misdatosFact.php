<?php $section = "Datos de facturación"; include("head.php"); $var = 10;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en datos de facturación'); }
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
$datFactura = $t->get_datosFactura($_SESSION['IdUsua']);
$usoCFDI = $t->get_usoCFDI();
$regimeFiscal = $t->get_regimenFiscal();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="saveDFactura"){
  $t->add_datosFactura();
  exit;
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="no_factura"){
  $t->add_datos_no_factura();
  exit;
}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Datos de facturación
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="miEspacio.php"> Mi espacio</a></li>
        <li class="active"> Mi informaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">

        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["Nombre"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <?php include("datEspacio.php"); ?>
              </ul>
            </div>
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Datos para facturaci&oacute;n</h3>
            </div>

            <form name="frm" id="frm" action="misdatosFact.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="" type="hidden"/>
              <input id="IdDocente" name="IdDocente" value="<?php echo $datosUser[0]["IdUsua"] ?>" type="hidden"/>
              <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
              <input id="IdDatosFacturacion" name="IdDatosFacturacion" value="<?php echo $datFactura[0]["IdDatosFacturacion"]; ?>" type="hidden"/>
              <input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>

              <div class="col-md-12">
        			  <div class="box-primary">
        					<div class="form-group">
                    <?php if($datFactura[0]["IdEstatus"] == 8){ ?>
        						<div class="bg-purple-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-check-circle"></i>  DATOS DE FACTURA ACTIVO </span></div>
                    <?php } ?>
                    <?php if($datFactura[0]["IdEstatus"] == 9){ ?>
        						<div class="bg-red-active color-palette" style="padding: 5px;"><span> <i class="fa fa-fw fa-warning"></i> FACTURA INACTIVA </span></div>
                    <?php } ?>
                    <?php if($datFactura[0]["IdEstatus"] == ''){ ?>
        						<div class="bg-navy-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-edit"></i>  DATOS DE FACTURA INCOMPLETA </span></div>
                    <?php } ?>
        					</div>
        			  </div>
        			</div>
              <div class="col-md-12">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Regimen Fiscal:</label>
                    <select class="form-control" name="txtRegimen" id="txtRegimen">
                      <option value=""> - Seleccione - </option>
                      <?php for ($i=0;$i< sizeof($regimeFiscal);$i++) { ?>
                      <option value="<?php echo $regimeFiscal[$i]["IdRegimen"]; ?>"<?php if($datFactura[0]["IdRegimen"]==$regimeFiscal[$i]["IdRegimen"]){?>selected="selected"<?php }?>><?php echo $regimeFiscal[$i]["Clave"].' | '.$regimeFiscal[$i]["Descripcion"]; ?></option>
                      <?php } ?>
                    </select>
        					</div>
        			  </div>
        			</div>
              <div class="col-md-12">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Uso CFDI:</label>
                    <select class="form-control" name="txtUso" id="txtUso">
                      <option value=""> - Seleccione - </option>
                      <?php for ($i=0;$i< sizeof($usoCFDI);$i++) { ?>
                      <option value="<?php echo $usoCFDI[$i]["IdUso"]; ?>"<?php if($datFactura[0]["IdUso"]==$usoCFDI[$i]["IdUso"]){?>selected="selected"<?php }?>><?php echo $usoCFDI[$i]["Clave"].' | '.$usoCFDI[$i]["Descripcion"]; ?></option>
                      <?php } ?>
                    </select>
        					</div>
        			  </div>
        			</div>
              <div class="col-md-4">
        			  <div class="box-primary">
        					<div class="form-group" style="margin-bottom: none !important;">
        						<label>RFC:</label>
        						<input class="form-control" id="txtRFC" name="txtRFC" placeholder="RFC" type="text" value="<?php echo $datFactura[0]["RFC"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-8">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Raz&oacute;n social: (nombre de la empresa o persona)</label>
        						<input class="form-control" id="txtRazon" name="txtRazon" placeholder="Razón social" type="text" value="<?php echo $datFactura[0]["Razon"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-12">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Domicilio:</label>
        						<input class="form-control" id="txtDomicilio" name="txtDomicilio" placeholder="Domicilio" type="text" value="<?php echo $datFactura[0]["Domicilio"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-4">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>No. Exterior:</label>
        						<input class="form-control" id="txtNoExterior" name="txtNoExterior" placeholder="No. Exterior" type="text" value="<?php echo $datFactura[0]["NoExterior"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-4">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>No. Interior:</label>
        						<input class="form-control" id="txtNoInterior" name="txtNoInterior" placeholder="No Interior" type="text" value="<?php echo $datFactura[0]["NoInterior"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-4">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>C&oacute;digo postal:</label>
        						<input class="form-control" id="txtCP" name="txtCP" placeholder="Código Postal" type="text" value="<?php echo $datFactura[0]["CP"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-6">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Colonia:</label>
        						<input class="form-control" id="txtColonia" name="txtColonia" placeholder="Colonia" type="text" value="<?php echo $datFactura[0]["Colonia"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-6">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Municipio:</label>
        						<input class="form-control" id="txtMunicipio" name="txtMunicipio" placeholder="Municipio" type="text" value="<?php echo $datFactura[0]["Municipio"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-6">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Ciudad:</label>
        						<input class="form-control" id="txtCiudad" name="txtCiudad" placeholder="Ciudad" type="text" value="<?php echo $datFactura[0]["Ciudad"]; ?>">
        					</div>
        			  </div>
        			</div>
              <div class="col-md-6">
        			  <div class="box-primary">
        					<div class="form-group">
        						<label>Estado:</label>
        						<input class="form-control" id="txtEstado" name="txtEstado" placeholder="Estado" type="text" value="<?php echo $datFactura[0]["Estado"]; ?>">
        					</div>
        			  </div>
        			</div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button onClick="no_voy_facturar()" href="javascript:void(0);" type="button" class="btn btn-danger"><i class="fa fa-fw fa-warning"></i> NO VOY A FACTURAR</button>
                <button onClick="val_datoFactura()" type="button" class="btn btn-info pull-right"><i class="fa fa-fw fa-save"></i> Actualizar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
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
<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", " Datos para factura guardado correctamente", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", " Datos para factura actualizado correctamente", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", " Favor de verificar sus datos, ha ocurrido un error", "error");
		}
    if(alerta =="ERROR2"){
			swal("Error", "Favor de actualizar su plataforma con Control  + F5 para poder hacer el proceso se guardar", "error");
		}
	}

});

function no_voy_facturar(){
      swal({
  		title: "\u00BFEst\u00E1 seguro que usted no va a necesitar facturas?",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: '#DD6B55',
  		confirmButtonText: 'Aceptar',
  		cancelButtonText: "Cancelar",
  		//closeOnConfirm: false,
  		//closeOnCancel: false
  	},
  	function (isConfirm) {
  		if (isConfirm) {
  			document.frm.Mov.value='no_factura';document.frm.submit();
  			return true;
  		} else {
  			return false;
  		}
  	});
}
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);?>
