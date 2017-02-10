
<div id="myPictures">
<h1 style="text-align: center">Mes photos</h1>
<?php
foreach ($img as $value) {
    echo '<img src="src/imgsave/' . $value->src .'.png"/>';
}
?>
</div>
    <div style="float: left;width: 80%">
              <video id="video" width="320" height="240" autoplay loop></video>
              <canvas id="canvas" width="320" height="240" style="display: none"></canvas>
              <button id="startbutton">Prendre une photo</button>


    <div id="gal" style="height: 110px;">
            <div>
                <img src="/src/img/Mario-PNG-Image.png"  class="draggableBox" onmousedown="return false">
            </div>
            <div>
                <img src="/src/img/mustache.png"  class="draggableBox" onmousedown="return false">
            </div>
            <div>
                <img src="/src/img/mickey.png"  class="draggableBox" onmousedown="return false">
            </div>
            <div>
                <img src="/src/img/claque.gif"  class="draggableBox" onmousedown="return false">
            </div>
    </div>
</div>
<script>

</script>
