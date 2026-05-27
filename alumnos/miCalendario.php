<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];

  $sql = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$idAsignacion' ORDER BY tblp_actividadesdocente.FecIni ASC ");

  $sql_for = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdAsignacion =  '$idAsignacion' ORDER BY tblp_foro.FecCap DESC LIMIT 5 ");

  ?>
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">

    <div class="col-md-7">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Mi calendario de actividades</h3>
        </div>
        <div class="box-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Comentarios recientes en el foro</h3>
        </div>
        <div class="box-body">
        <div class="direct-chat-messages">
          <?php while($for = $db->recorrer($sql_for)){ ?>
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left"><?php echo $for['Nombre'].' '.$for['APaterno'].' '.$for['AMaterno']; ?></span>
              <span class="direct-chat-timestamp pull-right"><?php echo $for['FecCap']; ?></span>
            </div>
            <img class="direct-chat-img" src="assets/perfil/<?php echo $for['Foto']; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
            <div class="direct-chat-text" style="font-size:12px;">
              <?php echo $for['Mensaje']; ?>
            </div>
          </div><?php } ?>
        </div>
      </div>
      </div>
    </div>




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
          <?php while($x = $db->recorrer($sql)){ $tipo = $x["IdTipoActividad"]; $IdParcial = $x["IdParcialDocente"]; $IdAsig = $x["IdAsignacion"]; //$_SESSION["IdAsignacion"]; //  for ($i=0;$i< sizeof($tareas);$i++) {  //alMiParcial.php?tok=15722790231
  					if($tipo ==2){ $back = "#f56954"; $border = "#f56954"; $link = "".$IdAsig."&Id=".time().$x["IdActividadesDocente"]; }
  					if($tipo == 1){ $back = "#f39c12"; $border = "#f39c12"; $link = "./miLeccion.php?idAsignacion=".$IdAsig;  }
  					if($tipo == 3){ $back = "#0073b7"; $border = "#0073b7"; $link = "./alMiParcial.php?tok=1572279023".$IdParcial; }
  					if($tipo == 4){ $back = "#00c0ef"; $border = "#00c0ef"; $link = "./alMiParcial.php?tok=1572279023".$IdParcial;  }
            $_valor = $x["IdParcialDocente"].'_'.$x["IdSemanaDocente"].'_'.$x["IdActividadesDocente"];
            $link = "./miLeccion.php?idAsignacion=".$IdAsig."&idLeccion=".$_valor;

  					$anioIni = substr($x["FecIni"],0,4 );
  					$mesIni = substr($x["FecIni"],5,2 );
  					$diaIni = substr($x["FecIni"],8,2 );
  					$mesIni = ($mesIni - 1);

  					$anioFin = substr($x["FecFin"],0,4 );
  					$mesFin = substr($x["FecFin"],5,2 );
  					$diaFin = substr($x["FecFin"],8,2 );
  					// $diaFin = ($diaFin + 1);
  					$mesFin = ($mesFin - 1);

  					 ?>
          {
            title          : '<?php echo $x["NomActividad"]; ?>',
            start          : new Date(<?php echo $anioFin; ?>, <?php echo $mesFin; ?>, <?php echo $diaFin; ?>),
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
