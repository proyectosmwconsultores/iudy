<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];

require('../php/clases/class_aula.php');
require('../hace.php');
$aula = new Aula();

$idActividad = isset($_POST['idActividad']) ? trim($_POST['idActividad']) : '';
$id_actividad = addslashes($idActividad);


if (!isset($IdUsua)) {
	echo '
    <div class="block">
        <h4>Error de sesión</h4>
        <p>Estimado usuario debe iniciar sesión nuevamente.</p>
    </div>';
	exit;
}

if ($id_actividad == '') {
	echo '
    <div class="block">
        <h4>Error al mostrar datos</h4>
        <p>No se recibió el identificador de la actividad. Favor de ingresar nuevamente a la materia.</p>
    </div>';
	exit;
}

$actividad = $aula->get_actividad($id_actividad);
$parcial = $aula->get_parcialdocente_id($actividad[0]['IdParcialDocente']);
$tarea = $aula->get_tarea_alumno_id($IdUsua, $id_actividad, $actividad[0]['IdAsignacion'], $actividad[0]['IdParcialDocente']);
$docente = $aula->get_docente_id($actividad[0]['IdAsignacion']);
$materiales = $aula->get_material_id($id_actividad);
$companeros = $aula->companeros_trabajo($actividad[0]['IdAsignacion'],$IdUsua);


if (!isset($actividad[0])) {
	echo '
    <div class="block">
        <h4>Error</h4>
        <p>No se encontró la actividad solicitada.</p>
    </div>';
	exit;
}

$IdEstatus = $actividad[0]['IdEstatus'];

$iconos = [
	"Actividad" => "fa-upload",
	"Foro" => "fa-comments",
	"Examen en linea" => "fa-file-text",
	"Contenido" => "fa-check"
];

$icon = $iconos[$actividad[0]['TipoActividad']] ?? "fa-book";
$especial = 0;
if(isset($tarea[0]['FecFinal'])){
	$hoy = date("Y-m-d");
	if($hoy == $tarea[0]['FecFinal']){
		$IdEstatus = 8;
	}
	$especial = 1;
}

