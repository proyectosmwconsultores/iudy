<?php $_v = 33;
$section = "Mi grupo";
include("head.php");
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario ha ingresado en el apartado de mi grupo de la materia.');
}
$contenido->get_validar_mat($_GET['idAsignacion'], $_SESSION['IdUsua']);
$materia = $t->get_datosModuloD($_GET['idAsignacion']);
$lst_grupo = $contenido->get_lst_grupo($_GET['idAsignacion']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <div class="topbar-planeacion">
        <div class="topbar-planeacion__left">
          <h1> <i class="fa fa-flag"></i> MIS GRUPO </h1>
        </div>
        <div class="topbar-planeacion__right">
          <span>MATERIA</span>
          <i class="fa fa-angle-right"></i>
          <span class="active"><?php echo $materia[0]['NombreMod']; ?></span>
        </div>
      </div>

      <div class="materia-wrap">
        <div class="grupo-box">
          <div class="grupo-grid">
            <?php for ($c = 0; $c < sizeof($lst_grupo); $c++) { ?>
              <div class="alumno-card">
                <div class="alumno-avatar">
                  <img src="assets/perfil/<?php echo $lst_grupo[$c]['Foto']; ?>" alt="Alumno">
                </div>
                <div class="alumno-info">
                  <h4><?php echo $lst_grupo[$c]['Nombre'] . ' ' . $lst_grupo[$c]['APaterno'] . ' ' . $lst_grupo[$c]['AMaterno']; ?></h4>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <?php include("footer.php"); ?>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

</body>

</html>