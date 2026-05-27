<?php
session_start();
if(isset($_SESSION['IdUsua'])){
include('../hace.php');
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_GET["tokenId"];
  $IdUsua = substr($_GET["IdUsua"],10,10);

  $sqlV = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.IdGrado, tblp_educativa.Nombre AS Educativa, tblp_modulo.NombreMod, tblp_modulo.Objetivo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_grupo.CveGrupo, tblp_grupo.Modalidad, tblc_campus.Ubicacion, tblc_campus.Logo, tblc_campus.Campus FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
  $db->rows($sqlV);
  $datos91 = $db->recorrer($sqlV);

  $sqlU = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sqlU);
  $dat_us = $db->recorrer($sqlU);


  $sql_par = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdParcialDocente, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.Porcentaje, tblp_actividadesdocente.FecFin, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdAsignacion =  '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC, tblp_actividadesdocente.FecFin ASC");

  $IdGrado = $datos91['IdGrado'];
  if(($IdGrado == 3) || ($IdGrado == 4) || ($IdGrado == 6)){
		$xtT = 'Parcial';
	} else {
		$xtT = 'Módulo';
	}

  $sql_res = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql_res);
  $_res = $db->recorrer($sql_res);

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
    <img src="../repositorio/portafolio/encabezado.jpg" style="width: 100%;">

  	<div style="margin-left: 1px; margin-top: -75px; ">
  			<table>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center; font-size: 15px;"><b><?php echo $datos91['Campus']; ?></b></td>
  					<td rowspan='3' style="border: none; width: 140px; text-align: center;"><img src="../assets/images/campus/logo_inicio.png" style=" height: 70px;" ></td>
  				</tr>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center;"><b>COORDINACIÓN DE SERVICIOS ESCOLARES</b></td>
  				</tr>
  				<tr>
  					<td style="border: none; width: 590px; text-align: center;"><b>REPORTE DETALLADO DE ACTIVIDADES POR ALUMNO</b></td>
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
  					<td colspan='2' style="width: 300px; "><b><?php echo $datos91['Ubicacion']; ?>; <?php echo date("Y-m-d"); ?></b></td>
  				</tr>
          <tr>
  					<td style="width: 60px; border-right: none;"><b>ALUMNO:</b></td>
  					<td colspan='3' style="width: 400px; "><b><?php echo $dat_us['Usuario'].' - '.$dat_us['Nombre'].' '.$dat_us['APaterno'].' '.$dat_us['AMaterno']; ?></b></td>
  				</tr>
  		</table>
      <br>

      
