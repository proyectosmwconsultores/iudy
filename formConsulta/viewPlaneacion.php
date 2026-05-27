<?php
session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdParcial = $_POST["IdParcial"];
  $IdOferta = $_POST["IdOferta"];
  $IdModulo = $_POST["IdModulo"];
  $sql = $db->query("SELECT * FROM tblp_semana WHERE tblp_semana.IdParcial = '$IdParcial' AND tblp_semana.IdOferta = '$IdOferta' AND tblp_semana.IdModulo = '$IdModulo'");

//
  ?>
  <form name="frm2" id="frm2" action="viewPlaneacion.php" method="POST" enctype="multipart/form-data">
    <input id="IdOferta" name="IdOferta" value="<?php echo $_POST["IdOferta"]; ?>" type="hidden"/>
    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>

    <ul class="timeline timeline-inverse">

    <?php while($x = $db->recorrer($sql)){ $IdSemana = $x["IdSemana"];
      $sql2 = $db->query("SELECT tblp_actividades.IdActividades, tblp_actividades.NomActividad, tblp_actividades.DesActividad, tblc_tipoactividad.TipoActividad FROM tblp_actividades Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividades.IdTipoActividad WHERE tblp_actividades.IdParcial = '$IdParcial' AND tblp_actividades.IdSemana = '$IdSemana'");
       ?>
    <li class="time-label">
          <span class="bg-red">
            Semana <?php echo $x["NoSemana"]; ?>
          </span>
    </li>

    <li>
      <i class="fa fa-bookmark bg-blue"></i>

      <div class="timeline-item">
        <div class="timeline-body">
          <?php echo $x["Temas"]; ?>
        </div>
      </div>
    </li>
    <?php while($y = $db->recorrer($sql2)){ ?>

    <li>
      <i class="fa fa-map-signs bg-green"></i>
      <div class="timeline-item">
        <span class="time"><i class="fa fa-bell"></i> <?php echo $y["TipoActividad"]; ?></span>

        <h3 class="timeline-header"><?php echo $y["NomActividad"]; ?></h3>

        <div class="timeline-body">
          <?php echo $y["DesActividad"]; ?>
        </div>

      </div>
    </li>
  <?php }  } ?>
  <?php if($IdSemana){ ?>

  <a class="btn btn-block btn-social btn-bitbucket" onclick="copiarPlaneacion(<?php echo $IdParcial; ?>)">
            <i class="fa fa-copy"></i> Copiar Planeaci&oacute;n del parcial
          </a>
        <?php } else { ?>
          <a class="btn btn-block btn-social btn-google">
                    <i class="fa fa-info-circle"></i> No existe planeaci&oacute;n academica creada anteriormente.
                  </a>
        <?php } ?>

  </ul>
  </form>
