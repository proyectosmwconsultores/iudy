<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdUsua = $_POST["IdUsua"];
$IdGrupox = $_POST["IdGrupo"];

$sql8 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblp_educativa.Clave, tblp_grupo.TipoCiclo
FROM tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$IdGrupo = $datos81['IdGrupo'];
$IdOferta = $datos81['IdOferta'];
$_tipoCiclo = $datos81['TipoCiclo'];
$IdCampus = $datos81['IdCampus'];

$sql_cic = $db->query("SELECT tblc_ciclo.Ciclo, tblc_ciclo.FInicio, tblc_ciclogrupo.IdCiclo FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo'  ORDER BY tblc_ciclo.FInicio DESC LIMIT 1");
$db->rows($sql_cic);
$_cic = $db->recorrer($sql_cic);
$IdCiclo = $_cic['IdCiclo'];

$sql_mat = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdEstatus FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$IdGrupox' AND tblp_asignacion.Tipo =  '2' AND ((tblp_asignacion.IdEstatus = 12) || (tblp_asignacion.IdEstatus = 8)) ");
$sql_recx = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblc_dias_clases._Dias,
tblc_campus.Campus
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo AND tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdCiclo = '$IdCiclo' AND tblp_moduloalumno.Activo = '2' AND tblp_asignacion.Tipo = '2'");

$sql_grp_dispo = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclogrupo.IdGrupo, tblc_ciclogrupo.Grado, tblp_grupo.CveGrupo, tblc_dias_clases._Dias, tblc_campus.Campus
FROM tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.Ingles = 'SI'
ORDER BY tblc_ciclogrupo.Grado ASC
 ");

?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-cog"></i> Configurar el horario personalizado de este periodo escolar</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-2 control-label">Grupo:</label>
        <div class="col-sm-10">
          <select class="form-control" name="txt_grupoy" id="txt_grupoy" onchange="sel_grupo(<?php echo $IdUsua; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while ($_grpx = $db->recorrer($sql_grp_dispo)) { ?>
              <option value="<?php echo $_grpx["IdGrupo"]; ?>" <?php if ($_grpx["IdGrupo"] == $IdGrupox) { ?>selected="selected" <?php } ?>> <?php echo $_grpx["Campus"]; ?> - <?php echo $_grpx["Grado"]; ?>° <?php echo $_grpx["CveGrupo"]; ?> (<?php echo $_grpx["_Dias"]; ?>) </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Lista de materias:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_mat_rec" id="txt_mat_rec">
            <option value=""> - Seleccione - </option>
            <?php while ($_mat = $db->recorrer($sql_mat)) { ?>
              <option value="<?php echo $_mat["IdModulo"] . '_' . $_mat["IdAsignacion"]; ?>"> <?php echo $_mat["CodeModulo"]; ?> <?php echo $_mat["NombreMod"]; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="procesar_materia_id(<?php echo $IdUsua; ?>,<?php echo $IdCiclo; ?>)" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>
  </form>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px"></th>
        <th>NOMBRE DE LA MATERIA</th>
        <th>GRUPO</th>
        <th>CAMPUS</th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql_recx)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td><?php echo $y["CodeModulo"]; ?> <?php echo $y["NombreMod"]; ?></td>
          <td><?php echo $y["Grado"]; ?>° <?php echo $y["CveGrupo"]; ?> (<?php echo $y["_Dias"]; ?>)</td>
          <td><?php echo $y["Campus"]; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  function procesar_materia_id(IdUsua, IdCiclo) {
    var IdGrupo = document.getElementById("txt_grupoy").value;
    var IdModulo = document.getElementById("txt_mat_rec").value;

    if (IdGrupo == "") {
      swal("Error al guardar", "Debe seleccionar el grupo.", "error");
      document.getElementById("txt_grupoy").focus();
      return 0;
    }
    if (IdModulo == "") {
      swal("Error al guardar", "Debe seleccionar la materia.", "error");
      document.getElementById("txt_mat_rec").focus();
      return 0;
    }

    var TipoGuardar = "add_materia_individual";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar esta materia a este alumno?",
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
              url: "vistas/escolar/guardar_datos_escolar.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdGrupo: IdGrupo,
                IdCiclo: IdCiclo,
                IdModulo: IdModulo,
                IdUsua: IdUsua
              },
              success: function(data) {
              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Asignado correctamente", "La materia se ha asignado correctamente al alumno.", "success");
                var IdGrupo = 0;
                $.ajax({
                  url: "vistas/escolar/asignar_materia.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    IdGrupo: IdGrupo
                  },
                  success: function(data) {
                    $('#employee_detail_asig').html(data);
                    $('#dataModal_asig').modal('show');
                  }
                });
              } else {
                swal("Error al asignar", "No se ha podido asignar la materia a este alumno.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        }
      });
  }

  function sel_grupo(IdUsua) {
    var IdGrupo = document.getElementById("txt_grupoy").value;
    $.ajax({
      url: "vistas/escolar/asignar_materia.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        IdGrupo: IdGrupo
      },
      success: function(data) {
        $('#employee_detail_asig').html(data);
        $('#dataModal_asig').modal('show');
      }
    });
  }
</script>