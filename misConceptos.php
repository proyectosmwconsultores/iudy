<?php $section = "Mis Conceptos de Pago"; include("head.php"); $var = 7;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en Mis Conceptos de Pago'); }
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
$misPagos = $espacio->get_misPagos($_SESSION['IdUsua']);
$tipoConcepto = $espacio->get_tipoConcepto($_SESSION['IdOferta']);
$misConceptos = $espacio->get_misConceptos($tipoConcepto[0]["Tipo"]);
$tipoX = $tipoConcepto[0]["Tipo"];
if($tipoX == "Doctorado"){
  $Grado = "Grado1";
} elseif($tipoX == "Maestria"){
  $Grado = "Grado2";
} elseif($tipoX == "Licenciatura"){
  $Grado = "Grado3";
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Mis pagos <?php echo $_SESSION['IdOferta']; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="miEspacio.php"> Mi espacio</a></li>
        <li class="active"> Mis conceptos</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["Nombre"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <?php include("datEspacio.php"); ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Lista de conceptos de pago</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form name="frm" id="frm" action="misdatosFact.php" method="POST" enctype="multipart/form-data">
              <div class="col-md-12">
        			  <div class="box-primary">
        				  <div class="box-body">
                    <div class="box-body no-padding">
                      <table class="table table-striped">
                        <tbody><tr>
                          <th style="width: 10px">#</th>
                          <th>Concepto</th>
                          <th>Monto</th>
                        </tr>
                        <?php for ($i=0;$i< sizeof($misConceptos);$i++) { ?>
                        <tr>
                          <td><?php echo $i + 1; ?></td>
                          <td><?php echo $misConceptos[$i]["NomConcepto"]; ?></td>
                          <td><b>$ <?php echo number_format($misConceptos[$i][$Grado], 2, '.', ','); ?></b></td>
                        </tr>
                        <?php } ?>
                      </tbody></table>
                    </div>

        				  </div>
        			  </div>
        			</div>

              <!-- /.box-body -->
              <div class="box-footer">

              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>



    </section>
  </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    $('.textarea').wysihtml5()
  })

  $(document).ready(function(){
    var alerta = document.frm.Alerta.value;
    if(alerta){
      if(alerta =="0"){
        swal("Error", "Error no se puede Guardar", "error");
      }
      if(alerta =="1"){
        swal("Guardado", "Comprobante guardado con exito", "success");
      }
    }
  });

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
