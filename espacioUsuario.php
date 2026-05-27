<?php $section = "Mis espacio";
include("head.php");
$var = 1;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en Mis espacio');
}

$datosUser = $t->get_docente_id($_SESSION['IdUsua']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa-fw fa-bell"></i> Mi espacio</h1>
        <ol class="breadcrumb">
          <li><a href="espacioUsuario.php"><i class="fa fa-bell"></i> Mi espacio</a></li>
        </ol>
      </section>

      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioDocente.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">
                <section class="ms-page">
                  <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden" />
                  <!-- Card: Perfil -->
                  <article class="ms-card">
                    <header class="ms-banner" style="background: #<?php echo $configuracion[34]['Descripcion']; ?>;">
                      <div class="ms-banner-left">
                        <div class="ms-avatar" aria-hidden="true">
                          <span class="ms-avatar-ring"></span>
                          <span class="ms-avatar-ico">👤</span>
                        </div>

                        <div class="ms-user">
                          <div class="ms-user-name"><?php echo $datosUser[0]["NombreUser"]; ?> <?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></div>
                          <div class="ms-user-role">DOCENTE</div>
                        </div>
                      </div>
                    </header>

                    <div class="ms-body">
                      <ul class="ms-info">
                        <li class="ms-info-row">
                          <span class="ms-info-ico" aria-hidden="true">🏛️</span>
                          <span class="ms-info-text"><?php echo $datosUser[0]["Campus"]; ?></span>
                          <span class="ms-info-right">📞 <b><?php if (isset($datosUser[0]["Celular"])) {
                                                              echo $datosUser[0]["Celular"];
                                                            } else {
                                                              echo "- - -";
                                                            } ?></b></span>
                        </li>

                        <li class="ms-info-row">
                          <span class="ms-info-ico" aria-hidden="true">✉️</span>
                          <span class="ms-info-text"><?php if (isset($datosUser[0]["Correo"])) {
                                                        echo $datosUser[0]["Correo"];
                                                      } else {
                                                        echo "- - -";
                                                      } ?></span>
                          <span class="ms-info-right"><?php if (isset($datosUser[0]["FecNac"])) {
                                                        echo $datosUser[0]["FecNac"];
                                                      } else {
                                                        echo "- - -";
                                                      } ?></span>
                        </li>
                      </ul>
                    </div>
                    <hr>

                    <?php
                    $chkHra = $t->get_chkHorarioDoc($_SESSION["IdUsua"]);
                    ?>
                    <div class="paytabs-header">

                      <div class="paytabs-title-area">
                        <div class="paytabs-icon">💳</div>
                        <div>
                          <div class="paytabs-title">Mi horario de clases</div>
                          <div class="paytabs-sub">Mi horario de clases activo </div>
                        </div>
                      </div>
                    </div>
                    <table class="docs-table" aria-label="Documentos en revisión">
                      <thead>
                        <tr>
                          <th>Nivel</th>
                          <th>Materia</th>
                          <th>Grupo</th>
                          <th style="text-align: center;">Lun</th>
                          <th style="text-align: center;">Mar</th>
                          <th style="text-align: center;">Mié</th>
                          <th style="text-align: center;">Jue</th>
                          <th style="text-align: center;">Vie</th>
                          <th style="text-align: center;">Sáb</th>
                          <th style="text-align: center;">Dom</th>
                        </tr>
                      </thead>
                      <?php for ($h = 0; $h < sizeof($chkHra); $h++) {
                        $chHra = $t->get_chkHor($chkHra[$h]['IdAsignacion']);
                        $chHraActiva1 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 1);
                        $chHraActiva2 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 2);
                        $chHraActiva3 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 3);
                        $chHraActiva4 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 4);
                        $chHraActiva5 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 5);
                        $chHraActiva6 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 6);
                        $chHraActiva7 = $t->get_chkHor_activa($chkHra[$h]['IdAsignacion'], 7);
                      ?>
                        <tr style="font-size: 12px;">
                          <td><?php echo $chkHra[$h]['_Grado']; ?></td>
                          <td><?php echo $chkHra[$h]['NombreMod']; ?></td>
                          <td><?php echo $chkHra[$h]['Grado']; ?> ❝<?php echo $chkHra[$h]['Grupo']; ?>❞</td>
                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva1[0]['IdDia'])) && ($chHraActiva1[0]['IdDia'] == 1)) {
                              echo $chHraActiva1[0]['HraIni'] . ':' . $chHraActiva1[0]['MinIni'] . '-' . $chHraActiva1[0]['HraFin'] . ':' . $chHraActiva1[0]['MinFin'];
                              if (isset($chHraActiva1[1]['Total'])) {
                                echo '<br>' . $chHraActiva1[1]['HraIni'] . ':' . $chHraActiva1[1]['MinIni'] . '-' . $chHraActiva1[1]['HraFin'] . ':' . $chHraActiva1[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>

                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva2[0]['IdDia'])) && ($chHraActiva2[0]['IdDia'] == 2)) {
                              echo $chHraActiva2[0]['HraIni'] . ':' . $chHraActiva2[0]['MinIni'] . '-' . $chHraActiva2[0]['HraFin'] . ':' . $chHraActiva2[0]['MinFin'];
                              if (isset($chHraActiva2[1]['Total'])) {
                                echo '<br>' . $chHraActiva2[1]['HraIni'] . ':' . $chHraActiva2[1]['MinIni'] . '-' . $chHraActiva2[1]['HraFin'] . ':' . $chHraActiva2[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>

                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva3[0]['IdDia'])) && ($chHraActiva3[0]['IdDia'] == 3)) {
                              echo $chHraActiva3[0]['HraIni'] . ':' . $chHraActiva3[0]['MinIni'] . '-' . $chHraActiva3[0]['HraFin'] . ':' . $chHraActiva3[0]['MinFin'];
                              if (isset($chHraActiva3[1]['Total'])) {
                                echo '<br>' . $chHraActiva3[1]['HraIni'] . ':' . $chHraActiva3[1]['MinIni'] . '-' . $chHraActiva3[1]['HraFin'] . ':' . $chHraActiva3[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>

                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva4[0]['IdDia'])) && ($chHraActiva4[0]['IdDia'] == 4)) {
                              echo $chHraActiva4[0]['HraIni'] . ':' . $chHraActiva4[0]['MinIni'] . '-' . $chHraActiva4[0]['HraFin'] . ':' . $chHraActiva4[0]['MinFin'];
                              if (isset($chHraActiva4[1]['Total'])) {
                                echo '<br>' . $chHraActiva4[1]['HraIni'] . ':' . $chHraActiva4[1]['MinIni'] . '-' . $chHraActiva4[1]['HraFin'] . ':' . $chHraActiva4[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>

                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva5[0]['IdDia'])) && ($chHraActiva5[0]['IdDia'] == 5)) {
                              echo $chHraActiva5[0]['HraIni'] . ':' . $chHraActiva5[0]['MinIni'] . '-' . $chHraActiva5[0]['HraFin'] . ':' . $chHraActiva5[0]['MinFin'];
                              if (isset($chHraActiva5[1]['Total'])) {
                                echo '<br>' . $chHraActiva5[1]['HraIni'] . ':' . $chHraActiva5[1]['MinIni'] . '-' . $chHraActiva5[1]['HraFin'] . ':' . $chHraActiva5[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>
                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva6[0]['IdDia'])) && ($chHraActiva6[0]['IdDia'] == 6)) {
                              echo $chHraActiva6[0]['HraIni'] . ':' . $chHraActiva6[0]['MinIni'] . '-' . $chHraActiva6[0]['HraFin'] . ':' . $chHraActiva6[0]['MinFin'];
                              if (isset($chHraActiva6[1]['Total'])) {
                                echo '<br>' . $chHraActiva6[1]['HraIni'] . ':' . $chHraActiva6[1]['MinIni'] . '-' . $chHraActiva6[1]['HraFin'] . ':' . $chHraActiva6[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>
                          <td style="text-align: center;">
                            <?php if ((isset($chHraActiva7[0]['IdDia'])) && ($chHraActiva7[0]['IdDia'] == 7)) {
                              echo $chHraActiva7[0]['HraIni'] . ':' . $chHraActiva7[0]['MinIni'] . '-' . $chHraActiva7[0]['HraFin'] . ':' . $chHraActiva7[0]['MinFin'];
                              if (isset($chHraActiva7[1]['Total'])) {
                                echo '<br>' . $chHraActiva7[1]['HraIni'] . ':' . $chHraActiva7[1]['MinIni'] . '-' . $chHraActiva7[1]['HraFin'] . ':' . $chHraActiva7[1]['MinFin'];
                              }
                            } else {
                              echo '-';
                            } ?>
                          </td>
                        </tr>
                      <?php } ?>

                    </table>

                    <hr>

                    <div class="paytabs-header">

                      <div class="paytabs-title-area">
                        <div class="paytabs-icon">💳</div>
                        <div>
                          <div class="paytabs-title">Nivel de estudios alcanzado</div>
                          <div class="paytabs-sub">Mi nivel de estudios </div>
                        </div>
                      </div>
                    </div>
                    <div id="panel_docente"></div>



                  </article>
                </section>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>

    <div id="dataModalViewPc" class="modal fade"> <!--MODAL ME GUSTA-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-user"></i> Mi semblanza</h4>
          </div>
          <div class="modal-body" id="employee_detailViewPc">
          </div>
        </div>
      </div>
    </div>

    <div id="data_grad" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Grado de estudio</h4>
          </div>

          <div class="modal-body" id="employee_grad">
          </div>
        </div>
      </div>
    </div>

    <div id="data_grad_u" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Actualizar documento del grado de estudio</h4>
          </div>

          <div class="modal-body" id="employee_grad_u">
          </div>
        </div>
      </div>
    </div>

    <div id="dataDocsx" class="modal fade"> <!--MODAL ME GUSTA-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-file"></i> <b id="_pre"></b></h4>
          </div>
          <div class="modal-body" id="employee_docsx">
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

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page script -->

  <script>
    $(document).ready(function() {
      var IdUsua = document.getElementById("IdUsua").value;
      datos_docente(IdUsua);
    });

    function datos_docente(IdUsua) {
      var Capa = "#panel_docente";
      $(Capa).load("dashboard/datos_docente.php", {
        IdUsua: IdUsua
      }, function(response, status, xhr) {
        if (status == "error") {
          alert(status);
          var msg = "Error!, algo ha sucedido: ";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    }


    function viewSemblanza() {
      var IdUsua = document.getElementById("IdUsua").value;

      $.ajax({
        url: "formConsulta/addSemblanza.php",
        method: "POST",
        data: {
          IdUsua: IdUsua
        },
        success: function(data) {
          $('#employee_detailViewPc').html(data);
          $('#dataModalViewPc').modal('show');
        }
      });
    }

    function viewGrados(IdUsua) {
      var IdGrado = 0;
      $.ajax({
        url: "formConsulta/addGrado.php",
        method: "POST",
        data: {
          IdUsua: IdUsua,
          IdGrado: IdGrado
        },
        success: function(data) {
          $('#employee_grad').html(data);
          $('#data_grad').modal('show');
        }
      });
    }

    function aplicar_n(IdUsua, IdNivel, Valor) {
      var TipoGuardar = "sav_nivel_class";
      $.ajax({
        url: "formConsulta/setting.php",
        method: "POST",
        data: {
          TipoGuardar: TipoGuardar,
          IdUsua: IdUsua,
          IdNivel: IdNivel,
          Valor: Valor
        },
        success: function(data) {
          datos_docente(IdUsua);
        }
      })
    }

    function ver_docs_docente(IdDocs) {
      $.ajax({
        url: "dashboard/ver_documento_asesor.php",
        method: "POST",
        data: {
          IdDocs: IdDocs
        },
        success: function(data) {
          $('#employee_docsx').html(data);
          $('#dataDocsx').modal('show');
        }
      });
    }

    function del_docsx(Code, IdUsua) {

      var TipoGuardar = "del_docs_doce";
      swal({
          title: "\u00BFEst\u00E1 seguro que desea eliminar estos datos del nivel académico?",
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
                  Code: Code,
                  IdUsua: IdUsua
                },
                success: function(data) {


                }
              })
              .done(function(data) {
                if (data == 1) {
                  swal("Elimado correctamente", "Los datos del nivel se han eliminado correctamente.", "success");
                  datos_docente(IdUsua);
                }

                if (data == 0) {
                  swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
                }
              })
              .error(function(data) {
                swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
              });
          }

        });
    }

    function subir_docs_dox(IdDocDocente, Tipo) {
      $.ajax({
        url: "formConsulta/upd_grado.php",
        method: "POST",
        data: {
          IdDocDocente: IdDocDocente,
          Tipo: Tipo
        },
        success: function(data) {
          $('#employee_grad_u').html(data);
          $('#data_grad_u').modal('show');
        }
      });
    }
  </script>
</body>

</html>