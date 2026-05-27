<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["employee_id"];

  $sql9 = $db->query("SELECT tblp_asignacion.IdCampus, tblp_asignacion.IdEducativa FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdCampus = $datos91["IdCampus"];
  $IdEducativa = $datos91["IdEducativa"];

  $sql_user = $db->query("SELECT
tblx_evaluacion.IdEvaluacionX,
tblx_evaluacion.FecIni,
tblx_evaluacion.FecFin,
tblx_evaluacion.Ini,
tblx_evaluacion.Fin,
tblc_estatus.Estatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_tipoevaluacion.Evaluacion
FROM
tblx_evaluacion
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_evaluacion.IdEstatus
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_evaluacion.IdUsua
Left Join tblc_tipoevaluacion ON tblc_tipoevaluacion.IdTipoEvaluacion = tblx_evaluacion.IdTipo
WHERE
tblx_evaluacion.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC ");

$sql_lista = $db->query("SELECT
tblc_tipoevaluacion_setting.IdTipoEvaluacion,
tblc_tipoevaluacion.Evaluacion
FROM
tblc_tipoevaluacion_setting
Left Join tblc_tipoevaluacion ON tblc_tipoevaluacion.IdTipoEvaluacion = tblc_tipoevaluacion_setting.IdTipoEvaluacion
WHERE tblc_tipoevaluacion_setting.IdCampus = '$IdCampus' AND tblc_tipoevaluacion_setting.IdOferta = '$IdEducativa' AND tblc_tipoevaluacion.Cve= '1' AND tblc_tipoevaluacion.IdPermiso = '3' AND tblc_tipoevaluacion.IdEstatus = '8'");

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="IdAsignacion" id="IdAsignacion" value="<?php echo $IdAsignacion; ?>">
    

    <table class="table table-striped" style="font-size: 12px;">
      <tbody><tr>
        <th style="width: 10px">#</th>
        <th>Nombre del alumno</th>
        <th>Estatus</th>
        <th>Tipo</th>
        <th>Fecha</th>
        <th>Fecha de realización</th>
      </tr>
      <?php $xc = 0; while($_user = $db->recorrer($sql_user)){ ?>
      <tr>
        <td><b><?php echo $xc = ($xc + 1);?>.-</b></td>
        <td><?php echo $_user['APaterno'].' '.$_user['AMaterno'].' '.$_user['Nombre']; ?></td>
        <td><?php echo $_user['Estatus']; ?></td>
        <td><?php echo $_user['Evaluacion']; ?></td>
        <td><?php echo obtener_dia($_user['FecIni']).' al '.obtener_dia($_user['FecFin']).' de '.substr($_user['FecFin'],0,4); ?></td>
        <td><?php echo $_user['Ini'].' al '.$_user['Fin']; ?></td>
      </tr>
      <?php } ?>
    </tbody></table>
    <?php if($xc == 0){ ?>
    <div class="box-body">
    <div class="col-md-12">
      <div class="form-group">
        <label>Tipo de evaluación y/o encuesta:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-book"></i>
          </div>
          <select name="txtEvax" id="txtEvax" class="form-control">
            <option value="">- Seleccione - </option>
            <?php $xc = 0; while($_lista = $db->recorrer($sql_lista)){ ?>
            <option value="<?php echo $_lista['IdTipoEvaluacion']; ?>"> <?php echo $_lista['Evaluacion']; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Fecha inicial:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Fecha final:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
          <span class="input-group-btn">
            <button onclick="save_registro()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i> Publicar</button>
          </span>
        </div>
      </div>
    </div>
  </div><?php } ?>


  </form>

  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
function save_registro(){
    var IdTipoEvaluacion = document.getElementById("txtEvax").value;
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var Fec1 = document.getElementById("datepicker1").value;
    var Fec2 = document.getElementById("datepicker2").value;

    if (IdTipoEvaluacion ==""){
        swal("Error al guardar", "Debe seleccionar el tipo de evaluación que va a publicar.", "error");
        document.getElementById("txtEvax").focus();
        return 0;
    }
    if (Fec1 ==""){
        swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
        document.getElementById("datepicker1").focus();
        return 0;
    }
    if (Fec2 ==""){
        swal("Error al guardar", "Debe seleccionar el final final.", "error");
        document.getElementById("datepicker2").focus();
        return 0;
    }

    var TipoGuardar = "sav_encuesta";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea publicarlo con estos datos?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, Fec1:Fec1, Fec2:Fec2, IdTipoEvaluacion:IdTipoEvaluacion},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Publicado correctamente", "La encuesta a los docentes se ha publicado correctamente.", "success");
            $.ajax({
                 url:"formConsulta/vista_evualuacion.php",
                 method:"POST",
                 data:{employee_id:IdAsignacion},
                 success:function(data){
                      $('#employee_detailEv').html(data);
                      $('#dataModalEv').modal('show');
                 }
            });
  				}
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

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
