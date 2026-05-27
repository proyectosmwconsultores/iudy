<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];

   // $insertar = $db->query("ALTER TABLE tblh_log ADD COLUMN email VARCHAR(1) NULL");
   // $insertar = $db->query("ALTER TABLE tblh_log DROP COLUMN email");


  ?>
  <input type="text" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <input type="text" name="IdAsignacion" id="IdAsignacion" value="<?php echo $_POST['IdAsignacion']; ?>">
  <div class="box-body">
    <div class="form-group">
      <label for="exampleInputEmail1">Seleccione el día que desea dar de alta:</label>
      <input type="text" class="form-control" id="datepicker1Xp" name="datepicker1Xp" placeholder="Clic para cargar el calendario">
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
    <button onclick="habilitarDia()" type="button" class="btn btn-primary">Guardar</button>
  </div>



<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
  function habilitarDia(){
    var Fecha = document.getElementById("datepicker1Xp").value;
    var IdAsignacion = document.getElementById("IdAsignacion").value;
    var IdUsua = document.getElementById("IdUsua").value;

    if (Fecha == ''){
		    swal("Error al guardar", "Debe seleccionar su fecha que desea agregar.", "error");
        document.getElementById("datepicker1Xp").focus();
        return 0;
    }

    var TipoGuardar = "add_asistencia";
        swal({
      		title: "\u00BFEst\u00E1 seguro que desea agregar este dia?",
      		type: "warning",
      		showCancelButton: true,
      		confirmButtonColor: '#DD6B55',
      		confirmButtonText: 'Aceptar',
      		cancelButtonText: "Cancelar",
      	},
      	function (isConfirm) {
      		if (isConfirm) {
      			$(".confirm").attr('disabled', 'disabled');

            $.ajax({
                 url:"docente/setting.php",
                 method:"POST",
                 data:{TipoGuardar:TipoGuardar, Fecha:Fecha, IdAsignacion:IdAsignacion, IdUsua:IdUsua},
                 success:function(data){
                   document.getElementById(IdUsua).style.display = 'none';
                 }
            })

      		}

      	});

  }
  $(function () {
    //Date picker
    $('#datepicker1Xp').datepicker({
    autoclose: true
    })
  })

</script>
