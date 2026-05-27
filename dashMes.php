<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<?php
session_start();


require('php/clases/class.php');
$t=new Trabajo();
echo $_GET["Id"]; 
// $IdUsua =  $_SESSION["IdUsua"];
//if($_GET['Tipo'] == 'cargarMes'){
  //$comentarios = $consultas->get_comentarios($IdBlog);

  ?>
<div  id="getMovSalida">
  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Ingresos en el día</th>
                        </tr>
                      </thead>
                      <tbody>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-15" style=" cursor: pointer;">
                          <th>
                            Jueves, 15 de ago del 2019                          </th>
                          <td>19</td>
                        </tr>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-16" style=" cursor: pointer;">
                          <th>
                            Viernes, 16 de ago del 2019                          </th>
                          <td>7</td>
                        </tr>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-19" style=" cursor: pointer;">
                          <th>
                            Lunes, 19 de ago del 2019                          </th>
                          <td>22</td>
                        </tr>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-20" style=" cursor: pointer;">
                          <th>
                            Martes, 20 de ago del 2019                          </th>
                          <td>20</td>
                        </tr>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-21" style=" cursor: pointer;">
                          <th>
                            Miércoles, 21 de ago del 2019                          </th>
                          <td>2</td>
                        </tr>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-23" style=" cursor: pointer;">
                          <th>
                            Viernes, 23 de ago del 2019                          </th>
                          <td>11</td>
                        </tr>
                                                <tr class="view_data" href="javascript:void(0);" name="view" value="view" id="2019-08-26" style=" cursor: pointer;">
                          <th>
                            Lunes, 26 de ago del 2019                          </th>
                          <td>3</td>
                        </tr>
                                              </tbody>
                    </table>
                  </div>




  <?php

//}
 ?>

 <script>
   // var Tipo = document.getElementById("Tipo").value;
   // var Mes = document.getElementById("Mes").value;
   Highcharts.chart('container', {
     data: {
       table: 'datatable'
     },
     chart: {
       type: 'line'
     },
     title: {
       text: 'Gráfica de ingresos en la plataforma del mes de '
     },
     yAxis: {
       allowDecimals: false,
       title: {
         text: 'Ingresos'
       }
     }
   });
 </script>
