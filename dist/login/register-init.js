$(function() {

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	var Valor = document.getElementById("val").value;
	var valc = document.getElementById("valc").value;

	// if(valc == 1){
	// 	document.getElementById("val").value = 1;
	// 	document.getElementById("txtEmail").focus();
	// 	return 0;
	//
	// }
// alert(valc);
	if(Valor == 1){
		var Code = document.getElementById("txtCode").value;
		var Email = document.getElementById("txtEmail").value;
		var Total = Code.length;

		if (Code==''){
		swal("Error al guardar", "Debe ingresar el código generado por el docente.", "error");
				document.getElementById("txtCode").focus();
				return 0;
		}

		if (Email==''){
		swal("Error al guardar", "Debe ingresar su correo electrónico.", "error");
				document.getElementById("txtEmail").focus();
				return 0;
		}
		if(valc == 2){
				document.getElementById("val").value = 2;
		}


	}

	if(Valor == 2){
		var Nombre = document.getElementById("txtNombre").value;
		var Paterno = document.getElementById("txtPaterno").value;
		var Materno = document.getElementById("txtMaterno").value;

		if (Nombre==''){
		swal("Error al guardar", "Debe escribir su nombre.", "error");
				document.getElementById("txtNombre").focus();
				return 0;
		}
		if (Paterno==''){
		swal("Error al guardar", "Debe escribir su apellido paterno.", "error");
				document.getElementById("txtPaterno").focus();
				return 0;
		}
		if (Materno==''){
		swal("Error al guardar", "Debe escribir su apellido materno.", "error");
				document.getElementById("txtMaterno").focus();
				return 0;
		}
		document.getElementById("val").value = 3;
	}

	if(Valor == 3){
		var Telefono = document.getElementById("txtTelefono").value;
		var Sexo = document.getElementById("txtSexo").value;

		if (Telefono==''){
		swal("Error al guardar", "Debe escribir su número de teléfono.", "error");
				document.getElementById("txtTelefono").focus();
				return 0;
		}
		if (Sexo==''){
		swal("Error al guardar", "Debe seleccionar su sexo.", "error");
				document.getElementById("txtSexo").focus();
				return 0;
		}

	}


	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	next_fs = $(this).parent().next();

	//activate next step on progressbar using the index of next_fs
	$("#eliteregister li").eq($("fieldset").index(next_fs)).addClass("active");

	//show the next fieldset
	next_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	var Valor = document.getElementById("val").value;
	var Numero = (Valor - 1);
	document.getElementById("val").value = Numero;
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();

	//de-activate current step on progressbar
	$("#eliteregister li").eq($("fieldset").index(current_fs)).removeClass("active");

	//show the previous fieldset
	previous_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	var Telefono = document.getElementById("txtTelefono").value;
	var Sexo = document.getElementById("txtSexo").value;

	if (Telefono==''){
	swal("Error al guardar", "Debe escribir su número de teléfono.", "error");
			document.getElementById("txtTelefono").focus();
			return 0;
	}
	if (Sexo==''){
	swal("Error al guardar", "Debe seleccionar su sexo.", "error");
			document.getElementById("txtSexo").focus();
			return 0;
	}

	var Code = document.getElementById("txtCode").value;
	var Email = document.getElementById("txtEmail").value;
	var Nombre = document.getElementById("txtNombre").value;
	var Paterno = document.getElementById("txtPaterno").value;
	var Materno = document.getElementById("txtMaterno").value;

		var TipoGuardar = "registroUserx";
		swal({
			title: "\u00BFEst\u00E1 seguro que desea registrarse en la Plataforma?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
		},
		function (isConfirm) {
			if (isConfirm) {
				document.getElementById("btn_1").style.display = 'none';
				document.getElementById("btn_2").style.display = 'none';
				document.getElementById("div_img").style.display = 'block';
				$(".confirm").attr('disabled', 'disabled');
				$.ajax({
		         url:"formConsulta/setting_registro_crm.php",
		         method:"POST",
		         data:{TipoGuardar:TipoGuardar, Code:Code, Email:Email, Nombre:Nombre, Paterno:Paterno, Materno:Materno, Telefono:Telefono, Sexo:Sexo},
		         success:function(data){


		         }
		    })
				.done(function(data) {
					if(data==1){
						swal("Error al registrarse", "El código ingresado no existe, no se puede registrar.", "error");
					}
					if(data==2){
						swal("Error al registrase", "Usted ya esta dado de alta con este código.", "error");
					}
					if(data==3){
						swal("Registrado correctamente", "Su registro se ha realizado con éxito.", "success");
						parent.location.href='index.php?x=5';
					}
					if(data==4){
						document.getElementById("div_img").style.display = 'none';
						swal("Error al registrase", "No se puede registrar ya que el docente no tiene espacio, favor de comunicarse con su docente.", "error");
					}
				})
				.error(function(data) {
					swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
				});
			}

		});

})

});
