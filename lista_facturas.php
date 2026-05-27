<?php $valor = 3; $section = "Facturas solicitadas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando las facturas solicitadas'); }

if(isset($_POST["txtEstatus"])){ $_POST["txtEstatus"] = $_POST["txtEstatus"]; } elseif(isset($_GET["s"])){ $_POST["txtEstatus"] = $_GET["s"]; } else { $_POST["txtEstatus"] = ''; }

$facturas=$t->get_facturas($_POST["txtEstatus"]);
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Reporte de facturas generadas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Facturas</a></li>
					<li class="active">Reporte</li>
				</ol>
			</section>
			<section class="content">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Reporte de facturas generadas por rango de fecha</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <form name="frm" id="frm" action="repIngresosDia.php" method="POST" enctype="multipart/form-data">
								<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
								<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
								<input id="Numero" name="Numero" value="4" type="hidden"/>
								<input id="Nombre" name="Nombre" value="Reporte de facturas" type="hidden"/>
                <div class="col-md-5">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Fecha inicial: </label>
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
          						<label>Fecha final: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-calendar"></i>
          						  </div>
                        <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
                        <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" onclick="consultar_facturas()"><i class="fa fa-fw fa-search"></i> Consultar</button>
                    </span>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
								<div class="col-md-12">
	                <div id="miTablaEvaluacion">
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

		<div id="data_fact_cancel"  class="modal fade">
				 <div class="modal-dialog">
							<div class="modal-content">
									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-times-circle"></i> Cancelar factura</h4>
									 </div>

									 <div class="modal-body" id="employee_fact_cancel">
									 </div>
							</div>
				 </div>
		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->

<script>
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

		function consultar_facturas(){
	    var Inicio = document.getElementById("datepicker1").value;
	    var Final = document.getElementById("datepicker2").value;

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

      var Capa = "#miTablaEvaluacion";
      $(Capa).load("dashboard/lista_facturas_generadas.php",{Inicio:Inicio, Final:Final}, function(response, status, xhr) {

        if (status == "error") {
          var msg = "Error!, algo ha sucedido: ";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    }

		function cancelar_factura(IdFactura){
			$.ajax({
		     url:"formConsulta/cancelar_factura.php",
		     method:"POST",
		     data:{IdFactura:IdFactura},
		       success:function(data){
		          $('#employee_fact_cancel').html(data);
		          $('#data_fact_cancel').modal('show');
		       }
		  });
		}
</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
