<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["employee_id"];

  // $sql6 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  // $db->rows($sql6);
  // $datos61 = $db->recorrer($sql6);
  // $HraDocx = $datos61["HraDoc"];
  // $HraIndx = $datos61["HraInd"];
  // $IdModulox = $datos61["IdModulo"];
  // if(!$HraDocx){
  //
  //     $sql8 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulox' ");
  //     $db->rows($sql8);
  //     $datos81 = $db->recorrer($sql8);
  //     $HraDocM = $datos81["HraDoc"];
  //     $HraIndM = $datos81["HraInd"];
  //
  //     if($HraDocM){
  //       $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.HraDoc = '$HraDocM', tblp_asignacion.HraInd = '$HraIndM' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  //     }
  //
  //
  // }
  //
  // $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  // $db->rows($sql9);
  // $datos91 = $db->recorrer($sql9);
  // $HraDoc = $datos91["HraDoc"];
  // $HraInd = $datos91["HraInd"];
  // $IdModulo = $datos91["IdModulo"];




  $sql = $db->query("SELECT tblp_horario.IdHorario, tblp_horario.IdAsignacion, tblp_horario.IdDia, tblp_horario.HraIni, tblp_horario.MinIni, tblp_horario.HraFin, tblp_horario.MinFin, tblp_horario.Total, tblc_dia.Dia FROM tblp_horario Left Join tblc_dia ON tblc_dia.IdDia = tblp_horario.IdDia WHERE tblp_horario.IdAsignacion = '$IdAsignacion' ORDER BY tblp_horario.IdDia ASC");

  ?>
  <form name="frm2" id="frm2" action="addActividad.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
  <table class="table table-condensed">
      <tr>
        <th>Día</th>
        <th>Hra</th>
        <th>Min</th>
        <th>-</th>
        <th>Hra</th>
        <th>Min</th>
        <th>Hras día</th>
        <th style="width: 100px;">-</th>
      </tr>
    <?php while($x = $db->recorrer($sql)){ ?>
                <tr>
                  <td style="width: 120px;"><b style="margin-top: 6px; position: absolute;"><?php echo $x["Dia"]; ?>:</b></td>
                  <td>
                    <select class="form-control" name="txtHraIni-<?php echo$x["IdHorario"]; ?>" id="txtHraIni-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Hra - </option>
                      <option value="7" <?php if($x["HraIni"] == 7){ ?>selected="selected"<?php } ?>>07</option>
                      <option value="8" <?php if($x["HraIni"] == 8){ ?>selected="selected"<?php } ?>>08</option>
                      <option value="9" <?php if($x["HraIni"] == 9){ ?>selected="selected"<?php } ?>>09</option>
                      <option value="10" <?php if($x["HraIni"] == 10){ ?>selected="selected"<?php } ?>>10</option>
                      <option value="11" <?php if($x["HraIni"] == 11){ ?>selected="selected"<?php } ?>>11</option>
                      <option value="12" <?php if($x["HraIni"] == 12){ ?>selected="selected"<?php } ?>>12</option>
                      <option value="13" <?php if($x["HraIni"] == 13){ ?>selected="selected"<?php } ?>>13</option>
                      <option value="14" <?php if($x["HraIni"] == 14){ ?>selected="selected"<?php } ?>>14</option>
                      <option value="15" <?php if($x["HraIni"] == 15){ ?>selected="selected"<?php } ?>>15</option>
                      <option value="16" <?php if($x["HraIni"] == 16){ ?>selected="selected"<?php } ?>>16</option>
                      <option value="17" <?php if($x["HraIni"] == 17){ ?>selected="selected"<?php } ?>>17</option>
                      <option value="18" <?php if($x["HraIni"] == 18){ ?>selected="selected"<?php } ?>>18</option>
                      <option value="19" <?php if($x["HraIni"] == 19){ ?>selected="selected"<?php } ?>>19</option>
  										<option value="20" <?php if($x["HraIni"] == 20){ ?>selected="selected"<?php } ?>>20</option>
  								  </select>
                  </td>
                  <td>
                    <select class="form-control" name="txtMinIni-<?php echo$x["IdHorario"]; ?>" id="txtMinIni-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Min - </option>
                      <?php for($i = 0; $i < 60; $i++){ if($i < 10){ $m = 0; } else { $m = ''; } ?>
                        <option value="<?php echo $m.$i; ?>" <?php if($x["MinIni"] == $m.$i){ ?>selected="selected"<?php } ?>> <?php echo $m.$i; ?> </option>
                      <?php } ?>
  								  </select>
                  </td>
                  <td><b>a</b></td>
                  <td>
                    <select class="form-control" name="txtHraFin-<?php echo$x["IdHorario"]; ?>" id="txtHraFin-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Hra - </option>
                      <option value="8" <?php if($x["HraFin"] == 8){ ?>selected="selected"<?php } ?>>08</option>
                      <option value="9" <?php if($x["HraFin"] == 9){ ?>selected="selected"<?php } ?>>09</option>
                      <option value="10" <?php if($x["HraFin"] == 10){ ?>selected="selected"<?php } ?>>10</option>
                      <option value="11" <?php if($x["HraFin"] == 11){ ?>selected="selected"<?php } ?>>11</option>
                      <option value="12" <?php if($x["HraFin"] == 12){ ?>selected="selected"<?php } ?>>12</option>
                      <option value="13" <?php if($x["HraFin"] == 13){ ?>selected="selected"<?php } ?>>13</option>
                      <option value="14" <?php if($x["HraFin"] == 14){ ?>selected="selected"<?php } ?>>14</option>
                      <option value="15" <?php if($x["HraFin"] == 15){ ?>selected="selected"<?php } ?>>15</option>
                      <option value="16" <?php if($x["HraFin"] == 16){ ?>selected="selected"<?php } ?>>16</option>
                      <option value="17" <?php if($x["HraFin"] == 17){ ?>selected="selected"<?php } ?>>17</option>
                      <option value="18" <?php if($x["HraFin"] == 18){ ?>selected="selected"<?php } ?>>18</option>
  										<option value="19" <?php if($x["HraFin"] == 19){ ?>selected="selected"<?php } ?>>19</option>
                      <option value="20" <?php if($x["HraFin"] == 20){ ?>selected="selected"<?php } ?>>20</option>
                      <option value="21" <?php if($x["HraFin"] == 21){ ?>selected="selected"<?php } ?>>21</option>
                      <option value="22" <?php if($x["HraFin"] == 22){ ?>selected="selected"<?php } ?>>22</option>
  								  </select>
                  </td>
                  <td>
                    <select class="form-control" name="txtMinFin-<?php echo$x["IdHorario"]; ?>" id="txtMinFin-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Min - </option>
                      <?php for($i = 0; $i < 60; $i++){ if($i < 10){ $m = 0; } else { $m = ''; } ?>
                        <option value="<?php echo $m.$i; ?>" <?php if($x["MinFin"] == $m.$i){ ?>selected="selected"<?php } ?>> <?php echo $m.$i; ?> </option>
                      <?php } ?>
  								  </select>
                  </td>
                  <td>
                    <select class="form-control" name="txtTotal-<?php echo$x["IdHorario"]; ?>" id="txtTotal-<?php echo$x["IdHorario"]; ?>">
  										<option value=""> - Total - </option>
                      <option value="1" <?php if($x["Total"] == 1){ ?>selected="selected"<?php } ?>>1 hra</option>
                      <option value="2" <?php if($x["Total"] == 2){ ?>selected="selected"<?php } ?>>2 hras</option>
                      <option value="3" <?php if($x["Total"] == 3){ ?>selected="selected"<?php } ?>>3 hras</option>
                      <option value="4" <?php if($x["Total"] == 4){ ?>selected="selected"<?php } ?>>4 hras</option>
                      <option value="5" <?php if($x["Total"] == 5){ ?>selected="selected"<?php } ?>>5 hras</option>
                      <option value="6" <?php if($x["Total"] == 6){ ?>selected="selected"<?php } ?>>6 hras</option>


  								  </select>
                  </td>
                  <td>
                    <button type="button" onclick="addHorario(<?php echo$x["IdHorario"]; ?>)" class="btn btn-primary" href="javascript:void(0);" style="float: center;"><i class="fa fa-save"></i></button>
                    <?php if(isset($x["Total"])){ ?>
                    <button type="button" onclick="delHorario(<?php echo$x["IdHorario"]; ?>)" class="btn btn-danger" href="javascript:void(0);" style="float: center;"><i class="fa fa-trash"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>


              </tbody></table>

        </form>
  <?php
}

?>
<script>
function delHorario(IdHorario){
  var IdAsignacion = document.getElementById("IdAsignacion").value;

  var TipoGuardar = "delHorario";
  swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar el horario de este dia?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
			var datos = 'TipoGuardar=' + TipoGuardar + '&IdAsignacion=' + IdAsignacion + '&IdHorario=' + IdHorario;
			$.ajax({
				type:"POST",
				url:"docente/setting.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {
				if(data==1){
					swal("Eliminado correctamente", "Horario del dia eliminado correctamente.", "success");
          $.ajax({
               url:"docente/addHorario.php",
               method:"POST",
               data:{employee_id:IdAsignacion},
               success:function(data){
                    $('#employee_hra').html(data);
                    $('#dataHra').modal('show');
               }
          });
				}
				if(data==0){
					swal("Error al eliminar", "No se puede eliminar estatus de cuenta de banco, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x136", "No se puede eliminar, comuniquese con el desarrollador.", "error");
			});
		}
	});


}
</script>
