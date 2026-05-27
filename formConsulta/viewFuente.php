<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $porciones = explode("-", $_POST["employee_id"]);
  $IdParcial =  $porciones[0]; // porción1
  $IdSemana =  $porciones[1]; // porción2

  $sql = $db->query("SELECT * FROM tblp_fuentedocente WHERE tblp_fuentedocente.IdParcialDocente = '$IdParcial' AND tblp_fuentedocente.IdSemanaDocente = '$IdSemana'");

?>
  <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Fuentes de consulta</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
            <?php
            while($x = $db->recorrer($sql)){
          echo  $x["Fuente"];
            echo "<br>";
            }
            ?>
        </div>
      </div>
    </table>
  </div>
  <?php
}
?>
