<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $IdCiclo = $_POST['employee_id'];
  $sql9 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwFInicio = $datos91["FInicio"];
  $rwFFinal = $datos91["FFinal"];
  $rwCiclo = $datos91["Ciclo"];
  $rwTipo = $datos91["Tipo"];
  $rwAnio = $datos91["Anio"];


  $output .= '
  <div class="box-info">
            <form class="form-horizontal" name="frm" id="frm" action="updCicloEscolar.php" method="POST" enctype="multipart/form-data">
            <input id="IdCiclo" name="IdCiclo" value="'.$IdCiclo.'" type="hidden"/>
            <input id="Tipo" name="Tipo" value="'.$rwTipo.'" type="hidden"/>
            <input id="Anio" name="Anio" value="'.$rwAnio.'" type="hidden"/>
            <input id="TipoGuardar" name="TipoGuardar" value="updCicloEscV" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Mes inicial:</label>
                  <div class="col-sm-8">
                    <input class="form-control" placeholder="Mes inicial" type="text" id="txtFecIni" name="txtFecIni" value="'.$rwFInicio.'">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Mes final:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right"  id="txtFecFin" name="txtFecFin" value="'.$rwFFinal.'">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">C&oacute;digo ciclo: final:</label>
                  <div class="col-sm-8">
                    <input class="form-control" placeholder="Codigo ciclo" type="text" id="txtCodigo" name="txtCodigo" value="'.$rwCiclo.'">
                  </div>
                </div>


              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-times"></i>Cancelar</button>
                <button type="button" class="btn bg-maroon btn-flat pull-right" onclick="updCicloEscV()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
              </div>
            </form>
          </div>';
  echo $output;
}
?>
