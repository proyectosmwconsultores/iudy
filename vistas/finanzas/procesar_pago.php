<?php
session_start();
require('../../hace.php');
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];
$IdTemporal = $_POST["IdTemporal"];
$Indicador = $_POST["Indicador"];

$sql_temp = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.IdTemporal =  '$IdTemporal'");
$db->rows($sql_temp);
$_temp = $db->recorrer($sql_temp);
if ($IdUsua == 0) {
?>
  <script>
    function show_UserBuscar(str) {
      var IdTemporal = document.getElementById("IdTemporal").value;
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "getuser.php?Tipo=buscar_datos_alumno&Buscar=" + str + "&IdTemporal=" + IdTemporal, true);
        xmlhttp.send();
      }
    }
  </script>
  <form name="frm2" id="frm2" action="buscarUsuario.php" method="POST" enctype="multipart/form-data">
    <input id="IdTemporal" name="IdTemporal" value="<?php echo $_POST["IdTemporal"]; ?>" type="hidden" />
    <div class="table-responsive">
      <div class="col-md-12">
        <div class="bg-black color-palette" style="padding: 5px;"><span><b>Ordenante: </b><?php echo $_temp['ordenante']; ?> <b>Alfanumérica: </b> <?php echo $_temp['alfanumerica']; ?> </span></div><br>
        <div class="form-group">
          <label>La búqueda puede ser por nombre, apellidos, matrícula:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-user"></i>
            </div>
            <input class="form-control" id="txtBuscar" name="txtBuscar" placeholder="Escriba los datos del alumno" type="text" onKeyUp="show_UserBuscar(this.value)">
          </div>
          <div class="box-body no-padding">
            <div id="txtHint"><br><br><b style=" text-align: center;">El desglose de la b&uacute;squeda se mostrar&aacute; aqu&iacute;...</b></div>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php } else {
  if ($Indicador == 1) {
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Valor = '0', tblp_pagos.Indicador = '0' WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus <> 4");
  }
  $sqle3 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblp_educativa.Clave, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sqle3);
  $datose31 = $db->recorrer($sqle3);
  $IdGrado = $datose31['IdGrado'];
  $Cve = $datose31['Clave'];
  $mto = 0;

  $sql_ban_proc = $db->query("SELECT * FROM tblc_banco_procedencia WHERE tblc_banco_procedencia.Tipo ='1' ORDER BY tblc_banco_procedencia.Banco ASC");

  $sqlT = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.Monto, tblp_pagos.Fecha, tblp_pagos.IdBeca, tblp_pagos.TotalPagado, tblp_pagos.Recargos, tblp_pagos.Descuento, tblp_pagos.Descuento2, tblp_pagos.IdEstatus, tblp_pagos.Valor, tblp_pagos.Indicador, tblc_estatus.Estatus, tblc_conceptosplanes.NomPlan FROM tblp_pagos Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus <> 4 ORDER BY tblp_pagos.Fecha ASC");

  $sql2 = $db->query("SELECT * FROM tblc_formapago");
  $sql_banco = $db->query("SELECT * FROM tblc_bancos WHERE tblc_bancos.IdEstatus = '8'");

  $_imporTemporal = $_temp['Importe'];
