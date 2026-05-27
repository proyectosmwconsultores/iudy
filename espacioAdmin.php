<aside class="kx-card kx-sidebar" aria-label="Menú del alumno">
  <div class="kx-user">
    <div class="kx-avatar">
      <img src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Foto de perfil">
    </div>
    <div class="kx-name"><?php echo $datosUser[0]["NombreUser"]; ?></div>
    <div class="kx-lastname"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></div>
  </div>
  <ul class="kx-menu">
    <li><a class="is-<?php if($var == 1){ echo "active"; } ?>" href="espacioAdministrativo.php" ><span class="ico">🏠</span> Mi espacio</a></li>
    <li><a style="cursor: pointer;" onclick="change_pass_id()"><span class="ico">🔒</span> Cambiar contraseña</a></li>
    <li><a class="is-<?php if($var == 3){ echo "active"; } ?>" href="actualizar_admin.php"><span class="ico">👤</span> Mis datos</a></li>
  </ul>

</aside>



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
  function change_pass_id(){
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