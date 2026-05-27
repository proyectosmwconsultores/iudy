<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $IdPlan = $_POST['employee_id'];

  $sql = $db->query("SELECT tblp_plantemas.IdTema, tblp_plantemas.Tema, tblp_plantemas.Cuatrimestre, tblc_abreviatura.Abreviatura FROM tblp_plantemas Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_plantemas.Cuatrimestre WHERE tblp_plantemas.IdPlan = '$IdPlan' ORDER BY tblp_plantemas.Cuatrimestre ASC");


  $sql2 = $db->query("SELECT
tblp_modulo.IdModulo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod
FROM
tblp_modulo WHERE tblp_modulo.IdEducativa = '1' AND tblp_modulo.Grado = '5'");



?>
<script>
function showAsignaturas(str) {
  // var IdCampus = document.getElementById("IdCampus").value;
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
        xmlhttp.open("GET","getuser.php?Tipo=Asignatura&Buscar="+str,true);
        xmlhttp.send();
    }
}

</script>
  <div class="box-info">
            <form class="form-horizontal" name="frmT5" id="frmT5" action="addPlanAsig.php" method="POST" enctype="multipart/form-data">
              <input id="IdPlan" name="IdPlan" value="<?php echo $IdPlan; ?>" type="hidden"/>
            <input id="TipoGuardar" name="TipoGuardar" value="addPlanAsig" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Tendencias y temas actuales:</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="txtTema" id="txtTema" style="cursor: pointer;">
                      <option value=""> - Seleccione - </option>
                      <?php while($x = $db->recorrer($sql)){ ?>
                      <option value="<?php echo $x["IdTema"]; ?>" ><?php echo $x["Cuatrimestre"].$x["Abreviatura"]; ?> Cuatrimestre - <?php echo $x["Tema"]; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-5 control-label">Etapas de la metodolog&iacute;a ABP:</label>
                  <div class="col-sm-7">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default">1</button>
                      <button type="button" class="btn btn-default">2</button>
                      <button type="button" class="btn btn-default">3</button>
                      <button type="button" class="btn btn-default">4</button>
                      <button type="button" class="btn btn-default">5</button>
                      <button type="button" class="btn btn-default">6</button>
                      <button type="button" class="btn btn-default">7</button>
                      <button type="button" class="btn btn-default">8</button>
                    </div>
                  </div>
                </div> -->
              </div>

            </form>
          </div>
          <div id="txtHint">La información de las asignaturas se mostrar&aacute; aqu&iacute;.</div>
<script>
$(document).ready(function(){
    $("#txtTema").change(function () {
      $("#txtTema option:selected").each(function () {
        idTema = $(this).val();

        showAsignaturas(idTema)
      });
    })
  });



</script>
          <?php
}
?>
