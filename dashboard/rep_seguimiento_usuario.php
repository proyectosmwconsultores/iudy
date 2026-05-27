<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST['IdUsua'];
$IdAlumno = $_POST['IdAlumno'];

$sql_seg = $db->query("SELECT
tblp_seguimiento.IdSeguimiento,
tblp_seguimiento.FecCap,
tblp_seguimiento.Comentario_control,
tblp_seguimiento.Comentario_usuario,
tblc_ciclo.Ciclo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblc_tipo_seguimiento.Seguimiento
FROM
tblp_seguimiento
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_seguimiento.IdCiclo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_seguimiento.IdUsua_admin
Left Join tblc_tipo_seguimiento ON tblc_tipo_seguimiento.IdTipoSeguimiento = tblp_seguimiento.IdTipoSeguimiento
WHERE tblp_seguimiento.IdUsua = '$IdAlumno' ORDER BY tblp_seguimiento.FecCap DESC");

?>
<button onclick="abrir_chat(<?php echo $IdUsua; ?>,<?php echo $IdAlumno; ?>)" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fw fa-wechat"></i> Crear un seguimiento</button>
    <button onclick="window.open('repositorio/portafolio/seguimiento.php?tokenId=<?php echo time() . $IdAlumno; ?>','_blank')" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-print"></i> Imprimir seguimiento</button>
<?php $c = 0; 
while ($_seg = $db->recorrer($sql_seg)) {  $c = ($c + 1);
  ?>
  <div class="box box-widget">
    <div class="box-header with-border">
      <div class="user-block">
        <img class="img-circle" src="assets/perfil/<?php echo $_seg['Foto']; ?>" alt="User Image">
        <span class="username"><a href="#"><?php echo $_seg['Nombre'] . ' ' . $_seg['APaterno'] . ' ' . $_seg['AMaterno']; ?></a></span>
        <span class="description">Publicado el - <?php echo $_seg['FecCap']; ?> <span class="pull-right text-muted"><?php echo $_seg['Ciclo']; ?> - (<?php echo $_seg['Seguimiento']; ?>)</span></span>
      </div>
    </div>
    <div class="box-body">
      <?php if ($_seg['Comentario_control']) { ?> <p><?php echo $_seg['Comentario_control']; ?></p> <?php } ?>
      <?php if ($_seg['Comentario_usuario']) { ?> <p><b>Respuesta del alumno:</b> <?php echo $_seg['Comentario_usuario']; ?></p> <?php } ?>
    </div>
  </div>
<?php } 
if($c == 0) { ?>
<p style="text-align: center;">
  <img src="assets/images/campus/no_data.gif" style="width: 50%;">
</p>
<?php } ?>