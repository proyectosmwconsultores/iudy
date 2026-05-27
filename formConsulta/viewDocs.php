<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $IdDoc = $_POST['employee_id'];
  $IdUsua = $_POST['IdUsua'];
  $valor = $_POST['valor'];
  $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.IdTipoDocumento,  tblc_docalumnos.Archivo, tblc_docalumnos.FecCap, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdTipoDocumento = '".$_POST["employee_id"]."' AND tblc_docalumnos.IdUsua ='$IdUsua'");
  $output .= '
  <form name="frmX" id="frmX" action="viewDocs.php" method="POST" enctype="multipart/form-data">
  <input id="employee_id" name="employee_id" value="'.$IdDoc.'" type="hidden"/>

  <div class="table-responsive">
  <table class="table table-bordered">
              <tbody><tr>
                <th style="width: 10px">#</th>
                <th>Fecha Captura</th>
                <th>Estatus</th>
                <th>Archivo</th>
                <th>Ajuste</th>
              </tr>
              '; $i = 0;
              while($x = $db->recorrer($sql)){ $i = $i + 1;
                $IdDocAlumno = $x["IdDocAlumno"];
                $FecCap = $x["FecCap"];
                $Estatus = $x["Estatus"];
                $Archivo = $x["Archivo"];
                $link = "assets/docs/Alumnos/".$Archivo;



                  $output .= '
              <tr>
                <td>'.$i.'</td>
                <td>'.$FecCap.'</td>
                <td>'.$Estatus.'</td>
                <td><a href="'.$link.'" target = "_blank"><button type="button" class="btn btn-success" ><i class="fa fa-eye"></i> Ver </button></a></td>
                <td>
                <button title="APROBADO" onClick="envioEstatus(this,'.$IdDocAlumno.',4)" type="button" class="btn btn-primary view_docs pull-left" name="view" value="view" id="'.$IdDoc.'" href="javascript:void(0);" style="float: right;"><i class="fa fa-check-circle"></i> </button>
                <button style="margin-left: 5px;" title="NO APROBADO" onClick="envioEstatus(this,'.$IdDocAlumno.',5)" type="button" class="btn btn-primary view_docs pull-left" name="view" value="view" id="'.$IdDoc.'" href="javascript:void(0);" style="float: right;"><i class="fa fa-times-circle"></i> </button>
                <button style="margin-left: 5px;" title="ELIMINAR" onClick="envioEstatus(this,'.$IdDocAlumno.',7)" type="button" class="btn btn-primary view_docs pull-left" view_docs pull-left" name="view" value="view" id="'.$IdDoc.'" href="javascript:void(0);"  style="float: right;"><i class="fa fa-trash"></i> </button>
                </td>
              </tr>
              ';
               }
                 $output .= '

            </tbody></table>


  </div>
  </form>';
  echo $output;
}
?>
<script>
function envioEstatus(valor1, IdDocAlumno,IdEstatus){
  var employee_id = document.getElementById("employee_id").value;
  var Tipo = "Estatus";
  $.ajax({
       url:"formConsulta/docsAjuste.php",
       method:"POST",
       data:{Tipo:Tipo, IdDocAlumno:IdDocAlumno,IdEstatus:IdEstatus},
       success:function(data){
             //alert(data);
            // document.getElementById("employee_id").value = employee_id;
       }
  });

}
</script>

<!-- jQuery 3 -->
