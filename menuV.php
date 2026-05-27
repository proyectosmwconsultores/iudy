<header class="main-header" style="border-bottom: 5px solid orange;">
  <a <?php if ($_SESSION['Permisos'] == 1) { ?> onClick="window.open('welcome.php','_self')" <?php } else { ?> onClick="window.open('clase.php','_self')" <?php } ?> class="logo">
    <span class="logo-mini"><b><img src="assets/images/campus/<?php echo $_config[0]["Icono"]; ?>" style="width: 100%;"><?php //echo $configuracion[2]["Descripcion"]; 
                                                                                                                        ?></b></b></span>
    <span class="logo-lg"><b><img style="margin-top:-5px; " src="assets/images/campus/<?php echo $_config[0]["Img_logo"]; ?>"><?php //echo $configuracion[11]["Descripcion"]; 
                                                                                                                              ?></b></span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php if (($_SESSION["Permisos"] == 2) || ($_SESSION["Permisos"] == 3)) {  ?>
          <li class="dropdown messages-menu">
            <a href="#" onclick="mostrar_notificacion_tarea(<?php echo $_SESSION['IdUsua']; ?>)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><b id="all_not">0</b></span>
            </a>
            <ul class="dropdown-menu" id="misNotificaciones">
            </ul>
          </li>
        <?php } ?>
        <?php if (($_SESSION["Permisos"] == 1) || ($_SESSION["Permisos"] == 5) || ($_SESSION["Permisos"] == 7) || ($_SESSION["Permisos"] == 9) || ($_SESSION["Permisos"] == 10) || ($_SESSION["Permisos"] == 11)) {  ?>
          <li class="dropdown messages-menu">
            <a href="#" onclick="mostrar_acta_cal()" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><b id="all_acta">0</b></span>
            </a>
            <ul class="dropdown-menu" id="misActas_cal">
            </ul>
          </li>
          <li class="dropdown messages-menu">
            <a href="#" onclick="mostrar_bajas()" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user-times"></i>
              <span class="label label-success"><b>50</b></span>
            </a>
            <ul class="dropdown-menu" id="bajas_alumnos">
            </ul>
            
          </li>
          
          
          <?php } ?>
        <?php if (($_SESSION["Permisos"] == 1) || ($_SESSION["Permisos"] == 6)) {  ?>
          <li class="dropdown notifications-menu" onclick="mostrarDocss()">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <i class="fa fa-usd"></i> <span class="label label-warning"></span> -->
              <i class="fa fa-usd"></i> <span class="label label-warning"><b id="lbl_pag">0</b></span>
            </a>
          </li>
          
          <li class="dropdown notifications-menu" onclick="mostrar_pagos()">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-black-tie"></i>
            </a>
          </li>
        <?php } ?>
        <?php if (($_SESSION["Permisos"] == 2) || ($_SESSION["Permisos"] == 3) || ($_SESSION["Permisos"] == 4)) {
        } else { ?>
          <li class="dropdown notifications-menu" onclick="mostrarPermisos(<?php echo '3547' . $_SESSION["IdUsua"]; ?>)">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-checkered"></i>
            </a>
          </li>
        <?php } ?>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $_SESSION['NombreUser']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" class="img-circle" alt="User Image">
              <p>
                <?php if ($_SESSION['Permisos'] == 3) { ?>
                  <small><?php echo $infoPerfil[0]["Campus"]; ?></small>
                  <small><?php echo $infoPerfil[0]["Oferta"]; ?></small>
                <?php } else { ?>
                  <small><?php echo $_SESSION['Cargo']; ?></small>
                  <?php if ($infoPerfil[0]["Campus"]) { ?><small><?php echo $infoPerfil[0]["Campus"]; ?></small> <?php } ?>
                <?php } ?>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <?php if($_SESSION['Permisos'] == 3){ ?>
                <a onClick="window.open('espacioUser.php','_self')" href="javascript:void(0);" class="btn btn-default btn-flat">Mi espacio</a>
                <?php } elseif($_SESSION['Permisos'] == 2) { ?>
                <a onClick="window.open('espacioUsuario.php','_self')" href="javascript:void(0);" class="btn btn-default btn-flat">Mi espacio</a>
                <?php } else { ?>
                <a onClick="window.open('espacioAdministrativo.php','_self')" href="javascript:void(0);" class="btn btn-default btn-flat">Mi espacio</a>
                <?php } ?>
              </div>
              <div class="pull-left" style=" padding-left: 13px;">
                <a onClick="window.open('miBiblioteca.php','_self')" href="javascript:void(0);" class="btn btn-default btn-flat">Biblioteca</a>
              </div>
              <div class="pull-right">
                <a onClick="window.open('php/estructura/destroy.php','_self')" href="javascript:void(0);" class="btn btn-default btn-flat">Salir</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img style="width: 50px; height: 50px;" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['NombreUser']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MEN&Uacute; PRINCIPAL</li>
      <?php if (($_SESSION['Permisos'] == 1) || ($_SESSION['Permisos'] == 5) || ($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 7) || ($_SESSION['Permisos'] == 8) || ($_SESSION['Permisos'] == 9) || ($_SESSION['Permisos'] == 10) || ($_SESSION['Permisos'] == 11)) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 301)) {
                              echo 'active';
                            } ?>">
          <a onClick="window.open('welcome.php','_self')" href="javascript:void(0);"><i class="fa fa-home"></i> <span>Inicio</span></a>
        </li><?php } ?>

      <?php if (($_SESSION['Permisos'] == "9") || ($_SESSION['Permisos'] == "5")) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 39)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('viewSupervisor.php','_self')" href="javascript:void(0);"><i class="fa fa-desktop"></i> <span>Supervisor</span><span class="pull-right-container"> </span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 40)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('viewSupervisorFinalizadas.php','_self')" href="javascript:void(0);"><i class="fa fa-bell"></i> <span>Supervisor</span><span class="pull-right-container"></span></a></li>
      <?php } ?>

      <?php if ($_SESSION['Permisos'] == 3) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 31)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('clase.php','_self')" href="javascript:void(0);"><i class="fa fa-home"></i> <span><?php echo $configuracion[0]['Descripcion']; ?></span></a></li>
      <?php }
      if (($_SESSION['Permisos'] == 2) && (!isset($_GET["idToks"]))) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 31)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('miPortal.php','_self')" href="javascript:void(0);"><i class="fa fa-home"></i> <span><?php echo $configuracion[0]['Descripcion']; ?></span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 61)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('misClases.php','_self')" href="javascript:void(0);"><i class="fa fa-book"></i> <span>Mis clases</span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 68)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('mis_reconocimientos.php','_self')" href="javascript:void(0);"><i class="fa fa-trophy"></i> <span>Mis reconocimientos</span></a></li>
        <li class="treeview"><a onClick="window.open('ayuda.php','_self')" href="javascript:void(0);"><i class="fa fa-question-circle"></i> <span>Ayuda</span><span class="pull-right-container">
              
            </span></a></li>
      <?php } ?>

      <?php
      if (($_SESSION['Permisos'] == "2") || ($_SESSION['Permisos'] == "9") || ($_SESSION['Permisos'] == "4") || ($_SESSION['Permisos'] == "5")) { ?>
        <?php if (isset($_GET["idToks"])) { ?>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 61)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('misClases.php','_self')" href="javascript:void(0);"><i class="fa fa-book"></i> <span>Mis clases</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 91)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('doMiPlaneacion.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-feed"></i> <span>Mi planeaci&oacute;n</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 89)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('doPlaneacion.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-quote-left"></i> <span>Vista de la planeaci&oacute;n</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 92)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('doAddCalificar.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-wrench"></i> <span>Calificar</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 93)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('acta_calificacion.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-file-code-o"></i> <span>Acta de calificaci&oacute;n</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 94)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('doEjecutarLista.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-calendar-check-o"></i> <span>Asistencia</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 95)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('doAddRecurso.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-bookmark"></i> <span>Material didáctico</span></a></li>
          <li class="treeview <?php if ((isset($_v)) && ($_v == 96)) {
                                echo 'active';
                              } ?>"><a onClick="window.open('doAddGrupo.php?idToks=<?php echo $_GET["idToks"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-users"></i> <span>Formar equipo</span></a></li>
        <?php } ?>
      <?php  } ?>


      <?php if ($_SESSION['Permisos'] == 3) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 52)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('mis_clases.php','_self')" href="javascript:void(0);"><i class="fa fa-book"></i> <span>Mis clases</span></a></li>

      <?php } ?>
      <?php
      if (($_SESSION['Permisos'] == "3") && (isset($_GET['idAsignacion']))) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 60)) { echo 'active'; } ?>"><a onClick="window.open('miMateria.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>','_self')" href="javascript:void(0);"><i class="fa fa-file"></i> <span>Mi asignatura</span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 2)) { echo 'active'; } ?>"><a onClick="window.open('miContenido.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>','_self')" href="javascript:void(0);"><i class="fa fa-puzzle-piece"></i> <span>Mi contenido</span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 36)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('mi_tareas.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>','_self')" href="javascript:void(0);"><i class="ion ion-clipboard"></i> <span>Mis tareas</span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 32)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('mi_material.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>','_self')" href="javascript:void(0);"><i class="fa fa-bookmark"></i> <span>Material didáctico</span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 33)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('mi_grupo.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>','_self')" href="javascript:void(0);"><i class="fa fa-users"></i> <span>Mi grupo</span></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 88)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('miAsistencia.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>','_self')" href="javascript:void(0);"><i class="fa fa-check-circle"></i> <span>Asistencia</span></a></li>
      <?php } ?>

      <?php
      if ((!isset($_GET['idAsignacion'])) && (!isset($_GET["idToks"]))) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 90)) { echo 'active'; } ?>"><a onClick="window.open('viewFinalizados.php','_self')" href="javascript:void(0);"><i class="fa fa-lock"></i> <span>Clases finalizadas</span></a></li>
        <?php if ($_SESSION['Permisos'] == 2) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 186)) { echo 'active'; } ?>"><a onClick="window.open('resultadoEvaluacion.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-trophy"></i> <span> Resultado evaluación </span> <small class="label pull-right bg-orange"><Nav></Nav>Nuevo</small></a></li>
      <?php } } ?>

      <?php if (($_SESSION['Permisos'] == 9) || ($_SESSION['Permisos'] == 5)) { ?>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 381)) {
                              echo 'active';
                            } ?>"><a onClick="window.open('evaluacionDocente.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-folder"></i> <span>Evaluación docente</span> <small class="label pull-right bg-orange">Nuevo</small></a></li>
      <?php } ?>
      <?php if (($_SESSION['Permisos'] == 1) || ($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 5) || ($_SESSION['Permisos'] == 10) || ($_SESSION['IdUsua'] == 708) ) { ?>
        <li><a onClick="window.open('repActivos.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-folder"></i> <span>Reporte</span></a></li>
        <?php if (($_SESSION['Permisos'] == 1) || ($_SESSION['Permisos'] == 6)) { ?>
        <li><a onclick="buscar_folio()" href="javascript:void(0);"><i class="fa fa-fw fa-search"></i> <span>Buscar</span></a></li>
        <?php } ?>
        
        <li class="treeview" style="height: auto;">
            <a href="#">
              <i class="fa fa-line-chart"></i> <span>Universo IUDY</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display: none;">
              <li><a onClick="window.open('universo_alumnos.php','_self')" href="javascript:void(0);"><i class="fa fa-circle-o"></i> Alumnos </a></li>
              <!-- <li><a onClick="window.open('dashboard.php?anio=2022','_self')" href="javascript:void(0);"><i class="fa fa-circle-o"></i> Ingresos 2022</a></li> -->
            </ul>
          </li>
      <?php } ?>

      <?php if (($_SESSION['Permisos'] == 1) || ($_SESSION['Permisos'] == 5) || ($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 7)) { ?>
        <!-- <li class="treeview" style="height: auto;">
            <a href="#">
              <i class="fa fa-bank"></i> <span>Universidad en números</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display: none;">
              <li><a onClick="window.open('dashboard_matricula.php','_self')" href="javascript:void(0);"><i class="fa fa-circle-o"></i> Informe de matrículas</a></li>
              <li><a onClick="window.open('dashboard_docentes.php','_self')" href="javascript:void(0);"><i class="fa fa-circle-o"></i> Informe de docentes</a></li>
            </ul>
          </li> -->
      <?php } ?>
      <?php if (($_SESSION['Permisos'] == 3) && (!isset($_GET['idAsignacion']))) { ?>
        <!--<li class="treeview <?php if ((isset($_v)) && ($_v == 919)) {
                                  echo 'active';
                                } ?>"><a onClick="window.open('viewVideos.php','_self')" href="javascript:void(0);"><i class="fa fa-question-circle"></i> <span>Ayuda</span><span class="pull-right-container">
                <small class="label pull-right bg-green">Video</small>
              </span></a></li>-->
        <li class="treeview <?php if ((isset($_v)) && ($_v == 303)) { echo 'active'; } ?>"><a onClick="window.open('viewEvaluacion.php','_self')" href="javascript:void(0);"><i class="fa fa-folder"></i> <span>Evaluación docente</span> <small class="label pull-right bg-orange">Nuevo</small></a></li>
        <li class="treeview <?php if ((isset($_v)) && ($_v == 33)) { echo 'active'; } ?>"><a onclick="mostrar_mi_credencial(<?php echo $_SESSION['IdUsua']; ?>)" href="javascript:void(0);"><i class="fa fa-qrcode"></i> <span>Mi credencial digital</span></a></li>
      <?php } ?>
    </ul>
  </section>
