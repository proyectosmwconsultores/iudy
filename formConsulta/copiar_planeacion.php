<?php
include('../hace.php');

$output = '';
require('../php/clases/class.System.php');
$db = new Conexion();
$materia = $_POST["materia"];
$_IdAsignacion = $_POST["employee_id"];

$pieces = explode("_", $_IdAsignacion);
$IdAsignacion =  $pieces[0];
$IdModulo =  $pieces[1];
$IdCiclo =  $pieces[2];


$sql_par = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Tema,
tblp_modulo.CodeModulo,
Sum(tblp_actividadesdocente.Porcentaje) AS Porcentaje
FROM
tblp_asignacion
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdParcialDocente = tblp_parcialdocente.IdParcialDocente AND tblp_actividadesdocente.IdAsignacion = tblp_parcialdocente.IdAsignacion
WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'
GROUP BY
tblp_parcialdocente.IdParcialDocente");
$db->rows($sql_par);
$_par = $db->recorrer($sql_par);

$codeMod = $_par['CodeModulo'];


$sql_miplan = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdModulo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_ciclo.Ciclo,
tblp_grupo.CveGrupo,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Tema,
tblp_semanadocente.Etiqueta_semana,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.Porcentaje,
tblp_semanadocente.NoSemana,
tblp_parcialdocente.Titulo
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblp_semanadocente ON tblp_semanadocente.IdParcialDocente = tblp_parcialdocente.IdParcialDocente
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdParcialDocente = tblp_semanadocente.IdParcialDocente AND tblp_actividadesdocente.IdSemanaDocente = tblp_semanadocente.IdSemanaDocente
WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'
ORDER BY
tblp_semanadocente.NoSemana ASC");



$sql_plan = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdModulo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_ciclo.Ciclo,
tblp_grupo.CveGrupo,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Titulo,
Sum(tblp_actividadesdocente.Porcentaje) AS Porcentaje
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdParcialDocente = tblp_parcialdocente.IdParcialDocente AND tblp_actividadesdocente.IdAsignacion = tblp_parcialdocente.IdAsignacion
WHERE
tblp_asignacion.IdModulo =  '$IdModulo' AND
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion.IdAsignacion <>  '$IdAsignacion'
GROUP BY
tblp_actividadesdocente.IdParcialDocente");

