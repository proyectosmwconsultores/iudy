<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

  ?>
  <form name="frm2sFr" id="frm2sFr" action="updFuente.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="TipoGuardar" id="TipoGuardar" value="addEvalsf">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre de la evaluación:</label>
                <input name="txtNombre" id="txtNombre" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Tipo de evaluación:</label>
              <select class="form-control" name="txtPermiso" id="txtPermiso">
                <option value="1"> Encuesta de satisfacción académica </option>
                <option value="2"> Encuesta de egreso </option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="addEvalsx()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
