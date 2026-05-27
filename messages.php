<?php $mnB = 85; $section = "Mensajes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el modulo de libros UDS'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datOfe = $t->get_lstOfertauds();


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script>

function searchUser(str) {
  var IdCampus = document.getElementById("IdCampus").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdPermiso = document.getElementById("IdPermiso").value;
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?Tipo=buscUsers&Buscar="+str+"&IdCampus="+IdCampus+"&IdUsua="+IdUsua+"&IdPermiso="+IdPermiso,true);
        xmlhttp.send();
    }
}
</script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Espacio para envio de mensajes</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Mensajes</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="messages.php" method="POST" enctype="multipart/form-data">
        <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
        <input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION["Permisos"]; ?>" type="hidden"/>
        <input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION["IdCampus"]; ?>" type="hidden"/>
        <div class="row">
        <div class="col-md-4">

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Mensajes recientes</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="form-group">
                  <label for="exampleInputEmail1">Buscar a quien desea mandar mensaje:</label>
                  <div class="has-feedback">
                    <input onKeyUp="searchUser(this.value)" type="text" name="txtNombre" id="txtNombre" class="form-control input-sm" placeholder="Buscar ... ">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                  </div>
                  <div style="width: 100%; position: absolute; background: #c6c6c6; font-size: 12px;" id="txtHint"><b style=" text-align: center !mportant;"></b></div>
                </div>

                <ul class="products-list product-list-in-box" id="panel-leer"></ul>
                <ul class="products-list product-list-in-box" id="panel-recientes"></ul>
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-body" id="panel-modulos">
              <div style="padding: 50px; text-align: center; color: black; font-size: 18px;" class="bg-green-active color-palette"><span>Espacio en donde se mostrará las conversaciones.</span></div>

              <img src="assets/images/conversacion.png" style="width: 100%">
            </div>

          </div>
        </div>
      </div>
    </form>
    </section>
  </div>
  <div id="dataModalR"  class="modal fade">
         <div class="modal-dialog">
              <div class="modal-content">
                   <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Subir archivo adjunto</h4>
                   </div>
                   <div class="modal-body" id="employee_detailR">
                   </div>
              </div>
         </div>
    </div>

  <?php include("footer.php"); ?>
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
$(document).ready(function(){
  var IdUsua = document.getElementById("IdUsua").value;
  listaReciente(IdUsua);
  listaLeer(IdUsua);
});


function generarConsulta(IdUsuaRecibe){
    var Nombre = document.getElementById("txtNombre").value = '';
    searchUser(Nombre);
		var IdUsuaEnvia = document.getElementById("IdUsua").value;

		var Capa = "#panel-modulos";
		$(Capa).load("formConsulta/misMensajes.php",{IdUsuaEnvia:IdUsuaEnvia,IdUsuaRecibe:IdUsuaRecibe}, function(response, status, xhr) {
			if (status == "error") { alert(status);
				var msg = "Error!, algo ha sucedido: ";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}

  function cargarComen(IdUsuaEnvia,IdUsuaRecibe){
  		var Capa = "#panel-modulos";
  		$(Capa).load("formConsulta/misMensajes.php",{IdUsuaEnvia:IdUsuaEnvia,IdUsuaRecibe:IdUsuaRecibe}, function(response, status, xhr) {
  			if (status == "error") { alert(status);
  				var msg = "Error!, algo ha sucedido: ";
  				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
  			}
  		});
  	}

    function listaReciente(IdUsua){
    		var Capa = "#panel-recientes";
    		$(Capa).load("formConsulta/misRecientes.php",{IdUsua:IdUsua}, function(response, status, xhr) {
    			if (status == "error") { alert(status);
    				var msg = "Error!, algo ha sucedido: ";
    				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
    			}
    		});
    	}

      function listaLeer(IdUsua){
      		var Capa = "#panel-leer";
      		$(Capa).load("formConsulta/misLeer.php",{IdUsua:IdUsua}, function(response, status, xhr) {
      			if (status == "error") { alert(status);
      				var msg = "Error!, algo ha sucedido: ";
      				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
      			}
      		});
      	}

      function addRecurso(){
        var IdUsuaEnvia = document.getElementById("IdUsuaEnvia").value;
        var IdUsuaRecibe = document.getElementById("IdUsuaRecibe").value;

        $.ajax({
             url:"formConsulta/addAdjunto.php",
             method:"POST",
             data:{IdUsuaEnvia:IdUsuaEnvia,IdUsuaRecibe:IdUsuaRecibe},
             success:function(data){
                  $('#employee_detailR').html(data);
                  $('#dataModalR').modal('show');
             }
        });

      }

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
