<?php session_start();
include('../../hace.php');
require('../../php/clases/class.System.php');
$anio = date("Y-m-d");
$db = new Conexion();
$IdUsua = $_SESSION['IdUsua'];
$IdActividadDoc = $_POST["IdActividadDoc"];
$IdRubrica = $_POST["IdRubrica"];

$act = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
$db->rows($act);
$x_act = $db->recorrer($act);
$_IdRubrica = $x_act['IdRubrica'];
if($_IdRubrica){
  $IdRubrica = $_IdRubrica;
}


$sql_rub = $db->query("SELECT tblc_rubrica.IdRubrica, tblc_rubrica.IdUsua, tblc_rubrica.Nombre, tblc_estatus.Estatus FROM tblc_rubrica Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_rubrica.IdEstatus WHERE tblc_rubrica.IdUsua = '$IdUsua' ORDER BY tblc_rubrica.IdEstatus DESC");
$sql_rub_det = $db->query("SELECT tblc_rubrica_detalle.IdDetalle, tblc_rubrica_detalle.IdRubrica, tblc_rubrica_detalle.Texto, tblc_rubrica_detalle.Cal1, tblc_rubrica_detalle.Cal2, tblc_rubrica_detalle.Cal3, tblc_rubrica_detalle.Cal4, tblc_rubrica_detalle.Cal5, tblc_rubrica.IdEstatus FROM tblc_rubrica_detalle Left Join tblc_rubrica ON tblc_rubrica.IdRubrica = tblc_rubrica_detalle.IdRubrica WHERE tblc_rubrica_detalle.IdRubrica = '$IdRubrica' ");
$rub = $db->query("SELECT * FROM tblc_rubrica WHERE tblc_rubrica.IdRubrica = '$IdRubrica'");
$db->rows($rub);
$x_rub = $db->recorrer($rub);
$IdEstatus = $x_rub['IdEstatus'];




