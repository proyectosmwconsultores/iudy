<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = substr($_POST["Token"], 10, 10);


  $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Grado = $datos81["Grado"];
  $IdOferta = $datos81["IdOferta"];


$sql = $db->query("SELECT
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_conceptosdetalle.IdConceptoPlan,
tblc_conceptosdetalle.IdOferta,
tblc_conceptosdetalle.IdConcepto,
tblc_conceptosplanes.NomPlan,
tblc_conceptosplanes.Costo
FROM
tblc_conceptosdetalle
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan
WHERE
tblc_conceptosplanes.IdGrado =  '$Grado' AND
tblc_conceptosdetalle.IdOferta =  '$IdOferta'");


  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["Token"]; ?>" type="hidden"/>
    <input id="IdUsuaCap" name="IdUsuaCap" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savBeca" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Concepto:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txtConcepto" id="txtConcepto">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql)){ ?>
                <option value="<?php echo $x["IdConceptoPlan"]; ?>"> $ <?php echo $x["Costo"]; ?> - <?php echo $x["NomPlan"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label>Beca (en porcentaje %):</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-star-o"></i>
              </div>
                <input class="form-control" type="text" name="txtBeca" id="txtBeca" onchange="val_beca(this,txtBeca)">
            </div>
          </div>
        </div>

        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="saveBeca()"> <i class="fa fa-fw fa-save"></i> Guardar</button>

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
function mostrarPlan(Opcion){
  if(Opcion == 1){
    document.getElementById("divPlan").style.display = 'block';
    document.getElementById("mostrar").style.display = 'none';
    document.getElementById("ocultar").style.display = 'block';
    document.getElementById("Proyecto").value = '1';
  } else {
    document.getElementById("divPlan").style.display = 'none';
    document.getElementById("mostrar").style.display = 'block';
      document.getElementById("ocultar").style.display = 'none';
      document.getElementById("Proyecto").value = '0';
  }

}

})
</script>
