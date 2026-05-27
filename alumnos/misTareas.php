<?php session_start();
  require('../php/clases/class.System.php');
  include('fecha.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];
   $IdUsua = $_SESSION['IdUsua'];
  $sql_tar = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.IdParcialDocente,
tblp_actividadesdocente.IdSemanaDocente,
tblp_actividadesdocente.IdTipoActividad,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.IdEstatus,
tblp_actividadesdocente.FecIni,
tblp_actividadesdocente.FecFin,
tblp_actividadesdocente.Modalidad,
tblp_actividadesdocente.Porcentaje,
tblc_estatus.Estatus,
tblp_semanadocente.NoSemana,
tblp_parcialdocente.NoParcial
FROM
tblp_actividadesdocente
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
WHERE tblp_actividadesdocente.IdAsignacion = '$idAsignacion' AND tblp_actividadesdocente.IdEstatus <> '12'
ORDER BY
tblp_parcialdocente.NoParcial ASC, tblp_actividadesdocente.FecFin ASC");

  ?>

            <div class="box-header with-border">
              <h3 class="box-title"><i class="ion ion-clipboard"></i> Lista de tareas</h3>

            </div>
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr style="background: #8d9093;">
                    <td colspan="2">Tarea</td>
                    <td>Estatus</td>
                    <td style="width: 100px;">Comienza</td>
                    <td style="width: 100px;">Finaliza</td>
                    <td style="text-align: center;">Porcentaje</td>
                    <td style="text-align: center;">Calificación</td>
                  </tr>

                  <?php $sumP = 0; $nP = 0;
                    $pi = 0; $pf = 0; $ci = 0; $cf = 0; $por = 0; $cal = 0; $miCal = 0;
                    while($xx = $db->recorrer($sql_tar)){ $IdAc = $xx['IdActividadesDocente']; $nP = $xx['NoParcial'];
                      $sql8 = $db->query("SELECT tblp_tareas.Calificacion FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$idAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdAc' AND tblp_tareas.IdAlumno= '$IdUsua'");
                      $db->rows($sql8);
                      $datos81 = $db->recorrer($sql8);
                      $cal = $datos81["Calificacion"];

                    $idT = $xx['IdTipoActividad']; $pi = $xx['NoParcial']; $ci = $xx['NoParcial'];
                    if($idT == 1){ $ico_ = 'fa-question-circle'; } elseif($idT == 2){ $ico_ = 'fa-comments'; }elseif($idT == 3){ $ico_ = 'fa-upload'; } ?>

                    <?php if(($ci <> $cf) && ($cf <> 0)){   ?>
                    <tr>
                      <td colspan="6" style="text-align: right;"><b>Calificación del <?php echo $_SESSION['_txt']; ?>:</b></td>
                      <td style="text-align: center;"><b><?php echo $miCal; $sumP = ($sumP + $miCal); ?></b></td>
                    </tr><?php $por = 0; $miCal = 0; } ?>
                  <?php if($pi <> $pf){  ?>
                   <tr style="background: #e0e2e4;">
                     <td colspan="7"><?php echo $_SESSION['_txt']; ?> <?php echo $xx['NoParcial'];  ?></td>
                   </tr><?php } ?>
                  <tr>
                    <td><i class="fa <?php echo $ico_; ?>"></td>
                    <td>
                      <?php if($idT == 1){ ?>
                        <a href="javascript:void(0);"><?php echo $xx['NomActividad']; ?></a>
                      <?php } elseif($idT == 2){ ?>
                        <a onclick="TareamiForo(<?php echo $xx['IdParcialDocente']; ?>,<?php echo $xx['IdSemanaDocente']; ?>,<?php echo $xx['NoSemana']; ?>,<?php echo $xx['IdActividadesDocente']; ?>)" href="javascript:void(0);"><?php echo $xx['NomActividad']; ?></a>
                      <?php } elseif($idT == 3){ ?>
                        <a onclick="subirTareaLts(<?php echo $xx['IdParcialDocente']; ?>,<?php echo $xx['IdSemanaDocente']; ?>,<?php echo $xx['NoSemana']; ?>,<?php echo $xx['IdActividadesDocente']; ?>)" href="javascript:void(0);"><?php echo $xx['NomActividad']; ?></a>
                      <?php } ?>
                    </td>
                    <td><?php echo $xx['Estatus']; ?></td>
                    <td><?php echo fechaMes($xx['FecIni']); ?></td>
                    <td><?php echo fechaMes($xx['FecFin']); ?></td>
                    <td style="text-align: center;"><?php echo $cal.'/'.$xx['Porcentaje']; ?></td>
                    <td style="text-align: center;"><?php echo $cal; ?></td>
                  </tr>

                  <?php $miCal = ($miCal + $cal);
                  $por = ($por + $xx['Porcentaje']); $pf = $xx['NoParcial']; $cf = $xx['NoParcial'];
                  } ?>
                  <tr>
                    <td colspan="6" style="text-align: right;"><b>Calificación del <?php echo $_SESSION['_txt']; ?>:</b></td>
                    <td style="text-align: center;"><b><?php echo $miCal; $sumP = ($sumP + $miCal); ?></b></td>
                  </tr>
                  <tr>
                    <td colspan="6" style="text-align: right;"><b>Calificación final:</b></td>
                    <td style="text-align: center;"><b><?php $pp = ($sumP/$nP); echo round($pp,1); ?></b></td>
                  </tr>

                  </tbody>
                </table>
              </div>
            </div>


  <div id="dataModal_Rec" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
             <div class="modal-content">
                  <div class="modal-body" id="employee_detail_Rec">
                  </div>
             </div>
        </div>
   </div>

<script>
$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewVideo.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail_Rec').html(data);
												 $('#dataModal_Rec').modal('show');
										}
							 });
					}
		 });
});
</script>
