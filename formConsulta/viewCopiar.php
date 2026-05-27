<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $IdParcialDoc = $_POST["IdParcialDoc"];
  $IdUsua = $_SESSION["IdUsua"];

  $sql1 = $db->query("SELECT tblp_parcialdocente.IdModulo, tblp_parcialdocente.NoParcial FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc' ");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $IdModulo = $datos11["IdModulo"];
  $noParcial = $datos11["NoParcial"];

  $sql = $db->query("SELECT
tblp_actividadesdocente.IdActividadesDocente,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.DesActividad,
tblp_parcialdocente.IdParcialDocente
FROM
tblp_actividadesdocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
WHERE
tblp_actividadesdocente.IdModulo =  '$IdModulo' AND
tblp_actividadesdocente.IdTipoActividad =  '1' AND
tblp_parcialdocente.NoParcial =  '$noParcial'
");

//
  ?>
  <section class="content">
    <form name="frm" id="frm" action="doMiPlaneacion.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
    <div class="row">

      <?php while($x = $db->recorrer($sql)){ $IdParcial = $x["IdParcialDocente"];  if($IdParcialDoc <> $IdParcial) {
        $IdActividadDocNew = $x["IdActividadesDocente"];
        $sql3 = $db->query("SELECT tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo FROM tblp_exampregunta WHERE tblp_exampregunta.IdParcialDocente = '$IdParcial' AND tblp_exampregunta.IdActividadesDocente = '$IdActividadDocNew' ");

        ?>
      <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-copy"></i>
              <h3 class="box-title"><?php echo $x["NomActividad"]; ?></h3>
            </div>
            <div class="box-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th>Pregunta</th>
                    <th>Tipo</th>
                  </tr>
                  <?php while($y = $db->recorrer($sql3)){ ?>
                <tr>
                  <td><?php echo $y["Pregunta"]; ?></td>
                  <td><?php if($y["Tipo"] == "O"){ echo "Opción multiple"; } else { echo "Abierta"; } ?></td>
                </tr>
                <?php } ?>
              </tbody></table>

            </div>

            <button onclick="copiarExamen(<?php echo $IdParcialDoc; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdActividadDocNew; ?>)" type="button" class="btn btn-block btn-success btn-xs">Copiar examen</button>
          </div>

        </div>
      <?php } } ?>

        <?php if(!$IdParcial){ ?>


                <a class="btn btn-block btn-social btn-google">
                          <i class="fa fa-info-circle"></i> No existen parciales creados anteriormente.
                        </a>
              <?php } ?>
    </div>
  </form>



      </section>
