<?php
session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdU = $_SESSION["IdUsua"];
  $IdC = $_SESSION["IdCampus"];

  ?>
  <script>



  function show_UserBuscar(str) {
    var IdCampus = document.getElementById("IdCampus").value;
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
          xmlhttp.open("GET","getuser.php?Tipo=alumnoBuscar&Buscar="+str+"&IdCampus="+IdCampus,true);
          xmlhttp.send();
      }
  }

  </script>
  <form name="frm2" id="frm2" action="buscarUsuario.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
<input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION["IdCampus"]; ?>" type="hidden"/>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">

        <div class="col-md-12">
          <div class="form-group">
            <label><br>La búqueda puede ser por nombre, apellidos, matrícula:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input class="form-control" id="txtBuscar" name="txtBuscar" placeholder="Escriba los datos del alumno" type="text" onKeyUp="show_UserBuscar(this.value)">
            </div>
            <div class="box-body no-padding">
              <div id="txtHint"><br><br><b style=" text-align: center;">El desglose de la b&uacute;squeda se mostrar&aacute; aqu&iacute;...</b></div>
            </div>
          </div>
        </div>

      </div>
    </table>
  </div>

  </form>
<script>
function savCampus(IdCampus){
  var IdC = IdCampus.value;
  document.getElementById("IdCampus").value = IdC;
  var buscar = "";
  show_UserBuscar(buscar);
  document.getElementById("txtBuscar").value = "";
}
</script>
