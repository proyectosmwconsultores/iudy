<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_POST["IdAsignacion"];
  $IdUsua = $_POST["IdUsua"];
  $IdParcial = $_POST["IdParcial"];
  $IdActividad = $_POST["IdActividad"];

  $sql = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Link, tblp_tareas.Link2, tblp_tareas.Link3, tblp_tareas.Fec1, tblp_tareas.Fec2, tblp_tareas.Fec3 FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdAlumno =  '$IdUsua' AND tblp_tareas.IdActividadesDocente =  '$IdActividad' AND tblp_tareas.IdParcialDocente =  '$IdParcial'");
  $db->rows($sql);
  $_datos = $db->recorrer($sql);

  ?>
      <li class="time-label">
            <span class="bg-red">
              Mi lista de tareas subidas
            </span>
      </li>
      <?php if(isset($_datos['Fec1'])){ ?>
      <li>
        <i class="fa fa-file bg-red"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($_datos['Fec1']); ?></span>
          <h3 class="timeline-header no-border"><a style="cursor: pointer;" onclick="verTarea(<?php echo $_datos['IdTarea']; ?>,'Link')" href="javascript:void(0);">Archivo 1 - <?php echo $_datos['Link']; ?></a>
          </h3>
        </div>
      </li><?php } ?>
      <?php if(isset($_datos['Fec2'])){ ?>
      <li>
        <i class="fa fa-file bg-aqua"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($_datos['Fec2']); ?></span>
          <h3 class="timeline-header no-border"><a style="cursor: pointer;" onclick="verTarea(<?php echo $_datos['IdTarea']; ?>,'Link2')" href="javascript:void(0);">Archivo 2 - <?php echo $_datos['Link2']; ?></a>
          </h3>
        </div>
      </li><?php } ?>
      <?php if(isset($_datos['Fec3'])){ ?>
      <li>
        <i class="fa fa-file bg-green"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($_datos['Fec3']); ?></span>
          <h3 class="timeline-header no-border"><a style="cursor: pointer;" onclick="verTarea(<?php echo $_datos['IdTarea']; ?>,'Link3')" href="javascript:void(0);">Archivo 3 - <?php echo $_datos['Link3']; ?></a>
          </h3>
        </div>
      </li><?php } ?>
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
<?php
function tiempo_transcurrido($fecha) {
		if(empty($fecha)) {
			  return "No hay fecha";
		}

		$intervalos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año");
		$duraciones = array("60","60","24","7","4.35","12");

		$ahora = time();
		$Fecha_Unix = strtotime($fecha);

		if(empty($Fecha_Unix)) {
			  return "Fecha incorrecta";
		}
		if($ahora > $Fecha_Unix) {
			  $diferencia     =$ahora - $Fecha_Unix;
			  $tiempo         = "hace";
		} else {
			  $diferencia     = $Fecha_Unix -$ahora;
			  $tiempo         = "Dentro de";
		}
		for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
		  $diferencia /= $duraciones[$j];
		}
		$diferencia = round($diferencia);
		if($diferencia != 1) {
			$intervalos[5].="e"; //MESES
			$intervalos[$j].= "s";
		}
		return "$tiempo $diferencia $intervalos[$j]";
	}
?>
