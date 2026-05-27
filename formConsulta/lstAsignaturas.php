<?php

  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdUsua,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.Estatus,
tblp_asignacion.FecCap,
tblp_educativa.IdEducativa,
tblp_educativa.Nombre AS NomEducativa,
tblp_modulo.NombreMod,
tblp_modulo.CodeModulo,
tblp_grupo.CveGrupo,
tblp_grupo.Grupo,
tblc_ciclo.Ciclo,
tblp_modulo.Oferta,
tblp_planeacion.Planeacion
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo AND tblp_modulo.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblp_planeacion ON tblp_planeacion.IdAsignacion = tblp_asignacion.IdAsignacion
WHERE
tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdUsua = '".$_POST["employee_id"]."' ORDER BY
tblp_asignacion.IdEducativa ASC");

  ?>
  <form name="frm2" id="frm2" action="lstAsignaturas.php" method="POST" enctype="multipart/form-data">
    <div class="row">
    <div class="col-xs-12">

            <div class="box-body table-responsive no-padding">


              <table class="table table-striped">
                <tbody>
                  <?php $ini = 0; $grado = 1; $valor = 0;
                   while($x = $db->recorrer($sql)){

                    if($grado == $x["IdEducativa"]){ $ini = 1; } else { $ini = 0; } ?>
                    <?php if(($ini == 0) || ($valor == 0)){ ?>
                    <tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
                      <th colspan="6"><?php echo $x["Oferta"].' - '.$x["NomEducativa"] ?></th>
                    </tr>
                    <tr style="background: #e1dede; color: #000; font-size: 12px;">
                      <th>Planeaci&oacute;n</th>
                      <th>Asignatura</th>
                      <th>Fecha</th>
                      <th>Estatus</th>
                      <th>Ciclo</th>
                      <th>CveGrupo</th>
                    </tr> <?php } ?>
                    <tr style="font-size: 12px;">
                      <td><?php echo $x["Planeacion"]; ?></td>
                      <td><?php echo $x["CodeModulo"].' '.$x["NombreMod"]; ?></td>
                      <td><?php echo $x["FecIni"].' - '.$x["FecFin"]; ?></td>
                      <td><?php echo $x["Estatus"]; ?></td>
                      <td><?php echo $x["Ciclo"]; ?></td>
                      <td><?php echo $x["CveGrupo"].' '.$x["Grupo"]; ?></td>
                    </tr>
                <?php $valor = 1; $grado = $x["IdEducativa"]; } ?>
              </tbody></table>
            </div>

        </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-success" onClick="window.open('formConsulta/expHistorialDocentes.php?Id=<?php echo $_POST["employee_id"]; ?>','_self')" href="javascript:void(0);">Descargar</button>
          <button type="button" class="btn btn-info" data-dismiss="modal">Salir</button>


        </div>

  </form>

  <!-- <table class="table table-hover">
    <tbody><tr>
      <th>Oferta</th>
      <th>Asignatura</th>
      <th>Fecha</th>
      <th>Estatus</th>
      <th>CveGrupo</th>
    </tr>
    <?php // while($x = $db->recorrer($sql)){ ?>
    <tr>
      <td style="font-size: 11px;"><?php echo $x["NomEducativa"]; ?></td>
      <td style="font-size: 11px;"><?php echo $x["NombreMod"]; ?></td>
      <td style="font-size: 11px;"><?php echo $x["FecIni"].' - '.$x["FecFin"]; ?></td>
      <td style="font-size: 11px;"><?php echo $x["Estatus"]; ?></td>
      <td style="font-size: 11px;"><?php echo $x["CveGrupo"].' '.$x["Grupo"]; ?></td>
    </tr>
    <?php //} ?>
  </tbody></table> -->
