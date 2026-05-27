<?php $valor = 1; $section = "Apertura de calificaciones"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en le módulo de apertura de calificaciones'); }

$lstCiclo=$t->get_cEscolarLst();
 ?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Apertura de calificaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i>Calificaciones</a></li>
        <li class="active">Apertura</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
    		  <form name="frm" id="frm" action="adApertura.php" method="POST" enctype="multipart/form-data">
    		  <input id="TipoGuardar" name="TipoGuardar" value="adAddCicloEscV" type="hidden"/>
          <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
            <div class="col-md-12">

            <div class="box-header with-border">
              <h3 class="box-title">Configuraciones generales</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th></th>
                  <th>Ciclo escolar</th>
                  <th>Tipo</th>
                  <th>Año</th>
                  <th>Mes inicial</th>
                  <th>Mes final</th>
                  <th>Estatus</th>
                </tr>
                <?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
                <tr>
                  <td style="width: 250px;">
                    <button type="button" class="btn btn-primary view_escolar" href="javascript:void(0);" name="view" value="view" id="<?php echo $lstCiclo[$i]["IdCiclo"] ?>"> <i class="fa fa-fw fa-edit"></i> Escolar</button>
                    <button type="button" class="btn btn-success view_noescolar" href="javascript:void(0);" name="view" value="view" id="<?php echo $lstCiclo[$i]["IdCiclo"] ?>"> <i class="fa fa-fw fa-edit"></i> No-escolar</button>
                  </td>
                  <td><?php echo $lstCiclo[$i]["Ciclo"]; ?></td>
                  <td><?php echo $lstCiclo[$i]["Tipo"]; ?></td>
                  <td><?php echo $lstCiclo[$i]["Anio"]; ?></td>
                  <td><?php echo obtenerFechaCorta($lstCiclo[$i]["FInicio"]); ?></td>
                  <td><?php echo obtenerFechaCorta($lstCiclo[$i]["FFinal"]); ?></td>
                  <td><?php echo $lstCiclo[$i]["Estatus"]; ?></td>
                </tr><?php } ?>
              </tbody></table>
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
                 <div class="modal-header" style="background: #056fb1; color: white; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Apertura de calificaciones Escolar</h4>
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
                      <h4 class="modal-title">Apertura de calificaciones No-Escolar</h4>
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
$(document).ready(function(){
		 $(document).on('click', '.view_escolar', function(){
					var employee_id = $(this).attr("id");
          var Tipo = "E";


					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/addApertura.php",
										method:"POST",
										data:{employee_id:employee_id, Tipo:Tipo},
										success:function(data){
												 $('#employee_detail3').html(data);
												 $('#dataModal3').modal('show');
										}
							 });
					}
		 });
});
$(document).ready(function(){
		 $(document).on('click', '.view_noescolar', function(){
					var employee_id = $(this).attr("id");
          var Tipo = "N";


					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/addApertura.php",
										method:"POST",
										data:{employee_id:employee_id, Tipo:Tipo},
										success:function(data){
												 $('#employee_detail4').html(data);
												 $('#dataModal4').modal('show');
										}
							 });
					}
		 });
});

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