?>
<input type="hidden" id="IdActividadesDocente" value="<?php echo $actividad[0]['IdActividadesDocente']; ?>">
<input type="hidden" id="IdAsignacion" value="<?php echo $actividad[0]['IdAsignacion']; ?>">
<input type="hidden" id="IdParcialDocente" value="<?php echo $actividad[0]['IdParcialDocente']; ?>">
<input type="hidden" id="IdParcial" value="<?php echo $actividad[0]['IdParcialDocente']; ?>">
<input type="hidden" id="IdTarea" value="<?php echo $tarea[0]['IdTarea']; ?>">
<div id="viewActivity">
	<div class="activity-header">

		<div class="activity-main">
			<div class="activity-type">
				<!-- <i class="fa fa-comments"></i> -->
				<i class="fa <?php echo $icon; ?>"></i>
				<?php echo $actividad[0]['TipoActividad']; ?>
			</div>

			<h2 class="activity-title">
				<?php echo $actividad[0]['NomActividad']; ?>
			</h2>
		</div>

		<div class="activity-status <?php echo strtolower($actividad[0]['Estatus']); ?>">
			<?php echo $actividad[0]['Estatus']; ?>
		</div>
	</div>
	
		
	<?php if($especial == 1){ ?>
			<div class="alert-fecha-especial">
				<div class="alert-icon">
					<i class="fa fa-clock-o"></i>
				</div>

				<div class="alert-content">
					<strong>Fecha especial</strong>
					<p>Esta actividad tiene una fecha especial asignada por el profesor.</p>
					<span class="fecha">Disponible hasta: <b><?php echo obtenerSoloFecha($tarea[0]['FecFinal']); ?> </b></span>
				</div>
			</div><?php } ?>

	<div class="block">
		<h4><i class="fa fa-fw fa-edit"></i> Instrucciones</h4>
		<p id="actInstructions"><?php echo $actividad[0]['DesActividad']; ?></p>

		<div class="actions">
			<?php if (isset($actividad[0]['IdRubrica'])) { ?>
				<button class="btn ver" onclick="mi_rubrica(<?php echo $id_actividad; ?>)">
					<i class="fa fa-fw fa-check-circle-o"></i> Ver rúbrica
				</button>
			<?php } ?>
			<?php if ($actividad[0]['IdTipoActividad'] == 3) { ?>
				<a onclick="mi_chat_id('<?php echo $tarea[0]['IdTarea'] . '-' . $_SESSION['IdUsua'] . '-A-' . $docente[0]['IdUsua'] . '-' . $id_actividad; ?>')" class="btn chat">
					<i class="fa fa-wechat"></i> Chat
				</a><?php } ?>
		</div>
	</div>

	<div class="block">
		<h4>
			<i class="fa fa-fw fa-check-circle"></i> Información de la actividad
		</h4>
		<div class="rightBox">
			<div class="kv"><span>Estrategía:</span><b><?php echo $actividad[0]['Estrategia']; ?></b></div>
			<div class="kv"><span>Técnica:</span><b><?php echo $actividad[0]['Tecnica']; ?></b></div>
			<div class="kv"><span>Herramientas de aprendizaje:</span><b><?php echo $actividad[0]['Herramienta']; ?></b></div>
			<div class="kv"><span>Fecha de inicio:</span><b><?php echo obtenerSoloFecha($actividad[0]['FecIni']); ?></b></div>
			<div class="kv"><span>Fecha término:</span><b><?php echo obtenerSoloFecha($actividad[0]['FecFin']); ?></b></div>
			<div class="kv"><span>Valor porcentaje:</span><b><?php echo $actividad[0]['Porcentaje']; ?>%</b></div>
			<div class="kv"><span>Obtenido:</span><b><?php echo !empty($tarea[0]['Calificacion']) ? $tarea[0]['Calificacion'] . '%' : '-----'; ?></b></div>
		</div>
	</div>


	<?php if ($actividad[0]['IdTipoActividad'] == 1) { 
		if($parcial[0]['Tipo'] == 'E'){
			$pago = $aula->get_pagos_id($docente[0]['IdModulo'],$IdUsua,1);
			if((isset($pago[0]['IdEstatus']) && ($pago[0]['IdEstatus'] == 1))){
				$IdEstatus = 1;
			}
			if(!isset($tarea[0]['IdTarea'])){
				$IdEstatus = 1;
			}
		}
		
			if(($especial == 1) && ($IdEstatus == 8)){
				$inicio = $tarea[0]['FecFinal'].' 09:00:00';
				$fin    = $tarea[0]['FecFinal'].' 21:00:00';

				$iniRaw = $tarea[0]['FecFinal'].' 09:00:00';
				$finRaw = $tarea[0]['FecFinal'].' 21:00:00';

			} else {
				$inicio = $actividad[0]['Ini'];
				$fin    = $actividad[0]['Fin'];

				$iniRaw = $actividad[0]['Ini'] ?? null;
				$finRaw = $actividad[0]['Fin'] ?? null;
			}

			$meses = [
				1 => 'enero',
				2 => 'febrero',
				3 => 'marzo',
				4 => 'abril',
				5 => 'mayo',
				6 => 'junio',
				7 => 'julio',
				8 => 'agosto',
				9 => 'septiembre',
				10 => 'octubre',
				11 => 'noviembre',
				12 => 'diciembre'
			];

			function formatFechaEs($fecha, $meses)
			{
				$dt = new DateTime($fecha);

				$dia   = $dt->format('d');
				$mes   = $meses[(int)$dt->format('m')];
				$hora  = $dt->format('h:i a'); // 12h con am/pm

				return "{$dia} de {$mes} {$hora}";
			}

			$txtIni = formatFechaEs($inicio, $meses);
			$txtFin = formatFechaEs($fin, $meses);
			$textoImprimir = "{$txtIni} hasta el {$txtFin}";

			

			$dtIni = $iniRaw ? new DateTime($iniRaw) : null;
			$dtFin = $finRaw ? new DateTime($finRaw) : null;

			$iniTs = $dtIni ? $dtIni->getTimestamp() : 0;
			$finTs = $dtFin ? $dtFin->getTimestamp() : 0;
			$nowTs = time();


		?>
			<div class="block exam-inline-block">
				<h4>
					<i class="fa fa-fw fa-folder-open"></i>
					Examen en línea
				</h4>
				
				<div class="exam-inline-box">
					<div class="exam-inline-info">
						<div class="exam-inline-info-item highlight">
							<div class="exam-inline-info-icon">
								<i class="fa fa-clock-o"></i>
							</div>
							<div class="exam-inline-info-content">
								<strong>Duración de <?php echo $actividad[0]['Tiempo']; ?> hra</strong>
								<span>Considera tu tiempo antes de iniciar.</span>
							</div>
						</div>
						<div class="exam-inline-info-item">
							<div class="exam-inline-info-icon">
								<i class="fa fa-calendar"></i>
							</div>
							<div class="exam-inline-info-content">
								<strong>Fecha disponible</strong>
								<span><?php echo $textoImprimir; ?></span>
							</div>
						</div>
					</div>
					
					<div id="examAvailability"
						data-ini="<?php echo $iniTs; ?>"
						data-fin="<?php echo $finTs; ?>"
						data-now="<?php echo $nowTs; ?>">
					</div>
					<?php if ($IdEstatus == 8) { ?>
					<div class="exam-inline-top">
						<div class="exam-inline-main" style="text-align: center;">
							<br>
							<button id="btnExamDone2" onclick="iniciarExamenEspecial('<?php echo $actividad[0]['IdAsignacion']; ?>',<?php echo $actividad[0]['IdParcialDocente']; ?>,<?php echo $actividad[0]['IdSemanaDocente']; ?>,<?php echo $actividad[0]['IdActividadesDocente']; ?>,<?php echo $tarea[0]['IdTarea']; ?>)" type="button" class="exam-inline-btn">
								<i class="fa fa-play-circle"></i>
								Ingresar a mi examen
							</button>

							<p id="btnExamDone" style="display:none; font-weight:700;"></p>
						</div>
					</div>
					<?php }  ?>
				</div>
			</div>


		
	<?php } ?>

	<?php if($actividad[0]['Modalidad'] == 2){ ?>

	<div class="block">
	<h4>
		<i class="fa fa-fw fa-users"></i> Mi equipo de trabajo para la actividad
	</h4>

	<?php if (!empty($companeros)) { ?>
		<div class="team-box">
			<div class="team-box-header">
				<div class="team-icon">
					<i class="fa fa-users"></i>
				</div>
				<div class="team-info">
					<div class="team-title">Actividad colaborativa</div>
					<div class="team-subtitle">
						Estos son los compañeros asignados a tu equipo para esta actividad.
					</div>
				</div>
			</div>

			<div class="team-grid">
				<?php foreach ($companeros as $item) { 
					$nombreCompleto = trim($item['Nombre'] . ' ' . $item['APaterno'] . ' ' . $item['AMaterno']);
					$inicial = strtoupper(substr($item['Nombre'], 0, 1));
				?>
					<div class="team-member-card">
						<div class="team-member-avatar">
							<?php echo $inicial; ?>
						</div>

						<div class="team-member-body">
							<div class="team-member-name">
								<?php echo htmlspecialchars($nombreCompleto); ?>
							</div>

							<div class="team-member-role">
								Compañero de equipo
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } else { ?>
		<div class="team-empty">
			<div class="team-empty-icon">
				<i class="fa fa-users"></i>
			</div>
			<p>Aún no se han asignado compañeros para esta actividad en equipo.</p>
		</div>
	<?php } ?>
	</div>
<?php } ?>





	<?php if (!empty($materiales)) { ?>
		<div class="block">
			<h4>
				<i class="fa fa-fw fa-folder-open"></i> Mis materiales didácticos
			</h4>
			<div class="material-grid">
				<?php foreach ($materiales as $material) {
					$extension = !empty($material['Tipo'])
						? strtolower($material['Tipo'])
						: 'file';
					$nombre = !empty($material['Nombre'])
						? $material['Nombre']
						: 'Material sin nombre';
				?>
					<div class="material-card">
						<div class="material-thumb" onclick="verBiblioteca(<?php echo $material['IdBiblioteca'] ?>)">
							<?php if ($extension == 'pdf') { ?>
								<i class="fa fa-file-pdf-o"></i>
							<?php } elseif ($extension == 'doc' || $extension == 'docx') { ?>
								<i class="fa fa-file-word-o"></i>
							<?php } elseif ($extension == 'xls' || $extension == 'xlsx') { ?>
								<i class="fa fa-file-excel-o"></i>
							<?php } elseif ($extension == 'ppt' || $extension == 'pptx') { ?>
								<i class="fa fa-file-powerpoint-o"></i>
							<?php } elseif ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') { ?>
								<i class="fa fa-file-image-o"></i>
							<?php } else { ?>
								<i class="fa fa-file-o"></i>
							<?php } ?>
						</div>
						<div class="material-body">
							<div class="material-title"><?php echo htmlspecialchars($nombre); ?>
						</div>
						<div class="material-meta">
							<?php if (!empty($material['Tipo'])) { ?>
								<span><?php echo strtoupper($material['Tipo']); ?></span>
							<?php } ?>
							<?php if (!empty($material['Tipo']) && !empty($peso)) { ?>
								<span>•</span>
							<?php } ?>
						</div>

					</div>
			</div>
		<?php } ?>
		</div>
</div>
<?php } else { ?>
	<div class="block">
		<h4>
			<i class="fa fa-fw fa-folder-open"></i>
			Mis materiales didácticos
		</h4>
		<div class="empty-material">
			<i class="fa fa-folder-open-o"></i>
			<p>
				Aún no hay materiales didácticos disponibles para esta actividad.
			</p>
		</div>
	</div>
<?php } ?>






