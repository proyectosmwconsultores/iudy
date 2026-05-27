

  <!-- <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"></h4>
  </div> -->
  <script type='text/javascript'>
$(function(){
    $(document).bind("contextmenu",function(e){
        return false;
    });
});
document.onkeydown=function (e){
        var currKey=0,evt=e||window.event;
        currKey=evt.keyCode||evt.which||evt.charCode;
        if (currKey == 123) {
            window.event.cancelBubble = true;
            window.event.returnValue = false;
        }
    }
</script>
  <div class="table-responsive">
    <video controls src="assets/docs/Videos/captura_planeacion.mp4" width="100%">
      <source src="assets/docs/Videos/captura_planeacion.mp4" type="video/mp4">
      <img src="imagen.png" alt="Video no soportado">
      Su navegador no soporta contenido multimedia.
    </video>

    <!-- <iframe width="100%" height="380" src="https://www.youtube.com/embed/Sy7eRao4oy0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
  </div>
