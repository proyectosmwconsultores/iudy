<?php
session_start();
include('../hace.php');
if(isset($_SESSION['IdUsua'])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_GET["tokenId"];

$sqlV = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre AS Educativa, tblp_modulo.NombreMod, tblp_modulo.Objetivo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_grupo.CveGrupo, tblp_grupo.Modalidad, tblc_campus.Direccion, tblc_campus.Img_reporte, tblc_campus.Campus FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
$db->rows($sqlV);
$datos91 = $db->recorrer($sqlV);

$sql_p = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.Titulo, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblp_parcialdocente.Objetivo FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC");

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


  	<div style="margin-left: 1px; margin-top: 5px; ">
  			<table>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center; font-size: 15px;"><b><?php echo $datos91['Campus']; ?></b></td>
  					<td rowspan='3' style="border: none; width: 140px; text-align: center;"><img src="../assets/images/campus/<?php echo $datos91['Img_reporte']; ?>" style=" width: 100%;" ></td>
  				</tr>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center;"><b>COORDINACIÓN DE SERVICIOS ESCOLARES</b></td>
  				</tr>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center;"><b>PLANEACIÓN ACADÉMICA</b></td>
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
      <table>
    			<tr>
    				<td colspan='2' style="width: 650px; text-align: center;">
    					<b><?php echo $datos91['NombreMod']; ?></b>
    				</td>
    			</tr>
    			<tr>
    				<td colspan='2' style="width: 650px">
    					<p><?php echo $datos91['Objetivo']; ?></p>
    				</td>
    			</tr>
    			<?php while($par = $db->recorrer($sql_p)){ $IdParcial = $par['IdParcialDocente'];
            $sql_sem = $db->query("SELECT tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.Etiqueta_semana, tblp_semanadocente.NoSemana, tblp_semanadocente.Temas FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente =  '$IdParcial' ORDER BY tblp_semanadocente.NoSemana ASC ");

    				//$semana=$t->get_semanas($par['IdParcialDocente']);
    				?>
            <tr>
      				<td colspan='2' style="width: 650px; padding: 15px; text-align: center; background: #797272;">
      					<b><?php echo $par['Titulo']; ?></b>
      				</td>
      			</tr>
    			<tr>
    				<td rowspan='2' style="width: 142px; "><b><?php echo $par['Titulo']; ?></b></td>
    				<td style="width: 510px; "><b>Tema:</b> <?php echo $par['Tema']; ?></td>
    			</tr>
    			<tr>
    				<td style="width: 510px; "><b>Objetivo:</b> <?php echo $par['Objetivo']; ?></td>
    			</tr>
    			<?php while($sem = $db->recorrer($sql_sem)){ $IdSemana = $sem['IdSemanaDocente'];
            $sql_act = $db->query("SELECT
        tblp_actividadesdocente.IdActividadesDocente,
        tblp_actividadesdocente.NomActividad,
        tblp_actividadesdocente.DesActividad,
        tblp_actividadesdocente.Porcentaje,
        tblp_actividadesdocente.FecIni,
        tblp_actividadesdocente.FecFin,
        tblp_actividadesdocente.IdTipo,
        tblc_tipoactividad.TipoActividad
        FROM
        tblp_actividadesdocente
        Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
        WHERE
        tblp_actividadesdocente.IdParcialDocente =  '$IdParcial' AND
        tblp_actividadesdocente.IdSemanaDocente =  '$IdSemana'
         ");
    			//	$actividad=$t->get_actividades($par['IdParcialDocente'],$sem['IdSemanaDocente']);
    				?>
    			<tr>
    				<td style="width: 142px;"><b><?php echo $sem['Etiqueta_semana']; ?></b></td>
    				<td style="width: 510px"><?php echo $sem['Temas']; ?></td>
    			</tr>
    			<?php while($act = $db->recorrer($sql_act)){
    				?>
    			<tr>
    				<td style="width: 142px;"><b><?php echo $act['TipoActividad']; ?></b></td>
    				<td style="width: 510px"><?php echo $act['NomActividad']; ?></td>
    			</tr>
    			<tr>
    				<td colspan='2' style="width: 650px; text-align: justify;">
              <?php if($act['IdTipo'] == 1){ ?>
              <p><?php echo $act['DesActividad']; ?></p> <?php } ?>
              <b>Porcentaje:</b> <?php echo $act['Porcentaje']; ?> % <br>
    					<b>Fecha:</b> <?php echo $act['FecIni'].' al '.$act['FecFin']; ?><br>
    				</td>
    			</tr>
    			<?php  } ?>
    			<?php  } ?>
    			<?php  } ?>


    	</table>

<br><br><p style="text-align: center; font-family: arial, sans-serif; font-size: 14px;">__________________________________<br><b>Nombre y Firma del Docente</b></p><br>
  		</div>
  	</div>


  </form>
<?php } else {
  echo "<script type='text/javascript'>window.location='../php/estructura/destroy.php';</script>";
} ?>