?>
<form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdAsignacion" id="IdAsignacion" value="<?php echo $IdAsignacion; ?>">

  <?php if ($_par['Porcentaje'] > 1) { ?>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <?php $ax_i = 'x';
        $ax_f = 'x';
        $xc = 0;
        while ($_xplan = $db->recorrer($sql_miplan)) { $ax_i = $_xplan['IdAsignacion'];
          if ($ax_i <> $ax_f) {  ?>
            <tr style="background: #003A70; color: white; text-align: center;">
              <td colspan="4"><b><i class="fa fa-edit"></i> En la planeación académica del docente se tiene capturado lo siguiente:</b></td>
            </tr>
            <tr style="background: #003A70; color: white;">
              <td colspan="2"><b><?php echo $_xplan['APaterno'] . ' ' . $_xplan['AMaterno'] . ' ' . $_xplan['Nombre']; ?></b></td>
              <td><?php echo $_xplan['Ciclo']; ?></td>
              <td><?php echo $_xplan['CveGrupo']; ?> </td>
            </tr>
            
          <?php } ?>
          <tr>
            <td><?php echo $_xplan['Titulo']; ?></td>
            <td><?php echo $_xplan['Etiqueta_semana']; ?></td>
            <td><?php echo $_xplan['NomActividad']; ?> </td>
              <td><?php echo $_xplan['Porcentaje']; ?>% </td>
          </tr>
        <?php $ax_f = $_xplan['IdAsignacion'];
        } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <div class="bg-red-active color-palette" style="padding: 10px; text-align: center;"><span><i class="fa fa-info-circle"></i> Planeaciones académicas</span></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <?php $a_i = 'x';
        $a_f = 'x';
        $xc = 0;
        while ($_plan = $db->recorrer($sql_plan)) {
          $a_i = $_plan['IdAsignacion'];
          if ($a_i <> $a_f) { ?>
            <tr>
              <td colspan='3' style='background: #a1a7ff;'>oko</td>
            </tr>
            <tr>
              <td><b><?php echo $_plan['Nombre'] . ' ' . $_plan['APaterno'] . ' ' . $_plan['AMaterno']; ?></b></td>
              <td><?php echo $_plan['Ciclo']; ?></td>
              <td>
                <?php echo $_plan['CveGrupo']; ?> 
                <button style="float: right;" type="button" class="btn btn-warning btn-xs v_copiar" href="javascript:void(0);" name="v" value="v" id="<?php echo $_plan["IdAsignacion"] . '_' . $IdAsignacion; ?>"><i class="fa fa-copy"></i> Copiar</button>
                <button style="float: right;" type="button" class="btn btn-info btn-xs" href="javascript:void(0);" onclick="cargar_materia_datos('<?php echo $_POST["employee_id"]; ?>','<?php echo $_plan["IdAsignacion"]; ?>')" ><i class="fa fa-eye"></i> Ver</button>
              </td>
            </tr>
          <?php } ?>

          <tr>
            <td><?php echo $_plan['Titulo']; ?></td>
            <td colspan="2"><b>Porcentaje capturado:</b> <?php echo $_plan['Porcentaje']; ?>%</td>
          </tr>
        <?php $a_f = $_plan['IdAsignacion'];
        } ?>
      </tbody>
    </table>
  <?php } ?>

  <?php if($materia <> 0){ 
    
    $sql_capturado = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdModulo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_ciclo.Ciclo,
tblp_grupo.CveGrupo,
tblp_parcialdocente.NoParcial,
tblp_parcialdocente.Tema,
tblp_semanadocente.Etiqueta_semana,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.Porcentaje,
tblp_semanadocente.NoSemana,
tblp_parcialdocente.Titulo
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblp_semanadocente ON tblp_semanadocente.IdParcialDocente = tblp_parcialdocente.IdParcialDocente
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdParcialDocente = tblp_semanadocente.IdParcialDocente AND tblp_actividadesdocente.IdSemanaDocente = tblp_semanadocente.IdSemanaDocente
WHERE tblp_asignacion.IdAsignacion = '$materia' AND tblp_asignacion.Tipo = '2'
ORDER BY
tblp_semanadocente.NoSemana ASC");


    
    
    ?>

<table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <?php $ax_i = 'x';
        $ax_f = 'x';
        $xc = 0;
        while ($_xplan = $db->recorrer($sql_capturado)) { $ax_i = $_xplan['IdAsignacion'];
          if ($ax_i <> $ax_f) {  ?>
            <tr style="background: #003A70; color: white; text-align: center;">
              <td colspan="4"><b><i class="fa fa-edit"></i> En la planeación académica, el docente tiene capturado lo siguiente:</b></td>
            </tr>
            <tr style="background: #1d3462; color: white;">
              <td colspan="2"><b><?php echo $_xplan['APaterno'] . ' ' . $_xplan['AMaterno'] . ' ' . $_xplan['Nombre']; ?></b></td>
              <td><?php echo $_xplan['Ciclo']; ?></td>
              <td><?php echo $_xplan['CveGrupo']; ?> </td>
            </tr>
            
          <?php } ?>
          <tr>
            <td><?php echo $_xplan['Titulo']; ?></td>
            <td><?php echo $_xplan['Etiqueta_semana']; ?></td>
            <td><?php echo $_xplan['NomActividad']; ?> </td>
              <td><?php echo $_xplan['Porcentaje']; ?>% </td>
          </tr>
        <?php $ax_f = $_xplan['IdAsignacion'];
        } ?>
      </tbody>
    </table>

  <?php } ?>

</form>







<script>
  function save_registro() {
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var Fec1 = document.getElementById("datepicker1").value;
    var Fec2 = document.getElementById("datepicker2").value;

    if (Fec1 == "") {
      swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
      document.getElementById("datepicker1").focus();
      return 0;
    }
    if (Fec2 == "") {
      swal("Error al guardar", "Debe seleccionar el final final.", "error");
      document.getElementById("datepicker2").focus();
      return 0;
    }

    var TipoGuardar = "sav_encuesta";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea publicar esta encuesta?",
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
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdAsignacion: IdAsignacion,
                Fec1: Fec1,
                Fec2: Fec2
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Publicado correctamente", "La encuesta a los docentes se ha publicado correctamente.", "success");
                $('#dataModalCP').modal('hide');
              }
            })
            .error(function(data) {
              swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
            });

        }
      });
  }

  $(document).ready(function() {
    $(document).on('click', '.v_copiar', function() {
      var IdAsignacion = $(this).attr("id");

      var TipoGuardar = "copy_planeacion";
      swal({
          title: "\u00BFEst\u00E1 seguro que desea copiar esta planeación académica?",
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
                url: "formConsulta/setting.php",
                method: "POST",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdAsignacion: IdAsignacion
                },
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Copiado correctamente", "La planeación académica se ha copiado correctamente a esta nueva materia.", "success");
                  $('#dataModalCP').modal('hide');
                }
              })
              .error(function(data) {
                swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });

          }
        });
    });
  });
</script>