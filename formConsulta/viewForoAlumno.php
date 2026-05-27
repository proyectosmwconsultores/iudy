<?php
session_start();
require('../php/clases/class.System.php');

$db = new Conexion();

$IdUsua = isset($_POST['IdUsua']) ? intval($_POST['IdUsua']) : 0;
$IdActividad = isset($_POST['IdActividad']) ? intval($_POST['IdActividad']) : 0;

if ($IdUsua <= 0 || $IdActividad <= 0) {
    echo '<div class="alert alert-danger">Parámetros inválidos.</div>';
    exit;
}
/*
|--------------------------------------------------------------------------
| Consulta del alumno y actividad
|--------------------------------------------------------------------------
*/
$sqlAlumno = "SELECT  IdUsua, CONCAT(IFNULL(Nombre,''), ' ', IFNULL(APaterno,''), ' ', IFNULL(AMaterno,'') ) AS NombreCompleto FROM tblc_usuario WHERE IdUsua = $IdUsua LIMIT 1";
$rsAlumno = $db->query($sqlAlumno);
$alumno = $db->recorrer($rsAlumno);

$NombreAlumno = isset($alumno['NombreCompleto']) && trim($alumno['NombreCompleto']) != '' ? trim($alumno['NombreCompleto']) : 'Alumno';

$sqlActividad = "SELECT  IdActividadesDocente, NomActividad FROM tblp_actividadesdocente WHERE IdActividadesDocente = $IdActividad LIMIT 1";
$rsActividad = $db->query($sqlActividad);
$actividad = $db->recorrer($rsActividad);

$NombreActividad = isset($actividad['NomActividad']) && trim($actividad['NomActividad']) != '' ? trim($actividad['NomActividad']) : 'Actividad sin título';

/*
|--------------------------------------------------------------------------
| Comentarios del alumno para la actividad
|--------------------------------------------------------------------------
*/
$sql = "SELECT  IdComentario, IdComentarioPadre, Comentario, FecCap, Estatus FROM tblp_foro_comentarios WHERE IdAlumno = $IdUsua AND IdActividadesDocente = $IdActividad AND Estatus = 'Activo' ORDER BY FecCap ASC";
$result = $db->query($sql);

$comentariosPadre = [];
$respuestas = [];

while ($row = $db->recorrer($result)) {
    $row['ComentarioSeguro'] = $row['Comentario'];
    // $row['ComentarioSeguro'] = nl2br(htmlspecialchars($row['Comentario'], ENT_QUOTES, 'UTF-8'));
    $row['FechaFormato'] = !empty($row['FecCap']) ? date('d/m/Y h:i A', strtotime($row['FecCap'])) : '';

    if (empty($row['IdComentarioPadre'])) {
        $row['respuestas'] = [];
        $comentariosPadre[$row['IdComentario']] = $row;
    } else {
        $respuestas[] = $row;
    }
}

foreach ($respuestas as $resp) {
    $padre = intval($resp['IdComentarioPadre']);
    if (isset($comentariosPadre[$padre])) {
        $comentariosPadre[$padre]['respuestas'][] = $resp;
    }
}

$totalComentarios = count($comentariosPadre);
$totalRespuestas = count($respuestas);
$totalParticipaciones = $totalComentarios + $totalRespuestas;
?>

