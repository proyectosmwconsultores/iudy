<?php $section = "Práctica profesional";
include("head.php");
$var = 9;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el modulo de practicas profesionales');
}

$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Prácticas profesionales
        </h1>
        <ol class="breadcrumb">
          <li><a href="espacioUser.php"><i class="fa fa-dashboard"></i> Mi espacio</a></li>
          <li class="active"> Prácticas profesionales </li>
        </ol>
        <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>">
      </section>
      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioAlumno.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">

                <!-- Header con Tabs -->
                <div class="paytabs-header">

                  <div class="paytabs-title-area">
                    <div class="paytabs-icon">💼</div>
                    <div>
                      <div class="paytabs-title">Mi práctica profesional </div>
                      <div class="paytabs-sub">Espacio para poder visualizar la disponibilidad de las practicas profesionales </div>
                    </div>
                  </div>
                </div>

                <!-- Contenido -->
                <div class="paytabs-content">
                  <div class="paypanel is-active" data-content="pendientes">

                    <form class="form-horizontal" name="frm" id="frm" action="misServicios.php" method="POST" enctype="multipart/form-data">
                      <div class="nav-tabs-custom">
                        <div class="tab-content">
                          <div class="tab-pane active" id="activity">
                            <div class="bg-active color-palette" style="padding: 5px; background: #1d3462; color: white;"><span><i class="fa fa-fw fa-odnoklassniki"></i> Prácticas profesionales</span></div>
                            <p style="text-align: center; display: none;" id="img_cargar2">
                              <img src="assets/images/cargando.gif">
                            </p>
                            <div id="panel_actividades"></div>
                          </div>
                        </div>
                        <!-- /.tab-content -->
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>

      
      <div id="data_practica" class="modal fade bs-example-modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Práctica profesional</h4>
            </div>
            <div class="modal-body" id="employee_practica">
            </div>
          </div>
        </div>
      </div>
      <div id="data_docspractica" class="modal fade bs-example-modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Documento recibido</h4>
            </div>
            <div class="modal-body" id="employee_docspractica">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("footer.php"); ?>
  </div>

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>


  <script>
    function inscripcion_practica(IdUsua, IdAviso, IdDetalle) {
      var Tipo = 1;
      $.ajax({
        url: "vistas/practicas/inscripcion_alumno.php",
        method: "POST",
        data: {
          IdUsua: IdUsua,
          IdAviso: IdAviso,
          IdDetalle: IdDetalle,
          Tipo: Tipo
        },
        success: function(data) {
          $('#employee_practica').html(data);
          $('#data_practica').modal('show');
        }
      });
    }

    $(function() {
      var IdUsua = document.getElementById("IdUsua").value;
      mostrar_seguimiento(IdUsua);

    })

    function mostrar_seguimiento(IdUsua) {
      document.getElementById("img_cargar2").style.display = 'block';
      document.getElementById("panel_actividades").style.display = 'none';
      var Capa = "#panel_actividades";
      $(Capa).load("vistas/practicas/alumno_espacio.php", {
        IdUsua: IdUsua
      }, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
        if (status == "success") {
          document.getElementById("panel_actividades").style.display = 'block';
          document.getElementById("img_cargar2").style.display = 'none';
        }
      });
    }

    function save_docs_practica(IdUsua, IdPractica) {
      var Tipo = document.getElementById("txtTipoDoc").value;
      var Archivo = document.getElementById("txtArchivo").value;
      var Imagen = '#txtArchivo';

      if (Tipo == "") {
        swal("Error al guardar", "Debe seleccionar el tipo de documento que esta subiendo.", "error");
        return 0;
      }
      if (Archivo == "") {
        swal("Error al guardar", "Debe seleccionar el archivo.", "error");
        return 0;
      }

      swal({
          title: "\u00BFEst\u00E1 seguro que desea guardar este archivo seleccionado?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function(isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');

            var formData = new FormData();
            var files = $(Imagen)[0].files[0];
            formData.append('IdUsua', IdUsua);
            formData.append('IdPractica', IdPractica);
            formData.append('Tipo', Tipo);
            formData.append('file', files);

            $.ajax({
                url: 'vistas/upload/subir_docs_practica.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                }
              })
              .done(function(response) {
                if (response == 1) {
                  swal("Guardado correctamente", "El archivo se ha subido correctamente.", "success");
                  mostrar_seguimiento(IdUsua);
                } else {
                  swal("Error al guardar", "Ha ocurrido un error no se ha podido subir el archivo.", "error");
                }
              })
              .error(function(data) {
                swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
              });
          }
        });
    }

    function del_docs_practica(IdDocs, IdUsua) {
      var TipoGuardar = "del_docs_practica";
      swal({
          title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este archivo?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function(isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');

            $.ajax({
                url: "vistas/practicas/sav_desarrollo.php",
                method: "POST",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdDocs: IdDocs
                },
                success: function(data) {}
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Eliminado correctamente", "El documento se ha eliminado correctamente.", "success");
                  mostrar_seguimiento(IdUsua);
                } else {
                  swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });
          }
        });
    }

    function ver_docs_practica(IdDocs) {
      $.ajax({
        url: "vistas/practicas/ver_docs_practica.php",
        method: "POST",
        data: {
          IdDocs: IdDocs
        },
        success: function(data) {
          $('#employee_docspractica').html(data);
          $('#data_docspractica').modal('show');
        }
      });
    }
  </script>
</body>

</html>