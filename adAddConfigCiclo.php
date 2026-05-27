<?php $valor = 1;
$section = "Configurar Periodo Escolar";
include("head.php");
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está por configurar ciclo escolar');
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <i class="fa fa-fw fa-gears"></i> Configurar periodo escolar a grupo
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-book"></i> Periodo escolar</a></li>
          <li class="active">Grupo</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
          <div class="box-body">
            <div class="row">
              <form name="frm" id="frm" action="adAddConfigCiclo.php" method="POST" enctype="multipart/form-data">
                <input id="TipoGuardar" name="TipoGuardar" value="addEnlazar" type="hidden" />
                <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden" />

                <div id="panel_alumnos_lista"></div>

                <div class="col-md-2">
                  <div class="box-primary">
                    <div class="box-body">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="input-group">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </form>
              <br>
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <div id="dataGra" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Alumnos que se sean migrar</h4>
            </div>
            <div class="modal-body" id="employee_Gra">
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

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

  <script>
    $(document).ready(function() {
      load_list_grp();
    })

    function load_list_grp() {
      var IdCiclo = 0;
      var IdCampus = 0;
      document.getElementById("panel_alumnos_lista").style.display = 'block';
      var Capa = "#panel_alumnos_lista";
      $(Capa).load("dashboard/rep_enlazar_grupo.php", {
        IdCiclo: IdCiclo,
        IdCampus:IdCampus
      }, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    }

    function sel_ciclo_es(IdCampus) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      document.getElementById("panel_alumnos_lista").style.display = 'block';
      var Capa = "#panel_alumnos_lista";
      $(Capa).load("dashboard/rep_enlazar_grupo.php", {
        IdCiclo: IdCiclo,
        IdCampus:IdCampus
      }, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    }

    function sel_campus_es(IdCiclo) {
      var IdCampus = document.getElementById("txtCampus").value;
      document.getElementById("panel_alumnos_lista").style.display = 'block';
      var Capa = "#panel_alumnos_lista";
      $(Capa).load("dashboard/rep_enlazar_grupo.php", {
        IdCiclo: IdCiclo,
        IdCampus:IdCampus
      }, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    } 

    function mostrar_lista_migrado(IdCiclo, IdCampus){
      document.getElementById("panel_alumnos_lista").style.display = 'block';
      var Capa = "#panel_alumnos_lista";
      $(Capa).load("dashboard/rep_enlazar_grupo.php", {
        IdCiclo: IdCiclo,
        IdCampus:IdCampus
      }, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    }


    function enlazar_grpx(IdGrupo, Grado) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      // var IdGrupo = document.getElementById("txtGrupo").value;
      var TipoGuardar = 'sav_enlaza_grp';
      if (IdCiclo == '') {
        swal("Error al guardar", "Debe seleccionar el Periodo Escolar.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
      }
      if (IdGrupo == '') {
        swal("Error al guardar", "Debe seleccionar el grupo.", "error");
        document.getElementById("txtGrupo").focus();
        return 0;
      }

      swal({
        title: "\u00BFEst\u00E1 seguro que desea realizar la migración de estos alumnos al próximo periodo escolar?",
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
              url: "vistas/migracion/guardar_datos.php",
                method: "POST",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdCiclo: IdCiclo,
                  IdGrupo: IdGrupo,
                  Grado:Grado
                },
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Migrado correctamente", "Los alumnos han sido migrados correctamente.", "success");
                  var IdCiclo = document.getElementById("txtCiclo").value;
                  var IdCampus = document.getElementById("txtCampus").value;
                  mostrar_lista_migrado(IdCiclo,IdCampus);
                  $.ajax({
                    url: "vistas/migracion/lista_alumnos_migrar.php",
                    method: "POST",
                    data: {
                      IdGrupo: IdGrupo,
                      IdCiclo: IdCiclo
                    },
                    success: function(data) {
                      $('#employee_Gra').html(data);
                      $('#dataGra').modal('show');
                    }
                  });
                }
                if (data == 3) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración, costo de reinscripcion no identificado", "error");
                }
                if (data == 2) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración, costo de inscripcion no identificado", "error");
                }
                if (data == 0) {
                  swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar X01", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });
          }

        });
    }


    function enlazar_grpx_especial_id(IdUsua, IdGrupo, Grado) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      // var IdGrupo = document.getElementById("txtGrupo").value;
      var TipoGuardar = 'sav_enlaza_grp_especial_id';
      
      swal({
        title: "\u00BFEst\u00E1 seguro que desea realizar la migración de este alumnos al próximo periodo escolar?",
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
              url: "vistas/migracion/guardar_datos.php",
                method: "POST",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdCiclo: IdCiclo,
                  IdGrupo: IdGrupo,
                  Grado:Grado, IdUsua:IdUsua
                },
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Migrado correctamente", "El alumnos han sido migrados correctamente.", "success");
                  var IdCiclo = document.getElementById("txtCiclo").value;
                  var IdCampus = document.getElementById("txtCampus").value;
                  mostrar_lista_migrado(IdCiclo,IdCampus);
                  $.ajax({
                    url: "vistas/migracion/lista_alumnos_migrar.php",
                    method: "POST",
                    data: {
                      IdGrupo: IdGrupo,
                      IdCiclo: IdCiclo
                    },
                    success: function(data) {
                      $('#employee_Gra').html(data);
                      $('#dataGra').modal('show');
                    }
                  });
                }
                if (data == 3) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración, costo de reinscripcion no identificado", "error");
                }
                if (data == 2) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración, costo de inscripcion no identificado", "error");
                }
                if (data == 0) {
                  swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar X01", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });
          }

        });
    }

    function migrar_grupo_id(IdGrupo, Grado) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      var TipoGuardar = 'sav_enlaza_grp'; 
 
      swal({
          title: "\u00BFEst\u00E1 seguro que desea realizar la migración de estos alumnos al próximo periodo escolar?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
        },
        function(isConfirm) {
          if (isConfirm) {
            $(".confirm").attr('disabled', 'disabled');
            $.ajax({
                type: "POST",
                url: "vistas/migracion/guardar_datos.php",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdGrupo: IdGrupo,
                  IdCiclo: IdCiclo,
				          Grado:Grado

                },
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Migrado correctamente", "Los alumnos han sido migrados correctamente.", "success");
                  var IdCiclo = document.getElementById("txtCiclo").value;
                  var IdCampus = document.getElementById("txtCampus").value;
                  mostrar_lista_migrado(IdCiclo,IdCampus);
                  $.ajax({
                    url: "vistas/migracion/lista_alumnos_migrar.php",
                    method: "POST",
                    data: {
                      IdGrupo: IdGrupo,
                      IdCiclo: IdCiclo
                    },
                    success: function(data) {
                      $('#employee_Gra').html(data);
                      $('#dataGra').modal('show');
                    }
                  });
                }

                if (data == 2) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración.", "error");
                }
                if (data == 7) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración, costo de inscripcion no identificado", "error");
                }
                if (data == 8) {
                  swal("Error al migrar", "No se puede realizar el proceso de migración, costo de mensualidad no identificado", "error");
                }
                if (data == 0) {
                  swal("Error al generar", "No se puede migrar.", "error");
                }
              })
              .error(function(data) {
                swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
              });
          }

        });
    }

    function cargar_lista_alumnos(IdGrupo, Grado, Tipo) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      $.ajax({
        url: "vistas/migracion/lista_alumnos_migrar.php",
        method: "POST",
        data: {
          IdGrupo: IdGrupo,
          IdCiclo: IdCiclo,
          Tipo:Tipo
        },
        success: function(data) {
          $('#employee_Gra').html(data);
          $('#dataGra').modal('show');
        }
      });

    }

    function sel_alumno_id(IdActivo, IdGrupo, Valor) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      var TipoGuardar = "mover_estatus_alumno";
      var Tipo = 0;
      $.ajax({
        url: "vistas/migracion/guardar_datos.php",
        method: "POST",
        data: {
          TipoGuardar: TipoGuardar,
          IdActivo: IdActivo,
          Valor: Valor
        },
        success: function(data) {
          $.ajax({
            url: "vistas/migracion/lista_alumnos_migrar.php",
            method: "POST",
            data: {
              IdGrupo: IdGrupo,
              IdCiclo: IdCiclo,
              Tipo: Tipo
            },
            success: function(data) {
              $('#employee_Gra').html(data);
              $('#dataGra').modal('show');
            }
          });
        }
      })
    }


    function migrar_grupo(IdGrupo, Grado) {
      var IdCiclo = document.getElementById("txtCiclo").value;
      var IdCampus = document.getElementById("txtCampus").value;
      var TipoGuardar = 'sav_enlaza_grp';
      
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
                url: "formConsulta/setting.php",
                method: "POST",
                data: {
                  TipoGuardar: TipoGuardar,
                  IdCiclo: IdCiclo,
                  Grado: Grado,
                  IdGrupo: IdGrupo
                },
                success: function(data) {

                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Migrado correctamente", "El proceso de migración se ha realizado correctamente.", "success");
                  mostrar_lista_migrado(IdCiclo, IdCampus);
                }
                if (data == 2) {
                  swal("Error al migrar", "Las mensualidades del próximo periodo escolar no se han generado, favor de comunicarse con el área de administración.", "error");
                }
                if (data == 3) {
                  swal("Error al migrar", "El monto de la reinscripción del próximo periodo escolar no se han generado, favor de comunicarse con el área de administración.", "error");
                }
                if (data == 0) {
                  swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al guardar X01", "No se puede guardar, comuniquese con el desarrollador.", "error");
              });
          }

        });
    }
  </script>
</body>

</html>
<?php unset($_SESSION['Alerta']);
unset($_SESSION['Variable']); ?>