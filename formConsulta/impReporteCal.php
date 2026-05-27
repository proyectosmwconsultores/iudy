<?php
session_start();
if(isset($_SESSION['IdUsua'])){
include('../hace.php');
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_GET["tokenId"];

$sqlV = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre AS Educativa, tblp_modulo.NombreMod, tblp_modulo.Objetivo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_grupo.CveGrupo, tblp_grupo.Modalidad, tblc_campus.Direccion, tblc_campus.Img_reporte, tblc_campus.Campus FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
$db->rows($sqlV);
$datos91 = $db->recorrer($sqlV);





$sql_par = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.Titulo, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC");



?>

   <style>
   table {
       font-family: arial, sans-serif;
       border-collapse: collapse;
       width: 100%;
   		font-size: 12px;
   }

   td, th {
       border: 1px solid #9f9595;
       padding: 3px;
   }
   tr:nth-child(even) {
       /* background-color: #dddddd; */
   }


   </style>
   <title>Imprimir planeación académica</title>
  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">


  	<div style="margin-left: 1px; margin-top: 15px; ">
  			<table>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center; font-size: 15px;"><b><?php echo $datos91['Campus']; ?></b></td>
  					<td rowspan='3' style="border: none; width: 140px; text-align: center;"><img src="../assets/images/campus/<?php echo $datos91['Img_reporte']; ?>" style=" width: 100%;" ></td>
  				</tr>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center;"><b>COORDINACIÓN DE SERVICIOS ESCOLARES</b></td>
  				</tr>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center;"><b>REPORTE DETALLADO DE ACTIVIDADES CALIFICADAS</b></td>
  				</tr>
  		</table>
  		<br>
  		<div style='width: 100%;'>
  		<table>
  				<tr>
  					<td style="width: 60px; border-right: none; border-bottom: none; "><b>GRUPO:</b></td>
  					<td style="width: 250px; border-right: none; border-bottom: none; "><?php echo $datos91['CveGrupo']; ?></td>
  					<td style="width: 60px; border-right: none; border-bottom: none; "><b>MODALIDAD:</b></td>
  					<td style="width: 250px; border-bottom: none; "><?php echo $datos91['Modalidad']; ?></td>
  				</tr>
  				<tr>
  					<td style="width: 60px; border-right: none; border-bottom: none;"><b>OFERTA:</b></td>
  					<td style="width: 250px; border-right: none; border-bottom: none;"><?php echo $datos91['Educativa']; ?></td>
  					<td style="width: 60px; border-right: none; border-bottom: none;"><b>MATERIA:</b></td>
  					<td style="width: 250px; border-bottom: none; "><?php echo $datos91['NombreMod']; ?></td>
  				</tr>
  				<tr>
  					<td style="width: 60px; border-right: none;"><b>DOCENTE:</b></td>
  					<td style="width: 250px; border-right: none;"><?php echo $datos91['Nombre'].' '.$datos91['APaterno'].' '.$datos91['AMaterno']; ?></td>
  					<td colspan='2' style="width: 300px; "><b><?php echo $datos91['Direccion']; ?>; <?php echo date("Y-m-d"); ?></b></td>
  				</tr>
  		</table>
      <br>

      <?php while($par_ = $db->recorrer($sql_par)){
        $IdParcial = $par_['IdParcialDocente'];

        $sql_act = $db->query("SELECT Count(tblp_actividadesdocente.IdActividadesDocente) AS Total FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion =  '$IdAsignacion' AND tblp_actividadesdocente.IdParcialDocente = '$IdParcial'");
        $db->rows($sql_act);
        $sql_count = $db->recorrer($sql_act);
        $numR = $sql_count['Total'];
        if($numR == 0){ $numR = 1;}

        $sql_lst1 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.NomActividad, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdParcialDocente = '$IdParcial' ORDER BY tblp_actividadesdocente.IdActividadesDocente ASC");

        $sql_use = $db->query("SELECT tblp_moduloalumno.IdModAlumno, tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion'");



         ?>
<br>
      <table>
    			<tr style="background: #716d6d;">
            <td style="width: 80px;"><b> <?php echo $par_['Titulo']; ?></b></td>
            <td colspan="<?php echo $numR + 2; ?>" style="width: 400px;"><b><?php echo $par_['Tema']; ?></b></td>
    			</tr>
          <tr>
            <th rowspan="2" style="width: 80px; background: #a29d9d;">No.Control</th>
            <th rowspan="2" style="width: 300px; background: #a29d9d;">Alumno</th>
            <th colspan="<?php echo $numR; ?>" style="width: 400px; text-align: center; background: #a29d9d;">Actividades creadas</th>
    				<th rowspan="2" style="width: 40px; text-align: center; background: #a29d9d;">Calificación</th>
    			</tr>
          <tr>
            <?php while($lst_ = $db->recorrer($sql_lst1)){ ?>
            <td style="width: 50px; background: #a29d9d;"><b><?php echo $lst_['TipoActividad']; ?></b><br><?php echo $lst_['NomActividad']; ?> </td>
          <?php } ?>
    			</tr>
          <?php while($use_ = $db->recorrer($sql_use)){
            $sql_lst2 = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdParcialDocente = '$IdParcial' ORDER BY tblp_actividadesdocente.IdActividadesDocente ASC");
            ?>
          <tr>
            <td><?php echo $use_['Usuario']; ?></td>
            <td><?php echo $use_['Nombre'].' '.$use_['APaterno'].' '.$use_['AMaterno']; ?></td>
            <?php $sumP = 0; while($ls_s = $db->recorrer($sql_lst2)){
              $IdU = $use_['IdUsua'];
              $IdA = $ls_s['IdActividadesDocente'];

              $sql_pro = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Calificacion FROM tblp_tareas WHERE tblp_tareas.IdActividadesDocente =  '$IdA' AND tblp_tareas.IdAlumno =  '$IdU' ");
              $db->rows($sql_pro);
              $sql_pro = $db->recorrer($sql_pro);

               ?>
            <td style="width: 50px; text-align: center;"><?php echo $sql_pro['Calificacion']; ?> </td>
            <?php $sumP = ($sumP + $sql_pro['Calificacion']); } ?>
            <td style="width: 40px; text-align: center;"><?php echo $sumP; ?></td>
          </tr>
          <?php } ?>



    	</table>
      <?php } ?>

      <br><br><p style="text-align: center; font-family: arial, sans-serif; font-size: 14px;">__________________________________<br><b>Nombre y Firma del Docente</b></p><br>
  		</div>
  	</div>


  </form>
<?php } else {
  echo "<script type='text/javascript'>window.location='../php/estructura/destroy.php';</script>";
} ?>