<style>
    .foro-lms-wrap{
        font-family: "Segoe UI", Arial, sans-serif;
        color:#243447;
    }

    .foro-lms-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:16px;
        padding:18px 20px;
        border-radius:16px;
        background:linear-gradient(135deg, #f7f9fc 0%, #eef3f8 100%);
        border:1px solid #e5edf5;
        margin-bottom:18px;
    }

    .foro-lms-title{
        margin:0;
        font-size:22px;
        font-weight:700;
        color:#1f2d3d;
    }

    .foro-lms-subtitle{
        margin-top:6px;
        font-size:13px;
        color:#6b7a8c;
    }

    .foro-lms-badges{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        justify-content:flex-end;
    }

    .foro-badge{
        background:#fff;
        border:1px solid #dfe7ef;
        border-radius:14px;
        padding:10px 14px;
        min-width:110px;
        text-align: center;
        box-shadow:0 4px 12px rgba(31,45,61,.04);
    }

    .foro-badge .label{
        display:block;
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:.4px;
        color:#7b8a9a;
        margin-bottom:4px;
    }

    .foro-badge .value{
        font-size:18px;
        font-weight:700;
        color:#1f2d3d;
    }

    .foro-lms-section{
        background:#fff;
        border:1px solid #e8edf3;
        border-radius:16px;
        padding:18px;
        box-shadow:0 8px 24px rgba(15,23,42,.04);
    }

    .foro-empty{
        text-align:center;
        padding:40px 20px;
        color:#7b8a9a;
    }

    .foro-card{
        background:#ffffff;
        border:1px solid #e9eef4;
        border-radius:16px;
        padding:16px;
        margin-bottom:16px;
        box-shadow:0 8px 18px rgba(20,35,50,.04);
    }

    .foro-card:last-child{
        margin-bottom:0;
    }

    .foro-card-top{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:12px;
    }

    .foro-user{
        display:flex;
        align-items:center;
        gap:12px;
    }

    .foro-avatar{
        width:42px;
        height:42px;
        border-radius:50%;
        background:linear-gradient(135deg,#3b82f6,#1d4ed8);
        color:#fff;
        font-weight:700;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:15px;
        flex-shrink:0;
    }

    .foro-user-info h5{
        margin:0;
        font-size:15px;
        font-weight:700;
        color:#1f2d3d;
    }

    .foro-user-info span{
        display:block;
        margin-top:2px;
        font-size:12px;
        color:#7b8a9a;
    }

    .foro-tag{
        background:#eef6ff;
        color:#2563eb;
        border:1px solid #dbeafe;
        font-size:12px;
        font-weight:600;
        padding:6px 10px;
        border-radius:30px;
        white-space:nowrap;
    }

    .foro-content{
        font-size:14px;
        line-height:1.7;
        color:#334155;
        background:#fbfcfe;
        border:1px solid #edf2f7;
        border-radius:12px;
        padding:14px;
    }

    .foro-respuestas{
        margin-top:14px;
        padding-left:24px;
        border-left:3px solid #e8eef5;
    }

    .foro-respuesta{
        background:#f9fbfd;
        border:1px solid #e7edf4;
        border-radius:14px;
        padding:14px;
        margin-top:12px;
    }

    .foro-respuesta:first-child{
        margin-top:0;
    }

    .foro-respuesta-top{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:10px;
    }

    .foro-respuesta-label{
        font-size:11px;
        font-weight:700;
        color:#0f766e;
        background:#ecfdf5;
        border:1px solid #d1fae5;
        border-radius:30px;
        padding:5px 10px;
        text-transform:uppercase;
        letter-spacing:.4px;
    }

    .foro-divider-title{
        font-size:16px;
        font-weight:700;
        color:#1f2d3d;
        margin:0 0 16px 0;
    }

    @media (max-width: 768px){
        .foro-lms-header{
            flex-direction:column;
        }

        .foro-lms-badges{
            justify-content:flex-start;
        }

        .foro-card-top,
        .foro-respuesta-top{
            flex-direction:column;
            align-items:flex-start;
        }
    }
</style>

<div class="foro-lms-wrap">
    <div class="foro-lms-header">
        <div>
            <h3 class="foro-lms-title">Participación del alumno en el foro</h3>
            <div class="foro-lms-subtitle">
                <strong>Alumno:</strong> <?php echo htmlspecialchars($NombreAlumno, ENT_QUOTES, 'UTF-8'); ?>
                <br>
                <strong>Actividad:</strong> <?php echo htmlspecialchars($NombreActividad, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>

        <div class="foro-lms-badges">
            <div class="foro-badge">
                <span class="label">Comentarios</span>
                <span class="value"><?php echo $totalComentarios; ?></span>
            </div>
            <div class="foro-badge">
                <span class="label">Respuestas</span>
                <span class="value"><?php echo $totalRespuestas; ?></span>
            </div>
            <div class="foro-badge">
                <span class="label">Total</span>
                <span class="value"><?php echo $totalParticipaciones; ?></span>
            </div>
        </div>
    </div>

    <div class="foro-lms-section">
        <h4 class="foro-divider-title">Detalle de la participación en el foro</h4>

        <?php if ($totalParticipaciones <= 0) { ?>
            <div class="foro-empty">
                <i class="fa fa-comments-o" style="font-size:36px; margin-bottom:10px; color:#b3c0ce;"></i>
                <div>No se encontraron comentarios ni respuestas para este alumno en la actividad seleccionada.</div>
            </div>
        <?php } else { ?>

            <?php foreach ($comentariosPadre as $comentario) { ?>
                <div class="foro-card">
                    <div class="foro-card-top">
                        <div class="foro-user">
                            <div class="foro-avatar">
                                <?php echo strtoupper(substr($NombreAlumno, 0, 1)); ?>
                            </div>
                            <div class="foro-user-info">
                                <h5><?php echo htmlspecialchars($NombreAlumno, ENT_QUOTES, 'UTF-8'); ?></h5>
                                <span><?php echo $comentario['FechaFormato']; ?></span>
                            </div>
                        </div>
                        <div class="foro-tag">Comentario principal</div>
                    </div>

                    <div class="foro-content">
                        <?php echo $comentario['ComentarioSeguro']; ?>
                    </div>

                    <?php if (!empty($comentario['respuestas'])) { ?>
                        <div class="foro-respuestas">
                            <?php foreach ($comentario['respuestas'] as $respuesta) { ?>
                                <div class="foro-respuesta">
                                    <div class="foro-respuesta-top">
                                        <div class="foro-user">
                                            <div class="foro-avatar" style="width:36px;height:36px;font-size:13px;">
                                                <?php echo strtoupper(substr($NombreAlumno, 0, 1)); ?>
                                            </div>
                                            <div class="foro-user-info">
                                                <h5 style="font-size:14px;"><?php echo htmlspecialchars($NombreAlumno, ENT_QUOTES, 'UTF-8'); ?></h5>
                                                <span><?php echo $respuesta['FechaFormato']; ?></span>
                                            </div>
                                        </div>
                                        <div class="foro-respuesta-label">Respuesta</div>
                                    </div>

                                    <div class="foro-content">
                                        <?php echo $respuesta['ComentarioSeguro']; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
</div>