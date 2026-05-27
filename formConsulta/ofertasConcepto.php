<?php
include('../hace.php');
if(isset($_POST["employee_id"])){

  $IdConceptoPlan =  $_POST["employee_id"];
  $IdCampus =  $_POST["IdCampus"];

  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM  tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdConceptoPlan'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdGrado = $datos91["IdGrado"];
  $IdConcepto = $datos91["IdConcepto"];

  $sql = $db->query("SELECT
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_conceptosdetalle.IdConceptoPlan,
tblc_conceptosdetalle.IdOferta,
tblp_educativa.Nombre,
tblc_conceptosplanes.NomPlan
FROM
tblc_conceptosdetalle
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_conceptosdetalle.IdOferta
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan
WHERE tblc_conceptosdetalle.IdConceptoPlan = '$IdConceptoPlan'");

  $sql2 = $db->query("SELECT
tblp_educativa.IdEducativa,
tblp_educativa.Nombre
FROM
tblp_educativa
WHERE
tblp_educativa.IdGrado =  '$IdGrado'
GROUP BY
tblp_educativa.IdEducativa
");
?>


  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
    <label for="exampleInputEmail1">Planes de estudios activas en el plan de pago</label>
    <table class="table table-striped">
      <tbody>
        <tr>
          <th style="width: 20px">Ajuste</th>
          <th>Nombre</th>
        </tr>
      <?php while($x = $db->recorrer($sql)){ $IdOfertaX = $x["IdOferta"]; ?>
      <tr>
        <td><button onclick="delPlanPag(<?php echo $IdOfertaX; ?>,<?php echo $IdConceptoPlan; ?>,<?php echo $IdConcepto; ?>,<?php echo $IdCampus; ?>)" title="Quitar plan de estudio" type="button" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Activo</button></td>
        <td><?php echo $x["Nombre"]; ?></td>
      </tr><?php } ?>
    </tbody></table><br>
    <label for="exampleInputEmail1">Planes de estudios libres</label>
    <table class="table table-striped">
      <tbody>
        <tr>
          <th style="width: 20px">Ajuste</th>
          <th>Plan de estudios</th>
        </tr>
        <?php while($x2 = $db->recorrer($sql2)){
          $IdOferta = $x2["IdEducativa"];
           $sql7 = $db->query("SELECT * FROM tblc_conceptosdetalle WHERE tblc_conceptosdetalle.IdOferta = '$IdOferta' AND tblc_conceptosdetalle.IdConceptoPlan = '$IdConceptoPlan'");
           $db->rows($sql7);
           $datos71 = $db->recorrer($sql7);
           $Idx = $datos71["IdConceptoDetalle"];
          if(!$Idx){
           ?>
        <tr>
          <td>
            <button onclick="addPlanPag(<?php echo $IdOferta; ?>,<?php echo $IdConceptoPlan; ?>,<?php echo $IdConcepto; ?>,<?php echo $IdCampus; ?>)" title="Agregar al plan de concepto" type="button" class="btn btn-success btn-sm"><i class="fa fa-fw fa-check-circle"></i> Libre</button>
          </td>
          <td><?php echo $x2["Nombre"]; ?> </td>
        </tr>
      <?php }  } ?>
      </tbody></table>
  </form>
<?php } ?>
