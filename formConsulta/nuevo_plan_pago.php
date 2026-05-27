<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdCampus = $_POST["IdCampus"];


  $sql_campus = $db->query("SELECT tblp_coordinador.IdCoordinador, tblp_coordinador.IdCampus, tblc_campus.Campus FROM tblp_coordinador Left Join tblc_campus ON tblc_campus.IdCampus = tblp_coordinador.IdCampus WHERE tblp_coordinador.IdUsua =  '$IdUsua' GROUP BY tblp_coordinador.IdCampus");
  $sql_concep = $db->query("SELECT * FROM tblc_conceptos");

  $sql_prod = $db->query("SELECT * FROM tbc_producto");
  $sql_unid = $db->query("SELECT * FROM tbc_unidad");

  ?>
  <form name="frm2xfYjty" id="frm2xfYjty" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $IdUsua; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-8">
            <div class="form-group">
              <label>Seleccione campus:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-bank"></i>
                </div>
                <select name="txt_campus" id="txt_campus" class="form-control">
                  <option value="">Seleccione</option>
                  <?php while($_campus = $db->recorrer($sql_campus)){ ?>
                    <option value="<?php echo $_campus["IdCampus"]; ?>" <?php if($IdCampus == $_campus["IdCampus"]){ ?>selected="selected"<?php } ?>><?php echo $_campus["Campus"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Nivel:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-book"></i>
                </div>
                <select name="txt_nivel" id="txt_nivel" class="form-control">
                  <option value="">Seleccione</option>
                    <option value="1"> Doctorado </option>
                  <option value="2"> Maestría </option>
                  <option value="3"> Licenciatura </option>
                  <option value="4"> Bachillerato / Prepa </option>
                  <option value="7"> Diplomado </option>
                  <option value="8"> Curso </option>
                  <option value="9"> Certfificacion </option>
                </select>
              </div>
            </div>
          </div>

        <div class="col-md-8">
          <div class="form-group">
            <label>Nombre del plan de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <input type="text" class="form-control" name="txt_nombre" id="txt_nombre">
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Tipo concepto:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-clone"></i>
              </div>
              <select name="txt_concepto" id="txt_concepto" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_concep)){ ?>
                  <option value="<?php echo $x["IdConcepto"]; ?>"><?php echo $x["NomConcepto"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Costo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control" name="txt_costo" id="txt_costo" >
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Recargo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control" name="txt_recargo" id="txt_recargo" >
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label>Clave de producto y/o servicio:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select name="txt_producto" id="txt_producto" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_prod)){ ?>
                  <option value="<?php echo $x["Clave"]; ?>" ><?php echo $x["Clave"]; ?> - <?php echo $x["Descripcion"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Unidad de medida:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select name="txt_unidad" id="txt_unidad" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_unid)){ ?>
                  <option value="<?php echo $x["Clave"]; ?>" ><?php echo $x["Clave"]; ?> - <?php echo $x["Descripcion"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>


        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="savPlanCosto()"> <i class="fa fa-fw fa-save"></i> Guardar</button>

        </div>
      </div>
    </table>
  </div>

  </form>
<script>
function savPlanCosto(){

  var IdUsua = document.getElementById("IdUsua").value;
  var IdCampus = document.getElementById("txt_campus").value;
  var IdNivel = document.getElementById("txt_nivel").value;
  var Nombre = document.getElementById("txt_nombre").value;
  var Concepto = document.getElementById("txt_concepto").value;
  var Costo = document.getElementById("txt_costo").value;
  var Recargo = document.getElementById("txt_recargo").value;
  var Producto = document.getElementById("txt_producto").value;
  var Unidad = document.getElementById("txt_unidad").value;

  var TipoGuardar = "addCostPlan"; 
  if (IdCampus ==''){
      swal("Error al guardar", "Debe seleccionar el campus.", "error");
      document.getElementById("txt_campus").focus();
      return 0;
  }
  if (IdNivel ==''){
      swal("Error al guardar", "Debe seleccionar el nivel o grado.", "error");
      document.getElementById("txt_nivel").focus();
      return 0;
  }
  if (Nombre ==''){
      swal("Error al guardar", "Debe escribir el nombre del plan.", "error");
      document.getElementById("txt_nombre").focus();
      return 0;
  }
  if (Concepto ==''){
      swal("Error al guardar", "Debe seleccionar el tipo de concepto.", "error");
      document.getElementById("txt_concepto").focus();
      return 0;
  }
  if (Costo ==''){
      swal("Error al guardar", "Debe escribir el costo del plan.", "error");
      document.getElementById("txt_costo").focus();
      return 0;
  }
  if (Recargo ==''){
      swal("Error al guardar", "Debe escribir el recargo del plan.", "error");
      document.getElementById("txt_recargo").focus();
      return 0;
  }

  swal({
		title: "\u00BFEst\u00E1 seguro que desea guardar este plan de concepto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
			var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsua=' + IdUsua + '&Nombre=' +Nombre + '&IdNivel=' + IdNivel + '&Concepto='+Concepto +'&IdCampus='+IdCampus+'&Costo='+Costo+'&Recargo='+Recargo+ '&Producto=' + Producto + '&Unidad=' + Unidad;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {

        if(data==1){
					swal("Guardado correctamente", "El plan de concepto ha sido guardado correctamente.", "success");
          parent.location.href='adConceptos.php';
				}
				if(data==0){
					swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}

	});
}

  function upd_concepto_plan(IdPlan){
    var TipoGuardar = "upd_concepto_user";
    var Nombre = document.getElementById("txt_nombre").value;
    var Oferta = document.getElementById("txt_oferta").value;
    var Concepto = document.getElementById("txt_concepto").value;
    var Costo = document.getElementById("txt_costo").value;
    var Recargo = document.getElementById("txt_recargo").value;

    if (Nombre ==''){
  			swal("Error al guardar", "Debe escribir el nombre del plan de plago.", "error");
  			document.getElementById("txt_nombre").focus();
  			return 0;
  	}
    if (Oferta ==''){
  			swal("Error al guardar", "Debe seleccionar el tipo de grado.", "error");
  			document.getElementById("txt_nombre").focus();
  			return 0;
  	}
    if (Costo ==''){
  			swal("Error al guardar", "Debe escribir el costo.", "error");
  			document.getElementById("txt_nombre").focus();
  			return 0;
  	}
    if (Recargo ==''){
  			swal("Error al guardar", "Debe escribir el sin descuento.", "error");
  			document.getElementById("txt_nombre").focus();
  			return 0;
  	}

        swal({
          title: "\u00BFEst\u00E1 seguro que desea actualizar este plan de pago?",
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
                 data:{TipoGuardar:TipoGuardar, IdPlan:IdPlan, Nombre:Nombre, Oferta:Oferta, Concepto:Concepto, Costo:Costo, Recargo:Recargo},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Actualizado correctamente", "El plan de pago se ha actualizado correctamente.", "success");
                $.ajax({
            				 url:"formConsulta/upd_conceptos.php",
            				 method:"POST",
            				 data:{IdConceptoPlan:IdConceptoPlan},
            				 success:function(data){
            							$('#employee_detail_3').html(data);
            							$('#dataModal_3').modal('show');
            				 }
            		});
      				} else {
                swal("Error al actualizar", "No se puede actualizar el plan de pago.", "error");
              }

      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function del_beca_user(IdUsua,IdBeca){
    var TipoGuardar = "del_beca_user";

        swal({
          title: "\u00BFEst\u00E1 seguro que desea eliminar esta beca a este alumno?",
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
                 data:{TipoGuardar:TipoGuardar, IdBeca:IdBeca},
                 success:function(data){

                 }
            })
            .done(function(data) {
      				if(data==1){
      					swal("Eliminado correctamente", "La beca se ha sido eliminado correctamente.", "success");
                var IdConcepto = 0;
                var IdPlan = 0;
                $.ajax({
              			 url:"formConsulta/beca_admisiones.php",
              			 method:"POST",
              			 data:{IdUsua:IdUsua, IdPlan:IdPlan, IdConcepto:IdConcepto},
              			 success:function(data){
              						$('#employee_detail3').html(data);
              						$('#dataModal3').modal('show');
              			 }
              	});
      				}else {
      					swal("Error al eliminar", "No se pudo eliminar la beca.", "error");
      				}
      			})
      			.error(function(data) {
      				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      			});

          }

        });
  }

  function sel_concepto(Id_planx, IdUsua, IdConcepto){
    var IdPlan = Id_planx.value;
    $.ajax({
         url:"formConsulta/beca_admisiones.php",
         method:"POST",
         data:{IdUsua:IdUsua, IdPlan:IdPlan, IdConcepto:IdConcepto},
         success:function(data){
              $('#employee_detail3').html(data);
              $('#dataModal3').modal('show');
         }
    });
  }
</script>
