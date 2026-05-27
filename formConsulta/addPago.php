<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = substr($_POST["Token"], 10, 10);
  $IdPago = $_POST["IdPago"];
  $_valx = 0;

  $sql8 = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.Monto, tblp_pagos.IdEstatus, tblp_pagos.FecLimPago, tblp_pagos.IdBeca, tblp_pagos.Descuento, tblp_pagos.FechaDesc, tblp_pagos._motivo, tblp_pagos.Descuento2, tblp_pagos.TotalPagado, tblp_pagos.Filtro, tblc_estatus.Estatus, tblc_conceptosplanes.NomPlan, tblc_conceptos.NomConcepto FROM tblp_pagos Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosplanes.IdConcepto WHERE tblp_pagos.IdPago = '$IdPago' AND tblp_pagos.IdUsua =  '$IdUsua' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Desc2 = $datos81['Descuento2'];

  $sql = $db->query("SELECT * FROM tblp_recargos WHERE tblp_recargos.IdUsua = '$IdUsua' AND tblp_recargos.IdPago = '$IdPago'");


  $mod_16 = $db->query("SELECT tblc_modulousuario.IdModulo FROM tblc_modulousuario WHERE tblc_modulousuario.IdModulo = '16' AND tblc_modulousuario.IdUsua = '".$_SESSION['IdUsua']."'");
  $db->rows($mod_16);
  $mod16 = $db->recorrer($mod_16);
  $_idMod16 = $mod16['IdModulo'];

  $mod_18 = $db->query("SELECT tblc_modulousuario.IdModulo FROM tblc_modulousuario WHERE tblc_modulousuario.IdModulo = '18' AND tblc_modulousuario.IdUsua = '".$_SESSION['IdUsua']."'");
  $db->rows($mod_18);
  $mod18 = $db->recorrer($mod_18);
  $_idMod18 = $mod18['IdModulo'];

  ?>
  <form class="form-horizontal" name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["Token"]; ?>" type="hidden"/>
    <input id="IdUsuaCap" name="IdUsuaCap" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="IdPago" name="IdPago" value="<?php echo $IdPago; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savBeca" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -45px;">
        <!-- <div class="box-body"> -->
          <table class="table table-striped">
                <tbody>
                  <tr>
                  <th>Descripción del pago</th>
                  <th style="text-align: right;">Monto</th>
                </tr>

                <tr>
                  <td><?php echo $datos81["NomPlan"]; ?></td>
                  <td style="text-align: right;">+ $ <?php echo number_format($datos81["Monto"], 2, '.', ','); ?></td>
                </tr>
                <?php if($datos81["Descuento"]){ ?>
                  <tr>
                    <td>DESCUENTO BECA</td>
                    <td style="text-align: right;"> - $ <?php echo number_format($datos81["Descuento"], 2, '.', ','); ?></td>
                  </tr>
                <?php } ?>
                <?php $recargo = 0; while($x = $db->recorrer($sql)){   ?>
                  <tr>
                    <td>
                      <?php if($datos81["IdEstatus"] != 4){ ?>
                      <button onclick="delRecargo(<?php echo $IdPago; ?>,<?php echo $IdUsua; ?>,<?php echo $x["IdRecargo"]; ?>)" type="button" title="Eliminar recargo" class="btn bg-red btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                    <?php } ?>
                      RECARGO <b><i class="fa fa-fw fa-dot-circle-o"></i></b> <?php echo $x["AnioMes"]; ?></td>
                    <td style="text-align: right;">+ $ <?php echo number_format($x["Monto"], 2, '.', ','); ?></td>
                  </tr>
                  <?php $recargo = $recargo + $x["Monto"]; } ?>
                <?php $abonos = 0; ?>
                  <?php if($Desc2){ $_valx = 1; ?>
                  <tr>
                    <td>
                      <?php if(($datos81["IdEstatus"] != 4) && (isset($_idMod18))){ ?>
                      <button onclick="del_desc_especial(<?php echo $IdPago; ?>)" type="button" title="Eliminar descuento especial" class="btn bg-red btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                    <?php } ?>
                      DESCUENTO ESPECIAL / <?php echo $datos81['FechaDesc'];  ?>
                      <br>
                      MOTIVO: <?php echo $datos81['_motivo'];  ?>
                    </td>
                    <td style="text-align: right;">- $ <?php echo number_format($Desc2, 2, '.', ','); ?> </td>
                  </tr>

                <?php } if(($datos81["IdEstatus"] != 4) && ($_valx == 0)) { ?>
                  <tr>
                    <td colspan="2">
                      <?php if(isset($_idMod16)){ ?>
                    <button onclick="add_desc_adicional()" type="button" title="Agregar descuento" class="btn bg-primary btn-flat btn-sm"><i class="fa fa-cog"></i></button> AGREGAR DESCUENTO ESPECIAL
                    <?php } ?>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2">
                      <div style="display: none;" id="div_desc2">
                      <div class="box-body">
                        <div class="form-group">
                        <label class="col-sm-8 control-label">Descuento (MXN):</label>
                        <div class="col-sm-4">
                        <input type="number" class="form-control" name="txtDesc2" id="txtDesc2" placeholder="Ejemplo: 500">
                        </div>
                        </div>
                        <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Motivo del descuento:</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="txt_motix" id="txt_motix" placeholder="Motivo del descuento ...">
                        </div>
                        </div>
                        </div>
                        <div class="box-footer">
                          <button type="button" onclick="save_desc_adicional(<?php echo $IdPago; ?>)" class="btn btn-info pull-right"><i class="fa fa-save"></i> Guardar descuento</button>
                          <button type="button" onclick="cancelar_descuento(<?php echo $IdPago; ?>)" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-times-circle"></i> Cancelar</button>
                        </div>
                        </div>
                    </td>

                  </tr>

                  <?php } ?>

              </tbody></table>
              <?php
              $monto = $datos81["Monto"];
              $descuento = ($datos81["Descuento"] + $Desc2);
              $sumTotal1 = ($monto - $descuento);
              $sumTotal2 = ($sumTotal1 + $recargo - $abonos);
              // if($IdEstt == 4){ $sumTotal2 = 0; }
               ?>


        <div class="col-md-12">
          <div class="form-group" style="background: #003A70; padding: 5px; color: white;">
            <label class="col-sm-4 control-label">TOTAL DEUDA:</label>
            <label class="col-sm-8 control-label"><b>$ <?php echo number_format($sumTotal2, 2, '.', ','); ?></b></label>
          </div>
        </div>

      </div>
    </table>
  </div>

  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>


function add_desc_adicional(){
  document.getElementById("div_desc2").style.display = "block";

}

function cancelar_descuento(IdPago){
    var Token = document.getElementById("IdUsua").value;
    $.ajax({
        url:"formConsulta/addPago.php",
        method:"POST",
        data:{Token:Token,IdPago:IdPago},
        success:function(data){
             $('#employee_detail7').html(data);
             $('#dataModal7').modal('show');
        }
   });

}


function save_desc_adicional(IdPago){
    var Token = document.getElementById("IdUsua").value;
    var Motivo = document.getElementById("txt_motix").value;
    var Desc = document.getElementById("txtDesc2").value;
    if (Desc ==""){
        swal("Error al guardar", "Debe escribir el descuento especial.", "error");
        return 0;
    }
    if (Motivo ==""){
        swal("Error al guardar", "Debe escribir el motivo del descuento especial.", "error");
        return 0;
    }

    var TipoGuardar = "savDescuento2";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea agregar este descuento especial?",
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
             data:{TipoGuardar:TipoGuardar, IdPago:IdPago, Desc:Desc, Motivo:Motivo},
             success:function(data){
               $.ajax({
             			 url:"formConsulta/addPago.php",
             			 method:"POST",
             			 data:{Token:Token,IdPago:IdPago},
             			 success:function(data){
             						$('#employee_detail7').html(data);
             						$('#dataModal7').modal('show');
             			 }
             	});
             }
        })
        .done(function(data) {

          if(data==1){
            swal("Guardado correctamente", "Guardado correctamente.", "success");

          }

        })
        .error(function(data) {
          swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
        });
      }
    });

}


$(document).ready(function(){
  $("#txtForma").change(function () {
     var Forma = parseFloat(document.getElementById("txtForma").value);
     if((Forma == 2) || (Forma == 3)){
        document.getElementById("BancoId").style.display = "block";
     }
     else{
       document.getElementById("BancoId").style.display = "none";
     }


  });
});

  $(function () {

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

  })

  function del_desc_especial(IdPago){
    var Token = document.getElementById("IdUsua").value;
  	var TipoGuardar = "del_desc_espx";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar este descuento especial?",
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
             data:{TipoGuardar:TipoGuardar, IdPago:IdPago},
             success:function(data){
               $.ajax({
             			 url:"formConsulta/addPago.php",
             			 method:"POST",
             			 data:{Token:Token,IdPago:IdPago},
             			 success:function(data){
             						$('#employee_detail7').html(data);
             						$('#dataModal7').modal('show');
             			 }
             	});
             }
        })
        .done(function(data) {
          if(data==1){
            swal("Eliminado correctamente", "El descuento especial ha sido eliminado correctamente.", "success");
          }

        })
        .error(function(data) {
          swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
        });
      }
    });
  }
</script>
