<?php $section = "Acta de calificación"; $_v = 93; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado el acta de calificaciones'); }
if($_SESSION['Permisos']) {
	$px = 0;
	$cpx = 0;
	$t->get_validar_mat_doc($_GET["idToks"],$_SESSION['IdUsua']);

	$emision=$t->get_fec_emi($_GET["idToks"]);
$actaCalificacion=$t->get_actaCalificacion($_GET["idToks"]);
$datP=$t->get_ofertaId($actaCalificacion[0]["IdEducativa"]);
$parcial=$t->get_parcialActivo($_GET["idToks"]);
if(isset($parcial[0])){

	$grP=$t->get_grupoId($parcial[0]["IdGrupo"]);
	$mod = substr($grP[0]["CveGrupo"],5,1);
	$idP = $parcial[0]["IdParcialDocente"];
}

$prom = 6;
echo $grad = $datP[0]["IdGrado"];
if($grad == 1){
	$prom = 8;
} elseif($grad == 2){
	$prom = 7;
} elseif($grad == 3){
	$prom = 6;
}

if($emision[0]['Fecha_impresion']){
	$cpx = 1;
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>Calificaciones finales de la asignatura</h1>
		  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i>Avance de calificaciones</a></li>
				<li class="active"><a href="#">Calificaciones</a></li>
		  </ol>

		</section>
		<section class="content">
			<form name="frm" id="frm" action="doSelActa.php" method="POST" enctype="multipart/form-data">
				<input id="Id" name="Id" value="<?php echo $_GET["idToks"]; ?>" type="hidden"/>
				<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
				<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_GET["idToks"]; ?>" type="hidden"/>
				<input id="Grado" name="Grado" value="<?php if(isset($datP[0]["IdGrado"])){ echo $datP[0]["IdGrado"]; } ?>" type="hidden"/>

      <!-- Info boxes -->
      <div class="row">
				<?php
				$Hoy=date("Y-m-d"); $f_ind = 0;
				$dd = 0;
				$pp1 = 0; $pp2 = 0; $pp3 = 0; $pp4 = 0; $par = 0; $fechaX= '';
				$x1 = 0; $x2 = 0; $x3 = 0; $x4 = 0;
				for ($i=0;$i< sizeof($parcial);$i++) { $par = $par + 1;
					$apT=$t->get_aperturaId($parcial[$i]["NoParcial"],$parcial[0]["IdCiclo"],$mod);
					$feIndiv=$t->get_parIndiv($parcial[$i]["IdParcialDocente"]);

					if((isset($feIndiv[0]['Fecha'])) && ($hoy <= $feIndiv[0]['Fecha'])){
						$f_ind = 1;
					}

					$valor = 0;
                    if(isset($parcial[$i]['Fecha'])){
                        $fecP = $parcial[$i]['Fecha'];
                        if(isset($apT[0]["Fecha"])){

                            $FecPar = $apT[0]["Fecha"];

                            if($fecP > $FecPar){
                                $valor = 1;
                            }
                        }

                    }


					if((isset($apT[0]["Fecha"])) || ($f_ind == 1)){


						$fechaX = $apT[0]["Fecha"];


						if($valor == 1){ $fechaX = $parcial[$i]['Fecha']; }
						if($f_ind == 1){ $fechaX = $feIndiv[0]['Fecha']; }

						if($i == 0){ if($fechaX >= $Hoy){ $f_1 = $fechaX; $x1 = 1; $pp1 = 1; $dd = 1; } else { $x1 = 0; $pp1 = 0; $dd = 0; } }
						if($i == 1){ if($fechaX >= $Hoy){ $f_2 = $fechaX; $x2 = 1; $pp2 = 1; } else { $x2 = 0; $pp2 = 0; } }
						if($i == 2){ if($fechaX >= $Hoy){ $f_3 = $fechaX; $x3 = 1; $pp3 = 1; } else { $x3 = 0; $pp3 = 0; } }
						if($i == 3){ if($fechaX >= $Hoy){ $f_4 = $fechaX; $x4 = 1; $pp4 = 1; $dd = 1; } else { $x4 = 0; $pp4 = 0; $dd = 0; } }
					}

					$est = $parcial[$i]["IdEstatus"];
					$sum = ($x1 + $x2 + $x3 + $x4);
					if($sum){ $dd = 1; }
					if($est == 26){
						$txtE = "Finalizado";
						$txtC = "red";
						$txtI = "fa fa-calendar-times-o";
					} else {
						$txtE = "Activo";
						$txtC = "green";
						$txtI = "fa fa-calendar-check-o";
					}
				  $fechaX;
					 ?>

					 <div class="col-md-3">
          <!-- Info Boxes Style 2 -->
          <div style="cursor: pointer" title="Cargar calificaciones de este parcial" class="info-box bg-<?php echo $txtC; ?>" onclick="cargarCal(<?php echo $parcial[$i]["IdParcialDocente"]; ?>,<?php echo $parcial[$i]["NoParcial"]; ?>)">
            <span class="info-box-icon"><i class="<?php echo $txtI; ?>"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?php echo $parcial[$i]["Titulo"]; ?></span>
              <span class="info-box-number"><?php echo $txtE; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    Cargar calificaciones
                  </span>
            </div>
          </div>
        </div>
			<?php } ?>
      </div>

      <div class="row">
        <div class="col-md-12">
					<div class="form-group" name="imgLoad" id="imgLoad" style="display: none;">
						<div class="col-sm-12" style="text-align: center;">
								<img src="assets/images/cargando.gif" style="margin-left: -162px; position: absolute; z-index:99999;">
						</div>
					</div>

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-tags"></i> Calificaciones finales de la asignatura</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-striped" style="font-size: 12px;">
                  <thead>
                  <tr>
                    <th style="width: 50px;">#</th>
										<th style="width: 50px;">NO.CONTROL</th>
                    <th>NOMBRE DEL ALUMNO</th>
										<?php if(1 <= $par){ ?> <th style="text-align: center;"><?php echo $parcial[0]["Titulo"]; ?> <br><?php if(isset($f_1)){ echo fechaMes($f_1); } ?></th> <?php } ?>
										<?php if(2 <= $par){ ?> <th style="text-align: center;"><?php echo $parcial[1]["Titulo"]; ?> </th> <?php } ?>
										<?php if(3 <= $par){ ?> <th style="text-align: center;"><?php echo $parcial[2]["Titulo"]; ?> </th> <?php } ?>
										<?php if(4 <= $par){ ?> <th style="text-align: center;"><?php echo $parcial[3]["Titulo"]; ?> </th> <?php } ?>
										<th style="text-align: center; width: 200px;">PROMEDIO FINAL</th>
										<?php if($grad == 3){ ?>
										<th style="text-align: center; width: 40px;"></th><?php } ?>
                  </tr>
                  </thead>
                  <tbody>
										<?php $resS = 0; $xtra1 = 0; for ($i=0;$i< sizeof($actaCalificacion);$i++) {
											$Id_Es = $actaCalificacion[$i]["IdEstatus"];
											$_tx = '';
											if($Id_Es == 20){ $_tx = 'text-decoration-line: line-through; color: red;'; } elseif($Id_Es == 50){ $_tx = 'text-decoration-line: underline line-through; color: blue;'; }
											if(isset($idP)){
											$sum = ($actaCalificacion[$i]["ParcialF1"] + $actaCalificacion[$i]["ParcialF2"] + $actaCalificacion[$i]["ParcialF3"] + $actaCalificacion[$i]["ParcialF4"]);
											$resS = ($sum / $par);
											$calPla=$t->get_calPlata($actaCalificacion[$i]["IdModuloAlumno"],$resS);

											if($actaCalificacion[$i]["Extra1"] == 1){
												$xtra1 = 1;
											} }
											 ?>
                  <tr style="<?php echo $_tx; ?>">
										<td><b><?php echo $i + 1;  $pp1 = 1; $pp2 = 1; $pp3 = $pp4; ?>.- </b></td>
										<td><?php echo $actaCalificacion[$i]["Usuario"]; ?></td>
										<td><?php echo $actaCalificacion[$i]["APaterno"].' '.$actaCalificacion[$i]["AMaterno"].' '.$actaCalificacion[$i]["Nombre"]; ?></td>
										<?php if(1 <= $par){ ?>
											<td style="text-align: center;">
												<input id="IdModAF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
												<div class="input-group input-group-sm">
													<span class="input-group-addon"><b><?php echo $actaCalificacion[$i]["Parcial1"]; ?></b></span>
			                		<input style="text-align: center;" value="<?php echo $actaCalificacion[$i]["ParcialF1"]; ?>" type="text" name="txtCalF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
													<?php if(($_SESSION['Permisos'] == 2) ){ ?>
			                    <span class="input-group-btn">
			                      <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,1)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
			                    </span><?php } ?>
			              		</div>
											</td>
										<?php } ?>
										<?php if(2 <= $par){ ?>
											<td style="text-align: center;">
												<input id="IdModAF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
												<div class="input-group input-group-sm">
													<span class="input-group-addon"><b><?php echo $actaCalificacion[$i]["Parcial2"]; ?></b></span>
			                		<input style="text-align: center;" value="<?php echo $actaCalificacion[$i]["ParcialF2"]; ?>" type="text" name="txtCalF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
													<?php if(($_SESSION['Permisos'] == 2) ){ ?>
			                    <span class="input-group-btn">
			                      <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,2)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
			                    </span><?php } ?>
			              		</div>
											</td>
										<?php } ?>
										<?php if(3 <= $par){ ?>
											<td style="text-align: center;">
												<input id="IdModAF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
												<div class="input-group input-group-sm">
													<span class="input-group-addon"><b><?php echo $actaCalificacion[$i]["Parcial3"]; ?></b></span>
			                		<input style="text-align: center;" value="<?php echo $actaCalificacion[$i]["ParcialF3"]; ?>" type="text" name="txtCalF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
													<?php if(($_SESSION['Permisos'] == 2)){ ?>
			                    <span class="input-group-btn">
			                      <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,3)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
			                    </span><?php } ?>
			              		</div>
											</td>
										<?php } ?>
										<?php if(4 <= $par){ ?>
											<td style="text-align: center;">
												<input id="IdModAF4-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF4-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
												<div class="input-group input-group-sm">
													<span class="input-group-addon"><b><?php echo $actaCalificacion[$i]["Parcial4"]; ?></b></span>
			                		<input style="text-align: center;" value="<?php echo $actaCalificacion[$i]["ParcialF4"]; ?>" type="text" name="txtCalF4-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF4-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
													<?php if(($_SESSION['Permisos'] == 2)){ ?>
			                    <span class="input-group-btn">
			                      <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,4)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
			                    </span><?php } ?>
			              		</div>
											</td>
										<?php } ?>
										<td style="text-align: center;">
											<input id="IdModPro-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModPro-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
											<div class="input-group input-group-sm">
												<span class="input-group-addon"><b><?php echo round($resS,2); ?></b></span>
												<input style="text-align: center;" value="<?php echo $actaCalificacion[$i]["Promedio"]; ?>" type="text" name="txtProm-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtProm-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
												<?php if($_SESSION['Permisos'] == 2){ ?>
												<span class="input-group-btn">
													<?php if($cpx == 0){ ?><button id="btnP-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" type="button" onclick="savPromedio(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>)" class="btn btn-success btn-flat"><i class="fa fa-fw fa-save"></i></button><?php } ?>
												</span><?php } ?>
											</div>
										</td>
										<?php if($grad == 3){ ?>
										<td style="text-align: center;">
											<div class="input-group input-group-sm">
												<?php if($_SESSION['Permisos'] == 2){ ?>
												<span class="input-group-btn">
													<?php if($actaCalificacion[$i]["Promedio"]) {
														if($actaCalificacion[$i]["Promedio"] < $prom){
														if($actaCalificacion[$i]["Extra1"] == 1){ ?>
															<button href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center" title="Extraordinario activado"> <i class="fa fa-fw fa-check-circle"></i> Activado</button>
														<?php } else { ?><br>
															<button id="btnActivado-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" style="display: none;" href="javascript:void(0);" title="Extraordinario activado" type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check-circle"></i> Activado</button>
															<button id="btnActivar-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" onclick="actExtraAlumno(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>)" href="javascript:void(0);"  type="button" class="btn btn-danger btn-xs pull-center"> <i class="fa fa-fw fa-database"></i> Extra</button>
													<?php } } } ?>
												</span><?php } ?>
											</div>
										</td><?php } ?>
										<!-- <td>
											<input id="IdModA-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModA-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
												<div class="input-group input-group-sm">
			                		<input value="<?php echo $actaCalificacion[$i]["CalIGSI"]; ?>" type="text" name="txtCal-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCal-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
			                    <span class="input-group-btn">
			                      <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
			                    </span>
			              		</div>
										</td> -->
                    <!-- <td>

												<?php if($actaCalificacion[$i]["Promedio"]) {
													if($actaCalificacion[$i]["Promedio"] < $prom){
													if($actaCalificacion[$i]["Extra1"] == 1){ ?>
														<button href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check"></i> Activado</button>
													<?php } else { ?><br>
														<button id="btnActivado-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" style="display: none;" href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check"></i> Activado</button>
														<button id="btnActivar-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" onclick="actExtraAlumno(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>)" href="javascript:void(0);"  type="button" class="btn btn-danger btn-xs pull-center"> <i class="fa fa-fw fa-database"></i> Activar Extra</button>
												<?php } } }  ?>

										</td> -->
                  </tr>
									<?php } ?>

                  </tbody>
                </table>
								<!-- <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Significado de los colores</th>
                  <th>Estatus</th>
                </tr>
                <tr>
                  <td>1.</td>
									<td>NOMBRE DEL USUARIO</td>
                  <td>ACTIVO</td>
                </tr>
								<tr>
                  <td>2.</td>
									<td style="text-decoration-line: line-through; color: red;">NOMBRE DEL USUARIO</td>
	                  <td>BAJA POR DESERCIÓN</td>
                </tr>
								<tr>
                  <td>3.</td>
									<td style="text-decoration-line: underline line-through; color: blue;">NOMBRE DEL USUARIO</td>
                  <td>BLOQUEADO TEMPORALMENTE</td>
                </tr>

              </tbody></table> -->

								<!-- if($Id_Es == 20){ $_tx = 'text-decoration-line: line-through; color: blue;'; } elseif($Id_Es == 50){ $_tx = 'text-decoration-line: underline line-through; color: red;'; } -->
              </div>

            </div>

          </div>




        </div>

      </div>

			<!-- ====INICIO DEL EXTRAORDINARIO 1 ==== -->

			<?php $xtra2 = 0; $xtra3 = 0;
				if($xtra1 == 1){
				$actaExtra1=$t->get_acta_datExtra($_GET["idToks"],1);
				$extraNo1=$t->get_activo_extra($_GET["idToks"],1); ?>
				<div class="row">
					<?php $par = 0; for ($i=0;$i< sizeof($extraNo1);$i++) {
						$est = $extraNo1[$i]["IdEstatus"];
						if($est == 26){
							$txtE = "Finalizado";
							$txtC = "red";
							$txtI = "fa fa-calendar-times-o";
						} else {
							$txtE = "Activo";
							$txtC = "green";
							$txtI = "fa fa-calendar-check-o";
						}
						 ?>
						 <div class="col-md-6">
	          <div style="cursor: pointer" title="Cargar calificaciones" class="info-box bg-<?php echo $txtC; ?>" onclick="cargarCalE(<?php echo $extraNo1[$i]["IdParcialDocente"]; ?>,<?php echo $extraNo1[$i]["NoParcial"]; ?>)">
	            <span class="info-box-icon"><i class="<?php echo $txtI; ?>"></i></span>
	            <div class="info-box-content">
	              <span class="info-box-text">Extraordinario</span>
	              <span class="info-box-number"><?php echo $txtE; ?></span>
	              <div class="progress">
	                <div class="progress-bar" style="width: 50%"></div>
	              </div>
	              <span class="progress-description">
	                    Cargar calificaciones
	                  </span>
	            </div>
	          </div>
	        </div>
				<?php } ?>
	      </div>
	      <div class="row">
	        <div class="col-md-12">
						<div class="form-group" name="imgLoad" id="imgLoad" style="display: none;">
							<div class="col-sm-12" style="text-align: center;">
									<img src="assets/images/cargando.gif" style="margin-left: -162px; position: absolute; z-index:99999;">
							</div>
						</div>
	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Calificaciones de la asignatura con extraordinario 1</h3>
	            </div>
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>#</th>
	                    <th>Nombre del alumno</th>
											<th>Extraordinario</th>
											<th>Cal. Plataforma</th>
											<th>Promedio Extra 1</th>
	                  </tr>
	                  </thead>
	                  <tbody>
											<?php  $xtra2 = 0; for ($i=0;$i< sizeof($actaExtra1);$i++) {
												if($actaExtra1[$i]["Extra2"] == 1){ $xtra2 = 1; } ?>
	                  <tr>
											<td><?php echo $i + 1; ?></td>
											<td><?php echo $actaExtra1[$i]["APaterno"].' '.$actaExtra1[$i]["AMaterno"].' '.$actaExtra1[$i]["Nombre"]; ?></td>
											<td style="text-align: center;"><?php echo $actaExtra1[$i]["CalExtra1"]; ?></td>
											<td style="text-align: center;"><?php echo $actaExtra1[$i]["CalExtra1"]; ?></td>
											<td>
												<input id="id_valExt<?php echo '1-'.$actaExtra1[$i]["IdUsua"]; ?>" name="id_valExt<?php echo '1-'.$actaExtra1[$i]["IdUsua"]; ?>" value="<?php echo $actaExtra1[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
													<div class="input-group input-group-sm">
				                		<input value="<?php echo $actaExtra1[$i]["E1"]; ?>" type="text" name="promExtr<?php echo '1-'.$actaExtra1[$i]["IdUsua"]; ?>" id="promExtr<?php echo '1-'.$actaExtra1[$i]["IdUsua"]; ?>" class="form-control">
														<?php if($_SESSION['Permisos'] == 2){ ?>
				                    <span class="input-group-btn">
				                      <button type="button" onclick="savExtra(<?php echo $actaExtra1[$i]["IdUsua"]; ?>,1)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
				                    </span><?php } ?>
				              		</div>
											</td>
	                    <td>
											<?php if($actaExtra1[$i]["E1"]) {
												if($actaExtra1[$i]["E1"] < 6){
												if($actaExtra1[$i]["Extra2"] == 1){ ?>
													<button href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check"></i> Activado</button>
												<?php } else { ?>
													<button id="btnActivado-<?php echo $actaExtra1[$i]["IdUsua"]; ?>" style="display: none;" href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check"></i> Activado</button>
													<button id="btnActivar-<?php echo $actaExtra1[$i]["IdUsua"]; ?>" onclick="actExtraAlumno2(<?php echo $actaExtra1[$i]["IdUsua"]; ?>)" href="javascript:void(0);"  type="button" class="btn btn-danger btn-xs pull-center"> <i class="fa fa-fw fa-database"></i> Activar </button>
											<?php } } }  ?>
											</td>
	                  </tr>
										<?php } ?>
	                  </tbody>
	                </table>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
			<?php } ?>


			<!-- ====INICIO DEL EXTRAORDINARIO 2 ==== -->

			<?php
				if($xtra2 == 1){
				$actaExtra2=$t->get_acta_datExtra($_GET["idToks"],2);
				$extraNo2=$t->get_activo_extra($_GET["idToks"],2); ?>
				<div class="row">
					<?php $par = 0; for ($i=0;$i< sizeof($extraNo2);$i++) {
						$est = $extraNo2[$i]["IdEstatus"];
						if($est == 26){
							$txtE = "Finalizado";
							$txtC = "red";
							$txtI = "fa fa-calendar-times-o";
						} else {
							$txtE = "Activo";
							$txtC = "green";
							$txtI = "fa fa-calendar-check-o";
						}
						 ?>
						 <div class="col-md-6">
	          <div style="cursor: pointer" title="Cargar calificaciones" class="info-box bg-<?php echo $txtC; ?>" onclick="cargarCalE(<?php echo $extraNo2[$i]["IdParcialDocente"]; ?>,<?php echo $extraNo2[$i]["NoParcial"]; ?>)">
	            <span class="info-box-icon"><i class="<?php echo $txtI; ?>"></i></span>
	            <div class="info-box-content">
	              <span class="info-box-text">Extraordinario</span>
	              <span class="info-box-number"><?php echo $txtE; ?></span>
	              <div class="progress">
	                <div class="progress-bar" style="width: 50%"></div>
	              </div>
	              <span class="progress-description">
	                    Cargar calificaciones
	                  </span>
	            </div>
	          </div>
	        </div>
				<?php } ?>
	      </div>
	      <div class="row">
	        <div class="col-md-12">
						<div class="form-group" name="imgLoad" id="imgLoad" style="display: none;">
							<div class="col-sm-12" style="text-align: center;">
									<img src="assets/images/cargando.gif" style="margin-left: -162px; position: absolute; z-index:99999;">
							</div>
						</div>
	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Calificaciones de la asignatura con extraordinario 2</h3>
	            </div>
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>#</th>
	                    <th>Nombre del alumno</th>
											<th>Extraordinario</th>
											<th>Cal. Plataforma</th>
											<th>Promedio Extra 2</th>
	                  </tr>
	                  </thead>
	                  <tbody>
											<?php $xtra2 = 0; for ($i=0;$i< sizeof($actaExtra2);$i++) {
												if($actaExtra2[$i]["Extra3"] == 1){ $xtra3 = 1; } ?>
	                  <tr>
											<td><?php echo $i + 1; ?></td>
											<td><?php echo $actaExtra2[$i]["APaterno"].' '.$actaExtra2[$i]["AMaterno"].' '.$actaExtra2[$i]["Nombre"]; ?></td>
											<td style="text-align: center;"><?php echo $actaExtra2[$i]["CalExtra1"]; ?></td>
											<td style="text-align: center;"><?php echo $actaExtra2[$i]["CalExtra1"]; ?></td>
											<td>
												<input id="id_valExt<?php echo '2-'.$actaExtra2[$i]["IdUsua"]; ?>" name="id_valExt<?php echo '2-'.$actaExtra2[$i]["IdUsua"]; ?>" value="<?php echo $actaExtra2[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
													<div class="input-group input-group-sm">
				                		<input value="<?php echo $actaExtra2[$i]["E2"]; ?>" type="text" name="promExtr<?php echo '2-'.$actaExtra2[$i]["IdUsua"]; ?>" id="promExtr<?php echo '2-'.$actaExtra2[$i]["IdUsua"]; ?>" class="form-control">
														<?php if($_SESSION['Permisos'] == 2){ ?>
				                    <span class="input-group-btn">
				                      <button type="button" onclick="savExtra(<?php echo $actaExtra2[$i]["IdUsua"]; ?>,2)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
				                    </span><?php } ?>
				              		</div>
											</td>
	                    <td>
											<?php if($actaExtra2[$i]["E2"]) {
												if($actaExtra2[$i]["E2"] < 6){
												if($actaExtra2[$i]["Extra3"] == 1){ ?>
													<button href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check"></i> Activado</button>
												<?php } else { ?>
													<button id="btnActivado-<?php echo $actaExtra2[$i]["IdUsua"]; ?>" style="display: none;" href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center"> <i class="fa fa-fw fa-check"></i> Activado</button>
													<button id="btnActivar-<?php echo $actaExtra2[$i]["IdUsua"]; ?>" onclick="actExtraAlumno3(<?php echo $actaExtra2[$i]["IdUsua"]; ?>)" href="javascript:void(0);"  type="button" class="btn btn-danger btn-xs pull-center"> <i class="fa fa-fw fa-database"></i> Activar </button>
											<?php } } }  ?>
											</td>
	                  </tr>
										<?php } ?>
	                  </tbody>
	                </table>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
			<?php } ?>

			<!-- ====INICIO DEL EXTRAORDINARIO 3 ==== -->

			<?php
				if($xtra3 == 1){
				$actaExtra3=$t->get_acta_datExtra($_GET["idToks"],3);
				$extraNo3=$t->get_activo_extra($_GET["idToks"],3); ?>
				<div class="row">
					<?php $par = 0; for ($i=0;$i< sizeof($extraNo3);$i++) {
						$est = $extraNo3[$i]["IdEstatus"];
						if($est == 26){
							$txtE = "Finalizado";
							$txtC = "red";
							$txtI = "fa fa-calendar-times-o";
						} else {
							$txtE = "Activo";
							$txtC = "green";
							$txtI = "fa fa-calendar-check-o";
						}
						 ?>
						 <div class="col-md-6">
	          <div style="cursor: pointer" title="Cargar calificaciones" class="info-box bg-<?php echo $txtC; ?>" onclick="cargarCalE(<?php echo $extraNo3[$i]["IdParcialDocente"]; ?>,<?php echo $extraNo3[$i]["NoParcial"]; ?>)">
	            <span class="info-box-icon"><i class="<?php echo $txtI; ?>"></i></span>
	            <div class="info-box-content">
	              <span class="info-box-text">Extraordinario</span>
	              <span class="info-box-number"><?php echo $txtE; ?></span>
	              <div class="progress">
	                <div class="progress-bar" style="width: 50%"></div>
	              </div>
	              <span class="progress-description">
	                    Cargar calificaciones
	                  </span>
	            </div>
	          </div>
	        </div>
				<?php } ?>
	      </div>
	      <div class="row">
	        <div class="col-md-12">
						<div class="form-group" name="imgLoad" id="imgLoad" style="display: none;">
							<div class="col-sm-12" style="text-align: center;">
									<img src="assets/images/cargando.gif" style="margin-left: -162px; position: absolute; z-index:99999;">
							</div>
						</div>
	          <div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Calificaciones de la asignatura con extraordinario 3</h3>
	            </div>
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>#</th>
	                    <th>Nombre del alumno</th>
											<th>Extraordinario</th>
											<th>Cal. Plataforma</th>
											<th>Promedio Extra 3</th>
	                  </tr>
	                  </thead>
	                  <tbody>
											<?php $xtra2 = 0; for ($i=0;$i< sizeof($actaExtra3);$i++) { ?>
	                  <tr>
											<td><?php echo $i + 1; ?></td>
											<td><?php echo $actaExtra3[$i]["APaterno"].' '.$actaExtra3[$i]["AMaterno"].' '.$actaExtra3[$i]["Nombre"]; ?></td>
											<td style="text-align: center;"><?php echo $actaExtra3[$i]["CalExtra3"]; ?></td>
											<td style="text-align: center;"><?php echo $actaExtra3[$i]["CalExtra3"]; ?></td>
											<td>
												<input id="id_valExt<?php echo '3-'.$actaExtra3[$i]["IdUsua"]; ?>" name="id_valExt<?php echo '3-'.$actaExtra3[$i]["IdUsua"]; ?>" value="<?php echo $actaExtra3[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
													<div class="input-group input-group-sm">
				                		<input value="<?php echo $actaExtra3[$i]["E3"]; ?>" type="text" name="promExtr<?php echo '3-'.$actaExtra3[$i]["IdUsua"]; ?>" id="promExtr<?php echo '3-'.$actaExtra3[$i]["IdUsua"]; ?>" class="form-control">
														<?php if($_SESSION['Permisos'] == 2){ ?>
				                    <span class="input-group-btn">
				                      <button type="button" onclick="savExtra(<?php echo $actaExtra3[$i]["IdUsua"]; ?>,3)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
				                    </span><?php } ?>
				              		</div>
											</td>
	                  </tr>
										<?php } ?>
	                  </tbody>
	                </table>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
			<?php } ?>
			<?php if($emision[0]['Fecha_impresion']){ ?>
				<div class="bg-purple-active color-palette" style="padding: 10px;">
					<span onclick="javascript:window.open('repositorio/portafolio/reporte_acta.php?tokenId=<?php echo $_GET["idToks"]; ?>');" href="javascript:void(0);" style="cursor: pointer;"><i class="fa fa-download"></i> Descargar acta de calificación</span>
					<span style="float: right;"><i class="fa fa-calendar"></i> Fecha de impresión del acta de calificación: <?php echo obtenerFechaCorta($emision[0]['Fecha_impresion']); ?> </span>

				</div>
			<?php } else { ?>
				<?php //if($i == $px){ ?>
				<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-gear"></i> Configurar fecha de emisión de acta de calificación</h3>
							</div>
							<form class="form-horizontal">
								<div class="box-body">
									<div class="form-group">
										<label class="col-sm-6 control-label" style="text-align: right; padding-top: 5px;">Fecha de emisión de acta:</label>
										<div class="col-sm-6">
											<input style="width: 80%;" type="text" class="form-control" id="txt_fecha" name="txt_fecha">
											<span class="input-group-btn" style="float: right; margin-right: 80px; margin-top: -34px;">
												<button onclick="sav_fecha_emi()" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Guardar</button>
											</span>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div><?php //} ?>
				<div class="bg-orange-active color-palette" style="padding: 10px;">
					<span onclick="javascript:window.open('repositorio/portafolio/reporte_acta.php?tokenId=<?php echo $_GET["idToks"]; ?>');" href="javascript:void(0);" style="color: black;"><i class="fa fa-times-circle"></i> Acta de calificación no disponible</span>
				</div>
			<?php } ?><br><br>
		</form>
    </section>


	  </div>
	  <?php include("footer.php"); ?>
	</div>
	<div id="dataModalModPar"  class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Calificaciones finales</h4>
								 </div>
								 <div class="modal-body" id="employee_detailModPar">
								 </div>
						</div>
			 </div>
	</div>
