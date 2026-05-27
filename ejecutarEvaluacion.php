<?php $section = "Configurar evaluación"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en le módulo de evaluación y encuesta'); }


if(isset($_POST["txtCicloEscolar"])){ $_POST["txtCicloEscolar"] = $_POST["txtCicloEscolar"]; } else {  $_POST["txtCicloEscolar"] = ''; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else {  $_POST["txtOferta"] = ''; }
if(isset($_POST["txtEvaluacion"])){ $_POST["txtEvaluacion"] = $_POST["txtEvaluacion"]; } else {  $_POST["txtEvaluacion"] = ''; }

if(isset($_GET["IdC"])){ $_POST["txtCicloEscolar"] = $_GET["IdC"]; }
if(isset($_GET["IdO"])){ $_POST["txtOferta"] = $_GET["IdO"]; }
if(isset($_GET["IdE"])){ $_POST["txtEvaluacion"] = $_GET["IdE"]; }

$lstCiclo=$t->get_cEscolarLst();
$oferta=$t->get_ofertaCic($_POST["txtCicloEscolar"]);
$lstEva=$t->get_tipoEvaluacionTipo();

$lstGrup=$t->get_grpCicId($_POST["txtCicloEscolar"],$_POST["txtOferta"],$_POST["txtEvaluacion"]);
// $lstGrup=$t->get_grpCic($_POST["txtCicloEscolar"],$_POST["txtOferta"],$_POST["txtEvaluacion"]);


if(isset($_POST["Mov"]) && $_POST["Mov"]=="checkTodos"){
  $t->add_evaTodos();
  exit;
}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuración evaluación
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Configurar</a></li>
					<li class="active">Evaluación</li>
				</ol>
			</section>
			<section class="content">
                <form name="frm" id="frm" action="ejecutarEvaluacion.php" method="POST" enctype="multipart/form-data">
		        <input id="Mov" name="Mov" value="<?php echo isset($_GET['Mov']);?>" type="hidden"/>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Ciclo escolar:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<select class="form-control select2" name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
								<option value=""> - Seleccione - </option>
								<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
								<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){ ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
					</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Oferta educativa:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){  ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-4">
							<div class="form-group">
								<label>Tipo de evaluación:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtEvaluacion" id="txtEvaluacion" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstEva);$i++) { ?>
										<option value="<?php echo $lstEva[$i]["IdTipoEvaluacion"]; ?>"<?php if($_POST["txtEvaluacion"]==$lstEva[$i]["IdTipoEvaluacion"]){  ?>selected="selected"<?php }?>><?php echo $lstEva[$i]["Evaluacion"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de grupos activos en el ciclo escolar</h3>
								</div>
								<div class="box-body">
									<table class="table table-striped">
                <tbody><tr>
                  <th style="width: 150px">

                  <label> <input onclick="activarTodos()" name="ckhTodos" id="ckhTodos" type="checkbox"> <b>Activar todos</b> </label>

									</th>
                  <th>CveGrupo</th>
									<th>Campus</th>
									<th>Inicio</th>
                  <th>Final</th>
                </tr>
								<?php $valor = "";  for ($i=0;$i< sizeof($lstGrup);$i++) {
                   $idT = $_POST["txtEvaluacion"];
                  $Id = $lstGrup[$i]["IdEvaluacion"]; ?>
                <tr>
                  <td>
										<div class="checkbox">
                      <label> <input <?php if($lstGrup[$i]["Valor_$idT"] == 2){ echo "checked"; } ?> <?php if($lstGrup[$i]["Valor_$idT"] == 3){ $valor = "disabled"; echo "checked disabled"; } ?> name="ckhG-<?php echo $Id; ?>" onclick="actGrupo(<?php echo $Id; ?>)" id="ckhG-<?php echo $Id; ?>" type="checkbox"> Activar </label>
                    </div>
									</td>
									<td><?php echo $lstGrup[$i]["CveGrupo"]; ?></td>
									<td><?php echo $lstGrup[$i]["Campus"]; ?></td>
									<td><?php echo $lstGrup[$i]["FecIni_$idT"]; ?></td>
                  <td><?php echo $lstGrup[$i]["FecFin_$idT"]; ?></td>
                </tr>
								<?php } ?>
              </tbody></table>
              <hr>
                <div class="col-md-4">
      							<label>Fecha inicial:</label>
      							<div class="input-group">
      								<div class="input-group-addon">
      									<i class="fa fa-calendar"></i>
      								</div>
      								<input type="text" name="datepicker1" id="datepicker1" class="form-control">
      							</div>

      					</div>
                <div class="col-md-4">
      							<label>Fecha final:</label>
      							<div class="input-group">
      								<div class="input-group-addon">
      									<i class="fa fa-calendar"></i>
      								</div>
      								<input type="text" name="datepicker2" id="datepicker2" class="form-control">
      							</div>
      					</div>
                <div class="col-md-4">
      							<label>:.</label>
      							<div class="input-group">
      								<button <?php echo $valor; ?> onclick="saveFecha()" type="button" class="btn btn-block btn-primary btn-sm"><i class="fa fa-save"></i> Aplicar en esta fecha</button>
      							</div>
      					</div>

								</div>

							</div>
						</div>


				</div>
				</form>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>


	

</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

function actGrupo(IdEvaluacion){
  var IdTipo = document.getElementById("txtEvaluacion").value;
  var Grupo = "ckhG-"+IdEvaluacion;
  var Tipo;
  var Evalu = document.getElementById(Grupo).checked;
  if(Evalu == true){ Tipo = 2; }
  if(Evalu == false){ Tipo = 1; }

  var TipoGuardar = "mov_eva"
  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdEvaluacion:IdEvaluacion, Tipo:Tipo, IdTipo:IdTipo},
       success:function(data){

       }
  })


}

function activarTodos()
{
  var Ciclo = document.getElementById("txtCicloEscolar").value;
  var Oferta = document.getElementById("txtOferta").value;
  var IdTipo = document.getElementById("txtEvaluacion").value;


    swal({
    title: "\u00BFEst\u00E1 seguro que desea activar todos los grupos?",
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
      document.frm.Mov.value='checkTodos';document.frm.submit();
      return true;
    } else {
      return false;
    }
  });
}

function saveFecha()
{
  var Ciclo = document.getElementById("txtCicloEscolar").value;
  var Oferta = document.getElementById("txtOferta").value;
  var IdEvaluacion = document.getElementById("txtEvaluacion").value;

  if (document.frm.datepicker1.value.length==''){
  swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
      document.getElementById("datepicker1").focus();
      return 0;
  }

  if (document.frm.datepicker2.value.length==''){
  swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
      document.getElementById("datepicker2").focus();
      return 0;
  }

  var Fec1 = document.getElementById("datepicker1").value;
  var Fec2 = document.getElementById("datepicker2").value;

    swal({
    title: "\u00BFEst\u00E1 seguro que desea activar las evaluaciones de los grupos con estas fechas?",
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
      $.post("formConsulta/chkGrupo.php", { Ciclo:Ciclo, Oferta:Oferta, Fec1:Fec1, Fec2:Fec2, IdEvaluacion:IdEvaluacion },
      function(data){
        // alert(data);
        parent.location.href='ejecutarEvaluacion.php?IdC='+Ciclo+'&IdO='+Oferta+'&IdE='+IdEvaluacion;
      });
      return true;
    } else {
      return false;
    }
  });
}

</script>
<script>
  $(function () {
    $('.select2').select2()
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })
    $('#datepicker2').datepicker({
      autoclose: true
    })

  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
