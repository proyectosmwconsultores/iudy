<?php $_v = 2;  $section = "Mi parcial"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'El usuario ha ingresado a la materia.'); }

$materia=$t->get_datosModuloD($_GET['idAsignacion']);
$porciones = explode("_", $_GET["tok"]);
$IdParcial =  $porciones[0];
$NoParcial =  $porciones[1];
$NoP_x =  $porciones[1];
$IdSemana = 0;
$NoSemana = 0;

$_sem =$t->get_semIni($IdParcial);
if(isset($_sem[0]['IdSemanaDocente'])){


$IdSemana = $_sem[0]['IdSemanaDocente'];
$NoSemana = $_sem[0]['NoSemana'];
}

?>
<link rel="stylesheet" type="text/css" href="assets/upload/style.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/upload/jquery.form.min.js"></script>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?php echo $materia[0]['NombreMod']; ?></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Mi materia</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="miParcial.php" method="POST" enctype="multipart/form-data">
        <input id="idAsignacion" name="idAsignacion" value="<?php echo $_GET["idAsignacion"]; ?>" type="hidden"/>
        <input id="Id_Menu" name="Id_Menu" value="10" type="hidden"/>
        <input id="IdMenu" name="IdMenu" value="10" type="hidden"/>
        <input id="IdParcial" name="IdParcial" value="<?php echo $IdParcial; ?>" type="hidden"/>
        <input id="NoParcial" name="NoParcial" value="<?php echo $NoParcial; ?>" type="hidden"/>
        <input id="IdSemana" name="IdSemana" value="<?php echo $IdSemana; ?>" type="hidden"/>
        <input id="NoSemana" name="NoSemana" value="<?php echo $NoSemana; ?>" type="hidden"/>
        <div class="row">
          <!-- <div class="col-md-3" id="panel_menu">

          </div> -->
          <div class="col-md-12">

            <div class="box box-primary" id="panel_10" style="display: block;"></div>
            <!-- <div class="box box-primary" id="panel_11" style="display: block;"></div> -->
            <div class="box box-primary" id="panel_12" style="display: none;"></div>
            <div class="box box-primary" id="panel_13" style="display: none;"></div>
            <div class="box box-primary" id="panel_14" style="display: none;"></div>
            <div class="box box-primary" id="panel_15" style="display: none;"></div>
            <div class="box box-primary" id="panel_16" style="display: none;"></div>

            <div class="box box-primary" id="panel_1" style="display: none;"></div>
            <div class="box box-primary" id="panel_2" style="display: none;"></div>
            <div class="box box-primary" id="panel_3" style="display: none;"></div>
            <div class="box box-primary" id="panel_4" style="display: none;"></div>
            <div class="box box-primary" id="panel_5" style="display: none;"></div>
            <div class="box box-primary" id="panel_6" style="display: none;"></div>

            <div class="box box-primary" id="panel_21" style="display: none;"></div>
            <div class="box box-primary" id="panel_22" style="display: none;"></div>
            <div class="box box-primary" id="panel_23" style="display: none;"></div>
            <div class="box box-primary" id="panel_24" style="display: none;"></div>
            <div class="box box-primary" id="panel_25" style="display: none;"></div>
            <div class="box box-primary" id="panel_26" style="display: none;"></div>

            <div class="box box-primary" id="panel_31" style="display: none;"></div>
            <div class="box box-primary" id="panel_32" style="display: none;"></div>
            <div class="box box-primary" id="panel_33" style="display: none;"></div>
            <div class="box box-primary" id="panel_34" style="display: none;"></div>
            <div class="box box-primary" id="panel_35" style="display: none;"></div>
            <div class="box box-primary" id="panel_36" style="display: none;"></div>

            <div class="box box-primary" id="panel_41" style="display: none;"></div>
            <div class="box box-primary" id="panel_42" style="display: none;"></div>
            <div class="box box-primary" id="panel_43" style="display: none;"></div>
            <div class="box box-primary" id="panel_44" style="display: none;"></div>
            <div class="box box-primary" id="panel_45" style="display: none;"></div>
            <div class="box box-primary" id="panel_46" style="display: none;"></div>
          </div>
        </div>
      </form>

    </section>
  </div>

  <div id="dataPre"  class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: #555299; color: white; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_Pre'></b></h4>
                 </div>
                 <div class="modal-body" id="employee_pre">
                 </div>
            </div>
       </div>
  </div>

  <div id="dataEva"  class="modal fade">
  		<div class="modal-dialog">
  				 <div class="modal-content">
  							<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
  									 <button type="button" class="close" data-dismiss="modal">&times;</button>
  									 <h4 class="modal-title"><i class="fa fa-fw fa-wechat"></i> Comentarios realizados</h4>
  							</div>
  							<div class="modal-body" id="employee_eva">
  							</div>
  				 </div>
  		</div>
  </div>

  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
