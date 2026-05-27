<?php
require('../../php/clases/class.System.php');
include('../../hace.php');
$db = new Conexion();

$Ubicacion = $_POST['Ubicacion'];
$IdUsua = $_POST['IdUsua'];
$NoFolio = $_POST['NoFolio'];
$forma = "";
$_forma = "";

$sql_us = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Curp, tblc_rvoe.Rvoe, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblc_rvoe ON tblc_rvoe.IdEducativa = tblc_usuario.IdOferta AND tblc_rvoe.IdCampus = tblc_usuario.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_rvoe.IdEducativa WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
$db->rows($sql_us);
$fac_us = $db->recorrer($sql_us);
if(!isset($fac_us['Curp'])){
    $sql_usx = $db->query("SELECT tblp_informacion.P_curp FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua' ");
    $db->rows($sql_usx);
    $ussxc = $db->recorrer($sql_usx);
    if(isset($ussxc['P_curp'])){
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Curp = '".$ussxc['P_curp']."' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    }
    
}

$sql_us = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Curp, tblc_rvoe.Rvoe, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblc_rvoe ON tblc_rvoe.IdEducativa = tblc_usuario.IdOferta AND tblc_rvoe.IdCampus = tblc_usuario.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_rvoe.IdEducativa WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
$db->rows($sql_us);
$fac_us = $db->recorrer($sql_us);


$sql_fac = $db->query("SELECT * FROM tblc_datosfactura WHERE tblc_datosfactura.IdUsua = '$IdUsua' ");
$db->rows($sql_fac);
$fac = $db->recorrer($sql_fac);

$lst_pag = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.Monto,
tblp_pagos.Fecha,
tblp_educativa.IdGrado,
tblp_foliospago.Estatus,
tblp_pagos.Monto AS TotalPagar,
tblc_formapago.c_FormaPago,
tblc_formapago.c_Descripcion,
tblp_educativa.Nombre,
tblc_conceptos.NomConcepto,
tblc_conceptosplanes.ClaveUnidad,
tblc_conceptosplanes.ClaveProdServ,
tbc_producto.Descripcion
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tbc_producto ON tbc_producto.Clave = tblc_conceptosplanes.ClaveProdServ
WHERE tblp_foliospago.IdUsua = '$IdUsua' AND  tblp_foliospago.NoFolio = '$NoFolio'");

  ?>
  <form class="form-horizontal">
    <?php if($fac['IdEstatus'] == 8){ ?>
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
          <tr>
            <th style="width: 10px"></th>
            <th>CONCEPTO</th>
            <th>CVE UNIDAD</th>
            <th>CVE PRODUCTO</th>
            <th style="width: 85px; text-align: right;">IMPORTE</th>
            <th style="width: 85px; text-align: right;">DESCUENTO</th>
            <th style="width: 85px; text-align: right;">TOTAL</th>
          </tr>
          <?php $c = 0; $sum = 0; $vx = 0; while($pag = $db->recorrer($lst_pag)){
            $forma = $pag['c_FormaPago'].' '.$pag['c_Descripcion'];
            $_forma = $pag['c_FormaPago'];
            $desc = ($pag['TotalPagar'] - $pag['Monto']);
            
            ?>
          <tr>
            <td><b><?php echo $c = ($c + 1); ?>.-</b></td>
            <td><?php echo $pag['Nombre'].' - '.$pag['NomConcepto'].' '.obtener_AnioMesMAY($pag['Fecha']); ?></td>
            <td><?php if($pag['ClaveUnidad']){ echo $pag['ClaveUnidad']; } else { $vx = 1;  echo "<b style='color: red; '><i class='fa fa-warning'></i></b>"; }?></td>
            <td><?php if($pag['ClaveProdServ']){ echo $pag['ClaveProdServ'].' - '.$pag['Descripcion'];  } else { $vx = 1;  echo "<b style='color: red; '><i class='fa fa-warning'></i></b>"; }?></td>
            <td style="text-align: right;">$ <?php echo number_format($pag['TotalPagar'], 2, '.', ','); ?></td>
            <td style="text-align: right;">$ <?php echo number_format($desc, 2, '.', ','); ?></td>
            <td style="text-align: right;">$ <?php echo number_format($pag['Monto'], 2, '.', ','); ?></td>
          </tr><?php $sum = ($sum + $pag['Monto']); } ?>
          <tr>
            <td colspan="6" style="text-align: right;"><b>TOTAL:</b></td>
            <td style="background: yellow; text-align: right;"><b>$ <?php echo number_format($sum, 2, '.', ','); ?></b></td>
          </tr>
        </tbody></table>
        <br><br>
        <?php $total = number_format($sum, 2, '.', ''); ?>
        <div class="form-group">
          <label class="col-sm-3 control-label">Forma de pago:</label>
          <div class="col-sm-9">
          <input type="text" value="<?php echo $forma; ?>" class="form-control" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">Fecha de facturacion:</label>
          <div class="col-sm-6">
            <input type="text" name="txt_fechax" id="txt_fechax" class="form-control" value="<?php echo date("Y/m/d"); ?>">
          </div>
        </div>
        <?php if($fac_us['IdGrado'] == 4){ ?>
        <br>
        <div class="bg-purple color-palette" style='padding: 10px; color: black;'><span>Datos del complemento educativo (Bachillerato)</span></div>
        <br>
        <div class="form-group">
          <label class="col-sm-6 control-label">CURP:</label>
          <div class="col-sm-6">
            <input type="text" disabled class="form-control" value="<?php echo $fac_us['Curp']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-6 control-label">RVOE:</label>
          <div class="col-sm-6">
            <input type="text" disabled class="form-control" value="<?php echo $fac_us['Rvoe']; ?>">
          </div>
        </div>
        <?php 
        if((!isset($fac_us['Curp'])) || (!isset($fac_us['Rvoe']))){
            $vx = 1;
        }
        } ?>
        <br><br>
        <?php 
        if($vx == 0){ ?>
          <button onclick="procesar_factura_id(<?php echo $IdUsua; ?>,'<?php echo $NoFolio; ?>',<?php echo $total.','.$_forma; ?>,<?php echo $Ubicacion; ?>)" type="button" class="btn bg-navy btn-flat margin" style="width: 95%;"><i class="fa fa-fw fa-check-circle"></i> Generar factura</button>
          <!--<button onclick="procesar_factura_id_2(<?php echo $IdUsua; ?>,'<?php echo $NoFolio; ?>',<?php echo $total.','.$_forma; ?>,<?php echo $Ubicacion; ?>)" type="button" class="btn bg-navy btn-flat margin" style="width: 95%;"><i class="fa fa-fw fa-check-circle"></i> Generar factura (PRUEBA)</button>-->
        <?php } else { ?>
          <button type="button" class="btn bg-maroon btn-flat margin" style="width: 95%;"><i class="fa fa-fw fa-times-circle"></i> No disponible para la factura</button>
        <?php } ?>
        
        <br><br>

  <?php } else { ?>
    <div class="alert alert-danger alert-dismissible">
      <h4><i class="icon fa fa-ban"></i> Datos de facturacion no activa!</h4>
      Estimado usuario favor de revisar los dato de facturacion para continuar con este proceso.
    </div>
  <?php } ?>
