<?php
session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdU = $_SESSION["IdUsua"];
  $IdC = $_SESSION["IdCampus"];

  ?>
  <script>
  function showUserBuscar(str) {
    var IdCampus = document.getElementById("IdCampus").value;
    var IdUsua = document.getElementById("IdUsua").value;
    var soloActivos = !document.getElementById("toggleActivos").checked;
      if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
          return;
      } else {

          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("txtHint").innerHTML = this.responseText;
              }
          };
          xmlhttp.open("GET","getuser.php?Tipo=alumno&Buscar="+str+"&IdCampus="+IdCampus+"&IdUsua="+IdUsua + '&Estatus=' + soloActivos,true);
          xmlhttp.send();
      }
  }

  </script>
  
  <style>
  /* =========================
   Switch Activos / Todos
========================= */
  .search-switch {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 13px;
    font-weight: 800;
    color: #374151;
    float: right;
  }

  /* Switch contenedor */
  .switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 24px;
  }

  /* Ocultar checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* Track */
  .slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background-color: #e5e7eb;
    border-radius: 999px;
    transition: .25s ease;
    box-shadow: inset 0 0 0 1px #cbd5e1;
  }

  /* Thumb */
  .slider:before {
    content: "";
    position: absolute;
    height: 18px;
    width: 18px;
    left: 3px;
    top: 3px;
    background: #ffffff;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(0, 0, 0, .18);
    transition: .25s ease;
  }

  /* Checked */
  .switch input:checked+.slider {
    background-color: #7c366c;
  }

  .switch input:checked+.slider:before {
    transform: translateX(22px);
  }

  /* Labels */
  .switch-label {
    user-select: none;
  }

  /* Focus accesible */
  .switch input:focus+.slider {
    box-shadow: 0 0 0 3px rgba(124, 54, 108, .25);
  }
</style>

  <form name="frm2" id="frm2" action="buscarUsuario.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
<input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION["IdCampus"]; ?>" type="hidden"/>
  <div class="table-responsive">
    <table class="table table-bordered">
        <div class="search-switch">
      <span class="switch-label">Solo usuarios activos</span>
      <label class="switch">
        <input type="checkbox" id="toggleActivos">
        <span class="slider"></span>
      </label>
      <span class="switch-label">Todos</span>
    </div>
    
      <div class="box box-primary" style="border-top: none;">
        <div class="col-md-12">
          <div class="form-group">
            <label><br>La búqueda puede ser por nombre, apellidos, matrícula:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input autocomplete="off" class="form-control" id="txtBuscar" name="txtBuscar" placeholder="Escriba los datos del alumno" type="text" onKeyUp="showUserBuscar(this.value)">
            </div>
            <div class="box-body no-padding">
              <div id="txtHint"><br><br><b style=" text-align: center !mportant;">El desglose de la b&uacute;squeda se mostrar&aacute; aqu&iacute;...</b></div>
            </div>
          </div>
        </div>

      </div>
    </table>
  </div>

  </form>
<script>
function savCampus(IdCampus){
  var IdC = IdCampus.value;
  document.getElementById("IdCampus").value = IdC;
  var buscar = "";
  showUserBuscar(buscar);
  document.getElementById("txtBuscar").value = "";
}
</script>

<script>
  document.getElementById('toggleActivos').addEventListener('change', function () {
    var input = document.getElementById('txtBuscar'); // <-- faltaba esto
    var q = input.value || '';

    showUserBuscar(q);

    input.focus();
    input.setSelectionRange(input.value.length, input.value.length);
  });
</script>