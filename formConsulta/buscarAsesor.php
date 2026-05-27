<?php
session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdU = $_SESSION["IdUsua"];
  $IdC = $_SESSION["IdCampus"];

  $sql = $db->query("SELECT tblp_modulo.IdCampus, tblc_campus.Campus, tblp_modulo.Oferta
FROM tblp_coordinador Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_coordinador.IdOferta Left Join tblc_campus ON tblc_campus.IdCampus = tblp_modulo.IdCampus
WHERE tblp_coordinador.IdUsua = '$IdU'
GROUP BY
tblp_modulo.IdCampus");

  ?>
  <script>



  function showUserBuscar(str) {
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
          xmlhttp.open("GET","getuser.php?Tipo=asesor&Buscar="+str+"&IdCampus="+IdCampus,true);
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
        <!-- <div class="form-group">
          <label for="inputEmail3" class="col-sm-4 control-label" style="text-align: right; margin-top: 7px;">Campus:</label>
          <div class="col-sm-6">
            <select class="form-control" name="txtCampus" id="txtCampus" onchange="savCampus(this)">
              <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql)){ ?>
                <option value="<?php echo $x["IdCampus"]; ?>" ><?php echo $x["Campus"]; ?></option>
                <?php } ?>
                </select>
          </div>
        </div> -->



        <div class="col-md-12">
          <div class="form-group">
            <label><br>La búqueda puede ser por nombre, apellidos:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input class="form-control" id="txtBuscar" autocomplete="off" name="txtBuscar" placeholder="Escriba los datos del asesor" type="text" onKeyUp="showUserBuscar(this.value)">
            </div>
            <div class="box-body no-padding">
              <div id="txtHint"><br><br><b style=" text-align: center !mportant;">El desglose de la b&uacute;squeda se mostrar&aacute; aqu&iacute;...</b></div>
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
  showUserBuscar(buscar);
  document.getElementById("txtBuscar").value = "";
}
</script>
