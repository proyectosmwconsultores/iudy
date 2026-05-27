
<a onClick="window.open('miEspacio.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 1) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-coffee"></i> Mi espacio <?php if($var == 1) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?> </li>
</a>
<a onclick="changePass()" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 2) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-lock"></i> Cambiar contraseña <?php if($var == 2) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-lock"></i></label> <?php } ?> </li>
</a>

<?php if($_SESSION["Permisos"] == 3){ ?>
<a onClick="window.open('misDatos.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 43) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-edit"></i> Mis datos <?php if($var == 43) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<a onClick="window.open('misDocumentos.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 3) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-folder"></i> Mis documentos <?php if($var == 3) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<a onClick="window.open('misTramites.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 21) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-folder"></i> Trámites escolares <?php if($var == 21) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<a onClick="window.open('constanciaEstudios.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 31) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-flag"></i> Constancias de estudios <?php if($var == 31) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<?php } ?>
<?php if($_SESSION["Permisos"] == 3){ ?>
<a onClick="window.open('misPagos.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 4) { ?> style="color: black;" <?php } ?>><i class="fa fa-fw fa-balance-scale"></i> Estatus financiero <?php if($var == 4) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<?php } ?>
<?php if($_SESSION["IdGrupo"]) { ?>
<a onClick="window.open('miKardex.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 5) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-qrcode"></i> K&aacute;rdex de calificaciones <?php if($var == 5) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<!-- <a onClick="window.open('misSolicitudes.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 15) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-clone"></i> Documentos solicitados<?php if($var == 15) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a> -->
<!-- <a onClick="window.open('misReconocimientos.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 153) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-trophy"></i> Mis reconocimientos<?php if($var == 153) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a> -->

<!--<a onClick="window.open('misSolicitudes.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 15) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-trophy"></i> Mis reconocimientos<?php if($var == 18) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
 <a onClick="window.open('updateMiEspacioA.php','_self')" href="javascript:void(0);">
  <li class="list-group-item"><i class="fa fa-fw fa-bank"></i> Referencia Bancaria</li>
</a> -->
<!-- <a onClick="window.open('misConceptos.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 7) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-qrcode"></i> Conceptos de pago <?php if($var == 7) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>

</a> -->
<?php if($_SESSION['_Grado'] == 3){ ?>
<a onClick="window.open('miPractica.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 67) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-odnoklassniki"></i> Práctica profesional <?php if($var == 67) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<a onClick="window.open('miServicio.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 88) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-odnoklassniki"></i> Servicio social <?php if($var == 88) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a><?php } ?>
<!-- <a onClick="window.open('misServicios.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 8) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-odnoklassniki"></i> Servicio social <?php if($var == 8) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a> -->

<?php } ?>
<?php if($_SESSION["Permisos"] == 2){ ?>
<a onClick="window.open('misDocDocente.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 3) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-folder"></i> Mis documentos <?php if($var == 3) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<a onClick="window.open('mi_reconocimiento.php','_self')" href="javascript:void(0);">
  <li class="list-group-item" <?php if($var == 4) { ?> style="color: black;" <?php } ?> ><i class="fa fa-fw fa-trophy"></i> Mis reconocimientos <?php if($var == 4) { ?> <label class="pull-right"><i style="color: blue;" class="fa fa-fw fa-circle"></i></label> <?php } ?></li>
</a>
<?php } ?>


<div id="dataModalExam" class="modal fade"> <!--MODAL ME GUSTA-->
     <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title"><i class="fa fa-fw fa-unlock-alt"></i> Cambiar mi contraseña</h4>
            </div>
               <div class="modal-body" id="employee_detailExam">
               </div>
          </div>
     </div>
</div>

<script>


function changePass(){
  $.ajax({
       url:"formConsulta/changePass.php",
       method:"POST",
       data:{},
       success:function(data){
            $('#employee_detailExam').html(data);
            $('#dataModalExam').modal('show');
       }
  });

}

</script>
