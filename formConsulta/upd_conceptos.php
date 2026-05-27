<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdPlan = $_POST["IdConceptoPlan"];

  $sql_concep = $db->query("SELECT * FROM tblc_conceptos");

  $sql8 = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdPlan'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);

  $sql_prod = $db->query("SELECT * FROM tbc_producto");
  $sql_unid = $db->query("SELECT * FROM tbc_unidad");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">

        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre del plan de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <input type="text" class="form-control" name="txt_nombre" id="txt_nombre" value="<?php echo $datos81["NomPlan"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label>Nivel:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select name="txt_oferta" id="txt_oferta" class="form-control">
                <option value="">Seleccione</option>
                <option value="1" <?php if($datos81["IdGrado"] == 1){ ?>selected="selected"<?php } ?> > Doctorado </option>
                <option value="2" <?php if($datos81["IdGrado"] == 2){ ?>selected="selected"<?php } ?> > Maestría </option>
                <option value="3" <?php if($datos81["IdGrado"] == 3){ ?>selected="selected"<?php } ?> > Licenciatura </option>
                <option value="4" <?php if($datos81["IdGrado"] == 4){ ?>selected="selected"<?php } ?> > Bachillerato / Prepa </option>
                <!-- <option value="5" <?php if($datos81["IdGrado"] == 5){ ?>selected="selected"<?php } ?> > Secundaria </option> -->
                <!-- <option value="6" <?php if($datos81["IdGrado"] == 6){ ?>selected="selected"<?php } ?> > Primaria </´option> -->
                <option value="7" <?php if($datos81["IdGrado"] == 7){ ?>selected="selected"<?php } ?> > Diplomado </option>
                <option value="8" <?php if($datos81["IdGrado"] == 8){ ?>selected="selected"<?php } ?> > Curso </option>
                <option value="9" <?php if($datos81["IdGrado"] == 9){ ?>selected="selected"<?php } ?> > Certificacin </option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="form-group">
            <label>Tipo concepto:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <select name="txt_concepto" id="txt_concepto" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_concep)){ ?>
                  <option value="<?php echo $x["IdConcepto"]; ?>" <?php if($datos81["IdConcepto"] == $x["IdConcepto"]){ ?>selected="selected"<?php } ?>><?php echo $x["NomConcepto"]; ?></option>
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
                <i class="fa fa-map-signs"></i>
              </div>
              <input type="text" class="form-control" name="txt_costo" id="txt_costo" value="<?php echo $datos81["Costo"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Recargo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </div>
              <input type="text" class="form-control" name="txt_recargo" id="txt_recargo" value="<?php echo $datos81["Recargo"]; ?>">
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
              <select name="txt_productox" id="txt_productox" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_prod)){ ?>
                  <option value="<?php echo $x["Clave"]; ?>" <?php if($datos81["ClaveProdServ"] == $x["Clave"]){ ?>selected="selected"<?php } ?>><?php echo $x["Clave"]; ?> - <?php echo $x["Descripcion"]; ?></option>
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
              <select name="txt_unidadx" id="txt_unidadx" class="form-control">
                <option value="">Seleccione</option>
                <?php while($x = $db->recorrer($sql_unid)){ ?>
                  <option value="<?php echo $x["Clave"]; ?>" <?php if($datos81["ClaveUnidad"] == $x["Clave"]){ ?>selected="selected"<?php } ?>><?php echo $x["Clave"]; ?> - <?php echo $x["Descripcion"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>


        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="upd_concepto_plan(<?php echo $IdPlan; ?>)"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>

        </div>
      </div>
    </table>
  </div>

  </form>
<script>
  function upd_concepto_plan(IdPlan){
    var TipoGuardar = "upd_concepto_user";
    var Nombre = document.getElementById("txt_nombre").value;
    var Oferta = document.getElementById("txt_oferta").value;
    var Concepto = document.getElementById("txt_concepto").value;
    var Costo = document.getElementById("txt_costo").value;
    var Recargo = document.getElementById("txt_recargo").value;
    var Producto = document.getElementById("txt_productox").value;
    var Unidad = document.getElementById("txt_unidadx").value;

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
                 data:{TipoGuardar:TipoGuardar, Producto:Producto, Unidad:Unidad, IdPlan:IdPlan, Nombre:Nombre, Oferta:Oferta, Concepto:Concepto, Costo:Costo, Recargo:Recargo},
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
