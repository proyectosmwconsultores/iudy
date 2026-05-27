<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  //$IdAs = $_SESSION["IdAsignacion"];
  $IdAs = $_POST["IdAsignacion"];

  $sql8 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.Curso, tblp_asignacion.IdModulo, tblp_grupo.IdPlan FROM tblp_asignacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdAsignacion = '$IdAs'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdPlan = $datos81["IdPlan"];
  $IdModulo = $datos81["IdModulo"];
  $curso = $datos81["Curso"];

  $sql9 = $db->query("SELECT Sum(tblp_actividadesdocente.Porcentaje) AS Avance FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAs' AND tblp_actividadesdocente.IdParcialDocente = '".$_POST["IdParcial"]."' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Avance = $datos91["Avance"];

  $sql = $db->query("SELECT * FROM tblc_tipoactividad");
  $estra = $db->query("SELECT * FROM tblc_herramientas WHERE tblc_herramientas.Tipo = '1' ORDER BY tblc_herramientas.Herramienta ASC");
  $tecni = $db->query("SELECT * FROM tblc_herramientas WHERE tblc_herramientas.Tipo = '2' ORDER BY tblc_herramientas.Herramienta ASC");
  $herra = $db->query("SELECT * FROM tblc_herramientas WHERE tblc_herramientas.Tipo = '3' ORDER BY tblc_herramientas.Herramienta ASC");
  
  ?>
  <form name="frm2TYj" id="frm2TYj" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdOferta" name="IdOferta" value="<?php echo $_POST["IdOferta"]; ?>" type="hidden"/>
    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdParcial" name="IdParcial" value="<?php echo $_POST["IdParcial"]; ?>" type="hidden"/>
    <input id="IdSemana" name="IdSemana" value="<?php echo $_POST["IdSemana"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savActividad" type="hidden"/>
    <input id="Proyecto" name="Proyecto" value="0" type="hidden"/>
    <input id="tipo_act" name="tipo_act" value="" type="hidden"/>
    <input id="IdPlan" name="IdPlan" value="<?php echo $IdPlan; ?>" type="hidden"/>
    <input id="IdTema" name="IdTema" value="<?php if(isset($IdTema)){ echo $IdTema; } ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-4">
          <div class="form-group">
            <label>Tipo actividad:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select class="form-control" name="txtTipoA" id="txtTipoA" onchange="valActividad()">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql)){ ?>
                <option value="<?php echo $x["IdTipoActividad"]; ?>"> <?php echo $x["TipoActividad"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label id='lbl_nombre'>Nombre:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-flag-o"></i>
              </div>

                <input class="form-control" type="text" name="txtActividad" id="txtActividad">
                <?php if($IdPlan){ ?>
                    <span class="input-group-btn">
                      <button id="mostrar" onclick="mostrarPlan(1)" type="button" class="btn btn-info btn-flat">Ver proyecto</button>
                      <button id="ocultar" onclick="mostrarPlan(0)" type="button" style="display: none;" class="btn btn-info btn-flat">Cerrar proyecto</button>
                    </span><?php } ?>

            </div>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="form-group">
            <label id='lbl_desc'>Descripci&oacute;n:</label>
              <textarea name="txtDescripcion" id="txtDescripcion" class="textarea" placeholder="Escriba la instrucción de la actividad..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Estrategías:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-book"></i>
              </div>
              <select class="form-control" name="txtEstrategias" id="txtEstrategias">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($estra)){ ?>
                <option value="<?php echo $x["Herramienta"]; ?>"> <?php echo $x["Herramienta"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Técnicas:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-book"></i>
              </div>
              <select class="form-control" name="txtTecnica" id="txtTecnica">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($tecni)){ ?>
                <option value="<?php echo $x["Herramienta"]; ?>"> <?php echo $x["Herramienta"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Herramientas:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-book"></i>
              </div>
              <select class="form-control" name="txtHerramienta" id="txtHerramienta">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($herra)){ ?>
                <option value="<?php echo $x["Herramienta"]; ?>"> <?php echo $x["Herramienta"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Fecha inicial:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Fecha final:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
            </div>
          </div>
        </div>
        <div class="col-md-4" id="divPorce">
          <div class="form-group">
            <label>Porcentaje:</label>
            <div class="input-group">
              <input name="txtPorcentaje" id="txtPorcentaje" class="form-control" type="number" >
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>Total pocentaje del parcial: <?php echo $Avance; ?> %:</label>
            <div class="progress progress-sm active">
              <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $Avance; ?>%">
                <span class="sr-only">20% Complete</span>
              </div>
            </div>
          </div>
        </div>




        </div>
        <div class="modal-footer">
          <div class="form-group pull-left" id="divEntrega">
            <label class="col-sm-6 control-label" style="padding-top: 6px;">Tipo entrega: </label>
                  <div class="col-sm-6">
                    <select class="form-control" name="txtEntrega" id="txtEntrega">
                      <option value=""> - Seleccione - </option>
                      <option value="1">Individual</option>
                      <option value="2">Equipo</option>
                    </select>
                  </div>

                </div>
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="saveActividad()"> <i class="fa fa-fw fa-save"></i> Guardar</button>

        </div>
      </div>
    </table>
  </div>

  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>

  function valActividad(){
    var TipoActividad = document.getElementById("txtTipoA").value;
    if(TipoActividad == 3){
      document.getElementById("divEntrega").style.display = 'block';
    } else {
      document.getElementById("divEntrega").style.display = 'none';
    }
    if(TipoActividad == 4){
      document.getElementById("divPorce").style.display = 'none';
    } else {
      document.getElementById("divPorce").style.display = 'block';
    }

    if(TipoActividad == 1){ document.getElementById('lbl_nombre').innerHTML = "Nombre de la evaluación:"; document.getElementById('lbl_desc').innerHTML = "Descripción de la evaluación:"; }
    if(TipoActividad == 2){ document.getElementById('lbl_nombre').innerHTML = "Nombre del foro:"; document.getElementById('lbl_desc').innerHTML = "Descripción del foro:"; }
    if(TipoActividad == 3){ document.getElementById('lbl_nombre').innerHTML = "Nombre de la actividad:"; document.getElementById('lbl_desc').innerHTML = "Descripción de la actividad a desarrollar:"; }
    if(TipoActividad == 4){ document.getElementById('lbl_nombre').innerHTML = "Nombre del contenido:"; document.getElementById('lbl_desc').innerHTML = "Descripción del contenido:"; }


  }
  function mostrarPlan(Opcion){
    if(Opcion == 1){
      document.getElementById("divPlan").style.display = 'block';
      document.getElementById("mostrar").style.display = 'none';
      document.getElementById("ocultar").style.display = 'block';
      document.getElementById("Proyecto").value = '1';
    } else {
      document.getElementById("divPlan").style.display = 'none';
      document.getElementById("mostrar").style.display = 'block';
        document.getElementById("ocultar").style.display = 'none';
        document.getElementById("Proyecto").value = '0';
    }

  }
  $(function () {
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })
  //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })

    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
