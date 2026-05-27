<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];
  $IdParcial = $_POST["IdParcial"];
  $IdSemana = $_POST["IdSemana"];

  $sql_par1 = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblp_parcialdocente.Objetivo FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente =  '$IdParcial'");
  $db->rows($sql_par1);
  $datosp1 = $db->recorrer($sql_par1);

  $sql_sem = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.IdParcialDocente, tblp_semanadocente.NoSemana, tblp_semanadocente.Temas, tblp_semanadocente.Nombre FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente =  '$IdSemana'");
  $db->rows($sql_sem);
  $datos_sem = $db->recorrer($sql_sem);

  $sql_sem1 = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.NoSemana, tblp_semanadocente.Temas FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ORDER BY tblp_semanadocente.NoSemana ASC");

  $sql_act1 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.DesActividad, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Modalidad, tblp_actividadesdocente.Porcentaje, tblp_actividadesdocente.Mostrar, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin, tblp_actividadesdocente.Tiempo, tblc_tipoactividad.IdTipoActividad, tblc_tipoactividad.TipoActividad, tblc_estatus.IdEstatus,tblc_estatus.Estatus FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus WHERE tblp_actividadesdocente.IdParcialDocente = '$IdParcial' AND tblp_actividadesdocente.IdSemanaDocente = '$IdSemana' AND tblp_actividadesdocente.IdEstatus <> '12' ORDER BY tblp_actividadesdocente.FecFin ASC");


  ?>

  <div class="row">
    <div class="col-md-6">
      <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-flag"></i> <?php echo $_SESSION['_txt']; ?> <?php echo $datosp1['NoParcial']; ?></h3>
      </div>
      <div class="box-body">
        <strong><i class="fa fa-book margin-r-5"></i> Tema:</strong>
        <p class="text-muted"> <?php echo $datosp1['Tema']; ?> </p>
        <strong><i class="fa fa-map-marker margin-r-5"></i> Objetivo:</strong>
        <p class="text-muted"><?php echo $datosp1['Tema']; ?></p>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box-header with-border">
          <h3 class="box-title">Mis unidades disponibles</h3>
      </div>
      <div class="box box-widget">
        <div class="box-body">
          <?php while($sem = $db->recorrer($sql_sem1)){ ?>
          <a <?php if($IdSemana == $sem['IdSemanaDocente']){ echo " style='background: #d4d3d9; '"; $col = "red"; } else { $col = "purple"; } ?> class="btn btn-app" onclick="miUnidad(<?php echo $IdParcial; ?>,<?php echo $sem['IdSemanaDocente']; ?>,<?php echo $sem['NoSemana']; ?>)">
            <span class="badge bg-<?php echo $col; ?>"><?php echo $sem['NoSemana']; ?></span>
            <i class="fa fa-file-text-o"></i> Unidad <?php echo $sem['NoSemana']; ?>
          </a><?php } ?>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
		<div class="col-md-12">
      <div class="box-primary">
        <div class="box-body">
          <div class="box-header with-border">
            <i class="fa fa-map-signs"></i>
            <h3 class="box-title">Mi unidad <?php echo $datos_sem['NoSemana']; ?></h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box-primary">
        <div class="box-body">
          <?php echo $datos_sem['Temas']; ?>
        </div>
      </div>
    </div>
    <?php if($datos_sem['Nombre']){ ?>
    <div class="col-md-12" onclick="verPresentacion(<?php echo $IdSemana; ?>)" style="cursor: pointer;">
      <div class="box-primary">
        <div class="box-body">
          <img src="assets/fondo/presentacion.jpg" style="width: 100%">
        </div>
      </div>
    </div><?php } ?>
  </div>
  <div class="box-body">
    <div class="box-footer no-padding">
      <ul class="timeline timeline-inverse">
        <li class="time-label">
              <span class="bg-red">
                Mis actividades
              </span>
        </li>
        <?php while($act = $db->recorrer($sql_act1)){ $_idTarea = 0;
          $idA = $act['IdActividadesDocente'];
          $idT = $act['IdTipoActividad']; if($idT == 1){ $ico = 'fa-question-circle bg-blue'; $ico_ = 'fa-question-circle'; } elseif($idT == 2){ $ico = 'fa-comments bg-yellow'; $ico_ = 'fa-comments'; }elseif($idT == 3){ $ico = 'fa-edit bg-green'; $ico_ = 'fa-upload'; }
          $idE = $act['IdEstatus']; if($idE == 8){ $ico_es = 'fa-unlock-alt'; $e_c = "blue"; } elseif($idE == 26){ $ico_es = 'fa-lock'; $e_c = "red"; }elseif($idE == 12){ $ico = 'fa-edit'; $e_c = "black"; }


          ?>
        <li>
          <i class="fa <?php echo $ico; ?>"></i>

          <div class="timeline-item">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tabA_<?php echo $idA; ?>" data-toggle="tab" aria-expanded="true"><?php echo $act['TipoActividad']; ?></a></li>
                  <!-- <li class=""><a href="#tabR_<?php echo $idA; ?>" data-toggle="tab" aria-expanded="false">Instrucción</a></li> -->

                  <li class="">
                    <?php if($idE == 8){ ?>
                    <?php if($idT == 1){ ?>
                      <a style="cursor: pointer; " onclick="comenzarEva(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $datos_sem['NoSemana']; ?>,<?php echo $idA; ?>)" aria-expanded="false"> <i class="fa <?php echo $ico_; ?>"></i> Realizar evaluación</a>
                    <?php } elseif($idT == 3){
                      $IdUx = $_SESSION['IdUsua'];

                        $sql_tar = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Link, tblp_tareas.Link2, tblp_tareas.Link3 FROM tblp_tareas WHERE tblp_tareas.IdAlumno =  '$IdUx' AND tblp_tareas.IdActividadesDocente =  '$idA' AND tblp_tareas.IdAsignacion =  '$idAsignacion' ");
                        $db->rows($sql_tar);
                        $datos_tar = $db->recorrer($sql_tar);
                        if(isset($datos_tar['IdTarea'])){ $_idTarea = $datos_tar['IdTarea']; } else { $_idTarea = 0; }
                      ?>
                      <!-- <a style="cursor: pointer; " onclick="enviarTarea(<?php echo $idA; ?>)" aria-expanded="false"> <i class="fa <?php echo $ico_; ?>"></i> Subir actividad</a> -->
                      <a style="cursor: pointer; " onclick="subirMiTarea(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $datos_sem['NoSemana']; ?>,<?php echo $idA; ?>)" aria-expanded="false"> <i class="fa <?php echo $ico_; ?>"></i> Subir actividad</a>
                    <?php } ?>
                    <?php } ?>
                  <?php if($idT == 2){ ?>
                    <a style="cursor: pointer;" onclick="miForo(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $datos_sem['NoSemana']; ?>,<?php echo $idA; ?>)" aria-expanded="false"> <i class="fa <?php echo $ico_; ?>"></i> Ingresar al foro</a>
                  <?php } ?>


                  </li>
                  <?php if(($idT == 3) && (isset($datos_tar['IdTarea']))){ ?>
                  <li class="">
                    <a style="cursor: pointer;" href="javascript:void(0);" name="view" value="view" id="<?php echo $_idTarea.'-'.$_SESSION['IdUsua'].'-A'; ?>" class=" coment_data" aria-expanded="false"> <i class="fa fa-fw fa-wechat"></i> Chat</a>
                  </li><?php } ?>
                  <li class="pull-right"><a href="#" class="text-muted"><b style="color: <?php echo $e_c; ?>"><i class="fa <?php echo $ico_es; ?>"></i> <?php echo $act['Estatus']; ?></b></a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tabA_<?php echo $idA; ?>">
                    <b><?php echo $act['NomActividad']; ?></b><br>
                    <p><?php echo $act['DesActividad']; ?></p>


                    <div class="box-body">
                      <strong><i class="fa fa-question-circle margin-r-5"></i> Información general</strong>
                      <dl class="dl-horizontal">
                        <?php if($idT == 1){ ?>
                          <dt>Fecha de inicio:</dt>
                          <dd><?php echo $act['Ini']; ?></dd>
                          <dt>Fecha de final:</dt>
                          <dd><?php echo $act['Fin']; ?></dd>
                        <?php }elseif($idT == 2){ ?>
                          <dt>Fecha de final:</dt>
                          <dd><?php echo $act['FecFin']; ?></dd>
                        <?php } else { ?>
                          <dt>Fecha de entrega:</dt>
                          <dd><?php echo $act['FecFin']; ?></dd>
                        <?php } ?>
                        <dt>Porcentaje:</dt>
                        <dd><?php echo $act['Porcentaje']; ?> %</dd>
                      </dl>
                      <?php if($idT == 3){
                        ?>
                      <hr>
                      <?php if((isset($datos_tar['Link'])) || (isset($datos_tar['Link2'])) || (isset($datos_tar['Link3']))){ ?>
                      <strong><i class="fa fa-pencil margin-r-5"></i> Mis trabajos subidos</strong>
                        <ul class="mailbox-attachments clearfix"><br>
                          <?php if($datos_tar['Link']){ ?>
                          <li>
                            <div class="mailbox-attachment-info">
                              <a style="cursor: pointer; color: #0b0b5e;" onclick="verTarea(<?php echo $datos_tar["IdTarea"]; ?>,'Link')" class="mailbox-attachment-name"><i class="fa fa-file"></i> <?php echo $datos_tar['Link']; ?></a>
                            </div>
                          </li><?php } ?>
                          <?php if($datos_tar['Link2']){ ?>
                          <li>
                            <div class="mailbox-attachment-info">
                              <a style="cursor: pointer; color: #0b0b5e;" onclick="verTarea(<?php echo $datos_tar["IdTarea"]; ?>,'Link2')" class="mailbox-attachment-name"><i class="fa fa-file"></i> <?php echo $datos_tar['Link2']; ?></a>
                            </div>
                          </li><?php } ?>
                          <?php if($datos_tar['Link3']){ ?>
                          <li>
                            <div class="mailbox-attachment-info">
                              <a style="cursor: pointer; color: #0b0b5e;" onclick="verTarea(<?php echo $datos_tar["IdTarea"]; ?>,'Link3')" class="mailbox-attachment-name"><i class="fa fa-file"></i> <?php echo $datos_tar['Link3']; ?></a>
                            </div>
                          </li><?php } ?>
                        </ul>
                      <?php } } ?>
                    </div>
                  </div>
                  <div class="tab-pane" id="tabR_<?php echo $idA; ?>">
                    <b><?php echo $act['NomActividad']; ?></b>
                    <p><?php echo $act['DesActividad']; ?></p>
                  </div>
                </div>
              </div>
          </div>
        </li>
      <?php } ?>
        <li>
          <i class="fa fa-clock-o bg-gray"></i>
        </li>
      </ul>


    </div>
  </div>

  <div id="dataTarea" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background: #858dac; color: black; font-size: 16px;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-fw fa-cloud-upload"></i> M&oacute;dulo para responder actividad</h4>
             </div>
                 <div class="modal-body" id="employee_Tarea">
                 </div>
            </div>
       </div>
  </div>
  <div id="dataModal8" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background: #858dac; color: black; font-size: 16px;">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"><i class="fa fa-fw fa-tripadvisor"></i> Vista previa del trabajo</h4>
              </div>
                 <div class="modal-body" id="employee_detail8">
                 </div>
            </div>
       </div>
  </div>
  <div id="dataChats" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chat de la actividad</h4>
               </div>
                  <div class="modal-body" id="employee_chats">
                  </div>
             </div>
        </div>
   </div>

  <script>
    function enviarTarea(IdActividad){
      var idAsignacion = document.getElementById("idAsignacion").value;
      $.ajax({
           url:"alumnos/uploadTarea.php",
           method:"POST",
           data:{IdActividad:IdActividad, idAsignacion:idAsignacion},
           success:function(data){
                $('#employee_Tarea').html(data);
                $('#dataTarea').modal('show');
           }
      });

    }


    function verTarea(IdTarea,Ubicacion){
    	$.ajax({
    			 url:"alumnos/verTarea.php",
    			 method:"POST",
    			 data:{IdTarea:IdTarea,Ubicacion:Ubicacion},
    			 success:function(data){

    						$('#employee_detail8').html(data);
    						$('#dataModal8').modal('show');
    			 }
    	});

    }

    $(document).ready(function(){
         $(document).on('click', '.coment_data', function(){
              var employee_id = $(this).attr("id");
              if(employee_id != '')
              {
                   $.ajax({
                        url:"formConsulta/viewComentarios.php",
                        method:"POST",
                        data:{employee_id:employee_id},
                        success:function(data){
                             $('#employee_chats').html(data);
                             $('#dataChats').modal('show');
                        }
                   });
              }
         });
    });
  </script>
