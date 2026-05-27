<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdUsua = $_POST["IdUsua"];
$idCiclo = $_POST["idCiclo"];
$idGrupo = $_POST["idGrupo"];
$idGrado = $_POST["idGrado"];
$anio = date("Y");

  $sql_pagos = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua'  ");
  $db->rows($sql_pagos);
  $_pagos = $db->recorrer($sql_pagos);

  
  
$condx = " ";
if($idGrado == 7){ $condx = " AND tblp_educativa.IdGrado =  '7' "; }
if($idGrado == 8){ $condx = " AND tblp_educativa.IdGrado =  '8' "; }
if($idGrado == 9){ $condx = " AND tblp_educativa.IdGrado =  '9' "; }

$sql_mat = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_asignacion.IdEstatus FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdGrupo =  '$idGrupo' AND tblp_asignacion.Tipo =  '2' AND ((tblp_asignacion.IdEstatus = 12) || (tblp_asignacion.IdEstatus = 8)) ");
$sql_recx = $db->query("SELECT
tblp_moduloalumno.IdModuloAlumno,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblc_dias_clases._Dias,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_moduloalumno
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_moduloalumno.IdGrupo
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo AND tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdCiclo = '$idCiclo' AND tblp_moduloalumno.Activo = '1' AND tblp_asignacion.Tipo = '2'");

$hoy = date("Y-m-d");
$hoy = date("Y-m-d",strtotime($hoy."- 9 month"));
$sql_cic_pers = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.FInicio >= '$hoy' AND tblc_ciclo.Tipo = 'CUATRIMESTRE' ORDER BY tblc_ciclo.FInicio ASC "); 


$sql_grp_dispo = $db->query("SELECT
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias,
tblp_educativa.Abreviatura
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE
tblc_ciclogrupo.IdCiclo =  '$idCiclo' $condx
ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.Idoferta ASC, tblc_ciclogrupo.Grado ASC
 ");


$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = 'CUATRIMESTRE' AND tblc_ciclo._activo = '1' ORDER BY tblc_ciclo.FInicio DESC ");

if(!isset($_pagos["IdPago"])){
?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-dollar"></i> Inicializar pagos del alumno</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Periodo escolar generar pagos: </label>
        <div class="col-sm-8">
          <select class="form-control" name="txt_periodo_pagos" id="txt_periodo_pagos">
            <option value=""> - Seleccione - </option>
            <?php while ($_cic = $db->recorrer($sql_ciclo)) { ?>
              <option value="<?php echo $_cic["IdCiclo"]; ?>" <?php if ($_cic["IdCiclo"] == $idPeriodo) { ?>selected="selected" <?php } ?>> <?php echo $_cic["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="iniciar_pagos_diplomado(<?php echo $IdUsua; ?>)" type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Iniciar configuracion de pagos </button>
    </div>

  </form>
</div>

<?php } 
if(isset($_pagos["IdPago"])){
?>
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
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,7,<?php echo $idGrupo; ?>,<?php echo $idCiclo; ?>)" type="button" class="btn btn-<?php if($idGrado == 7){ echo "primary"; } else { echo "default"; } ?>">Diplomados</button>
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,8,<?php echo $idGrupo; ?>,<?php echo $idCiclo; ?>)" type="button" class="btn btn-<?php if($idGrado == 8){ echo "primary"; } else { echo "default"; } ?>">Cursos</button>
            <button onclick="sel_tipo_grupo_id(<?php echo $IdUsua; ?>,9,<?php echo $idGrupo; ?>,<?php echo $idCiclo; ?>)" type="button" class="btn btn-<?php if($idGrado == 9){ echo "primary"; } else { echo "default"; } ?>">Certificación</button>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-3 control-label">Periodo escolar:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_ciclo13" id="txt_ciclo13" onchange="sel_ciclo_escolar(<?php echo $IdUsua; ?>,'<?php echo $idGrado; ?>')">
            <option value=""> - Seleccione - </option>
            <?php while ($_perx = $db->recorrer($sql_cic_pers)) { ?>
              <option value="<?php echo $_perx["IdCiclo"]; ?>" <?php if ($_perx["IdCiclo"] == $idCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_perx["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Grupo:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_grupo" id="txt_grupo" onchange="sel_grupo(<?php echo $IdUsua; ?>,'<?php echo $idGrado; ?>')">
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
      <div class="form-group">
        <label class="col-sm-3 control-label">Tipo usuario:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_usuario_ext" id="txt_usuario_ext">
            <option value=""> - Seleccione - </option>
              <option value="B"> ALUMNO ACTIVO</option>
              <option value="A"> EGRESADOS IUDY</option>
              <option value="E"> ALUMNOS EXTERNOS</option>
          </select>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="procesar_personaliz_is(<?php echo $IdUsua; ?>,'<?php echo $idGrado; ?>')" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
    </div>

  </form>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px"></th>
        <th>MATERIA ASIGNADA</th>
        <th>GRUPO</th>
        <th>DOCENTE</th>
        <th></th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql_recx)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td>
            <?php echo $y["CodeModulo"]; ?> <?php echo $y["NombreMod"]; ?>
          </td>
          <td><?php echo $y["Grado"]; ?>° <?php echo $y["CveGrupo"]; ?> (<?php echo $y["_Dias"]; ?>)</td>
          <td><?php echo $y["Nombre"].' '.$y["APaterno"].' '.$y["AMaterno"]; ?></td>
          <td>
          <button onclick="del_materia_asig_espec(<?php echo $IdUsua; ?>,<?php echo $y["IdModuloAlumno"]; ?>,<?php echo $idCiclo; ?>)" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fw fa-trash"></i></button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>
<script>
  function procesar_personaliz_is(IdUsua,idGrado) {
    var idCiclo = document.getElementById("txt_ciclo13").value;
    var idGrupo = document.getElementById("txt_grupo").value;
    var IdModulo = document.getElementById("txt_mat_rec").value;
    var Tipo = document.getElementById("txt_usuario_ext").value;
    
    if (idCiclo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      document.getElementById("txt_ciclo13").focus();
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

    var TipoGuardar = "add_materia_especial";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar esta materia al alumno?",
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
            url: "vistas/vinculacion/guardar_datos_vinculacion.php",
            method: "POST",
            data: {
              TipoGuardar: TipoGuardar,
              idGrupo: idGrupo,
              idCiclo: idCiclo,
              IdModulo: IdModulo,
              IdUsua: IdUsua,
              idGrado:idGrado,
              Tipo:Tipo
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
              swal("Asignado correctamente", "La materia se ha asignado correctamente al alumno.", "success");
              var idCiclo = 0;
              var idGrupo = 0;
              var idGrado = 7;
              $.ajax({
                url: "vistas/vinculacion/asignar_materia.php",
                method: "POST",
                data: {
                  IdUsua: IdUsua,
                  idCiclo: idCiclo,
                  idGrupo:idGrupo,
                  idGrado:idGrado
                },
                success: function(data) {
                  $('#employee_detail_dip').html(data);
                  $('#dataModal_dip').modal('show');
                }
              });
          }
          if (data == 3) {
                swal("Error al inicializar", "Favor de verificar el pago de inscripcion.", "error");
              }
              if (data == 2) {
                swal("Error al inicializar", "Favor de verificar el pago de las mensualidades.", "error");
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


  
  function sel_ciclo_escolar(IdUsua,idGrado) {
    var idCiclo = document.getElementById("txt_ciclo13").value;
    var idGrupo = 0;
    $.ajax({
			url: "vistas/vinculacion/asignar_materia.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				idCiclo: idCiclo,
				idGrupo:idGrupo,
				idGrado:idGrado
			},
			success: function(data) {
				$('#employee_detail_dip').html(data);
				$('#dataModal_dip').modal('show');
			}
		});
  }

  function sel_grupo(IdUsua,idGrado) {
    var idCiclo = document.getElementById("txt_ciclo13").value;
    var idGrupo = document.getElementById("txt_grupo").value;
		$.ajax({
			url: "vistas/vinculacion/asignar_materia.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				idCiclo: idCiclo,
				idGrupo:idGrupo,
				idGrado:idGrado
			},
			success: function(data) {
				$('#employee_detail_dip').html(data);
				$('#dataModal_dip').modal('show');
			}
		});
  }

  function sel_tipo_grupo_id(IdUsua,idGrado,idGrupo,idCiclo) { 
    $.ajax({
			url: "vistas/vinculacion/asignar_materia.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				idCiclo: idCiclo,
				idGrupo:idGrupo,
				idGrado:idGrado
			},
			success: function(data) {
				$('#employee_detail_dip').html(data);
				$('#dataModal_dip').modal('show');
			}
		});
  }


  function del_materia_asig_espec(IdUsua,IdModulo,idCiclo){
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
            var idGrado = 7;
            $.ajax({
              url: "vistas/vinculacion/asignar_materia.php",
              method: "POST",
              data: {
                IdUsua: IdUsua,
                idCiclo: idCiclo,
                idGrupo:idGrupo,
                idGrado:idGrado
              },
              success: function(data) {
                $('#employee_detail_dip').html(data);
                $('#dataModal_dip').modal('show');
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

function iniciar_horario(IdUsua,idTipo) {
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
  
  function iniciar_pagos_diplomado(IdUsua) {
    var idPeriodo = document.getElementById("txt_periodo_pagos").value;

    if (idPeriodo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
      document.getElementById("txt_periodo_pagos").focus();
      return 0;
    }

    var TipoGuardar = "generar_pagos_diplomado";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea cargar los pagos de este alumno?",
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
              url: "vistas/vinculacion/guardar_datos_vinculacion.php",
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
                swal("Inicializado correctamente", "Usted ya puede comenzar a generar el sus materias al alumno.", "success");
                var idGrupo = 0;
                var idModulo = 0;
                var idCiclo = 0;
                var idPeriodo = 0;
                var idCiclo = 0;
        		var idGrupo = 0;
        		var idGrado = 7;
        		$.ajax({
        			url: "vistas/vinculacion/asignar_materia.php",
        			method: "POST",
        			data: {
        				IdUsua: IdUsua,
        				idCiclo: idCiclo,
        				idGrupo: idGrupo,
        				idGrado: idGrado
        			},
        			success: function(data) {
        				$('#employee_detail_dip').html(data);
        				$('#dataModal_dip').modal('show');
        			}
        		});
              }
              if (data == 55) {
                swal("Error al inicializar", "El alumno ya se le cargo sus pagos de diplomado.", "error");
              }
              if (data == 3) {
                swal("Error al inicializar", "Favor de verificar el pago de inscripcion.", "error");
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