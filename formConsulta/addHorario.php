<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["employee_id"];

  $sql6 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);
  $HraDocx = $datos61["HraDoc"];
  $HraIndx = $datos61["HraInd"];
  $IdModulox = $datos61["IdModulo"];
  if(!$HraDocx){

      $sql8 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulox' ");
      $db->rows($sql8);
      $datos81 = $db->recorrer($sql8);
      $HraDocM = $datos81["HraDoc"];
      $HraIndM = $datos81["HraInd"];

      if($HraDocM){
        $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.HraDoc = '$HraDocM', tblp_asignacion.HraInd = '$HraIndM' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
      }


  }

  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $HraDoc = $datos91["HraDoc"];
  $HraInd = $datos91["HraInd"];
  $IdModulo = $datos91["IdModulo"];




  $sql = $db->query("SELECT tblp_horario.IdHorario, tblp_horario.IdAsignacion, tblp_horario.IdDia, tblp_horario.HraIni, tblp_horario.MinIni, tblp_horario.HraFin, tblp_horario.MinFin, tblp_horario.Total, tblc_dia.Dia FROM tblp_horario Left Join tblc_dia ON tblc_dia.IdDia = tblp_horario.IdDia WHERE tblp_horario.IdAsignacion = '$IdAsignacion' ORDER BY tblp_horario.IdDia ASC");

  ?>
  <form name="frm2" id="frm2" action="addActividad.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
  <table class="table table-condensed" style="font-size: 12px;">
      <tr>
        <th>Día</th>
        <th>Hra</th>
        <th>Min</th>
        <th>-</th>
        <th>Hra</th>
        <th>Min</th>
        <th>Hras día</th>
        <th>-</th>
      </tr>
    <?php while($x = $db->recorrer($sql)){ ?>
                <tr>
                  <td style="width: 120px;"><b style="margin-top: 6px; position: absolute;"><?php echo $x["Dia"]; ?>:</b></td>
                  <td>
                    <select class="form-control" name="txtHraIni-<?php echo$x["IdHorario"]; ?>" id="txtHraIni-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Hra - </option>
                      <option value="07" <?php if($x["HraIni"] == '07'){ ?>selected="selected"<?php } ?>>07</option>
                      <option value="08" <?php if($x["HraIni"] == '08'){ ?>selected="selected"<?php } ?>>08</option>
                      <option value="09" <?php if($x["HraIni"] == '09'){ ?>selected="selected"<?php } ?>>09</option>
                      <option value="10" <?php if($x["HraIni"] == '10'){ ?>selected="selected"<?php } ?>>10</option>
                      <option value="11" <?php if($x["HraIni"] == '11'){ ?>selected="selected"<?php } ?>>11</option>
                      <option value="12" <?php if($x["HraIni"] == '12'){ ?>selected="selected"<?php } ?>>12</option>
                      <option value="13" <?php if($x["HraIni"] == '13'){ ?>selected="selected"<?php } ?>>13</option>
                      <option value="14" <?php if($x["HraIni"] == '14'){ ?>selected="selected"<?php } ?>>14</option>
                      <option value="15" <?php if($x["HraIni"] == '15'){ ?>selected="selected"<?php } ?>>15</option>
                      <option value="16" <?php if($x["HraIni"] == '16'){ ?>selected="selected"<?php } ?>>16</option>
                      <option value="17" <?php if($x["HraIni"] == '17'){ ?>selected="selected"<?php } ?>>17</option>
                      <option value="18" <?php if($x["HraIni"] == '18'){ ?>selected="selected"<?php } ?>>18</option>
                      <option value="19" <?php if($x["HraIni"] == '19'){ ?>selected="selected"<?php } ?>>19</option>
  										<option value="20" <?php if($x["HraIni"] == '20'){ ?>selected="selected"<?php } ?>>20</option>
  								  </select>
                  </td>
                  <td>
                    <select class="form-control" name="txtMinIni-<?php echo$x["IdHorario"]; ?>" id="txtMinIni-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Min - </option>

                      <option value="00" <?php if($x["MinIni"] == '00'){ ?>selected="selected"<?php } ?>> 00 </option>
                      <option value="05" <?php if($x["MinIni"] == '05'){ ?>selected="selected"<?php } ?>> 05 </option>
                      <option value="10" <?php if($x["MinIni"] == '10'){ ?>selected="selected"<?php } ?>> 10 </option>
                      <option value="15" <?php if($x["MinIni"] == '15'){ ?>selected="selected"<?php } ?>> 15 </option>
                      <option value="20" <?php if($x["MinIni"] == '20'){ ?>selected="selected"<?php } ?>> 20 </option>
                      <option value="25" <?php if($x["MinIni"] == '25'){ ?>selected="selected"<?php } ?>> 25 </option>
                      <option value="30" <?php if($x["MinIni"] == '30'){ ?>selected="selected"<?php } ?>> 30 </option>
                      <option value="35" <?php if($x["MinIni"] == '35'){ ?>selected="selected"<?php } ?>> 35 </option>
                      <option value="40" <?php if($x["MinIni"] == '40'){ ?>selected="selected"<?php } ?>> 40 </option>
                      <option value="45" <?php if($x["MinIni"] == '45'){ ?>selected="selected"<?php } ?>> 45 </option>
                      <option value="50" <?php if($x["MinIni"] == '50'){ ?>selected="selected"<?php } ?>> 50 </option>
                      <option value="55" <?php if($x["MinIni"] == '55'){ ?>selected="selected"<?php } ?>> 55 </option>
  								  </select>
                  </td>
                  <td><b>a</b></td>
                  <td>
                    <select class="form-control" name="txtHraFin-<?php echo$x["IdHorario"]; ?>" id="txtHraFin-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Hra - </option>
                      <option value="08" <?php if($x["HraFin"] == '08'){ ?>selected="selected"<?php } ?>>08</option>
                      <option value="09" <?php if($x["HraFin"] == '09'){ ?>selected="selected"<?php } ?>>09</option>
                      <option value="10" <?php if($x["HraFin"] == '10'){ ?>selected="selected"<?php } ?>>10</option>
                      <option value="11" <?php if($x["HraFin"] == '11'){ ?>selected="selected"<?php } ?>>11</option>
                      <option value="12" <?php if($x["HraFin"] == '12'){ ?>selected="selected"<?php } ?>>12</option>
                      <option value="13" <?php if($x["HraFin"] == '13'){ ?>selected="selected"<?php } ?>>13</option>
                      <option value="14" <?php if($x["HraFin"] == '14'){ ?>selected="selected"<?php } ?>>14</option>
                      <option value="15" <?php if($x["HraFin"] == '15'){ ?>selected="selected"<?php } ?>>15</option>
                      <option value="16" <?php if($x["HraFin"] == '16'){ ?>selected="selected"<?php } ?>>16</option>
                      <option value="17" <?php if($x["HraFin"] == '17'){ ?>selected="selected"<?php } ?>>17</option>
                      <option value="18" <?php if($x["HraFin"] == '18'){ ?>selected="selected"<?php } ?>>18</option>
  										<option value="19" <?php if($x["HraFin"] == '19'){ ?>selected="selected"<?php } ?>>19</option>
                      <option value="20" <?php if($x["HraFin"] == '20'){ ?>selected="selected"<?php } ?>>20</option>
                      <option value="21" <?php if($x["HraFin"] == '21'){ ?>selected="selected"<?php } ?>>21</option>
                      <option value="22" <?php if($x["HraFin"] == '22'){ ?>selected="selected"<?php } ?>>22</option>
  								  </select>
                  </td>
                  <td>
                    <select class="form-control" name="txtMinFin-<?php echo$x["IdHorario"]; ?>" id="txtMinFin-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Min - </option>
                        <option value="00" <?php if($x["MinFin"] == '00'){ ?>selected="selected"<?php } ?>> 00 </option>
                        <option value="05" <?php if($x["MinFin"] == '05'){ ?>selected="selected"<?php } ?>> 05 </option>
                        <option value="10" <?php if($x["MinFin"] == '10'){ ?>selected="selected"<?php } ?>> 10 </option>
                        <option value="15" <?php if($x["MinFin"] == '15'){ ?>selected="selected"<?php } ?>> 15 </option>
                        <option value="20" <?php if($x["MinFin"] == '20'){ ?>selected="selected"<?php } ?>> 20 </option>
                        <option value="25" <?php if($x["MinFin"] == '25'){ ?>selected="selected"<?php } ?>> 25 </option>
                        <option value="30" <?php if($x["MinFin"] == '30'){ ?>selected="selected"<?php } ?>> 30 </option>
                        <option value="35" <?php if($x["MinFin"] == '35'){ ?>selected="selected"<?php } ?>> 35 </option>
                        <option value="40" <?php if($x["MinFin"] == '40'){ ?>selected="selected"<?php } ?>> 40 </option>
                        <option value="45" <?php if($x["MinFin"] == '45'){ ?>selected="selected"<?php } ?>> 45 </option>
                        <option value="50" <?php if($x["MinFin"] == '50'){ ?>selected="selected"<?php } ?>> 50 </option>
                        <option value="55" <?php if($x["MinFin"] == '55'){ ?>selected="selected"<?php } ?>> 55 </option>
  								  </select>
                  </td>
                  <td>
                    <select class="form-control" name="txtTotal-<?php echo$x["IdHorario"]; ?>" id="txtTotal-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Total - </option>
                      <option value="1" <?php if($x["Total"] == 1){ ?>selected="selected"<?php } ?>>1 hra</option>
                      <option value="1.5" <?php if($x["Total"] == 1.5){ ?>selected="selected"<?php } ?>>1.5 hra</option>
                      <option value="2" <?php if($x["Total"] == 2){ ?>selected="selected"<?php } ?>>2 hras</option>
                      <option value="2.5" <?php if($x["Total"] == 2.5){ ?>selected="selected"<?php } ?>>2.5 hras</option>
                      <option value="3" <?php if($x["Total"] == 3){ ?>selected="selected"<?php } ?>>3 hras</option>
                      <option value="3.5" <?php if($x["Total"] == 3.5){ ?>selected="selected"<?php } ?>>3.5 hras</option>
                      <option value="4" <?php if($x["Total"] == 4){ ?>selected="selected"<?php } ?>>4 hras</option>
                      <option value="4.5" <?php if($x["Total"] == 4.5){ ?>selected="selected"<?php } ?>>4.5 hras</option>
                      <option value="5" <?php if($x["Total"] == 5){ ?>selected="selected"<?php } ?>>5 hras</option>
                      <option value="5.5" <?php if($x["Total"] == 5.5){ ?>selected="selected"<?php } ?>>5.5 hras</option>
                      <option value="6" <?php if($x["Total"] == 6){ ?>selected="selected"<?php } ?>>6 hras</option>
                      <option value="6.5" <?php if($x["Total"] == 6.5){ ?>selected="selected"<?php } ?>>6.5 hras</option>
                      <option value="7" <?php if($x["Total"] == 7){ ?>selected="selected"<?php } ?>>7 hras</option>
                      <option value="7.5" <?php if($x["Total"] == 7.5){ ?>selected="selected"<?php } ?>>7.5 hras</option>
                      <option value="8" <?php if($x["Total"] == 8){ ?>selected="selected"<?php } ?>>8 hras</option>


  								  </select>
                  </td>
                  <td style="width: 40px;">
                    <button type="button" onclick="addHorario(<?php echo$x["IdHorario"]; ?>)" class="btn bg-purple btn-flat btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-save"></i></button>
                    <?php if($x["Total"]){ ?>
                    <!-- <button type="button" onclick="addHorario(<?php echo$x["IdHorario"]; ?>)" class="btn bg-maroon btn-flat btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-trash"></i></button> -->
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>


              </tbody></table>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Horas docente:</label>

                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="txtHraD" name="txtHraD" value="<?php echo $HraDoc; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Horas Independiente:</label>

                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="txtHraI" name="txtHraI" value="<?php echo $HraInd; ?>" >
                  </div>
                </div>
                <div class="box-footer">
                <button data-dismiss="modal" class="btn btn-warning"> <i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="addHoras()" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Guardar</button>
              </div>
              </div>
        </form>
  <?php
}
?>
