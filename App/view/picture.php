<div>
    <h2>Photo prise par <?php echo $usersPicture->pseudo ?></h2>
    <img src="/src/imgsave/<?php echo $picture->src; ?>.png"/>
    <div id="commentaires">
        <form id="formCom" onsubmit="return submitForm()">
            <textarea id="com">

            </textarea>
            <input type="hidden"  id="id_picture" value="<?php echo $picture->id_pictures ?>">
            <input type="submit" value="Commenter">
        </form>
    </div>
    <div id="showCom">
        <?php
            foreach ($commentaires as $key => $value) {
                $toto =  $value->users();
                if ($toto) {
                    echo $toto->pseudo . ' => ' .$value->commentaires . ' => '. $value->users_id.' => '.$value->pictures_id.' => '.$value->id_commentaires.'<br/>';
                }
            }
        ?>
    </div>
</div>

<script>
function submitForm() {
    xhr = new XMLHttpRequest();
        xhr.open('POST', '/commentaires', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var donnee = "commentaire=" + document.querySelector('#com').value + "&id_picture=" + document.querySelector('#id_picture').value;
        xhr.onload = function () {
            if (xhr.status === 200) {
                    var myArr = JSON.parse(this.responseText);
                    //console.log(myArr);
            }
        };
        xhr.send(donnee);
    return false;
}
</script>
