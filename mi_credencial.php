<!DOCTYPE html>
<html>

<head>
    <meta name="robots" content="noindex">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Validación de Credencial</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">
</head>

<body class="hold-transition">
  <input type="hidden" name="idToks" id="idToks" value="<?php if (isset($_GET['idToks'])) {echo $_GET['idToks']; } ?>">
  <div id="_no_disponible" style="display: none;">
    <p style="text-align: center;">
      <img src="assets/images/campus/buscando.gif" style="width: 400px;">
    </p>

  </div>

  <div id="data_credencial" class="modal fade">
    <div class="modal-dialog modal-sm">
    <div class="modal-content" style="width: 350px !important; height: 517px !important; margin: 0 auto;">
        <div class="modal-body" id="employee_credencial">
        </div>
      </div>
    </div>
  </div>

  <script src="bower_components/jquery/dist/jquery.min.js"></script>

  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      var idToks = document.getElementById("idToks").value;
      if (idToks) {
        document.getElementById("_no_disponible").style.display = 'none';
        $.ajax({
          url: "vistas/alumno/mi_credencial_alumno.php",
          method: "POST",
          data: {
            idToks: idToks
          },
          success: function(data) {
            $('#employee_credencial').html(data);
            $('#data_credencial').modal('show');
          }
        });
      } else {
        document.getElementById("_no_disponible").style.display = 'block';
      }

    })
  </script>
</body>

</html>