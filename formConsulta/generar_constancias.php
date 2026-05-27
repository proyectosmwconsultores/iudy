
<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST["IdCiclo"];
  $_co = 0;
  $sql_grp = $db->query("SELECT tblp_constancia.IdConst, tblp_constancia.IdOferta, tblp_constancia.IdEstatus, tblp_constancia.Fecha, tblp_educativa.Nombre FROM tblp_constancia Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_constancia.IdOferta WHERE tblp_constancia.IdCiclo = '$IdCiclo' ORDER BY tblp_educativa.IdGrado ASC "); ?>
  <form  name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">


      <?php $c = 0; while($_grp = $db->recorrer($sql_grp)){ $c = 1;
        if($_grp['IdEstatus'] == 1){ ?>
          <div class="col-md-12">
            <div class="btn-group" style="margin-right: 10px; margin-bottom: 5px;">
                <button type="button" class="btn btn-danger btn-flat"><?php echo $_grp['Nombre']; ?></button>
                <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false" onclick="gen_constId(<?php echo $IdCiclo; ?>,<?php echo $_grp['IdConst']; ?>,<?php echo $_grp['IdOferta']; ?>)"> <i class="fa fa-fw fa-check-circle"></i> Generar </button>
            </div>
          </div>
        <?php } else { $_co = 1;?>
          <div class="col-md-12">
            <div class="btn-group" style="margin-right: 10px; margin-bottom: 5px;">
                <button type="button" class="btn btn-success btn-flat"><?php echo $_grp['Nombre']; ?></button>
            </div>
          </div>
        <?php } ?>
      <?php } ?>
      <?php if($c == 0){ ?>
      <div class="col-md-12">
        <div class="form-group">
          <label>Seleccione la fecha con la que se emitira el reconocimiento:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" name="datepickerx" id="datepickerx" class="form-control">
            <span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat" onclick="sav_fec_const(<?php echo $IdCiclo; ?>)"><i class="fa fa-save"></i> Aplicar fecha</button>
            </span>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($_co == 1){ ?>
      <div class="col-md-12" style="margin-top: 50px;">
        <div class="form-group">
            <button type="button" class="btn btn-block btn-danger" onclick="del_const_gen(<?php echo $IdCiclo; ?>)"><i class="fa fa-trash"></i> Eliminar todos los reconocimientos generado en este periodo escolar</button>
        </div>
      </div><?php } ?>
    </table>


  </div>

  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <!-- <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
  <!-- bootstrap time picker-->
  <!-- <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->

<script>
$(function () {
  $('.select2').select2()

})

  $(function () {

    //Date picker
    $('#datepickerx').datepicker({
      autoclose: true
    })

  })

  function sav_fec_const(IdCiclo){
    var Fecha = document.getElementById("datepickerx").value;
    if(Fecha==''){
		    swal("Error al guardar", "Debe seleccionar la fecha de emisión del reconocimiento.", "error");
        document.getElementById("datepickerx").focus();
        return 0;
    }
      var TipoGuardar = "gn_constancias";

      swal({
    		title: "\u00BFEst\u00E1 seguro que desea generar los reconocimientos con la fecha seleccionada?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#DD6B55',
    		confirmButtonText: 'Aceptar',
    		cancelButtonText: "Cancelar",
    	},
    	function (isConfirm) {
    		if (isConfirm) {
    			$(".confirm").attr('disabled', 'disabled');
    			var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&Fecha=' + Fecha;
    			$.ajax({
    				type:"POST",
    				url:"formConsulta/setting.php",
    				data:datos,
    				success:function(data){

    				}
    			})
    			.done(function(data) {

            if(data==1){
    					swal("Cargado correctamente", "Las fecha se ha configurado correctamente.", "success");
              $.ajax({
            			 url:"formConsulta/generar_constancias.php",
            			 method:"POST",
            			 data:{IdCiclo:IdCiclo},
            			 success:function(data){
            						$('#employee_detailIni').html(data);
            						$('#dataModalIni').modal('show');
            			 }
            	});

    				}
    				if(data==0){
    					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al agregar 0x138", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});
    		}

    	});
  }

  function gen_constId(IdCiclo,IdConst,IdOferta){


      var TipoGuardar = "gn_const_lista";

      swal({
    		title: "\u00BFEst\u00E1 seguro que desea generar los reconocimientos de este plan de estudios?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#DD6B55',
    		confirmButtonText: 'Aceptar',
    		cancelButtonText: "Cancelar",
    	},
    	function (isConfirm) {
    		if (isConfirm) {
    			$(".confirm").attr('disabled', 'disabled');
    			var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&IdConst=' + IdConst + '&IdOferta=' + IdOferta;
    			$.ajax({
    				type:"POST",
    				url:"formConsulta/setting.php",
    				data:datos,
    				success:function(data){

    				}
    			})
    			.done(function(data) {

            if(data==1){
    					swal("Generado correctamente", "Los reconocimiento se han generado correctamente.", "success");
              $.ajax({
            			 url:"formConsulta/generar_constancias.php",
            			 method:"POST",
            			 data:{IdCiclo:IdCiclo},
            			 success:function(data){
            						$('#employee_detailIni').html(data);
            						$('#dataModalIni').modal('show');
            			 }
            	});

    				}
    				if(data==0){
    					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al agregar 0x138", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});
    		}

    	});
  }

  function del_const_gen(IdCiclo){
      var TipoGuardar = "del_const_lista";

      swal({
    		title: "\u00BFEst\u00E1 seguro que desea eliminar todos los reconocimientos generadas?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#DD6B55',
    		confirmButtonText: 'Aceptar',
    		cancelButtonText: "Cancelar",
    	},
    	function (isConfirm) {
    		if (isConfirm) {
    			$(".confirm").attr('disabled', 'disabled');
    			var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo;
    			$.ajax({
    				type:"POST",
    				url:"formConsulta/setting.php",
    				data:datos,
    				success:function(data){

    				}
    			})
    			.done(function(data) {

            if(data==1){
    					swal("Eliminado correctamente", "Los reconocimientos se han eliminado correctamente.", "success");
              document.getElementById("tbl_cons").style.display = 'none';
              $.ajax({
            			 url:"formConsulta/generar_constancias.php",
            			 method:"POST",
            			 data:{IdCiclo:IdCiclo},
            			 success:function(data){
            						$('#employee_detailIni').html(data);
            						$('#dataModalIni').modal('show');
            			 }
            	});

    				}
    				if(data==0){
    					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al agregar 0x138", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});
    		}

    	});
  }
</script>
