<?php
include('../hace.php');
if(isset($_POST["IdUsua"])){
   $IdUsua = substr($_POST["IdUsua"],4,10);
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql_permisos = $db->query("SELECT tblp_coordinador.IdCoordinador, tblp_coordinador.IdCampus, tblc_campus.Campus, tblp_educativa.Nombre FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_coordinador.IdOferta WHERE tblp_coordinador.IdUsua =  '$IdUsua' ORDER BY tblp_coordinador.IdCampus ASC, tblp_educativa.IdGrado ASC ");

 ?>
  <div class="table-responsive">
    <form class="form-horizontal">
      <table class="table table-striped">
        <tbody>
          <?php $c_i = 0; $c_f = 0; while($y = $db->recorrer($sql_permisos)){ $c_i = $y["IdCampus"];
            if($c_i <> $c_f){  ?>
              <tr style="background: #003A70; color: white;">
                <td colspan="2"><i class="fa fa-bank"></i> <?php echo $y["Campus"]; ?></td>
              </tr>
            <?php } ?>
          <tr>
            <td style="text-align: center;">
              <i class="fa fa-check-circle"></i>
            </td>
            <td><?php echo $y["Nombre"]; ?></td>
          </tr>
        <?php  $c_f = $y["IdCampus"]; } ?>
      </tbody>
    </table>
    </form>
  </div>
<?php
}
?>
