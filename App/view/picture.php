<div>
    <h2>Photo prise par <?php echo $usersPicture->pseudo ?></h2>
    <img src="/src/imgsave/<?php echo $picture->src.'.'.$picture->type; ?>"/>
    <div id="like">
        <span id="nbLike"><?php echo $picture->vote; ?></span> Like
        <span id="spanLike"><img id="likePng" src="/src/img/like.png" onclick="addLike()" /></span>
        <span id="errorLike">* Vous avez déjà liké cette image</span>
    </div>
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
    $user = $value->users();
    if ($user) {
?>
        <div class="com">
            <p class="titre-com">
                Commentaire de <span class="pseudo-com"><?php echo $user->pseudo; ?></span> - <span class="date-com">Le : <?php echo strftime('%d-%m-%Y à %H:%M', strtotime($value->time)); ?></span>
            </p>
            <p class="body-com"><?php echo nl2br($value->commentaires); ?></p>
        </div>
<?php
    }
}
?>
    </div>
</div>

<script>
function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function submitForm() {
    xhr = new XMLHttpRequest();
    xhr.open('POST', '/commentaires', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var donnee = "commentaire=" + document.querySelector('#com').value + "&id_picture=" + document.querySelector('#id_picture').value;
    xhr.onload = function () {
        if (xhr.status === 200) {
                var myArr = JSON.parse(this.responseText);
                if(!myArr.error) {
                    var newComm = document.createElement('span');
                    var showCom = document.getElementById('showCom');

                    showCom.insertBefore(newComm, showCom.childNodes[0]);
                    newComm.innerHTML = '<div><p class="titre-com">Commentaire de <span class="pseudo-com">' + myArr.user + '</span> - Maintenant </p><p class="body-com">' + nl2br(myArr.com.commentaires) + '</p></div>';
                }
                else {

                }
        }
    };
    xhr.send(donnee);
    return false;
}

function addLike()
{
    var spanLike = document.getElementById('spanLike');
    spanLike.innerHTML = '<img id="likePng" src="/src/img/like.png" onclick="error()"/>'
    xhr = new XMLHttpRequest();
    xhr.open('POST', '/like', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var donnee = "id_picture=" + document.querySelector('#id_picture').value;
    xhr.onload = function () {
        if (xhr.status === 200) {
                var myArr = JSON.parse(this.responseText);
                if(!myArr.error) {
                    var like = document.getElementById('nbLike');
                    like.innerHTML = myArr.vote;
                }
                else {
                    var error = document.getElementById('errorLike');
                    error.style.display = 'inline';
                }
        }
    };
    xhr.send(donnee);
}

function error()
{
    var error = document.getElementById('errorLike');
    error.style.display = 'inline';
}
</script>