<br>
      <table>
        <?php
        $ini = 0; $fin = 0; $sumCP = 0; while($par_ = $db->recorrer($sql_par)){
        $ini = $par_['IdParcialDocente'];
        $IdActividad = $par_['IdActividadesDocente'];

        $sql_act = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Link, tblp_tareas.Link2, tblp_tareas.Link3, tblp_tareas.Calificacion FROM tblp_tareas WHERE tblp_tareas.IdAlumno = '$IdUsua' AND tblp_tareas.IdActividadesDocente = '$IdActividad'");
        $db->rows($sql_act);
        $sql_count = $db->recorrer($sql_act);
        $IdTarea = $sql_count['IdTarea'];
        if($IdTarea){
          $Link1 = $sql_count['Link'];
          $Link2 = $sql_count['Link2'];
          $Link3 = $sql_count['Link3'];
          $Cal = $sql_count['Calificacion'];
          if(($Link1) || ($Link2) || ($Link3)){ $t_E = 'SI'; } else { $t_E = 'NO'; }
          if($Cal){ $t_C = 'SI'; } else { $t_C = 'NO'; }

        } else {
          $t_E = 'NO';
          $t_C = 'NO';
          $Cal = 0;
        }


        $sumCP = ($sumCP + $Cal);

        if($ini <> $fin){
          if($fin <> 0){
           ?>
          <tr>
            <td colspan="6" style="width: 400px; text-align: right; "><b>Calificación alcanzada en el <?php echo $xtT; ?>:</b></td>
            <td style="width: 80px; text-align: center;"><b> <?php echo $sumCP; ?></b></td>
          </tr><?php $sumCP = 0; } ?>
    			<tr style="background: #716d6d;">
            <td style="width: 80px;"><b> <?php echo $xtT.' '.$par_['NoParcial']; ?></b></td>
            <td colspan="6" style="width: 400px;"><b><?php echo $par_['Tema']; ?></b></td>
    			</tr>
          <tr>
            <th style="width: 80px; background: #a29d9d;">Tipo actividad</th>
            <th style="width: 300px; background: #a29d9d;">Nombre actividad</th>
            <th style="width: 100px; text-align: center; background: #a29d9d; text-decoration:">Fecha</th>
            <th style="width: 50px; text-align: center; background: #a29d9d;">Porcentaje</th>
            <th style="width: 50px; text-align: center; background: #a29d9d;">Tarea enviada</th>
            <th style="width: 50px; text-align: center; background: #a29d9d;">Calificada</th>
    				<th style="width: 50px; text-align: center; background: #a29d9d;">Calificación</th>
    			</tr>

          <?php } ?>
          <tr>
            <th style="width: 80px; text-align: left;"><?php echo $par_['TipoActividad']; ?></th>
            <th style="width: 300px; text-align: left;"><?php echo $par_['NomActividad']; ?></th>
            <th style="width: 100px; text-align: center;"><?php echo $par_['FecIni'].' / '.$par_['FecFin']; ?></th>
            <th style="width: 50px; text-align: center; <?php if($par_['Porcentaje'] == 0){ echo 'text-decoration:line-through;'; } ?>"><?php echo $par_['Porcentaje']; ?></th>
            <th style="width: 50px; text-align: center;"><?php echo $t_E; ?></th>
            <th style="width: 50px; text-align: center;"><?php echo $t_C; ?></th>
    				<th style="width: 50px; text-align: center;"><?php if($par_['Porcentaje'] == 0){ echo '---'; } else { echo $Cal; } ?></th>
    			</tr>

<?php $fin = $par_['IdParcialDocente']; } ?>
          <tr>
            <td colspan="6" style="width: 400px; text-align: right; "><b>Calificación alcanzada en el <?php echo $xtT; ?>:</b></td>
            <td style="width: 80px; text-align: center;"><b> <?php echo $sumCP; ?></b></td>
          </tr>





    	</table>
      <br>
      <table>
        <tr style="background: #716d6d;">
          <td><b><?php echo $xtT; ?></b></td>
          <td style="text-align: center;"><b>Calificación obtenida</b></td>
        </tr>
        <?php if($_res['ParcialF1']){ ?>
        <tr>
          <td><b><?php echo $xtT; ?> 1</b></td>
          <td style="text-align: center;"><?php echo $_res['ParcialF1']; ?></td>
        </tr>
        <?php } ?>
        <?php if($_res['ParcialF2']){ ?>
        <tr>
          <td><b><?php echo $xtT; ?> 2</b></td>
          <td style="text-align: center;"><?php echo $_res['ParcialF2']; ?></td>
        </tr>
        <?php } ?>
        <?php if($_res['ParcialF3']){ ?>
        <tr>
          <td><b><?php echo $xtT; ?> 3</b></td>
          <td style="text-align: center;"><?php echo $_res['ParcialF3']; ?></td>
        </tr>
        <?php } ?>
        <?php if($_res['ParcialF4']){ ?>
        <tr>
          <td><b><?php echo $xtT; ?> 4</b></td>
          <td style="text-align: center;"><?php echo $_res['ParcialF4']; ?></td>
        </tr>
        <?php } ?>
        <?php if($_res['Promedio']){ ?>
        <tr style="background: #d0c8c8;">
          <td><b>Promedio final:</b></td>
          <td style="text-align: center;"><b><?php echo $_res['Promedio']; ?></b></td>
        </tr>
        <?php } ?>
      </table>


      <br><br><p style="text-align: center; font-family: arial, sans-serif; font-size: 14px;">__________________________________<br><b>Nombre y Firma del Docente</b></p><br>
  		</div>
  	</div>


  </form>
<?php } else {
  echo "<script type='text/javascript'>window.location='../php/estructura/destroy.php';</script>";
} ?>
