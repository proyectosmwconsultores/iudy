<?php $valor = 3;
$section = "Captura de alumno";
include("head.php");
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en la cédula de inscripción.');
}

$usuario = $t->getId_usuarioId(substr($_GET["idToks"], 10, 10));
$info = $t->getId_usuarioInfo(substr($_GET["idToks"], 10, 10));
$est = $t->get_estados();
$titulacion = $t->get_tipo_titulacion($usuario[0]['IdGrado']);
$_mod55 = $t->get_mod_lista_id($_SESSION['IdUsua'], 55);
$idUs = substr($_GET["idToks"], 10, 10);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <i class="fa fa-fw fa-file"></i> Cédula de inscripción
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Cédula</li>
        </ol>
      </section>
      <section class="content">
        <form name="frm" id="frm" action="adCaptura.php" method="POST" enctype="multipart/form-data">
          <input id="TipoGuardar" name="TipoGuardar" value="savCedula" type="hidden" />
          <input id="Mov" name="Mov" value="" type="hidden" />
          <input id="IdUsua" name="IdUsua" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />
          <input type="hidden" name="IdEsta_D" id="IdEsta_D" value="<?php echo $info[0]["D_estado"]; ?>">
          <input type="hidden" name="IdMuni_D" id="IdMuni_D" value="<?php echo $info[0]["D_municipio"]; ?>">
          <input type="hidden" name="IdCiud_D" id="IdCiud_D" value="<?php echo $info[0]["D_ciudad"]; ?>">

          <input type="hidden" name="IdEsta_N" id="IdEsta_N" value="<?php echo $info[0]["Estado"]; ?>">
          <input type="hidden" name="IdCiud_N" id="IdCiud_N" value="<?php echo $info[0]["Ciudad"]; ?>">
          <input type="hidden" name="IdLoca_N" id="IdLoca_N" value="<?php echo $info[0]["Localidad"]; ?>">


          <div class="box box-default">


            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <?php if ($_GET["Ub"] == "A") { ?>
                    <a style="float: left;" class="btn btn-app" onClick="window.open('adAddAlumno.php?C=<?php echo $usuario[0]["IdCampus"]; ?>&O=<?php echo $usuario[0]["IdOferta"]; ?>','_self')" href="javascript:void(0);"><span class="badge bg-success"></span><i class="fa fa-history"></i> Regresar</a>
                  <?php } ?>
                  <?php if ($_GET["Ub"] == "P") { ?>
                    <a style="float: left;" class="btn btn-app" onClick="window.open('addAddSeguimiento.php?idO=<?php echo $usuario[0]['IdOferta']; ?>','_self')" href="javascript:void(0);"><span class="badge bg-success"></span><i class="fa fa-history"></i> Regresar</a>
                  <?php } ?>
                  <?php if ($_GET["Ub"] == "Px") { ?>
                    <a style="float: left;" class="btn btn-app" onClick="window.open('perfil.php?token=<?php echo $_GET['idToks']; ?>','_self')" href="javascript:void(0);"><span class="badge bg-success"></span><i class="fa fa-history"></i> Regresar</a>
                  <?php } ?>
                  <?php if ($_GET["Ub"] == "Py") { ?>
                    <a style="float: left;" class="btn btn-app" onClick="window.open('docVerificar.php?IdUsua=<?php echo $_GET['idToks']; ?>','_self')" href="javascript:void(0);"><span class="badge bg-success"></span><i class="fa fa-history"></i> Regresar</a>
                  <?php } ?>
                  <a style="float: left;" class="btn btn-app" onclick="subir_foto_perfil(<?php echo $idUs; ?>)" href="javascript:void(0);"><span class="badge bg-success"></span><i class="fa fa-camera"></i> Foto</a>
                </div>
              </div>



              <div class="row">
                <div class="col-md-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><i class="fa fa-fw fa-info-circle"></i> Información general</a></li>
                      <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-bookmark"></i> Antecedentes académicos</a></li>
                      <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-map-signs"></i> Domicilio actual</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="activity">
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-user"></i> Información general del alumno</span></div>
                            <br>
                          </div>
                          <input class="form-control" id="txtControl" name="txtControl" type="hidden" value="<?php echo $usuario[0]["Usuario"]; ?>">
                          
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Nombre:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" value="<?php echo $usuario[0]["Nombre"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>A.Paterno:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtPaterno" name="txtPaterno" type="text" value="<?php echo $usuario[0]["APaterno"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>A.Materno:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtMaterno" name="txtMaterno" type="text" value="<?php echo $usuario[0]["AMaterno"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Fec. Nacimiento:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtNac" name="txtNac" type="text" value="<?php echo $usuario[0]["FecNac"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Sexo:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control select2" name="txtSexo" id="txtSexo">
                                  <option value=""> - Seleccione - </option>
                                  <option value="M" <?php if ($usuario[0]["Sexo"] == "M") { ?>selected="selected" <?php } ?>> MUJER </option>
                                  <option value="H" <?php if ($usuario[0]["Sexo"] == "H") { ?>selected="selected" <?php } ?>> HOMBRE </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Celular:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtCel" name="txtCel" type="text" value="<?php echo $usuario[0]["Celular"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Teléfono:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtTelefono" name="txtTelefono" type="text" value="<?php echo $usuario[0]["Telefono"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Tipo de sangre:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtSangre" name="txtSangre" type="text" value="<?php echo $info[0]["Sangre"]; ?>">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Correo personal:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtCorreo" name="txtCorreo" type="text" value="<?php echo $usuario[0]["Correo"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Correo institucional:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtInstitucional" name="txtInstitucional" type="text" value="<?php echo $usuario[0]["Correo_institucional"]; ?>">
                              </div>
                            </div>
                          </div>
                          <!-- <input class="form-control" id="txtSangre" name="txtSangre" type="hidden" value=""> -->



                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Estado civil:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control select2" name="txtCivil" id="txtCivil">
                                  <option value="">- Seleccione -</option>
                                  <option value="1" <?php if ($info[0]["P_civil"] == "1") { ?>selected="selected" <?php } ?>> SOLTERO </option>
                                  <option value="2" <?php if ($info[0]["P_civil"] == "2") { ?>selected="selected" <?php } ?>> CASADO </option>
                                  <option value="3" <?php if ($info[0]["P_civil"] == "3") { ?>selected="selected" <?php } ?>> UNION LIBRE </option>
                                  <option value="4" <?php if ($info[0]["P_civil"] == "4") { ?>selected="selected" <?php } ?>> VIUDO </option>
                                  <option value="5" <?php if ($info[0]["P_civil"] == "5") { ?>selected="selected" <?php } ?>> DIVORCIADO </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>CURP:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtCurp" name="txtCurp" type="text" value="<?php echo $info[0]["P_curp"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Económicamente depende de:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control select2" name="txtDepende" id="txtDepende">
                                  <option value="">- Seleccione -</option>
                                  <option value="MI PADRE" <?php if ($info[0]["P_depende"] == "MI PADRE") { ?>selected="selected" <?php } ?>> MI PADRE </option>
                                  <option value="MI MADRE" <?php if ($info[0]["P_depende"] == "MI MADRE") { ?>selected="selected" <?php } ?>> MI MADRE </option>
                                  <option value="AMBOS" <?php if ($info[0]["P_depende"] == "AMBOS") { ?>selected="selected" <?php } ?>> AMBOS </option>
                                  <option value="MI MISMO" <?php if ($info[0]["P_depende"] == "MI MISMO") { ?>selected="selected" <?php } ?>> MI MISMO </option>
                                  <option value="OTRO" <?php if ($info[0]["P_depende"] == "OTRO") { ?>selected="selected" <?php } ?>> OTRO </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>¿Actualmente trabaja?:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control select2" name="txtTrabaja" id="txtTrabaja" onchange="sel_trabajo()">
                                  <option value="">- Seleccione -</option>
                                  <option value="SI" <?php if ($info[0]["P_trabaja"] == "SI") { ?>selected="selected" <?php } ?>> SI </option>
                                  <option value="NO" <?php if ($info[0]["P_trabaja"] == "NO") { ?>selected="selected" <?php } ?>> NO </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>¿Algún padecimiento? ¿Cuál?:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input type="text" class="form-control" name="txt_cual" id="txt_cual" value="<?php echo $info[0]["_Cual"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div id="div_labora" style="display: none;">
                            <div class="col-md-12">
                              <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-bank"></i> Información de la empresa donde labora</span></div>
                              <br>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Nombre de la empresa:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtLnom" name="txtLnom" type="text" value="<?php echo $info[0]["LNombre"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Teléfono:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtLtel" name="txtLtel" type="text" value="<?php echo $info[0]["LTelefono"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Extensión:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtLext" name="txtLext" type="text" value="<?php echo $info[0]["LExtension"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Puesto desempeñado:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txLPuesto" name="txLPuesto" type="text" value="<?php echo $info[0]["LPuesto"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label>Dirección:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtLdire" name="txtLdire" type="text" value="<?php echo $info[0]["LDireccion"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Correo electrónico:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtLcorreo" name="txtLcorreo" type="text" value="<?php echo $info[0]["LCorreo"]; ?>">
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-book"></i> Formación académica</span></div>
                            <br>
                          </div>

                          <div class="col-md-8">
                            <div class="form-group">
                              <label>Carrera:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $usuario[0]["Educativa"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Nivel:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $usuario[0]["_Grado"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Grupo:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $usuario[0]["CveGrupo"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Turno:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $usuario[0]["Turno"] . ' - ' . $usuario[0]["_Dias"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Modalidad:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $usuario[0]["_Modalidad"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Tipo:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" name="txtTipIng" id="txtTipIng">
                                  <option value="">- Seleccione -</option>
                                  <option value="REGULAR" <?php if ($info[0]["C_tipo"] == "REGULAR") { ?>selected="selected" <?php } ?>> REGULAR</option>
                                  <option value="EQUIVALENCIA" <?php if ($info[0]["C_tipo"] == "EQUIVALENCIA") { ?>selected="selected" <?php } ?>> EQUIVALENCIA</option>
                                  <option value="CONVALIDACION" <?php if ($info[0]["C_tipo"] == "CONVALIDACION") { ?>selected="selected" <?php } ?>> CONVALIDACIÓN</option>
                                  <option value="EQUIVALENCIA" <?php if ($info[0]["C_tipo"] == "EQUIVALENCIA") { ?>selected="selected" <?php } ?>> EQUIVALENCIA</option>
                                  <option value="REVALIDACION" <?php if ($info[0]["C_tipo"] == "REVALIDACION") { ?>selected="selected" <?php } ?>> REVALIDACIÓN</option>

                                  <!-- <option value="REPETIDOR" <?php // if ($info[0]["C_tipo"] == "REPETIDOR") { ?>selected="selected" <?php //} ?>> REPETIDOR</option>
                                  <option value="REINGRESO" <?php //if ($info[0]["C_tipo"] == "REINGRESO") { ?>selected="selected" <?php //} ?>> REINGRESO</option>
                                  <option value="CAMBIO DE PLANTEL" <?php //if ($info[0]["C_tipo"] == "CAMBIO DE PLANTEL") { ?>selected="selected" <?php //} ?>> CAMBIO DE PLANTEL</option> -->
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Periodo escolar de inscripción:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $usuario[0]["Ciclo"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Fecha de inscripción:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtFecIns" name="txtFecIns" type="text" value="<?php echo $info[0]["FecIns"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Medio que se enteró:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" name="txt_medx" id="txt_medx" type="text" value="<?php echo $info[0]["Medio"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Asesor:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" disabled type="text" value="<?php echo $info[0]["Asesor"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Fecha de inicio carrera:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input class="form-control" id="txt_fecini_carr" name="txt_fecini_carr" type="text" value="<?php echo $info[0]["Fec_ini_carr"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Fecha de término carerra:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input class="form-control" id="txt_fecfin_carr" name="txt_fecfin_carr" type="text" value="<?php echo $info[0]["Fec_fin_carr"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Forma en la que se va a titular el alumno:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-flag-checkered"></i></div>
                                <select class="form-control" name="txt_titulacion" id="txt_titulacion">
                                  <option value=""> - Seleccione - </option>
                                  <?php for ($i = 0; $i < sizeof($titulacion); $i++) { ?>
                                    <option value="<?php echo $titulacion[$i]["IdTitulacion"]; ?>" <?php if ($info[0]["IdTitulacion"] == $titulacion[$i]["IdTitulacion"]) { ?>selected="selected" <?php } ?>><?php echo $titulacion[$i]["Nombre_titulacion"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-ambulance"></i> En caso de emergencia / Tutor</span></div>
                            <br>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Nombre:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtNombrePa" name="txtNombrePa" type="text" value="<?php echo $info[0]["ENombre"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Celular:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtTel" name="txtTel" type="text" value="<?php echo $info[0]["ECelular"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Parentesto:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtParenteso" name="txtParenteso" type="text" value="<?php echo $info[0]["EParentesco"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Correo:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txt_correoT" name="txt_correoT" type="text" value="<?php echo $info[0]["correo_tutor"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Teléfono:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtTelx" name="txtTelx" type="text" value="<?php echo $info[0]["ETelefono"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Tel. Trabajo:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtTelT" name="txtTelT" type="text" value="<?php echo $info[0]["ETelTrabajo"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Dirección:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtDirex" name="txtDirex" type="text" value="<?php echo $info[0]["EDireccion"]; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="timeline">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-flag-o"></i> Antecedentes académicos</span></div>
                            <br>
                          </div>

                          <div class="col-md-8">
                            <div class="form-group">
                              <label>Carrera que estudio:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txt_carr" name="txt_carr" type="text" value="<?php echo $info[0]["E_estudio"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Promedio:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txt_prom" name="txt_prom" type="text" value="<?php echo $info[0]["E_promedio"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-9">
                            <div class="form-group">
                              <label>Escuela de procedencia:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txt_esc" name="txt_esc" type="text" value="<?php echo $info[0]["E_escuela_procedencia"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Estado de procedencia:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" name="txt_est" id="txt_est">
                                  <option value=""> - Seleccione - </option>
                                  <?php for ($i = 0; $i < sizeof($est); $i++) { ?>
                                    <option value="<?php echo $est[$i]["IdEstado"]; ?>" <?php if ($info[0]["E_estado_procedencia"] == $est[$i]["IdEstado"]) { ?>selected="selected" <?php } ?>><?php echo $est[$i]["Estado"]; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="col-md-6">
                    <div class="form-group">
                      <label>Tipo de estudio del antecedente academico:</label>
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-check"></i></div>
                        <input class="form-control" id="txt_tipo_es_ant" name="txt_tipo_es_ant" type="text" value="<?php echo $info[0]["Tipo_estudio_ante"]; ?>">
                      </div>
                  </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label>Fecha de inicio:</label>
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input class="form-control" id="txt_fecini" name="txt_fecini" type="text" value="<?php echo $info[0]["Fec_ini"]; ?>">
                      </div>
                  </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label>Fecha de término:</label>
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input class="form-control" id="txt_fecfin" name="txt_fecfin" type="text" value="<?php echo $info[0]["Fec_fin"]; ?>">
                      </div>
                  </div>
                </div> -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>Tipo institución:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" name="txt_tip" id="txt_tip">
                                  <option value="">- Seleccione -</option>
                                  <option value="PRIVADA" <?php if ($info[0]["E_tipo"] == "PRIVADA") { ?>selected="selected" <?php } ?>> PRIVADA </option>
                                  <option value="PUBLICA" <?php if ($info[0]["E_tipo"] == "PUBLICA") { ?>selected="selected" <?php } ?>> PÚBLICA </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>¿Cuenta con título profesional?:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" name="txt_tit" id="txt_tit">
                                  <option value="">- Seleccione -</option>
                                  <option value="SI" <?php if ($info[0]["E_titulo"] == "SI") { ?>selected="selected" <?php } ?>> SI </option>
                                  <option value="NO" <?php if ($info[0]["E_titulo"] == "NO") { ?>selected="selected" <?php } ?>> NO </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>¿Cuenta con cédula profesional?:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" name="txt_ced" id="txt_ced">
                                  <option value="">- Seleccione -</option>
                                  <option value="SI" <?php if ($info[0]["E_cedula"] == "SI") { ?>selected="selected" <?php } ?>> SI </option>
                                  <option value="NO" <?php if ($info[0]["E_cedula"] == "NO") { ?>selected="selected" <?php } ?>> NO </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>¿Cuenta con posgrado?:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" name="txt_pos" id="txt_pos" onchange="sel_posgrado()">
                                  <option value="">- Seleccione -</option>
                                  <option value="SI" <?php if ($info[0]["E_posgrado"] == "SI") { ?>selected="selected" <?php } ?>> SI </option>
                                  <option value="NO" <?php if ($info[0]["E_posgrado"] == "NO") { ?>selected="selected" <?php } ?>> NO </option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div id="div_posgrado" style="display: none;">
                            <div class="col-md-12">
                              <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-graduation-cap"></i> Datos del posgrado estudiado</span></div>
                              <br>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Posgrado que estudio:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtPnombre" name="txtPnombre" type="text" value="<?php echo $info[0]["PNombre"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Institución donde estudió:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <input class="form-control" id="txtPUni" name="txtPUni" type="text" value="<?php echo $info[0]["PUniversidad"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Estado de procedencia:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                  <select class="form-control" name="txt_pos_est" id="txt_pos_est">
                                    <option value=""> - Seleccione - </option>
                                    <?php for ($i = 0; $i < sizeof($est); $i++) { ?>
                                      <option value="<?php echo $est[$i]["IdEstado"]; ?>" <?php if ($info[0]["Pos_estado"] == $est[$i]["IdEstado"]) { ?>selected="selected" <?php } ?>><?php echo $est[$i]["Estado"]; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Fecha de inicio:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                  <input class="form-control" id="txt_pos_ini" name="txt_pos_ini" type="text" value="<?php echo $info[0]["Pos_ini"]; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Fecha de término:</label>
                                <div class="input-group">
                                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                  <input class="form-control" id="txt_pos_fin" name="txt_pos_fin" type="text" value="<?php echo $info[0]["Pos_fin"]; ?>">
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="tab-pane" id="settings">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-map-marker"></i> Domicilio actual</span></div>
                            <br>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Estado:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" style="width:100%;" name="txtEstadoD" id="txtEstadoD" onchange="cargar_mun_dom()">
                                  <option value=""> - Seleccione - </option>
                                  <?php for ($i = 0; $i < sizeof($est); $i++) { ?>
                                    <option value="<?php echo $est[$i]["IdEstado"]; ?>" <?php if (isset($info[0]["D_estado"])) {
                                                                                          if ($info[0]["D_estado"] == $est[0]["D_estado"]) { ?>selected="selected" <?php }
                                                                                                                                                                                                } ?>> <?php echo $est[0]["Estado"]; ?> </option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Municipio:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" style="width:100%;" name="txtMunicipio" id="txtMunicipio" onclick="cargar_loc_dom()">
                                  <option value="">- Seleccione -</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Localidad:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" style="width:100%;" name="txtCiudad" id="txtCiudad">
                                  <option value="">- Seleccione -</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label>CP:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txt_cp" name="txt_cp" type="text" value="<?php echo $info[0]["D_cp"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-9">
                            <div class="form-group">
                              <label>Dirección:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txt_dir" name="txt_dir" type="text" value="<?php echo $info[0]["D_direccion"]; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="bg-navy-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-map-o"></i> Lugar de nacimiento</span></div>
                            <br>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Estado:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" style="width:100%;" name="txtEstadoN" id="txtEstadoN" onchange="cargar_mun_nac()">
                                  <option value=""> - Seleccione - </option>
                                  <?php for ($i = 0; $i < sizeof($est); $i++) { ?>
                                    <option value="<?php echo $est[$i]["IdEstado"]; ?>" <?php if (isset($info[0]["Estado"])) {
                                                                                          if ($info[0]["Estado"] == $est[$i]["IdEstado"]) { ?>selected="selected" <?php }
                                                                                                                                                                                            } ?>> <?php echo $est[$i]["Estado"] ?> </option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Municipio:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" style="width:100%;" name="txtMunicipioN" id="txtMunicipioN" onclick="cargar_loc_nac()">
                                  <option value="">- Seleccione -</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Localidad:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <select class="form-control" style="width:100%;" name="txtLocalidadN" id="txtLocalidadN">
                                  <option value="">- Seleccione -</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Dirección:</label>
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-compass"></i></div>
                                <input class="form-control" id="txtDireN" name="txtDireN" type="text" value="<?php echo $info[0]["Domicilio"]; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box-footer">
                    <button onclick="saveCedula()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-save"></i> Guardar cédula</button>
                    <!-- <button style="margin-right: 10px;" onclick="configurarDocs(<?php echo substr($_GET["idToks"], 10, 10); ?>)" type="button" class="btn btn-primary pull-right"><i class="fa fa-fw fa-cog"></i> Configurar documentación</button> -->
                    <?php if (isset($_mod55[0])) { ?>
                      <!-- <button onclick="configurar_imprx(<?php echo substr($_GET["idToks"], 10, 10); ?>)" type="button" class="btn btn-warning btn-flat"><i class="fa fa-cog"></i> Configurar obtención de grado</button> -->
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </form>
      </section>
      <div id="dataModalModFue" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar documentos</h4>
            </div>
            <div class="modal-body" id="employee_detailModFue">
            </div>
          </div>
        </div>
      </div>
      <div id="dataModalPerfil" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Foto de perfil del alumno</h4>
            </div>
            <div class="modal-body" id="employee_detailPerfil">
            </div>
          </div>
        </div>
      </div>
      <div id="dataModalI" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar proceso</h4>
            </div>
            <div class="modal-body" id="employee_detailI">
            </div>
          </div>
        </div>
      </div>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page script -->
  <script>
    function configurar_imprx(IdUsua) {
      var IdCiclo = 0;
      $.ajax({
        url: "formConsulta/configurar_proceso_titulacion.php",
        method: "POST",
        data: {
          IdUsua: IdUsua,
          IdCiclo: IdCiclo
        },
        success: function(data) {
          $('#employee_detailI').html(data);
          $('#dataModalI').modal('show');
        }
      });
    }

    function configurarDocs(IdUsua) {
      $.ajax({
        url: "formConsulta/configurarDocs.php",
        method: "POST",
        data: {
          IdUsua: IdUsua
        },
        success: function(data) {
          $('#employee_detailModFue').html(data);
          $('#dataModalModFue').modal('show');
        }
      });
    }



    $(function() {
      //Date picker
      $('#txtNac').datepicker({
        autoclose: true
      })
      $('#txtFecIns').datepicker({
        autoclose: true
      })
      $('#txt_fecini').datepicker({
        autoclose: true
      })
      $('#txt_fecfin').datepicker({
        autoclose: true
      })
      $('#txt_fecini_carr').datepicker({
        autoclose: true
      })
      $('#txt_fecfin_carr').datepicker({
        autoclose: true
      })
      $('#txt_pos_ini').datepicker({
        autoclose: true
      })
      $('#txt_pos_fin').datepicker({
        autoclose: true
      })

    })

    $(function() {
      var Trabaja = document.getElementById("txtTrabaja").value;
      if (Trabaja == 'SI') {
        document.getElementById("div_labora").style.display = "block";
      } else {
        document.getElementById("div_labora").style.display = "none";
      }

      var Posgrado = document.getElementById("txt_pos").value;
      if (Posgrado == 'SI') {
        document.getElementById("div_posgrado").style.display = "block";
      } else {
        document.getElementById("div_posgrado").style.display = "none";
      }

      $('.select2').select2()

    })

    $(document).ready(function() {
      var IdEstado = document.getElementById("IdEsta_D").value;
      var Tipo = "get_estado_sel";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado
      }, function(data) {
        $("#txtEstadoD").html(data);
      });
    });

    $(document).ready(function() {
      var IdEstado = document.getElementById("IdEsta_D").value;
      var IdMunicipio = document.getElementById("IdMuni_D").value;
      var Tipo = "get_ciudad_sel";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado,
        IdMunicipio: IdMunicipio
      }, function(data) {
        $("#txtMunicipio").html(data);
      });
    });

    $(document).ready(function() {
      var IdEstado = document.getElementById("IdEsta_D").value;
      var IdMunicipio = document.getElementById("IdMuni_D").value;
      var IdLocalidad = document.getElementById("IdCiud_D").value;

      var Tipo = "get_localidad_sel";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado,
        IdMunicipio: IdMunicipio,
        IdLocalidad: IdLocalidad
      }, function(data) {
        $("#txtCiudad").html(data);
      });
    });

    $(document).ready(function() {
      var IdEstado = document.getElementById("IdEsta_N").value;
      var Tipo = "get_estado_sel";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado
      }, function(data) {
        $("#txtEstadoN").html(data);
      });
    });

    $(document).ready(function() {
      var IdEstado = document.getElementById("IdEsta_N").value;
      var IdMunicipio = document.getElementById("IdCiud_N").value;
      var Tipo = "get_ciudad_sel";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado,
        IdMunicipio: IdMunicipio
      }, function(data) {
        $("#txtMunicipioN").html(data);
      });
    });

    $(document).ready(function() {
      var IdEstado = document.getElementById("IdEsta_N").value;
      var IdMunicipio = document.getElementById("IdCiud_N").value;
      var IdLocalidad = document.getElementById("IdLoca_N").value;

      var Tipo = "get_localidad_sel";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado,
        IdMunicipio: IdMunicipio,
        IdLocalidad: IdLocalidad
      }, function(data) {
        $("#txtLocalidadN").html(data);
      });
    });

    function cargar_mun_dom() {
      var IdEstado = document.getElementById("txtEstadoD").value;
      var Tipo = "get_estados";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado
      }, function(data) {
        $("#txtMunicipio").html(data);
      });
    }

    function cargar_mun_nac() {
      var IdEstado = document.getElementById("txtEstadoN").value;
      var Tipo = "get_estados";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado
      }, function(data) {
        $("#txtMunicipioN").html(data);
      });
    }


    function cargar_loc_dom() {
      var IdEstado = document.getElementById("txtEstadoD").value;
      var IdMunicipio = document.getElementById("txtMunicipio").value;

      var Tipo = "get_municipios";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado,
        IdMunicipio: IdMunicipio
      }, function(data) {

        $("#txtCiudad").html(data);
      });
    }

    function cargar_loc_nac() {
      var IdEstado = document.getElementById("txtEstadoN").value;
      var IdMunicipio = document.getElementById("txtMunicipioN").value;

      var Tipo = "get_municipios";
      $.post("php/clases/getConsulta.php", {
        Tipo: Tipo,
        IdEstado: IdEstado,
        IdMunicipio: IdMunicipio
      }, function(data) {

        $("#txtLocalidadN").html(data);
      });
    }

    function sel_trabajo() {
      var Trabaja = document.getElementById("txtTrabaja").value;
      if (Trabaja == 'SI') {
        document.getElementById("div_labora").style.display = "block";
      } else {
        document.getElementById("div_labora").style.display = "none";
      }

    }

    function sel_posgrado() {
      var Posgrado = document.getElementById("txt_pos").value;
      if (Posgrado == 'SI') {
        document.getElementById("div_posgrado").style.display = "block";
      } else {
        document.getElementById("div_posgrado").style.display = "none";
      }

    }

    function subir_foto_perfil(IdUsua) {
      $.ajax({
        url: "formConsulta/foto_perfil.php",
        method: "POST",
        data: {
          IdUsua: IdUsua
        },
        success: function(data) {
          $('#employee_detailPerfil').html(data);
          $('#dataModalPerfil').modal('show');
        }
      });
    }
  </script>
</body>

</html>