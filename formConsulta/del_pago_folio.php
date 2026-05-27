<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];
  $Folio = $_POST["Folio"];
  $Token = $_POST["Token"];

    $sql_folio = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.FecPago,
tblp_foliospago.Monto,
tblc_conceptosplanes.NomPlan
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE
tblp_foliospago.Folio =  '$Folio'
");
  ?>
  <form class="form-horizontal" name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -45px;">
        <!-- <div class="box-body"> -->
          <table class="table table-striped">
                <tbody>
                  <tr style="background: #1e2255c4;">
                    <td colspan="2" style="text-align: center; font-size: 20px; color: yellow;"><b>FOLIO DE PAGO: <?php echo $Folio; ?></b></td>
                  </tr>
                  <tr>
                    <th>PLAN DE PAGO</th>
                    <th style="text-align: right;">FECHA DE PAGO</th>
                  </tr>

                <?php $px = 0; while($_fol = $db->recorrer($sql_folio)){ $px = $_fol['Monto'];  ?>
                  <tr>
                    <td><?php echo $_fol['NomPlan']; ?></td>
                    <td style="text-align: right;"><?php echo $_fol['FecPago']; ?></td>
                  </tr>
                <?php }  ?>
                <tr style="background: #c1c5ffc4;">
                  <td><b>Total pagado:</b></td>
                  <td style="text-align: right;"><b>$ <?php echo number_format($px, 2, '.', ','); ?></b></td>
                </tr>
              </tbody></table>

      </div>
      <div class="box-body">
        <form role="form">
        <div class="form-group">
          <label>Motivo de la cancelación:</label>
          <textarea name="txt_cancel" id="txt_cancel" class="form-control" rows="3" placeholder="Enter ..."></textarea>
        </div>
        <button onclick="cancelar_pagox(<?php echo $Folio; ?>,<?php echo $IdUsua; ?>,<?php echo $Token; ?>)" type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-times-circle"></i> Cancelar pago</button>
        </form>
        </div>
    </table>

  </div>

  </form>

<script>

function cancelar_pagox(Folio, IdUsua, Token){
    var Cancelx = document.getElementById("txt_cancel").value;

    if (Cancelx ==""){
        swal("Error al cancelar", "Debe escribir el motivo de la cancelación del pago.", "error");
        return 0;
    }

    var TipoGuardar = "cancel_pago";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea cancelar este pago?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, Folio:Folio, IdUsua:IdUsua, Cancelx:Cancelx},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==1){
            swal("Cancelado correctamente", "El pago se ha cancelado correctamente.", "success");
            parent.location.href='cobrar.php?token='+Token;
          }

        })
        .error(function(data) {
          swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}

</script>
