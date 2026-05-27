<?php
session_start();
require('../php/clases/class.System.php');
require('../hace.php');
  $db = new Conexion();
   $_IdUs = $_SESSION['IdUsua'];

   $sqlx = $db->query("SELECT tblh_detallepagos.IdDetallePagos, tblp_pagos.IdEstatus, tblh_detallepagos.Estatus FROM tblh_detallepagos Left Join tblp_pagos ON tblp_pagos.IdPago = tblh_detallepagos.IdPago WHERE tblh_detallepagos.Estatus = '2' ORDER BY tblp_pagos.IdEstatus DESC");
   while ($x = $db->recorrer($sqlx)) {
    
     $idEsta = $x['IdEstatus'];
     if(($idEsta == 58) || ($idEsta == 4)){
      $sql = $db->query("UPDATE tblh_detallepagos SET tblh_detallepagos.Estatus = '4' WHERE tblh_detallepagos.IdDetallePagos = '".$x['IdDetallePagos']."' ");
     }
   }

  $sql_docs = $db->query("SELECT
    tblh_detallepagos.IdDetallePagos,
tblh_detallepagos.Visto,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdOferta,
tblc_usuario.IdCampus,
tblc_conceptosplanes.NomPlan,
tblc_campus.Campus,
tblh_detallepagos.IdUsua,
tblh_detallepagos.TipoPago,
tblh_detallepagos.FecCap
FROM
tblh_detallepagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_detallepagos.IdUsua
Left Join tblp_pagos ON tblp_pagos.IdPago = tblh_detallepagos.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE
tblc_usuario.Permisos = '3' AND
tblh_detallepagos.Estatus =  '2'
ORDER BY
tblh_detallepagos.FecCap DESC
");
?>
  <form name="frm22" id="frm22" action="updCalificacion.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
      <div class="box">
            <div class="box-body no-padding">
              <table class="table table-striped" style='font-size: 12px;'>
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Alumno</th>
                  <th>Concepto</th>
                  <th>Campus</th>
                  <th>FecSubida</th>
                  <th>Ajustes</th>
                </tr>
                <?php $v = 0;  while($x = $db->recorrer($sql_docs)){ $v = ($v + 1); $IdE = $x['IdOferta']; $IdC = $x['IdCampus'];
                  // $sql9 = $db->query("SELECT tblp_coordinador.IdCoordinador FROM tblp_coordinador WHERE tblp_coordinador.IdUsua = '$_IdUs' AND tblp_coordinador.IdOferta =  '$IdE' AND tblp_coordinador.IdEstatus = '8' AND tblp_coordinador.IdCampus = '$IdC'");
                  // $db->rows($sql9);
                  // $datos91 = $db->recorrer($sql9);
                  //if($datos91["IdCoordinador"]){
                   ?>
                <tr>
                  <td><?php echo $v; ?>.- </td>
                  <td><?php echo $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno']; ?></td>
                  <td><?php if($x['TipoPago'] == 1){ echo $x['NomPlan']; }  else { echo "<b style='color: blue;'>ABONO AL PAGO INICIAL</b>"; } ?></td>
                  <td><?php echo $x['Campus']; ?></td>
                  <td><?php echo tiempo_transcurrido($x['FecCap']); ?> <?php if($x['Visto'] == 0){ echo " <i style='color: black;'>(visto)</i>"; } else { echo " <i style='color: blue;'>(nuevo)</i>"; } ?></td>
                  <td style='text-align: center;'>
                      <div class="btn-group">
                      <button onclick="aprobadoDocs(<?php echo $x['IdDetallePagos']; ?>,<?php echo $x['IdUsua']; ?>)" href="javascript:void(0);" type="button" class="btn btn-primary"><i class="fa fa-sign-out"></i></button>
                    </div>
                  </td>
                </tr><?php } //} ?>
              </tbody></table>
            </div>
          </div>
        </form>

<script>


  function aprobadoDocs(IdDocumento,IdUsua){
    var TipoGuardar = "visto_rec_pag";

    $.ajax({
         url:"formConsulta/setting.php",
         method:"POST",
         data:{TipoGuardar:TipoGuardar, IdDocumento:IdDocumento},
         success:function(data){
           parent.location.href='cobrar.php?token=1632756458'+IdUsua; //direcciona la pagina madre
         }
    })
  }

</script>
