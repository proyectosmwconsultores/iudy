<?php
session_start();
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();
$hoy = date("Y-m-d");
$IdUsua = $_POST["IdUsua"];
$idPeriodo = $_POST["idPeriodo"];
$idCiclo = $_POST["idCiclo"];
$idGrupo = $_POST["idGrupo"];
$idModulo = $_POST["idModulo"];
$idTipo = $_POST["idTipo"];
$condx = " ";
if($idTipo == "T"){ $condx = " "; }
if($idTipo == "R"){ $condx = " AND ((tblp_grupo.Dia = 'L') || (tblp_grupo.Dia = 'S') || (tblp_grupo.Dia = 'D') || (tblp_grupo.Dia = 'O') || (tblp_grupo.Dia = 'A')) "; }
if($idTipo == "I"){ $condx = " AND tblp_grupo.Ingles = 'SI' "; }
if($idTipo == "P"){ $condx = " AND tblp_grupo.Dia = 'P' "; }
if($idTipo == "A"){ $condx = " AND tblp_grupo.Dia = 'B' "; }


$sql8 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario._idOferta, tblc_usuario._idCampus, tblc_usuario._idRvoe, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblp_educativa.Clave, tblp_grupo.TipoCiclo
FROM tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$_tipoCiclo = $datos81['TipoCiclo'];
$_IdCampus_act = $datos81['IdCampus'];
$_IdOferta_act = $datos81['IdOferta'];
$IdCampus = $datos81['_idCampus'];
$_idRvoe = $datos81['_idRvoe'];
$IdOferta = $datos81['_idOferta'];
$IdGrupo = $datos81['IdGrupo'];

if($_idRvoe == 48){
  $IdCampus = 1;  
}

if($_idRvoe == 43){
  $IdCampus = 1;  
}

$sql_modulo = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' ");

if ($_tipoCiclo == 'C') {
  $_tipC = 'CUATRIMESTRE';
} elseif ($_tipoCiclo == 'S') {
  $_tipC = 'SEMESTRE';
} elseif ($_tipoCiclo == 'T') {
  $_tipC = 'TRIMESTRE';
}

$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$_tipC' AND tblc_ciclo.Limite >= '$hoy' ");

$sql_mat = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdEstatus FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$idGrupo' AND tblp_asignacion.Tipo =  '2' AND ((tblp_asignacion.IdEstatus = 12) || (tblp_asignacion.IdEstatus = 8)) ");
$sql_recx = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblc_dias_clases._Dias,
tblc_campus.Campus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
ModRvoe.CodeModulo AS RCode,
ModRvoe.NombreMod AS RMateria
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo AND tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_modulo AS ModRvoe ON ModRvoe.IdModulo = tblp_moduloalumno._idModulo
WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdCiclo = '$idCiclo' AND tblp_moduloalumno.Activo = '1' AND tblp_asignacion.Tipo = '2'");

// $sql_cic_pers = $db->query("SELECT tblp_personalizado.IdHorario, tblp_personalizado.IdCiclo, tblc_ciclo.Ciclo FROM tblp_personalizado Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_personalizado.IdCiclo WHERE tblp_personalizado.IdUsua =  '$IdUsua' ORDER BY tblc_ciclo.FInicio DESC LIMIT 1 "); 
$sql_cic_pers = $db->query("SELECT tblc_alumnos.IdCiclo,  tblc_ciclo.Ciclo FROM tblc_alumnos LEFT JOIN tblc_ciclo ON tblc_alumnos.IdCiclo = tblc_ciclo.IdCiclo WHERE tblc_alumnos.IdUsua = '$IdUsua' ORDER BY tblc_ciclo.FInicio DESC LIMIT 1"); 

