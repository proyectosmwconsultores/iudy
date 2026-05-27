<?php $mnAl = 1; $section = "Mi asignatura"; include("head.php");

if($_SESSION['Permisos']) {
	if(!isset($_SESSION['IdAsignacion'])){
		$_SESSION['IdAsignacion'] = $_GET["Id"];
	}

	if(!isset($_SESSION['EstatusAsig'])){
		$_SESSION['EstatusAsig'] = $_GET["T"];
	}
	
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
$tareas = $t->get_tareasCalendar($_SESSION['IdAsignacion']);
$tareasId = $t->get_tareasCalendarS($_SESSION['IdAsignacion']);
$foro = $t->get_reciente($_SESSION['IdAsignacion']);
$_SESSION['IdAsignacion'];

$xmodulo = "En la materia -> ".$materia[0]['NombreMod'];
$addIngresos=$t->add_registros($_SESSION['IdUsua'],$xmodulo,'Mi asignatura','Mi asignatura -> Calendario de actividades',$_GET['idAsignacion'],$_SESSION['IdUsua'],0); 



?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
      <h1>
        Mi <?php if($AsignacionId[0]["Curso"] == 0){ ?>asignatura <?php } else { echo "curso"; } ?>: <?php echo $AsignacionId[0]["NombreMod"];?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $AsignacionId[0]["NombreMod"];?></a></li>
        <li class="active">Datos generales</li>
      </ol>
    </section>
		<section class="content">
		  <div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Calendario de actividades</h3>
						</div>
						<div class="box-body no-padding">
							<!-- THE CALENDAR -->
							<div id="calendar"></div>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /. box -->
				</div>
				<div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Actividades recientes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
									<?php  for ($i=0;$i< sizeof($tareasId);$i++) { $tipoA = $tareasId[$i]["IdTipoActividad"]; $IdParcial = $tareasId[$i]["IdParcialDocente"];

										 $backC = "bg-maroon disabled color-palette";
										if($i==0){ $backC = "bg-light-blue disabled color-palette"; }
										if($i==1){ $backC = "bg-aqua disabled color-palette"; }
										if($i==2){ $backC = "bg-green disabled color-palette"; }
										if($i==3){ $backC = "bg-yellow disabled color-palette"; }
										if($i==4){ $backC = "bg-red disabled color-palette"; }
										if($i==5){ $backC = "bg-gray disabled color-palette"; }
										if($i==6){ $backC = "bg-navy disabled color-palette"; }
										if($i==7){ $backC = "bg-teal disabled color-palette"; }
										if($i==8){ $backC = "bg-purple disabled color-palette"; }
										if($i==9){ $backC = "bg-orange disabled color-palette"; }
										?>
                  <div class="item <?php if($i == 0){ ?>active<?php } ?>" onClick="window.open('alMiParcial.php?tok=1572279023<?php echo $IdParcial; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">
										<div class="box-body <?php echo $backC; ?>">
				              <dl class="dl-horizontal">
				                <dt>Actividad:</dt>
				                <dd><?php echo $tareasId[$i]["NomActividad"]; ?></dd>
				                <dt>Fecha inicial:</dt>
				                <dd><?php echo obtenerFechaEnLetra($tareasId[$i]["FecIni"]); ?></dd>
				                <dt>Fecha final:</dt>
				                <dd><?php echo obtenerFechaEnLetra($tareasId[$i]["FecFin"]); ?></dd>
												<dt>Puntos:</dt>
				                <dd><?php echo $tareasId[$i]["Porcentaje"]; ?></dd>
				              </dl>
				            </div>
                  </div>
								<?php }  ?>



                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

				<div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Comentarios recientes en el foro</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
							<div class="direct-chat-messages">
                <!-- Message. Default to the left -->
								<?php  for ($i=0;$i< sizeof($foro);$i++) { ?>
                <div class="direct-chat-msg" onClick="window.open('viewForoId.php?idToks=<?php echo $_SESSION['IdAsignacion']; ?>&Id=<?php echo time().$foro[$i]["IdActividad"]; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left"><?php echo $foro[$i]["Nombre"].' '.$foro[$i]["APaterno"]; ?></span>
                    <span class="direct-chat-timestamp pull-right"><?php echo tiempo_transcurrido($foro[$i]["FecCap"]); ?></span><br>
										<span class="direct-chat-name pull-left"><?php echo $foro[$i]["TituloActividad"]; ?></span>
                  </div>

                  <img class="direct-chat-img" src="assets/perfil/<?php echo $foro[$i]["Foto"]; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    <?php echo $foro[$i]["Mensaje"]; ?>
                  </div>

                </div>
								<?php } ?>

              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


		  </div>
		</section>
	  </div>
	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week : 'Semana',
        day  : 'Dia'
      },
      //Random default events
      events    : [
        <?php  for ($i=0;$i< sizeof($tareas);$i++) { $tipo = $tareas[$i]["IdTipoActividad"]; $IdAsig = $_SESSION["IdAsignacion"]; $IdParcial = $tareas[$i]["IdParcialDocente"]; //alMiParcial.php?tok=15722790231
					if($tipo ==2){ $back = "#f56954"; $border = "#f56954"; $link = "./viewForoId.php?idToks=".$IdAsig."&Id=".time().$tareas[$i]["IdActividadesDocente"]; }
					if($tipo == 1){ $back = "#f39c12"; $border = "#f39c12"; $link = "./alMiParcial.php?tok=1572279023".$IdParcial;  }
					if($tipo == 3){ $back = "#0073b7"; $border = "#0073b7"; $link = "./alMiParcial.php?tok=1572279023".$IdParcial; }
					if($tipo == 4){ $back = "#00c0ef"; $border = "#00c0ef"; $link = "./alMiParcial.php?tok=1572279023".$IdParcial;  }


					$anioIni = substr($tareas[$i]["FecIni"],0,4 );
					$mesIni = substr($tareas[$i]["FecIni"],5,2 );
					$diaIni = substr($tareas[$i]["FecIni"],8,2 );
					$mesIni = ($mesIni - 1);

					$anioFin = substr($tareas[$i]["FecFin"],0,4 );
					$mesFin = substr($tareas[$i]["FecFin"],5,2 );
					$diaFin = substr($tareas[$i]["FecFin"],8,2 );
					$diaFin = ($diaFin + 1);
					$mesFin = ($mesFin - 1);

					 ?>
        {
          title          : '<?php echo $tareas[$i]["NomActividad"]; ?>',
          start          : new Date(<?php echo $anioIni; ?>, <?php echo $mesIni; ?>, <?php echo $diaIni; ?>),
          end            : new Date(<?php echo $anioFin; ?>, <?php echo $mesFin; ?>, <?php echo $diaFin; ?>),
          url            : '<?php echo $link; ?>',
          backgroundColor: '<?php echo $back; ?>', //Primary (light-blue)
          borderColor    : '<?php echo $border; ?>' //Primary (light-blue)
        },
				<?php } ?>

      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
</body>
</html>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);

 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
