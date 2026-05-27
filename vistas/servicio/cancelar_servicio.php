<?php session_start();
  $IdUsua = $_POST['IdUsua'];
  $IdServicio = $_POST['IdServicio'];
  require('../../php/clases/class_practicas.php');
  require('../../hace.php');
  $practicas = new Class_practicas();
  

  $pract_pro = $practicas->get_mi_servicio_id($IdServicio);
  $aviso_id = $practicas->get_aviso_servicio_id($pract_pro[0]['IdAviso']);

?>
  <form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  
    <div class="box-body">
    
      <div class="form-group">
        <label class="col-sm-4 control-label">Periodo actual en el que se encuentra inscrito:</label>
        <div class="col-sm-8">
        <span class="username"><a href="#"><?php echo $aviso_id[0]['Titulo']; ?></a></span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Motivo de la cancelación:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="txt_motivo" id="txt_motivo">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Fecha de cancelación:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="txt_cancelacion" id="txt_cancelacion">
        </div>
      </div>

      <div class="box-footer">
          <button type="button" onclick="procesar_cancelacion_ss_id(<?php echo $_SESSION['IdUsua']; ?>,<?php echo $IdServicio; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Procesar cancelación de Servicio Social</button>
      </div>
    </div>
  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script>
    $(function() {
      //Date picker
      $('#txt_cancelacion').datepicker({
        autoclose: true
      })

    })
  </script>
