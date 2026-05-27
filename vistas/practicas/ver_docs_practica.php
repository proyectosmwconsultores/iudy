<?php
require('../../php/clases/class_practicas.php');
$practicas = new Class_practicas();
$IdDocs = $_POST['IdDocs'];
$sql_docs = $practicas->get_ver_docs_profesional_id($IdDocs);

?>

<div class="post">
  <div class="user-block">
    <img class="img-circle img-bordered-sm" src="assets/perfil/<?php echo $sql_docs[0]['Foto']; ?>" alt="User Image">
    <span class="username">
      <a href="#"><?php echo $sql_docs[0]['Nombre']; ?> <?php echo $sql_docs[0]['APaterno']; ?> <?php echo $sql_docs[0]['AMaterno']; ?></a>
      <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
    </span>
    <span class="description"><?php echo $sql_docs[0]['NomDocumento']; ?> - <?php echo $sql_docs[0]['FecCap']; ?></span>
  </div>
  <div class="row margin-bottom">
    <div class="col-sm-12">
      <p style="text-align: right;">
        <button onClick="window.open('<?php echo $sql_docs[0]['Ruta']; ?>','_blank')" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-briefcase"></i> Abrir nueva ventana</button>
      </p>
      <?php if ($sql_docs[0]['Formato'] == 'pdf') { ?>
        <embed src="<?php echo $sql_docs[0]['Ruta']; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
        <img src="" style="width: 100%;">
      <?php } else { ?>
        <img src="<?php echo $sql_docs[0]['Ruta']; ?>" style="width: 100%;">
      <?php } ?>
    </div>
  </div>
</div>