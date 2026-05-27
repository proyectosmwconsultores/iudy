<?php
session_start();
include('../hace.php');
if(isset($_POST["IdActividadDoc"])){

  $IdAsig = $_POST["IdAsignacion"];

  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql = $db->query("SELECT * FROM tblp_exampregunta WHERE tblp_exampregunta.IdActividadesDocente = '".$_POST["IdActividadDoc"]."' AND tblp_exampregunta.IdAsignacion = '$IdAsig'");

  ?>
  <table class="table table-hover" style="font-size: 12px;">
                <tbody><tr style="background: gray;">
                  <th>#</th>
                  <th colspan="6">Pregunta</th>
                </tr>
                <?php $r=0; while($x = $db->recorrer($sql)){ ?>
                <tr style="background: #bdbdbd;">
                  <td style="width: 10px;"><b><?php echo $r = $r + 1; ?>.- </b></td>
                  <td colspan="6">
                      <?php echo $x["IdPregunta"]; ?>-<?php echo $x["Pregunta"]; ?> <br><b style='color: blue;'>(<?php if($x["Tipo"] == "O") { echo "Opcion multple"; } else { echo "Pregunta abierta";} ?>)</b>
                      <?php if($x["Tipo"] == "O") { if(isset($x["Imagen"])){ ?>  
                      <br>
                      <p style='text-align: right;'>
                          
                          <img src="assets/docs/files/<?php echo $x["Anio"]; ?>/<?php echo $x["Mes"]; ?>/<?php echo $x["Imagen"]; ?>" style="width: 400px;" >
                          
                      </p>  <?php } } ?>
                      </td>
                </tr>
                <?php $IdPregunt = $x["IdPregunta"];
                $sql2 = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta ='$IdPregunt' ");
                ?>
                  <tr>
                    <td>R:</td>

                    <?php while($xy = $db->recorrer($sql2)){ ?><td <?php if($xy["Valor"] == 1) { echo "style='background: #f4d9d9;'"; } else { echo ""; } ?>><?php echo $xy["Respuesta"]; ?> </td> <?php } ?>


              <?php } ?>

              </tbody></table>

  <?php
}
?>
