<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST['IdAsignacion'];
  $sql8 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblc_campus.Icono, tblp_asignacion.IdGrupo FROM tblp_asignacion Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);

  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="TipoGuardar" name="TipoGuardar" value="savClase" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>

    <div class="row">
        <div class="col-md-6" onclick="javascript:window.open('repositorio/portafolio/asistencia_licenciatura_ejecutiva.php?tokenId=<?php echo $IdAsignacion; ?>&tok=1');" href="javascript:void(0);" title="Descargar lista de alumnos del grupo" style="cursor: pointer;">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-info">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/campus/<?php echo $datos81['Icono']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Formato de asistencia</h3>
              <h5 class="widget-user-desc">Control escolar</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6" onclick="javascript:window.open('repositorio/portafolio/lista_alumnos.php?tokenId=<?php echo $IdAsignacion; ?>');" href="javascript:void(0);" title="Descargar lista de alumnos del grupo" style="cursor: pointer;">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/campus/<?php echo $datos81['Icono']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Lista de alumnos</h3>
              <h5 class="widget-user-desc">Control escolar</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6" onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_final.php?tokenId=<?php echo $IdAsignacion; ?>&x=1');" href="javascript:void(0);" title="Descargar acta de calificaciones" style="cursor: pointer;">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/campus/<?php echo $datos81['Icono']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Acta de calificaciones</h3>
              <h5 class="widget-user-desc">Control escolar</h5>
            </div>
          </div>
        </div>

        <div class="col-md-6" onclick="javascript:window.open('formConsulta/impPlaneacion.php?tokenId=<?php echo $IdAsignacion; ?>' , 'ventana1' , 'width=800px,height=600,scrollbars=NO,toolbar=NO');" href="javascript:void(0);" title="Descargar planeación académica" style="cursor: pointer;">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-black">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/campus/<?php echo $datos81['Icono']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Planeación académica</h3>
              <h5 class="widget-user-desc">Control escolar</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6" onclick="javascript:window.open('formConsulta/impReporteCal.php?tokenId=<?php echo $IdAsignacion; ?>' , 'ventana1' , 'width=800px,height=600,scrollbars=NO,toolbar=NO');" href="javascript:void(0);" title="Descargar actividades calificadas" style="cursor: pointer;">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-aqua">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/campus/<?php echo $datos81['Icono']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Actividades calificadas</h3>
              <h5 class="widget-user-desc">Control escolar</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6" onclick="javascript:window.open('formConsulta/impActividades.php?tokenId=<?php echo $IdAsignacion; ?>' , 'ventana1' , 'width=800px,height=600,scrollbars=NO,toolbar=NO');" href="javascript:void(0);" title="Descargar actividades calificadas" style="cursor: pointer;">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-red">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/campus/<?php echo $datos81['Icono']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Planeación de clase</h3>
              <h5 class="widget-user-desc">Control escolar</h5>
            </div>
          </div>
        </div>
      </div>



  </form>