</aside>
<input type="hidden" name="txt_docs_sol" id="txt_docs_sol" value="<?php if (isset($docs_sol[0]['IdDocumento'])) {
                                                                    echo $docs_sol[0]['IdDocumento'];
                                                                  } ?>">
<input type="hidden" name="txt_pers" id="txt_pers" value="<?php echo $_SESSION['Permisos']; ?>">
<input type="hidden" name="_idUs" id="_idUs" value="<?php echo $_SESSION['IdUsua']; ?>">

<input type="hidden" name="t_ini" id='t_ini' value="<?php echo $infoPerfil[0]['Visto']; ?>">
<div id="dataModPermisos" class="modal fade">
  <!--MODAL ME GUSTA-->
  <div class="modal-dialog">
    <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Mis roles de acceso</h4>
    </div>
    <div class="modal-content">
      <div class="modal-body" id="empl_ModPermisos">
      </div>
    </div>
  </div>
</div>
<div id="dataClass" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-gift"></i> Crear una clase</h4>
      </div>
      <div class="modal-body" id="employee_class">
      </div>
    </div>
  </div>
</div>
<div id="dataUnirse" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-gift"></i> Unirse a una clase</h4>
      </div>
      <div class="modal-body" id="employee_unirse">
      </div>
    </div>
  </div>
