<?php
if (isset($_POST["IdUsua"])) {
  require('../../php/clases/class_practicas.php');
  require('../../hace.php');
  $practicas = new Class_practicas();
  $IdUsua = $_POST['IdUsua'];
  $Tipo = $_POST['Tipo'];

  if ($Tipo == 0) {
  } else {
    $pract_pro = $practicas->get_cargar_lista_docs($IdUsua, $Tipo);
  } 

  $lst_docs = $practicas->get_lista_docs($IdUsua, $Tipo);
  $lst_serv = $practicas->get_servicio_id($lst_docs[0]['IdServicio']);
  
?>
  <form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-8 control-label">Tipo de liberación:</label>
        <div class="col-sm-4">
          <div class="btn-group">
            <?php if((isset($lst_serv[0]["_validado"])) && ($lst_serv[0]["_validado"] == 2)){ ?>
              <button type="button" class="btn btn-info"><?php if ($lst_docs[0]["Tipo"] == 1) { echo "NORMAL"; } else { echo "AUTOMÁTICO"; } ?></button>
            <?php } else { ?>
              <button type="button" onclick="sel_tipo(<?php echo $IdUsua; ?>,1)" class="btn btn-<?php if ($lst_docs[0]["Tipo"] == 1) { echo "info"; } else { echo "default"; } ?>">Normal</button>
              <button type="button" onclick="sel_tipo(<?php echo $IdUsua; ?>,2)" class="btn btn-<?php if ($lst_docs[0]["Tipo"] == 2) { echo "info"; } else { echo "default"; } ?>">Automático</button>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-striped">
      <tbody>
        <tr>
          <th>Nombre del documento</th>
          <th style="text-align: center;">Estatus</th>
        </tr>
        <?php $v = 0;
        for ($i = 0; $i < sizeof($lst_docs); $i++) {  ?>
          <tr>
            <td><?php echo $lst_docs[$i]['NomDocumento']; ?></td>
            <td style="text-align: center;">
              <?php if ($lst_docs[$i]['IdEstatus'] == 1) { ?>
                <span onclick="sel_docs_id(<?php echo $lst_docs[$i]['IdExpediente']; ?>,<?php echo $IdUsua; ?>,4)" style="cursor: pointer;" class="badge bg-red">Pendiente</span>
              <?php } else { ?>
                <span onclick="sel_docs_id(<?php echo $lst_docs[$i]['IdExpediente']; ?>,<?php echo $IdUsua; ?>,1)" style="cursor: pointer;" class="badge bg-light-blue">Recibido</span>
              <?php } ?>
            </td>
          </tr><?php } ?>
      </tbody>
    </table>
  </form>
  <?php if($v == 0){ ?>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-6 control-label">Giro en la que estará:</label>
        <div class="col-sm-6">
          <select class="form-control" id="txt_giro">
            <option value="">- SELECCIONE -</option>
            <option value="1" <?php if($lst_docs[0]["Giro"] == 1){ ?>selected="selected"<?php } ?> > PRODUCTIVO </option>
            <option value="2" <?php if($lst_docs[0]["Giro"] == 2){ ?>selected="selected"<?php } ?>> COMERCIO </option>
            <option value="3" <?php if($lst_docs[0]["Giro"] == 3){ ?>selected="selected"<?php } ?>> SERVICIO </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Tipo:</label>
        <div class="col-sm-6">
          <select class="form-control" id="txt_tipoEmpresa">
            <option value="">- SELECCIONE - </option>
            <option value="1" <?php if($lst_docs[0]["TipoEmp"]== 1){?>selected="selected"<?php } ?>> PÚBLICA </option>
            <option value="2" <?php if($lst_docs[0]["TipoEmp"]== 2){?>selected="selected"<?php } ?>> PRIVADA </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Fecha de validación:</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_fecha_2" name="txt_fecha_2" value="<?php echo $lst_serv[0]["Fecha_validado"]; ?>">
        </div>
      </div>
    </div>

    <div class="box-footer">
    <?php if((isset($lst_serv[0]["_validado"])) && ($lst_serv[0]["_validado"] == 2)){ ?>
      <!-- <button type="button" class="btn bg-maroon btn-flat pull-right"><i class="fa fa-times-circle"></i> Cancelar servicio social</button> -->
    <?php } else { ?>
      <button onclick="generar_expediente(<?php echo $lst_docs[0]['IdServicio'].','.$lst_docs[0]['IdExpediente'].','.$IdUsua; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-save"></i> Generar expediente</button>
    <?php } ?>
      
    </div>

  </form>
  <?php } ?>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('#txt_fecha_2').datepicker({
      autoclose: true
    })
  })
  </script>
<?php } ?>