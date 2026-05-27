<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  
  

  $sql = $db->query("SELECT
tblp_examresultado.IdResultado,
tblp_examresultado.IdUsua,
tblp_examresultado.IdAsignacion,
tblp_examresultado.IdExamenUsuario,
tblp_examresultado.IdParcialDocente,
tblp_examresultado.IdActividadesDocente,
tblp_examresultado.IdPregunta,
tblp_examresultado.IdRespuesta,
tblp_examresultado.Valor,
tblp_examresultado.FecCap,
tblp_examresultado.Respuesta,
tblp_exampregunta.Pregunta
FROM
tblp_examresultado
Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta
WHERE
tblp_examresultado.IdAsignacion =  '".$_POST["IdAsignacion"]."' AND
tblp_examresultado.IdUsua =  '".$_POST["employee_id"]."' AND
tblp_examresultado.IdParcialDocente =  '".$_POST["IdParcial"]."' AND
tblp_examresultado.IdActividadesDocente =  '".$_POST["IdActividadDoc"]."'
");

  $sql8 = $db->query("SELECT Nombre, APaterno, AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '".$_POST["employee_id"]."'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
  $nombre = $datos81["Nombre"].' '.$datos81["APaterno"].' '.$datos81["AMaterno"];
?>
<form name="frm" class="form-horizontal" id="frm" action="viewRespuestaDoc.php" method="POST" enctype="multipart/form-data">
  <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $_POST["IdActividadDoc"]; ?>" type="hidden"/>
  <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $_POST["IdParcial"]; ?>" type="hidden"/>
  <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["employee_id"]; ?>" type="hidden"/>
  <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>

  <div class="modal-header" style="background: #212221; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">RESPUESTAS DE: <b style="color: white; font-weight: 200;"><?php echo $nombre; ?></b></h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <tbody>
        <?php
      while($x = $db->recorrer($sql)){
        $IdPr = $x["IdPregunta"];
        $IdRes = $x["IdRespuesta"];
        $IdResultado = $x["IdResultado"];

        $sql5 = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta = '$IdPr' AND tblp_examrespuesta.IdRespuesta = '$IdRes' ");
        $db->rows($sql5);
        $datos51 = $db->recorrer($sql5);


      ?>
        <tr style="background: #ccc4c4;">
          <th colspan="3"><?php echo $x["IdPregunta"]; ?>-<?php echo $x["Pregunta"]; ?></th>
        </tr>
        <tr>
          <td colspan="2">
<?php if($x["Valor"] == 1){ ?>
     <button type="button" style="margin-right: 10px;" class="btn btn-primary" href="javascript:void(0);" style="float: left;"><i class="fa fa-fw fa-check"></i></button>
 <?php } else { ?>
    <button type="button" style="margin-right: 10px;" class="btn btn-danger" href="javascript:void(0);" style="float: left;"><i class="fa fa-fw fa-times"></i></button>
   <?php } ?>
            <b>Respondio:</b><br> <?php if($x["Respuesta"]){ echo $x["Respuesta"]; } else { echo $datos51["Respuesta"]; } ?> </td>
          <td>
            <?php if($x["Respuesta"]){  ?>
              <button type="button" onclick="calBuena(<?php echo $IdResultado; ?>,1)" class="btn btn-success" href="javascript:void(0);" style="float: left;"><i class="fa fa-fw fa-check"></i></button>
              <button type="button" onclick="calBuena(<?php echo $IdResultado; ?>,0)" class="btn btn-danger" href="javascript:void(0);" style="float: left;"><i class="fa fa-fw fa-times"></i></button>




         <?php }  ?>


          </td>
        </tr>





        <!-- <tr '; if($respT == 1) { $output .= ' style = "background: gray;" ';  } $output .= ' >
          <td style=" width: 40px;">';
            if($respT == 1) { $output .= ' <i style="color: black;" class="fa fa-fw fa-thumbs-up"></i> '; } else{ $output .= ' <i style="color: red;" class="fa fa-fw fa-thumbs-down"></i> '; }
             $output .= ' </td>
          <td>'.$respAl.'</td>
        </tr> -->
<?php
    }
      ?>

      </tbody>
    </table>
    <button onclick="CalificarExame()" type="button" class="btn btn-block btn-primary btn-lg">CALIFICAR EXAMEN</button>
  </div>
</form>
  <?php
}
?>
<script type="text/javascript">
  function calBuena(IdResultado, Valor){
    var TipoGuardar = "savResulktado";

    var employee_id = document.getElementById("IdUsua").value;
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var IdParcial = document.getElementById("IdParcial").value;
    var IdActividadDoc = document.getElementById("IdActividadDoc").value;
    $.ajax({
          url:"formConsulta/setting.php",
          method:"POST",
          data:{TipoGuardar:TipoGuardar,IdResultado:IdResultado, Valor:Valor},
          success:function(data){

            if(data == 1){
              $.ajax({
                   url:"formConsulta/viewRespuestaDoc.php",
                   method:"POST",
                   data:{employee_id:employee_id,IdAsignacion:IdAsignacion,IdParcial:IdParcial,IdActividadDoc:IdActividadDoc},
                   success:function(data){
                        $('#employee_detail3').html(data);
                        $('#dataModal3').modal('show');
                   }
              });
            }
          }
     })
  }

  function CalificarExame(){
    var TipoGuardar = "calexasulktado";

    var employee_id = document.getElementById("IdUsua").value;
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var IdParcial = document.getElementById("IdParcial").value;
    var IdActividadDoc = document.getElementById("IdActividadDoc").value;
    $.ajax({
          url:"formConsulta/setting.php",
          method:"POST",
          data:{TipoGuardar:TipoGuardar,employee_id:employee_id, IdAsignacion:IdAsignacion,IdParcial:IdParcial,IdActividadDoc:IdActividadDoc},
          success:function(data){

          parent.location.href='doAddCalificarTarea.php?IdToken=8752342637'+IdActividadDoc+'&M=1&idToks='+IdAsignacion;
          }
     })
  }
</script>
