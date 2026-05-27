<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
include('../hace.php');
$IdAsignacion = $_POST["IdAsignacion"];
$Fecha = $_POST["Fecha"];
 $Pasar = $_POST["Pasar"];

// $lst_actvo = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
// while ($_avtv = $db->recorrer($lst_actvo)) {
//   $sqlV = $db->query("SELECT tblp_asistencia.IdAsistencia FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion = '$IdAsignacion' AND tblp_asistencia.Fecha = '$Fecha' AND tblp_asistencia.IdUsua = '" . $_avtv['IdUsua'] . "' ");
//   $db->rows($sqlV);
//   $datos91 = $db->recorrer($sqlV);
//   $idAs = $datos91['IdAsistencia'];
//   if (!$idAs) {
//     $_a = substr($Fecha, 0, 4);
//     $_m = substr($Fecha, 5, 2);
//     $anioM = $_a . '-' . $_m;
//     $insertar = $db->query("INSERT INTO tblp_asistencia(IdUsua, IdAsignacion, Fecha, IdTipo, AnioMes) VALUES ('" . $_avtv['IdUsua'] . "','$IdAsignacion','$Fecha','1','$anioM')");
//   }
// }

$sql_dia = $db->query("SELECT tblp_asistencia.IdAsistencia FROM tblp_asistencia WHERE tblp_asistencia.Fecha =  '$Fecha'  AND tblp_asistencia.IdAsignacion =  '$IdAsignacion' ");
$db->rows($sql_dia);
$_dia = $db->recorrer($sql_dia);

if(isset($_dia["IdAsistencia"])){
  if($Pasar == 0){
    $sql_totallista = $db->query("SELECT Count(tblp_moduloalumno.IdUsua) AS Total FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ");
    $db->rows($sql_totallista);
    $_totallista = $db->recorrer($sql_totallista);

    $sql_aissx = $db->query("SELECT Count(tblp_asistencia.IdUsua) AS Total FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND tblp_asistencia.Fecha =  '$Fecha'");
    $db->rows($sql_aissx);
    $_asix = $db->recorrer($sql_aissx);

    if($_totallista['Total'] <> $_asix['Total']){
      $sql1 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdModulo, tblp_asignacion.FecIni, tblp_asignacion.FecFin FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $id_modulo = $datos2['IdModulo'];

      $sql_us = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdModulo = '$id_modulo'");
      while ($u = $db->recorrer($sql_us)) {
        
        $sql_asis = $db->query("SELECT tblp_asistencia.IdAsistencia FROM tblp_asistencia WHERE tblp_asistencia.IdUsua = '".$u['IdUsua']."' AND tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND tblp_asistencia.Fecha =  '$Fecha'");
        $db->rows($sql_asis);
        $datos2 = $db->recorrer($sql_asis);
        if(!isset($datos2['IdAsistencia'])){
          $IdUsua = $u["IdUsua"];
          $anioM = substr($Fecha, 0, 7);
          $insertar = $db->query("INSERT INTO tblp_asistencia(IdUsua, IdAsignacion, Fecha, IdTipo, AnioMes, Valor) VALUES ('".$u['IdUsua']."','$IdAsignacion','$Fecha','1','$anioM',1)");
        }          
      }
    }
}
}


$sql_us = $db->query("SELECT tblp_asistencia.IdAsistencia, tblp_asistencia.IdTipo, tblp_asistencia.FecCap, tblp_asistencia.Observaciones, tblp_asistencia.Comentario, tblp_asistencia.Valor, tblp_asistencia.Archivo, tblc_usuario.Nombre, tblc_usuario.IdEstatus, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblc_tipo_asistencia.Icono FROM tblp_asistencia Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asistencia.IdUsua Left Join tblc_tipo_asistencia ON tblc_tipo_asistencia.IdTipo = tblp_asistencia.IdTipo WHERE tblp_asistencia.IdAsignacion = '$IdAsignacion' AND tblp_asistencia.Fecha = '$Fecha' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");
$sql_fechas = $db->query("SELECT tblp_asistencia.IdAsistencia, tblp_asistencia.Fecha FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_asistencia.Fecha ORDER BY tblp_asistencia.Fecha ASC");

