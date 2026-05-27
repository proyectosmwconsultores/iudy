<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCalendario = $_POST["IdCalendario"];
$anio = date("Y");
$sql9 = $db->query("SELECT * FROM tble_calendario WHERE tble_calendario.IdCalendario = '$IdCalendario' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);
$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.FInicio DESC ");

  ?>
  <form name="frm2sr" id="frm2sr" action="updCampus.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Periodo escolar:</label>
              <select class="form-control" name="txt_xciclo" id="txt_xciclo">
                <option value="">- Seleccione -</option>
                <?php while($_ciclo = $db->recorrer($sql_ciclo)){ ?>
                <option value="<?php echo $_ciclo['IdCiclo']; ?>" <?php if($datos91["IdCiclo"] == $_ciclo['IdCiclo']){ ?>selected="selected"<?php } ?>> <?php echo $_ciclo['Ciclo']; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Modalidad:</label>
              <select class="form-control" name="txt_xmodalidad" id="txt_xmodalidad">
              <option value="">- Seleccione -</option>
                <option value="E" <?php if($datos91["Modalidad"] == 'E'){ ?>selected="selected"<?php } ?>> Escolarizado </option>
                <option value="N" <?php if($datos91["Modalidad"] == 'N'){ ?>selected="selected"<?php } ?>> No escolarizado </option>
                <option value="M" <?php if($datos91["Modalidad"] == 'M'){ ?>selected="selected"<?php } ?>> Mixto </option>
                <option value="L" <?php if($datos91["Modalidad"] == 'L'){ ?>selected="selected"<?php } ?>> Linea </option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del calendario escolar:</label>
                <input type="text" name="txt_xnombre" id="txt_xnombre" class="form-control" value="<?php echo $datos91["Nombre"]; ?>">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn bg-maroon btn-flat pull-right" onClick="upd_calendario_id(<?php echo $IdCalendario; ?>)"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>
  </form>

  <script>
  function upd_calendario_id(IdCalendario){
  var IdCiclo = document.getElementById("txt_xciclo").value;
  var Nombre = document.getElementById("txt_xnombre").value;
  var Mod = document.getElementById("txt_xmodalidad").value;

  if (IdCiclo ==''){
      swal("Error al guardar", "Debe seleccionar el Periodo Escolar.", "error");
      document.getElementById("txt_xciclo").focus();
      return 0;
  }

  if (Nombre ==''){
      swal("Error al guardar", "Debe escribir el nombre del calendario escolar.", "error");
      document.getElementById("txt_xnombre").focus();
      return 0;
  }
  if (Mod ==''){
      swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
      document.getElementById("txt_xmodalidad").focus();
      return 0;
  }

  var TipoGuardar = "asig_fecha_grp";
  swal({
    title: "\u00BFEst\u00E1 seguro que desea actualizar este calendario escolar?",
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
           data:{TipoGuardar:TipoGuardar, IdCiclo:IdCiclo, Nombre:Nombre, IdCalendario:IdCalendario, Mod:Mod},
           success:function(data){
           }
      })
      .done(function(data) {
        if(data==1){
          swal("Actualizado correctamente", "Los datos se han actualizado correctamente.", "success");
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
