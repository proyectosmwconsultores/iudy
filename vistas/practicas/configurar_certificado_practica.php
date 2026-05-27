<?php
if (isset($_POST["IdPractica"])) {
  require('../../php/clases/class_practicas.php');
require('../../hace.php');
$practicas = new Class_practicas();
$IdPractica = $_POST['IdPractica'];
$IdUsua = $_POST['IdUsua'];

$pract_pro = $practicas->get_mi_practica_id_prac($IdPractica);
?>
  <form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-8 control-label">Fecha de emisión de la constancia:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="txtFec_prac" id="txtFec_prac" value="<?php echo $pract_pro[0]["_cer_fecha_liberacion"]; ?>">
        </div>
      </div>


      <div class="box-footer">
        <?php if (!$pract_pro[0]["_cer_fecha_liberacion"]) { ?>
          <button type="button" onclick="generar_constancia_prac(<?php echo $IdUsua; ?>,<?php echo $IdPractica; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Generar constancia</button>
        <?php } ?>
      </div>
    </div>
  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script>
    $(function() {
      //Date picker
      $('#txtFec_prac').datepicker({
        autoclose: true
      })

    })

  </script>
<?php
}
?>