<?php if ($actividad[0]['IdTipoActividad'] == 3) { ?>

	<?php if (empty($tarea[0]['Link'])) {
		if ($IdEstatus == 8) { ?>
			<div class="block block-upload-pro">
				<h4><i class="fa fa-fw fa-cloud-upload"></i> Subir mi tarea</h4>

				<div class="upload-pro-card">
					<div class="upload-pro-head">
						<div>
							<div class="upload-pro-title">Entrega de actividad</div>
							<div class="upload-pro-subtitle">
								Adjunta tu archivo y agrega un comentario opcional para el profesor.
							</div>
						</div>
					</div>

					<div id="uploadSelectorWrapper">
						<div id="dropZoneTarea" class="upload-dropzone-pro">
							<input id="fileInput" type="file" class="file-input-hidden"
								accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.webp,.zip,.rar">

							<div class="upload-dropzone-content">
								<div class="upload-dropzone-icon">
									<i class="fa fa-cloud-upload"></i>
								</div>
								<div class="upload-dropzone-title">
									Arrastra aquí tu archivo o haz clic para seleccionarlo
								</div>
								<div class="upload-dropzone-text">
									Formatos permitidos: PDF, Word, Excel, PowerPoint, imágenes y ZIP/RAR
								</div>
								<div class="upload-dropzone-meta">
									Tamaño máximo: 20 MB
								</div>
								<button type="button" id="btnSelectFile" class="btn primario btn-upload-select">
									<i class="fa fa-folder-open"></i> Seleccionar archivo
								</button>
							</div>
						</div>

						<div id="selectedFileCard" class="selected-file-card" style="display:none;"></div>
					</div>

					<div class="upload-comment-box">
						<label for="comment">Comentario para el profesor</label>
						<textarea id="comment" placeholder="Escribe un comentario opcional para acompañar tu entrega..."></textarea>
					</div>

					<div class="upload-warning-pending" id="uploadPendingNotice" style="display:none;">
						<i class="fa fa-info-circle"></i>
						Tu archivo fue seleccionado, pero aún no se ha enviado. Da clic en <b>Subir y entregar tarea</b>.
					</div>

					<div class="upload-actions-pro">
						<button id="btnSend" type="button" class="btn primario">
							<i class="fa fa-fw fa-send"></i> Subir y entregar tarea
						</button>
					</div>
				</div>
			</div>
		<?php }
	} else { ?>

		<div class="block">
			<h4><i class="fa fa-fw fa-check-circle-o"></i> Mi tarea entregada</h4>

			<div class="upload upload-entregado">
				<div class="drop entregado-box">
					<div class="entrega-head">
						<div class="entrega-icon">
							<i class="fa fa-check-circle"></i>
						</div>
						<div class="entrega-info">
							<strong>Tarea entregada correctamente</strong>
							<div class="tag success">
								<?php
								if (empty($tarea[0]['Calificacion'])) {
									echo 'Entrega registrada en plataforma';
								} else {
									echo 'Tarea calificada por el docente';
								}
								?>
							</div>
						</div>
					</div>

					<?php
					$extTarea = !empty($tarea[0]['ExtensionArchivo']) ? strtolower($tarea[0]['ExtensionArchivo']) : '';
					$iconTarea = 'fa-file-o';

					if ($extTarea == 'pdf') {
						$iconTarea = 'fa-file-pdf-o';
					} elseif (in_array($extTarea, ['doc', 'docx'])) {
						$iconTarea = 'fa-file-word-o';
					} elseif (in_array($extTarea, ['xls', 'xlsx', 'csv'])) {
						$iconTarea = 'fa-file-excel-o';
					} elseif (in_array($extTarea, ['ppt', 'pptx'])) {
						$iconTarea = 'fa-file-powerpoint-o';
					} elseif (in_array($extTarea, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
						$iconTarea = 'fa-file-image-o';
					} elseif (in_array($extTarea, ['zip', 'rar'])) {
						$iconTarea = 'fa-file-archive-o';
					}
					?>

					<div class="archivo-card">
						<div class="archivo-icon">
							<i class="fa <?php echo $iconTarea; ?>"></i>
						</div>

						<div class="archivo-info">
							<div style="cursor: pointer;" onclick="verTarea(<?php echo $tarea[0]['IdTarea']; ?>, 'Link')" class="archivo-nombre">
								<?php echo $tarea[0]['Link']; ?>
							</div>
							<div class="archivo-meta">
								<span><?php echo !empty($tarea[0]['ExtensionArchivo']) ? strtoupper($tarea[0]['ExtensionArchivo']) : ''; ?></span>
								<span>•</span>
								<span><?php echo !empty($tarea[0]['PesoArchivo']) ? $tarea[0]['PesoArchivo'] : ''; ?> MB</span>
								<span>•</span>
								<span>Subido el <?php echo fecha_lms($tarea[0]['FecCap']); ?>.</span>
							</div>
						</div>
					</div>

					<?php if (!empty($tarea[0]['Comentario'])) { ?>
						<div class="comentario-box">
							<div class="comentario-label">Comentario enviado al profesor:</div>
							<div class="comentario-texto">
								<?php echo $tarea[0]['Comentario']; ?>
							</div>
						</div>
					<?php } ?>

					<div class="actions actions-entrega">
						<a onclick="verTarea(<?php echo $tarea[0]['IdTarea']; ?>, 'Link')" class="btn descargar">
							<i class="fa fa-download"></i> Descargar
						</a>

						<?php if ($IdEstatus == 8) { ?>
							<button onclick="eliminarTarea(<?php echo $tarea[0]['IdTarea']; ?>,<?php echo $id_actividad; ?>)" class="btn eliminar">
								<i class="fa fa-trash"></i> Eliminar
							</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } ?>

<?php if ($actividad[0]['IdTipoActividad'] == 2) {
	$comentarios = $aula->get_foro_comentarios($id_actividad);
?>

	<div class="block">
		<h4><i class="fa fa-fw fa-comments"></i> Foro de discusión</h4>
		<?php if ($IdEstatus == 8) { ?>
			<div class="foro-box">
				<textarea id="txtComentarioForo" placeholder="Escribe tu comentario..."></textarea>
				<div class="actions" style="margin-top:10px;">
					<button type="button" class="btn primario" id="btnComentarForo">
						<i class="fa fa-fw fa-send"></i> Publicar comentario
					</button>
				</div>
			</div><?php } ?>

		<div id="listaComentariosForo">
			<?php if (!empty($comentarios)) { ?>
				<?php foreach ($comentarios as $comentario) {
					$respuestas = $aula->get_foro_respuestas($comentario['IdComentario']);
				?>
					<div class="comentario-item">
						<div class="comentario-head">
							<strong><?php echo $comentario['Nombre']; ?> <?php echo $comentario['APaterno']; ?> <?php echo $comentario['AMaterno']; ?></strong>
							<span><?php echo fecha_lms($comentario['FecCap']); ?></span>
						</div>

						<div class="comentario-body">
							<?php echo nl2br($comentario['Comentario']); ?>
						</div>
						<?php if ($IdEstatus == 8) { ?>
							<div class="comentario-actions">
								<button class="btn-responder" data-id="<?php echo $comentario['IdComentario']; ?>">
									Responder
								</button>
							</div>

							<div class="respuesta-box" id="respuesta_<?php echo $comentario['IdComentario']; ?>" style="display:none;">
								<textarea id="txt_respuesta_<?php echo $comentario['IdComentario']; ?>" placeholder="Escribe una respuesta..."></textarea>
								<button type="button" class="btn-enviar-respuesta" data-id="<?php echo $comentario['IdComentario']; ?>">
									<i class="fa fa-fw fa-send"></i> Enviar respuesta
								</button>
							</div>
						<?php } ?>

						<div class="comentario-respuestas">
							<?php if (!empty($respuestas)) { ?>
								<?php foreach ($respuestas as $respuesta) { ?>
									<div class="comentario-item comentario-item-respuesta">
										<div class="comentario-head">
											<strong><?php echo $respuesta['Nombre']; ?> <?php echo $respuesta['APaterno']; ?> <?php echo $respuesta['AMaterno']; ?></strong>
											<span><?php echo fecha_lms($respuesta['FecCap']); ?></span>
										</div>

										<div class="comentario-body">
											<?php echo nl2br($respuesta['Comentario']); ?>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="block">
					<p>No hay comentarios todavía. Sé el primero en participar.</p>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>


</div>
<script>
	function showAlert(message, type) {
		let icon = 'info';
		let title = 'Aviso';

		if (type === 'success') {
			icon = 'success';
			title = 'Tarea enviada';
		}

		if (type === 'error') {
			icon = 'error';
			title = 'Error';
		}

		Swal.fire({
			icon: icon,
			title: title,
			text: message,
			confirmButtonText: 'Aceptar',
			confirmButtonColor: '#2563eb',
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false
		});
	}

	(function() {
		const campoActividad = document.getElementById('IdActividadesDocente');
		const campoAsignacion = document.getElementById('IdAsignacion');
		const campoParcial = document.getElementById('IdParcialDocente');
		const campoTarea = document.getElementById('IdTarea');

		if (!campoActividad || !campoAsignacion || !campoParcial) {
			return;
		}

		const IdActividadesDocente = campoActividad.value;
		const IdAsignacion = campoAsignacion.value;
		const IdParcialDocente = campoParcial.value;
		const IdTarea = campoTarea ? campoTarea.value : '';

		const fileInput = document.getElementById('fileInput');
		const btnSend = document.getElementById('btnSend');
		const comment = document.getElementById('comment');
		const dropZone = document.getElementById('dropZoneTarea');
		const btnSelectFile = document.getElementById('btnSelectFile');
		const selectedFileCard = document.getElementById('selectedFileCard');

		function recargarVistaActividad() {
			$('#detalleActividad').html(
				'<div class="block"><p><i class="fa fa-spinner fa-spin"></i> Cargando actividad...</p></div>'
			);

			$.ajax({
				url: 'ajax/get_actividad.php',
				type: 'POST',
				data: {
					idActividad: IdActividadesDocente
				},
				success: function(respuesta) {
					$('#detalleActividad').html(respuesta);
				},
				error: function() {
					$('#detalleActividad').html(
						'<div class="block"><p>Error al cargar la actividad.</p></div>'
					);
				}
			});
		}

		if (!fileInput || !btnSend || !comment || !dropZone || !btnSelectFile || !selectedFileCard) {
			return;
		}

		const MAX_SIZE = 20 * 1024 * 1024;

		const allowedExt = [
			'pdf', 'doc', 'docx',
			'xls', 'xlsx', 'csv',
			'ppt', 'pptx',
			'jpg', 'jpeg', 'png', 'gif', 'webp',
			'zip', 'rar'
		];

		function formatBytes(bytes) {
			if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
			if (bytes >= 1024) return (bytes / 1024).toFixed(2) + ' KB';
			return bytes + ' bytes';
		}

		function getFileIcon(extension) {
			extension = (extension || '').toLowerCase();

			if (extension === 'pdf') return 'fa-file-pdf-o';
			if (['doc', 'docx'].includes(extension)) return 'fa-file-word-o';
			if (['xls', 'xlsx', 'csv'].includes(extension)) return 'fa-file-excel-o';
			if (['ppt', 'pptx'].includes(extension)) return 'fa-file-powerpoint-o';
			if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) return 'fa-file-image-o';
			if (['zip', 'rar'].includes(extension)) return 'fa-file-archive-o';
			return 'fa-file-o';
		}

		function toggleDropzone(show) {
			const uploadPendingNotice = document.getElementById('uploadPendingNotice');

			if (show) {
				dropZone.style.display = 'block';
				selectedFileCard.style.display = 'none';
				selectedFileCard.innerHTML = '';

				if (uploadPendingNotice) {
					uploadPendingNotice.style.display = 'none';
				}
			} else {
				dropZone.style.display = 'none';
				selectedFileCard.style.display = 'flex';

				if (uploadPendingNotice) {
					uploadPendingNotice.style.display = 'block';
				}
			}
		}

		function renderSelectedFile(file) {
			if (!file) {
				toggleDropzone(true);
				return;
			}

			const extension = file.name.split('.').pop().toLowerCase();
			const icon = getFileIcon(extension);

			selectedFileCard.innerHTML = `
				<div class="selected-file-left">
					<div class="selected-file-icon is-pending">
						<i class="fa ${icon}"></i>
					</div>
					<div class="selected-file-info">
						<div class="selected-file-name">${file.name}</div>
						<div class="selected-file-meta">${extension.toUpperCase()} · ${formatBytes(file.size)}</div>
						<div class="selected-file-status pending">
							<i class="fa fa-clock-o"></i>
							Archivo seleccionado, pendiente de envío
						</div>
						<div class="selected-file-help">
							Este archivo aún no se ha subido. Haz clic en <b>“Subir y entregar tarea”</b> para completar el envío.
						</div>
					</div>
				</div>
				<button type="button" class="selected-file-remove" id="btnRemoveSelectedFile" title="Quitar archivo">
					<i class="fa fa-times"></i>
				</button>
			`;

			toggleDropzone(false);

			const btnRemove = document.getElementById('btnRemoveSelectedFile');
			if (btnRemove) {
				btnRemove.addEventListener('click', function() {
					fileInput.value = '';
					renderSelectedFile(null);
				});
			}
		}

		function setDroppedFiles(files) {
			if (!files || !files.length) return;

			const dt = new DataTransfer();
			dt.items.add(files[0]);
			fileInput.files = dt.files;

			renderSelectedFile(files[0]);
		}

		toggleDropzone(true);

		btnSelectFile.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			fileInput.click();
		});

		dropZone.addEventListener('click', function(e) {
			if (e.target.id !== 'btnSelectFile') {
				fileInput.click();
			}
		});

		fileInput.addEventListener('change', function() {
			const file = this.files[0] || null;
			renderSelectedFile(file);
		});

		dropZone.addEventListener('dragover', function(e) {
			e.preventDefault();
			e.stopPropagation();
			dropZone.classList.add('is-dragover');
		});

		dropZone.addEventListener('dragleave', function(e) {
			e.preventDefault();
			e.stopPropagation();
			dropZone.classList.remove('is-dragover');
		});

		dropZone.addEventListener('drop', function(e) {
			e.preventDefault();
			e.stopPropagation();
			dropZone.classList.remove('is-dragover');

			if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
				setDroppedFiles(e.dataTransfer.files);
			}
		});

		btnSend.addEventListener('click', function() {
			const file = fileInput.files[0];

			if (!file) {
				showAlert('Debes seleccionar un archivo antes de entregar la tarea.', 'error');
				return;
			}

			const extension = file.name.split('.').pop().toLowerCase();

			if (!allowedExt.includes(extension)) {
				showAlert('Formato no permitido. Solo se aceptan PDF, Word, Excel, PowerPoint, imágenes y ZIP/RAR.', 'error');
				return;
			}

			if (file.size > MAX_SIZE) {
				showAlert('El archivo supera el tamaño máximo permitido de 20 MB.', 'error');
				return;
			}

			const formData = new FormData();
			formData.append('archivo', file);
			formData.append('comentario', comment.value);
			formData.append('IdActividadesDocente', IdActividadesDocente);
			formData.append('IdAsignacion', IdAsignacion);
			formData.append('IdParcialDocente', IdParcialDocente);
			formData.append('IdTarea', IdTarea);

			btnSend.disabled = true;
			btnSend.innerHTML = '<i class="fa fa-fw fa-spinner fa-spin"></i> Subiendo...';

			Swal.fire({
				title: 'Subiendo tarea...',
				html: `
					<p><img src="assets/images/cargando.gif" style="z-index:99999; width:125px;"></p>
					<div style="text-align:left; margin-top:10px;">
						<div style="font-size:14px; margin-bottom:8px; color:#555; text-align:center;">
							Por favor espera. No cierres ni recargues esta página.
						</div>
						<div style="width:100%; height:18px; background:#e5e7eb; border-radius:999px; overflow:hidden;">
							<div id="uploadProgressBar" style="width:0%; height:100%; background:#2563eb; transition:width .2s;"></div>
						</div>
						<div id="uploadProgressText" style="margin-top:8px; font-size:13px; color:#374151; text-align:center;">0%</div>
					</div>
				`,
				allowOutsideClick: false,
				allowEscapeKey: false,
				showConfirmButton: false,
				allowEnterKey: false
			});

			const xhr = new XMLHttpRequest();
			xhr.open('POST', 'ajax/subir_tarea.php', true);

			xhr.upload.addEventListener('progress', function(e) {
				if (e.lengthComputable) {
					const percent = Math.round((e.loaded / e.total) * 100);
					const progressBar = document.getElementById('uploadProgressBar');
					const progressText = document.getElementById('uploadProgressText');

					if (progressBar) progressBar.style.width = percent + '%';
					if (progressText) progressText.textContent = percent + '%';
				}
			});

			xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				btnSend.disabled = false;
				btnSend.innerHTML = '<i class="fa fa-fw fa-send"></i> Subir y entregar tarea';

				Swal.close();

				if (xhr.status === 200) {
					try {
						const data = JSON.parse(xhr.responseText);

						if (data.ok) {
							const uploadPendingNotice = document.getElementById('uploadPendingNotice');
							if (uploadPendingNotice) {
								uploadPendingNotice.style.display = 'none';
							}
							Swal.fire({
								icon: 'success',
								title: 'Tarea enviada',
								text: data.msg,
								confirmButtonText: 'Aceptar',
								confirmButtonColor: '#2563eb',
								allowOutsideClick: false, // ❌ no cerrar al dar clic fuera
								allowEscapeKey: false,   // ❌ no cerrar con ESC
								allowEnterKey: false     // opcional (evita cerrar con Enter)
							}).then((result) => {
								if (result.isConfirmed) {
									recargarVistaActividad();
								}
							});
						} else {
							showAlert(data.msg, 'error');
						}
					} catch (error) {
						showAlert('La respuesta del servidor no es válida.', 'error');
					}
				} else {
					showAlert('Ocurrió un error al comunicarse con el servidor.', 'error');
				}
			}
		};

		xhr.send(formData);
		});
	})();


	function eliminarTarea(idTarea, idActividad) {
		Swal.fire({
			title: '¿Eliminar tarea?',
			text: 'Esta acción eliminará el archivo subido y el registro de la entrega.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#dc2626',
			cancelButtonColor: '#64748b',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar',
			reverseButtons: true
		}).then((result) => {
			if (!result.isConfirmed) {
				return;
			}

			Swal.fire({
				title: 'Eliminando tarea...',
				text: 'Por favor espera',
				allowOutsideClick: false,
				allowEscapeKey: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});

			$.ajax({
				url: 'ajax/eliminar_tarea.php',
				type: 'POST',
				dataType: 'json',
				data: {
					IdTarea: idTarea
				},
				success: function(respuesta) {
					Swal.close();

					if (respuesta.ok) {
						Swal.fire({
							icon: 'success',
							title: 'Tarea eliminada',
							text: respuesta.msg,
							confirmButtonText: 'Aceptar',
							confirmButtonColor: '#2563eb',
							allowOutsideClick: false,
							allowEscapeKey: false
						}).then(() => {
							recargarVistaActividad_id(idActividad);
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: respuesta.msg,
							confirmButtonText: 'Aceptar',
							confirmButtonColor: '#2563eb'
						});
					}
				},
				error: function() {
					Swal.close();

					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'No se pudo eliminar la tarea.',
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					});
				}
			});
		});
	}

	function recargarVistaActividad_id(idActividad) {
		$('#detalleActividad').html(
			'<div class="block"><p><i class="fa fa-spinner fa-spin"></i> Cargando actividad...</p></div>'
		);

		$.ajax({
			url: 'ajax/get_actividad.php',
			type: 'POST',
			data: {
				idActividad: idActividad
			},
			success: function(respuesta) {
				$('#detalleActividad').html(respuesta);
			},
			error: function() {
				$('#detalleActividad').html(
					'<div class="block"><p>Error al cargar la actividad.</p></div>'
				);
			}
		});
	}



	// Evita que el evento se registre varias veces cuando se recarga get_actividad.php por AJAX
	$(document).off('click', '#btnComentarForo').on('click', '#btnComentarForo', function(e) {

		e.preventDefault();
		e.stopPropagation();

		var $btn = $(this);
		var comentario = $('#txtComentarioForo').val().trim();
		var idActividad = $('#IdActividadesDocente').val();
		var idAsignacion = $('#IdAsignacion').val();
		var idParcial = $('#IdParcialDocente').val();

		// Validación
		if (comentario === '') {

			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Debes escribir un comentario.',
				confirmButtonText: 'Aceptar',
				confirmButtonColor: '#2563eb'
			});

			return;
		}

		// Evita doble clic
		if ($btn.prop('disabled')) {
			return;
		}

		$btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Publicando...');

		Swal.fire({
			title: 'Publicando comentario...',
			text: 'Por favor espera.',
			allowOutsideClick: false,
			allowEscapeKey: false,
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'ajax/guardar_comentario_foro.php',
			type: 'POST',
			dataType: 'json',
			data: {
				IdActividadesDocente: idActividad,
				IdAsignacion: idAsignacion,
				IdParcialDocente: idParcial,
				Comentario: comentario
			},

			success: function(respuesta) {

				Swal.close();

				$btn.prop('disabled', false)
					.html('<i class="fa fa-fw fa-send"></i> Publicar comentario');

				if (respuesta.ok) {

					$('#txtComentarioForo').val('');

					Swal.fire({
						icon: 'success',
						title: 'Comentario publicado',
						text: respuesta.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb',
						allowOutsideClick: false,
						allowEscapeKey: false
					}).then(() => {

						// recargar la actividad para ver el comentario nuevo
						recargarVistaActividad_id(idActividad);

					});

				} else {

					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: respuesta.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					});

				}
			},

			error: function() {

				Swal.close();

				$btn.prop('disabled', false)
					.html('<i class="fa fa-fw fa-send"></i> Publicar comentario');

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'No se pudo guardar el comentario.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#2563eb'
				});

			}

		});

	});

	$(document).off('click', '.btn-responder').on('click', '.btn-responder', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var idComentario = $(this).data('id');
		var caja = $('#respuesta_' + idComentario);

		if (caja.length) {
			$('.respuesta-box').not(caja).slideUp(200);
			caja.slideToggle(200);
		}
	});


	$(document).off('click', '.btn-enviar-respuesta').on('click', '.btn-enviar-respuesta', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var $btn = $(this);
		var idComentarioPadre = $btn.attr('data-id');
		var respuesta = $('#txt_respuesta_' + idComentarioPadre).val().trim();

		var idActividad = $('#IdActividadesDocente').val();
		var idAsignacion = $('#IdAsignacion').val();
		var idParcial = $('#IdParcialDocente').val();

		if (respuesta === '') {
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Debes escribir una respuesta.',
				confirmButtonText: 'Aceptar',
				confirmButtonColor: '#2563eb'
			});
			return;
		}

		if ($btn.prop('disabled')) {
			return;
		}

		$btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enviando...');

		Swal.fire({
			title: 'Publicando respuesta...',
			text: 'Por favor espera.',
			allowOutsideClick: false,
			allowEscapeKey: false,
			showConfirmButton: false,
			didOpen: () => {
				Swal.showLoading();
			}
		});

		$.ajax({
			url: 'ajax/guardar_respuesta_foro.php',
			type: 'POST',
			dataType: 'json',
			data: {
				IdActividadesDocente: idActividad,
				IdAsignacion: idAsignacion,
				IdParcialDocente: idParcial,
				IdComentarioPadre: idComentarioPadre,
				Comentario: respuesta
			},
			success: function(respuestaAjax) {
				Swal.close();

				$btn.prop('disabled', false).html('Enviar respuesta');

				if (respuestaAjax.ok) {
					Swal.fire({
						icon: 'success',
						title: 'Respuesta publicada',
						text: respuestaAjax.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					}).then(() => {
						recargarVistaActividad_id(idActividad);
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: respuestaAjax.msg,
						confirmButtonText: 'Aceptar',
						confirmButtonColor: '#2563eb'
					});
				}
			},
			error: function(xhr, status, error) {
				Swal.close();

				$btn.prop('disabled', false).html('Enviar respuesta');

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'No se pudo guardar la respuesta.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#2563eb'
				});
			}
		});
	});
