<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = substr($_POST["Token"], 10, 10);
  $IdCiclo = $_POST["IdCiclo"];

  $sqle9 = $db->query("SELECT
tblc_usuario.IdUsua,
tblp_grupo.TipoCiclo,
tblp_educativa.IdGrado
FROM
tblc_usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sqle9);
  $datose91 = $db->recorrer($sqle9);
  $IdGrado = $datose91['IdGrado'];
  $TipoCiclo = $datose91['TipoCiclo'];
$_cic = '';
if($TipoCiclo == 'C'){
  $_cic = 'CUATRIMESTRE';
} else { $_cic = 'SEMESTRE'; }

  $sql = $db->query("SELECT
tblp_calendario.IdCalendario,
tblp_calendario.IdConceptosPlanes,
tblp_calendario.FecDescuento,
tblp_calendario.Monto,
tblc_conceptosplanes.NomPlan
FROM
tblp_calendario
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes
WHERE
tblp_calendario.IdGrado =  '$IdGrado' AND
tblp_calendario.IdCiclo =  '$IdCiclo' AND
tblc_conceptosplanes.IdConcepto =  '7'
");

  $sql2 = $db->query("SELECT * FROM tblc_ciclo WHERE  tblc_ciclo.Tipo = '$_cic' AND tblc_ciclo.IdEstatus = '8' ORDER BY tblc_ciclo.FInicio DESC");

  ?>
  ok
  <form class="form-horizontal" name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="addNewPago" type="hidden"/>

    <div class="table-responsive">
    <table class="table table-bordered">

        <div class="col-md-12">
          <div class="form-group">
            <label>Periodo escolar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-bank"></i>
              </div>
              <select class="form-control" name="txtCiclo" id="txtCiclo" onchange="sel_ciclo_esx(<?php echo $IdUsua; ?>)">
                <option value=""> - Seleccione - </option>
                <?php
                while($x3 = $db->recorrer($sql2)){ ?>
                <option value="<?php echo $x3['IdCiclo'] ?>" <?php if($x3["IdCiclo"] == $IdCiclo){ ?>selected="selected"<?php } ?> > <?php echo $x3['Ciclo']; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>Seleccione tipo de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtPlan" id="txtPlan">
                <option value=""> - Seleccione - </option>
                <?php
                while($x2 = $db->recorrer($sql)){ ?>
                <option class="form-control"  value="<?php echo $x2['IdCalendario']; ?>" > <?php echo $x2['NomPlan']; ?> / $<b style="float: right; color: blue;"><?php echo number_format($x2['Monto'], 2, '.', ','); ?></b> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
              <button type="button" class="btn btn-block btn-info" onclick="addNewPagoD(<?php echo $IdUsua; ?>)"> Guardar cambios</button>
          </div>
        </div>

    </table>
  </div>

  </form>

<script>
  function sel_ciclo_esx(IdUsua){
    var IdCiclo = document.getElementById("txtCiclo").value;
    var Token = '0978546875'+IdUsua;

  	$.ajax({
  			 url:"formConsulta/addNewPago.php",
  			 method:"POST",
  			 data:{Token:Token, IdCiclo:IdCiclo},
  			 success:function(data){
  						$('#employee_NewPago').html(data);
  						$('#dataNewPago').modal('show');
  			 }
  	});
  }

  function addNewPagoD(IdUsua){
  	var Plan = document.getElementById("txtPlan").value;
  	var Ciclo = document.getElementById("txtCiclo").value;
    var TipoGuardar = "NewPago";

    if (Ciclo ==''){
        swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
    }
    if (Plan ==''){
          swal("Error al guardar", "Debe seleccionar el tipo de plan de pago.", "error");
          document.getElementById("txtPlan").focus();
          return 0;
      }


  	swal({
  		title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo pago?",
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: '#DD6B55',
  		confirmButtonText: 'Aceptar',

  	},
  	function (isConfirm) {
  		if (isConfirm) {
  			$(".confirm").attr('disabled', 'disabled');
  			var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&Plan=' + Plan + '&Ciclo=' + Ciclo;
  			$.ajax({
  				type:"POST",
  				url:"insertar.php",
  				data:datos,
  				success:function(data){

  				}
  			})
  			.done(function(data) {
  				if(data==1){
  					swal("Guardado correctamente", "Pago agregado correctamente.", "success");
  					//document.getElementById("frm").reset();
            parent.location.href='cobrar.php?token=7845896587'+IdUsua;
  				}
          if(data==0){
  					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
  				}
  			})
  			.error(function(data) {
  				swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});
  		}

  	});
  }

</script>
