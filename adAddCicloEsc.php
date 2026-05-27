<?php $valor = 1; $section = "Periodo escolar"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en le módulo de creación de periodo escolar'); }
$periodo=$t->get_periodo();
$meses=$t->get_meses();
$anio=$t->get_anios();

if(isset($_POST["txtTipo"])){ $_POST["txtTipo"] = $_POST["txtTipo"];  } else { $_POST["txtTipo"] = ''; }
if(isset($_POST["txtAnio"])){ $_POST["txtAnio"] = $_POST["txtAnio"];  } else { $_POST["txtAnio"] = ''; }


if(isset($_GET["Tipo"])){ $_POST["txtTipo"] = $_GET["Tipo"];  }
if(isset($_GET["Anio"])){ $_POST["txtAnio"] = $_GET["Anio"];  }

if(isset($_POST["txtTipo"])){
  $lstCiclo=$t->get_lstCiclo($_POST["txtTipo"]);
}
 ?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Periodo Escolar</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i>Periodo</a></li>
        <li class="active">Crear Periodo Escolar</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-fw fa-folder-open"></i> Creaci&oacute;n de Periodo Escolar</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
    		  <form name="frm" id="frm" action="adAddCicloEsc.php" method="POST" enctype="multipart/form-data">
    		  <input id="TipoGuardar" name="TipoGuardar" value="adAddCicloEscV" type="hidden"/>
          <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
            <div class="col-md-4">
      			  <div class="box-primary">
      				  <div class="box-body">
      					<div class="form-group">
      						<label>Tipo:</label>
      						<div class="input-group">
      						  <div class="input-group-addon">
      							<i class="fa fa-book"></i></div>
                    <select class="form-control" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
        							<option value=""> - Seleccione - </option>
                      <option value="SEMESTRE" <?php if($_POST["txtTipo"]=="SEMESTRE"){?>selected="selected"<?php } ?>> SEMESTRE </option>
                      <option value="CUATRIMESTRE" <?php if($_POST["txtTipo"]=="CUATRIMESTRE"){?>selected="selected"<?php } ?>> CUATRIMESTRE </option>
                      <option value="TRIMESTRE" <?php if($_POST["txtTipo"]=="TRIMESTRE"){?>selected="selected"<?php } ?>> TRIMESTRE </option>
      						  </select>
      						</div>
      					</div>
      				  </div>
      			  </div>
      			</div>
            <div class="col-md-4">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Mes inicial:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar-check-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
                  </div>
                </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Mes final:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar-check-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
                  </div>
                </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
      			  <div class="box-primary">
      				  <div class="box-body">
      					<div class="form-group">
      						<label>C&oacute;digo Periodo Escolar:</label>
      						<div class="input-group">
      						  <div class="input-group-addon">
      							<i class="fa fa-code"></i>
      						  </div>
                    <input type="text" class="form-control pull-right" id="txtCiclo" name="txtCiclo">
      						</div>
      					</div>
      				  </div>
      			  </div>
      			</div>
            <div class="col-md-4">
      			  <div class="box-primary">
      				  <div class="box-body">
      					<div class="form-group">
      						<label>Ciclo Escolar:</label>
      						<div class="input-group">
      						  <div class="input-group-addon">
      							<i class="fa fa-code"></i>
      						  </div>
                    <select class="form-control select2" name="txtPeriodo" id="txtPeriodo">
                      <option value=""> - Seleccione - </option>
                      <?php for ($i=0;$i< sizeof($periodo);$i++) { ?>
                      <option value="<?php echo $periodo[$i]["IdPeriodo"]; ?>"><?php echo $periodo[$i]["Periodo"]; ?></option>
                      <?php } ?>
                    </select>
      						</div>
      					</div>
      				  </div>
      			  </div>
      			</div>

            <div class="col-md-4">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="input-group">
                    <button type="button" class="btn btn-success" onClick="adAddCicloEscV()"><i class="fa fa-fw fa-save"></i> Guardar</button>
                  </div>
                </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> Lista de Periodos Escolares datos de alta</h3>
            </div>
            <?php if(isset($lstCiclo[0])){ ?>
            <div class="box-body">
              <table class="table table-striped" style="font-size: 12px;">
                <tbody><tr>
                  <th></th>
                  <th>CICLO ESCOLAR</th>
                  <th>PERIODO ESCOLAR</th>
                  <th>TIPO</th>
                  <th>FECHA INICIAL</th>
                  <th>FECHA FINAL</th>
                  <th>ESTATUS</th>
                </tr>
                <?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
                <tr>
                  <td>
                    <button type="button" class="btn bg-maroon btn-flat btn-sm view_updCiclo" href="javascript:void(0);" name="view" value="view" id="<?php echo $lstCiclo[$i]["IdCiclo"] ?>"> <i class="fa fa-fw fa-edit"></i> </button>
                  </td>
                  <td><?php echo $lstCiclo[$i]["Periodo"]; ?></td>
                  <td><?php echo $lstCiclo[$i]["Ciclo"]; ?></td>
                  <td><?php echo $lstCiclo[$i]["Tipo"]; ?></td>
                  <td><?php echo obtenerFechaCorta($lstCiclo[$i]["FInicio"]); ?></td>
                  <td><?php echo obtenerFechaCorta($lstCiclo[$i]["FFinal"]); ?></td>
                  <td><?php echo $lstCiclo[$i]["Estatus"]; ?></td>
                </tr><?php } ?>
              </tbody></table>
            </div><?php } ?>
          </div>
        </div>
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

  <div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Editar Periodo Escolar</h4>
                 </div>
                 <div class="modal-body" id="employee_detail3">

                 </div>
            </div>
       </div>
  </div>

  <div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: #056fb1; color: white; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">SubPeriodos</h4>
                 </div>
                 <div class="modal-body" id="employee_detail4">

                 </div>
            </div>
       </div>
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
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
$(document).ready(function(){
		 $(document).on('click', '.view_updCiclo', function(){
					var employee_id = $(this).attr("id");


					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/updCicloEscolar.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail3').html(data);
												 $('#dataModal3').modal('show');
										}
							 });
					}
		 });
});


$(document).ready(function(){
		 $(document).on('click', '.view_subPeriodo', function(){
					var employee_id = $(this).attr("id");


					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/addSubPeriodo.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail4').html(data);
												 $('#dataModal4').modal('show');
										}
							 });
					}
		 });
});


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })

		$('#datepicker2').datepicker({
      autoclose: true
    })

    $('#datepicker3').datepicker({
      autoclose: true
    })

  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
