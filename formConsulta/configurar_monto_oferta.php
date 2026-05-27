<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];

  $lst_oferta = $db->query("SELECT * FROM tblp_educativa");
  $sql_gas = $db->query("SELECT * FROM tblp_gastos WHERE tblp_gastos.IdGasto = '$IdGasto' ");
  $db->rows($sql_gas);
  $_gas = $db->recorrer($sql_gas);
  $val = $_gas['Valor'];

  ?>

  <form name="frm2xfYj" id="frm2xfYj" action="addBeca.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">

    <table class="table table-striped" style="font-size: 12px;">
      <tbody><tr>
        <th style="width: 10px"></th>
        <th>PLAN DE ESTUDIOS</th>
        <th style="width: 100px; text-align: right;">MONTO</th>
      </tr>
      <?php $va = 0; $sx = 0; while($_us = $db->recorrer($lst_oferta)){
        $stl = "";
        $sql_s = $db->query("SELECT * FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' AND tblp_gastos_detalle.IdOferta = '".$_us['IdEducativa']."' ");
        $db->rows($sql_s);
        $_serv = $db->recorrer($sql_s);
        $IdDet = $_serv['IdDetalle_g'];
        $monto = $_serv['Monto'];
        if($monto){ $va = 1; $stl = "style= 'color: blue;'"; }
         ?>
      <tr <?php echo $stl; ?>>
        <td><b><?php echo $sx = ($sx + 1); ?>.- </b></td>
        <td><?php echo $_us['Nombre']; ?></td>
        <td style="text-align: right;">$ <?php echo number_format($monto, 2, '.', ','); ?></td>
      </tr><?php } ?>
      </tbody></table>
      <br>
      <div style="text-align: center;">
      <?php if($va == 0){ ?>
        <div class="btn-group" style="text-align: center;">
          <button onclick="gen_pag_plan(<?php echo $IdGasto; ?>,5,4)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-check-circle"></i> Cursos</button>
          <button onclick="gen_pag_plan(<?php echo $IdGasto; ?>,4,3)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-check-circle"></i> Diplomados</button>
          <button onclick="gen_pag_plan(<?php echo $IdGasto; ?>,3,1)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-check-circle"></i> Licenciatura</button>
          <button onclick="gen_pag_plan(<?php echo $IdGasto; ?>,2,1)" type="button" class="btn btn-success"><i class="fa fa-fw fa-folder"></i> Maestría</button>
          <button onclick="gen_pag_plan(<?php echo $IdGasto; ?>,1,1)" type="button" class="btn btn-info"><i class="fa fa-fw fa-graduation-cap"></i> Doctorado</button>
          <button onclick="gen_pag_todos(<?php echo $IdGasto; ?>)" type="button" class="btn btn-warning"><i class="fa fa-fw fa-gear"></i> Todos</button>
        </div><?php } ?>
        <?php if($va == 1){ ?>
        <div class="btn-group" style="text-align: center; margin-top: 5px;">
          <button onclick="reinciar_pagos(<?php echo $IdGasto; ?>)" type="button" class="btn btn-danger"><i class="fa fa-fw fa-refresh"></i> Reiniciar</button>
          <button style="margin-left: 5px;" onclick="confirmar_pago(<?php echo $IdGasto; ?>)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-check-circle"></i> Confirmar</button>
        </div><?php } ?>
      </div>
  </div>
  </form>
<script>
  function gen_pag_plan(IdGasto, IdGrado, Tipo){
    var TipoGuardar = "gen_pag_plans";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea generar este proceso?",
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
             data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto, IdGrado:IdGrado, Tipo:Tipo},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error, no se puede guardar el gasto.", "error");
  				} else {
            swal("Aplicado correctamente", "El gasto se ha aplicado correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/configurar_monto_oferta.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto},
        				 success:function(data){
        							$('#employee_detail_C').html(data);
        							$('#dataModal_C').modal('show');
        				 }
        		});
          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function gen_pag_todos(IdGasto){
    var TipoGuardar = "gen_pag_plans_all";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea generar este proceso para todos?",
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
             data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==0){
            swal("Error al guardar", "Ha ocurrido un error, no se puede guardar el gasto.", "error");
  				} else {
            swal("Aplicado correctamente", "El gasto se ha aplicado correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/configurar_monto_oferta.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto},
        				 success:function(data){
        							$('#employee_detail_C').html(data);
        							$('#dataModal_C').modal('show');
        				 }
        		});
          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function reinciar_pagos(IdGasto){
    var TipoGuardar = "del_gen_pag_plans";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar los montos generados?",
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
             data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==1){
            swal("Eliminado correctamente", "Los montos se ha eliminado correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/configurar_monto_oferta.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto},
        				 success:function(data){
        							$('#employee_detail_C').html(data);
        							$('#dataModal_C').modal('show');
        				 }
        		});

  				}
          if(data==0){
                        swal("Error al guardar", "Ha ocurrido un error, no se puede guardar el gasto.", "error");
          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }

  function confirmar_pago(IdGasto){
    var TipoGuardar = "aprobar_gen_pag_all";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea cerrar el desglose de gastos generados?",
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
             data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==1){
            swal("Aprobado correctamente", "Los montos se ha generado correctamente.", "success");
            $('#dataModal_C').modal('hide');
            cargar_ultimo_gasto();
  				}
          if(data==0){
                        swal("Error al guardar", "Ha ocurrido un error, no se puede guardar el gasto.", "error");
          }
  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
  }


  function validar_monto(){
		var Monto = document.getElementById("txtImporte2").value;
		if( isNaN(Monto) ) {
			swal("Error en el monto", "El monto ingresado no es un numero entero.", "error");
			document.getElementById("txtImporte2").value = '';
		  return 0;
		}
	}

</script>
