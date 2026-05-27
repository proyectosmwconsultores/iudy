<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=lista_prospectos.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");

include('../hace.php');
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdToks = $_GET["idToks"];


  $sqlX = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS NomEducativa,
tblc_usuario.FecAlta,
tblc_usuario.Telefono,
tblc_usuario.Correo,
tblc_usuario.Celular,
tblc_usuario.FecCap,
tblc_usuario.NoDoc
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.IdEstatus =  '12' AND tblc_usuario.IdOferta = '$IdToks'

 ");

?>
  <meta charset="utf-8">

  <table class="table table-striped" style="font-size: 14px;">
         <tbody>
           <tr>
             <th></th>
             <th>Nombre del aspirante</th>
             <th>Oferta educativa</th>
             <th>Correo</th>
             <th>Teléfono</th>
             <th>FecCap</th>
           </tr>

         <?php $_spt = 0;
         while($x2 = $db->recorrer($sqlX)){
           ?>
         <tr>
           <td><b><?php echo $_spt = ($_spt + 1); ?>.- </b></td>
           <td><?php echo $x2["Nombre"].' '.$x2["APaterno"].' '.$x2["AMaterno"]; ?></td>
           <td><?php echo $x2["NomEducativa"]; ?></td>
           <td><?php echo $x2["Correo"]; ?></td>
           <td><?php echo $x2["Telefono"].' / '.$x2["Celular"]; ?></td>
           <td><?php echo $x2["FecCap"]; ?></td>
         </tr>
         <?php  } ?>
       </tbody>
</table>
