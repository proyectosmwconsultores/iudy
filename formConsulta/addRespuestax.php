<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdPre = $_POST["IdPregunta"];

$sql = $db->query("SELECT * FROM tblxx_respuesta WHERE tblxx_respuesta.IdPregunta = '$IdPre' ORDER BY tblxx_respuesta.Valor Desc ");


  ?>
  <form name="frm2sr" id="frm2sr" action="updCampus.php" method="POST" enctype="multipart/form-data">
    <input id="IdPregunta" name="IdPregunta" value="<?php echo $IdPre; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updPreguts" type="hidden"/>
    <div class="box-header">
      <h3 class="box-title">Lista de respuestas</h3>
    </div>
    <table class="table table-striped">
      <tr>
        <td>
          <select class="form-control" name="txtValor" id="txtValor">
            <option value=""> Valor</option>
            <option value="10"> 10 </option>
            <option value="9"> 9 </option>
            <option value="8"> 8 </option>
            <option value="7"> 7 </option>
            <option value="6"> 6 </option>
            <option value="5"> 5 </option>
          </select>
        </td>
        <td colspan="2"><input name="txtTexto" id="txtTexto" class="form-control" placeholder="Escriba la respuesta"></td>
        <td><button title="Guardar respuesta" type="button" class="btn btn-info btn-sm" onclick="saveRespx(<?php echo $IdPre; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-save"></i> Guardar</button></td>
      </tr>
        <tbody><tr>
          <th>Valor</th>
          <th>Respuesta</th>
          <th>Estatus</th>
          <th>Ajuste</th>
        </tr>
        <?php while($x = $db->recorrer($sql)){ $IdRe = $x["IdResp"]; ?>
        <tr>
          <td>
            <select class="form-control" name="txtValor-<?php echo $IdRe; ?>" id="txtValor-<?php echo $IdRe; ?>">
              <option value="10" <?php if($x["Valor"] == 10){ ?>selected="selected"<?php } ?>> 10 </option>
              <option value="9" <?php if($x["Valor"] == 9){ ?>selected="selected"<?php } ?>> 9 </option>
              <option value="8" <?php if($x["Valor"] == 8){ ?>selected="selected"<?php } ?>> 8 </option>
              <option value="7" <?php if($x["Valor"] == 7){ ?>selected="selected"<?php } ?>> 7 </option>
              <option value="6" <?php if($x["Valor"] == 6){ ?>selected="selected"<?php } ?>> 6 </option>
              <option value="5" <?php if($x["Valor"] == 5){ ?>selected="selected"<?php } ?>> 5 </option>
            </select>
          </td>
          <td><input name="txtTexto-<?php echo $IdRe; ?>" id="txtTexto-<?php echo $IdRe; ?>" class="form-control" value="<?php echo $x['Texto']; ?>"></td>
          <td>
            <select class="form-control" name="txtEstatus-<?php echo $IdRe; ?>" id="txtEstatus-<?php echo $IdRe; ?>">
              <option value="8" <?php if($x["IdEstatus"] == 8){ ?>selected="selected"<?php } ?>> Activo </option>
              <option value="9" <?php if($x["IdEstatus"] == 9){ ?>selected="selected"<?php } ?>> Inactivo </option> 
            </select>
          </td>
          <td>
            <button title="Preguntas" type="button" class="btn btn-success btn-sm" onclick="savResp(<?php echo $x['IdResp']; ?>, <?php echo $IdPre; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
          </td>
        </tr><?php } ?>
      </tbody></table>


  <!-- <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre de la pregunta:</label>
              <textarea name="txtPregunta" id="txtPregunta" class="form-control" rows="3" placeholder="Enter ..."><?php echo $datos91["Pregunta"]; ?></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Estatus:</label>
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value="8" <?php if($datos91["IdEstatus"] == 8){ ?>selected="selected"<?php } ?>> Activo </option>
                <option value="9" <?php if($datos91["IdEstatus"] == 9){ ?>selected="selected"<?php } ?>> Inactivo </option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updEPregs()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div> -->

  </form>
