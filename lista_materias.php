<?php $valor = 1;
$section = "Lista de materias";
include("head.php");
if ($_SESSION['Permisos']) {
  $campus = $t->get_campusId();
?>
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
    <div class="wrapper">
      <?php include("menuV.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>Reporte de lista de materias</h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
            <li class="active">Materias</li>
          </ol>
        </section>
        <section class="content">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Lista de materias activas por plan de estudios</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <form name="frm" id="frm" action="repIngresosDia.php" method="POST" enctype="multipart/form-data">
                  <div class="col-md-4">
                    <div class="box-primary">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Campus: </label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-book"></i>
                            </div>
                            <select class="form-control select2" name="txtCampus" id="txtCampus" onchange="buscar_oferta_plan()">
                              <option value=""> - Seleccione - </option>
                              <?php for ($i = 0; $i < sizeof($campus); $i++) { ?>
                                <option value="<?php echo $campus[$i]["IdCampus"]; ?>"><?php echo $campus[$i]["Campus"]; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="box-primary">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Plan de estudios: </label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-book"></i>
                            </div>
                            <select class="form-control select2" name="txt_oferta" id="txt_oferta">
                            </select>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-info btn-flat" onclick="consultar_ingresos()"><i class="fa fa-fw fa-search"></i> Consultar</button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <p style="text-align: center; display: none;" id="img_cargar">
              <img src="assets/images/cargando.gif">
            </p>
            <div class="box-body" id="mostrar_ingresos" style="display: none;"></div>
          </div>
        </section>
        <div id="dataModalModAct" class="modal fade"> <!--MODAL ME GUSTA-->
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-check"></span> Actualizar datos de la materias</h4>
              </div>
              <div class="modal-body" id="employee_detailModAct">
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
    <!-- Select2 -->
    <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- bootstrap datepicker -->
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script>
      function consultar_ingresos() {
        var IdCampus = document.getElementById("txtCampus").value;
        var IdOferta = document.getElementById("txt_oferta").value;
        if (IdCampus == '') {
          swal("Error al buscar", "Debe seleccionar el campus.", "error");
          document.getElementById("txtCampus").focus();
          return 0;
        }
        if (IdOferta == '') {
          swal("Error al buscar", "Debe seleccionar el plan de estudios.", "error");
          document.getElementById("txt_oferta").focus();
          return 0;
        }

        document.getElementById("img_cargar").style.display = 'block';
        document.getElementById("mostrar_ingresos").style.display = 'none';
        var Capa = "#mostrar_ingresos";
        $(Capa).load("vistas/escolar/reporte_materias.php", {
          IdCampus: IdCampus,
          IdOferta: IdOferta
        }, function(response, status, xhr) {
          if (status == "error") {
            var msg = "Error!, algo ha sucedido: ";
            $(Capa).html(msg + xhr.status + " " + xhr.statusText);
          }
          if (status == "success") {
            document.getElementById("mostrar_ingresos").style.display = 'block';
            document.getElementById("img_cargar").style.display = 'none';
          }
        });
      }

      $(function() {
        $('.select2').select2()
      })

      function buscar_oferta_plan() {
        var IdCampus = document.getElementById("txtCampus").value;
        var Tipo = "get_oferta_campus";
        $.post("php/clases/getConsulta.php", {
          Tipo: Tipo,
          IdCampus: IdCampus
        }, function(data) {
          $("#txt_oferta").html(data);
        });
      }

      function mostrarMat(IdModulo) {
        $.ajax({
          url: "vistas/admin/actualiza_materia_id.php",
          method: "POST",
          data: {
            IdModulo: IdModulo
          },
          success: function(data) {
            $('#employee_detailModAct').html(data);
            $('#dataModalModAct').modal('show');
          }
        });
      }

      function actualizar_materia_id(IdModulo) {
        var IdGrado = document.getElementById("txtIdGrado").value;
        var Code = document.getElementById("txtCode").value;
        var Nombre = document.getElementById("txtNombre").value;
        var IdSeriada = document.getElementById("txtSeriada").value;

        if (IdGrado == '') {
          swal("Error al guardar", "Debe selecionar el cuatrimestre.", "error");
          document.getElementById("txtIdGrado").focus();
          return 0;
        }
        if (Code == '') {
          swal("Error al guardar", "Debe escribir el CodeModulo.", "error");
          document.getElementById("txtIdGrado").focus();
          return 0;
        }

        if (Nombre == '') {
          swal("Error al guardar", "Debe escribir el CodeModulo.", "error");
          document.getElementById("txtNombre").focus();
          return 0;
        }

        var TipoGuardar = "update_datos_materia";
        swal({
            title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
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
                  url: "vistas/admin/guardar_datos.php",
                  method: "POST",
                  data: {
                    TipoGuardar: TipoGuardar,
                    IdModulo: IdModulo,
                    IdGrado: IdGrado,
                    Code: Code,
                    Nombre: Nombre,
                    IdSeriada:IdSeriada
                  },
                  success: function(data) {

                  }
                })
                .done(function(data) {
                  if (data == 1) {
                    swal("Actualizado correctamente", "Los datos de la materia se han actualizado correctamente.", "success");
                    // consultar_ingresos();
                    $.ajax({
                      url: "vistas/admin/actualiza_materia_id.php",
                      method: "POST",
                      data: {
                        IdModulo: IdModulo
                      },
                      success: function(data) {
                        $('#employee_detailModAct').html(data);
                        $('#dataModalModAct').modal('show');
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

      function marcar_seridada(IdModulo,Valor) {
        var TipoGuardar = "marcar_materia_seriada";
        swal({
            title: "\u00BFEst\u00E1 seguro que desea realizar este proceso?",
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
                  url: "vistas/admin/guardar_datos.php",
                  method: "POST",
                  data: {
                    TipoGuardar: TipoGuardar,
                    IdModulo: IdModulo,
                    Valor: Valor
                  },
                  success: function(data) {

                  }
                })
                .done(function(data) {
                  if (data == 1) {
                    swal("Actualizado correctamente", "El proceso se ha ejecutado correctamente.", "success");
                    $.ajax({
                      url: "vistas/admin/actualiza_materia_id.php",
                      method: "POST",
                      data: {
                        IdModulo: IdModulo
                      },
                      success: function(data) {
                        $('#employee_detailModAct').html(data);
                        $('#dataModalModAct').modal('show');
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
  </body>

  </html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>