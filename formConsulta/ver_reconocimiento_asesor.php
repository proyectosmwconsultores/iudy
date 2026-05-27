<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdReconocimiento = $_POST["IdReconocimiento"];
  $sql9 = $db->query("SELECT tblp_reconocimiento.Texto, tblp_reconocimiento.IdReconocimiento, tblp_reconocimiento.Fecha, tblp_reconocimiento.Formato, tblp_reconocimiento.Anio, tblp_reconocimiento.Mes, tblp_reconocimiento.Archivo, tblp_reconocimiento.IdUsuaCap, tblc_tipo_reconocomiento.Reconocimiento FROM tblp_reconocimiento Left Join tblc_tipo_reconocomiento ON tblc_tipo_reconocomiento.IdTipoReconocimiento = tblp_reconocimiento.IdTipo WHERE tblp_reconocimiento.IdReconocimiento = '$IdReconocimiento' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  ?>
  <div class="box-body">
    <input type="hidden" name="nomxx_" id="nomxx_" value="<?php if($datos91["Texto"]){ echo $datos91["Texto"]; } else { echo $datos91["Reconocimiento"]; } ?>">
  <div class="box box-solid">
    <div class="btn-group" style="text-align: center;">
      <button type="button" onClick="window.open('assets/docs/files/<?php echo $datos91['Anio']; ?>/<?php echo $datos91['Mes']; ?>/<?php echo $datos91['Archivo']; ?>','_blank')" href="javascript:void(0);" title="Descargar documento del docente" class="btn btn-info"> <i class="fa fa-fw fa-cloud-download"></i> Descargar reconocimiento </button>
      <?php if($datos91['IdUsuaCap'] == $IdUsua){ ?>
      <button style="margin-left: 10px;" type="button" onclick="del_reconox(<?php echo $datos91['IdReconocimiento']; ?>)" href="javascript:void(0);" title="Eliminar reconocimiento" class="btn btn-danger"><i class="fa fa-fw fa-trash"></i> Eliminar reconocimiento</button>
      <?php } ?>
    </div><hr>
    <?php if($datos91["Formato"] == 'pdf'){ ?>
    <iframe src="assets/docs/files/<?php echo $datos91['Anio']; ?>/<?php echo $datos91['Mes']; ?>/<?php echo $datos91['Archivo']; ?>" width="100%" height="400px">
    <?php } else { ?>
      <img style="text-align: center; width: 100%;" src="assets/docs/files/<?php echo $datos91['Anio']; ?>/<?php echo $datos91['Mes']; ?>/<?php echo $datos91['Archivo']; ?>">
    <?php } ?>
  </div>
</div>
<script>
$(document).ready(function(){
  var nom_ = document.getElementById("nomxx_").value;

  document.getElementById('_prex').innerHTML = nom_;

});

function del_reconox(IdReconocimiento){
  var texto = "rec_"+IdReconocimiento;
    var TipoGuardar = "del_reconoxy";
        swal({
      		title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este reconocimiento?",
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
                 url:"formConsulta/setting.php",
                 method:"POST",
                 data:{TipoGuardar:TipoGuardar, IdReconocimiento:IdReconocimiento},
                 success:function(data){
                   document.getElementById(texto).style.display = 'none';
                   $('#dataEncRec').modal('hide');
                 }
            })

      		}

      	});
}
</script>