?>
  <form name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
    <!-- <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["Token"]; ?>" type="hidden" /> -->
    <input id="IdUsuaCap" name="IdUsuaCap" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
    <input id="valor_banco" name="valor_banco" value="0" type="hidden" />
    <input id="IdTemporal" name="IdTemporal" value="<?php echo $_POST["IdTemporal"]; ?>" type="hidden" />
    <div class="table-responsive">
      <div class="bg-navy color-palette" style="padding: 5px;"><span><b>Nombre: </b> <?php echo $datose31['Nombre'] . ' ' . $datose31['APaterno'] . ' ' . $datose31['AMaterno']; ?></div><br>
      <table class="table table-bordered">
        <div class="box box-primary" style="border-top: none; margin-top: -45px;">
          <table class="table table-striped" style="font-size: 12px;">
            <tbody>
              <tr>
                <th class="text-blue">Ajuste--</th>
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
              $_sig = 0;
              while ($x = $db->recorrer($sqlT)) {
                if ($_sig == 0) {
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
                  $vx = 0;
                  if($sumPagar == $_imporTemporal){
                    $vx = 1;
                  }
              ?>
                  <tr>
                    <td>
                      <?php if ($x["Valor"] == 1) { ?>
                        <button type="button" class="btn bg-purple btn-flat btn-sm" onclick="activarPag(<?php echo $IdPag; ?>,<?php echo $IdUsua; ?>,0,<?php echo $IdTemporal; ?>)"><i class="fa fa-check-circle"></i></button>
                      <?php } else { ?>
                        <button type="button" class="btn bg-red btn-flat btn-sm" onclick="activarPag(<?php echo $IdPag; ?>,<?php echo $IdUsua; ?>,1,<?php echo $IdTemporal; ?>)"><i class="fa fa-times-circle"></i></button>
                      <?php } ?>
                    </td>
                    <td>
                      <?php echo $x["NomPlan"]; ?> / <?php echo obtener_AnioMesMAY($x["Fecha"]); ?><br>
                      <b>Límite:</b> <?php echo obtenerFechaCorta($x["Fecha"]); ?>
                      <?php if (($x["Valor"] == 1) && ($vx == 0)) { ?>
                        <br>
                        <?php if ($x["Indicador"] == 1) {
                          $_abo = 1; ?>
                          <span onclick="activarAbo(<?php echo $IdUsua; ?>,<?php echo $IdPag; ?>,0,<?php echo $IdTemporal; ?>)" style="cursor: pointer;" class="label label-primary"><i class="fa fa-check-circle"></i> Seleccionado</span>
                        <?php } else {
                          $_sum = ($_sum + $total); ?>
                          <span onclick="activarAbo(<?php echo $IdUsua; ?>,<?php echo $IdPag; ?>,1,<?php echo $IdTemporal; ?>)" style="cursor: pointer;" class="label label-danger"><i class="fa fa-times-circle"></i> Seleccionar para abono</span>
                      <?php }
                      } ?>
                    </td>
                    <td style="text-align: right;">$<?php echo number_format($x["Monto"], 2, '.', ','); ?></td>
                    <td style="text-align: right;">$<?php echo number_format($desc, 2, '.', ','); ?></td>
                    <td style="text-align: right;">$<?php echo number_format($recargo, 2, '.', ','); ?>
                      <?php if ($recargo <> 0) { ?> <p style="text-align: center;"><button onclick="del_recargo(<?php echo $IdUsua; ?>,<?php echo $IdPag; ?>,<?php echo $IdTemporal; ?>)" type="button" class="btn btn-danger btn-xs" title="Eliminar recargo"><i class="fa fa-fw fa-trash-o"></i></button></p><?php } ?> </td>
                    <td style="text-align: right;">$<?php echo number_format($abono, 2, '.', ','); ?></td>
                    <td style="text-align: right;"><b>$<?php echo number_format($total, 2, '.', ','); ?></b></td>
                  </tr>
              <?php $sum = ($sum + $total);
                  if ($sum >= $_imporTemporal) {
                   // $_sig = 1;
                  }
                }
              } ?>
              <tr style="background: #003A70; color: white; font-size: 16px; font-weight: bold;">
                <td colspan="5" style="text-align: right;">Total a cobrar:</td>
                <td colspan="2" style="text-align: right;"> $ <?php echo number_format($sumPagar, 2, '.', ','); ?></td>
              </tr>
              <tr style="background: #57AEFF; color: blue; font-size: 16px; font-weight: bold;">
                <td colspan="5" style="text-align: right;">Monto ingresado en el banco:</td>
                <td colspan="2" style="text-align: right;"> $ <?php echo number_format($_imporTemporal, 2, '.', ','); ?></td>
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
                  <input disabled class="form-control" type="text" value="<?php echo $_imporTemporal; ?>" />
                  <input id="txt_monto" class="form-control" name="txt_monto" type="hidden" value="<?php echo $_imporTemporal; ?>" />
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
                  <input disabled type="text" class="form-control pull-right" value="<?php echo $_temp['Fecha']; ?>">
                  <input type="hidden" class="form-control pull-right" id="datepickert5" name="datepickert5" value="<?php echo $_temp['Fecha']; ?>">
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Forma de pago:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <select class="form-control" name="txtFormaT5" id="txtFormaT5">
                      <option class="form-control" value="2"> TRANSFERENCIA </option>
                      <option class="form-control" value="3"> DEPÓSITO </option>
                      <option class="form-control" value="4"> TARJETA DE DÉBITO </option>
                      <option class="form-control" value="5"> TARJETA DE CRÉDITO </option>
                  </select>
                </div>
              </div>
            </div>
            <input type="hidden" class="form-control" name="txt_banco" id="txt_banco" value='3'>
            <input type="hidden" class="form-control" name="txt_procedencia" id="txt_procedencia" value="0">
            <div class="col-md-12">
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
                <!-- <button type="button" class="btn btn-block btn-success" onclick="valMonto()"><i class="fa fa-save"></i> Procesar pago</button> -->
                <button type="button" class="btn btn-block btn-success" onclick="procesar_pago_id_us(<?php echo $_SESSION['IdUsua']; ?>, <?php echo $IdUsua; ?>,<?php echo $IdTemporal; ?>)"><i class="fa fa-save"></i> Procesar pago</button>
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
    function activarAbo(IdUsua, IdPago, Valor, IdTemporal) {
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
          var Indicador = 0;
          $.ajax({
            url: "vistas/finanzas/procesar_pago.php",
            method: "POST",
            data: {
              IdTemporal: IdTemporal,
              IdUsua: IdUsua,
              Indicador: Indicador
            },
            success: function(data) {
              $('#employee_promxi').html(data);
              $('#data_promxi').modal('show');
            }
          });
        }
      })
    }

    function del_recargo(IdUsua, IdPago, IdTemporal) {
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
                var Indicador = 0;
                $.ajax({
                  url: "vistas/finanzas/procesar_pago.php",
                  method: "POST",
                  data: {
                    IdTemporal: IdTemporal,
                    IdUsua: IdUsua,
                    Indicador: Indicador
                  },
                  success: function(data) {
                    $('#employee_promxi').html(data);
                    $('#data_promxi').modal('show');
                  }
                });
              }
            })
          }

        });
    }
    $(function() {

      //Date picker
      $('#datepickert5').datepicker({
        autoclose: true
      })

    })

    function activarPag(IdPago, IdUsua, Valor, IdTemporal) {
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
          var Indicador = 0;
          $.ajax({
            url: "vistas/finanzas/procesar_pago.php",
            method: "POST",
            data: {
              IdTemporal: IdTemporal,
              IdUsua: IdUsua,
              Indicador: Indicador
            },
            success: function(data) {
              $('#employee_promxi').html(data);
              $('#data_promxi').modal('show');
            }
          });
        }
      })
    }
 
    function procesar_pago_id_us(IdAdmin, IdUsua, IdTemporal) {
      var IdUsuaCap = document.getElementById("IdUsuaCap").value;
      var Forma = document.getElementById("txtFormaT5").value;
      var Fecha = document.getElementById("datepickert5").value;
      var TPagar = document.getElementById("TPagar").value;
      var Division = document.getElementById("Division").value;
      var Folio = document.getElementById("txt_recibo").value;
      var Monto = document.getElementById("txt_monto").value;
      var Banco = document.getElementById("valor_banco").value;
      var Nota = document.getElementById("txt_nota").value;
      var IdProcedencia = document.getElementById("txt_procedencia").value;
      var IdBanco = 0;
      var TipoGuardar = "sav_pagos_especial";

      var SelAbono = document.getElementById("_abonSel").value;
      var SumPag = document.getElementById("_sumMon").value;
      Monto = parseFloat(Monto, 2);
      TPagar = parseFloat(TPagar, 2);
      SumPag = parseFloat(SumPag, 2);
      if (Monto == "") {
        swal("Error al procesar", "01_Debe escribir el monto total del pago.", "error");
        return 0;
      }
      if (isNaN(Monto)) {
        swal("Dato err\u00F3neo", "02_El dato ingresado no es un n\u00FAmero.", "error");
        return 0;
      }

      if (Monto > TPagar) {
        swal("Error al procesar", "03_El monto ingresado no debe ser mayor a al monto total.", "error");
        return 0;
      }

      if (Monto < SumPag) {
        swal("Error al procesar", "04_El monto ingresado es mucho menor a los pagos seleccionado, favor de indicar un concepto como abono.", "error");
        return 0;
      }

      if (Monto <= 0) {
        swal("Error al procesar", "05_El n\u00FAmero ingresado no debe ser menor a 0.", "error");
        return 0;
      }

      if (TPagar == 0) {
        swal("Error al guardar", "Debe seleccionar los pagos que va a realizar.", "error");
        return 0;
      }

      swal({
          title: "\u00BFEst\u00E1 seguro que desea guardar estos de este pago?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',

        },
        function(isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');
            var datos = 'TipoGuardar=' + TipoGuardar + '&Forma=' + Forma + '&IdUsua=' + IdUsua + '&Fecha=' + Fecha + '&IdUsuaCap=' + IdUsuaCap + '&Division=' + Division + '&TPagar=' + Monto + '&IdBanco=' + IdBanco + '&Nota=' + Nota + '&IdProcedencia=' + IdProcedencia + '&IdAdmin=' + IdAdmin + '&Folio=' + Folio + '&IdTemporal=' + IdTemporal;

            $.ajax({
                type: "POST",
                url: "insertar.php",
                data: datos,
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Guardado correctamente", "El pago se ha procesado correctamente.", "success");
                  parent.location.href = 'finanzas_conciliar_pagos.php';
                }
                if (data == 2) {
                  swal("Error al procesar", "El folio de recibo ingresado ya existe en la plataforma.", "error");
                  //document.getElementById("frm").reset();

                }
                if (data == 0) {
                  swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });
          }
        });
    }
  </script>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<?php } ?>