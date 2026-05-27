<?php
session_start();

if (isset($_SESSION['_idUsua'])) {



  require('php/clases/consulta_class.php');
  include('hace.php');
  $espacio = new Consultas();
  $trayectoria = $espacio->get_trayectoria_id($_SESSION['_idUsua']);
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IUDY - TRAYECTORIA ESTUDIANTIL</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">


    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script nonce="0ca980b8-3869-4534-be47-a1b9c58bebeb">
      (function(w, d) {
        ! function(j, k, l, m) {
          j[l] = j[l] || {};
          j[l].executed = [];
          j.zaraz = {
            deferred: [],
            listeners: []
          };
          j.zaraz.q = [];
          j.zaraz._f = function(n) {
            return function() {
              var o = Array.prototype.slice.call(arguments);
              j.zaraz.q.push({
                m: n,
                a: o
              })
            }
          };
          for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
          j.zaraz.init = () => {
            var q = k.getElementsByTagName(m)[0],
              r = k.createElement(m),
              s = k.getElementsByTagName("title")[0];
            s && (j[l].t = k.getElementsByTagName("title")[0].text);
            j[l].x = Math.random();
            j[l].w = j.screen.width;
            j[l].h = j.screen.height;
            j[l].j = j.innerHeight;
            j[l].e = j.innerWidth;
            j[l].l = j.location.href;
            j[l].r = k.referrer;
            j[l].k = j.screen.colorDepth;
            j[l].n = k.characterSet;
            j[l].o = (new Date).getTimezoneOffset();
            if (j.dataLayer)
              for (const w of Object.entries(Object.entries(dataLayer).reduce(((x, y) => ({
                  ...x[1],
                  ...y[1]
                })), {}))) zaraz.set(w[0], w[1], {
                scope: "page"
              });
            j[l].q = [];
            for (; j.zaraz.q.length;) {
              const z = j.zaraz.q.shift();
              j[l].q.push(z)
            }
            r.defer = !0;
            for (const A of [localStorage, sessionStorage]) Object.keys(A || {}).filter((C => C.startsWith("_zaraz_"))).forEach((B => {
              try {
                j[l]["z_" + B.slice(7)] = JSON.parse(A.getItem(B))
              } catch {
                j[l]["z_" + B.slice(7)] = A.getItem(B)
              }
            }));
            r.referrerPolicy = "origin";
            r.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(j[l])));
            q.parentNode.insertBefore(r, q)
          };
          ["complete", "interactive"].includes(k.readyState) ? zaraz.init() : j.addEventListener("DOMContentLoaded", zaraz.init)
        }(w, d, "zarazData", "script");
      })(window, document);
    </script>
  </head>

  <body class="hold-transition lockscreen">


    <section class="content">
      <div class="row">


        <div class="col-md-12">

          <?php if (isset($trayectoria[0])) { ?>
            <div class="nav-tabs-custom">
              <div class="box-header with-border">
                <h3 class="box-title">Espacio para poder visualizar mi proceso de titulación.</h3>
              </div>
              <div class="tab-content">

                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="assets/perfil/<?php echo $_SESSION['_foto']; ?>" alt="user image">
                  <span class="username">
                    <a href="#"><?php echo $_SESSION['_nombre']; ?> <?php echo $_SESSION['_apellido']; ?></a>
                  </span>
                  <span class="description">Alumno en estado de Graduado</span>
                </div><br>
                <div class="tab-pane active" id="timeline">

                  <ul class="timeline timeline-inverse">

                    <li class="time-label">
                      <span class="bg-red">
                        Trayectoria estudiantil
                      </span>
                    </li>

                    <?php for ($i = 0; $i < sizeof($trayectoria); $i++) { ?>
                      <li>
                        <i class="fa fa-envelope bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($trayectoria[$i]['FecCap']); ?></span>
                          <h3 class="timeline-header"><a href="#"><?php echo $trayectoria[$i]['Trayectoria']; ?></a></h3>
                          <div class="timeline-body">
                            <?php echo $trayectoria[$i]['Nota']; ?>
                          </div>
                          <div class="timeline-footer">
                            <?php if ($trayectoria[$i]['IdEstatus'] == 12) { ?>
                              <a class="btn btn-danger btn-xs"><i class="fa fa-fw fa-warning"></i> En proceso</a>
                            <?php } else { ?>
                              <a class="btn btn-primary btn-xs"><i class="fa fa-fw fa-check-circle"></i> Concluido</a>
                              <?php if ($trayectoria[$i]['Archivo']) { ?>
                                <a onclick="window.open('assets/docs/files/<?php echo $trayectoria[$i]['Anio']; ?>/<?php echo $trayectoria[$i]['Mes']; ?>/<?php echo $trayectoria[$i]['Archivo']; ?>','_blank')" class="btn btn-warning btn-xs"><i class="fa fa-fw fa-share-alt"></i> Evidencia</a>
                              <?php } ?>
                            <?php } ?>
                          </div>
                        </div>
                      </li>
                    <?php } ?>

                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                  </ul>
                </div>



              </div>

            </div>
          <?php } else { ?>
            <p style="text-align: center;">
              <img src="assets/images/iconos/not_found.gif" style="width: 30%;">
            </p>

          <?php } ?>

        </div>

      </div>

    </section>


    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>

  </html>
<?php } else {
  $_session = array();
  session_unset();
  session_destroy();
  unset($_SESSION['IdUsua']);
  header("Location: ./index.php");
} ?>