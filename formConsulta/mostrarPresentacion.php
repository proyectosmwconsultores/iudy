<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_POST["IdAsignacion"];
  $IdParcial = $_POST["IdParcial"];

  $sql = $db->query("SELECT tblp_parcialdocente.Titulo, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblp_parcialdocente.Objetivo, tblp_parcialdocente.FecIni, tblp_parcialdocente.FecIni FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente =  '$IdParcial' ");
  $db->rows($sql);
  $_datos = $db->recorrer($sql);

  $sql_sem = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.Etiqueta_semana, tblp_semanadocente.NoSemana, tblp_semanadocente.Semana FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ");

  ?>
  <input id="nom_" name="nom_" value="<?php echo $_datos['Titulo'].': '.$_datos['Tema']; ?>" type="hidden"/>
  <div class="box-body">
    <strong><i class="fa fa-file-text-o margin-r-5"></i> <?php echo $_datos['Tema']; ?></strong>
    <p class="text-muted">
      Objetivo: <?php echo $_datos['Objetivo']; ?>
    </p>
    <hr>
  </div>
  <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          Lista del contenido del <?php echo $_datos['Titulo']; ?>
                        </span>
                  </li>
                  <?php while($_sem = $db->recorrer($sql_sem)){ $IdSemana = $_sem['IdSemanaDocente'];  ?>
                  <li>
                    <i class="fa fa-map-signs bg-aqua"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header no-border"><a onclick="window.open('miLeccion.php?idAsignacion=<?php echo $IdAsignacion; ?>&idLeccion=<?php echo $IdParcial.'_'.$IdSemana; ?>','_self')" href="javascript:void(0);"><?php echo $_sem['Etiqueta_semana']; ?></a> <?php echo $_sem['Semana']; ?>
                      </h3>
                    </div>
                  </li><?php } ?>
                  <li>
                    <i class="fa fa-power-off bg-red"></i>
                  </li>
                </ul>

                <script>
                $(document).ready(function(){
                  var nom_ = document.getElementById("nom_").value;
                  document.getElementById('lbl_par').innerHTML = nom_;

                });
                </script>
