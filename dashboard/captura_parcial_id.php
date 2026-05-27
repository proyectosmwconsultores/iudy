<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $NoParcial = $_POST['NoParcial'];
  $Parcial = $_POST['Parcial'];
   $IdAsignacion = $_POST['IdAsignacion'];

  $sql_asig = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.Tipo = '2' AND tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql_asig);
  $_asig = $db->recorrer($sql_asig);

  $sql_user = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno, tblp_moduloalumno.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_moduloalumno.Parcial$Parcial, tblp_moduloalumno.ParcialF$Parcial, tblp_moduloalumno.Promedio, tblp_moduloalumno.Promedio_final FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.APaterno ASC ");

  $valor = $_asig["Fec_emi_bim$Parcial"];
  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">

  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>NOMBRE DEL ALUMNO</th>
        <th colspan="2">CALIFICACIÓN PARCIAL <?php echo $Parcial; ?></th>
      </tr>
      <?php $d = 0; while($_user = $db->recorrer($sql_user)){ ?>
      <tr>
        <td style="width: 15px;"><b><?php echo $d = ($d + 1); ?>.- </b></td>
        <td><?php echo $_user["APaterno"].' '.$_user["AMaterno"].' '.$_user["Nombre"]; ?></td>
        <td style="width: 100px;">

          <input type="text" <?php if($valor){ echo "disabled"; }?> value="<?php echo $_user["ParcialF$Parcial"]; ?>" id="txt_cal_<?php echo $_user["IdModuloAlumno"]; ?>" name="txt_cal_<?php echo $_user["IdModuloAlumno"]; ?>" class="form-control">

        </td>
        <td>
          <?php if(!$valor){ ?>
          <button onclick="up_cal_parcial(<?php echo $_user["IdModuloAlumno"]; ?>,<?php echo $Parcial; ?>, <?php echo $NoParcial; ?>, '<?php echo $IdAsignacion; ?>',<?php echo $_user["IdUsua"]; ?>)" type="button" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></button>
          <?php } ?>
        </td>
      </tr>
      <?php } ?>
  </tbody></table>
  <?php if($valor){ ?>
    <button type="button" onclick="modificar_calificacion_id('<?php echo $IdAsignacion; ?>',<?php echo $Parcial; ?>, <?php echo $NoParcial; ?>)" class="btn btn-block btn-danger btn-sm"><i class="fa fa-cog"></i> Aperturar para modificar calificación</button>
  <?php } else { ?>
    <div class="box-body">
      <div class="form-group">
      <label class="col-sm-4 control-label">Fecha de emisión:</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="fecha_emi_par" name="fecha_emi_par">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="emitir_acta_parcial('<?php echo $IdAsignacion; ?>',<?php echo $Parcial; ?>, <?php echo $NoParcial; ?>)" type="button" class="btn btn-success pull-right"><i class="fa fa-save"></i> Emitir acta</button>
    </div>
  <?php } ?>
  </form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
$(function () {
  //Date picker
  $('#fecha_emi_par').datepicker({
    autoclose: true
  })

})
</script>
