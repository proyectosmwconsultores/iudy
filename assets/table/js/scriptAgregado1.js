$(document).ready(function(){
  var Universidad = document.getElementById("Universidad").value;
  var Nombre = "Plataforma de Educación en Línea";
  var Logo = document.getElementById("Logo").value;
  var Numero = document.getElementById("Numero").value;
  var valor = ""; var tipoDoc = "";
  if(Numero == 1){
    tipoDoc = "landscape";
    var Tipo = document.getElementById("txtClaveGrp").value;
      if(Tipo) { valor = Universidad + " \n Lista del grupo"; } else { valor = Universidad + " \n Lista de todos los alumnos"; }
  }
  if(Numero == 2){
      valor = Universidad + " \n Lista de todos los docentes";
  }
  if(Numero == 3){
    tipoDoc = "landscape";
      valor = Universidad + " \n Lista de todos los docentes";
  }
  if(Numero == 4){
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Reporte de historial  \n" + Nombre;
  }
  if(Numero == 5){
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Reporte de documentos solicitados  \n" + Nombre;
  }
  if(Numero == 6){
    tipoDoc = "landscape";
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Reporte de pagos";

  }
  if(Numero == 7){
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Reporte de bajas";
  }
  if(Numero == 8){
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Kardex de calificaciones";
  }
  if(Numero == 9){
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Lista de matrículas";
  }
  if(Numero == 16){
    tipoDoc = "landscape";
    var Nombre = document.getElementById("Nombre").value;
      valor = Universidad + " \n Reporte de pagos";
    var Oferta = document.getElementById("Oferta").value;
    var Nombre = Nombre + '  \n '+Oferta;
  }
  $('#example').DataTable({
      pageLength: 50,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: [
          { extend: 'copy',text: '<i class="fa fa-fw fa-copy"></i> COPIAR'},
          {
            extend: 'excel',
            text: '<i class="fa fa-download"></i> EXCEL',
            title: Nombre,  message: valor,
          },
          {
            extend: 'pdf',
            pageSize: 'A4',
            orientation: tipoDoc,
            title: Nombre,  message: valor,
            messageTop: 'Reporte',
            text: '<i class="fa fa-download"></i> PDF',
            customize: function ( doc ) {
              doc.content.splice( 1, 0, {
                  margin: [ 0, -50, 0, 12 ],
                  alignment: 'left',
                  image: 'data:image/png;base64,'+ Logo
              } );

              var objFooter = {};
              objFooter['alignment'] = 'center';
              doc["footer"] = function(currentPage, pageCount) {
                  var footer = [
                      {
                          text: Nombre,
                          alignment: 'left',
                          color: 'red',
                          margin:[15, 15, 0, 15]
                      },{
                          text: 'Página ' + currentPage + ' de ' + pageCount,
                          alignment: 'center',
                          color: 'blue',
                          margin:[0, 15, 0, 15]
                      },{
                          text: '',
                          alignment: 'center',
                          color: 'blue',
                          margin:[0, 15, 15, 15]
                      }
                  ];
                  objFooter['columns'] = footer;
                  return objFooter;
              };
            }
          },
      ]
  });
});
