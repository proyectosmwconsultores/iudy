<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdRvoe  = $_POST['IdRvoe'];
$sql_campx = $db->query("SELECT * FROM tblc_campus");

$sql_rvoe = $db->query("SELECT * FROM tblc_rvoe WHERE tblc_rvoe.IdRvoe = '$IdRvoe'");
$db->rows($sql_rvoe);
$_rvoe = $db->recorrer($sql_rvoe);

?>
<div class="bg-navy-active color-palette" style="padding: 10px;"><span><?php echo $_rvoe['Rvoe'].' - '.$_rvoe['Educativa']; ?></span></div>
<br><br>
  <table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr>
      <th style="width: 10px">#</th>
      <th>NOMBRE DEL CAMPUS</th>
      <th>ESTATUS</th>
    </tr>
  <?php while($xy = $db->recorrer($sql_campx)){
    $sql9 = $db->query("SELECT * FROM tblc_rvoe_campus WHERE tblc_rvoe_campus.IdRvoe = '$IdRvoe' AND tblc_rvoe_campus.IdCampus = '".$xy['IdCampus']."'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdEx = $datos91['Id_rvoe'];
     ?>
      <tr>
        <td>
          <?php if($IdEx){ ?>
          <button type="button" onclick="del_sett_rvoe(<?php echo $IdRvoe.','.$xy['IdCampus'].','.$_rvoe['IdEducativa']; ?>)" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-check-circle"></i></button>
          <?php } else { ?>
            <button type="button" onclick="sav_sett_rvoe(<?php echo $IdRvoe.','.$xy['IdCampus'].','.$_rvoe['IdEducativa']; ?>)" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-times-circle"></i></button>
          <?php } ?>
        </td>
        <td style="padding-top: 15px;"><?php echo $xy['Campus']; ?></td>
        <td>
          <?php if($IdEx){ echo "<b style='color: blue;'>ACTIVO</b>"; } else { echo "<b style='color: red;'>INACTIVO</b>"; } ?>
        </td>
      </tr>
  <?php } ?>
  </tbody></table>

<script>
  function sav_sett_rvoe(IdRvoe,IdCampus,IdEducativa){
      var TipoGuardar = "act_rvoe_campus";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea activar este RVOE en este campus?",
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
               url:"vistas/admin/guardar_datos.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdRvoe:IdRvoe, IdCampus:IdCampus, IdEducativa:IdEducativa},
               success:function(data){

               }
          })
          .done(function(data) {
            if(data==1){
              swal("Guardado correctamente", "El rvoe se ha activado correctamente a este campus.", "success");
              $.ajax({
            			 url:"vistas/admin/configurar_rvoe_campus.php",
            			 method:"POST",
            			 data:{IdRvoe:IdRvoe},
            			 success:function(data){
            						$('#employee_detail_Rvoe').html(data);
            						$('#dataModal_Rvoe').modal('show');
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

  function del_sett_rvoe(IdRvoe,IdCampus,IdEducativa){
      var TipoGuardar = "quitar_rvoe_campus";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea quitar este RVOE en este campus?",
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
               url:"vistas/admin/guardar_datos.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdRvoe:IdRvoe, IdCampus:IdCampus, IdEducativa:IdEducativa},
               success:function(data){

               }
          })
          .done(function(data) {
            if(data==1){
              swal("Deshabiliado correctamente", "El rvoe se ha quitado correctamente de este campus.", "success");
              $.ajax({
            			 url:"vistas/admin/configurar_rvoe_campus.php",
            			 method:"POST",
            			 data:{IdRvoe:IdRvoe},
            			 success:function(data){
            						$('#employee_detail_Rvoe').html(data);
            						$('#dataModal_Rvoe').modal('show');
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
</script>
