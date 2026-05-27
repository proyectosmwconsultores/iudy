<footer class="main-footer">
  <!-- <div class="pull-right hidden-xs">
      <b>Version</b> <?php echo $configuracion[6]["Descripcion"]; ?>
    </div> -->
  <strong>Copyright &copy; 2023.</strong> Todos los derechos reservados.
  <div class="pull-right hidden-xs">
    <code onclick="servicio_ayuda()" style="cursor: pointer;"> <i class="fa fa-fw fa-info-circle"></i> Ayuda </code>
    <code onclick="aviso_privacidad()" style="cursor: pointer;"> <i class="fa fa-fw fa-bullhorn"></i> Aviso de privacidad </code>
    <code onclick="terminos_condiciones()" style="cursor: pointer;"> <i class="fa fa-fw fa-legal"></i> Términos y condiciones </code>
  </div>
</footer>
<div class="control-sidebar-bg"></div>
<div id="dataSer" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-info-circle"></i> Servicio de ayuda</h4>
      </div>
      <div class="modal-body" id="employee_Ser">
      </div>
    </div>
  </div>
</div>
<div id="dataAvi" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-bullhorn"></i> Aviso de privacidad</h4>
      </div>
      <div class="modal-body" id="employee_Avi">
      </div>
    </div>
  </div>
</div>
<div id="dataTer" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-fw fa-legal"></i> T&eacute;rminos y condiciones</h4>
      </div>
      <div class="modal-body" id="employee_Ter">
      </div>
    </div>
  </div>
</div>
<script>
  function servicio_ayuda() {
    $.ajax({
      url: "formConsulta/servicio_ayuda.php",
      method: "POST",
      data: {},
      success: function(data) {
        $('#employee_Ser').html(data);
        $('#dataSer').modal('show');
      }
    });
  }

  function aviso_privacidad() {
    $.ajax({
      url: "formConsulta/aviso_privacidad.php",
      method: "POST",
      data: {},
      success: function(data) {
        $('#employee_Avi').html(data);
        $('#dataAvi').modal('show');
      }
    });
  }

  function terminos_condiciones() {
    $.ajax({
      url: "formConsulta/terminos_condiciones.php",
      method: "POST",
      data: {},
      success: function(data) {
        $('#employee_Ter').html(data);
        $('#dataTer').modal('show');
      }
    });
  }
</script>