</div>
<div id="dataDocs" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Constancias solicitados pendientes por aprobar</h4>
      </div>

      <div class="modal-body" id="employee_docs">
      </div>
    </div>
  </div>
</div>

<div id="dataPagos" class="modal fade bs-example-modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-usd"></i> Comprobantes de pagos que acaban de subir a la Plataforma</h4>
      </div>

      <div class="modal-body" id="employee_pagos">
      </div>
    </div>
  </div>
</div>

<div id="dataOnline" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-smile-o"></i> Usuarios que se encuentran en linea en la Plataforma en este momento</h4>
      </div>

      <div class="modal-body" id="employee_online">
      </div>
    </div>
  </div>
</div>

<div id="data_notificacion" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-bell-o"></i> Notificación de la actividad</h4>
      </div>

      <div class="modal-body" id="employee_notificacion">
      </div>
    </div>
  </div>
</div>
<div id="data_baja" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-user-times"></i> Baja del alumno </h4>
      </div>

      <div class="modal-body" id="employee_baja">
      </div>
    </div>
  </div>
</div>
<div id="data_folio" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-search"></i> Buscar pago </h4>
      </div>

      <div class="modal-body" id="employee_folio">
      </div>
    </div>
  </div>
</div>
<div id="data_video" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-bell-o"></i> Crear planeación académica</h4>
      </div>

      <div class="modal-body" id="employee_video">
      </div>
    </div>
  </div>
