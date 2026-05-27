<?php
include('../hace.php');
if(isset($_POST["IdPago"])){

  $IdPago = $_POST["IdPago"];
  $IdGrupo = $_POST["IdGrupo"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();


  $sql9 = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.IdBanco, tblp_pagos.IdConcepto, tblp_pagos.Pagar, tblp_pagos.FecLimPago, tblp_pagos.Recargos, tblp_pagos.IdEstatus, tblp_pagos.IdFormaPago, tblp_pagos.IdTipoDescuento, tblp_pagos.IdDescuento, tblc_conceptos.NomConcepto, tblc_estatus.Estatus FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus WHERE tblp_pagos.IdPago =  '$IdPago'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $rwNomConcepto = $datos91["NomConcepto"];
  $rwNomConcepto = $datos91["NomConcepto"];
  $rwPagar = $datos91["Pagar"];
  $rwRecargo = $datos91["Recargos"];
  $rwFecLimPago = $datos91["FecLimPago"];
  $rwEstatus = $datos91["IdEstatus"];
  $rwIdFormaPag = $datos91["IdFormaPago"];
  $rwIdBanco = $datos91["IdBanco"];
  $tot = $rwPagar + $rwRecargo;

  $sql8 = $db->query("SELECT * FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago =  '$IdPago' AND tblh_detallepagos.Estatus = '2'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $rwIdDetalle = $datos81["IdDetallePagos"];

  $sql7 = $db->query("SELECT tblp_descuento.IdDescuento, tblp_descuento.IdTipoDescuento, tblp_descuento.Porcentaje, tblp_descuento.FecDescuento, tblp_descuento.Descuento, tblp_descuento.FecDescuento, tblc_tipodescuento.NomDescuento FROM tblp_descuento Inner Join tblc_tipodescuento ON tblc_tipodescuento.IdTipoDescuento = tblp_descuento.IdTipoDescuento WHERE tblp_descuento.IdPago = '$IdPago' AND tblp_descuento.Estatus = '8'");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);
  $rxIdDescuento = $datos71["IdDescuento"];
  $rxNomDescuento = $datos71["NomDescuento"];
  $rxDescuento = $datos71["Descuento"];
  $rxPorcentaje = $datos71["Porcentaje"];
  $rxDescuento = $datos71["Descuento"];
  $rxFecDescuento = $datos71["FecDescuento"];
  $hoy = date("Y-m-d");
  $rxValor = 0; $vDesc = 0;
  if($rxFecDescuento >=$hoy){
    $rxValor = 1;
  } else {
    $rxValor = 0;
  }
  if($rxIdDescuento){ $vDesc = 1;}  else { $vDesc = 0; }

  if(($rxIdDescuento) && ($rxValor == 1)){
    $estilo1 = ' ';
    $estilo2 = " style='background: #79797e; color: #000;' ";
  }else{
    $estilo1 = " style='background: #b6b6b7; color: #1a0a0a;' ";
    $estilo2 = ' ';
  }


//echo $rxValor.'-'.$vDesc;
  $sql = $db->query("SELECT * FROM tblc_estatus WHERE tblc_estatus.Fase1 = '1'");

  $sqlB = $db->query("SELECT * FROM tblc_bancos");

  $sql2 = $db->query("SELECT * FROM tblc_formapago");


  $output .= '
  <form name="frm2" id="frm2" action="totalPagar.php" method="POST" enctype="multipart/form-data">
              <div class="box-body no-padding">
                <table class="table table-striped">
                  <tbody><tr>
                    <th>Descripción</th>
                    <th width="150px;">Monto</th>
                  </tr>
                  <tr>
                    <td>'.$rwNomConcepto.' / pagar antes del ('.$rwFecLimPago.')</td>
                    <td>$ '.number_format($rwPagar, 2, '.', ',').'</td>
                  </tr>
                  ';
                  if($rwRecargo){
                  $output .= '
                  <tr>
                    <td>Recargo</td>
                    <td>$ '.number_format($rwRecargo, 2, '.', ',').'</td>
                  </tr>
                  ';
                  }
                  $output .= '
                  <tr '.$estilo1.'>
                    <td style="text-align: right;"><b>Total a Pagar</b></td>
                    <td><b>$ '.number_format($tot, 2, '.', ',').'</b></td>
                  </tr>

                  ';
                  if(($rxValor == 0) && ($vDesc==1)){    $output .= '
                    <tr>
                      <td colspan="2" style="text-align: center;">
                      ';
                      if($rwEstatus != 4){ $output .='

                      ';
                    }
                      $output .='
                      &nbsp;&nbsp; *'.$rxNomDescuento.' del '.$rxPorcentaje.' % / <br> pagar antes del ('.$rxFecDescuento.'), $ - '.number_format($rxDescuento, 2, '.', ',').' <b style="color: red;">(EXPIRADO)</b></td>

                    </tr>
                    ';
                  }
                  if(($rxIdDescuento) && ($rxValor==1)){ $sumTotalP = $tot - $rxDescuento;
                  $output .= '
                  <tr>
                    <td>';
                    if($rwEstatus != 4){ $output .='
                    
                    ';
                  }
                    $output .='
                    &nbsp;&nbsp; *'.$rxNomDescuento.' del '.$rxPorcentaje.' % / pagar antes del ('.$rxFecDescuento.')</td>
                    <td>$ - '.number_format($rxDescuento, 2, '.', ',').'</td>
                  </tr>
                  <tr '.$estilo2.'>
                    <td style="text-align: right;">&nbsp;&nbsp; <b>Total a Pagar</b></td>
                    <td><b style="color: #000;">$ '.number_format($sumTotalP, 2, '.', ',').' </b></td>
                  </tr>
                  ';
                  }
                  $output .= '

                </tbody></table>
              </div>

            ';
            if($rwEstatus != 4){ if($sumTotalP) { $txtT = $sumTotalP; } else { $txtT = $tot; }
            $output .= '
            <input type="hidden" class="form-control pull-right" id="MonTotal" name="MonTotal" value="'.$txtT.'">

              <div class="box-body">






              </div>


                                ';
                              }
                                $output .= '



  </form>';
  echo $output;
}
?>
