<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	
	require_once'../portafolio.php';
	require_once'../hace_fecha.php';
	$t=new Imprimir();
	
	
	$IdAsignacion = $_GET["tokenId"];
	
	$IdEstatus = substr($IdAsignacion, 0, 1);
	$IdAsignacion = substr($IdAsignacion, 1, 50);
	
	
	$lst = $t->get_datos_docente_id($IdAsignacion);
	$contrato = $t->get_contrato_id($IdAsignacion);
	$hras = $t->get_horas_id($IdAsignacion);
	$mat = $t->get_materia_id($IdAsignacion);
	
	if($mat[0]['IdGrado'] == 1){ $area = "DOCTORADO"; }
	if($mat[0]['IdGrado'] == 2){ $area = "MAESTRÍA"; }
	if($mat[0]['IdGrado'] == 3){ $area = "LICENCIATURA"; }
	
	
function numero_letras_esok($num, $fem, $dec) {
   $matuni[2]  = "DOS";
   $matuni[3]  = "TRES";
   $matuni[4]  = "CUATRO";
   $matuni[5]  = "CINCO";
   $matuni[6]  = "SEIS";
   $matuni[7]  = "SIETE";
   $matuni[8]  = "OCHO";
   $matuni[9]  = "NUEVE";
   $matuni[10] = "DIEZ";
   $matuni[11] = "ONCE";
   $matuni[12] = "DOCE";
   $matuni[13] = "TRECE";
   $matuni[14] = "CATORCE";
   $matuni[15] = "QUINCE";
   $matuni[16] = "DIECISEIS";
   $matuni[17] = "DIECISIETE";
   $matuni[18] = "DIECIOCHO";
   $matuni[19] = "DIECINUEVE";
   $matuni[20] = "VEINTE";
   $matunisub[2] = "DOS";
   $matunisub[3] = "TRES";
   $matunisub[4] = "CUATRO";
   $matunisub[5] = "QUIN";
   $matunisub[6] = "SEIS";
   $matunisub[7] = "SETE";
   $matunisub[8] = "OCHO";
   $matunisub[9] = "NOVE";

   $matdec[2] = "VEINT";
   $matdec[3] = "TREINTA";
   $matdec[4] = "CUARENTA";
   $matdec[5] = "CINCUENTA";
   $matdec[6] = "SESENTA";
   $matdec[7] = "SETENTA";
   $matdec[8] = "OCHENTA";
   $matdec[9] = "NOVENTA";
   $matsub[3]  = 'MILL';
   $matsub[5]  = 'BILL';
   $matsub[7]  = 'MILL';
   $matsub[9]  = 'TRILL';
   $matsub[11] = 'MILL';
   $matsub[13] = 'BILL';
   $matsub[15] = 'MILL';
   $matmil[4]  = 'MILLONES';
   $matmil[6]  = 'BILLONES';
   $matmil[7]  = 'DE BILLONES';
   $matmil[8]  = 'MILLONES DE BILLONES';
   $matmil[10] = 'TRILLONES';
   $matmil[11] = 'DE TRILLONES';
   $matmil[12] = 'MILLONES DE TRILLONES';
   $matmil[13] = 'DE TRILLONES';
   $matmil[14] = 'BILLONES DE TRILLONES';
   $matmil[15] = 'DE BILLONES DE TRILLONES';
   $matmil[16] = 'MILLONES DE BILLONES DE TRILLONES';

   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num);
   if ($num[0] == '-') {
      $neg = 'menos ';
      $num = substr($num, 1);
   }else
      $neg = '';
   while ($num[0] == '0') $num = substr($num, 1);
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
   $zeros = true;
   $punt = false;
   $ent = '';
   $fra = '';
   for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
         if ($punt) break;
         else{
            $punt = true;
            continue;
         }

      }elseif (! (strpos('0123456789', $n) === false)) {
         if ($punt) {
            if ($n != '0') $zeros = false;
            $fra .= $n;
         }else

            $ent .= $n;
      }else

         break;

   }
   $ent = '     ' . $ent;
   if ($dec and $fra and ! $zeros) {
      $fin = ' COMA';
      for ($n = 0; $n < strlen($fra); $n++) {
         if (($s = $fra[$n]) == '0')
            $fin .= ' CERO';
         elseif ($s == '1')
            $fin .= $fem ? ' UNA' : ' UN';
         else
            $fin .= ' ' . $matuni[$s];
      }
   }else
      $fin = '';
   if ((int)$ent === 0) return 'CERO ' . $fin;
   $tex = '';
   $sub = 0;
   $mils = 0;
   $neutro = false;
   while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
         $matuni[1] = 'UNA';
         $subcent = 'AS';
      }else{
         $matuni[1] = $neutro ? 'UN' : 'UNO';
         $subcent = 'OS';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      }elseif ($n2 < 21)
         $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {
         $n3 = $num[2];
         if ($n3 != 0) $t = 'I' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }else{
         $n3 = $num[2];
         if ($n3 != 0) $t = ' Y ' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }
      $n = $num[0];
      if ($n == 1) {
         $t = ' CIENTO' . $t; //CIENTO
      }elseif ($n == 5){
         $t = ' ' . $matunisub[$n] . 'IENT' . $subcent . $t;
      }elseif ($n != 0){
         $t = ' ' . $matunisub[$n] . 'CIENT' . $subcent . $t;
      }
      if ($sub == 1) {
      }elseif (! isset($matsub[$sub])) {
         if ($num == 1) {
            $t = ' MIL';
         }elseif ($num > 1){
            $t .= ' MIL';
         }
      }elseif ($num == 1) {
         $t .= ' ' . $matsub[$sub] . '?N';
      }elseif ($num > 1){
         $t .= ' ' . $matsub[$sub] . 'ONES';
      }
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
         $mils = 0;
      }
      $neutro = true;
      $tex = $t . $tex;
   }
   $tex = $neg . substr($tex, 1) . $fin;
   //Zi hack --> return ucfirst($tex);
   $end_num=ucfirst($tex).' PESOS '.$float[1].'/100 M.N.';
   return $end_num;
}


