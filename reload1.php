
<?php include("php/clases/session.php");

include('hace.php');
$ingresos=$t->get_ingresosTReal();
//echo 'aqui = '.$facil;
//echo $_GET["Id"];
$porciones = explode("Id=", $_GET["Id"]);
$IdUsua = $porciones[1]; // porción1
if($IdUsua){
  $ingresosId=$t->get_ingresosTRealId($IdUsua);
}
 ?>
 <script src="bower_components/push/push.min.js"></script>
<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Usuarios ingresando en tiempo real</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        <?php for ($i=0;$i< sizeof($ingresos);$i++) { $Id = $ingresos[$i]["IdUsua"];  ?>
        <li class="item">
          <div class="product-img">
            <img src="assets/perfil/<?php echo $ingresos[$i]["Foto"]; ?>" alt="Perfil" class="img-circle img-sm">
          </div>
          <div class="product-info">
            <a onClick="val_tipo(<?php echo $Id; ?>)" href="javascript:void(0)" class="product-title"><?php echo $ingresos[$i]["Nombre"].' '.$ingresos[$i]["APaterno"].' '.$ingresos[$i]["AMaterno"]; ?>
              <span class="label label-success pull-right"><?php echo tiempo_transcurrido($ingresos[$i]["FecCap"]); ?></span></a>
              <span class="product-description">
                  <?php echo $ingresos[$i]["Pagina"]; ?><?php if($ingresos[$i]["Descripcion"]) { ?>  " <?php echo $ingresos[$i]["Descripcion"]; ?> "<?php  } ?>.
                </span>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <!--<div class="box-footer text-center">
      <a href="javascript:void(0)" class="uppercase">Ver todos</a>
    </div>-->
  </div>
</div>

<div class="col-md-6">
  <?php if($IdUsua) { ?>
  <div class="box box-widget widget-user-2">
    <div class="widget-user-header bg-aqua">
      <div class="widget-user-image">
        <img class="img-circle" src="assets/perfil/<?php echo $ingresosId[0]["Foto"]; ?>" alt="User Avatar">
      </div>
      <h3 class="widget-user-username"><?php echo $ingresosId[0]["Nombre"].' '.$ingresosId[0]["APaterno"].' '.$ingresosId[0]["AMaterno"]; ?></h3>
      <h5 class="widget-user-desc"><?php echo $ingresosId[0]["Cargo"]; ?></h5>
    </div>
    <div class="box-footer no-padding">
      <ul class="nav nav-stacked">
        <?php for ($i=0;$i< sizeof($ingresosId);$i++) {   ?>
        <li><a href="#"><?php echo $ingresosId[$i]["Pagina"]; ?><?php if($ingresosId[$i]["Descripcion"]) { ?>  " <?php echo $ingresosId[$i]["Descripcion"]; ?> "<?php  } ?>.  <span class="pull-right badge bg-blue"><?php echo tiempo_transcurrido($ingresosId[$i]["FecCap"]); ?></span></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php } else { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Reporte detallado por usuario</h4>
        Debe seleccionar un usuario del lado izquierdo para visualizar detalladamente sus procesos.
      </div>
  <?php } ?>
</div>