</script>

<script>
	(() => {
		const el = document.getElementById('examAvailability');
		if (!el) return;

		const ini = Number(el.dataset.ini || 0) * 1000;
		const fin = Number(el.dataset.fin || 0) * 1000;
		const nowServer = Number(el.dataset.now || 0) * 1000;

		const btnExam = document.getElementById('btnExamDone2');
		const msgExam = document.getElementById('btnExamDone');

		if (!btnExam && !msgExam) return;

		const clientStart = Date.now();

		function getServerLikeNow() {
			return nowServer + (Date.now() - clientStart);
		}

		function setState(state) {
			if (btnExam) {
				btnExam.disabled = false;
				btnExam.style.display = 'inline-flex';
				btnExam.classList.remove('is-disabled');
			}

			if (msgExam) {
				msgExam.style.display = 'none';
				msgExam.innerHTML = '';
				msgExam.style.color = '';
				msgExam.style.fontWeight = '700';
			}

			if (state === 'open') {
				if (btnExam) {
					btnExam.disabled = false;
					btnExam.style.display = 'inline-flex';
				}
			}

			if (state === 'before') {
				if (btnExam) {
					btnExam.disabled = true;
					btnExam.style.display = 'none';
				}

				if (msgExam) {
					msgExam.style.display = 'block';
					msgExam.style.color = '#b45309';
					msgExam.innerHTML = '<i class="fa fa-clock-o"></i> El examen aún no está disponible';
				}
			}

			if (state === 'after') {
				if (btnExam) {
					btnExam.disabled = true;
					btnExam.style.display = 'none';
				}

				if (msgExam) {
					msgExam.style.display = 'block';
					msgExam.style.color = '#dc2626';
					msgExam.innerHTML = '<i class="fa fa-warning"></i> Evaluación finalizada';
				}
			}
		}

		function tick() {
			const now = getServerLikeNow();

			if (ini > 0 && now < ini) {
				setState('before');
				return;
			}

			if (fin > 0 && now > fin) {
				setState('after');
				return;
			}

			setState('open');
		}

		tick();
		setInterval(tick, 1000);
	})();
</script>