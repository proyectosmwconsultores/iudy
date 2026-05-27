<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = substr($_POST["token"], 10,10);

  $sql1 = $db->query("SELECT * FROM tblc_dia");

  ?>
  <form name="frm5hb" id="frm5hb" action="materiaAvance.php" method="POST" enctype="multipart/form-data">

  <div class="table-responsive">
    <div class="col-md-12">
      <table class="table table-striped">
            <tbody><tr>
              <th style="width: 10px">Ajuste</th>
              <th>Días</th>
            </tr>
            <?php while($x = $db->recorrer($sql1)){ $IdDia = $x["IdDia"];

              $sql9 = $db->query("SELECT tblk_diasasesor.IdDiasA  FROM tblk_diasasesor WHERE tblk_diasasesor.IdDia = '$IdDia' AND tblk_diasasesor.IdUsua = '$IdUsua'");
              $db->rows($sql9);
              $datos91 = $db->recorrer($sql9);
              $rwIdDia = $datos91["IdDiasA"];
               ?>
            <tr>
              <td>
                <?php if($rwIdDia){ ?>
                <button type="button" class="btn btn-info" onclick="addDiaA(<?php echo $x["IdDia"]; ?>,0,<?php echo $IdUsua; ?>)"><i class="fa fa-fw fa-check-circle"></i> </button></td>
              <?php } else { ?>
                <button type="button" class="btn btn-danger" onclick="addDiaA(<?php echo $x["IdDia"]; ?>,1,<?php echo $IdUsua; ?>)"><i class="fa fa-fw fa-times-circle"></i> </button></td>
                <?php } ?>
              <td><?php echo $x["Dia"]; ?></td>

            </tr>
            <?php } ?>
          </tbody></table>
    </div>
  </div>

  </form>
  <script>
    function addDiaA(IdDia, Valor, IdUsua){
      var TipoGuardar = "addHoraA";
      var token = "8945874125"+IdUsua;
      $.ajax({
           url:"formConsulta/setting.php",
           method:"POST",
           data:{TipoGuardar:TipoGuardar, IdDia:IdDia, Valor:Valor, IdUsua:IdUsua},
           success:function(data){
             $.ajax({
                 url:"formConsulta/asesorDias.php",
                 method:"POST",
                 data:{token:token},
                 success:function(data){
                      $('#employee_Dia').html(data);
                      $('#dataDia').modal('show');
                 }
            });

           }
      })
    }
  </script>
