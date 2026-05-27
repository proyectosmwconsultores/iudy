<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '".$_POST["IdActividadDoc"]."' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdAs =  $datos91["IdAsignacion"];
  $IdParcial =  $datos91["IdParcialDocente"];
  $IdPlan =  $datos91["IdPlan"];
  $IdTema =  $datos91["IdTema"];
  $IdEtapa =  $datos91["IdEtapa"];


  $sql8 = $db->query("SELECT Sum(tblp_actividadesdocente.Porcentaje) AS Avance FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAs' AND tblp_actividadesdocente.IdParcialDocente = '$IdParcial' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Avance = $datos81["Avance"];


  $sql = $db->query("SELECT * FROM tblc_tipoactividad");

  $estra = $db->query("SELECT * FROM tblc_herramientas WHERE tblc_herramientas.Tipo = '1' ORDER BY tblc_herramientas.Herramienta ASC");
  $tecni = $db->query("SELECT * FROM tblc_herramientas WHERE tblc_herramientas.Tipo = '2' ORDER BY tblc_herramientas.Herramienta ASC");
  $herra = $db->query("SELECT * FROM tblc_herramientas WHERE tblc_herramientas.Tipo = '3' ORDER BY tblc_herramientas.Herramienta ASC");
  

if($IdPlan){ $pro = 1; } else {$pro = 0; }
  ?>
  <form name="frm2Vb" id="frm2Vb" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $_POST["IdActividadDoc"]; ?>" type="hidden"/>
    <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $IdParcial; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updActividadDoc" type="hidden"/>
    <input id="Proyecto" name="Proyecto" value="<?php echo $pro; ?>" type="hidden"/>
    <input id="id_tipo" name="id_tipo" value="<?php echo $datos91["IdTipoActividad"]; ?>" type="hidden"/>
    <input id="tipo_act" name="tipo_act" value="<?php echo $datos91["IdTipo"]; ?>" type="hidden"/>

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
              <select class="form-control" name="txtTipoAU" id="txtTipoAU">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql)){ ?>
                <option value="<?php echo $x["IdTipoActividad"]; ?> " <?php if($datos91["IdTipoActividad"]==$x["IdTipoActividad"]){ ?>selected="selected"<?php } ?> > <?php echo $x["TipoActividad"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label>Nombre de la actividad:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-flag-o"></i>
              </div>
              <input name="txtActividad1" id="txtActividad1" class="form-control" value='<?php echo $datos91["NomActividad"]; ?>' >
            </div>
          </div>
        </div>
        <?php if($IdPlan){
          $sql2 = $db->query("SELECT * FROM tblp_planetapa WHERE tblp_planetapa.IdPlan ='$IdPlan' AND tblp_planetapa.IdTema = '$IdTema' ");
          $sql6 = $db->query("SELECT * FROM tblp_plantemas WHERE tblp_plantemas.IdTema = '$IdTema'");
          $db->rows($sql6);
          $datos61 = $db->recorrer($sql6);
          $Tema = $datos61["Tema"];
          $Comple = $datos61["Complejidad"];
          ?>
          <div class="col-md-8">
            <div class="form-group">
              <label>Tendencias y temas actuales:</label>
              <div class="input-group">
                  <p>"<?php echo $Tema.' / '.$Comple; ?>"</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label>Etapa de la metodolog&iacute;a:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-flag-o"></i>
                </div>
                <select class="form-control" name="txtEtapaU" id="txtEtapaU">
                  <option value=""> - Seleccione - </option>
                  <?php while($y = $db->recorrer($sql2)){ ?>
                  <option value="<?php echo $y["IdEtapa"]; ?>" <?php if($y["IdEtapa"] == $IdEtapa){?>selected="selected"<?php }?>> Etapa <?php echo $y["Etapa"]; ?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

        <?php } ?>

        
        <div class="col-md-12">
          <div class="form-group">
            <label id='lbl_desc'>Descripci&oacute;n:</label>
              <textarea name="txtDescripcion1" id="txtDescripcion1" class="textareavbd" placeholder="Escriba la instrucción de la actividad..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $datos91["DesActividad"]; ?></textarea>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Estrategías:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-book"></i>
              </div>
              <select class="form-control" name="txtEstrategiax" id="txtEstrategiax">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($estra)){ ?>
                <option value="<?php echo $x["Herramienta"]; ?>" <?php if($datos91["Estrategia"]==$x["Herramienta"]){ ?>selected="selected"<?php } ?>> <?php echo $x["Herramienta"]; ?> </option>
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
              <select class="form-control" name="txtTecnicax" id="txtTecnicax">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($tecni)){ ?>
                <option value="<?php echo $x["Herramienta"]; ?>" <?php if($datos91["Tecnica"]==$x["Herramienta"]){ ?>selected="selected"<?php } ?>> <?php echo $x["Herramienta"]; ?> </option>
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
              <select class="form-control" name="txtHerramientax" id="txtHerramientax">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($herra)){ ?>
                <option value="<?php echo $x["Herramienta"]; ?>" <?php if($datos91["Herramienta"]==$x["Herramienta"]){ ?>selected="selected"<?php } ?>> <?php echo $x["Herramienta"]; ?> </option>
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
              <input type="text" class="form-control pull-right" id="datepicker111" name="datepicker111" value="<?php echo $datos91["FecIni"]; ?>">
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
              <input type="text" class="form-control pull-right" id="datepicker222" name="datepicker222" value="<?php echo $datos91["FecFin"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Porcentaje:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-line-chart"></i>
              </div>
              <input <?php if($datos91["IdTipoActividad"] == 4){ echo "disabled"; } ?> name="txtPorcentajex" id="txtPorcentajex" class="form-control" type="number" value="<?php echo $datos91["Porcentaje"]; ?>">
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
          <div class="form-group pull-left">
            <label class="col-sm-6 control-label" style="padding-top: 6px;">Tipo entrega: </label>
                  <div class="col-sm-6">
                    <select class="form-control" name="txtEntregaU" id="txtEntregaU" <?php if($datos91["IdTipoActividad"] <> 3){ echo "disabled"; } ?>>
                      <option value=""> - Seleccione - </option>
                      <option value="1" <?php if($datos91["Modalidad"] == 1){ ?>selected="selected"<?php } ?> > Individual </option>
                      <option value="2" <?php if($datos91["Modalidad"] == 2){ ?>selected="selected"<?php } ?> > Equipo </option>
                    </select>
                  </div>

                </div>

          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updActividadDoc()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
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
$(function () {
 

// tipo_act
  //Date picker
  $('#datepicker111').datepicker({
    autoclose: true
  })
//Date picker
  $('#datepicker222').datepicker({
    autoclose: true
  })

  //bootstrap WYSIHTML5 - text editor
  $('.textareavbd').wysihtml5()
})


</script>
