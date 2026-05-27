<?php $valor = 1; $section = "Configurar matrículas"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por configurar matriculas'); }
if(isset($_GET["M"])){ $_POST["txtTipo"] = $_GET["M"]; }
if(isset($_GET["C"])){ $_POST["txtCampus"] = $_GET["C"]; }
if(isset($_POST["txtTipo"])){ $_POST["txtTipo"]= $_POST["txtTipo"]; } else { $_POST["txtTipo"] = '';}
if(isset($_POST["txtCampus"])){ $_POST["txtCampus"]= $_POST["txtCampus"]; } else { $_POST["txtCampus"] = '';}
$lstSerie=$t->get_lstSerie();
$lstCampus=$t->get_campusPermiso($_SESSION['IdUsua']);
$lstOfer=$t->get_lstOfSer($_POST["txtCampus"]);

 ?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Configurar las matrículas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Inicio</a></li>
        <li class="active">Matrículas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
    		  <form name="frm" id="frm" action="adConfigSer.php" method="POST" enctype="multipart/form-data">
    		  <input id="TipoGuardar" name="TipoGuardar" value="addEnlazar" type="hidden"/>
          <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
          <div class="col-md-3">
              <div class="box-primary">
                <div class="box-body">
                  <a onclick="mostrarSer()" class="btn btn-app" href="javascript:void(0);">
                    <i class="fa fa-black-tie"></i> Nuevo
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-3">
	              <div class="box-primary">
	                <div class="form-group">
	                  <label>Seriación:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
                      <select class="form-control select2" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
                        <option value=""> - Seleccione - </option>
                        <?php for ($i=0;$i< sizeof($lstSerie);$i++) { ?>
                        <option value="<?php echo $lstSerie[$i]["Serie"]; ?>" <?php if($lstSerie[$i]["Serie"] == $_POST["txtTipo"]){ ?>selected="selected"<?php }?>><?php echo $lstSerie[$i]["Serie"]; ?></option>
                        <?php } ?>
                      </select>

	                  </div>
	                </div>
	              </div>
	            </div>
              <div class="col-md-6">
  	              <div class="box-primary">
  	                <div class="form-group">
  	                  <label>Campus:</label>
  	                  <div class="input-group">
  	                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
                        <select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
                          <option value=""> - Seleccione - </option>
                          <?php for ($i=0;$i< sizeof($lstCampus);$i++) { ?>
                          <option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>" <?php if($lstCampus[$i]["IdCampus"] == $_POST["txtCampus"]){ ?>selected="selected"<?php }?>><?php echo $lstCampus[$i]["Campus"]; ?></option>
                          <?php } ?>
                        </select>
  	                  </div>
  	                </div>
  	              </div>
  	            </div>
                <div class="col-md-6" id="ser" style="display: none;">
    	              <div class="box-primary">
    	                <div class="form-group">
    	                  <label>Clave seriación:</label>
    	                  <div class="input-group">
    	                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
                          <input type="text" name="txtClave" id="txtClave" class="form-control">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-flat" onclick="val_addSer()"><i class="fa fa-fw fa-save"></i> Guardar</button>
                          </span>
    	                  </div>
    	                </div>
    	              </div>
    	            </div>

                  <?php if((isset($_POST['txtTipo'])) && (isset($_POST['txtCampus']))){ ?>
                  <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Lista de grupos asociados a un ciclo escolar</h3>
                    </div>
                    <div class="box-body">
                      <table class="table table-bordered">
                        <tbody><tr>
                          <th>Ajuste</th>
                          <th>Nombre de la oferta educativa</th>
                        </tr>
                        <?php for ($i=0;$i< sizeof($lstOfer);$i++) {
                          $acti=$t->get_verificar($lstOfer[$i]["IdEducativa"],$_POST["txtCampus"],$_POST["txtTipo"]);
                          ?>
                        <tr>
                          <td>
                            <?php if(isset($acti[0]["IdSeriacion"])) { ?>
                            <button onclick="addmatr(<?php echo $lstOfer[$i]["IdEducativa"]; ?>, <?php echo $_POST["txtCampus"]; ?>, 1)" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i></button>
                          <?php } else { ?>
                            <button onclick="addmatr(<?php echo $lstOfer[$i]["IdEducativa"]; ?>, <?php echo $_POST["txtCampus"]; ?>, 0)" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                          <?php } ?>
                          </td>
                          <td><?php echo $lstOfer[$i]["Nombre"]; ?></td>
                        </tr><?php } ?>
                      </tbody></table>
                    </div>
                  </div>
                </div><?php } ?>
        			</form>
        			<br>
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
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
  function mostrarSer(){
    document.getElementById("ser").style.display = 'block';
  }

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
