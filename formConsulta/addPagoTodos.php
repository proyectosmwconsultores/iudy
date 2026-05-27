<?php
session_start();
require('../hace.php');
require('../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = substr($_POST["Token"], 10, 10);



$sqle3 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblp_educativa.Clave, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
$db->rows($sqle3);
$datose31 = $db->recorrer($sqle3);
$IdGrado = $datose31['IdGrado'];
$Cve = $datose31['Clave'];
$mto = 0;

$sql_ban_proc = $db->query("SELECT * FROM tblc_banco_procedencia WHERE tblc_banco_procedencia.Tipo ='1' ORDER BY tblc_banco_procedencia.Banco ASC");

$sqlT = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.Monto, tblp_pagos.Fecha, tblp_pagos.IdBeca, tblp_pagos.TotalPagado, tblp_pagos.Recargos, tblp_pagos.Descuento, tblp_pagos.Descuento2, tblp_pagos.IdEstatus, tblp_pagos.Valor, tblp_pagos.Indicador, tblc_estatus.Estatus, tblc_conceptosplanes.NomPlan FROM tblp_pagos Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus = '1' ORDER BY tblp_pagos.Fecha ASC");

$sql2 = $db->query("SELECT * FROM tblc_formapago WHERE tblc_formapago.tipo = '1' ");
$sql_banco = $db->query("SELECT * FROM tblc_bancos WHERE tblc_bancos.IdEstatus = '8'");

?>
<form name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
  <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["Token"]; ?>" type="hidden" />
  <input id="IdUsuaCap" name="IdUsuaCap" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
  <input id="TipoGuardar" name="TipoGuardar" value="savTodosP" type="hidden" />
  <input id="valor_banco" name="valor_banco" value="0" type="hidden" />

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -45px;">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr>
              <th class="text-blue">Ajuste</th>
              <th class="text-blue">Concepto</th>
              <th class="text-blue" style="width: 75px; text-align: right;">Monto</th>
              <th class="text-blue" style="width: 50px; text-align: right;">Descuento</th>
              <th class="text-blue" style="width: 50px; text-align: right;">Recargo</th>
              <th class="text-blue" style="width: 65px; text-align: right;">Abono</th>
              <th class="text-blue" style="width: 75px; text-align: right;">Deuda</th>
            </tr>
            <?php $sumPagar = 0;
            $sum = 0;
            $division = 0;
            $_abo = 0;
            $_sum = 0;
            while ($x = $db->recorrer($sqlT)) {
              $IdPag = $x["IdPago"];
              $recargo = $x["Recargos"];
              $desc = ($x["Descuento"] + $x["Descuento2"]);
              $totalG = ($x["Monto"] - $x["Descuento"] - $x["Descuento2"]);
              $abono = ($x["TotalPagado"]);
              $total = ($totalG + $recargo - $abono);

              if ($x["Valor"] == 1) {
                $sumPagar = ($sumPagar + $total);
                $division = $division + 1;
              }

            ?>
              <tr>
                <td>
                  <?php if ($x["Valor"] == 1) { ?>
                    <button type="button" class="btn bg-purple btn-flat btn-sm" onclick="activarPag(<?php echo $IdPag; ?>,<?php echo $IdUsua; ?>,0)"><i class="fa fa-check-circle"></i></button>
                  <?php } else { ?>
                    <button type="button" class="btn bg-red btn-flat btn-sm" onclick="activarPag(<?php echo $IdPag; ?>,<?php echo $IdUsua; ?>,1)"><i class="fa fa-times-circle"></i></button>
                  <?php } ?>
                </td>
                <td>
                  <?php echo $x["NomPlan"]; ?> / <?php echo obtener_AnioMesMAY($x["Fecha"]); ?><br>
                  <b>Límite:</b> <?php echo obtenerFechaCorta($x["Fecha"]); ?>
                  <?php if ($x["Valor"] == 1) { ?>
                    <br>
                    <?php if ($x["Indicador"] == 1) {
                      $_abo = 1; ?>
                      <span onclick="activarAbo(<?php echo $IdUsua; ?>,<?php echo $IdPag; ?>,0)" style="cursor: pointer;" class="label label-primary"><i class="fa fa-check-circle"></i> Seleccionado</span>
                    <?php } else {
                      $_sum = ($_sum + $total); ?>
                      <span onclick="activarAbo(<?php echo $IdUsua; ?>,<?php echo $IdPag; ?>,1)" style="cursor: pointer;" class="label label-danger"><i class="fa fa-times-circle"></i> Seleccionar para abono</span>
                  <?php }
                  } ?>
                </td>
                <td style="text-align: right;">$<?php echo number_format($x["Monto"], 2, '.', ','); ?></td>
                <td style="text-align: right;">$<?php echo number_format($desc, 2, '.', ','); ?></td>
                <td style="text-align: right;">$<?php echo number_format($recargo, 2, '.', ','); ?>
                  <?php if ($recargo <> 0) { ?> <p style="text-align: center;"><button onclick="del_recargo(<?php echo $IdUsua; ?>,<?php echo $IdPag; ?>)" type="button" class="btn btn-danger btn-xs" title="Eliminar recargo"><i class="fa fa-fw fa-trash-o"></i></button></p><?php } ?> </td>
                <td style="text-align: right;">$<?php echo number_format($abono, 2, '.', ','); ?></td>
                <td style="text-align: right;"><b>$<?php echo number_format($total, 2, '.', ','); ?></b></td>
                <?php if($total == 0){ $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '4' WHERE tblp_pagos.IdPago= '$IdPag' "); } ?>
              </tr>
            <?php $sum = ($sum + $total); } ?>
            <tr style="background: #003A70; color: white; font-size: 16px; font-weight: bold;">
              <td colspan="5" style="text-align: right;">Total a cobrar:</td>
              <td colspan="2" style="text-align: right;"> $ <?php echo number_format($sumPagar, 2, '.', ','); ?></td>
            </tr>
            <tr>
              <td colspan="7" style="text-align: right;">
              </td>
            </tr>
          </tbody>
        </table>

        <?php if ($sumPagar) { ?>
          <p style="text-align: left;"><b style="color: red;">Nota:</b> el rango del monto a pagar según lo seleccionado seria de $ <?php echo number_format($_sum); ?>.00 a $ <?php echo number_format($sumPagar); ?>.00</p>
          <input id="_sumMon" class="form-control" name="_sumMon" value="<?php echo $_sum; ?>" type="hidden" />
          <input id="_abonSel" class="form-control" name="_abonSel" value="<?php echo $_abo; ?>" type="hidden" />
          <input id="Division" class="form-control" name="Division" value="<?php echo $division; ?>" type="hidden" />
          <input id="MTotal" class="form-control" name="MTotal" value="<?php echo $sumPagar; ?>" type="hidden" />
          <input id="TPagar" class="form-control" name="TPagar" value="<?php echo $sumPagar; ?>" type="hidden" />

          <input id="txt_recibo" class="form-control" value="0" name="txt_recibo" type="hidden" />

          <div class="col-md-4">
            <div class="form-group">
              <label>Monto a pagar:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                </div>
                <input id="txt_monto" class="form-control" name="txt_monto" onchange="valMonto()" type="text" />
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Fecha de pago:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepickert5" name="datepickert5">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Seleccione tipo de pago:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-dollar"></i>
                </div>
                <select class="form-control" name="txtFormaT5" id="txtFormaT5" onchange="sel_tipo_pago()">
                  <option value=""> - Seleccione - </option>
                  <?php
                  while ($x2 = $db->recorrer($sql2)) {
                    $IdForma = $x2["IdFormaPago"];
                    $Pago = $x2["Descripcion"]; ?>
                    <option class="form-control" value="<?php echo $IdForma ?>"> <?php echo $Pago; ?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div style="display: none; " id='div_banco_p'>
            <div class="col-md-4">
              <div class="form-group">
                <label>Banco de procedencia:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-file"></i>
                  </div>
                  <select class="form-control" name="txt_procedencia" id="txt_procedencia"> 
                    <?php while ($_banc_proc = $db->recorrer($sql_ban_proc)) {  ?>
                      <option class="form-control" value="<?php echo $_banc_proc['IdProcedencia'] ?>"> <?php echo $_banc_proc['Banco']; ?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Banco Institución:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-file"></i>
                  </div>
                  <select class="form-control" name="txt_banco" id="txt_banco">
                    <?php while ($_banco = $db->recorrer($sql_banco)) {  ?>
                      <option class="form-control" value="<?php echo $_banco['IdBanco'] ?>"> <?php echo $_banco['Nombre']; ?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Nota:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-file"></i>
                </div>
                <input type="text" name="txt_nota" id="txt_nota" class="form-control">
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group"><br>
              <button type="button" class="btn btn-block btn-success" onclick="val_cerrarPagoT(<?php echo $_SESSION['IdUsua']; ?>)"><i class="fa fa-save"></i> Procesar pago</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <br>
              <hr>
            </div>
          </div>
        <?php } ?>
      </div>
  </div>
  </table>
  </div>
</form>
<script>
  function activarAbo(IdUsua, IdPago, Valor) {
    var TipoGuardar = "sel_Abono";
    var Token = '8420159645' + IdUsua;
    $.ajax({
      url: "formConsulta/setting.php",
      method: "POST",
      data: {
        TipoGuardar: TipoGuardar,
        IdUsua: IdUsua,
        IdPago: IdPago,
        Valor: Valor
      },
      success: function(data) {
        $.ajax({
          url: "formConsulta/addPagoTodos.php",
          method: "POST",
          data: {
            Token: Token
          },
          success: function(data) {
            $('#employee_detail7T').html(data);
            $('#dataModal7T').modal('show');
          }
        });
      }
    })
  }

  function del_recargo(IdUsua, IdPago) {
    var TipoGuardar = "del_recargo_id";
    var Token = '8420159645' + IdUsua;

    swal({
        title: "\u00BFEst\u00E1 seguro que desea eliminar el recargo de esta pago?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
            url: "formConsulta/setting.php",
            method: "POST",
            data: {
              TipoGuardar: TipoGuardar,
              IdPago: IdPago
            },
            success: function(data) {
              $.ajax({
                url: "formConsulta/addPagoTodos.php",
                method: "POST",
                data: {
                  Token: Token
                },
                success: function(data) {
                  $('#employee_detail7T').html(data);
                  $('#dataModal7T').modal('show');
                }
              });
            }
          })
        }

      });
  }



  function valMonto() {
    var Monto = document.getElementById("txt_monto").value;
    var Total = document.getElementById("TPagar").value;
    var SelAbono = document.getElementById("_abonSel").value;
    var SumPag = document.getElementById("_sumMon").value;
    Monto = parseFloat(Monto, 2);
    Total = parseFloat(Total, 2);
    SumPag = parseFloat(SumPag, 2);
    // alert(Monto);
    // alert(Total);
    if (Monto == "") {
      swal("Error al procesar", "01_Debe escribir el monto total del pago.", "error");
      document.getElementById("txt_monto").value = "";
      document.getElementById("txt_monto").focus();
      return 0;
    }
    if (isNaN(Monto)) {
      swal("Dato err\u00F3neo", "02_El dato ingresado no es un n\u00FAmero.", "error");
      document.getElementById("txt_monto").value = "";
      document.getElementById("txt_monto").focus();
      return 0;
    }
    if (Monto > Total) {
      swal("Error al procesar", "03_El monto ingresado no debe ser mayor a al monto total.", "error");
      document.getElementById("txt_monto").value = "";
      document.getElementById("txt_monto").focus();
      return 0;
    }
    if (Monto < SumPag) {
      swal("Error al procesar", "04_El monto ingresado es mucho menor a los pagos seleccionado.", "error");
      document.getElementById("txt_monto").value = "";
      document.getElementById("txt_monto").focus();
      return 0;
    }
    if (Monto <= 0) {
      swal("Error al procesar", "05_El n\u00FAmero ingresado no debe ser menor a 0.", "error");
      document.getElementById("txt_monto").value = "";
      document.getElementById("txt_monto").focus();
      return 0;
    }
  }

  function descuento() {
    var Descuento = document.getElementById("txtDescuento").value;
    var Monto = document.getElementById("MTotal").value;
    var Pagar = (Monto - Descuento);
    //alert(Pagar);

    document.getElementById("TPagar").value = Pagar;
    document.getElementById("txtPago").value = Pagar;

  }

  $(function() {

    //Date picker
    $('#datepickert5').datepicker({
      autoclose: true
    })

  })

  function activarPag(IdPago, IdUsua, Valor) {
    var TipoGuardar = "add_actPago";
    var Token = "1000254780" + IdUsua;
    $.ajax({
      url: "formConsulta/setting.php",
      method: "POST",
      data: {
        TipoGuardar: TipoGuardar,
        IdPago: IdPago,
        IdUsua: IdUsua,
        Valor: Valor
      },
      success: function(data) {
        $.ajax({
          url: "formConsulta/addPagoTodos.php",
          method: "POST",
          data: {
            Token: Token
          },
          success: function(data) {
            $('#employee_detail7T').html(data);
            $('#dataModal7T').modal('show');
          }
        });
      }
    })
  }

  function sel_tipo_pago() {

    var tipoPago = document.getElementById("txtFormaT5").value;
    if (tipoPago == 1) {
      document.getElementById("div_banco_p").style.display = 'none';
      document.getElementById("valor_banco").value = '0';
    } else {
      document.getElementById("div_banco_p").style.display = 'block';
      document.getElementById("valor_banco").value = '1';
    }
  }
</script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->