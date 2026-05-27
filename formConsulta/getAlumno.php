<?php
require('../php/clases/class.System.php');

$html = '';
$idGrupo = $_POST['id_grupo'];
$db = new Conexion();
$sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdGrupo = '$idGrupo'");

$contador = 1;
while($x = $db->recorrer($sql)){
//while ($Curso=mysql_fetch_array($res)) {
  $nombre = $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno'];
  if($contador == 1)
    $html='<option value="">- Seleccione Alumno -</option>';
    $html .= '<option value="'.$x['IdUsua'].'">'.$nombre.'</option>';
    $contador++;
  }
if($html == '') $html='<option value="">No hay Alumno en este grupo</option>';
echo $html;
?>