</body>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<script>
$(function () {
	$('#txt_fecha').datepicker({
		autoclose: true
	})
})

	function savCalificacion(IdUsua,Parcial){

		var ModAlum = "IdModAF"+Parcial+"-"+IdUsua;
		var CalAlum = "txtCalF"+Parcial+"-"+IdUsua;
		var IdModA = document.getElementById(ModAlum).value;
		var Calif = document.getElementById(CalAlum).value;
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var TipoGuardar = "savIGSI";

		if (Calif==''){
			swal("Error al guardar", "Debe escribir la calificaci\u00F3n final del parcial.", "error");
        document.getElementById(CalAlum).focus();
        return 0;
    }

		if ((Calif < 5) || (Calif > 10)){
				swal("Error al guardar", "Debe escribir el promedio del parcial. \n Ejemplo: 5, 6, 7, 8, 9, 10", "error");
				document.getElementById(CalAlum).focus();
	        document.getElementById(CalAlum).value = '';
	        return 0;
		}


		$.ajax({
					url:"formConsulta/setting.php",
					method:"POST",
					data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, Parcial:Parcial, IdUsua:IdUsua},
					success:function(data){
						if(data == 1){
							swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
							// parent.location.href='doSelActa.php';
						}
					}
		 })
	}

	function savPromedio(IdUsua){
		var Boton = "btnP-"+IdUsua;
		var ModAlum = "IdModPro-"+IdUsua;
		var CalAlum = "txtProm-"+IdUsua;

		var IdModA = document.getElementById(ModAlum).value;
		var Calif = document.getElementById(CalAlum).value;

		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var Grado = document.getElementById("Grado").value;

		var TipoGuardar = "savPromedio";
		if (Calif==''){
			swal("Error al guardar", "Debe escribir el promedio final de la materia.", "error");
        document.getElementById(CalAlum).focus();
        return 0;
    }

		if((Grado == 1) || (Grado == 2) || (Grado == 3)){
			if ((Calif == 5) || (Calif == 6) || (Calif == 7) || (Calif == 8) || (Calif == 9) || (Calif == 10) || (Calif == 'NP')){
			} else {
				swal("Error al guardar", "Debe escribir el promedio final de la materia. \n Ejemplo: 5, 6, 7, 8, 9, 10, NP", "error");
	        document.getElementById(CalAlum).focus();
	        return 0;
	    }
		}

		document.getElementById(Boton).style.display = 'none';

		$.ajax({
					url:"formConsulta/setting.php",
					method:"POST",
					data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, IdUsua:IdUsua},
					success:function(data){
					    //alert(data);
						if(data == 1){
							swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
							document.getElementById(Boton).style.display = 'block';
							// parent.location.href='doSelActa.php';
						}
					}
		 })
	}

	function savExtra(IdUsua,Extra){
		var IdModAlum = "id_valExt"+Extra+'-'+IdUsua;
		var PromExtr1 = "promExtr"+Extra+'-'+IdUsua;

		var IdModA = document.getElementById(IdModAlum).value;
		var Calif = document.getElementById(PromExtr1).value;

		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var Grado = document.getElementById("Grado").value;

		var TipoGuardar = "savExtra";
		if (Calif==''){
			swal("Error al guardar", "Debe escribir el promedio final del extraordinario.", "error");
        document.getElementById(PromExtr1).focus();
        return 0;
    }

		if(Grado == 6){
			if ((Calif == 5) || (Calif == 6) || (Calif == 7) || (Calif == 8) || (Calif == 9) || (Calif == 10) || (Calif == 'NP')){
			} else {
				swal("Error al guardar", "Debe escribir el promedio final del extraordinario. \n Ejemplo: 5, 6, 7, 8, 9, 10, NP", "error");
	        document.getElementById(PromExtr1).focus();
	        return 0;
	    }
		}
		if((Grado == 1) || (Grado == 2) || (Grado == 3)){
			if ((Calif == 5) || (Calif == 7) || (Calif == 8) || (Calif == 9) || (Calif == 10) || (Calif == 'NP')){
			} else {
				swal("Error al guardar", "Debe escribir el promedio final del extraordinario. \n Ejemplo: 5, 7, 8, 9, 10, NP", "error");
	        document.getElementById(PromExtr1).focus();
	        return 0;
	    }
		}

		$.ajax({
					url:"formConsulta/setting.php",
					method:"POST",
					data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, IdUsua:IdUsua, Extra:Extra},
					success:function(data){
						if(data == 1){

							swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
							// document.getElementById(Boton).style.display = 'block';
							// parent.location.href='doSelActa.php';
						}
					}
		 })
	}

	function savCalificacionE(IdUsua,Extra){

		if(Extra == 1){
			var ModAlum = "IdModAE-"+IdUsua;
			var CalAlum = "txtCalE-"+IdUsua;
		} else {
			var ModAlum = "IdModAT-"+IdUsua;
			var CalAlum = "txtCalT-"+IdUsua;
		}

		var IdModA = document.getElementById(ModAlum).value;
		var Calif = document.getElementById(CalAlum).value;

		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var TipoGuardar = "savIGSIE";
		if (Calif==''){
			swal("Error al guardar", "Debe escribir el promedio final.", "error");
        return 0;
    }


		$.ajax({
					url:"formConsulta/setting.php",
					method:"POST",
					data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, Extra:Extra, IdUsua:IdUsua},
					success:function(data){
						if(data == 1){
							swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
							// parent.location.href='doSelActa.php';
						}
					}
		 })
	}


	function cargarCal(IdParcialDoc,NoParcial){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var TipoGuardar = "cargarCali";
		swal({
		title: "\u00BFEst\u00E1 seguro que desea cargar calificaciones de este parcial?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
		//closeOnConfirm: false,
		//closeOnCancel: false
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
			document.getElementById("imgLoad").style.display = 'block';
			$.ajax({
						url:"formConsulta/setting.php",
						method:"POST",
						data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, IdParcialDoc:IdParcialDoc, NoParcial:NoParcial},
						success:function(data){
							if(data == 1){
								swal("Cargado correctamente", "Calificaciones cargadas correctamente.", "success");
								parent.location.href='doSelActa.php?idToks='+IdAsignacion;
							}
						}
			 })

			return true;
		} else {
			return false;
		}
	});
	}


		function cargarCalE(IdParcialDoc,NoParcial){
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			var TipoGuardar = "cargarCaliE";
			swal({
			title: "\u00BFEst\u00E1 seguro que desea cargar calificaciones?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
			//closeOnConfirm: false,
			//closeOnCancel: false
		},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				document.getElementById("imgLoad").style.display = 'block';
				$.ajax({
							url:"formConsulta/setting.php",
							method:"POST",
							data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, IdParcialDoc:IdParcialDoc, NoParcial:NoParcial},
							success:function(data){
								if(data == 1){

									swal("Cargado correctamente", "Calificaciones cargadas correctamente.", "success");
									parent.location.href='doSelActa.php?idToks='+IdAsignacion;
								}
							}
				 })

				return true;
			} else {
				return false;
			}
		});
		}

	function verCalificaciones(){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		$.ajax({
				 url:"formConsulta/viewCalificaciones.php",
				 method:"POST",
				 data:{IdAsignacion:IdAsignacion},
				 success:function(data){
							$('#employee_detailModPar').html(data);
							$('#dataModalModPar').modal('show');
				 }
		});

	}

	function sav_fecha_emi(){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var Fecha = document.getElementById("txt_fecha").value;

		if (Fecha==''){
			swal("Error al guardar", "Debe seleccionar la fecha de emisión del acta de calificación.", "error");
        document.getElementById("txt_fecha").focus();
        return 0;
    }
			var TipoGuardar = "sav_fec_emix";
			swal({
			title: "\u00BFEst\u00E1 seguro que desea emitir esta acta de calificación con la fecha seleccionada?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
			//closeOnConfirm: false,
			//closeOnCancel: false
		},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				$.ajax({
							url:"formConsulta/setting.php",
							method:"POST",
							data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Fecha:Fecha},
							success:function(data){
								if(data == 1){

									swal("Generado correctamente", "El acta de calificación se ha generado correctamente.", "success");
									parent.location.href='doSelActa.php?idToks='+IdAsignacion;
								}
							}
				 })

				return true;
			} else {
				return false;
			}
		});
	}
</script>
</html>
<?php

 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
