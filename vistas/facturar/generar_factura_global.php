<?php session_start();
require('../../php/clases/class.System.php');
include('../../hace.php');
$db = new Conexion();
$IdUsua = $_SESSION['IdUsua'];
$Inicio = $_POST['Inicio'];
$Final = $_POST['Final'];
$IdForma = $_POST['IdForma'];

$forma = $db->query("SELECT * FROM tblc_formapago");



$lst_pag = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.Monto,
tblp_foliospago.FecPago,
tblc_conceptosplanes.Unidad,
tblc_conceptosplanes.ClaveUnidad,
tblc_conceptosplanes.ClaveProdServ,
tblc_conceptosplanes.NomPlan,
tblp_modulo.NombreMod,
tblp_pagos.FecDesc,
tblp_educativa.IdGrado,
tblp_foliospago.Estatus,
tblp_foliospago._importe,
    tblp_foliospago._descuento,
    tblp_foliospago._total,
tblp_pagos.Monto AS TotalPagar
FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_pagos.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
WHERE
tblp_foliospago.Factura = '1' AND
tblp_foliospago.IdForma = '$IdForma' AND
tblp_foliospago.FecPago BETWEEN '$Inicio' AND '$Final'

");

  ?>
  <form class="form-horizontal">
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
          <tr>
            <th style="width: 10px"></th>
            <th>CONCEPTO</th>
            <th>FECHA</th>
            <th style="width: 100px; text-align: right;">PRECIO</th>
            <th style="width: 100px; text-align: right;">DESCUENTO</th>
            <th style="width: 100px; text-align: right;">MONTO</th>
          </tr>
          <?php $_des = 0; $sub = 0; $c = 0; $sum = 0; while($pag = $db->recorrer($lst_pag)){
            $_descu = $pag['_descuento'];
            if($_descu < 0){
              $_impor = $pag['_total'];
              $_descu = 0;
              $_total = $pag['_total'];
            } else {
              $_impor = $pag['_importe'];
              $_total = $pag['_total'];
              $_sum = ($_descu + $_total);
              if($_sum <> $_impor){
                $_impor = $pag['_total'];
                $_descu = 0;
                $_total = $pag['_total'];
              }
            }
            $sub = ($sub +  $_impor);
            $_des = ($_des +  $_descu);
            $sum = ($sum +  $_total);
            ?>
          <tr>
            <td><b><?php echo $c = ($c + 1); ?>.-</b></td>
            <td><?php echo $pag['NomPlan']; ?></td>
            <td><?php echo $pag['FecPago']; ?></td>
            <td style="width: 100px; text-align: right;">$ <?php echo number_format($_impor, 2, '.', ','); ?></td>
            <td style="width: 100px; text-align: right;">$ <?php echo number_format($_descu, 2, '.', ','); ?></td>
            <td style="width: 100px; text-align: right;">$ <?php echo number_format($_total, 2, '.', ','); ?></td>
          </tr><?php } ?>
          <tr>
            <td colspan="5" style="text-align: right;"><b>SubTotal:</b></td>
            <td><b>$ <?php echo number_format($sub, 2, '.', ','); ?></b></td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: right;"><b>Descuento:</b></td>
            <td><b>$ <?php echo number_format($_des, 2, '.', ','); ?></b></td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: right;"><b>Total:</b></td>
            <td style="background: yellow;"><b>$ <?php echo number_format($sum, 2, '.', ','); ?></b></td>
          </tr>
        </tbody></table>
        <br><br>

        <div class="form-group">
          <label class="col-sm-3 control-label">FORMA DE PAGO:</label>
          <div class="col-sm-9">
            <select name="txt_cfdi" id="txt_cfdi" class="form-control" disabled>
              <?php while($_forma = $db->recorrer($forma)){ ?>
              <option value="<?php echo $_forma['IdFormaPago']; ?>" <?php if($_forma['IdFormaPago']==$IdForma){ ?>selected="selected"<?php } ?>><?php echo $_forma['_Descripcion']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">FECHA DE FACTURACIÓN:</label>
          <div class="col-sm-6">
            <input type="text" name="txt_fechax" id="txt_fechax" class="form-control">
          </div>
        </div>
      
        <br><br>
        <?php if($IdUsua == 1){ ?>
        <button onclick="procesar_factura_id('<?php echo $Inicio; ?>','<?php echo $Final; ?>',<?php echo $IdForma; ?>)" type="button" class="btn bg-navy btn-flat margin" style="width: 95%;"><i class="fa fa-fw fa-check-circle"></i> Generar factura</button>
        <?php } ?>

</form>
<script>
  $(function() {
				//Date picker
				$('#txt_fechax').datepicker({
					autoclose: true
				})
			})

  function procesar_factura_id(Inicio,Final,IdForma){
    var Fecha = document.getElementById("txt_fechax").value;
    if (Fecha==""){
          swal("Error al guardar", "Debe seleccionar la fecha con la que quiere realizar esta factura.", "error");
          document.getElementById("txt_fechax").focus();
          return 0;
      }

      var TipoGuardar = "generar_factura_global";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea generar esta factura global, con la fecha seleccionada?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function (isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
                url:"vistas/facturar/setting_facturar.php",
                method:"POST",
                data:{TipoGuardar:TipoGuardar, Inicio:Inicio, Final:Final, IdForma:IdForma, Fecha:Fecha},
                success:function(data){ //alert(data);

                }
           })
          .done(function(data) {
            var Valor1 = '';
            var Valor2 = '';
            var porciones = data.split('_');
            Valor1 = porciones[0];
            Valor2 = porciones[1];

            if(Valor1==1){

              swal({
          		title: "La factura se ha generado correctamente",
          		type: "success",
          		showCancelButton: false,
          		confirmButtonColor: '#DD6B55',
          		confirmButtonText: 'Aceptar',
          		//cancelButtonText: "Cancelar",
          		//closeOnConfirm: false,
          		//closeOnCancel: false
          	},
          	function (isConfirm) {
          		if (isConfirm) {
          			$(".confirm").attr('disabled', 'disabled');
          			parent.location.href='factura_global.php';
          			return true;
          		} else {
          			return false;
          		}
          	});
              // swal("Generado correctamente", "La factura se ha generado correctamente.", "success");
              // $.ajax({
              //    url:"formConsulta/generar_factura_id.php",
              //    method:"POST",
              //    data:{IdUsua:IdUsua, NoFolio:NoFolio},
              //      success:function(data){
              //         $('#employee_fact_gene').html(data);
              //         $('#data_fact_gene').modal('show');
              //      }
              // });
            }
            if(Valor1==0){
              swal("Ha ocurrido un error", Valor2, "error");
            }
          })
          .error(function(data) {
            swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
          });
        }

      });
  }
</script>
