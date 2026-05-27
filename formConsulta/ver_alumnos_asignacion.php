<?php session_start();
  require('../php/clases/consulta_class.php');
  $t=new Consultas();

  $IdAsignacion = $_POST['employee_id'];
  $_user=$t->get_alumnos_materia($IdAsignacion);

?>

  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-file-text-o"></i> Lista de alumnos en la materia</h3>    
  </div>
<?php if($_SESSION['IdUsua'] == 1){ ?>
    <button onclick="actualizar_lista_alumnos('<?php echo $IdAsignacion; ?>')" type="button" class="btn bg-orange btn-flat btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-refresh"></i>Actualizar lista</button>
    <?php } ?>
  <div class="box-body no-padding">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS</th>
        </tr>
      <?php $vn = 0;
      for ($x=0;$x< sizeof($_user);$x++) {  ?>
      <tr>
        <td>
          <b><?php echo $vn = ($vn + 1); ?>.-</b>
        </td>
        <td> <?php echo $_user[$x]['APaterno'].' '.$_user[$x]['AMaterno'].' '.$_user[$x]['Nombre']; ?> </td>
        <td> <?php echo $_user[$x]['Estatus']; ?> </td>
      </tr><?php
     } ?>
   </tbody></table>
   <button onclick="javascript:window.open('repositorio/portafolio/lista_alumnos.php?tokenId=<?php echo $IdAsignacion; ?>');" href="javascript:void(0);" type="button" class="btn bg-olive btn-flat btn-xs"><i class="fa fa-fw fa-download"></i> Lista de alumnos</button>
  </div>

