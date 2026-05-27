<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$anio = date("Y");
$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.FInicio DESC ");
  ?>
  <form name="frm2sFr" id="frm2sFr" action="updFuente.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="TipoGuardar" id="TipoGuardar" value="addCampusNew">
    <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Seleccione periodo escolar:</label>
              <select class="form-control" name="txt_ciclo" id="txt_ciclo">
                <option value="">- Seleccione -</option>
                <?php while($_ciclo = $db->recorrer($sql_ciclo)){ ?>
                <option value="<?php echo $_ciclo['IdCiclo']; ?>"> <?php echo $_ciclo['Ciclo']; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Modalidad:</label>
              <select class="form-control" name="txt_modalidad" id="txt_modalidad">
              <option value="">- Seleccione -</option>
                <option value="E"> Escolarizado </option>
                <option value="N"> No escolarizado </option>
                <option value="M"> Mixto </option>
                <option value="L"> Linea </option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del calendario:</label>
                <input name="txt_nombre" id="txt_nombre" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-success pull-right" onClick="add_calendario()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
<script>
function add_calendario(){
  var IdCiclo = document.getElementById("txt_ciclo").value;
  var Nombre = document.getElementById("txt_nombre").value;
  var Mod = document.getElementById("txt_modalidad").value;

	if (IdCiclo ==''){
			swal("Error al guardar", "Debe seleccionar el Periodo Escolar.", "error");
			document.getElementById("txt_ciclo").focus();
			return 0;
	}

  if (Nombre ==''){
			swal("Error al guardar", "Debe escribir el nombre del calendario escolar.", "error");
			document.getElementById("txt_nombre").focus();
			return 0;
	}
  if (Mod ==''){
			swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
			document.getElementById("txt_modalidad").focus();
			return 0;
	}

  var TipoGuardar = "add_calendario_esc";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo calendario escolar?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
      $.ajax({
           url:"formConsulta/setting.php",
           method:"POST",
           data:{TipoGuardar:TipoGuardar, IdCiclo:IdCiclo, Nombre:Nombre, Mod:Mod},
           success:function(data){
           }
      })
			.done(function(data) {
        if(data==1){
					swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
          parent.location.href='calendario_escolar.php';
				}
				if(data==0){
					swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}
</script>
