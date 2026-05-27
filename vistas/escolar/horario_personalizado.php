<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdUsua = $_POST["IdUsua"];
$idPeriodo = $_POST["idPeriodo"];
$idCiclo = $_POST["idCiclo"];
$idGrupo = $_POST["idGrupo"];


$sql8 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblp_educativa.Clave, tblp_grupo.TipoCiclo
FROM tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$IdOferta = $datos81['IdOferta'];
$_tipoCiclo = $datos81['TipoCiclo'];
$IdCampus = $datos81['IdCampus'];


if ($_tipoCiclo == 'C') {
  $_tipC = 'CUATRIMESTRE';
} elseif ($_tipoCiclo == 'S') {
  $_tipC = 'SEMESTRE';
} elseif ($_tipoCiclo == 'T') {
  $_tipC = 'TRIMESTRE';
}

$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$_tipC' AND tblc_ciclo._activo = '1' ");

$sql_mat = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdEstatus FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$idGrupo' AND tblp_asignacion.Tipo =  '2' AND ((tblp_asignacion.IdEstatus = 12) || (tblp_asignacion.IdEstatus = 8)) ");
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
WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdCiclo = '$idCiclo' AND tblp_moduloalumno.Activo = '1' AND tblp_asignacion.Tipo = '2'");

$sql_cic_pers = $db->query("SELECT tblp_personalizado.IdHorario, tblp_personalizado.IdCiclo, tblc_ciclo.Ciclo FROM tblp_personalizado Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_personalizado.IdCiclo WHERE tblp_personalizado.IdUsua =  '$IdUsua' ORDER BY tblc_ciclo.FInicio ASC ");

$sql_grp_dispo = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclogrupo.IdGrupo, tblc_ciclogrupo.Grado, tblp_grupo.CveGrupo, tblc_dias_clases._Dias, tblc_campus.Campus
FROM tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
WHERE tblc_ciclogrupo.IdCiclo =  '$idCiclo' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCampus = '$IdCampus'
ORDER BY tblc_ciclogrupo.Grado ASC
 ");

?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-folder-open"></i> Inicializar horario personalizado de este periodo escolar</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-3 control-label">Periodo escolar</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_periodo" id="txt_periodo" onchange="sel_periodo_escolar(<?php echo $IdUsua; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while ($_cic = $db->recorrer($sql_ciclo)) { ?>
              <option value="<?php echo $_cic["IdCiclo"]; ?>" <?php if ($_cic["IdCiclo"] == $idPeriodo) { ?>selected="selected" <?php } ?>> <?php echo $_cic["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="iniciar_horario(<?php echo $IdUsua; ?>)" type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Iniciar configuración</button>
    </div>

  </form>
</div>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-cog"></i> Configurar el horario personalizado de este periodo escolar</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-3 control-label">Periodo escolar</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_ciclo" id="txt_ciclo" onchange="sel_ciclo_escolar(<?php echo $IdUsua; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while ($_perx = $db->recorrer($sql_cic_pers)) { ?>
              <option value="<?php echo $_perx["IdCiclo"]; ?>" <?php if ($_perx["IdCiclo"] == $idCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_perx["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Grupo</label>
        <div class="col-sm-10">
          <select class="form-control" name="txt_grupo" id="txt_grupo" onchange="sel_grupo(<?php echo $IdUsua; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while ($_grpx = $db->recorrer($sql_grp_dispo)) { ?>
              <option value="<?php echo $_grpx["IdGrupo"]; ?>" <?php if ($_grpx["IdGrupo"] == $idGrupo) { ?>selected="selected" <?php } ?>> <?php echo $_grpx["Campus"]; ?> - <?php echo $_grpx["Grado"]; ?>° <?php echo $_grpx["CveGrupo"]; ?> (<?php echo $_grpx["_Dias"]; ?>) </option>
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
      <button onclick="procesar_personalizado(<?php echo $IdUsua; ?>)" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
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
  function procesar_personalizado(IdUsua) {
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idGrupo = document.getElementById("txt_grupo").value;
    var IdModulo = document.getElementById("txt_mat_rec").value;

    if (idCiclo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      document.getElementById("txt_ciclo").focus();
      return 0;
    }
    if (idGrupo == "") {
      swal("Error al guardar", "Debe seleccionar el grupo.", "error");
      document.getElementById("txt_grupo").focus();
      return 0;
    }
    if (IdModulo == "") {
      swal("Error al guardar", "Debe seleccionar la materia.", "error");
      document.getElementById("txt_mat_rec").focus();
      return 0;
    }

    var TipoGuardar = "add_materia_personalizada";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar esta materia personalizada al alumno?",
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
              idGrupo: idGrupo,
              idCiclo: idCiclo,
              IdModulo: IdModulo,
              IdUsua: IdUsua
            },
            success: function(data) {
              var idPeriodo = 0;
              swal("Asignado correctamente", "La materia se ha asignado correctamente al alumno.", "success");
              $.ajax({
                url: "vistas/escolar/horario_personalizado.php",
                method: "POST",
                data: {
                  IdUsua: IdUsua,
                  idPeriodo: idPeriodo,
                  idCiclo: idCiclo,
                  idGrupo: idGrupo
                },
                success: function(data) {
                  $('#employee_detail_per').html(data);
                  $('#dataModal_per').modal('show');
                }
              });

            }
          })
        }
      });
  }


  function sel_periodo_escolar(IdUsua) {
    var idPeriodo = document.getElementById("txt_periodo").value;
    var idCiclo = 0;
    var idGrupo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }

  function sel_ciclo_escolar(IdUsua) {
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idPeriodo = 0;
    var idGrupo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }

  function sel_grupo(IdUsua) {
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idGrupo = document.getElementById("txt_grupo").value;
    var idPeriodo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }

  function iniciar_horario(IdUsua) {
    var idPeriodo = document.getElementById("txt_periodo").value;

    if (idPeriodo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      document.getElementById("txt_periodo").focus();
      return 0;
    }

    var TipoGuardar = "ini_horario_personalizado";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea inicializar el horario personalizado de este alumno con este periodo escolar?",
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
                idPeriodo: idPeriodo,
                IdUsua: IdUsua
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 0) {
                swal("Error al inicializar", "Este proceso no se pudo realizar favor de revisar.", "error");
              }
              if (data == 1) {
                swal("Inicializado correctamente", "Usted ya puede comenzar a generar el horario personalizado.", "success");
                var idPeriodo = 0;
                var idCiclo = 0;
                var idGrupo = 0;
                $.ajax({
                  url: "vistas/escolar/horario_personalizado.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    idPeriodo: idPeriodo,
                    idCiclo: idCiclo,
                    idGrupo: idGrupo
                  },
                  success: function(data) {
                    $('#employee_detail_per').html(data);
                    $('#dataModal_per').modal('show');
                  }
                });
              }
              if (data == 3) {
                swal("Error al inicializar", "Favor de verificar el pago de reinscripción.", "error");
              }
              if (data == 2) {
                swal("Error al inicializar", "Favor de verificar el pago de las mensualidades.", "error");
              }
              if (data == 4) {
                swal("Error al inicializar", "El periodo escolar seleccionado ya se encuentra inicializado.", "error");
              }
            })
            .error(function(data) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });
        }
      });
  }
</script>