</div>
<div id="data_credencial" class="modal fade">
  <div class="modal-dialog modal-sm">
      <div class="modal-content" style="width: 350px !important; height: 590px !important; margin: 0 auto;">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-fw fa-barcode"></i> Mi Credencial Digital</h4>
            </div>

            <div class="modal-body" id="employee_credencial">
            </div>
      </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    var Permiso = document.getElementById("txt_pers").value;

    if ((Permiso == 1) || (Permiso == 7)) {
      var Docs = document.getElementById("txt_docs_sol").value;
      if (Docs) {
        $.ajax({
          url: "formConsulta/lst_docs_sol.php",
          method: "POST",
          data: {},
          success: function(data) {
            $('#employee_docs').html(data);
            $('#dataDocs').modal('show');
          }
        });
      }
    }
  })

  function mostrarDocss() {
    $.ajax({
      url: "formConsulta/lst_pagos_subidos.php",
      method: "POST",
      data: {},
      success: function(data) {
        $('#employee_pagos').html(data);
        $('#dataPagos').modal('show');
      }
    });
  }



  function user_online() {
    $.ajax({
      url: "formConsulta/lst_user_online.php",
      method: "POST",
      data: {},
      success: function(data) {
        $('#employee_online').html(data);
        $('#dataOnline').modal('show');
      }
    });
  }

  function mostrar_pagos() {
    $.ajax({
      url: "formConsulta/lst_docs_sol.php",
      method: "POST",
      data: {},
      success: function(data) {
        $('#employee_docs').html(data);
        $('#dataDocs').modal('show');
      }
    });
  }

  function buscarUser_() {
    var Code = document.getElementById("txt_Code").value;
    var TipoGuardar = 'buscar_User';
    $.ajax({
      url: "formConsulta/setting.php",
      method: "POST",
      data: {
        TipoGuardar: TipoGuardar,
        Code: Code
      },
      success: function(data) {
        var Tipo_ = "";
        var Acceso = "";
        var porciones = data.split('-');
        Tipo_ = porciones[0];
        Acceso = porciones[1];
        if (Tipo_ == 0) {
          swal("No encontrado", "El usuario no se ha encontrado en la Plataforma.", "error");
        }
        if (Tipo_ == 1) {
          swal("Usuario activo", "No tiene permisos para ver este usuario.", "success");
        }
        if (Tipo_ == 2) {
          parent.location.href = 'asesor.php?token=' + Acceso;
        }
        if (Tipo_ == 3) {
          parent.location.href = 'perfil.php?token=' + Acceso;
        }

      }
    })

  }

  $(document).ready(function() {
    var Permiso = document.getElementById("txt_pers").value;

    if ((Permiso == 1) || (Permiso == 6)) {
      no_pagos_pendientes();
    }

    if ((Permiso == 2) || (Permiso == 3)) {
      no_notificion();
    }
    if ((Permiso == 1) || (Permiso == 9)) {
      no_acta();
    }

  });

  function no_pagos_pendientes() {
    var TipoGuardar = 'no_pag_pend';
    $.ajax({
        type: "POST",
        url: "formConsulta/setting.php",
        data: {
          TipoGuardar: TipoGuardar
        },
        success: function(data) {
          //alert(data);
        }
      })
      .done(function(data) {
        document.getElementById('lbl_pag').innerHTML = data;
      })
  }

  function no_notificion() {
    var IdUsua = document.getElementById("_idUs").value;
    var TipoGuardar = 'notificion_all';
    $.ajax({
      type: "POST",
      url: "formConsulta/setting.php",
      data: {
        TipoGuardar: TipoGuardar,
        IdUsua: IdUsua
      },
      success: function(data) {
        document.getElementById('all_not').innerHTML = data;
      }
    })
  }

  function no_acta() {
    var TipoGuardar = 'acta_all';
    $.ajax({
      type: "POST",
      url: "formConsulta/setting.php",
      data: {
        TipoGuardar: TipoGuardar
      },
      success: function(data) {
        document.getElementById('all_acta').innerHTML = data;
      }
    })
  }

  function mostrar_notificacion_tarea(IdUsua) {
    var Capa = "#misNotificaciones";
    $(Capa).load("formConsulta/misNotificaciones.php", {
      IdUsua: IdUsua
    }, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
  }

  function mostrar_acta_cal() {
    var Capa = "#misActas_cal";
    $(Capa).load("formConsulta/misActaCalificaciones.php", {}, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
  }

  function mostrar_bajas() {
    var Capa = "#bajas_alumnos";
    $(Capa).load("formConsulta/lst_alumnos_baja.php", {}, function(response, status, xhr) {
      if (status == "error") {
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
  }

  function ver_notificacion(IdNotificacion) {
    $.ajax({
      url: "formConsulta/verNotificacion.php",
      method: "POST",
      data: {
        IdNotificacion: IdNotificacion
      },
      success: function(data) {
        $('#employee_notificacion').html(data);
        $('#data_notificacion').modal('show');
      }
    });
  }

  function ver_baja_id(IdBaja) {
    $.ajax({
      url: "formConsulta/verBaja.php",
      method: "POST",
      data: {
        IdBaja: IdBaja
      },
      success: function(data) {
        $('#employee_baja').html(data);
        $('#data_baja').modal('show');
      }
    });
  }

  function buscar_folio() {
      var Rerefencia = ''; var Autorizacion = '';
    $.ajax({
      url: "formConsulta/buscarFolio.php",
      method: "POST",
      data: {
        Rerefencia:Rerefencia, Autorizacion: Autorizacion
      },
      success: function(data) {
        $('#employee_folio').html(data);
        $('#data_folio').modal('show');
      }
    });
  }

  function buscar_folio_pago_id(){
    var Rerefencia = document.getElementById("txt_referencia_bus").value;
    var Autorizacion = document.getElementById("txt_autorizacion_bus").value;
    if (Rerefencia == '') {
			swal("Error al guardar", "Debe ingresar el número de referencia.", "error");
			document.getElementById("txt_referencia_bus").focus();
			return 0;
		}
    if (Autorizacion == '') {
			swal("Error al guardar", "Debe ingresar el número de autorización.", "error");
			document.getElementById("txt_autorizacion_bus").focus();
			return 0;
		}


    $.ajax({
      url: "formConsulta/buscarFolio.php",
      method: "POST",
      data: {
        Rerefencia:Rerefencia, Autorizacion: Autorizacion
      },
      success: function(data) {
        $('#employee_folio').html(data);
        $('#data_folio').modal('show');
      }
    });
  }

  function mostrar_mi_credencial(Valor){
    var IdUsua = '0000000000'+Valor;
		$.ajax({
			url:"vistas/alumno/mi_credencial.php",
			method:"POST",
			data:{IdUsua:IdUsua},
			success:function(data){
				$('#employee_credencial').html(data);
				$('#data_credencial').modal('show');
			}
		});
  }

  


  function mostrar_acta(Id) {
    var TipoGuardar = 'set_asignacion';
    $.ajax({
        type: "POST",
        url: "formConsulta/setting.php",
        data: {
          TipoGuardar: TipoGuardar,
          Id: Id
        },
        success: function(data) {
          // alert(data);
        }
      })
      .done(function(data) {
        var url = 'repositorio/portafolio/acta_calificacion_final.php?tokenId=' + data;
        var win = window.open(url, '_blank');
        win.focus();
      })
  }


  $(document).ready(function() {
    var Permisox = document.getElementById("txt_pers").value;
    if (Permisox == 3) {
      setTimeout(sendAlert, 20 * 60 * 1000);
      setTimeout(sendAlertPrev, 15 * 60 * 1000)
    }

  });

  function sendAlert() {
    swal({
        title: "La sesi\u00F3n ha terminado",
        text: "Recarga tu plataforma para seguir trabajando.",
        type: "error",
        showCancelButton: false,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Ok',
      },
      function(isConfirm) {
        if (isConfirm) {
          window.location = 'php/estructura/destroy.php';
        } else {
          window.location = 'php/estructura/destroy.php';
        }
      });


  }

  function sendAlertPrev() {
    swal({
        title: "La sesi\u00F3n esta por terminar",
        text: "Recarga la p\u00E1gina para seguir trabajando.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Ok',
      },
      function(isConfirm) {
        if (isConfirm) {}

      });
  }
</script>