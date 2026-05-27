<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdAsignacion = $_POST["IdAsignacion"];
$IdUsua = $_POST["IdUsua"];
$IdAdmin = $_POST["IdAdmin"];
$Tipo = $_POST["Tipo"];

$sql2 = $db->query("SELECT
tblp_regresar_acta.IdRegresar,
tblp_regresar_acta.IdAdmin,
tblp_regresar_acta.FecCap,
tblp_regresar_acta.Motivo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_regresar_acta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_regresar_acta.IdAdmin
WHERE tblp_regresar_acta.IdAsignacion = '$IdAsignacion'
 ");

?>
<form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
<?php if($Tipo == 1){ ?>
  <div class="box-body">

    <div class="form-group">
      <label class="col-sm-3 control-label">Motivo:</label>
      <div class="col-sm-9">
        <textarea class="form-control" rows="3" name="txt_motivo_reg" id="txt_motivo_reg" placeholder="Escriba el motivo ..."></textarea>
      </div>
    </div>

  </div>
  <div class="box-footer">
    <button type="button" class="btn btn-block btn-info btn" onClick="reg_materia_edicion_id('<?php echo $IdAsignacion; ?>',<?php echo $IdUsua; ?>,<?php echo $IdAdmin; ?>)"> <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
  </div>
  <hr>
  <?php } ?>
  
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px">#</th>
        <th>Nombre</th>
        <th>Motivo</th>
        <th>FecCap</th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql2)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td><?php echo $y["Nombre"].' '.$y["APaterno"].' '.$y["AMaterno"]; ?></td>
          <td><?php echo $y["Motivo"]; ?></td>
          <td><?php echo $y["FecCap"]; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>



</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
  function cap_baja(IdUsua, IdTipo, IdAdmin) {
    var Estatus = document.getElementById("txtEstatus").value;
    var Comentario = document.getElementById("txtComentario").value;
    var Fecha = document.getElementById("txtFecha").value;
    var Ciclo = document.getElementById("txtCiclo").value;

    if (Estatus == "") {
      swal("Error al guardar", "Debe seleccionar el tipo de baja.", "error");
      document.getElementById("txtEstatus").focus();
      return 0;
    }
    if (Ciclo == "") {
      swal("Error al guardar", "Debe seleccionar el periodo en el que se da de baja.", "error");
      document.getElementById("txtCiclo").focus();
      return 0;
    }
    if (Ciclo == "") {
      swal("Error al guardar", "Debe indicar la fecha de baja.", "error");
      document.getElementById("txtCiclo").focus();
      return 0;
    }
    if (Comentario == "") {
      swal("Error al guardar", "Debe escribir un comentario.", "error");
      document.getElementById("txtComentario").focus();
      return 0;
    }

    var TipoGuardar = "sav_baja_doc";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
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
              Estatus: Estatus,
              Comentario: Comentario,
              Ciclo: Ciclo,
              IdUsua: IdUsua,
              IdTipo: IdTipo,
              Fecha: Fecha,
              IdAdmin: IdAdmin
            },
            success: function(data) {

              parent.location.href = 'asesor.php?token=1663683464' + IdUsua; //direcciona la pagina madre

            }
          })
        }
      });

  }

  function actAvCampsId(IdCampus, IdDocs, Valor) {
    var TipoGuardar = "savCampsIdAss";

    $.ajax({
      url: "formConsulta/setting.php",
      method: "POST",
      data: {
        TipoGuardar: TipoGuardar,
        IdCampus: IdCampus,
        IdDocs: IdDocs,
        Valor: Valor
      },
      success: function(data) {
        $.ajax({
          url: "formConsulta/calendarioCampus.php",
          method: "POST",
          data: {
            IdDocs: IdDocs
          },
          success: function(data) {
            $('#employee_Grp').html(data);
            $('#dataGrp').modal('show');
          }
        });
      }
    })
  }
</script>

<script>
  $(function() {

    $('#txtFecha').datepicker({
      autoclose: true
    })

  })
</script>