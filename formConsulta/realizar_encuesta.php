<?php
include('../hace.php');
  $IdEvaluacionX =  $_POST["employee_id"];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $Es = 0;
  $_dispo = 0;
  $sql8 = $db->query("SELECT * FROM tblx_evaluacion WHERE tblx_evaluacion.IdEvaluacionX =  '$IdEvaluacionX'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Id_est = $datos81['IdEstatus'];
  $f_ini = $datos81['Ini'];
  $f_fin = $datos81['Fin'];
  $IdAsignacion = $datos81['IdAsignacion'];
  if(!$f_ini){
    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Ini = NOW() WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
  }
 ?>
  <form name="frm" id="frm" action="realizar_encuesta.php.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo  $_POST["employee_id"]; ?>">
        <?php
           $sql = $db->query("SELECT tblx_respuesta.IdRespuesta, tblx_pregunta.Tipo, tblx_pregunta.Pregunta, tblx_pregunta.IdPregunta, tblx_pregunta._Tipo, tblx_modulo.Nombre_mod, tblx_bloque.Bloque, tblx_pregunta.IdMod, tblx_pregunta.IdBloque
             FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod Left Join tblx_bloque ON tblx_bloque.IdBloque = tblx_pregunta.IdBloque WHERE tblx_respuesta.IdEvaluacion = '$IdEvaluacionX' AND tblx_respuesta.IdEstatus = '8' ORDER BY tblx_pregunta.IdMod ASC, tblx_pregunta.IdBloque ASC "); ?>
             <table class="table table-striped" style="font-size: 12px;">
                <tbody>
                <?php $mi= 0; $mf = 0; $bi= 0; $bf= 0; while($x = $db->recorrer($sql)){ $Es = 1; $mi= $x["IdMod"]; $bi= $x["IdBloque"];
                  $pTipo = $x["_Tipo"];
                  $idPreg = $x["IdPregunta"];
                  if($mi <> $mf){ ?>
                    <tr>
                      <td colspan="5" style="background: #001F3F; color: white; text-align: center;"><b><i class="fa fa-fw fa-flag-checkered"></i> <?php echo $x["Nombre_mod"]; ?></b></td>
                    </tr>
                  <?php }
                  if($bi <> $bf){ ?>
                    <tr>
                      <td colspan="5" style="background: #dd4b39; color: black;"><i class="fa fa-fw fa-bookmark-o"></i> <?php echo $x["Bloque"]; ?></td>
                    </tr>
                  <?php } ?>
                <tr>
                  <td colspan="5" style="background: #cbddff; color: black;"><i class="fa fa-fw fa-question-circle"></i> <?php echo $x["Pregunta"]; ?></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <?php if($pTipo == 1){
                      $sql6 = $db->query("SELECT * FROM tblxx_respuesta WHERE tblxx_respuesta.IdPregunta = '$idPreg' AND tblxx_respuesta.IdEstatus = '8' ");
                      while($m = $db->recorrer($sql6)){
                      ?>
                        <a onClick="add_respuesta(<?php echo $m['Valor']; ?>,<?php echo $x['IdRespuesta']; ?>,<?php echo $IdEvaluacionX; ?>)" class="btn btn-app" style="margin-left: 40px; height: auto;">
                          <?php echo $m['Texto']; ?>
                        </a>
                  <?php } } else { ?>
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="txtRes-<?php echo $x['IdRespuesta']; ?>" id="txtRes-<?php echo $x['IdRespuesta']; ?>"></textarea>
                    <br>
                    <button type="button" onclick="saveEnc(<?php echo $x['IdRespuesta']; ?>,<?php echo $IdEvaluacionX; ?>)" class="btn btn-info pull-right">Guardar respuesta</button>
                  <?php } ?>
                  </td>
                </tr>

              <?php $mf= $x["IdMod"]; $bf= $x["IdBloque"]; } ?>

              </tbody></table>
      <?php

         if(($Es == 0) && ($Id_est == 8)){
           $IdT = $datos81['IdTipo'];
           $_dispo = 0;
           $sql7 = $db->query("SELECT tblc_tipoevaluacion.Cve FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion =  '$IdT'");
           $db->rows($sql7);
           $datos71 = $db->recorrer($sql7);
           $_cve = $datos71['Cve'];
           if($_cve == 2){
             $_dispo = 2;
           } else {
             $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Fin = NOW(), tblx_evaluacion.IdEstatus = '10' WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
             $Id_est = 10;
           }

         }

         if($Id_est == 10){
           $IdT = $datos81['IdTipo'];
           $sql7 = $db->query("SELECT tblc_tipoevaluacion.Cve FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion =  '$IdT'");
           $db->rows($sql7);
           $datos71 = $db->recorrer($sql7);
           $_cvex = $datos71['Cve'];
            ?>
           <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
              <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
              <div class="info-box-content">
                <span class="info-box-number">Completado 100%</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                      Inició: <?php echo $f_ini;  ?> finalizó: <?php echo $f_fin; ?>
                    </span>
              </div>
            </div>
          </div><br><br><br><br>
          <?php if($_cvex == 2){ $IdUsua = $datos81['IdUsua']; ?>
            <button onclick="window.open('repositorio/portafolio/cedula_pre-egreso.php?idToks=<?php echo time().$IdUsua; ?>','_blank')" href="javascript:void(0);" title="Descargar cédula" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-fw fa-cloud-download"></i> Descargar cédula de pre-egreso</button>
          <?php } ?>
        <?php }
        if($_dispo == 2){
          $IdGrupo = $datos81['IdGrupo'];
          $IdUsua = $datos81['IdUsua'];
          $sql_d = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_educativa.Nombre, tblp_educativa.IdGrado, tblc_modalidad._Modalidad, tblc_dias_clases._Dias, tblp_grupo.TipoCiclo, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
          $db->rows($sql_d);
          $_dat = $db->recorrer($sql_d);

          $sql_us = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Correo,
tblc_usuario.SemCua,
tblc_usuario.Telefono,
tblc_usuario.Grado,
tblc_usuario.Sexo,
tblc_usuario.Celular,
tblp_informacion.ENombre,
tblp_informacion.ETelefono,
tblp_informacion.EParentesco,
tblp_informacion.E_escuela_procedencia,
tblp_informacion.E_estudio,
tblp_informacion.E_promedio,
tblp_informacion.E_titulo,
tblp_informacion.E_cedula,
tblp_informacion.E_posgrado,
tblp_informacion.E_opcion_titulacion,
tblp_informacion.D_direccion,
tblp_informacion.P_civil,
tblp_informacion.E_opcion_titulacion,
tblp_informacion.Ocupacion,
tblp_informacion.Trabaja,
tblp_informacion.Tel_trabajo,
tblp_informacion.Facebook,
tblp_informacion.Twitter,
tblp_informacion.ENombre,
tblp_informacion.ETelefono,
tblp_informacion.EParentesco,
tblp_informacion.ECelular,
tblp_informacion.ETelTrabajo,
tblp_informacion.EDireccion,
tblp_informacion.ENombre2,
tblp_informacion.ETelefono2,
tblp_informacion.EParentesco2,
tblp_informacion.ECelular2,
tblp_informacion.ETelTrabajo2,
tblp_informacion.EDireccion2
FROM
tblc_usuario
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
WHERE
tblc_usuario.IdUsua =  '$IdUsua'
");
          $db->rows($sql_us);
          $_us = $db->recorrer($sql_us);



          if($_dat['IdGrado'] == 1){ $txt_a = "Maestría"; $txt_c = "Universidad"; }
          if($_dat['IdGrado'] == 2){ $txt_a = "Licenciatura"; $txt_c = "Universidad"; }
          if($_dat['IdGrado'] == 3){ $txt_a = "Bachillerato"; $txt_c = "Escuela"; }

           ?>
          <div class="row" style="margin-top: -20px;">
            <div class="col-md-12">
            <div class="bg-navy color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-bookmark-o"></i> <?php echo $_dat['Nombre'].' - '.$_dat['_Modalidad'].' - '.$_dat['_Dias']; ?></span></div>
            <table class="table table-striped" style="font-size: 12px;">
              <tbody>
                <tr>
                  <td style="text-align: right; width: 180px;"><b>GRUPO:</b></td>
                  <td><?php echo $_dat['CveGrupo']; ?></td>
                  <td><?php echo $_us['SemCua']; ?>° <?php if($_dat['TipoCiclo'] == 'S'){ echo "SEMESTRE"; } else { echo "CUATRIMESTRE"; } ?></td>
                </tr>
                <tr>
                  <td style="text-align: right;"><b>NOMBRE COMPLETO:</b></td>
                  <td colspan="2"><?php echo $_us['APaterno'].' '.$_us['AMaterno'].' '.$_us['Nombre']; ?></td>
                </tr>
            </tbody></table>
            <div class="bg-aqua color-palette" style="padding: 5px; text-align: center;"><span><i class="fa fa-fw fa-map-signs"></i> DATOS PERSONALES</span></div>
            <br>
          </div>
              <div class="col-md-12">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Direccion:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
          						  <input class="form-control" id="txtDire" name="txtDire" type="text" value="<?php echo $_us['D_direccion']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-6">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Correo:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-book"></i>
          						  </div>
          						  <input class="form-control" id="txtCorr" name="txtCorr" type="text" value="<?php echo $_us['Correo']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
          			<div class="col-md-3">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Celular:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtCelu" name="txtCelu" type="text" value="<?php echo $_us['Celular']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Teléfono:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtTele" name="txtTele" type="text" value="<?php echo $_us['Telefono']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Ocupación:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtOcup" name="txtOcup" type="text" value="<?php echo $_us['Ocupacion']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>¿Donde trabaja?:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtTrab" name="txtTrab" type="text" value="<?php echo $_us['Trabaja']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Teléfono trabajo:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtTelTra" name="txtTelTra" type="text" value="<?php echo $_us['Tel_trabajo']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Estado civil:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
                        <select class="form-control select2" name="txtCivi" id="txtCivi">
                          <option value="">- Seleccione -</option>
                          <option value="1" <?php if($_us["P_civil"]=="1"){?>selected="selected"<?php } ?> > SOLTERO </option>
                          <option value="2" <?php if($_us["P_civil"]=="2"){?>selected="selected"<?php } ?> > CASADO </option>
                          <option value="3" <?php if($_us["P_civil"]=="3"){?>selected="selected"<?php } ?> > UNION LIBRE </option>
                          <option value="4" <?php if($_us["P_civil"]=="4"){?>selected="selected"<?php } ?> > VIUDO </option>
                          <option value="5" <?php if($_us["P_civil"]=="5"){?>selected="selected"<?php } ?> > DIVORCIADO </option>
                        </select>
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Facebook:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtFace" name="txtFace" type="text" value="<?php echo $_us['Facebook']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-4">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Twitter:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtTwtt" name="txtTwtt" type="text" value="<?php echo $_us['Twitter']; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-6">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label><?php echo $txt_c; ?> de donde egreso:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtEgre" name="txtEgre" type="text" value="<?php echo $_us["E_escuela_procedencia"]; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-6">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label><?php echo $txt_a; ?> cursada:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtCurs" name="txtCurs" type="text" value="<?php echo $_us["E_estudio"]; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>¿Está titulado?:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
                        <select class="form-control" name="txt_titu" id="txt_titu">
                          <option value="">- Seleccione -</option>
                          <option value="SI" <?php if($_us["E_titulo"]=="SI"){?>selected="selected"<?php } ?> > SI </option>
                          <option value="NO" <?php if($_us["E_titulo"]=="NO"){?>selected="selected"<?php } ?> > NO </option>
                        </select>
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-6">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Especifique la opción de titulación:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
                        <select class="form-control select2" name="txtOxTix" id="txtOxTix">
                          <option value="">- Seleccione -</option>
                          <option value="CENEVAL" <?php if($_us["E_opcion_titulacion"]=="CENEVAL"){?>selected="selected"<?php } ?> > CENEVAL </option>
                          <?php if($_dat['IdGrado'] == 1){ ?>
                          <option value="CREDITOS DOCTORADO" <?php if($_us["E_opcion_titulacion"]=="CREDITOS DOCTORADO"){?>selected="selected"<?php } ?> > CREDITOS DOCTORADO </option>
                          <?php } ?>
                          <?php if($_dat['IdGrado'] == 2){ ?>
                          <option value="CREDITOS MAESTRIA" <?php if($_us["E_opcion_titulacion"]=="CREDITOS MAESTRIA"){?>selected="selected"<?php } ?> > CREDITOS MAESTRIA </option>
                          <?php } ?>
                          <option value="EXAMEN GENERAL DE CONOCIMIENTOS" <?php if($_us["E_opcion_titulacion"]=="EXAMEN GENERAL DE CONOCIMIENTOS"){?>selected="selected"<?php } ?> > EXAMEN GENERAL DE CONOCIMIENTOS </option>
                          <option value="PROMEDIO GENERAL" <?php if($_us["E_opcion_titulacion"]=="PROMEDIO GENERAL"){?>selected="selected"<?php } ?> > PROMEDIO GENERAL </option>
                          <option value="TESIS" <?php if($_us["E_opcion_titulacion"]=="TESIS"){?>selected="selected"<?php } ?> > TESIS </option>
                        </select>
          						</div>
          					</div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          					<div class="form-group">
          						<label>Promedio Licenciatura:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <input class="form-control" id="txtProm" name="txtProm" type="text" value="<?php echo $_us["E_promedio"]; ?>">
          						</div>
          					</div>
          			  </div>
          			</div>


                <div class="col-md-12">
                  <div class="box-primary">
                    <div class="bg-aqua color-palette" style="padding: 5px; text-align: center;"><span><i class="fa fa-fw fa-users"></i> REFERENCIAS PERSONALES, DE PREFERENCIA "PAPÁ, MAMÁ O PARIENTES CERCANOS</span></div>
                    <div class="bg-maroon disabled color-palette" style="padding: 5px; text-align: center;"><span>Referencia 1</span></div>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="box-primary">
                    <div class="form-group">
                      <label><b style="color: red;">*</b> Nombre:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtNom1" name="txtNom1" type="text" value="<?php echo $_us["ENombre"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label><b style="color: red;">*</b> Parentesco:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtParen1" name="txtParen1" type="text" value="<?php echo $_us["EParentesco"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="box-primary">
                    <div class="form-group">
                      <label>Dirección:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtDire1" name="txtDire1" type="text" value="<?php echo $_us["EDireccion"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label><b style="color: red;">*</b> Celular:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtCel1" name="txtCel1" type="text" value="<?php echo $_us["ECelular"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label>Teléfono:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtTel1" name="txtTel1" type="text" value="<?php echo $_us["ETelefono"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label>Teléfono trabajo:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtTelTra1" name="txtTelTra1" type="text" value="<?php echo $_us["ETelTrabajo"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="box-primary">
                    <div class="bg-maroon disabled color-palette" style="padding: 5px; text-align: center;"><span>Referencia 2</span></div>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="box-primary">
                    <div class="form-group">
                      <label><b style="color: red;">*</b> Nombre:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtNom2" name="txtNom2" type="text" value="<?php echo $_us["ENombre2"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label><b style="color: red;">*</b> Parentesco:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtParen2" name="txtParen2" type="text" value="<?php echo $_us["EParentesco2"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="box-primary">
                    <div class="form-group">
                      <label>Dirección:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtDire2" name="txtDire2" type="text" value="<?php echo $_us["EDireccion2"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label><b style="color: red;">*</b> Celular:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtCel2" name="txtCel2" type="text" value="<?php echo $_us["ECelular2"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label>Teléfono:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtTel2" name="txtTel2" type="text" value="<?php echo $_us["ETelefono2"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-primary">
                    <div class="form-group">
                      <label>Teléfono trabajo:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                        </div>
                        <input class="form-control" id="txtTelTra2" name="txtTelTra2" type="text" value="<?php echo $_us["ETelTrabajo2"]; ?>">
                      </div>
                    </div>
                  </div>
                </div>



          </div>



          <button onclick="sav_cedx_us(<?php echo $IdUsua; ?>,<?php echo $IdEvaluacionX; ?>)" type="button" class="btn btn-block btn-warning btn-sm"><i class="fa fa-fw fa-save"></i> Guardar y generar cédula</button>
       <?php } ?>



  </form>

<script>

  function sav_cedx_us(IdUsua,IdEvaluacionX){

    var employee_id = document.getElementById("employee_id").value;
    var Dire = document.getElementById("txtDire").value;
    var Corr = document.getElementById("txtCorr").value;
    var Celu = document.getElementById("txtCelu").value;
    var Tele = document.getElementById("txtTele").value;
    var Ocup = document.getElementById("txtOcup").value;
    var Trab = document.getElementById("txtTrab").value;
    var TelTra = document.getElementById("txtTelTra").value;
    var Civil = document.getElementById("txtCivi").value;
    var Face = document.getElementById("txtFace").value;
    var Twitter = document.getElementById("txtTwtt").value;
    var Egre = document.getElementById("txtEgre").value;
    var Curs = document.getElementById("txtCurs").value;
    var Titu = document.getElementById("txt_titu").value;
    var Otit = document.getElementById("txtOxTix").value;
    var Prom = document.getElementById("txtProm").value;

    var Nom1 = document.getElementById("txtNom1").value;
    var Nom2 = document.getElementById("txtNom2").value;
    var Paren1 = document.getElementById("txtParen1").value;
    var Paren2 = document.getElementById("txtParen2").value;
    var Dire1 = document.getElementById("txtDire1").value;
    var Dire2 = document.getElementById("txtDire2").value;
    var Cel1 = document.getElementById("txtCel1").value;
    var Cel2 = document.getElementById("txtCel2").value;
    var Tel1 = document.getElementById("txtTel1").value;
    var Tel2 = document.getElementById("txtTel2").value;
    var Tra1 = document.getElementById("txtTelTra1").value;
    var Tra2 = document.getElementById("txtTelTra2").value;

    if (Dire==''){
  		swal("Error al guardar", "Debe ingresar su dirección.", "error");
      document.getElementById("txtDire").focus();
      return 0;
    }
    if (Corr==''){
  		swal("Error al guardar", "Debe ingresar su correo.", "error");
      document.getElementById("txtCorr").focus();
      return 0;
    }
    if (Celu==''){
  		swal("Error al guardar", "Debe ingresar su celular.", "error");
      document.getElementById("txtCelu").focus();
      return 0;
    }
    if (Celu==''){
  		swal("Error al guardar", "Debe ingresar su celular.", "error");
      document.getElementById("txtCelu").focus();
      return 0;
    }

    if (Nom1==''){
  		swal("Error al guardar", "Debe escribir el nombre.", "error");
      document.getElementById("txtNom1").focus();
      return 0;
    }
    if (Paren1==''){
  		swal("Error al guardar", "Debe escribir el parentesco.", "error");
      document.getElementById("txtParen1").focus();
      return 0;
    }
    if (Cel1==''){
  		swal("Error al guardar", "Debe escribir el número de celular.", "error");
      document.getElementById("txtCel1").focus();
      return 0;
    }
    if (Nom2==''){
  		swal("Error al guardar", "Debe escribir el nombre.", "error");
      document.getElementById("txtNom2").focus();
      return 0;
    }
    if (Paren2==''){
  		swal("Error al guardar", "Debe escribir el parentesco.", "error");
      document.getElementById("txtParen2").focus();
      return 0;
    }
    if (Cel2==''){
  		swal("Error al guardar", "Debe escribir el número de celular.", "error");
      document.getElementById("txtCel2").focus();
      return 0;
    }

    var TipoGuardar = "sav_datos_cedula";
  	swal({
  		title: "\u00BFEst\u00E1 seguro que desea guadar estos?",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: '#DD6B55',
  		confirmButtonText: 'Aceptar',
  		cancelButtonText: "Cancelar",
  	},
  	function (isConfirm) {
  		if (isConfirm) {
  			$(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",

             data:{TipoGuardar:TipoGuardar, IdEvaluacionX:IdEvaluacionX, IdUsua:IdUsua, Dire:Dire, Corr:Corr, Celu:Celu, Tele:Tele, Ocup:Ocup, Trab:Trab, TelTra:TelTra, Civil:Civil, Face:Face, Twitter:Twitter, Egre:Egre, Curs:Curs, Titu:Titu, Otit:Otit, Prom:Prom, Nom1:Nom1, Nom2:Nom2, Paren1:Paren1, Paren2:Paren2, Dire1:Dire1, Dire2:Dire2, Cel1:Cel1, Cel2:Cel2, Tel1:Tel1, Tel2:Tel2, Tra1:Tra1, Tra2:Tra2},
             success:function(data){

             }
        })
  			.done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "Sus datos se han guardado correctamente, ahora ya puede descargar su acuse.", "success");
            $.ajax({
              url:"formConsulta/realizar_encuesta.php",
              method:"POST",
                 data:{employee_id:employee_id},
                 success:function(data){
                      $('#employee_detailE').html(data);
                      $('#dataModalE').modal('show');
                 }
            });
  				}

  				if(data==0){
  					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
  				}
  			})
  			.error(function(data) {
  				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
  			});
  		}

  	});
  }

  function saveEnc(IdRespuesta,employee_id){
    var Escribir = "txtRes-"+IdRespuesta;

    var Texto = document.getElementById(Escribir).value;
    if (Texto ==''){
        swal("Error al guardar", "Debe escribir en el espacio.", "error");
        document.getElementById(Texto).focus();
        return 0;
    }


    var TipoGuardar = "addEncuestaOtro";
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Texto=' + Texto;
  	$.ajax({
  		type:"POST",
  		url:"insertar.php",
  		data:datos,
  		success:function(data){
        $.ajax({
          url:"formConsulta/realizar_encuesta.php",
          method:"POST",
             data:{employee_id:employee_id},
             success:function(data){
                  $('#employee_detailE').html(data);
                  $('#dataModalE').modal('show');
             }
        });
  		}
  	})

  }

function add_respuesta(Valor,IdRespuesta,employee_id)
{
	var TipoGuardar = "addEncuestaCal";
	var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Valor=' + Valor;
	$.ajax({
		type:"POST",
		url:"insertar.php",
		data:datos,
		success:function(data){ //alert(data);
      $.ajax({
        url:"formConsulta/realizar_encuesta.php",
        method:"POST",
           data:{employee_id:employee_id},
           success:function(data){
                $('#employee_detailE').html(data);
                $('#dataModalE').modal('show');
           }
      });
		}
	})
}
</script>
