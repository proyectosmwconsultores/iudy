<?php
$_v = 89;
$section = "Mi lección";
include("head.php");

if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario ha ingresado a la materia.');
}

$IdAsignacion = isset($_GET['idToks']) ? $_GET['idToks'] : '';
$porciones = explode("_", $_GET["id"]);
$IdParcial = isset($porciones[0]) ? $porciones[0] : '';
$IdSemana  = isset($porciones[1]) ? $porciones[1] : '';
$IdActividad  = isset($porciones[2]) ? $porciones[2] : '';

$semanas = $aula->get_contenido_parcial($IdAsignacion, $IdParcial);
$parciales = $aula->get_parcial_id($IdAsignacion);
$semanas = is_array($semanas) ? $semanas : [];

$totalParciales = count($parciales);

$primerSemana = reset($semanas);



?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <input type="hidden" id="_idSemana" value="<?php echo $IdSemana; ?>">
      <input type="hidden" id="_idActividad" value="<?php echo $IdActividad; ?>">

      <header class="topbar">
        <div class="topbar-inner">
          <div>
            <h1><i class="fa fa-book"></i> Información de la planeación </h1>
          </div>
        </div>
        <?php if ($totalParciales >= 2) { ?>
          <div class="partials-wrap">
            <div class="partials">
              <?php if ($totalParciales == 3) { ?>
                <button onClick="window.open('vistaContenido.php?idToks=<?php echo urlencode($IdAsignacion); ?>&id=<?php echo $parciales[0]['IdParcialDocente']; ?>','_self')" class="partial p1">
                  <span>Parcial 1</span>
                </button>
                <button onClick="window.open('vistaContenido.php?idToks=<?php echo urlencode($IdAsignacion); ?>&id=<?php echo $parciales[1]['IdParcialDocente']; ?>','_self')" class="partial p2">
                  <span>Parcial 2</span>
                </button>
                <button onClick="window.open('vistaContenido.php?idToks=<?php echo urlencode($IdAsignacion); ?>&id=<?php echo $parciales[2]['IdParcialDocente']; ?>','_self')" class="partial p3">
                  <span>Parcial 3</span>
                </button>
              <?php } ?>
              <?php if ($totalParciales == 2) { ?>
                <button onClick="window.open('vistaContenido.php?idToks=<?php echo urlencode($IdAsignacion); ?>&id=<?php echo $parciales[0]['IdParcialDocente']; ?>','_self')" class="partial p1">
                  <span>Parcial 1</span>
                </button>
                <button onClick="window.open('vistaContenido.php?idToks=<?php echo urlencode($IdAsignacion); ?>&id=<?php echo $parciales[1]['IdParcialDocente']; ?>','_self')" class="partial p3">
                  <span>Parcial 2</span>
                </button>
                </button>
              <?php } ?>
            </div>
          </div><?php } ?>
      </header>

      <main class="layout">
        <aside class="card sidebar">
          <div class="card-h">
            <h2 id="sidebarTitle" style="font-size: 15px;"><b><i class="fa fa-fw fa-flag-o"></i> Contenido del Parcial <?php echo $primerSemana['NoParcial']; ?></b></h2>
          </div>

          <div id="sidebarItems">
            <?php if (!empty($semanas)) { ?>
              <?php foreach ($semanas as $semana) { ?>
                <div class="item item-semana" data-idsemana="<?php echo $semana['IdSemanaDocente']; ?>" style="cursor:pointer;">
                  <div>
                    <i class="fa fa-fw fa-folder-o"></i>
                    <?php echo htmlspecialchars($semana['Etiqueta_semana']); ?>
                  </div>
                  <div class="tag">Contenido</div>
                </div>

                <?php if (!empty($semana['actividades'])) { ?>
                  <?php foreach ($semana['actividades'] as $actividad) { ?>
                    <div class="item item-actividad" data-idactividad="<?php echo $actividad['IdActividadesDocente']; ?>" style="cursor:pointer;">
                      <div>
                        <div>
                          <i class="fa fa-fw fa-check-circle-o"></i>
                          <?php echo htmlspecialchars($actividad['NomActividad']); ?>
                        </div>
                        <div class="tag activity" <?php if ($actividad['IdEstatus'] == 8) { echo "style='color: #9696ff;'"; } else { echo "style='color: #ff4f4f;'"; } ?>>
                          <i class="fa fa-fw fa-sign-in"></i> <?php echo htmlspecialchars($actividad['TipoActividad']); ?>
                        </div>
                      </div>
                      <span>›</span>
                    </div>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            <?php } else { ?>
              <div class="item empty">
                <div>
                  <i class="fa fa-fw fa-info-circle"></i>
                  No hay contenido disponible para este parcial.
                </div>
              </div>
            <?php } ?>
          </div>
        </aside>
        <section class="card main">
          <div id="detalleActividad">
            <div class="block">
              <h4>Seleccione el contenido o la actividad que quiere revisar</h4>
              <p>Da clic sobre el contenido y una actividad del panel izquierdo para ver su informaciòn.</p>
            </div>
          </div>
        </section>
      </main>

      <section class="content"></section>
    </div>
    <div id="dataModal8" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-tripadvisor"></i> Vista previa del trabajo</h4>
          </div>
          <div class="modal-body" id="employee_detail8">
          </div>
        </div>
      </div>
    </div>
    <div id="dataModal_rub" class="modal fade bs-example-modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Rúbrica de la actividad</h4>
          </div>
          <div class="modal-body" id="employee_detail_rub">
          </div>
        </div>
      </div>
    </div>
    <div id="dataModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-wechat"></i> Comentarios de la actividad</h4>
          </div>
          <div class="modal-body" id="employee_detail">
          </div>
        </div>
      </div>
    </div>
    <div id="dataBli" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_bib'></b></h4>
          </div>
          <div class="modal-body" id="employee_bli">
          </div>
        </div>
      </div>
    </div>


    <?php include("footer.php"); ?>
  </div>

  <script>

$(document).ready(function(){

    var IdSemana = $('#_idSemana').val();
    var IdActividad = $('#_idActividad').val();

    if(IdSemana){
        cargarSemana(IdSemana);
        $('.item-semana[data-idsemana="'+IdSemana+'"]').addClass('active');
    }
    if(IdActividad){
        cargarActividad(IdActividad);
        $('.item-actividad[data-idactividad="'+IdActividad+'"]').addClass('active');
    }

});

function cargarSemana(idSemana){

    $('#detalleActividad').html(
        '<div class="block"><p><i class="fa fa-spinner fa-spin"></i> Cargando contenido...</p></div>'
    );

    $.ajax({
        url:'ajax/get_semana.php',
        type:'POST',
        data:{
            idSemana:idSemana
        },
        success:function(respuesta){
            $('#detalleActividad').html(respuesta);
        },
        error:function(){
            $('#detalleActividad').html(
                '<div class="block"><p>Error al cargar el contenido.</p></div>'
            );
        }
    });

}


$(document).on('click','.item-semana',function(){
    var idSemana = $(this).data('idsemana');
    $('.item-semana').removeClass('active');
    $(this).addClass('active');
    cargarSemana(idSemana);

});

function cargarActividad(idActividad){
    $('#detalleActividad').html(
        '<div class="block"><p><i class="fa fa-spinner fa-spin"></i> Cargando actividad...</p></div>'
    );
    $.ajax({
        url: 'ajax/get_actividad_docente.php',
        type: 'POST',
        data: {
            idActividad: idActividad
        },
        success: function(respuesta){
            $('#detalleActividad').html(respuesta);
        },
        error: function(){
            $('#detalleActividad').html(
                '<div class="block"><p>Error al cargar la actividad.</p></div>'
            );
        }
    });

}

$(document).on('click', '.item-actividad', function(){
    var idActividad = $(this).data('idactividad');
    $('.item-actividad').removeClass('active');
    $(this).addClass('active');
    cargarActividad(idActividad);

});


    
    function mi_rubrica(IdActividadDoc) {
      var IdRubrica = 0;
      $.ajax({
        url: "vistas/docente/mi_rubrica_actividad.php",
        method: "POST",
        data: {
          IdActividadDoc: IdActividadDoc,
          IdRubrica: IdRubrica
        },
        success: function(data) {
          $('#employee_detail_rub').html(data);
          $('#dataModal_rub').modal('show');
        }
      });
    }



    function verBiblioteca(IdBiblioteca) {
      $.ajax({
        url: "formConsulta/verDocumento.php",
        method: "POST",
        data: {
          IdBiblioteca: IdBiblioteca
        },
        success: function(data) {
          $('#employee_bli').html(data);
          $('#dataBli').modal('show');
        }
      });
    }
  </script>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="dist/js/demo.js"></script>
</body>

</html>