?>
<form method="POST" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">

    <?php if(!$_IdRubrica){ ?>
    <div class="form-group" id="div_old">
      <div class="col-sm-12" style="text-align: right;">
        <div class="btn-group">
          <button onclick="nueva_rubrica()" type="button" class="btn btn-warning"><i class="fa fa-fw fa-folder-o"></i> Crear rúbrica</button>
        </div>
      </div>
    </div><?php } ?>

    <div style="display: none;" id="div_new">
      <div class="form-group">
        <label class="col-sm-4 control-label">Nombre de la rúbrica:</label>
        <div class="col-sm-8">
          <input type="text" name="txt_newrubrica" id="txt_newrubrica" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12" style="text-align: right;">
          <div class="btn-group">
            <button onclick="cancelar_alta_rubrica(<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-warning" style="margin-right: 5px;"><i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
            <button onclick="sav_nueva_rubrica(<?php echo $IdActividadDoc; ?>,<?php echo $IdUsua; ?>)" type="button" class="btn btn-success"><i class="fa fa-fw fa-save"></i> Guardar rúbrica</button>
          </div>
        </div>
      </div>
    </div>

    <div id="div_lista">
      <div class="form-group">
        <label class="col-sm-4 control-label">Seleccione rúbrica:</label>
        <div class="col-sm-8">
          <select <?php if($_IdRubrica){ echo "disabled"; } ?> class="form-control" name="txt_rubrica" id="txt_rubrica" onchange="sel_rubrica_id(<?php echo $IdActividadDoc; ?>)">
            <option value="">- Seleccione -</option>
            <?php while ($_rub = $db->recorrer($sql_rub)) { ?>
              <option value="<?php echo $_rub['IdRubrica']; ?>" <?php if ($_rub["IdRubrica"] == $IdRubrica) { ?>selected="selected" <?php } ?>> <?php echo $_rub['Estatus']; ?> - <?php echo $_rub['Nombre']; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php if ($IdRubrica) { ?>
        <?php if ($IdEstatus == 1) { ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Criterios de evaluación: </label>
            <div class="col-sm-8">
              <input type="text" name="txt_criterio_eva" class="form-control" id="txt_criterio_eva" placeholder="Nombre">
            </div>
            <div class="col-sm-1">
              <button onclick="save_criterio(<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i></button>
            </div>
          </div><?php } ?>
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr>
              <th style="width: 10px"></th>
              <th <?php if ($IdEstatus == 1) {
                    echo " style='width: 300px;' ";
                  } ?>>Criterios de evaluación</th>
              <th style="text-align: center;">Excelente</th>
              <th style="text-align: center;">Muy bien</th>
              <th style="text-align: center;">Satisfactorio</th>
              <th style="text-align: center;">Requiere mejora</th>
              <th style="text-align: center;">Inadecuado</th>
            </tr>
            <?php $v = 0;
            while ($_det = $db->recorrer($sql_rub_det)) { ?>
              <tr>
                <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
                <td>
                  <?php if ($IdEstatus == 1) { ?> <i onclick="del_criterio_eva(<?php echo $_det['IdDetalle']; ?>,<?php echo $IdActividadDoc; ?>)" style="color: blue; cursor: pointer;" class="fa fa-fw fa-trash-o"></i> <?php } ?>
                  <?php echo $_det['Texto']; ?></td>
                <td style="text-align: center;"><?php if ($IdEstatus == 8) { ?><?php echo $_det['Cal1']; } else { ?>
                  <div class="input-group input-group-sm">
                    <input name="txt_cal1_<?php echo $_det['IdDetalle']; ?>" id="txt_cal1_<?php echo $_det['IdDetalle']; ?>" type="text" class="form-control" value="<?php echo $_det['Cal1']; ?>">
                    <span class="input-group-btn">
                      <button onclick="upd_valx_cal(<?php echo $_det['IdDetalle']; ?>,<?php echo $IdActividadDoc; ?>,1)" type="button" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i></button>
                    </span>
                  </div>
                <?php } ?>
                </td>
                <td style="text-align: center;"><?php if ($IdEstatus == 8) { ?><?php echo $_det['Cal2']; } else { ?>
                  <div class="input-group input-group-sm">
                    <input name="txt_cal2_<?php echo $_det['IdDetalle']; ?>" id="txt_cal2_<?php echo $_det['IdDetalle']; ?>" type="text" class="form-control" value="<?php echo $_det['Cal2']; ?>">
                    <span class="input-group-btn">
                      <button onclick="upd_valx_cal(<?php echo $_det['IdDetalle']; ?>,<?php echo $IdActividadDoc; ?>,2)" type="button" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i></button>
                    </span>
                  </div>
                <?php } ?>
                </td>
                <td style="text-align: center;"><?php if ($IdEstatus == 8) { ?><?php echo $_det['Cal3']; } else { ?>
                  <div class="input-group input-group-sm">
                    <input name="txt_cal3_<?php echo $_det['IdDetalle']; ?>" id="txt_cal3_<?php echo $_det['IdDetalle']; ?>" type="text" class="form-control" value="<?php echo $_det['Cal3']; ?>">
                    <span class="input-group-btn">
                      <button onclick="upd_valx_cal(<?php echo $_det['IdDetalle']; ?>,<?php echo $IdActividadDoc; ?>,3)" type="button" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i></button>
                    </span>
                  </div>
                <?php } ?>
                </td>
                <td style="text-align: center;"><?php if ($IdEstatus == 8) { ?><?php echo $_det['Cal4']; } else { ?>
                  <div class="input-group input-group-sm">
                    <input name="txt_cal4_<?php echo $_det['IdDetalle']; ?>" id="txt_cal4_<?php echo $_det['IdDetalle']; ?>" type="text" class="form-control" value="<?php echo $_det['Cal4']; ?>">
                    <span class="input-group-btn">
                      <button onclick="upd_valx_cal(<?php echo $_det['IdDetalle']; ?>,<?php echo $IdActividadDoc; ?>,4)" type="button" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i></button>
                    </span>
                  </div>
                <?php } ?>
                </td>
                <td style="text-align: center;"><?php if ($IdEstatus == 8) { ?><?php echo $_det['Cal5']; } else { ?>
                  <div class="input-group input-group-sm">
                    <input name="txt_cal5_<?php echo $_det['IdDetalle']; ?>" id="txt_cal5_<?php echo $_det['IdDetalle']; ?>" type="text" class="form-control" value="<?php echo $_det['Cal5']; ?>">
                    <span class="input-group-btn">
                      <button onclick="upd_valx_cal(<?php echo $_det['IdDetalle']; ?>,<?php echo $IdActividadDoc; ?>,5)" type="button" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i></button>
                    </span>
                  </div>
                <?php } ?>
                </td>
              </tr><?php } ?>
          </tbody>
        </table>
        <div class="box-footer">
        <?php if($_IdRubrica){ ?>
          <div class="bg-navy-active color-palette" style="text-align: center; padding: 5px;"><span><i class="fa fa-fw fa-check-circle"></i> Rúbrica activa para esta actividad</span></div>
          <?php } else { ?>
          <?php if ($IdEstatus == 1) { ?>
            <button type="button" onclick="act_rubrica_id(<?php echo $IdActividadDoc; ?>)" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-save"></i> Activar esta rúbrica</button>
          <?php } ?>
          <?php if ($IdEstatus == 8) { ?>
            <button type="button" onclick="sel_rubrica_act(<?php echo $IdActividadDoc; ?>, <?php echo $IdRubrica; ?>)" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-check-circle"></i> Seleccionar rúbrica</button>
          <?php } ?>
          

          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</form>
<script>
  function add_new_grupo(Ciclo) {
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    var IdRvoe = document.getElementById("txt_rvoe").value;
    var Modalidad = document.getElementById("txt_modalidad").value;
    var Turno = document.getElementById("txt_turno").value;
    var Dia = document.getElementById("txt_dia").value;
    var Inicio = document.getElementById("txtFeIni").value;
    var Final = document.getElementById("txtFeFin").value;
    var Grupo = document.getElementById("txt_grp").value;

    var TipoGuardar = "sav_cve_grupo_new";
    if (IdCampus == '') {
      swal("Error al guardar", "Debe seleccionar el campus.", "error");
      document.getElementById("txt_campus").focus();
      return 0;
    }
    if (IdOferta == '') {
      swal("Error al guardar", "Debe seleccionar el plan de estudios.", "error");
      document.getElementById("txt_oferta").focus();
      return 0;
    }
    if (IdRvoe == '') {
      swal("Error al guardar", "Debe seleccionar el rvoe del plan de estudios.", "error");
      document.getElementById("txt_rvoe").focus();
      return 0;
    }
    if (Ciclo == '') {
      swal("Error al guardar", "Debe seleccionar el periodo escolar inicial.", "error");
      document.getElementById("txt_ciclo").focus();
      return 0;
    }
    if (Modalidad == '') {
      swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
      document.getElementById("txt_modalidad").focus();
      return 0;
    }
    if (Turno == '') {
      swal("Error al guardar", "Debe seleccionar el turno.", "error");
      document.getElementById("txt_turno").focus();
      return 0;
    }

    if (Dia == '') {
      swal("Error al guardar", "Debe seleccionar el tipo de dias de clases.", "error");
      document.getElementById("txt_dia").focus();
      return 0;
    }

    if (Grupo == '') {
      swal("Error al guardar", "Debe seleccionar el grupo.", "error");
      document.getElementById("txt_grupo").focus();
      return 0;
    }
    if (Inicio == '') {
      swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
      document.getElementById("txtFeIni").focus();
      return 0;
    }
    if (Final == '') {
      swal("Error al guardar", "Debe seleccionar la fecha de egreso.", "error");
      document.getElementById("txtFeFin").focus();
      return 0;
    }

    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva clave de grupo?",
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
              type: "POST",
              url: "vistas/escolar/guardar_datos_escolar.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdOferta: IdOferta,
                IdCampus: IdCampus,
                IdRvoe: IdRvoe,
                Modalidad: Modalidad,
                Turno: Turno,
                Ciclo: Ciclo,
                Dia: Dia,
                Inicio: Inicio,
                Final: Final,
                Grupo: Grupo
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "El grupo se ha guardado correctamente.", "success");
                $('#dataDocsx').modal('hide');
                cargar_grupo_reg();
              }
              if (data == 2) {
                swal("Error al guardar", "La clave de grupo ya fue dada de alta.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function sel_rubrica_id(IdActividadDoc) {
    var IdRubrica = document.getElementById("txt_rubrica").value;
    $.ajax({
      url: "vistas/docente/mis_rubricas.php",
      method: "POST",
      data: {
        IdActividadDoc: IdActividadDoc,
        IdRubrica: IdRubrica
      },
      success: function(data) {
        $('#employee_detail_rub').html(data);
        $('#dataModal_rub').modal('show');
      }
    });
  }

  function sel_oferta_grp(IdCiclo) {
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    $.ajax({
      url: "vistas/escolar/crea_grupo.php",
      method: "POST",
      data: {
        IdCampus: IdCampus,
        IdOferta: IdOferta,
        IdCiclo: IdCiclo
      },
      success: function(data) {
        $('#employee_docsx').html(data);
        $('#dataDocsx').modal('show');
      }
    });
  }

  function save_criterio(IdActividadDoc) {
    var IdRubrica = document.getElementById("txt_rubrica").value;
    var Criterio = document.getElementById("txt_criterio_eva").value;
    var TipoGuardar = "sav_crite_eva";

    if (IdRubrica == '') {
      swal("Error al guardar", "Debe seleccionar la rúbrica.", "error");
      document.getElementById("txt_rubrica").focus();
      return 0;
    }
    if (Criterio == '') {
      swal("Error al guardar", "Debe escribir el criterio de evaluación.", "error");
      document.getElementById("txt_criterio_eva").focus();
      return 0;
    }

    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo criterio de evaluación?",
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
              type: "POST",
              url: "vistas/docente/procesar_datos_docente.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdRubrica: IdRubrica,
                Criterio: Criterio
              },
              success: function(data) {}
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "El criterio de evaluación se ha guardado correctamente.", "success");
                $.ajax({
                  url: "vistas/docente/mis_rubricas.php",
                  method: "POST",
                  data: {
                    IdActividadDoc: IdActividadDoc,
                    IdRubrica: IdRubrica
                  },
                  success: function(data) {
                    $('#employee_detail_rub').html(data);
                    $('#dataModal_rub').modal('show');
                  }
                });

              }

            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function del_criterio_eva(IdDetalle, IdActividadDoc) {
    var IdRubrica = document.getElementById("txt_rubrica").value;
    var TipoGuardar = "del_crite_eva";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea eliminar este criterio de evaluación?",
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
              type: "POST",
              url: "vistas/docente/procesar_datos_docente.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdDetalle: IdDetalle
              },
              success: function(data) {}
            })
            .done(function(data) {
              if (data == 1) {
                swal("Eliminado correctamente", "El criterio de evaluación se ha guardado eliminado correctamente.", "success");
                $.ajax({
                  url: "vistas/docente/mis_rubricas.php",
                  method: "POST",
                  data: {
                    IdActividadDoc: IdActividadDoc,
                    IdRubrica: IdRubrica
                  },
                  success: function(data) {
                    $('#employee_detail_rub').html(data);
                    $('#dataModal_rub').modal('show');
                  }
                });

              }

            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function upd_valx_cal(IdDetalle, IdActividadDoc, Valor) {

    var IdRubrica = document.getElementById("txt_rubrica").value;
    var TipoGuardar = "upd_puntps_eva";
    var Input_val = "txt_cal" + Valor + "_" + IdDetalle;
    var Puntos = document.getElementById(Input_val).value;

    if (Puntos == '') {
      swal("Error al guardar", "Debe indicar los puntos.", "error");
      document.getElementById(Input_val).focus();
      return 0;
    }

    if (Puntos > 10) {
      swal("Error al guardar", "Los punto no deben ser mayor a 10.", "error");
      document.getElementById(Input_val).focus();
      return 0;
    }

    $.ajax({
      type: "POST",
      url: "vistas/docente/procesar_datos_docente.php",
      data: {
        TipoGuardar: TipoGuardar,
        IdDetalle: IdDetalle,
        Puntos: Puntos,
        Valor: Valor
      },
      success: function(data) {
        $.ajax({
          url: "vistas/docente/mis_rubricas.php",
          method: "POST",
          data: {
            IdActividadDoc: IdActividadDoc,
            IdRubrica: IdRubrica
          },
          success: function(data) {
            $('#employee_detail_rub').html(data);
            $('#dataModal_rub').modal('show');
          }
        });
      }
    });
  }

  function act_rubrica_id(IdActividadDoc) {
    var IdRubrica = document.getElementById("txt_rubrica").value;
    var TipoGuardar = "act_rubr_idx";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea activar esta rúbrica?",
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
              type: "POST",
              url: "vistas/docente/procesar_datos_docente.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdRubrica: IdRubrica
              },
              success: function(data) {}
            })
            .done(function(data) {
              if (data == 1) {
                swal("Activado correctamente", "La rúbrica se ha activado correctamente.", "success");
                $.ajax({
                  url: "vistas/docente/mis_rubricas.php",
                  method: "POST",
                  data: {
                    IdActividadDoc: IdActividadDoc,
                    IdRubrica: IdRubrica
                  },
                  success: function(data) {
                    $('#employee_detail_rub').html(data);
                    $('#dataModal_rub').modal('show');
                  }
                });

              }

            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function sel_rubrica_act(IdActividadDoc,IdRubrica) {
    var TipoGuardar = "act_rubrica_actividad";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea activar esta rúbrica para esta actividad?",
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
              type: "POST",
              url: "vistas/docente/procesar_datos_docente.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdActividadDoc: IdActividadDoc,
                IdRubrica: IdRubrica
              },
              success: function(data) {}
            })
            .done(function(data) {
              if (data == 1) {
                swal("Activado correctamente", "La rúbrica se ha activado correctamente en esta actividad.", "success");
                $.ajax({
                  url: "vistas/docente/mis_rubricas.php",
                  method: "POST",
                  data: {
                    IdActividadDoc: IdActividadDoc,
                    IdRubrica: IdRubrica
                  },
                  success: function(data) {
                    $('#employee_detail_rub').html(data);
                    $('#dataModal_rub').modal('show');
                  }
                });

              }

            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  function nueva_rubrica() {
    document.getElementById("div_new").style.display = "block";
    document.getElementById("div_old").style.display = "none";
    document.getElementById("div_lista").style.display = "none";

  }

  function cancelar_alta_rubrica(IdActividadDoc) {
    var IdRubrica = 0;
    $.ajax({
      url: "vistas/docente/mis_rubricas.php",
      method: "POST",
      data: {
        IdActividadDoc: IdActividadDoc,
        IdRubrica: IdRubrica
      },
      success: function(data) {
        $('#employee_detail_rub').html(data);
        $('#dataModal_rub').modal('show');
      }
    });
  }

  function sav_nueva_rubrica(IdActividadDoc, IdUsua){
    var Rubrica = document.getElementById("txt_newrubrica").value;
    if (Rubrica == '') {
      swal("Error al guardar", "Debe escribir el nombre de la rúbrica.", "error");
      document.getElementById("txt_newrubrica").focus();
      return 0;
    }


    var TipoGuardar = "add_new_rubrica";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea crear el nombre de esta rúbrica?",
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
              type: "POST",
              url: "vistas/docente/procesar_datos_docente.php",
              data: {
                TipoGuardar: TipoGuardar,
                Rubrica: Rubrica,
                IdUsua:IdUsua
              },
              success: function(data) {}
            })
            .done(function(data) {
              if (data == 1) {
                var IdRubrica = 0;
                swal("Creado correctamente", "El nombre de la rúbrica se ha creado correctamente.", "success");
                $.ajax({
                  url: "vistas/docente/mis_rubricas.php",
                  method: "POST",
                  data: {
                    IdActividadDoc: IdActividadDoc,
                    IdRubrica: IdRubrica
                  },
                  success: function(data) {
                    $('#employee_detail_rub').html(data);
                    $('#dataModal_rub').modal('show');
                  }
                });

              }

            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }
</script>