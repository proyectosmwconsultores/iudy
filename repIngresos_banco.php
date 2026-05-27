<?php $valor = 1; $section = "Ingresos por bancos"; include("head.php");
if($_SESSION['Permisos']) {

$lst_bancos=$t->get_bancos();
//$lstIngresos=$t->get_lstDineroDia($_POST["datepicker1"],$_POST["datepicker2"]);


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Reporte de ingresos por tipo de banco</h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
          <li class="active">Ingresos</li>
        </ol>
      </section>
      <section class="content">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Ingresos capturados por rango de fecha</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <form name="frm" id="frm" action="repIngresos_banco.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
                <div class="col-md-5">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Tipo de banco: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-book"></i>
          						  </div>
                        <select class="form-control select2" name="txt_banco" id="txt_banco">
      										<option value=""> - Seleccione - </option>
                          <option value="9999">TODOS LOS BANCOS</option>
      										<?php for ($i=0;$i< sizeof($lst_bancos);$i++) { ?>
      										<option value="<?php echo $lst_bancos[$i]["IdBanco"]; ?>"><?php echo $lst_bancos[$i]["Banco"]; ?></option>
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
                        <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1" >
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Fec. Final: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-calendar"></i>
          						  </div>
                        <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
                        <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" onclick="consultar_ingresos()"><i class="fa fa-fw fa-search"></i> Consultar</button>
                    </span>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
              </form>
            </div>
          </div>
          <p style="text-align: center; display: none;" id="img_cargar">
            <img src="assets/images/cargando.gif">
          </p>

          <div class="box-body" id="mostrar_ingresos" style="display: none;"></div>
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
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script>
  function consultar_ingresos(){
    var IdBanco = document.getElementById("txt_banco").value;
    var Inicio = document.getElementById("datepicker1").value;
    var Final = document.getElementById("datepicker2").value;
    if (IdBanco ==''){
				swal("Error al buscar", "Debe seleccionar el concepto.", "error");
				document.getElementById("txt_banco").focus();
				return 0;
		}
    if (Inicio ==''){
				swal("Error al buscar", "Debe seleccionar la fecha inicial.", "error");
				document.getElementById("datepicker1").focus();
				return 0;
		}
    if (Final ==''){
				swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
				document.getElementById("datepicker2").focus();
				return 0;
		}

    document.getElementById("img_cargar").style.display = 'block';
    document.getElementById("mostrar_ingresos").style.display = 'none';
    var Capa = "#mostrar_ingresos";
    $(Capa).load("php/ajax/ingresos_bancos.php",{IdBanco:IdBanco, Inicio:Inicio, Final:Final}, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
      if (status == "success") {
        document.getElementById("mostrar_ingresos").style.display = 'block';
        document.getElementById("img_cargar").style.display = 'none';
      }
    });
  }

    $(function () {
      //Date picker
      $('#datepicker1').datepicker({
        autoclose: true
      })
  	//Date picker
      $('#datepicker2').datepicker({
        autoclose: true
      })
    })
  </script>
</body>
</html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
