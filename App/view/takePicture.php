
<div id="myPictures">
<h1 style="text-align: center">Mes photos</h1>
<?php
if($img) {
    foreach ($img as $value) {
        echo '<img class="trash" id="' . $value->id_pictures . '" src="src/img/poubelle.png" onclick="trash(id)"/>';
        echo '<img class="myPicture" src="src/imgsave/' . $value->src .'.'.$value->type.'"/>';
    }
}
?>
</div>
    <div style="float: left;width: 80%">
              <canvas id="canvas" width="320" height="240" style="display: none"></canvas>
              <video id="video" width="320" height="240" ></video>
              <br/>
              <button id="startbutton" >Prendre une photo</button>
              <button id="startGif">Prendre un gif</button>
<input type="file" name="files" id="files" onSubmit="return CheckUpload()">
              <br/><br/>

    <div id="gal">
        <img src="/src/img/Mario-PNG-Image.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/mustache.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/mickey.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/Cool.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/diable.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/tigre.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/angry.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/hamb.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/diable.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/corne.png"  class="draggableBox" onmousedown="return false">
        <img src="/src/img/aureole.png"  class="draggableBox" onmousedown="return false">

    </div>
</div>
<script>

</script>
