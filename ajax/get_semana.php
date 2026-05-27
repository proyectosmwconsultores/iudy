<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];

require('../php/clases/class_aula.php');
require('../hace.php');
$aula = new Aula();

$idSemana = isset($_POST['idSemana']) ? trim($_POST['idSemana']) : '';
$id_semana = addslashes($idSemana);


if (!isset($IdUsua)) {
	echo '
    <div class="block">
        <h4>Error de sesión</h4>
        <p>Estimado usuario debe iniciar sesión nuevamente.</p>
    </div>';
	exit;
}

if ($id_semana == '') {
	echo '
    <div class="block">
        <h4>Error al mostrar datos</h4>
        <p>No se recibió el identificador del contenido. Favor de ingresar nuevamente a la materia.</p>
    </div>';
	exit;
}

$semana = $aula->get_semana_id($id_semana);


if (!isset($semana[0])) {
	echo '
    <div class="block">
        <h4>Error</h4>
        <p>No se encontró el contenido solicitad0.</p>
    </div>';
	exit;
}


?>

<div id="viewActivity" class="lms-summary-card">
    <div class="lms-summary-card__header">
        <div class="lms-summary-card__title">
            <i class="fa fa-folder-open-o"></i>
            <h3 id="actTitle"><?php echo $semana[0]['Etiqueta_semana']; ?></h3>
        </div>
    </div>

    <div class="lms-summary-card__meta">
        <div class="meta-row">
            <span class="meta-label">Tema: </span>
            <div class="meta-value" id="actTema"><?php echo $semana[0]['Semana']; ?></div>
        </div>

        <div class="meta-row">
            <span class="meta-label">Objetivo: </span>
            <div class="meta-value" id="actObjetivo"><?php echo $semana[0]['Tematica']; ?></div>
        </div>
    </div>

    <div class="lms-summary-card__section">
        <div class="section-title">
            <i class="fa fa-file-text-o"></i>
            <span>Contenido</span>
        </div>

        <div class="section-content" id="actInstructions">
            <?php echo nl2br($semana[0]['Temas']); ?>
        </div>
    </div>
</div>
