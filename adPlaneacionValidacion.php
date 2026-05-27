<?php $valor = 2; $section = "Validación Planeación"; include("head.php");
	if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de validación de Planeación'); }
	if($_SESSION['Permisos'] == 9){
		$revParcial=$t->get_revisarParcial($_SESSION['IdUsua']);
	} else {
		$oferta=$t->get_OfertaETodos($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
	}



?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Informaci&oacute;n de la Planeaci&oacute;n general
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Informaci&oacute;n</a></li>
        <li class="active">Planeaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Datos de la Planeaci&oacute;n</h3>
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
        </div>
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adPlaneacionValidacion.php" method="POST" enctype="multipart/form-data">
					  <input id="Mov" name="Mov" value="<?php echo $_GET["Mov"];?>" type="hidden"/>
					  <input id="IdDatosM" name="IdDatosM" value="<?php echo $moduloDatos[0]["IdDatosM"];?>" type="hidden"/>
					  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
					  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>


						<div class="box-body">
							<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>#</th>
                  <th>Oferta educativa</th>
									<th>Asesor acad&eacute;mico</th>
                  <!-- <th>Parcial</th> -->
                </tr>
								<?php for ($i=0;$i< sizeof($revParcial);$i++) { ?>

									<tr  style="cursor: pointer; " onClick="window.open('planeacionAcademica.php?IdA=<?php echo $revParcial[$i]["IdAsignacion"]; ?>&IdO=<?php echo $revParcial[$i]["IdOferta"]; ?>&IdM=<?php echo $revParcial[$i]["IdModulo"]; ?>&IdU=<?php echo $revParcial[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);">
                <!-- <tr style="cursor: pointer; "onclick="revisarParcial(<?php echo $revParcial[$i]["IdParcialDocente"]; ?>)"> -->
                  <td><?php echo $c = $c + 1; ?></td>
									<td>
										<?php echo $revParcial[$i]["Nombre"]; ?><br>
										<?php echo $revParcial[$i]["NombreMod"]; ?>
									</td>
									<td><?php echo $revParcial[$i]["Asesor"].' '.$revParcial[$i]["APaterno"].' '.$revParcial[$i]["AMaterno"]; ?></td>
									<!-- <td>Parcial <?php echo $revParcial[$i]["NoParcial"]; ?></td> -->
                </tr>
							<?php } ?>
              </tbody></table>
            </div>


            </div>






									</div>
						</form>
          </div>
					<hr>

        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

	<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title">Informaci&oacute;n general del parcial</h4>
									</div>
									<div class="modal-body" id="employee_detail">
									</div>
						 </div>
				</div>
	 </div>

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


	function revisarParcial(IdParcial){
		var User = "C";
		$.ajax({
				 url:"formConsulta/viewRevisarParcial.php",
				 method:"POST",
				 data:{IdParcial:IdParcial,User:User},
				 success:function(data){
							$('#employee_detail').html(data);
							$('#dataModal').modal('show');
				 }
		});

	}




</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
