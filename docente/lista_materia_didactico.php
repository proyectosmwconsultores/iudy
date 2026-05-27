<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.php');
$t = new Trabajo();
$recursosA = $t->get_recursosApoyo($_POST["idToks"]);

?>

<div class="box">
  <div class="box-body">
    <table class="table table-hover table-striped">
      <tbody>
        <tr style="background: #5a284f; color: #fbeb00;">
          <td>Nombre del material didáctico</td>
          <td>Tipo</td>
          <td>Opciones</td>
        </tr>
        <?php
        $pi = 0;
        $por = 0;
        for ($tx = 0; $tx < sizeof($recursosA); $tx++) {
          $IdR = $recursosA[$tx]["IdBiblioteca"];
          $_tip = $recursosA[$tx]['Tipo'];
          $_tem = $recursosA[$tx]['IdTema'];
          $_icono = "<i class='fa fa-fw fa-file-text'></i>";
          if ($_tem == 10) {
            if ($_tip == 'link') {
              $_icono = "<i class='fa fa-fw fa-external-link'></i>";
            } else {
              $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>";
            }
          } elseif ($_tem == 7) {
            if ($_tip == 'youtube') {
              $_icono = "<i class='fa fa-fw fa-toggle-right'></i>";
            } else {
              $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>";
            }
          } elseif ($_tem == 8) {
            if ($_tip == 'tv') {
              $_icono = "<i class='fa fa-fw fa-toggle-right'></i>";
            } else {
              $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>";
            }
          } else {
            if ($_tip == 'pdf') {
              $_icono = "<i class='fa fa-fw fa-file-pdf-o'></i>";
            } elseif ($_tip == 'docx') {
              $_icono = "<i class='fa fa-fw fa-file-word-o'></i>";
            } elseif ($_tip == 'xlsx') {
              $_icono = "<i class='fa fa-fw fa-file-excel-o'></i>";
            }
          } ?>
          <tr id="<?php echo $IdR; ?>">
            <td>
              <a onclick="verBiblioteca(<?php echo $recursosA[$tx]['IdBiblioteca']; ?>)" href="javascript:void(0);"><?php echo $recursosA[$tx]['Nombre']; ?>
              </a>
              <div class="direct-chat-info clearfix" style="font-size: 10px;">
                <span class="direct-chat-name pull-right"><?php echo $recursosA[$tx]['NomActividad']; ?></span>
                <span class="direct-chat-timestamp pull-left"><?php echo $recursosA[$tx]['Titulo']; ?> <?php if ($recursosA[$tx]['Etiqueta_semana']) { echo ' / ' . $recursosA[$tx]['Etiqueta_semana']; } ?></span>
              </div>
            </td>
            <td style="padding-top: 15px; color: black;"><?php echo $recursosA[$tx]['Descripcion']; ?></td>
            <td style="padding-top: 15px; color: black;">
              <button onclick="verBiblioteca(<?php echo $recursosA[$tx]['IdBiblioteca']; ?>)" type="button" class="btn btn-primary" href="javascript:void(0);"><?php echo $_icono; ?></button>
              <?php if ($_SESSION['EstatusAsig'] == "A") { ?>
                <button onClick="val_recursoApoyo(<?php echo $IdR; ?>)" name="add" id="add" type="button" class="btn btn-default"><i class="fa fa-times"></i></button>
              <?php } ?>
            </td>
          </tr>
        <?php  } ?>
      </tbody>
    </table>


  </div>
</div>