function fecha_impor($fecha){
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $num.' de '.$mes.' de '.$anno;
	}

if(isset($lst[0]['FecNac'])){
    $fechaNacimiento = new DateTime($lst[0]['FecNac']);
    $hoy = new DateTime(); // Fecha actual
    $edad = $hoy->diff($fechaNacimiento);
    $edad = $edad->y; // Retorna solo los años
    
} else {
    $edad = "XX";
}
	
?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;

}

td, th {
    border: 1px solid #dddddd;
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="28mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

<table style='margin-left: 40px;'>
    <tr>
        <td style="width: 150px; border: none;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%; margin-top: 18px;" ></td>
        <td style="width: 500px; text-align: center; border: none;">
            <p style='font-size: 25px;'><b>Instituto Universitario de Yucatán</b></p>
            <p style='margin-top: -25px; font-size: 9px;'> INCORPORADO AL COLEGIO DE BACHILLERES DE TABASCO <br>
                                         CON CLAVE DEL CENTRO DE TRABAJO: 27PCB0081E</p>
        </td>
    </tr>
</table>



	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	
	</page_footer>
	<div style="width: 700px; height: 100px; background: white; margin-top: -100px;">
	    
	</div>
	<br>
	<p style="text-align: justify; font-size: 16px; line-height: 25px;"><b>DR. AUDIEL HIPOLITO DURAN</b></p>
	<p style="text-align: justify; font-size: 16px; line-height: 25px; margin-top: -20px;">Rector del Instituto Universitario de Yucatán</p>
	<p style="text-align: justify; font-size: 16px; line-height: 25px; margin-top: -20px;">Centro Integral de Estudios Profesionales SC</p>
	<p style="text-align: justify; font-size: 16px; line-height: 25px; margin-top: 40px;">
	    <br>
	    Por medio de la presente, yo, <?php echo $lst[0]['Nombre']; ?> <?php echo $lst[0]['APaterno']; ?> <?php echo $lst[0]['AMaterno']; ?>, identificado con <b> credencial de elector número <?php echo $lst[0]['_elector']; ?>, </b> 
	    declaro bajo protesta de decir verdad que la relación contractual-civil que sostengo con, el Centro Integral de Estudios Profesionales SC por su nombre comercial Instituto Universitario de Yucatán (IUDY), 
	    no es mi fuente principal de ingresos; ya que poseo otra fuente principal de ingresos  con otra institución y/o empresa.
Esta declaración se realiza con el fin de aclarar mi situación contractual y evitar cualquier interpretación errónea respecto a mi vínculo con IUDY, reafirmando que mi relación contractual con dicha institución es parcial y no exclusiva.
Sin otro particular, quedo a su disposición para cualquier aclaración adicional.

</p>
	<br><br><br><br><br><br><br>
	<p style="text-align: center; font-size: 16px; line-height: 23px;"><b> ATENTAMENTE </b> </p><br><br><br><br><br><br><br>
	<p style="text-align: center; font-size: 16px; line-height: 23px;"><b> <br><br><?php echo $lst[0]['Nombre']; ?> <?php echo $lst[0]['APaterno']; ?> <?php echo $lst[0]['AMaterno']; ?> </b> </p>
	<?php if(($lst[0]['id_paquete']) && ($IdEstatus == 1)){ ?>
			        <p style='text-align: center;'><img src="../../assets/firma/<?php echo $lst[0]['id_paquete']; ?>" style="height: 95px; margin-top: -170px;"></p>
			    <?php } ?> 
<br><br><br><br><br><br><br><br><br><br><br><br>
<?php if($IdEstatus == 1) { ?>
<br><br><br><br><br><br><br> <?php } ?>
<div style="page-break-after: always;"></div>
	<p style="text-align: center; font-size: 20px; margin-top: -5px;"><b>Contrato de Prestación de Servicios Profesionales por<br>Honorarios por Tiempo Determinado</b></p>
	
	<p style="text-align: justify; font-size: 15px; line-height: 19px; margin-top: -10px;">Que celebran por una parte <b>el Centro Integral de Estudios Profesional S.C. por su nombre comercial Instituto Universitario de Yucatán,</b> que en adelante se le denominará <b>"EL INSTITUTO"</b> a través de su representante legal el <b>DR. AUDIEL HIPOLITO DURAN,</b> y por la otra parte el <b><?php echo $lst[0]['_prefijo']; ?>. <?php echo $lst[0]['Nombre']; ?> <?php echo $lst[0]['APaterno']; ?> <?php echo $lst[0]['AMaterno']; ?>,</b> quien en adelante se designará como <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”,</b> de conformidad con las declaraciones y cláusulas siguientes:</p>
    
    <p style="text-align: center; font-size: 16px; margin-top: -2px; "><b>DECLARACIONES:</b></p>
    
    <p style="text-align: justify; font-size: 16px; margin-top: -2px; line-height: 19px;">I.	<b>De “EL INSTITUTO”</b></p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.1	Que es una institución de educación privada, legalmente constituida mediante escritura pública número 6769, de fecha 26 de agosto de 2009, pasada ante la fe del licenciado Jorge Sánchez Brito, notario público número Uno del municipio de Jonuta, Tabasco.</p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.2	Se encuentra inscrito en el Sistema de Administración Tributaria (S.A.T.) con el Registro Federal de Contribuyentes <b>CIE090115D22.</b></p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.3	Que señala como domicilio legal, el ubicado en Carretera Federal Villahermosa-Teapa Km. 1, Colonia Plutarco Elías Calles, Centro, Tabasco, C.P. 86280.</p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.4	Que tiene por objeto impartir educación en el nivel medio superior, para formar estudiantes aptos para la aplicación y la generación de conocimientos científicos y tecnológicos, pertinentes a los proyectos de desarrollo social de la Región, del Estado y del país.</p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.5	Que su representante legal es el <b>Dr. AUDIEL HIPOLITO DURAN,</b> que cuenta con facultades amplias y suficientes para celebrar el presente contrato, según consta en escritura pública número Ocho mil quinientos noventa y tres, volumen CI de fecha 13 de Julio del año 2016 otorgado ante la Fé del Notario Público número 1 de la ciudad de Jonuta, Tabasco; Licenciado Jorge Sanchez Brito, mismas que a la fecha no le han sido revocadas ni limitadas en forma alguna.</p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.6	Que cuenta con los fondos y autorizaciones presupuestales para la realización de las actividades que se detallan en la cláusula correspondiente.</p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.7	Que requiere los servicios del <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”,</b> para la realización de las actividades motivo del presente contrato.</p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">I.8	Que este contrato se celebra de conformidad con lo dispuesto en los artículos <b>2918, 2919, 2920, 2921, 2922, 2923,2924, 2926 y 2927 del código civil para el Estado de Tabasco.</b></p>
    
    <p style="text-align: justify; font-size: 16px;">II.	<b>De “EL PROFESIONAL”</b></p>
    
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">II.1	Bajo protesta de decir verdad manifiesta llamarse <b><?php echo $lst[0]['Nombre']; ?> <?php echo $lst[0]['APaterno']; ?> <?php echo $lst[0]['AMaterno']; ?>, </b> con credencial de elector número <b><?php echo $lst[0]['_elector']; ?>, </b> de nacionalidad <b><?php echo $lst[0]['_nacionalidad']; ?>,</b> tener una edad de <b><?php echo $edad; ?> años, </b> haber nacido en <b><?php echo $lst[0]['_nacimiento']; ?>, </b> con escolaridad de <b><?php echo $lst[0]['_escolaridad']; ?>,</b> con una experiencia académico/docente comprobable, siendo su Clave Única de Registro de Población <b> <?php echo $lst[0]['Curp']; ?> </b> y Registro Federal de Contribuyentes <b> <?php echo $lst[0]['_rfc']; ?> </b>.</p>
    
    
    <div style="page-break-after: always;"></div>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">II.2	Que tiene capacidad técnica y jurídica, los conocimientos y experiencias profesionales requeridas por <b>"EL INSTITUTO"</b> para contratar y obligarse en la prestación de servicios que son objeto de este contrato y que dispone de los elementos propios y suficientes para cumplir con todas y cada una de las obligaciones fiscales, jurídicas o de cualquier otra naturaleza; autorizando para que le sea pagado de forma electrónica el monto que obtenga producto de la actividad que realizara derivada de este contrato. </p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">II.3	Que tiene su domicilio ubicado en <?php echo $lst[0]['_domicilio']; ?>. comprometiéndose a dar aviso por escrito a <b>“EL INSTITUTO”</b> en el momento en que por alguna circunstancia se vea en la necesidad de cambiar de residencia.</p>
    
    <p style="text-align: justify; font-size: 16px;">III.	<b>Ambas partes declaran:</b></p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">III.1	Que la contratación de <b> “EL PROFESIONAL” </b> se realiza sobre las bases establecidas por <b> "EL INSTITUTO" </b> para la impartición de clases al alumnado de <b> “EL INSTITUTO”. </b> </p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">III.2	Que, para normar los servicios, materia del presente contrato, <b> "EL INSTITUTO" </b> ha elaborado y <b> “EL PROFESIONAL” </b> ha aceptado y reconocido los términos de referencia en el presente contrato. </p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">III.3	Que <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> está inscrito en el registro federal de contribuyentes con el numero: <b><?php echo $lst[0]['_rfc']; ?></b>. </p>
    <p style="text-align: justify; font-size: 15px; margin-top: -2px; line-height: 19px;">III.4	Las partes manifiestan que es su voluntad celebrar el presente Contrato de Prestación de Servicios por Honorarios por Tiempo Determinado, al tenor de las siguientes: </p>
    <br>
    <p style="text-align: center; font-size: 16px; margin-top: 40px; "><b>CLAUSULAS</b></p>
    <br>
    <p style="text-align: justify; font-size: 15px; margin-top: 15px; line-height: 20px;"><b>PRIMERA.- </b> <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> se obliga a prestar a <b>"EL INSTITUTO"</b> sus servicios profesionales como <b>Docente</b> en el área de <b><?php echo $area; ?></b>, por un tiempo determinado, para dar cumplimiento al programa educativo señalado para la <b><?php echo $mat[0]['Nombre']; ?>,</b> para el primer periodo del <?php echo fecha_impor($mat[0]['FecIni']); ?> al <?php echo fecha_impor($mat[0]['FecFin']); ?> del <?php echo strtolower($mat[0]['Tipo']); ?> escolar <?php echo strtolower($mat[0]['Ciclo']); ?> conforme a los lineamientos, objetivos y condiciones señaladas en los términos de referencia a que alude la declaración conjunta III.2 </p>

    <p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;"><b>SEGUNDA.- </b> Los servicios profesionales como <b>Docente</b> que realizará <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> son de distinta naturaleza a los que presta un docente de tiempo completo, toda vez que estos últimos llevan a cabo una labor académica integral desarrollando distintas actividades académicas, de investigación, de proyectos, etceterá, que <b>"EL INSTITUTO"</b> le encomienda y que a diferencia del <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> requieren una continuidad en el tiempo; que no es el caso para el <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”.</b></p>
    
    <br><br>
    <!--<p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;"><b>SEGUNDA.- </b> Monto del contrato: <b> "EL INSTITUTO" </b> cubrirá a <b> “EL PROFESIONAL” </b> la cantidad de <b> $ <?php echo number_format($contrato[0]["Monto"], 2, '.', ','); ?> (<?php echo strtolower(numero_letras_esok($contrato[0]["Monto"], false, false)); ?>), </b><?php echo $contrato[0]['Texto']; ?>, menos la retención de impuesto que corresponda; conforme al Título IV, Capítulo I, Artículo 94, Inciso IV de la Ley del Impuestos Sobre la Renta vigente, como pago de sus servicios, de conformidad con el presente contrato, mediante transferencia bancaria a la cuenta número <b> <?php echo $lst[0]['_cuenta']; ?> </b> del banco <?php echo $lst[0]['_banco']; ?>. <b> “EL INSTITUTO” </b> se compromete a enviar por correo electrónico institucional que se le asigne a <b> “EL PROFESIONAL” </b> el recibo con el timbrado fiscal correspondiente al pago de sus servicios. A la vez <b> “EL PROFESIONAL” </b> se compromete a firmar de autorizado su pago por los servicios prestados a <b> “EL INSTITUTO”. </b> </p>-->
    
    <div style="page-break-after: always;"></div>
    <p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;"><b>TERCERA.- </b> Monto del contrato: <b>"EL INSTITUTO"</b> cubrirá a <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> la cantidad de <b>$ <?php echo number_format($contrato[0]["Monto"], 2, '.', ','); ?> (<?php echo strtolower(numero_letras_esok($contrato[0]["Monto"], false, false)); ?>),</b> <?php echo $contrato[0]['Texto']; ?>, menos la retención de impuesto que corresponda; conforme al Título IV, Capítulo I, Artículo 94, Inciso IV de la Ley del Impuestos Sobre la Renta vigente, como pago de sus servicios, de conformidad con el presente contrato, mediante transferencia bancaria a la cuenta número <b><?php echo $lst[0]['_cuenta']; ?></b> del banco <b><?php echo $lst[0]['_banco']; ?></b>. <b>“EL INSTITUTO”</b> se compromete a enviar por correo electrónico a <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> el recibo con el timbrado fiscal correspondiente al pago de sus servicios. A la vez <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> se compromete a firmar de autorizado su pago por los servicios prestados a <b>“EL INSTITUTO”.</b></p>
    
    <p style="text-align: justify; font-size: 16px; margin-top: 17px; line-height: 21px;"><b>CUARTA.- “EL INSTITUTO” </b>se compromete a establecer a <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> un correo electrónico, que le permita tener acceso al sistema que se utilizará para evaluar los resultados de sus actividades, así mismo será el medio para hacer llegar tanto los comunicados institucionales, asi como el recibo con el timbrado fiscal de pago de honorarios profesionales por los servicios prestados a <b>“EL INSTITUTO”.</b> </p>
    <p style="text-align: justify; font-size: 16px; margin-top: 17px; line-height: 21px;"><b>QUINTA.- </b> Plazo del contrato: el presente contrato es por tiempo determinado, tendrá una duración del <b><?php echo fecha_impor($mat[0]['FecIni']); ?> al <?php echo fecha_impor($mat[0]['FecFin']); ?>,</b> fecha en que vence el presente contrato. Si quedare algún trámite por realizar que derive del trabajo realizado en el periodo en mención se le pagara las horas utilizadas para el término de dicho trámite</p>
    
    <p style="text-align: justify; font-size: 16px; margin-top: 17px; line-height: 21px;"><b>SEXTA.- </b> Disponibilidad de la información: Ambas partes acuerdan que toda información proporcionada por <b>"EL INSTITUTO"</b> será confidencial por lo que <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> se obliga a utilizar la información recibida únicamente para los fines de este contrato y no divulgar o reproducirla en provecho propio o de terceros. El incumplimiento de esta obligación será causa de rescisión del contrato sin responsabilidad para <b>“EL INSTITUTO.”</b> y sancionado con el pago de los daños y perjuicios que se causen, independientemente de las obligaciones civiles o penales que pudiera ejercitarse.</p>
    
    <p style="text-align: justify; font-size: 16px; margin-top: 17px; line-height: 21px;"><b>SEPTIMA.- </b> Contrato intuito personae: En virtud de ser el presente contrato intuito personae, <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> no podrá ceder en ningún caso, ya sea en todo o en parte, los derechos y obligaciones derivados del mismo, para la realización de los trabajos a otras personas físicas o morales. <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> se obliga a realizar directamente los servicios profesionales materia del presente contrato por lo que no podrá subcontratar con terceros para el cumplimiento de sus obligaciones. </p>
    <p style="text-align: justify; font-size: 16px; margin-top: 17px; line-height: 21px;"><b>OCTAVA.- </b> Supervisión y vigilancia: <b>"EL INSTITUTO" </b> podrá supervisar en cualquier momento, el desarrollo y los avances del trabajo contratado con <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”.</b> </p>
    
    
    
    
    
    
    <div style="page-break-after: always;"></div>
    <p style="text-align: justify; font-size: 16px; margin-top: -10px; line-height: 21px;"><b>NOVENA.- </b> Obligaciones de: <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> se obliga a trabajar con eficiencia, honestidad, productividad, calidad y atender puntualmente las indicaciones que para el eficaz desempeño de los servicios contratados recibirá de "EL INSTITUTO", así como poner en su conocimiento cualquier hecho o circunstancia que pueda traducirse en beneficio, daño o perjuicio de los intereses de <b>"EL INSTITUTO".</b></p>
    
    <p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;"><b>DECIMA.- </b> Propiedad del trabajo: Las partes convienen en que los estudios objeto de este contrato, que desarrollará <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> en el cumplimiento de sus obligaciones son propiedad exclusiva de "EL INSTITUTO", por lo que el <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> no se reservará derecho alguno, propiedad intelectual, invención o patente que pudiera corresponderle por los trabajos; sin embargo, se hace responsable por la exactitud de sus análisis y la funcionalidad de sus propuestas.</p>
    
    
    
    <p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;"><b>DECIMA PRIMERA.- </b> Incumplimiento del contrato: en caso de que <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> no cumpla con cualquiera de las obligaciones contraídas en el presente contrato, responderá por los daños y perjuicios que por incumpliendo cause a <b>"EL INSTITUTO".</b></p>
    
    
        <p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;"><b>DECIMA SEGUNDA.- </b> Legislación: Ambas partes convienen en que lo no previsto en el presente contrato se ajustará a lo dispuesto en el Código Civil para el Estado de Tabasco y el Código de Procedimientos Civiles para el Estado de Tabasco, asimismo, para la interpretación y cumplimiento del contrato las partes se sujetan a la jurisdicción y competencia de los tribunales civiles del municipio de Centro, Tabasco, y por lo tanto, <b>“EL PRESTADOR DE SERVICIOS PROFESIONALES”</b> renuncia al fuero que por su domicilio o cualquier otra razón presente o futura tenga o pudiera llegar a tener.</p>
        
    
    <p style="text-align: justify; font-size: 16px; margin-top: 15px; line-height: 20px;">Enteradas las partes del contenido y efectos de este contrato manifiestan que no existe error, lesión, dolo, ni algún otro vicio del consentimiento que lo pudiera invalidar o modificar; perfectamente entendidos en todas y cada una de sus consecuencias jurídicas correspondientes y lo firman de conformidad, quedando en poder de "EL INSTITUTO" un ejemplar y de “EL PRESTADOR DE SERVICIOS PROFESIONALES” un ejemplar, en la Ciudad de Villahermosa Tabasco, el <?php echo obtFechConst($lst[0]['_fec_contrato']); ?>.</p>
    
    
    
    <table>
        <tr>
            <td style="width: 290px; text-align: center; font-size: 16px; border: none; "><b>Por el Instituto Universitario de Yucatán<br>RECTOR </b></td>
            <td style="width: 55px; border: none;"></td>
            <td style="width: 290px; text-align: center; font-size: 16px; border: none; "><br><b>EL PROFESIONAL</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 290px; text-align: center; font-size: 16px; height: 70px; border: none; ">
                <?php if($IdEstatus == 1){ ?>
                <p style='text-align: center;'><img src="../../assets/firma/firma_ok.jpg" style="height: 85px; margin-top: -30px;"></p>
                <?php } ?>
			</td>
            <td style="width: 55px; border: none;"></td>
            <td style="width: 290px; text-align: center; font-size: 16px; border: none; ">
                <?php if(($lst[0]['id_paquete']) && ($IdEstatus == 1)){ ?>
			        <p style='text-align: center;'><img src="../../assets/firma/<?php echo $lst[0]['id_paquete']; ?>" style="height: 65px; margin-top: -30px;"></p>
			    <?php } ?> 
            </td>
        </tr>
    </table>
    <table style="margin-top: -10px;">
        <tr>
            <td style="width: 290px; text-align: center; font-size: 16px; border: none; "><b>DR. AUDIEL HIPOLITO DURAN</b></td>
            <td style="width: 55px; border: none;"></td>
            <td style="width: 290px; text-align: center; font-size: 16px; border: none; "><b> <?php echo $lst[0]['_prefijo']; ?>. <?php echo $lst[0]['Nombre']; ?> <?php echo $lst[0]['APaterno']; ?> <?php echo $lst[0]['AMaterno']; ?> </b></td>
        </tr>
    </table>
    <br><br><br><br>
    <p style="text-align: center; font-size: 16px; margin-top: 50px;"><b>TESTIGO</b></p>
    <p style="text-align: center; font-size: 16px; margin-top: 60px;"><b>DRA. MARIA ENRIQUETA VELAZQUEZ BARREDO<br>DIRECTORA GENERAL ACADEMICA IUDY</b></p>
    <?php if($IdEstatus == 1){ ?>
    <p style='text-align: center;'><img src="../../assets/firma/1678914732895.png" style="height: 95px; margin-top: -150px;"></p>               
     <?php } ?>
    <div style="page-break-after: always;"></div>

    
    
</page>

<?php



?>


<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>



