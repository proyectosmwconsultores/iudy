<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCampus = substr($_GET["idCa"], 10,10);
  $IdEstatus = substr($_GET["idEs"],10,10);
  $hoy = date("Y-m-d");

  $sqlH = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

$sql_res = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_pagos.IdCiclo,
tblp_pagos.IdGrupo,
tblp_pagos.Fecha,
tblp_pagos.Monto,
tblp_pagos.Recargos,
tblp_pagos.TotalPagado,
tblp_pagos.Descuento,
tblc_ciclo.Ciclo,
tblp_educativa.Nombre AS Educativa,
tblp_pagos.IdOferta
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
WHERE
tblp_pagos.IdEstatus =  '1' AND
tblp_pagos.IdConcepto <=  '3' AND
tblp_pagos.IdCampus =  '$IdCampus' AND
tblp_pagos.Fecha <=  '$hoy' AND ((tblc_usuario.IdEstatus =  '8') || (tblc_usuario.IdEstatus =  '55') || (tblc_usuario.IdEstatus =  '61') || (tblc_usuario.IdEstatus =  '62'))
ORDER BY
tblp_pagos.IdOferta ASC,
tblp_pagos.IdGrupo ASC
");




?>

   <style>
   table {
       font-family: arial, sans-serif;
       border-collapse: collapse;
       width: 100%;
   		font-size: 12px;
   }

   td, th {
       border: 1px solid #dddddd;
       padding: 3px;
   }
   tr:nth-child(even) {
       background-color: #dddddd;
   }
   </style>
   <title>Reporte de saldos vencidos</title>
  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
    <div class="table-responsive">
          <div class="box-body">
          <div class="col-md-12">

		  <table>
              <tr style="background: gray; padding: 15px; text-align: center; font-size: 15px; ">
                <td colspan="10" style="padding: 5px;">
                    <b>RESULTADO DE SALDOS VENCIDOS A LA FECHA <br>
                      CAMPUS <?php echo $datos81['Campus']; ?></b>
                </td>

              </tr>
              <tr>
                <td colspan="10" style="padding: 5px; text-align: right;">
                    <b>Fecha de impresión: <?php echo date("Y-m-d H:m:s");; ?></b>
                </td>
              </tr>
              <tr style="background: gray;">
				<td style="width: 10px;  text-align: center;">No.</td>
				<td style="width: 100px; border-right: none;">Ciclo / Plan de pago</td>
				<td style="width: 50px;  border-right: none;">No. Control</td>
				<td style="width: 115px; ">Nombre del alumno</td>
				<td style="width: 85px; ">Fec. Vencimiento</td>
				<td style="width: 75px; text-align: center; ">Adeudo</td>
				<td style="width: 75px; text-align: center; ">Beca</td>
				<td style="width: 75px; text-align: center; ">Recargo</td>
				<td style="width: 75px; text-align: center; ">Abono</td>
				<td style="width: 75px; text-align: center; ">Adeudo total</td>
			</tr>
			<?php $sumT = 0; $c = 0; $smont = 0; $sbeca = 0; $sreca= 0; $sabono = 0; $oi = 0; $of = 0;
			while($_res = $db->recorrer($sql_res)){
				$total = ($_res['Monto'] + $_res['Recargos'] - $_res['Descuento'] - $_res['TotalPagado']);
				$sumT = ($sumT + $total);
				$smont = ($smont + $_res['Monto']);
				$sbeca = ($sbeca + $_res['Descuento']);
				$sreca = ($sreca + $_res['Recargos']);
				$sabono = ($sabono + $_res['TotalPagado']);
				$oi = $_res['IdOferta'];
				if($oi <> $of){ ?>
			<tr>
                <td colspan="10" style="padding: 5px; text-align: left; background: #c0b3ff;">
                    <b><?php echo $_res['Educativa']; ?></b>
                </td>
              </tr>
				<?php }
				?>
			<tr>
				<td style="width: 10px;  text-align: center;"><b><?php  echo $c = ($c + 1); ?></b>.-</td>
				<td style="width: 100px; border-right: none;"><?php echo $_res['Ciclo']; ?></td>
				<td style="width: 50px;  border-right: none;"><?php echo $_res['Usuario']; ?></td>
				<td style="width: 115px; "><?php echo $_res['APaterno'].' '.$_res['AMaterno'].' '.$_res['Nombre']; ?></td>
				<td style="width: 85px; "><?php echo $_res['Fecha']; ?></td>
				<td style="width: 75px; text-align: center; ">$ <?php echo number_format($_res['Monto'], 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: center; ">$ <?php echo number_format($_res['Descuento'], 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: center; ">$ <?php echo number_format($_res['Recargos'], 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: center; ">$ <?php echo number_format($_res['TotalPagado'], 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: center; ">$ <?php echo number_format($total, 2, '.', ',');  ?></td>
			</tr>
			<?php $of = $_res['IdOferta']; } ?>
			<tr style="background: gray;">
				<td colspan="5" style="width: 10px;  text-align: right;"><b>TOTAL: </b></td>
				<td style="width: 75px; text-align: center; background: yellow; "><b>$ <?php echo number_format($smont, 2, '.', ',');  ?></b></td>
				<td style="width: 75px; text-align: center; background: yellow; "><b>$ <?php echo number_format($sbeca, 2, '.', ',');  ?></b></td>
				<td style="width: 75px; text-align: center; background: yellow; "><b>$ <?php echo number_format($sreca, 2, '.', ',');  ?></b></td>
				<td style="width: 75px; text-align: center; background: yellow; "><b>$ <?php echo number_format($sabono, 2, '.', ',');  ?></b></td>
				<td style="width: 75px; text-align: center; background: yellow;"><b>$ <?php echo number_format($sumT, 2, '.', ',');  ?></b></td>
			</tr>
          	</table>
              </div>
          </div>
    </div>
  </form>
