<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
$IdModulo = $_POST["IdModulo"];
  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdModulo = '$IdModulo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdAs =  $datos91["IdAsignacion"];
  $IdE =  $datos91["IdEstatus"];
  $IdUsua =  $datos91["IdUsua"];


  $sql8 = $db->query("SELECT *  FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAs'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);



  $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND ((tblc_usuario.Permisos = '1') || (tblc_usuario.Permisos = '5') || (tblc_usuario.Permisos = '9'))  ORDER BY tblc_usuario.Nombre ASC");

if($IdE == 8){
  $exsT = "Activo";
} elseif($IdE == 12){
  $exsT = "En proceso";
}elseif($IdE == 26){
  $exsT = "Finalizado";
}
  ?>
  <form name="frm5Vb" id="frm5Vb" action="configCurso.php" method="POST" enctype="multipart/form-data">

    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAs; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savCursodat" type="hidden"/>
    <input id="IdUsuaXX" name="IdUsuaXX" value="<?php echo $IdUsua; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">


        <div class="col-md-12">
          <div class="bg-green disabled color-palette" style="padding: 10px;"><span><b>Curso:</b> <?php echo $exsT; ?></span></div><br>
          <div class="form-group">
            <label>Asesor acad&eacute;mico:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control" name="txtUsua" id="txtUsua">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql)){ ?>
                <option value="<?php echo $x["IdUsua"]; ?> " <?php if($datos81["IdUsua"]==$x["IdUsua"]){ ?>selected="selected"<?php } ?> > <?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha inicial:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker11" name="datepicker11" value="<?php echo $datos81["FecIni"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha final:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker22" name="datepicker22" value="<?php echo $datos81["FecFin"]; ?>">
            </div>
          </div>
        </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onClick="savDatCurso()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>
$(function () {
  //Date picker
  $('#datepicker11').datepicker({
    autoclose: true
  })
//Date picker
  $('#datepicker22').datepicker({
    autoclose: true
  })

  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5()
})
</script>
