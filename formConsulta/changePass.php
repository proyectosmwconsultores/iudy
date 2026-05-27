<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
?>

<form name="frm2srA" id="frm2srA" action="changePass.php" method="POST">
  <input id="IdUsuaXL" name="IdUsuaXL" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
  <input id="TipoGuardar" name="TipoGuardar" value="changePass" type="hidden" />
  <input type="hidden" name="txtAnterior" id="txtAnterior" value="x">

  <div class="box-body">
    <div class="form-group">
      <label>Nueva contraseña:</label>

      <div style="position:relative;">
        <input
          type="password"
          id="txtNueva"
          name="txtNueva"
          class="form-control"
          autocomplete="new-password"
          style="padding-right:42px;"
        >

        <span
          id="togglePassword"
          style="position:absolute; right:12px; top:50%; transform:translateY(-50%);
                 cursor:pointer; font-size:16px; user-select:none;"
          aria-label="Mostrar u ocultar contraseña"
          title="Mostrar/Ocultar"
        >👁</span>
      </div>

      <div id="passwordRules" style="margin-top:10px;font-size:13px;font-weight:600;">
        <div id="ruleLength" data-label="Mínimo 8 caracteres">❌ Mínimo 8 caracteres</div>
        <div id="ruleUpper"  data-label="Al menos 1 mayúscula">❌ Al menos 1 mayúscula</div>
        <div id="ruleNumber" data-label="Al menos 1 número">❌ Al menos 1 número</div>
        <div id="ruleNoSpace" data-label="Sin espacios">❌ Sin espacios</div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
    <button type="button" id="btnSubmit" class="btn btn-primary" disabled onclick="change_pass_new()">
      Cambiar contraseña
    </button>
  </div>
</form>

<script>
(function () {
  const input = document.getElementById("txtNueva");
  const btn   = document.getElementById("btnSubmit");
  const eye   = document.getElementById("togglePassword");

  if (!input || !btn) return;

  // evita doble init si tu modal se vuelve a inyectar
  if (input.dataset.init === "1") return;
  input.dataset.init = "1";

  const ruleLength  = document.getElementById("ruleLength");
  const ruleUpper   = document.getElementById("ruleUpper");
  const ruleNumber  = document.getElementById("ruleNumber");
  const ruleNoSpace = document.getElementById("ruleNoSpace");

  function setRule(el, ok) {
    if (!el) return;
    const label = el.getAttribute("data-label") || el.textContent.replace(/[✅❌]\s*/, "");
    el.textContent = (ok ? "✅ " : "❌ ") + label;
    el.style.color = ok ? "#16a34a" : "#dc2626";
  }

  function validate() {
    // Quitar espacios (escritura y pegado)
    const cleaned = input.value.replace(/\s+/g, "");
    if (cleaned !== input.value) input.value = cleaned;

    const v = input.value;

    const hasLength  = v.length >= 8;
    const hasUpper   = /[A-Z]/.test(v);
    const hasNumber  = /\d/.test(v);
    const hasNoSpace = !/\s/.test(v);

    setRule(ruleLength,  hasLength);
    setRule(ruleUpper,   hasUpper);
    setRule(ruleNumber,  hasNumber);
    setRule(ruleNoSpace, hasNoSpace);

    const ok = hasLength && hasUpper && hasNumber && hasNoSpace;

    btn.disabled = !ok;

    if (v.length === 0) {
      input.style.borderColor = "";
      input.style.boxShadow = "";
    } else {
      input.style.borderColor = ok ? "#16a34a" : "#dc2626";
      input.style.boxShadow = ok
        ? "0 0 0 3px rgba(22,163,74,.12)"
        : "0 0 0 3px rgba(220,38,38,.10)";
    }

    return ok;
  }

  // Validación en tiempo real
  input.addEventListener("input", validate);

  // Mostrar / ocultar
  if (eye) {
    eye.addEventListener("click", function () {
      const isPass = input.type === "password";
      input.type = isPass ? "text" : "password";
      eye.textContent = isPass ? "🙈" : "👁";
      input.focus();
    });
  }

  // Función del botón: solo envía si es válido
  window.change_pass_new = function () {
    if (!validate()) return;
    

    

    var IdUsuaXL = document.getElementById("IdUsuaXL").value;
    var Anterior = document.getElementById("txtAnterior").value;
    var Nueva = document.getElementById("txtNueva").value;

    if (Anterior == '') {
        swal("Error al actualizar", "Debe escribir la contraseña actual.", "error");
        document.getElementById("txtAnterior").focus();
        return 0;
    }

    if (Nueva == '') {
        swal("Error al actualizar", "Debe escribir su nueva contraseña.", "error");
        document.getElementById("txtNueva").focus();
        return 0;
    }

    var TipoGuardar = "changePass";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea actualizar su contraseña?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
    },
        function (isConfirm) {
            if (isConfirm) {
                $(".confirm").attr('disabled', 'disabled');
                //  var datos=$('#frm2srA').serialize();
                var datos = 'TipoGuardar=' + TipoGuardar + '&IdUsuaXL=' + IdUsuaXL + '&Anterior=' + Anterior + '&Nueva=' + Nueva;
                $.ajax({
                    type: "POST",
                    url: "insertar.php",
                    data: datos,
                    success: function (data) {

                    }
                })
                    .done(function (data) {
                        if (data == 1) {
                            swal("Actualizado correctamente", "La contraseña se ha actualizado correctamente.", "success");

                        }
                        if (data == 2) {
                            swal("Error al actualizar", "Los datos no coinciden con su usuario.", "error");
                            //  parent.location.href='doMiPlaneacion.php?tok='+IdParcialDoc;
                        }
                        if (data == 0) {
                            swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
                        }
                    })
                    .error(function (data) {
                        swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
                    });
            }

        });
  };

  // init
  validate();
})();
</script>