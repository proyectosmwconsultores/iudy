<?php $valor = 1; $section = "Historial de Ingresos"; include("head.php");
if($_SESSION['Permisos']) {
$datos = 1;
$Usuarios=$t->get_tUsuario($_POST["txtTipo"]);
$lstIngresos=$t->get_lstIngresos($_POST["datepicker"],$_POST["datepicker2"],$_POST["txtIdUsua"]);
$lstContador=$t->get_lstContador($_POST["datepicker"],$_POST["datepicker2"],$_POST["txtIdUsua"]);
$lstIngrC=$t->get_lstIngCount($_POST["datepicker"],$_POST["datepicker2"],$_POST["txtIdUsua"]);
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
        Historial de ingresos en la Plataforma
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
          <li class="active">Ingresos</li>
        </ol>
      </section>
      <section class="content">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Búsqueda de información</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <form name="frm" id="frm" action="acHistorialI.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET["Mov"];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Tipo usuario: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
                          <option value="0"> - Seleccione -</option>
                          <option value="1" <?php if($_POST["txtTipo"] == 1){?>selected="selected"<?php }?> > Administrador general</option>
                          <option value="2" <?php if($_POST["txtTipo"] == 2){?>selected="selected"<?php }?> > Docente </option>
    						<option value="3" <?php if($_POST["txtTipo"] == 3){?>selected="selected"<?php }?> > Alumno </option>
    						<option value="4" <?php if($_POST["txtTipo"] == 4){?>selected="selected"<?php }?> > Tutor </option>
    						<option value="5" <?php if($_POST["txtTipo"] == 5){?>selected="selected"<?php }?>> Direcci&oacute;n general </option>
    						<option value="6" <?php if($_POST["txtTipo"] == 6){?>selected="selected"<?php }?>> Finanzas </option>
                          <option value="7" <?php if($_POST["txtTipo"] == 7){?>selected="selected"<?php }?>> Servicios escolares </option>
                          <option value="8" <?php if($_POST["txtTipo"] == 8){?>selected="selected"<?php }?>> Admisiones </option>
                          <option value="9" <?php if($_POST["txtTipo"] == 9){?>selected="selected"<?php }?>> Coordinador acad&eacute;mico </option>

          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Usuario: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtIdUsua" id="txtIdUsua" onchange="document.frm.submit();">
          							<option value=""> - Seleccione - </option>
          							<?php for ($i=0;$i< sizeof($Usuarios);$i++) { ?>
          							<option value="<?php echo $Usuarios[$i]["IdUsua"]; ?>"<?php if($_POST["txtIdUsua"]==$Usuarios[$i]["IdUsua"]){?>selected="selected"<?php }?>><?php echo $Usuarios[$i]["Nombre"].' '.$Usuarios[$i]["APaterno"].' '.$Usuarios[$i]["AMaterno"]; ?></option>
          							<?php } ?>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Fec. Inicial: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-calendar"></i>
          						  </div>
                        <input type="text" class="form-control pull-right" value="<?php echo $_POST["datepicker"]; ?>" id="datepicker" name="datepicker" onchange="document.frm.submit();">
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Fec. Final: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-calendar"></i>
          						  </div>
                        <input type="text" class="form-control pull-right" value="<?php echo $_POST["datepicker2"]; ?>" id="datepicker2" name="datepicker2" onchange="document.frm.submit();">
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
              </form>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                  <div class="box-body no-padding">
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr style="background: #d2d6de; color: black;">
                          <th>Fecha captura</th>
                          <th>Movimiento</th>
                          <th style="text-align: right; color: blue;" width="100px"><?php if($lstIngresos[0]){ ?>
                            <a onclick="javascript:window.open('formConsulta/expHistorial.php?IdUsua=<?php echo $_POST["txtIdUsua"]; ?>&F1=<?php echo $_POST["datepicker"]; ?>&F2=<?php echo $_POST["datepicker2"]; ?>&Ing=<?php echo $lstIngrC[0]["Ingresos"]; ?>');" href="javascript:void(0);" class="btn btn-primary btn-block"><i class="fa fa-fw fa-cloud-download"></i> Descargar</a>
                          <?php } ?>

                            </th>
                            <th style="text-align: right; color: blue;" width="100px"><?php if($lstIngresos[0]){ ?>
                              <button class="btn btn-success btn-block">T. Ingresos = <?php echo $lstIngrC[0]["Ingresos"]; ?></button>
                            <?php } ?>

                              </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($lstIngresos);$i++) {  $total = $total  +  $ingresos[$i]["Porcentaje"]; ?>
                        <tr style=" cursor: pointer;">
                          <td>
                            <?php echo $lstIngresos[$i]["FecCap"]; ?>
                          </td>
                          <td colspan="3"><?php echo $lstIngresos[$i]["Pagina"]; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                  <div class="box-body no-padding">
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr style="background: #d2d6de; color: black;">
                          <th>Fecha ingreso</th>
                          <th>Fecha salida</th>
                          <th>Duraci&oacute;n aproximada</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($lstContador);$i++) {  $total = $total  +  $ingresos[$i]["Porcentaje"]; ?>
                        <tr style=" cursor: pointer;">
                          <td><?php echo $lstContador[$i]["FecIng"]; ?></td>
                          <td><?php echo $lstContador[$i]["FecSal"]; ?></td>
                          <td><?php echo $lstContador[$i]["Duracion"]; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>


        </div>
      </section>
    </div>
    <?php include("footer.php"); ?>
  </div>

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- date-range-picker -->
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
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
    $(function () {
      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })
  	//Date picker
      $('#datepicker2').datepicker({
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
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