</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
$(function() {
				//Date picker
				$('#txt_fechax').datepicker({
					autoclose: true
				})
			})
			
  function procesar_factura_id(IdUsua,NoFolio,Total,Forma,Ubicacion){
var Fecha = document.getElementById("txt_fechax").value;
    if (Fecha==""){
          swal("Error al guardar", "Debe seleccionar la fecha con la que quiere realizar esta factura.", "error");
          document.getElementById("txt_fechax").focus();
          return 0;
      }
      var TipoGuardar = "process_fact_id";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea generar esta factura, con la fecha seleccionada?",
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
                data:{TipoGuardar:TipoGuardar,IdUsua:IdUsua, NoFolio:NoFolio, Total:Total, Forma:Forma, Ubicacion:Ubicacion, Fecha:Fecha},
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
                if(Ubicacion == 0){
                  parent.location.href='adFacturas.php';
                }
                if(Ubicacion == 1){
                  parent.location.href='cobrar.php?token=1672771826'+IdUsua;
                }
                if(Ubicacion == 3){
                  parent.location.href='usuarios_externos.php';
                }
                if(Ubicacion == 5){
                  parent.location.href='facturas_pendientes.php';
                }
          			
          			return true;
          		} else {
          			return false;
          		}
          	});
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
  
  function procesar_factura_id_2(IdUsua,NoFolio,Total,Forma,Ubicacion){

      var TipoGuardar = "process_fact_id";

      swal({
        title: "\u00BFEst\u00E1 seguro que desea generar esta factura?",
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
                url:"vistas/facturar/setting_facturar2.php",
                method:"POST",
                data:{TipoGuardar:TipoGuardar,IdUsua:IdUsua, NoFolio:NoFolio, Total:Total, Forma:Forma, Ubicacion:Ubicacion},
                success:function(data){ alert(data);

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
                if(Ubicacion == 0){
                  parent.location.href='adFacturas.php';
                }
                if(Ubicacion == 1){
                  parent.location.href='cobrar.php?token=1672771826'+IdUsua;
                }
                if(Ubicacion == 3){
                  parent.location.href='usuarios_externos.php';
                }
          			
          			return true;
          		} else {
          			return false;
          		}
          	});
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
