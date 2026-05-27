<?php $valor = 3;
$section = "Prospectos";
include("head.php");
if ($_SESSION['IdUsua']) {
     $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de aspirantes');
}
if (isset($_GET['idO'])) {
     $_POST['txtOferta'] = $_GET['idO'];
} elseif (isset($_POST['txtOferta'])) {
     $_POST['txtOferta'] = $_POST['txtOferta'];
} else {
     $_POST['txtOferta'] = '';
}
$oferta = $t->get_OfertaETodos(0, 0, 0);

if (isset($_POST['txtOferta'])) {
     $lstAlumnos = $t->get_lstProspectos($_SESSION['IdUsua'], $_SESSION['Permisos'], $_POST['txtOferta']);
}

$_mod79 = $t->get_mod_lista_id($_SESSION['IdUsua'], 79);
$_mod83 = $t->get_mod_lista_id($_SESSION['IdUsua'], 83);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
     <div class="wrapper">
          <?php include("menuV.php"); ?>
          <div class="content-wrapper">
               <section class="content-header">
                    <h1>
                         <i class="fa fa-fw fa-users"></i> Lista de aspirantes en seguimiento
                    </h1>
                    <ol class="breadcrumb">
                         <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                         <li class="active">Prospectos</li>
                    </ol>
               </section>
               <section class="content">
                    <form name="frm" id="frm" action="addAddSeguimiento.php" method="POST" enctype="multipart/form-data">
                         <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />

                         <div class="box box-default">
                              <div class="box-body">
                                   <div class="row">
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                  <a class="btn btn-app" onclick="lista_concentrado()" href="javascript:void(0);">
                                                       <i class="fa fa-user"></i> Lista de prospectos
                                                  </a>
                                                  <a class="btn btn-app" onclick="mostrar_concentrado()" href="javascript:void(0);">
                                                       <i class="fa fa-users"></i> Concentrado
                                                  </a>
                                             </div>
                                        </div>
                                        <div class="col-md-8">
                                             <div class="form-group">
                                                  <label>Plan de estudio:</label>
                                                  <div class="input-group">
                                                       <div class="input-group-addon">
                                                            <i class="fa fa-gears"></i>
                                                       </div>
                                                       <select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
                                                            <option value=""> - Seleccione - </option>
                                                            <option value="100" <?php if (isset($_POST["txtOferta"])) {
                                                                                     if ($_POST["txtOferta"] == 100) { ?>selected="selected" <?php }
                                                                                                                                                                          } ?>>TODOS LOS PLANES DE ESTUDIOS</option>
                                                            <?php for ($i = 0; $i < sizeof($oferta); $i++) { ?>
                                                                 <option value="<?php echo $oferta[$i]["IdEducativa"]; ?>" <?php if (isset($_POST["txtOferta"])) {
                                                                                                                                  if ($_POST["txtOferta"] == $oferta[$i]["IdEducativa"]) { ?>selected="selected" <?php }
                                                                                                                                                                                                                                           } ?>><?php echo $oferta[$i]["Nombre"]; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>


                                        <div class="col-xs-12">

                                             <div class="box">
                                                  <div class="box-header">
                                                       <h3 class="box-title">Lista de aspirantes en proceso de alta</h3>
                                                  </div>
                                                  <div class="box-body">
                                                       <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                                                            <thead>
                                                                 <tr>
                                                                      <th></th>
                                                                      <th>AJUSTE</th>
                                                                      <th>NOMBRE</th>
                                                                      <th>FEC.ALTA</th>
                                                                      <th>CAMPUS</th>
                                                                      <th>PLAN DE ESTUDIOS</th>
                                                                      <th>PERIODO ESCOLAR</th>
                                                                      <th>NOTA</th>
                                                                      <th>ASESOR</th>
                                                                 </tr>
                                                            </thead>
                                                            <?php if (isset($lstAlumnos[0])) { ?>
                                                                 <tbody>
                                                                      <?php for ($i = 0; $i < sizeof($lstAlumnos); $i++) {
                                                                      ?>
                                                                           <tr id="del_<?php echo $lstAlumnos[$i]["IdUsua"]; ?>">
                                                                                <td><?php echo $i + 1; ?>.- </td>
                                                                                <td>
                                                                                     <!-- <button type="button" class="btn btn-danger btn-xs" onClick="delAlumno(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>)"><i class="fa fa-fw fa-trash"></i></button> -->

                                                                                     <button title="Configurar alumno" type="button" class="btn btn-primary btn-xs" onclick="miProspecto(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-qrcode"></i></button>
                                                                                     <button title="Llenar cédula de inscripción" type="button" class="btn btn-warning btn-xs" onClick="window.open('adCaptura.php?idToks=<?php echo time() . $lstAlumnos[$i]["IdUsua"]; ?>&Ub=P','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
                                                                                     <button title="Documento de alumnos" type="button" class="btn btn-success btn-xs" onClick="window.open('docVerificar.php?IdUsua=<?php echo time() . $lstAlumnos[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-copy"></i></button>
                                                                                     <?php if (isset($lstAlumnos[$i]["id_ciclo_ini"])) { ?>
                                                                                          <button title="Modificar beca del alumno" onclick="modificar_beca(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>,<?php echo $lstAlumnos[$i]["id_ciclo_ini"]; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-cog"></i></button>
                                                                                          <?php if (isset($_mod83[0])) { ?>
                                                                                               <button title="Modificar configuración del alumno" onclick="configurar_alumno_id(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>, <?php echo $lstAlumnos[$i]["IdCampus"]; ?>,<?php echo $lstAlumnos[$i]["id_ciclo_ini"]; ?>, <?php echo $lstAlumnos[$i]["IdOferta"]; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-refresh"></i></button>

                                                                                          <?php } ?>


                                                                                     <?php } ?>
                                                                                     <button title="Datos de facturación" onclick="datos_factura_id(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>)" type="button" class="btn bg-black btn-flat btn-xs"><i class="fa fa-fw fa-question-circle"></i></button>
                                                                                     <?php if (isset($_mod79[0])) { ?>
                                                                                          <button title="Eliminar alumno" onclick="eliminar_alumno_id(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>, <?php echo $lstAlumnos[$i]["IdCampus"]; ?>,<?php echo $lstAlumnos[$i]["id_ciclo_ini"]; ?>, <?php echo $lstAlumnos[$i]["IdOferta"]; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-trash"></i></button>
                                                                                     <?php } ?>

                                                                                     <!-- <button title="Configurar documentos" type="button" class="btn btn-default btn-sm" onclick="configurarDocs(<?php echo $lstAlumnos[$i]["IdUsua"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-paperclip"></i></button> -->

                                                                                     <!-- <button title="Imprimir cédula de inscripción" type="button" class="btn btn-danger btn-sm" onclick="javascript:window.open('repositorio/pdf/cedula.php?idToks=<?php echo time() . $lstAlumnos[$i]["IdUsua"]; ?>');" href="javascript:void(0);"><i class="fa fa-fw fa-print"></i></button>
                        <button title="Imprimir carta compromiso" type="button" class="btn btn-info btn-sm" onclick="javascript:window.open('repositorio/pdf/cartaCompromiso.php?idToks=<?php echo time() . $lstAlumnos[$i]["IdUsua"]; ?>');" href="javascript:void(0);"><i class="fa fa-fw fa-print"></i></button> -->
                                                                                </td>
                                                                                <td><?php echo $lstAlumnos[$i]["Nombre"] . ' ' . $lstAlumnos[$i]["APaterno"] . ' ' . $lstAlumnos[$i]["AMaterno"]; ?> <?php if ($lstAlumnos[$i]["id_paquete"]) {
                                                                                                                                                                                                             echo "<b style='color: blue;'>(CRM)</b>";
                                                                                                                                                                                                        } ?></td>
                                                                                <td><?php echo $lstAlumnos[$i]["FecCap"]; ?></td>
                                                                                <td><?php echo $lstAlumnos[$i]["Campus"]; ?></td>
                                                                                <td><?php echo $lstAlumnos[$i]["Educativa"]; ?></td>
                                                                                <td><?php echo $lstAlumnos[$i]["Ciclo"]; ?></td>
                                                                                <td><?php if ($lstAlumnos[$i]["id_paquete"]) {
                                                                                          echo $lstAlumnos[$i]["Semblanza"];
                                                                                     } ?></td>
                                                                                <td><?php echo $lstAlumnos[$i]["Asesor"]; ?></td>
                                                                           </tr>
                                                                 <?php }
                                                                 } ?>
                                                                 </tfoot>
                                                       </table>
                                                       <br>
                                                       <?php if (isset($lstAlumnos[0])) { ?>
                                                            <!-- <button onClick="window.open('formConsulta/lista_prospectos_ex.php?idToks=<?php echo $_POST['txtOferta']; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-block btn-info btn-sm">Descargar</button> -->
                                                       <?php } ?>
                                                  </div>
                                             </div>
                                        </div>

                                   </div>
                              </div>
                         </div>




                    </form>
               </section>
               <!-- /.content -->
          </div>

          <div id="dataGrpx" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
               <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                         <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración del prospecto</h4>
                         </div>
                         <div class="modal-body" id="employee_Grpx">

                         </div>
                    </div>
               </div>
          </div>

          <div id="data_promxi" class="modal fade"> <!--MODAL ME GUSTA-->
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-cog"></i> Modificar beca del alumno</h4>
                         </div>
                         <div class="modal-body" id="employee_promxi">
                         </div>
                    </div>
               </div>
          </div>
          <div id="data_ins" class="modal fade"> <!--MODAL ME GUSTA-->
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-cog"></i> Modificar inscripción del alumno</h4>
                         </div>
                         <div class="modal-body" id="employee_ins">
                         </div>
                    </div>
               </div>
          </div>
          <div id="data_del" class="modal fade"> <!--MODAL ME GUSTA-->
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-trash"></i> Eliminar alumno del proceso de inscripción</h4>
                         </div>
                         <div class="modal-body" id="employee_del">
                         </div>
                    </div>
               </div>
          </div>
          <div id="dataModalModFue" class="modal fade">
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar documentos</h4>
                         </div>
                         <div class="modal-body" id="employee_detailModFue">
                         </div>
                    </div>
               </div>
          </div>

          <div id="dataModal_concentradol" class="modal fade bs-example-modal-lg">
               <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                         <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-fw fa-users"></i> Lista de prospectos</h4>
                         </div>
                         <div class="modal-body" id="employee_concentradol">
                         </div>
                    </div>
               </div>
          </div>
          <div id="data_facx" class="modal fade"> <!--MODAL ME GUSTA-->
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-fw fa-child"></i> Datos de facturación</h4>
                         </div>
                         <div class="modal-body" id="employee_facx">
                         </div>
                    </div>
               </div>
          </div>

          <div id="dataModal_concentrado" class="modal fade bs-example-modal-lg">
               <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                         <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-fw fa-users"></i> Concentrado de prospectos</h4>
                         </div>
                         <div class="modal-body" id="employee_concentrado">
                         </div>
                    </div>
               </div>
          </div>

          <!-- /.content-wrapper -->
          <?php include("footer.php"); ?>
     </div>
     <!-- ./wrapper -->

     <!-- jQuery 3 -->
     <script src="bower_components/jquery/dist/jquery.min.js"></script>
     <!-- Bootstrap 3.3.7 -->
     <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
     <!-- Select2 -->
     <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
     <!-- bootstrap datepicker -->
     <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
     <!-- bootstrap color picker -->
     <!-- <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
     <!-- bootstrap time picker -->
     <!-- <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
     <!-- AdminLTE App -->
     <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
     <script src="dist/js/adminlte.min.js"></script>
     <!-- AdminLTE for demo purposes -->
     <script src="dist/js/demo.js"></script>
     <!-- Page script -->
     <script>
          function miProspecto(IdUsua) {
               var Tipo = 'R';
               $.ajax({
                    url: "formConsulta/miProspecto.php",
                    method: "POST",
                    data: {
                         IdUsua: IdUsua,
                         Tipo: Tipo
                    },
                    success: function(data) {
                         $('#employee_Grpx').html(data);
                         $('#dataGrpx').modal('show');
                    }
               });
          }


          $(function() {
               //Date picker
               $('#datepicker').datepicker({
                    autoclose: true
               })

          })
          $(function() {
               $('#example1').DataTable()
          })
          $(function() {
               $('.select2').select2()

          })

          function modificar_beca(IdUsua, IdCiclo) {
               $.ajax({
                    url: "formConsulta/configurar_beca_alumno_inicio.php",
                    method: "POST",
                    data: {
                         IdCiclo: IdCiclo,
                         IdUsua: IdUsua
                    },
                    success: function(data) {
                         $('#employee_promxi').html(data);
                         $('#data_promxi').modal('show');
                    }
               });
          }

          function configurar_alumno_id(IdUsua, IdCampus, IdCiclo, IdOferta) {
               $.ajax({
                    url: "formConsulta/configurar_perfil_alumno.php",
                    method: "POST",
                    data: {
                         IdUsua: IdUsua,
                         IdCampus: IdCampus,
                         IdCiclo: IdCiclo,
                         IdOferta: IdOferta
                    },
                    success: function(data) {
                         $('#employee_ins').html(data);
                         $('#data_ins').modal('show');
                    }
               });
          }

          function eliminar_alumno_id(IdUsua, IdCampus, IdCiclo, IdOferta) {
               $.ajax({
                    url: "formConsulta/eliminar_inscripcion_alumno.php",
                    method: "POST",
                    data: {
                         IdUsua: IdUsua,
                         IdCampus: IdCampus,
                         IdCiclo: IdCiclo,
                         IdOferta: IdOferta
                    },
                    success: function(data) {
                         $('#employee_del').html(data);
                         $('#data_del').modal('show');
                    }
               });
          }

          function configurarDocs(IdUsua) {
               $.ajax({
                    url: "formConsulta/configurarDocs.php",
                    method: "POST",
                    data: {
                         IdUsua: IdUsua
                    },
                    success: function(data) {
                         $('#employee_detailModFue').html(data);
                         $('#dataModalModFue').modal('show');
                    }
               });
          }

          function lista_concentrado() {
               $.ajax({
                    url: "vistas/reportes/lista_prospectos.php",
                    method: "POST",
                    data: {},
                    success: function(data) {
                         $('#employee_concentradol').html(data);
                         $('#dataModal_concentradol').modal('show');
                    }
               });
          }

          function mostrar_concentrado() {
               $.ajax({
                    url: "vistas/reportes/concentrado_prospectos.php",
                    method: "POST",
                    data: {},
                    success: function(data) {
                         $('#employee_concentrado').html(data);
                         $('#dataModal_concentrado').modal('show');
                    }
               });
          }

          function datos_factura_id(IdUsua) {
               $.ajax({
                    url: "vistas/finanzas/datos_factura_id.php",
                    method: "POST",
                    data: {
                         IdUsua: IdUsua
                    },
                    success: function(data) {
                         $('#employee_facx').html(data);
                         $('#data_facx').modal('show');
                    }
               });
          }
     </script>
</body>

</html>