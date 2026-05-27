<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label>Fecha de suspensión:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="txtFechax" id="txtFechax" >
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Motivo de la suspensión:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bank"></i>
                </div>
                <input type="text" class="form-control" name="txtMotivo" id="txtMotivo" >
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="sav_suspex(<?php echo $IdUsua; ?>)"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function () {
    $('#txtFechax').datepicker({
      autoclose: true
    })

  })
  function sav_suspex(IdUsua){
    var Anio = document.getElementById("txtAnio").value;
    var Fecha = document.getElementById("txtFechax").value;
    var Motivo = document.getElementById("txtMotivo").value;


    if (Fecha ==""){
        swal("Error al guardar", "Debe seleccionar la fecha.", "error");
        document.getElementById("txtFechax").focus();
        return 0;
    }
    if (Motivo ==""){
        swal("Error al guardar", "Debe escribir el motivo de la suspensión.", "error");
        document.getElementById("txtFechax").focus();
        return 0;
    }

    var TipoGuardar = "sav_mot_suspx";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este dia de suspensión?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, Fecha:Fecha, Motivo:Motivo, IdUsua:IdUsua},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "El día de suspensión se ha guardado correctamente.", "success");
            if(Anio){
              cargar_calendario();
            }
            $.ajax({
        				 url:"formConsulta/configurar_suspension.php",
        				 method:"POST",
        				 data:{},
        				 success:function(data){
        							$('#employee_detail_4').html(data);
        							$('#dataModal_4').modal('show');
        				 }
        		});
  				}
          if(data==2){
            swal("Error al guardar", "El día seleccionado ya esta dado de alta.", "error");

  				}
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }
</script>
