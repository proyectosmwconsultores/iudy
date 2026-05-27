
<a onClick="window.open('miEspacio.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 1) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-coffee"></i> Mi Espacio <?php if($var == 1) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?> </li>
</a>
<a disabled="disabled" onClick="window.open('updateMiEspacio.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 2) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-black-tie"></i> Mi Informaci&oacute;n <?php if($var == 2) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>

<a onClick="window.open('misDocDocente.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 3) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-folder"></i> Mis Documentos <?php if($var == 3) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