?>
<form class="form-horizontal">
  <div class="box-header with-border">
    <h3 class="box-title" style="font-size: 18px;"><i class="fa fa-fw fa-calendar-check-o"></i> <?php echo obtenerFechaEnLetra($_POST["Fecha"]);  ?></h3>
    <p class="margin" style="text-align: right;">
      <code><i class="fa fa-fw fa-check-circle"></i> Asistencia</code>
      <code><i class="fa fa-fw fa-warning"></i> Permiso</code>
      <code><i class="fa fa-fw fa-times-circle"></i> Falta</code>
    </p>
  </div>
  <div class="form-group">
<label class="col-sm-6 control-label">Seleciona día de pase de lista:</label>
<div class="col-sm-6">
<select class="form-control" name="fecha_lista" id="fecha_lista" onchange="cambiar_dia_asistencia('<?php echo $IdAsignacion; ?>')">
  <option value=""> - Seleccione día -</option>
  <?php $v = 0; while($_fecha = $db->recorrer($sql_fechas)){ ?>
    <option value="<?php echo $_fecha['Fecha']; ?>" <?php if($_fecha['Fecha'] == $Fecha){ ?>selected="selected"<?php } ?> > <?php echo obtenerFechaEnLetra($_fecha['Fecha']); ?></option>
  <?php } ?>
