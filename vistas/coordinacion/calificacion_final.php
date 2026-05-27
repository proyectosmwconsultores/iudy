<?php
session_start();
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();

$IdUsua = $_SESSION["IdUsua"];
$IdCalificacion = $_POST["IdCalificacion"];


$sql_matx = $db->query("SELECT
tblp_calificacion_cambios.IdCambio,
tblp_calificacion_cambios.PromedioAnterior,
tblp_calificacion_cambios.PromedioNuevo,
tblp_calificacion_cambios.Motivo,
tblp_calificacion_cambios.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_calificacion_cambios
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion_cambios.IdUsua
WHERE tblp_calificacion_cambios.IdCalificacion = '$IdCalificacion'
ORDER BY
tblp_calificacion_cambios.FecCap ASC
 ");


$sql_cal = $db->query("SELECT
  tblp_modulo.CodeModulo,
  tblp_modulo.NombreMod,
  tblp_calificacion.IdCalificacion,
  tblp_calificacion.Promedio,
  tblp_calificacion.Observacion
  FROM
  tblp_calificacion
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
  WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");
$db->rows($sql_cal);
$_cal = $db->recorrer($sql_cal);
$_txt = "REGULAR";
if ($_cal['Observacion'] == 'R') {
  $_txt = "RECURSADO";
}
if ($_cal['Observacion'] == 'E') {
  $_txt = "EXTRAORDINARIO";
}

$sql_permiso = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '67'");
$db->rows($sql_permiso);
$_perm = $db->recorrer($sql_permiso);
?>
<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-2 control-label">MATERIA:</label>
      <div class="col-sm-10">
        <input disabled type="text" class="form-control" value="<?php echo $_cal['CodeModulo'] . ' ' . $_cal['NombreMod']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">PROMEDIO ACTUAL:</label>
      <div class="col-sm-4">
        <input style="text-align: center;" disabled type="text" class="form-control" value="<?php echo $_cal['Promedio']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">TIPO PROMEDIO:</label>
      <div class="col-sm-4">
        <input style="text-align: center;" disabled type="text" class="form-control" value="<?php echo $_txt; ?>">
      </div>
    </div>
    <?php if(isset($_perm[0])){ ?>
    <div class="form-group">
      <label class="col-sm-8 control-label">NUEVO PROMEDIO:</label>
      <div class="col-sm-4">
        <input style="text-align: center;" type="text" class="form-control" name="txt_promedio" id="txt_promedio">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">MOTIVO DEL CAMBIO:</label>
      <div class="col-sm-9">
        <textarea name="txt_motivo" id="txt_motivo" class="form-control" rows="3" placeholder="Motivo del cambio de promedio ..."></textarea>
      </div>
    </div><?php } ?>
  </div>
  <?php if(isset($_perm[0])){ ?>
  <div class="box-footer">
    <button type="button" onclick="sav_calificacion_final_id('<?php echo $_cal['Promedio']; ?>',<?php echo $IdCalificacion; ?>,<?php echo $IdUsua; ?>)" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-refresh"></i> Actualizar promedio</button>
  </div><?php } ?>

  <div class="tab-pane active" id="timeline">

    <ul class="timeline timeline-inverse">
      <?php while($x = $db->recorrer($sql_matx)){ ?>
      <li class="time-label">
        <span class="bg-red">
          <?php echo obtenerFechaCorta($x['FecCap']); ?>
        </span>
      </li>
      <li>
        <i class="fa fa-user bg-blue"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($x['FecCap']); ?></span>
          <h3 class="timeline-header"><a href="#"><?php echo $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno']; ?></a></h3>
          <div class="timeline-body">
          <?php echo $x['Motivo']; ?>
          </div>
          <div class="timeline-footer">
            <a class="btn btn-primary btn-xs">Promedio anterior: <?php echo $x['PromedioAnterior']; ?></a>
            <a class="btn btn-danger btn-xs">Promedio guardado: <?php echo $x['PromedioNuevo']; ?></a>
          </div>
        </div>
      </li>
      <?php } ?>
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>
  </div>

</form>

<script>
  function sav_calificacion_final_id(AnteriorPromedio, IdCalificacion, IdUsua) {
    var Promedio = document.getElementById("txt_promedio").value;
    var Motivo = document.getElementById("txt_motivo").value;


    if (Promedio == "") {
      swal("Error al guardar", "Debe indicar el promedio del alumno.", "error");
      document.getElementById("txt_promedio").focus();
      return 0;
    }
    if (Motivo == "") {
      swal("Error al guardar", "Debe indicar el motivo del cambio de la calificacion final.", "error");
      document.getElementById("txt_motivo").focus();
      return 0;
    }

    if ((Promedio == "NP") || (Promedio == "5") || (Promedio == "6") || (Promedio == "7") || (Promedio == "8") || (Promedio == "9") || (Promedio == "10")) {

    } else {
      swal("Error al guardar", "El promedio del alumno debe ser: NP, 5, 6, 7, 8, 9, 10.", "error");
      document.getElementById("txt_promedio").focus();
      document.getElementById("txt_promedio").value = '';
      return 0;
    }


    var TipoGuardar = "mod_calificacion_final";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar la calificacion de este alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
            url: "vistas/coordinacion/sav_coordinacion.php",
            method: "POST",
            data: {
              TipoGuardar: TipoGuardar,
              AnteriorPromedio: AnteriorPromedio,
              IdCalificacion: IdCalificacion,
              IdUsua: IdUsua,
              Promedio: Promedio,
              Motivo: Motivo
            },
            success: function(data) {
              
              $.ajax({
                url: "vistas/coordinacion/calificacion_final.php",
                method: "POST",
                data: {
                  IdCalificacion: IdCalificacion
                },
                success: function(data) {
                  $('#employee_detail_calF').html(data);
                  $('#dataModal_calF').modal('show');
                }
              });

            }
          })
        }
      });

  }


  function sel_mate_rec(IdUsua) {
    var IdPago = document.getElementById("txt_mate_rec").value;
    var IdGrupo = document.getElementById("txt_grp_rec").value;
    $.ajax({
      url: "formConsulta/recursar_materia_alumno.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        IdGrupo: IdGrupo,
        IdPago: IdPago
      },
      success: function(data) {
        $('#employee_detail_rec').html(data);
        $('#dataModal_rec').modal('show');
      }
    });
  }

  function sel_grupo_rec(IdUsua) {
    var IdPago = document.getElementById("txt_mate_rec").value;
    var IdGrupo = document.getElementById("txt_grp_rec").value;
    $.ajax({
      url: "formConsulta/recursar_materia_alumno.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        IdGrupo: IdGrupo,
        IdPago: IdPago
      },
      success: function(data) {
        $('#employee_detail_rec').html(data);
        $('#dataModal_rec').modal('show');
      }
    });
  }
</script>