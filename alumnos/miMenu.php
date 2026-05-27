<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];
  echo $IdMenu = $_POST["IdMenu"]; die();

  $sql_par = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.NoParcial FROM tblp_parcialdocente  WHERE tblp_parcialdocente.IdAsignacion =  '$idAsignacion'");

  ?>
  <div class="box box-primary">
    <div class="box-body box-profile">
      <img class="profile-user-img img-responsive img-circle" src="assets/images/oferta/default.png" alt="User profile picture">

      <p class="text-muted text-center"><?php //echo $materia[0]['NombreMod']; ?></p>
      <ul class="nav nav-pills nav-stacked">
        <li <?php if($IdMenu == 11){ echo "class='active'"; } ?>><a onclick="miCalendario()" href="javascript:void(0);"><i class="fa fa-calendar"></i> Mi calendario</a></li>
        <li <?php if($IdMenu == 12){ echo "class='treeview active'"; } ?>><a onclick="informacion()" href="javascript:void(0);"><i class="fa fa-inbox"></i> Información</a></li>
        <li <?php if($IdMenu == 13){ echo "class='active'"; } ?>><a onclick="recursos()" href="javascript:void(0);"><i class="fa fa-envelope-o"></i> Recursos</a></li>
        <li <?php if($IdMenu == 14){ echo "class='active'"; } ?>><a onclick="migrupo()" href="javascript:void(0);"><i class="fa fa-users"></i> Mi grupo</a></li>
        <li <?php if($IdMenu == 15){ echo "class='active'"; } ?>><a onclick="docente()" href="javascript:void(0);"><i class="fa fa-user"></i> Docente</a></li>
        <li <?php if($IdMenu == 16){ echo "class='active'"; } ?>><a onclick="mistareas()" href="javascript:void(0);"><i class="ion ion-clipboard"></i> Tareas enviadas</a></li>
      </ul>
    </div>
  </div>
  <div class="box box-solid">
    <div class="box-header with-border">
      <h3 class="box-title">Mis parciales</h3>
      <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body no-padding" style="">
      <ul class="nav nav-pills nav-stacked">
        <?php while($par = $db->recorrer($sql_par)){ ?>
          <li <?php if($IdMenu == $par['NoParcial']){ echo "class='active'"; } ?>><a onclick="miParcial(<?php echo $par['NoParcial']; ?>,<?php echo $par['IdParcialDocente']; ?>)" href="javascript:void(0);"><i class="fa fa-filter"></i> Parcial <?php echo $par['NoParcial']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
