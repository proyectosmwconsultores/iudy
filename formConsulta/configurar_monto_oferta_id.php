<?php
  session_start();
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();
  $IdUsua = $_SESSION["IdUsua"];
  $IdGasto = $_POST['IdGasto'];


  $lst_oferta = $db->query("SELECT
    tblp_educativa.IdEducativa,
tblp_educativa.Nombre,
tblp_gastos_detalle.Monto,
tblp_gastos_detalle.IdDetalle_g,
tblp_gastos_detalle.Tipo
FROM
tblp_gastos_detalle
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_gastos_detalle.IdOferta
WHERE tblp_gastos_detalle.IdGasto = '$IdGasto'
ORDER BY
tblp_educativa.IdEducativa ASC
");

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
      <?php $va1 = 0; $va2 = 0; $va3 = 0;
        while($_us = $db->recorrer($lst_oferta)){
        $IdDet = $_us['IdDetalle_g'];
        $monto = $_us['Monto'];
        $tipo = $_us['Tipo'];

        if($tipo == 1){ $va1 = 1; $stl = "style= 'color: red;'"; } else { $stl = "style= 'color: blue;'"; }
        if($tipo == 2){ $va2 = 1; }
        if($tipo == 3){ $va3 = 1; $va1 = 1;}

         ?>
      <tr <?php echo $stl; ?>>
        <td>
          <?php if(($tipo == 1) || ($tipo == 2)){ if($tipo == 1){ ?>
          <button onclick="selecc_plan(<?php echo $IdDet; ?>,<?php echo $IdGasto; ?>,2)" type="button" class="btn btn-default btn-xs"><i class="fa fa-fw fa-times-circle"></i></button>
        <?php } else { ?>
          <button onclick="selecc_plan(<?php echo $IdDet; ?>,<?php echo $IdGasto; ?>,1)" type="button" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-check-circle"></i></button>
        <?php } } ?>
        </td>
        <td><?php echo $_us['Nombre']; ?></td>
        <td style="text-align: right;"><?php if($tipo == 3){ ?>$ <?php echo number_format($monto, 2, '.', ','); ?><?php } ?></td>
      </tr><?php } ?>
      </tbody></table>
      <br>
      <div style="text-align: center;">

        <?php if($va2 == 1){ ?>
        <div class="btn-group" style="text-align: center; margin-top: 5px;">
          <button onclick="reinciar_pagos(<?php echo $IdGasto; ?>)" type="button" class="btn btn-danger"><i class="fa fa-fw fa-refresh"></i> Calcular</button>
        </div><?php } ?>
        <?php if($va3 == 1){ ?>
        <div class="btn-group" style="text-align: center;">
          <button style="margin-left: 5px;" onclick="reiniciar_pagx(<?php echo $IdGasto; ?>)" type="button" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reiniciar</button>
          <button style="margin-left: 5px;" onclick="confirmar_pago(<?php echo $IdGasto; ?>)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-check-circle"></i> Confirmar</button>
        </div><?php } ?>

        <?php if($va1 == 0){ ?>
        <div class="btn-group">
          <button onclick="cargar_planes_pagx(<?php echo $IdGasto; ?>)" type="button" class="btn btn-danger"><i class="fa fa-fw fa-refresh"></i> Cargar planes de pagos</button>
        </div><?php } ?>

      </div>
  </div>
  </form>
<script>

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
    var TipoGuardar = "cal_pag_plans";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea calcular los montos por cada plan de estudios?",
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
            swal("Generado correctamente", "Los montos se ha calculados correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/configurar_monto_oferta_id.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto},
        				 success:function(data){
        							$('#employee_detail_Cx').html(data);
        							$('#dataModal_Cx').modal('show');
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
    var TipoGuardar = "apr_gen_pag_all";
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
            parent.location.href='captura_gastos.php'; //direcciona la pagina madre
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


  function cargar_planes_pagx(IdGasto){
    var TipoGuardar = "load_pag_plans";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea cargar los planes de estudios?",
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
            swal("Cargado correctamente", "Los planes de estudios se han cargado correctamente.", "success");
            $.ajax({
        				 url:"formConsulta/configurar_monto_oferta_id.php",
        				 method:"POST",
        				 data:{IdGasto:IdGasto},
        				 success:function(data){
        							$('#employee_detail_Cx').html(data);
        							$('#dataModal_Cx').modal('show');
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

  function selecc_plan(IdDetalle_g, IdGasto, Valor){

      var TipoGuardar = "ups_sts_gen_pag";
      $.ajax({
           url:"formConsulta/setting.php",
           method:"POST",
           data:{TipoGuardar:TipoGuardar, IdDetalle_g:IdDetalle_g, Valor:Valor},
           success:function(data){

           }
      })
      .done(function(data) {
        if(data==1){
          $.ajax({
               url:"formConsulta/configurar_monto_oferta_id.php",
               method:"POST",
               data:{IdGasto:IdGasto},
               success:function(data){
                    $('#employee_detail_Cx').html(data);
                    $('#dataModal_Cx').modal('show');
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

  function reiniciar_pagx(IdGasto){
    var TipoGuardar = "reini_gen_pag_all";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea reiniciar el cálculo de los montos?",
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
            swal("Reiniciado correctamente", "Los montos se ha reiniciado correctamente.", "success");
            $.ajax({
                 url:"formConsulta/configurar_monto_oferta_id.php",
                 method:"POST",
                 data:{IdGasto:IdGasto},
                 success:function(data){
                      $('#employee_detail_Cx').html(data);
                      $('#dataModal_Cx').modal('show');
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

</script>
