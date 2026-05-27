<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';

  $IdU =  $_POST["employee_id"];
  $IdOferta =  $_POST["IdOferta"];
  $IdCampus =  $_POST["IdCampus"];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdGrado = $datos91["IdGrado"];

  $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdU'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Pagos = $datos81["Valor"];

  $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Tipo = 'Abierto' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCampus = '$IdCampus'");
  $sql2 = $db->query("SELECT tblp_pagos.IdPago, tblc_conceptos.NomConcepto, tblp_pagos.FecLimPago, tblp_pagos.Pagar, tblp_descuento.Descuento, tblp_descuento.Porcentaje FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblp_descuento ON tblp_descuento.IdDescuento = tblp_pagos.IdDescuento AND tblp_descuento.IdPago = tblp_pagos.IdPago WHERE tblp_pagos.IdEstatus <> '4' AND tblp_pagos.IdUsua = '$IdU' ");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);

?>
  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="IdCampus" id="IdCampus" value="<?php echo $IdCampus; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">


          <?php $valor = ""; ?>
          <?php if($Pagos == 1){ $valor = "disabled"; ?>
          <div class="alert alert-danger alert-dismissible" style="text-align: justify;">
            <h4><i class="fa fa-exclamation-circle"></i> Alerta</h4>
            Este prospecto aun <b style="color: black;">no se han generado sus pagos correspondientes,</b> favor de comunicarse con el <b style="color: black;">&aacute;rea de finanzas</b>, para continuar con este proceso.
          </div>
            <?php } ?>
            <?php if(($Pagos == 2) && ($datos21[0])){ $valor = "disabled"; ?>
            <div class="alert alert-info alert-dismissible">
                <h4><i class="fa fa-exclamation-circle"></i> Alerta</h4>
                Este prospecto aun <b style="color: black;">tiene pagos pendientes por realizar,</b> en cuanto realice los pagos correspondientes usted podr&aacute; asiganarlo a un grupo.
              </div>
          <?php } ?>
        <div class="col-md-8">
          <div class="form-group">
            <label>Clave grupo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-gears"></i>
              </div>
              <select class="form-control" name="txtGrupoAdd" id="txtGrupoAdd" <?php echo $valor; ?> >
                <option value=""> - Seleccione - </option>
                <?php $cond = "";
                while($x = $db->recorrer($sql)){
                  if($x["IdGrupo"]==$IdGrupo) { $cond = " selected='selected'"; }  else { $cond = ""; }
                    ?>
                <option value="<?php echo $x["IdGrupo"]; ?>" <?php echo $cond;  ?> ><?php echo $x["CveGrupo"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <div class="input-group">
              <button type="button" class="btn btn-block btn-success btn-sm" onClick="val_cveGrupo()"> ASIGNAR CLAVE DE GRUPO</button>
            </div>
          </div>
        </div>

    </table>
  </div>
</form>
<?php } ?>