$(document).ready(function(){
  var IdParcial = document.getElementById("IdParcial").value;
  var IdSemana = document.getElementById("IdSemana").value;
  var NoSemana = document.getElementById("NoSemana").value;
  // var NoParcial = 1;
  // miParcial(NoParcial,IdParcial);

   miUnidad(IdParcial,IdSemana, NoSemana);

});

  function informacion(){
    document.getElementById('12').className = 'treeview active';
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var Id_Menu = document.getElementById("Id_Menu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById('panel_12').style.display = 'block';

    document.getElementById(Id_Menu).className = 'treeview';

    var Capa = "#panel_12";
    $(Capa).load("alumnos/informacion.php",{idAsignacion:idAsignacion}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = 12;
    document.getElementById("Id_Menu").value = 12;
    miMenu(12);
  }

  function recursos(){
    document.getElementById('13').className = 'treeview active';
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var Id_Menu = document.getElementById("Id_Menu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById('panel_13').style.display = 'block';

    document.getElementById(Id_Menu).className = 'treeview';

    var Capa = "#panel_13";
    $(Capa).load("alumnos/miRecurso.php",{idAsignacion:idAsignacion}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = 13;
    document.getElementById("Id_Menu").value = 13;
    miMenu(13);
  }

  function migrupo(){
    document.getElementById('14').className = 'treeview active';
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var Id_Menu = document.getElementById("Id_Menu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById('panel_14').style.display = 'block';

    document.getElementById(Id_Menu).className = 'treeview';
    var Capa = "#panel_14";
    $(Capa).load("alumnos/miGrupo.php",{idAsignacion:idAsignacion}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = 14;
    document.getElementById("Id_Menu").value = 14;
    miMenu(14);
  }


  function mistareas(){
    document.getElementById('16').className = 'treeview active';
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var Id_Menu = document.getElementById("Id_Menu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById('panel_16').style.display = 'block';

    document.getElementById(Id_Menu).className = 'treeview';
    var Capa = "#panel_16";
    $(Capa).load("alumnos/misTareas.php",{idAsignacion:idAsignacion}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = 16;
    document.getElementById("Id_Menu").value = 16;
    miMenu(16);
  }

  function miUnidad(IdParcial,IdSemana, NoSemana){
    var PanelPar1 = "panel_2"+NoSemana;
    var PanelPar2 = "#panel_2"+NoSemana;
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;

    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById(PanelPar1).style.display = 'block';

    var Capa = PanelPar2;
    $(Capa).load("alumnos/miUnidad.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = '2'+NoSemana;
    //miMenu(NoParcial);
  }

  function miForo(IdParcial,IdSemana, NoSemana, IdActividad){
    var PanelPar1 = "panel_3"+NoSemana;
    var PanelPar2 = "#panel_3"+NoSemana;
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById(PanelPar1).style.display = 'block';

    var Capa = PanelPar2;
    $(Capa).load("alumnos/miForo.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = '3'+NoSemana;
    //miMenu(NoParcial);
  }

  function subirMiTarea(IdParcial,IdSemana, NoSemana, IdActividad){
    var PanelPar1 = "panel_3"+NoSemana;
    var PanelPar2 = "#panel_3"+NoSemana;
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById(PanelPar1).style.display = 'block';

    var Capa = PanelPar2;
    $(Capa).load("alumnos/subirMiTarea.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = '3'+NoSemana;
    //miMenu(NoParcial);
  }

  function TareamiForo(IdParcial,IdSemana, NoSemana, IdActividad){
    var PanelPar1 = "panel_3"+NoSemana;
    var PanelPar2 = "#panel_3"+NoSemana;
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById(PanelPar1).style.display = 'block';

    var Capa = PanelPar2;
    $(Capa).load("alumnos/miForo.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = '3'+NoSemana;
    //miMenu(NoParcial);
  }

  function subirTareaLts(IdParcial,IdSemana, NoSemana, IdActividad){
    var PanelPar1 = "panel_3"+NoSemana;
    var PanelPar2 = "#panel_3"+NoSemana;
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById(PanelPar1).style.display = 'block';

    var Capa = PanelPar2;
    $(Capa).load("alumnos/subirMiTarea.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = '3'+NoSemana;
    //miMenu(NoParcial);
  }

  function comenzarEva(IdParcial,IdSemana, NoSemana, IdActividad){
    swal({
      title: "\u00BFEst\u00E1 seguro que desea iniciar esta evaluaci\u00F3n? \n Recuerde que una vez iniciado comenzar\u00E1 a correr su tiempo?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if (isConfirm) {
        var PanelPar1 = "panel_4"+NoSemana;
        var PanelPar2 = "#panel_4"+NoSemana;
        var idAsignacion = document.getElementById("idAsignacion").value;
        var IdMenu = document.getElementById("IdMenu").value;
        var div = "panel_"+IdMenu;
        document.getElementById(div).style.display = 'none';
        document.getElementById(PanelPar1).style.display = 'block';

        var Capa = PanelPar2;
        $(Capa).load("alumnos/miExamen.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
          if (status == "error") { alert(status);
            var msg = "Error!, algo ha sucedido: ";
            $(Capa).html(msg + xhr.status + " " + xhr.statusText);
          }
        });
        document.getElementById("IdMenu").value = '4'+NoSemana;

        // parent.location.href='viewEvaYseC.php?Id=8643543276'+IdActividadDoc+'&IdP=9807506430'+IdParcial+'&IdT=7090980989'+IdTarea; //direcciona la pagina madre
      }
    });



  }

  function verPresentacion(IdSemana){
    $.ajax({
				 url:"formConsulta/verPresentacion.php",
				 method:"POST",
				 data:{IdSemana:IdSemana},
				 success:function(data){
							$('#employee_pre').html(data);
							$('#dataPre').modal('show');
				 }
		});
  }

  function newRespuesta(IdForo){
    $.ajax({
         url:"docente/respuestaForo.php",
         method:"POST",
         data:{IdForo:IdForo},
         success:function(data){
              $('#employee_eva').html(data);
              $('#dataEva').modal('show');
         }
    });
  }

</script>
</body>
</html>
