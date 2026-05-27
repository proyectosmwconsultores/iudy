<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql = $db->query("SELECT * FROM tblp_examen WHERE tblp_examen.IdAsignacion = '".$_POST["Id"]."' AND tblp_examen.NoActividad = '".$_POST["employee_id"]."'");


  //  while($row=mysql_fetch_array($res1)) { '.$row["NoPregunta"].'
  $output .= '
  <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Mis respuestas del examen</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <tbody>';
      while($x = $db->recorrer($sql)){
        $sql5 = $db->query("SELECT tblp_resultadoexamen.NoPregunta, tblp_resultadoexamen.IdExamen, tblp_resultadoexamen.IdRespuesta AS Respondio, tblp_respuestaexamen.IdRespuesta, tblp_respuestaexamen.Respuesta, tblp_respuestaexamen.Valor FROM tblp_resultadoexamen Left Join tblp_respuestaexamen ON tblp_respuestaexamen.IdExamen = tblp_resultadoexamen.IdExamen WHERE tblp_resultadoexamen.IdExamen =  '".$x["IdExamen"]."' AND tblp_resultadoexamen.IdUsua =  '".$_POST["IdUsua"]."' AND tblp_resultadoexamen.IdAsignacion =  '".$_POST["Id"]."' AND tblp_resultadoexamen.NoActividad =  '".$_POST["employee_id"]."' AND tblp_respuestaexamen.Valor =  '1' AND tblp_resultadoexamen.IdUsua =  '".$_POST["IdUsua"]."'");
        $db->rows($sql5);
        $datos51 = $db->recorrer($sql5);
        $respondio = $datos51["Respondio"];
        $idrespuesta = $datos51["IdRespuesta"];
        $respAl = $datos51["Respuesta"];
        if($respondio == $idrespuesta){ $respT = 1; } else { $respT = 0; }

      // $sql2="SELECT tblp_resultadoexamen.NoPregunta, tblp_resultadoexamen.IdExamen, tblp_resultadoexamen.IdRespuesta AS Respondio, tblp_respuestaexamen.IdRespuesta, tblp_respuestaexamen.Respuesta, tblp_respuestaexamen.Valor FROM tblp_resultadoexamen Left Join tblp_respuestaexamen ON tblp_respuestaexamen.IdExamen = tblp_resultadoexamen.IdExamen
      // WHERE tblp_resultadoexamen.IdExamen =  '".$row["IdExamen"]."' AND tblp_resultadoexamen.IdUsua =  '".$_POST["IdUsua"]."' AND tblp_resultadoexamen.IdAsignacion =  '".$_POST["Id"]."' AND tblp_resultadoexamen.NoActividad =  '".$_POST["employee_id"]."'";
        //$res2=mysql_query($sql2,Conectar::con());
      $output .= '
        <tr>
          <th colspan="3">'.$x["NoPregunta"].'.- '.$x["Pregunta"].'</th>
        </tr>';
      //  while($x2 = $db->recorrer($valorRes)){ $n = $x + 1;
        //while($row2=mysql_fetch_array($res2)) {  $n = $x + 1;



        $output .= '
        <tr '; if($respT == 1) { $output .= ' style = "background: gray;" ';  } $output .= ' >
          <td style=" width: 40px;">';
            if($respT == 1) { $output .= ' <i style="color: black;" class="fa fa-fw fa-thumbs-up"></i> '; } else{ $output .= ' <i style="color: red;" class="fa fa-fw fa-thumbs-down"></i> '; }
             $output .= ' </td>
          <td>'.$respAl.'</td>
        </tr>';
      // //while($row=mysql_fetch_array($res1)) {
      // $sql2 = $db->query("SELECT tblp_resultadoexamen.NoPregunta, tblp_resultadoexamen.IdExamen, tblp_resultadoexamen.IdRespuesta AS Respondio, tblp_respuestaexamen.IdRespuesta, tblp_respuestaexamen.Respuesta, tblp_respuestaexamen.Valor FROM tblp_resultadoexamen Left Join tblp_respuestaexamen ON tblp_respuestaexamen.IdExamen = tblp_resultadoexamen.IdExamen
      // WHERE tblp_resultadoexamen.IdExamen =  '".$x["IdExamen"]."' AND tblp_resultadoexamen.IdUsua =  '".$_POST["IdUsua"]."' AND tblp_resultadoexamen.IdAsignacion =  '".$_POST["Id"]."' AND tblp_resultadoexamen.NoActividad =  '".$_POST["employee_id"]."'");
      //
      //
      //
      // $output .= '
      //   <tr>
      //     <th colspan="3">'.$x["NoPregunta"].'.- '.$x["Pregunta"].'</th>
      //   </tr>';
      //   while($x2 = $db->recorrer($sql2)){ $n = $x + 1;
      //   //while($row2=mysql_fetch_array($res2)) {  $n = $x + 1;
      //   $output .= '
      //   <tr>
      //     <td style=" width: 40px;">';
      //     if($x2["Respondio"] == $x2["IdRespuesta"] ){ if($x2["Valor"] == 1) {
      //     $output .= ' <i style="color: black;" class="fa fa-fw fa-thumbs-up"></i> ';
      //   } elseif($x2["Valor"] == 0) {
      //       $output .= ' <i style="color: black;" class="fa fa-fw fa-thumbs-down"></i> ';
      //        } }
      //        $output .= ' </td>
      //     <td style=" width: 40px;"> '.$n.' </td>
      //     <td>'.$x2["Respuesta"].'</td>
      //   </tr>';
      //
      // }
    }
      $output .= '
      </tbody>
    </table>
  </div>';
  echo $output;
}
?>