</select>
</div>
</div>

  <input type="hidden" name="IdAsignacion" id="IdAsignacion" value="<?php echo $IdAsignacion; ?>">
  <input type="hidden" name="Fecha" id="Fecha" value="<?php echo $Fecha; ?>">
  <p style="text-align: center; display: none;" id="p_imagen">
    <img src="assets/images/cargando.gif">
  </p>
  
  <div id="div_mostrar_lista">
  <?php if(isset($_dia["IdAsistencia"])){ ?>
  <table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th></th>
        <th>NOMBRE DEL ALUMNO </th>
        <th style="text-align: center; width: 20px;">A</th>
        <th style="text-align: center; width: 20px;">P</th>
        <th style="text-align: center; width: 20px;">F</th>
        <th>OBSERVACIONES</th>
        <th>PERMISO</th>
      </tr>
    </thead>
    <tbody>
      <?php $nb = 0;
      while ($x = $db->recorrer($sql_us)) { ?>
        <tr <?php if ($x['IdEstatus'] == 8) {
              echo "style='color: black;'";
            } else {
              echo "style='color: red;'";
            } ?>>
          <td>
            <b><?php echo $nb = ($nb + 1); ?>.- </b>
          </td>
          <td><?php echo $x['APaterno'] . ' ' . $x['AMaterno'] . ' ' . $x['Nombre']; ?></td>
          <td> <?php if ($x['IdEstatus'] == 8) { ?>
              <?php if ($x['IdTipo'] == 2) { ?>
                <button onclick="pasarList(<?php echo $x['IdAsistencia']; ?>,1)" type="button" class="btn btn-success btn-sm"><i class="fa fa-fw fa-check-circle"></i></button>
              <?php } else { ?>
                <button onclick="pasarList(<?php echo $x['IdAsistencia']; ?>,2)" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-check-circle"></i></button>
              <?php } ?>
            <?php } ?>
          </td>
          <td><?php if ($x['IdEstatus'] == 8) { ?>
              <?php if ($x['IdTipo'] == 3) { ?>
                <button onclick="pasarList(<?php echo $x['IdAsistencia']; ?>,1)" type="button" class="btn btn-success btn-sm"><i class="fa fa-fw fa-warning"></i></button>
              <?php } else { ?>
                <button onclick="pasarList(<?php echo $x['IdAsistencia']; ?>,3)" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-warning"></i></button>
              <?php } ?>
            <?php } ?>
          </td>
          <td>
            <?php if ($x['IdTipo'] == 4) { ?>
              <button onclick="pasarList(<?php echo $x['IdAsistencia']; ?>,1)" type="button" class="btn btn-success btn-sm"><i class="fa fa-fw fa-times-circle"></i></button>
            <?php } else { ?>
              <button onclick="pasarList(<?php echo $x['IdAsistencia']; ?>,4)" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-times-circle"></i></button>
            <?php } ?>
          </td>
          <td>
            <div class="input-group input-group-sm">
              <input type="text" class="form-control" name="txt_nota<?php echo $x['IdAsistencia']; ?>" id="txt_nota<?php echo $x['IdAsistencia']; ?>" value="<?php echo $x['Observaciones']; ?>">
              <span class="input-group-btn">
                <button onclick="sav_nota(<?php echo $x['IdAsistencia']; ?>)" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i></button>
              </span>
            </div>
          </td>
          <td style="text-align: center;"><?php if ($x['Comentario']) { ?>
              <?php if ($x['IdEstatus'] == 8) { ?>
                <button onclick="mostr_perx(<?php echo $x['IdAsistencia']; ?>)" href="javascript:void(0);" type="button" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-twitch"></i></button>
              <?php } ?>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="alert alert-success alert-dismissible" style="display: none;" id="dvi_prx">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Solicitud de permiso</h4>
    <p id="_pxs"></p>
  </div>


<?php } else { ?>
  <div class="bg-red-active color-palette" style="padding: 10px; font-size: 16px; text-align: center;"><span><i class="fa fa-fw fa-bell-slash-o"></i> El dia de hoy no tiene pase de lista disponible, pero puede seleccionar otro día.</span></div>
<?php } ?>
</div>
</form>
<script>
  function mostr_perx(IdAsistencia) {
    document.getElementById("dvi_prx").style.display = "block";
    var TipoGuardar = "vre_permiso";
    $.ajax({
      url: "formConsulta/setting.php",
      method: "POST",
      data: {
        TipoGuardar: TipoGuardar,
        IdAsistencia: IdAsistencia
      },
      success: function(data) {

        document.getElementById('_pxs').innerHTML = data;
      }
    })


  }

  function sav_nota(IdAsistencia) {
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var Fecha = document.getElementById("Fecha").value;
    var NotaNum = "txt_nota" + IdAsistencia;

    var Nota = document.getElementById(NotaNum).value;

    if (Nota == "") {
      swal("Error al guardar", "Debe escribir la observacion que desea guardar.", "error");
      return 0;
    }
    var TipoGuardar = "exa_nota_ls";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar esta observación para el alumno?",
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
                IdAsistencia: IdAsistencia,
                Nota: Nota
              },
              success: function(data) {


              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "Los datos se  han guardado correctamente.", "success");
                // cargar_lista_asistencia(IdAsignacion);
                var Pasar = 1;
                $.ajax({
                  url: "formConsulta/pasarLista.php",
                  method: "POST",
                  data: {
                    IdAsignacion: IdAsignacion,
                    Fecha: Fecha, Pasar:Pasar
                  },
                  success: function(data) {
                    $('#employee_fondo').html(data);
                    $('#dataFondo').modal('show');
                  }
                });
              } else {
                swal("Error", "No se ha podido guardar.", "error");
              }
            })
          // .error(function(data) {
          // 	swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
          // });

        }

      });
  }

  function pasarList(IdAsistencia, IdTipo) {
    var Tipo = "pasarList";
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var Fecha = document.getElementById("Fecha").value;
    var Pasar = 1;

    var datos = 'IdAsistencia=' + IdAsistencia + '&TipoGuardar=' + Tipo + '&IdTipo=' + IdTipo;
    $.ajax({
      type: "POST",
      url: "insertar.php",
      data: datos,
      success: function(data) {
        // cargar_lista_asistencia(IdAsignacion);
        $.ajax({
          url: "formConsulta/pasarLista.php",
          method: "POST",
          data: {
            IdAsignacion: IdAsignacion,
            Fecha: Fecha, Pasar:Pasar
          },
          success: function(data) {
            $('#employee_fondo').html(data);
            $('#dataFondo').modal('show');
          }
        });
      }
    })
  }
</script>