$sql_grp_dispo = $db->query("SELECT tblc_ciclogrupo.IdCiclo, tblc_ciclogrupo.IdGrupo, tblc_ciclogrupo.Grado, tblp_grupo.CveGrupo, tblc_dias_clases._Dias, tblc_campus.Campus, tblp_educativa.Abreviatura
FROM tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE tblc_ciclogrupo.IdCiclo =  '$idCiclo' $condx
ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.Idoferta ASC, tblc_ciclogrupo.Grado ASC ");

$sql_rvoe = $db->query("SELECT tblc_rvoe_campus.Id_rvoe, tblc_rvoe_campus.IdEducativa, tblc_rvoe_campus.IdRvoe, tblc_rvoe.Educativa, tblc_rvoe.Rvoe, tblc_rvoe.IdCampus, tblc_campus.Campus FROM tblc_rvoe_campus Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_rvoe_campus.IdRvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus WHERE tblc_rvoe_campus.IdEducativa =  '$_IdOferta_act' GROUP BY tblc_rvoe.Rvoe ORDER BY tblc_rvoe_campus.IdRvoe ASC");


?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-book"></i> Configurar rvoe del plan de estudios a utilizar:</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-2 control-label">Rvoe:</label>
        <div class="col-sm-10">
        <select class="form-control" name="txt_rvoe" id="txt_rvoe" <?php if($_idRvoe){ echo "disabled"; }  ?>>
          <option value="">- Seleccione -</option>
          <?php while ($_rvoe = $db->recorrer($sql_rvoe)) { ?>
            <option value="<?php echo $_rvoe['IdRvoe']; ?>" <?php if ($_rvoe['IdRvoe'] == $_idRvoe) { ?>selected="selected" <?php } ?>> <?php echo $_rvoe['Rvoe'].' '.$_rvoe['Educativa']. ' - ' . $_rvoe['Campus']; ?> </option>
          <?php } ?>
        </select>
        </div>
      </div>
    </div>
    <?php if(!$_idRvoe){ ?>
    <div class="box-footer">
      <button onclick="procesar_rvoe(<?php echo $IdUsua; ?>,'<?php echo $idTipo; ?>')" type="button" class="btn btn-warning pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
    </div><?php } ?>
  </form>
</div>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-folder-open"></i> Inicializar en este periodo escolar</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-3 control-label">Periodo escolar</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_periodo" id="txt_periodo" onchange="sel_periodo_escolar(<?php echo $IdUsua; ?>)">
            <option value=""> - Seleccione - </option>
            <?php while ($_cic = $db->recorrer($sql_ciclo)) { ?>
              <option value="<?php echo $_cic["IdCiclo"]; ?>" <?php if ($_cic["IdCiclo"] == $idPeriodo) { ?>selected="selected" <?php } ?>> <?php echo $_cic["Ciclo"]; ?> -  (Fecha límite de inscripción: <?php echo obtenerFechaCorta($_cic["Limite"]); ?>) </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="iniciar_horario_personalizado_espe(<?php echo $IdUsua; ?>,'<?php  echo $idTipo;?>')" type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Iniciar configuración</button>
    </div>

  </form>
</div>



<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-cog"></i> Configurar materias del alumno en este periodo escolar</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-3 control-label">Tipo de grupo:</label>
        <div class="col-sm-9">
          <div class="btn-group">
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,'T')" type="button" class="btn btn-<?php if($idTipo == 'T'){ echo "primary"; } else { echo "default"; } ?>">Todos</button>
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,'R')" type="button" class="btn btn-<?php if($idTipo == 'R'){ echo "primary"; } else { echo "default"; } ?>">Regulares</button>
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,'P')" type="button" class="btn btn-<?php if($idTipo == 'P'){ echo "primary"; } else { echo "default"; } ?>">Personalizados</button>
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,'I')" type="button" class="btn btn-<?php if($idTipo == 'I'){ echo "primary"; } else { echo "default"; } ?>">Inglés</button>
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,'A')" type="button" class="btn btn-<?php if($idTipo == 'A'){ echo "primary"; } else { echo "default"; } ?>">Asesorias</button>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Materia actual:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_modulo" id="txt_modulo">
            <option value=""> - Seleccione - </option>
            <?php while ($_modx = $db->recorrer($sql_modulo)) { ?>
              <option value="<?php echo $_modx["IdModulo"]; ?>" <?php if ($_modx["IdModulo"] == $idModulo) { ?>selected="selected" <?php } ?>> <?php echo $_modx["CodeModulo"]; ?> - <?php echo $_modx["NombreMod"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-3 control-label">Periodo escolar:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_ciclo" id="txt_ciclo" onchange="sel_ciclo_escolar(<?php echo $IdUsua; ?>,'<?php echo $idTipo; ?>')">
            <option value=""> - Seleccione - </option>
            <?php while ($_perx = $db->recorrer($sql_cic_pers)) { ?>
              <option value="<?php echo $_perx["IdCiclo"]; ?>" <?php if ($_perx["IdCiclo"] == $idCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_perx["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Grupo:</label>
        <div class="col-sm-10">
          <select class="form-control" name="txt_grupo" id="txt_grupo" onchange="sel_grupo(<?php echo $IdUsua; ?>,'<?php echo $idTipo; ?>')">
            <option value=""> - Seleccione - </option>
            <?php while ($_grpx = $db->recorrer($sql_grp_dispo)) { ?>
              <option value="<?php echo $_grpx["IdGrupo"]; ?>" <?php if ($_grpx["IdGrupo"] == $idGrupo) { ?>selected="selected" <?php } ?>> <?php echo $_grpx["Campus"]; ?> - <?php echo $_grpx["Grado"]; ?>° <?php echo $_grpx["CveGrupo"]; ?> (<?php echo $_grpx["_Dias"]; ?>)  - <?php echo $_grpx["Abreviatura"]; ?></option>
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
      <button onclick="procesar_personalizado(<?php echo $IdUsua; ?>,'<?php echo $idTipo; ?>',<?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>

  </form>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px"></th>
        <th>NOMBRE DE RVOE</th>
        <th>MATERIA ASIGNADA</th>
        <th>GRUPO</th>
        <th>CAMPUS</th>
        <th>DOCENTE</th>
        <th></th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql_recx)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td>
            <?php echo $y["RCode"]; ?> <?php echo $y["RMateria"]; ?>
          </td>
          <td>
            <?php echo $y["CodeModulo"]; ?> <?php echo $y["NombreMod"]; ?>
          </td>
          <td><?php echo $y["Grado"]; ?>° <?php echo $y["CveGrupo"]; ?> (<?php echo $y["_Dias"]; ?>)</td>
          <td><?php echo $y["Campus"]; ?></td>
          <td><?php echo $y["Nombre"].' '.$y["APaterno"].' '.$y["AMaterno"]; ?></td>
          <td>
          <button onclick="del_materia_asig_espec(<?php echo $IdUsua; ?>,<?php echo $y["IdModuloAlumno"]; ?>,<?php echo $idCiclo; ?>,'<?php echo $idTipo; ?>')" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fw fa-trash"></i></button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  function procesar_personalizado(IdUsua,idTipo,IdAdmin) {
    var id_modulo = document.getElementById("txt_modulo").value;
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idGrupo = document.getElementById("txt_grupo").value;
    var IdModulo = document.getElementById("txt_mat_rec").value;

    if (id_modulo == "") {
      swal("Error al guardar", "Debe seleccionar la materia actual.", "error");
      document.getElementById("txt_modulo").focus();
      return 0;
    }
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

    var TipoGuardar = "add_materia_personalizda_especial";
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
              IdUsua: IdUsua,
              id_modulo:id_modulo,
              IdAdmin:IdAdmin
            },
            success: function(data) {
              
            }
          })
          .done(function(data) {
          if (data == 0) {
            swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
          }
          if (data == 3) {
            swal("Error al guardar", "Este alumno ya tiene 7 materias asignadas al mismo periodo escolar, favor de verificar con rectoria.", "error");
          }
          if (data == 4) {
            swal("Error al guardar", "La materia que seleccionó ya lo tiene activa el alumno.", "error");
          }
          if(data == 1){
            var idPeriodo = 0;
              swal("Asignado correctamente", "La materia se ha asignado correctamente al alumno.", "success");
              $.ajax({
                url: "vistas/escolar/horario_personalizado_especial.php",
                method: "POST",
                data: {
                  idModulo:id_modulo,
                  IdUsua: IdUsua,
                  idPeriodo: idPeriodo,
                  idCiclo: idCiclo,
                  idGrupo: idGrupo,
                  idTipo:idTipo
                },
                success: function(data) {
                  $('#employee_detail_per').html(data);
                  $('#dataModal_per').modal('show');
                }
              });
          }

        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
        }
      });
  }

  function procesar_rvoe(IdUsua,idTipo) {
    var IdRvoe = document.getElementById("txt_rvoe").value;
    
    if (IdRvoe == "") {
      swal("Error al guardar", "Debe seleccionar el rvoe a utilizar.", "error");
      document.getElementById("txt_rvoe").focus();
      return 0;
    }

    var TipoGuardar = "add_sav_rvoe_alumno_id";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar este RVOE para este alumno, recuerde que una vez guardado no se podra cambiar?",
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
              IdRvoe: IdRvoe,
              IdUsua: IdUsua
            },
            success: function(data) {
              
            }
          })
          .done(function(data) {
          if (data == 0) {
            swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
          }
          if(data == 1){
            var idPeriodo = 0;
              swal("Asignado correctamente", "El rvoe del plan de estudios se ha asignado correctamente.", "success");
              var idGrupo = 0;
                var idModulo = 0;
                var idPeriodo = 0;
                var idCiclo = 0;
                $.ajax({
                  url: "vistas/escolar/horario_personalizado_especial.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    idPeriodo: idPeriodo,
                    idCiclo: idCiclo,
                    idGrupo: idGrupo,
                    idModulo:idModulo,
                    idTipo:idTipo
                  },
                  success: function(data) {
                    $('#employee_detail_per').html(data);
                    $('#dataModal_per').modal('show');
                  }
                });
          }

        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
        }
      });
  }


  
  function sel_ciclo_escolar(IdUsua,idTipo) {
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idModulo = document.getElementById("txt_modulo").value;
    var idPeriodo = 0;
    var idGrupo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado_especial.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo,
        idModulo:idModulo,
        idTipo:idTipo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }
  
   function sel_periodo_escolar(IdUsua) {
    var idPeriodo = document.getElementById("txt_periodo").value;
    var idModulo = 0;
    var idTipo = 'T';
    var idCiclo = 0;
    var idGrupo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado_especial.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo,
        idModulo:idModulo,
        idTipo:idTipo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }

  function sel_grupo(IdUsua,idTipo) {
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idGrupo = document.getElementById("txt_grupo").value;
    var idModulo = document.getElementById("txt_modulo").value;
    var idPeriodo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado_especial.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo,
        idModulo:idModulo,
        idTipo:idTipo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }

  function sel_tipo_grupo_id(IdUsua,idTipo) { 
    var idCiclo = document.getElementById("txt_ciclo").value;
    var idGrupo = 0;
    var idModulo = 0;
    var idPeriodo = 0;
    $.ajax({
      url: "vistas/escolar/horario_personalizado_especial.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        idPeriodo: idPeriodo,
        idCiclo: idCiclo,
        idGrupo: idGrupo,
        idModulo:idModulo,
        idTipo:idTipo
      },
      success: function(data) {
        $('#employee_detail_per').html(data);
        $('#dataModal_per').modal('show');
      }
    });
  }


  function del_materia_asig_espec(IdUsua,IdModulo,idCiclo,idTipo){
    var TipoGuardar = "del_asignacion_materia_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar esta materia del alumno?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdModulo:IdModulo},
             success:function(data){

             }
        })
        .done(function(data) {
          if (data == 0) {
            swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
          }
          if(data == 1){
            swal("Eliminado correctamente", "La materia ha sido eliminado correctamente  del perfil del alumno.", "success");
            var idGrupo = 0;
            var idModulo = 0;
            var idPeriodo = 0;
            $.ajax({
              url: "vistas/escolar/horario_personalizado_especial.php",
              method: "POST",
              data: {
                IdUsua: IdUsua,
                idPeriodo: idPeriodo,
                idCiclo: idCiclo,
                idGrupo: idGrupo,
                idModulo:idModulo,
                idTipo:idTipo
              },
              success: function(data) {
                $('#employee_detail_per').html(data);
                $('#dataModal_per').modal('show');
              }
            });
          }

        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}

function iniciar_horario_personalizado_espe(IdUsua,idTipo) {
    var idPeriodo = document.getElementById("txt_periodo").value;

    if (idPeriodo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      document.getElementById("txt_periodo").focus();
      return 0;
    }

    var TipoGuardar = "ini_horario_personalizado";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea inicializar la inscripción académica de este alumno con este periodo escolar?",
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
                swal("Inicializado correctamente", "Usted ya puede comenzar a generar la inscripción académica.", "success");
                var idGrupo = 0;
                var idModulo = 0;
                var idCiclo = 0;
                var idPeriodo = 0;
                $.ajax({
                  url: "vistas/escolar/horario_personalizado_especial.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua,
                    idPeriodo: idPeriodo,
                    idCiclo: idCiclo,
                    idGrupo: idGrupo,
                    idModulo:idModulo,
                    idTipo:idTipo
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