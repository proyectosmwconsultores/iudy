<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];

  $sql_grp1 = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$idAsignacion'");
  ?>

  <div class="box-body">
    <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-black">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/equipo.png" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">MI GRUPO</h3>
              <h5 class="widget-user-desc">Mis compañeros de clase</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="users-list clearfix">
                  <?php while($grp_1 = $db->recorrer($sql_grp1)){ ?>
                    <li>
                      <img style="width: 60px; height: 60px;" src="assets/perfil/<?php echo $grp_1['Foto']; ?>" alt="Foto">
                      <a class="users-list-name" href="#"><?php echo $grp_1['Nombre'].' '.$grp_1['APaterno'].' '.$grp_1['AMaterno']; ?></a>
                      <span class="users-list-date"><br></span>
                    </li>
                  <?php } ?>
                  </ul>
            </div>
          </div>
  </div>
