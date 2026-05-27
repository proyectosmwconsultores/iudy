<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];
  $IdCampus = $_POST['IdCampus'];
  $IdGrado = $_POST['IdGrado'];
  $IdPlan = $_POST['IdPlan'];
  $IdCiclo = $_POST['IdCiclo'];

  $sql_campus = $db->query("SELECT tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus");

  $sql1 = $db->query("SELECT tblc_conceptosplanes.IdConceptoPlanes, tblc_conceptosplanes.Code,tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo FROM tblc_conceptosplanes Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosplanes.IdConcepto WHERE tblc_conceptosplanes.IdCampus = '$IdCampus' AND tblc_conceptosplanes.IdGrado = '$IdGrado' ");
  $sql2 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdEstatus = '8'");

  $sql_lista = $db->query("SELECT
tblp_calendario.IdCalendario,
tblp_calendario.IdConceptosPlanes,
tblp_calendario.FecDescuento,
tblc_conceptosplanes.NomPlan,
tblc_conceptosplanes.Costo
FROM
tblp_calendario
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes
WHERE tblp_calendario.IdGrado = '$IdGrado' AND tblp_calendario.IdConceptosPlanes = '$IdPlan' AND tblp_calendario.IdCiclo = '$IdCiclo'");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>

    <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -5px;">
        <div class="col-md-12">
          <div class="form-group">
            <label>Campus / escuela:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txt_campus" id="txt_campus" onchange="cambioCampus()" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while($_campus = $db->recorrer($sql_campus)){ ?>
                <option value="<?php echo $_campus["IdCampus"]; ?>" <?php if($IdCampus==$_campus["IdCampus"]){ ?>selected="selected"<?php } ?>> <?php echo $_campus["Campus"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Grado de estudio:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txt_Grado" id="txt_Grado" onchange="cambioGrado()" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <option value="1" <?php if($IdGrado==1){ ?>selected="selected"<?php } ?> > Doctorado</option>
                <option value="2" <?php if($IdGrado==2){ ?>selected="selected"<?php } ?> > Maestría</option>
                <option value="3" <?php if($IdGrado==3){ ?>selected="selected"<?php } ?> > Licenciatura</option>
                <option value="4" <?php if($IdGrado==4){ ?>selected="selected"<?php } ?> > Bachillerato / Prepa</option>
                <option value="5" <?php if($IdGrado==5){ ?>selected="selected"<?php } ?> > Secundaria</option>
                <option value="6" <?php if($IdGrado==6){ ?>selected="selected"<?php } ?> > Primaria</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Plan de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txt_Concepto" id="txt_Concepto" onchange="cambioPlan()" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while($y1 = $db->recorrer($sql1)){ ?>
                <option value="<?php echo $y1["IdConceptoPlanes"]; ?>" <?php if($IdPlan==$y1["IdConceptoPlanes"]){ ?>selected="selected"<?php } ?>> <?php echo $y1["NomPlan"]; ?> / $ <?php echo $y1["Costo"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Ciclo escolar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="txt_Ciclo" id="txt_Ciclo" onchange="cambioCiclo()" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while($y2 = $db->recorrer($sql2)){ ?>
                <option value="<?php echo $y2["IdCiclo"]; ?>" <?php if($IdCiclo==$y2["IdCiclo"]){ ?>selected="selected"<?php } ?>> <?php echo $y2["Ciclo"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Numero de pagos:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-flag-checkered"></i>
              </div>
              <select class="form-control" name="txt_pago" id="txt_pago">
                <option value="1"> 1 </option>
                <option value="2"> 2 </option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
                <option value="5"> 5 </option>
                <option value="6"> 6 </option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <button type="button" class="btn btn-block btn-success" onclick="pubPago()"> <i class="fa fa-fw fa-check-circle"></i> Generar pago</button>
          </div>
        </div>

      </div>
    </table>

    <table class="table table-striped">
                <tbody>
                  <tr>
                  <th style="width: 10px">#</th>
                  <th>Nombre del plan</th>
                  <th>Fecha</th>
                  <th>Costo</th>
                </tr>
                <?php $v = 0; while($_lista = $db->recorrer($sql_lista)){ ?>
                <tr>
                  <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
                  <td><?php echo $_lista['NomPlan']; ?></td>
                  <td><?php echo $_lista['FecDescuento']; ?></td>
                  <td>$ <?php echo $_lista['Costo']; ?></td>
                </tr><?php } ?>

              </tbody></table>
  </div>

  </form>
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
$(function () {

  $('.select2').select2()

})




function cambioGrado(){
  var IdCampus = document.getElementById("txt_campus").value;
  var IdGrado = document.getElementById("txt_Grado").value;
  var IdPlan = document.getElementById("txt_Concepto").value;
  var IdCiclo = document.getElementById("txt_Ciclo").value;
  $.ajax({
       url:"formConsulta/crearPago.php",
       method:"POST",
       data:{IdCampus:IdCampus, IdGrado:IdGrado, IdPlan:IdPlan, IdCiclo:IdCiclo},
       success:function(data){
            $('#employee_Grpx').html(data);
            $('#dataGrpx').modal('show');
       }
  });
}

function cambioCampus(){
  var IdCampus = document.getElementById("txt_campus").value;
  var IdGrado = document.getElementById("txt_Grado").value;
  var IdPlan = document.getElementById("txt_Concepto").value;
  var IdCiclo = document.getElementById("txt_Ciclo").value;
  $.ajax({
       url:"formConsulta/crearPago.php",
       method:"POST",
       data:{IdCampus:IdCampus, IdGrado:IdGrado, IdPlan:IdPlan, IdCiclo:IdCiclo},
       success:function(data){
            $('#employee_Grpx').html(data);
            $('#dataGrpx').modal('show');
       }
  });
}

function cambioPlan(){
  var IdCampus = document.getElementById("txt_campus").value;
  var IdGrado = document.getElementById("txt_Grado").value;
  var IdPlan = document.getElementById("txt_Concepto").value;
  var IdCiclo = document.getElementById("txt_Ciclo").value;
  $.ajax({
       url:"formConsulta/crearPago.php",
       method:"POST",
       data:{IdCampus:IdCampus, IdGrado:IdGrado, IdPlan:IdPlan, IdCiclo:IdCiclo},
       success:function(data){
            $('#employee_Grpx').html(data);
            $('#dataGrpx').modal('show');
       }
  });
}

function cambioCiclo(){
  var IdCampus = document.getElementById("txt_campus").value;
  var IdGrado = document.getElementById("txt_Grado").value;
  var IdPlan = document.getElementById("txt_Concepto").value;
  var IdCiclo = document.getElementById("txt_Ciclo").value;
  $.ajax({
       url:"formConsulta/crearPago.php",
       method:"POST",
       data:{IdCampus:IdCampus, IdGrado:IdGrado, IdPlan:IdPlan, IdCiclo:IdCiclo},
       success:function(data){
            $('#employee_Grpx').html(data);
            $('#dataGrpx').modal('show');
       }
  });
}




function pubPago(){
  var IdCampus = document.getElementById("txt_campus").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdGrado = document.getElementById("txt_Grado").value;
  var IdConcepto = document.getElementById("txt_Concepto").value;
  var IdCiclo = document.getElementById("txt_Ciclo").value;
  var Fecha = document.getElementById("datepicker1").value;
  var NoPagos = document.getElementById("txt_pago").value;

  if (IdGrado ==""){
      swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
      return 0;
  }
  if (IdConcepto ==""){
      swal("Error al guardar", "Debe seleccionar el concepto de pago.", "error");
      return 0;
  }
  if (IdCiclo ==""){
      swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
      return 0;
  }
  if (Fecha ==""){
      swal("Error al guardar", "Debe seleccionar la fecha de pago.", "error");
      return 0;
  }
  if (NoPagos ==""){
      swal("Error al guardar", "Debe seleccionar el número de pagos a realizar.", "error");
      return 0;
  }

  var TipoGuardar = "gePagoNew";
  swal({
    title: "\u00BFEst\u00E1 seguro que desea generar este pago?",
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
           data:{TipoGuardar:TipoGuardar, IdGrado:IdGrado, IdConcepto:IdConcepto, IdCiclo:IdCiclo, Fecha:Fecha, IdUsua:IdUsua, NoPagos:NoPagos, IdCampus:IdCampus},
           success:function(data){

           }
      })
      .done(function(data) {
        if(data==1){
          swal({
        		title: "El concepto de pago se ha generado correctamente.",
        		type: "success",
        		confirmButtonColor: '#DD6B55',
        		confirmButtonText: 'Aceptar',
        	},
        	function (isConfirm) {
        		if (isConfirm) {
        			$(".confirm").attr('disabled', 'disabled');
              parent.location.href='adGenerarPagos.php';
        		}
        	});
				}

				if(data==0){
					swal("Error al agregar", "No se puede agregar el pago.", "error");
				}
			})
      .error(function(data) {
				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
			});

    }
  });

}

$(function () {
  //Date picker
  $('#datepicker1').datepicker({
    autoclose: true
  })
})
</script>
